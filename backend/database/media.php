<?php
/**
 * - JINZORA | Web-based Media Streamer -
 *
 * Jinzora is a Web-based media streamer, primarily desgined to stream MP3s
 * (but can be used for any media file that can stream from HTTP).
 * Jinzora can be integrated into a CMS site, run as a standalone application,
 * or integrated into any PHP website.  It is released under the GNU GPL.
 *
 * - Resources -
 * - Jinzora Author: Ross Carlson <ross@jasbone.com>
 * - Web: http://www.jinzora.org
 * - Documentation: http://www.jinzora.org/docs
 * - Support: http://www.jinzora.org/forum
 * - Downloads: http://www.jinzora.org/downloads
 * - License: GNU GPL <http://www.gnu.org/copyleft/gpl.html>
 *
 * - Contributors -
 * Please see http://www.jinzora.org/modules.php?op=modload&name=jz_whois&file=index
 *
 * - Code Purpose -
 * This is the media backend for the database adaptor.
 *
 * @since  05.10.04
 * @author Ross Carlson <ross@jinzora.org>
 */

// Most classes should be included from header.php

// The music root is $media_dir.
class jzMediaNode extends jzMediaNodeClass
{
    public $nodecount;

    public $leafcount;

    /**
     * Constructor wrapper for jzMediaNode.
     *
     * @author  Ben Dodson <bdodson@seas.upenn.edu>
     * @version 5/14/04
     * @since   5/13/04
     * @param mixed $par
     */

    public function __construct($par = [])
    {
        $this->nodecount = false;

        $this->leafcount = false;

        $this->_constructor($par);
    }

    public function updateCache()
    {
        global $sql_usr, $sql_type, $sql_pw, $sql_socket, $sql_db;

        $filename = 'backend/database/data/updated.lst';

        if (!$updated = unserialize(@file_get_contents($filename))) {
            $updated = [];
        }

        // connect to the database.

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $slashedNodePath = addslashes($nodePath);

        $level = $this->getLevel();

        // Mark my children as invalid if they exist in the DB.

        // Mark as valid only if/when they are found.

        $sql = "UPDATE nodes SET valid = 'false' ";

        $slash = (0 == $level) ? '' : '/';

        $sql .= "WHERE level > $level AND path LIKE '${slashedNodePath}${slash}%'";

        dbx_query($link, $sql) || die(dbx_error($link));

        $sql = "UPDATE tracks SET valid = 'false' ";

        $sql .= "WHERE path LIKE '${slashedNodePath}%'";

        dbx_query($link, $sql) || die(dbx_error($link));

        $this->updateCacheHelper($updated, $link);

        $handle = fopen($filename, w);

        fwrite($handle, serialize($updated));

        fclose($handle);
    }

    /**
     * Updates the cache using $this as the base node.
     *
     * @author  Ben Dodson <bdodson@seas.upenn.edu>
     * @version 5/13/04
     * @since   5/13/04
     * @param mixed $lastUpdated
     * @param mixed $link
     */

    public function updateCacheHelper(&$lastUpdated, &$link)
    {
        global $sql_usr, $sql_type, $sql_pw, $sql_socket, $sql_db, $audio_types, $video_types, $ext_graphic, $fav_image_name, $media_dir, $web_root, $root_dir, $track_num_seperator;

        // The database adaptor builds itself based on the filesystem.

        $music_dir = $web_root . $root_dir . $media_dir;

        $mySlashedName = addslashes($this->getName());

        $pathArray = $this->getPath();

        $nodePath = $this->getPath('String');

        $slashedNodePath = addslashes($nodePath); // SQL no likey the quotes.

        $level = $this->getLevel();

        // Now handle $this.

        $mdate = date('Y-m-d', filemtime($music_dir . '/' . $nodePath));

        $stamp = $lastUpdated[md5($nodePath)] ?? 0;

        $sql = 'INSERT INTO nodes(name,path,filepath,level,date_added) ';

        $sql .= "VALUES('$mySlashedName','$slashedNodePath','$slashedNodePath',$level,'$mdate')";

        // ADD MORE INFO TO DB.

        if (!dbx_query($link, $sql)) {
            // the node was already in the database.

            $sql = "UPDATE nodes SET valid = 'true' ";

            $sql .= "WHERE path LIKE '$slashedNodePath'";

            dbx_query($link, $sql);
        }

        // Now move inside $this's path.

        if (!($handle = opendir($music_dir . '/' . $nodePath))) {
            die("Could not access directory $music_dir" . '/' . (string)$nodePath);
        }

        // let's look for the best files to use while we are scanning this directory:

        $leafcount = 0;

        $nodecount = 0;

        $bestImage = '';

        $bestDescription = '';

        while ($file = readdir($handle)) {
            $nextPath = ('' == $nodePath) ? $file : $nodePath . '/' . $file;

            if ('.' == $file || '..' == $file) {
                continue;
            } elseif (is_dir($music_dir . '/' . $nextPath)) {
                $next = new self($nextPath);

                $next->updateCacheHelper($lastUpdated, $link);

                $nodecount++;
            } else {  // is a regular file.
                // That means check for media file (leaf),

                // or picture or text for $this.

                if (preg_match("/\.(txt)$/i", $file)) {
                    // TODO: GET THE CORRECT DESCRIPTION IN $bestDescription
                }

                if (preg_match("/\.($ext_graphic)$/i", $file) && !mb_stristr($file, '.thumb.')) {
                    // An image

                    if (preg_match("($fav_image_name)", $file)) {
                        $bestImage = $slashedNodePath . '/' . addslashes($file);
                    } elseif ('' == $bestImage) {
                        $bestImage = $slashedNodePath . '/' . addslashes($file);
                    }
                } elseif (preg_match("/\.($audio_types)$/i", $file)
                          || preg_match("/\.($video_types)$/i", $file)) {
                    // A media file

                    // add it as an element.

                    $leafcount++;

                    $mdate = date('Y-m-d', filemtime($music_dir . '/' . $nextPath));

                    // First, try putting me in the DB.

                    $slashedFileName = addslashes($file);

                    $slashedFilePath = $slashedNodePath . '/' . $slashedFileName;

                    $fullSlashedFilePath = addslashes($media_dir) . '/' . $slashedFilePath;

                    $sql = 'INSERT INTO nodes(name,path,filepath,level,date_added,leaf) ';

                    $sql .= "VALUES('$slashedFileName','$slashedFilePath','$slashedFilePath',$level+1,'$mdate','true') ";

                    dbx_query($link, $sql);

                    if ($stamp < date('U', filemtime($music_dir . '/' . $nextPath))) {
                        $getID3 = new getID3();

                        $fileInfo = $getID3->analyze($music_dir . '/' . $nextPath);

                        getid3_lib::CopyTagsToComments($fileInfo);

                        if (!empty($fileInfo['audio']['bitrate'])) {
                            $bitrate = (round($fileInfo['audio']['bitrate'] / 1000));
                        } else {
                            $bitrate = '-';
                        }

                        if (!empty($fileInfo['playtime_string'])) {
                            $length = $fileInfo['playtime_string'];
                        } else {
                            $length = '-';
                        }

                        if (!empty($fileInfo['filesize'])) {
                            $filesize = round($fileInfo['filesize'] / 1000000, 2);
                        } else {
                            $filesize = '-';
                        }

                        if (!empty($fileInfo['comments']['title'][0])) {
                            $name = addslashes($fileInfo['comments']['title'][0]);
                        } else {
                            $name = '-';
                        }

                        if (!empty($fileInfo['comments']['artist'][0])) {
                            $artist = addslashes($fileInfo['comments']['artist'][0]);
                        }

                        if (!empty($fileInfo['comments']['album'][0])) {
                            $album = addslashes($fileInfo['comments']['album'][0]);
                        }

                        if (!empty($fileInfo['comments']['year'][0])) {
                            $year = addslashes($fileInfo['comments']['year'][0]);
                        } else {
                            $year = '-';
                        }

                        if (!empty($fileInfo['comments']['track'][0])) {
                            $track = $fileInfo['comments']['track'][0];
                        } else {
                            $track = '-';
                        }

                        if (!empty($fileInfo['comments']['genre'][0])) {
                            $genre = addslashes($fileInfo['comments']['genre'][0]);
                        }

                        if (!empty($fileInfo['audio']['sample_rate'])) {
                            $frequency = round($fileInfo['audio']['sample_rate'] / 1000, 1);
                        } else {
                            $frequency = '-';
                        }

                        if (!empty($fileInfo['comments']['comment'][0])) {
                            $description = addslashes($fileInfo['comments']['comment'][0]);
                        } else {
                            $description = '';
                        }

                        if (!empty($fileInfo['tags']['id3v2']['unsynchronised lyric'][0])) {
                            $lyrics = addslashes($fileInfo['tags']['id3v2']['unsynchronised lyric'][0]);
                        } else {
                            $lyrics = '';
                        }

                        // Now let's get the extension

                        $fileInfo = pathinfo($music_dir . '/' . $nextPath);

                        $fileExt = $fileInfo['extension'];

                        // Now let's see if we need to manually create the name

                        if ('-' == $name or 'Tconv' == $name) {
                            $name = str_replace('.' . $fileExt, '', $slashedFileName);

                            // Let's see if this is a .fake file or not

                            if (mb_stristr($name, 'fake')) {
                                $name = str_replace('.fake', '', $name);
                            }
                        }

                        // Now let's see if the name needs the file number stripped off of it (thus giving us the track number)

                        if (is_numeric(mb_substr($name, 0, 2))) {
                            // Ok, we found numbers so let's fix it up!

                            // Now let's figure out the new track names...

                            $track = mb_substr($name, 0, 2);

                            $name = mb_substr($name, 2, mb_strlen($name));

                            $trackSepArray = explode('|', $track_num_seperator);

                            for ($i = 0, $iMax = count($trackSepArray); $i < $iMax; $i++) {
                                if (mb_stristr($name, $trackSepArray[$i])) {
                                    // Now let's strip from the beginning up to and past the seperator

                                    $name = mb_substr($name, mb_strpos($name, $trackSepArray[$i]) + mb_strlen($trackSepArray[$i]), 999999);
                                }
                            }
                        } else {
                            if ('-' == $track && is_numeric(mb_substr($file, 0, 2))) {
                                $track = mb_substr($file, 0, 2);
                            }
                        }

                        // Now let's make sure the name wasn't empty and if so just use the full file name...

                        if ('' == $name) {
                            $name = $slashedFileName;
                        }

                        // Now let's see if there is a description file...

                        $desc_file = str_replace('.' . $fileExt, '', $music_dir . '/' . $nextPath) . '.txt';

                        $long_description = '';

                        if (is_file($desc_file) and 0 != filesize($desc_file)) {
                            // Ok, let's read the description file

                            $handle2 = fopen($desc_file, 'rb');

                            $long_description = addslashes(fread($handle2, filesize($desc_file)));

                            fclose($handle2);
                        }

                        // Now let's see if there is a thumbnail for this track

                        $thumb_file = addslashes(searchThumbnail($music_dir . '/' . $nextPath));

                        $sql = "INSERT INTO tracks(path,trackname,bitrate,filesize,frequency,length,lyrics,genre,artist,album,year,number,extension)
							           VALUES('$slashedFilePath','$name','$bitrate','$filesize','$frequency','$length','$lyrics','$genre','$artist','$album','$year','$track','$fileExt')";

                        $updatesql = "UPDATE tracks SET valid = 'true',
											trackname = '$name',
											bitrate = '$bitrate',
											filesize = '$filesize',
											frequency = '$frequency',
											length = '$length',
											lyrics = '$lyrics',
											year = '$year',
											genre = '$genre',
											artist = '$artist',
											album = '$album',
											number = '$track',
											extension = '$fileExt'
											WHERE path LIKE '$slashedFilePath'";

                        dbx_query($link, $sql) || dbx_query($link, $updatesql);
                    } else {
                        $sql = "UPDATE tracks SET valid = 'true' WHERE path LIKE '$slashedFilePath'";

                        dbx_query($link, $sql);
                    }

                    // last thing: add thumb and/or descriptions.

                    $sql = "valid = 'true'";

                    if (false === !$thumb_file) {
                        $sql .= ", main_art = '$thumb_file'";
                    }

                    if ('' != $description) {
                        $sql .= ", descr = '$description'";
                    }

                    if ('' != $long_description) {
                        $sql = ", longdesc = '$long_description'";
                    }

                    dbx_query($link, "UPDATE nodes SET $sql WHERE path LIKE '$slashedFilePath'");
                }
            }
        }

        // Back to $this node:

        // add new info to $this's database entry.

        $lastUpdated[md5($nodePath)] = date('U');

        $sqlUpdate = "nodecount = $nodecount, leafcount = $leafcount";

        if ('' != $bestImage) {
            $bestImage = addslashes($root_dir . $media_dir) . '/' . $bestImage;

            $sqlUpdate .= ", main_art = '$bestImage'";
        }

        if ('' != $bestDescription) {
            // similar code here.
        }

        $sql = "UPDATE nodes SET $sqlUpdate WHERE path LIKE '$slashedNodePath'";

        dbx_query($link, $sql) || die(dbx_error($link));

        $slash = (0 == $level) ? '' : '/';

        // all done; remove everything beyond $this's path that is still not valid.

        $sql = 'DELETE FROM nodes WHERE ';

        $sql .= "level > $level AND path LIKE '${slashedNodePath}${slash}%' AND valid = 'false'";

        dbx_query($link, $sql);

        $sql = 'DELETE FROM tracks WHERE ';

        $sql .= "path LIKE '${slashedNodePath}${slash}%' AND valid = 'false'";

        dbx_query($link, $sql);
    }

    /**
     * Counts the number of subnodes $distance steps down.
     * $distance = -1 does a recursive count.
     *
     * @param mixed $type
     * @param mixed $distance
     * @return false|mixed
     * @return false|mixed
     * @author  Ben Dodson <bdodson@seas.upenn.edu>
     * @version 5/14/2004
     * @since   5/14/2004
     */

    public function getSubNodeCount($type = 'both', $distance = false)
    {
        global $sql_type, $sql_pw, $sql_socket, $sql_db, $sql_usr;

        if (false === $distance) {
            $distance = $this->getNaturalDepth();
        }

        // can we do it quickly?

        if (1 == $distance && false !== $this->nodecount) {
            if ('nodes' == $type) {
                return $this->nodecount;
            }

            if ('leaves' == $type) {
                return $this->leafcount;
            }

            return $this->nodecount + $this->leafcount;
        }

        if (1 == $distance) {
            if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
                die('could not connect to database.');
            }

            $pathArray = $this->getPath();

            $level = $this->getLevel();

            $pathString = addslashes($this->getPath('String'));

            $sql = "SELECT nodecount,leafcount FROM nodes WHERE path LIKE '${pathString}'";

            $results = dbx_query($link, $sql);

            if ('nodes' == $type) {
                return $results[0][nodecount];
            }

            if ('leaves' == $type) {
                return $results[0][leafcount];
            }
  

            return $results[0][leafcount] + $results[0][nodecount];
        }

        $pathArray = $this->getPath();

        $level = $this->getLevel();

        $pathString = addslashes($this->getPath('String'));

        if ('' != $pathString) {
            $pathString .= '/';
        }

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        // speed up the common case of counting all tracks.

        if (-1 == $distance && $type = 'leaves' && 0 == $this->getLevel()) {
            $sql = 'SELECT COUNT(*) FROM tracks';

            $results = dbx_query($link, $sql);

            return $results->data[0][0];
        }

        if (-1 == $distance) {
            $op = '>';
        } else {
            $op = '=';

            $level += $distance;
        }

        $lim = '';

        if ('leaves' == $type) {
            $lim = "AND leaf = 'true'";
        } elseif ('nodes' == $type) {
            $lim = "AND leaf = 'false'";
        }

        $sql = "SELECT COUNT(*) FROM nodes WHERE level $op $level $lim AND path LIKE '${pathString}%'";

        $results = dbx_query($link, $sql);

        return $results->data[0][0];
    }

    /**
     * Returns the subnodes as an array.
     *
     * @param mixed $type
     * @param mixed $distance
     * @param mixed $random
     * @param mixed $limit
     * @return array
     * @return array
     * @since   5/14/2004
     * @author  Ben Dodson <bdodson@seas.upenn.edu>
     * @version 5/15/2004
     */

    public function getSubNodes($type = 'nodes', $distance = false, $random = false, $limit = 0)
    {
        global $sql_type, $sql_pw, $sql_socket, $sql_db, $sql_usr;

        if (false === $distance) {
            $distance = $this->getNaturalDepth();
        }

        $pathArray = $this->getPath();

        $level = $this->getLevel();

        $pathString = addslashes($this->getPath('String'));

        if ('' != $pathString) {
            $pathString .= '/';
        }

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        if ($distance < 0) {
            $op = '>';
        } else {
            $op = '=';

            $level += $distance;
        }

        $sql = "SELECT path,leaf,nodecount,leafcount FROM nodes WHERE level $op $level
				AND path LIKE '${pathString}%'";

        if ('leaves' == $type) {
            $sql .= " AND leaf = 'true'";
        } elseif ('nodes' == $type) {
            $sql .= " AND leaf = 'false'";
        }

        if ($random) {
            $sql .= ' ORDER BY rand()';
        } else {
            $sql .= ' ORDER BY name,path';
        }

        if ($limit > 0) {
            $sql .= " LIMIT $limit";
        }

        $results = dbx_query($link, $sql);

        // have $results.

        $arr = [];

        for ($i = 0; $i < $results->rows; $i++) {
            if ('false' == $results->data[$i][leaf]) {
                $me = new self(stripslashes($results->data[$i][path]));

                $me->leafcount = $results->data[$i][leafcount];

                $me->nodecount = $results->data[$i][nodecount];

                $arr[] = $me;
            } else {
                $arr[] = new jzMediaTrack(stripslashes($results->data[$i][path]));
            }
        }

        return $arr;
    }

    /**
     * Alphabetical listing of a node.
     *
     * @param mixed $letter
     * @param mixed $distance
     * @return array
     * @return array
     * @author  Ben Dodson <bdodson@seas.upenn.edu>
     * @version 5/14/2004
     * @since   5/14/2004
     */

    public function getAlphabetical($letter, $distance = false)
    {
        global $sql_type, $sql_pw, $sql_socket, $sql_db, $sql_usr;

        if (false === $distance) {
            $distance = $this->getNaturalDepth();
        }

        $pathString = addslashes($this->getPath('String'));

        if ('' != $pathString) {
            $pathString .= '/';
        }

        $level = $this->getLevel();

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        if (-1 == $distance) {
            // recursive

            $op = '>';
        } else {
            $level += $distance;

            $op = '=';
        }

        if ('#' == $letter) {
            $results = dbx_query(
                $link,
                "SELECT path,leaf FROM nodes 
				  WHERE level $op $level AND path LIKE '${pathString}%'
				  AND name REGEXP '^[0-9]'"
            );

        //TODO: add special characters (IE, anything not a-zA-Z)
        } elseif ('*' == $letter) {
            $results = dbx_query(
                $link,
                "SELECT path,leaf FROM nodes 
				  WHERE level $op $level AND path LIKE '${pathString}%'"
            );
        } else {
            $results = dbx_query(
                $link,
                "SELECT path,leaf FROM nodes 
				  WHERE level $op $level AND path LIKE '${pathString}%'
				  AND name LIKE '${letter}%' ORDER BY name"
            );
        }

        // have $results.

        $arr = [];

        for ($i = 0; $i < $results->rows; $i++) {
            if ('false' == $results->data[$i][leaf]) {
                $arr[] = new self(stripslashes($results->data[$i][path]));
            } else {
                $arr[] = new jzMediaTrack(stripslashes($results->data[$i][path]));
            }
        }

        return $arr;
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Do NOT modify the below: modify overrides.php instead,        *
     * change to jinzora/backend, and run `php global_include.php`   *
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

    // begin global_include: overrides.php

    /* * * * * * * * * * * * * * * * * * *
     *            Overrides              *
     * * * * * * * * * * * * * * * * * * */

    /**
     * Returns the date the node was added.
     *
     * @author  Ben Dodson <bdodson@seas.upenn.edu>
     * @version 5/14/2004
     * @since   5/14/2004
     */

    public function getDateAdded()
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        $results = dbx_query($link, "SELECT date_added FROM nodes WHERE path = '$path'");

        return $results->data[0][date_added];
    }

    /**
     * Returns the number of times the node has been played.
     *
     * @author  Ben Dodson <bdodson@seas.upenn.edu>
     * @version 5/14/2004
     * @since   5/14/2004
     */

    public function getPlayCount()
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        $results = dbx_query($link, "SELECT playcount FROM nodes WHERE path = '$path'");

        return $results->data[0][playcount];
    }

    /**
     * Increments the node's playcount, as well
     * as the playcount of its parents.
     *
     * @author  Ben Dodson <bdodson@seas.upenn.edu>
     * @version 5/14/2004
     * @since   5/14/2004
     */

    public function increasePlayCount()
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        dbx_query($link, "UPDATE nodes SET playcount = playcount+1 WHERE path = '$path'");

        if (count($ar = $this->getPath()) > 0) {
            array_pop($ar);

            $next = new self($ar);

            $next->increasePlayCount();
        }
    }

    /**
     * Sets the elements playcount.
     *
     * @author  Ben Dodson <bdodson@seas.upenn.edu>
     * @version 5/14/2004
     * @since   5/14/2004
     * @param mixed $n
     */

    public function setPlayCount($n)
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        dbx_query($link, "UPDATE nodes SET playcount = $n WHERE path = '$path'");
    }

    /**
     * Returns the main art for the node.
     *
     * @author  Ben Dodson <bdodson@seas.upenn.edu>
     * @version 5/14/04
     * @since   5/14/04
     */

    public function getMainArt()
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        $results = dbx_query($link, "SELECT main_art FROM nodes WHERE path = '$path'");

        return stripslashes($results->data[0][main_art]);
    }

    /**
     * Sets the node's main art
     *
     * @author  Ben Dodson
     * @version 6/7/04
     * @since   6/7/04
     * @param mixed $image
     */

    public function addMainArt($image)
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        $image = addslashes($image);

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        $results = dbx_query($link, "UPDATE nodes SET main_art = '$image' WHERE path = '$path'");
    }

    /**
     * Returns the miscellaneous artwork attached to the node.
     *
     * @author
     * @version
     * @since
     */

    public function getRandomArt()
    {
    }

    /**
     * Adds misc. artwork to the node.
     *
     * @author
     * @version
     * @since
     * @param mixed $image
     */

    public function addRandomArt($image)
    {
    }

    /**
     * Returns a brief description for the node.
     *
     * @author  Ben Dodson
     * @version 5/21/04
     * @since   5/21/04
     */

    public function getShortDescripiton()
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        $results = dbx_query($link, "SELECT descr FROM nodes WHERE path = '$path'");

        return stripslashes($results->data[0][descr]);
    }

    /**
     * Adds a brief description.
     *
     * @author  Ben Dodson
     * @version 5/21/04
     * @since   5/21/04
     * @param mixed $text
     */

    public function addShortDescription($text)
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        $text = addslashes($text);

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        $results = dbx_query(
            $link,
            "UPDATE nodes SET descr = '$text'
                                                     WHERE path = '$path'"
        );
    }

    /**
     * Returns the description of the node.
     *
     * @author  Ben Dodson
     * @version 5/21/04
     * @since   5/21/04
     */

    public function getDescription()
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        $results = dbx_query($link, "SELECT longdesc FROM nodes WHERE path = '$path'");

        return stripslashes($results->data[0][longdesc]);
    }

    /**
     * Adds a description.
     *
     * @author  Ben Dodson
     * @version 5/21/04
     * @since   5/21/04
     * @param mixed $text
     */

    public function addDescription($text)
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        $text = addslashes($text);

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        $results = dbx_query(
            $link,
            "UPDATE nodes SET longdesc = '$text'
                                                     WHERE path = '$path'"
        );
    }

    /**
     * Gets the overall rating for the node.
     *
     * @author  Ben Dodson
     * @version 6/7/04
     * @since   6//704
     */

    public function getRating()
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        $results = dbx_query($link, "SELECT rating,rating_count FROM nodes WHERE path = '$path'");

        return (0 == $results->data[0]['rating_count']) ? 0 : $results->data[0]['rating'] / $results->data[0]['rating_count'];
    }

    /**
     * Add a rating for the node.
     *
     * @author
     * @version
     * @since
     * @param mixed $rating
     */

    public function addRating($rating)
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        $results = dbx_query(
            $link,
            "UPDATE nodes SET rating=rating+$rating,
                                                     rating_count=rating_count+1 WHERE path = '$path'"
        );

        // should this update parents too?
    }

    /**
     * Returns the node's discussion
     *
     * @author  Ben Dodson
     * @version 6/7/04
     * @since   6/7/04
     */

    public function getDiscussion()
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        $results = dbx_query($link, "SELECT * FROM discussions WHERE path LIKE '$path' ORDER BY my_id");

        $discussion = [];

        $i = 0;

        foreach ($results->data as $key => $data) {
            $discussion[$i]['user'] = stripslashes($data['user']);

            $discussion[$i]['comment'] = stripslashes($data['comment']);

            $i++;
        }

        return $discussion;
    }

    /**
     * Adds a blurb to the node's discussion
     *
     * @author  Ben Dodson <bdodson@seas.upenn.edu>
     * @version 5/15/04
     * @since   5/15/04
     * @param mixed $text
     * @param mixed $username
     */

    public function addDiscussion($text, $username)
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        $text = addslashes($text);

        $username = addslashes($username);

        dbx_query(
            $link,
            "INSERT INTO discussions(path,user,comment)
                     	                  VALUES('$path','$username','$text')"
        )
        || die(dbx_error($link));
    }

    /**
     * Returns the year of the element;
     * if it is a leaf, returns the info from getMeta[year]
     * else, returns the average of the result from its children.
     * Entry is '-' for no year.
     *
     * @author  Ben Dodson
     * @version 5/21/04
     * @since   5/21/04
     */

    public function getYear()
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        if ($this->isLeaf()) {
            $results = dbx_query($link, "SELECT year FROM tracks WHERE path = '$path'");

            return $results->data[0][year];
        }  

        $results = dbx_query($link, "SELECT year FROM tracks WHERE path LIKE '${path}%' AND year != '-'");

        $sum = 0;

        $total = 0;

        foreach ($results->data as $row) {
            if (is_numeric($row[year])) {
                $sum += $row[year];

                $total++;
            }
        }

        if (0 == $total) {
            return '-';
        }

        return round($sum / $total);
    }

    // end global_include: overrides.php
}

class jzMediaTrack extends jzMediaTrackClass
{
    /**
     * Constructor wrapper for jzMediaTrack.
     *
     * @author  Ben Dodson
     * @version 5/11/04
     * @since   5/11/04
     * @param mixed $par
     */

    public function __construct($par = [])
    {
        $this->_constructor($par);
    }

    /**
     * Returns the track's name (not filename)
     *
     * @author  Ben Dodson
     * @version 5/21/04
     * @since   5/21/04
     */

    public function getName()
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        $results = dbx_query($link, "SELECT trackname FROM tracks WHERE path LIKE '$path'");

        return stripslashes($results->data[0][trackname]);
    }

    /**
     * Returns the track's complete filename (excluding $media_dir)
     *
     * @author  Ben Dodson
     * @version 5/21/04
     * @since   5/21/04
     */

    public function getFileName()
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        $results = dbx_query($link, "SELECT filepath FROM nodes WHERE path LIKE '$path'");

        return stripslashes($results->data[0][filepath]);
    }

    /**
     * Returns the track's metadata as an array with the following keys:
     *
     * title
     * bitrate
     * frequency
     * filename [excluding path]
     * size
     * year
     * comment
     * length
     * number
     * genre
     * artist
     * album
     * lyrics
     * type [extension]
     *
     * These are taken mostly from the ID3.
     *
     * @param mixed $mode
     * @return array
     * @return array
     * @since
     * @author
     * @version
     */

    public function getMeta($mode = 'cache')
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        if ('cache' == $mode) {
            $meta = [];

            if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
                die('could not connect to database.');
            }

            $path = addslashes($this->getPath('String'));

            $results = dbx_query(
                $link,
                "SELECT tracks.*,nodes.name,nodes.desc FROM tracks,nodes 
							WHERE nodes.path = '$path' AND nodes.path = tracks.path"
            );

            print_r($results);

            $meta['title'] = stripslashes($results->data[0]['trackname']);

            $meta['bitrate'] = stripslashes($results->data[0]['bitrate']);

            $meta['frequency'] = stripslashes($results->data[0]['frequency']);

            $meta['filename'] = stripslashes($results->data[0]['name']);

            $meta['size'] = stripslashes($results->data[0]['filesize']);

            $meta['year'] = stripslashes($results->data[0]['year']);

            $meta['comment'] = stripslashes($results->data[0]['desc']);

            $meta['length'] = stripslashes($results->data[0]['length']);

            $meta['number'] = stripslashes($results->data[0]['number']);

            $meta['genre'] = stripslashes($results->data[0]['genre']);

            $meta['artist'] = stripslashes($results->data[0]['artist']);

            $meta['album'] = stripslashes($results->data[0]['album']);

            $meta['lyrics'] = stripslashes($results->data[0]['lyrics']);

            $meta['type'] = stripslashes($results->data[0]['extension']);

            if ('' == $meta['comment']) {
                $meta['comment'] = '-';
            }

            return $meta;
        }
  

        return parent::getMeta($mode);
    }

    /**
     * Returns the track's lyrics.
     *
     * @author  Ben Dodson
     * @version 5/21/04
     * @since   5/21/04
     */

    public function getLyrics()
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        $results = dbx_query($link, "SELECT lyrics FROM tracks WHERE path LIKE '$path'");

        return stripslashes($results->data[0][lyrics]);
    }

    /**
     * Adds lyrics for the track.
     * @author
     * @version
     * @since
     * @param mixed $text
     */

    public function addLyrics($text)
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        $text = addslashes($text);

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        $results = dbx_query(
            $link,
            "UPDATE tracks SET lyrics = '$text'
                                                     WHERE path LIKE '$path'"
        );
    }

    //////////////////////////////////////

    // begin global_include: overrides.php

    /* * * * * * * * * * * * * * * * * * *
     *            Overrides              *
     * * * * * * * * * * * * * * * * * * */

    /**
     * Returns the date the node was added.
     *
     * @author  Ben Dodson <bdodson@seas.upenn.edu>
     * @version 5/14/2004
     * @since   5/14/2004
     */

    public function getDateAdded()
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        $results = dbx_query($link, "SELECT date_added FROM nodes WHERE path = '$path'");

        return $results->data[0][date_added];
    }

    /**
     * Returns the number of times the node has been played.
     *
     * @author  Ben Dodson <bdodson@seas.upenn.edu>
     * @version 5/14/2004
     * @since   5/14/2004
     */

    public function getPlayCount()
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        $results = dbx_query($link, "SELECT playcount FROM nodes WHERE path = '$path'");

        return $results->data[0][playcount];
    }

    /**
     * Increments the node's playcount, as well
     * as the playcount of its parents.
     *
     * @author  Ben Dodson <bdodson@seas.upenn.edu>
     * @version 5/14/2004
     * @since   5/14/2004
     */

    public function increasePlayCount()
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        dbx_query($link, "UPDATE nodes SET playcount = playcount+1 WHERE path = '$path'");

        if (count($ar = $this->getPath()) > 0) {
            array_pop($ar);

            $next = new jzMediaNode($ar);

            $next->increasePlayCount();
        }
    }

    /**
     * Sets the elements playcount.
     *
     * @author  Ben Dodson <bdodson@seas.upenn.edu>
     * @version 5/14/2004
     * @since   5/14/2004
     * @param mixed $n
     */

    public function setPlayCount($n)
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        dbx_query($link, "UPDATE nodes SET playcount = $n WHERE path = '$path'");
    }

    /**
     * Returns the main art for the node.
     *
     * @author  Ben Dodson <bdodson@seas.upenn.edu>
     * @version 5/14/04
     * @since   5/14/04
     */

    public function getMainArt()
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        $results = dbx_query($link, "SELECT main_art FROM nodes WHERE path = '$path'");

        return stripslashes($results->data[0][main_art]);
    }

    /**
     * Sets the node's main art
     *
     * @author  Ben Dodson
     * @version 6/7/04
     * @since   6/7/04
     * @param mixed $image
     */

    public function addMainArt($image)
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        $image = addslashes($image);

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        $results = dbx_query($link, "UPDATE nodes SET main_art = '$image' WHERE path = '$path'");
    }

    /**
     * Returns the miscellaneous artwork attached to the node.
     *
     * @author
     * @version
     * @since
     */

    public function getRandomArt()
    {
    }

    /**
     * Adds misc. artwork to the node.
     *
     * @author
     * @version
     * @since
     * @param mixed $image
     */

    public function addRandomArt($image)
    {
    }

    /**
     * Returns a brief description for the node.
     *
     * @author  Ben Dodson
     * @version 5/21/04
     * @since   5/21/04
     */

    public function getShortDescripiton()
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        $results = dbx_query($link, "SELECT descr FROM nodes WHERE path = '$path'");

        return stripslashes($results->data[0][descr]);
    }

    /**
     * Adds a brief description.
     *
     * @author  Ben Dodson
     * @version 5/21/04
     * @since   5/21/04
     * @param mixed $text
     */

    public function addShortDescription($text)
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        $text = addslashes($text);

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        $results = dbx_query(
            $link,
            "UPDATE nodes SET descr = '$text'
                                                     WHERE path = '$path'"
        );
    }

    /**
     * Returns the description of the node.
     *
     * @author  Ben Dodson
     * @version 5/21/04
     * @since   5/21/04
     */

    public function getDescription()
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        $results = dbx_query($link, "SELECT longdesc FROM nodes WHERE path = '$path'");

        return stripslashes($results->data[0][longdesc]);
    }

    /**
     * Adds a description.
     *
     * @author  Ben Dodson
     * @version 5/21/04
     * @since   5/21/04
     * @param mixed $text
     */

    public function addDescription($text)
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        $text = addslashes($text);

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        $results = dbx_query(
            $link,
            "UPDATE nodes SET longdesc = '$text'
                                                     WHERE path = '$path'"
        );
    }

    /**
     * Gets the overall rating for the node.
     *
     * @author  Ben Dodson
     * @version 6/7/04
     * @since   6//704
     */

    public function getRating()
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        $results = dbx_query($link, "SELECT rating,rating_count FROM nodes WHERE path = '$path'");

        return (0 == $results->data[0]['rating_count']) ? 0 : $results->data[0]['rating'] / $results->data[0]['rating_count'];
    }

    /**
     * Add a rating for the node.
     *
     * @author
     * @version
     * @since
     * @param mixed $rating
     */

    public function addRating($rating)
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        $results = dbx_query(
            $link,
            "UPDATE nodes SET rating=rating+$rating,
                                                     rating_count=rating_count+1 WHERE path = '$path'"
        );

        // should this update parents too?
    }

    /**
     * Returns the node's discussion
     *
     * @author  Ben Dodson
     * @version 6/7/04
     * @since   6/7/04
     */

    public function getDiscussion()
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        $results = dbx_query($link, "SELECT * FROM discussions WHERE path LIKE '$path' ORDER BY my_id");

        $discussion = [];

        $i = 0;

        foreach ($results->data as $key => $data) {
            $discussion[$i]['user'] = stripslashes($data['user']);

            $discussion[$i]['comment'] = stripslashes($data['comment']);

            $i++;
        }

        return $discussion;
    }

    /**
     * Adds a blurb to the node's discussion
     *
     * @author  Ben Dodson <bdodson@seas.upenn.edu>
     * @version 5/15/04
     * @since   5/15/04
     * @param mixed $text
     * @param mixed $username
     */

    public function addDiscussion($text, $username)
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        $text = addslashes($text);

        $username = addslashes($username);

        dbx_query(
            $link,
            "INSERT INTO discussions(path,user,comment)
                     	                  VALUES('$path','$username','$text')"
        )
        || die(dbx_error($link));
    }

    /**
     * Returns the year of the element;
     * if it is a leaf, returns the info from getMeta[year]
     * else, returns the average of the result from its children.
     * Entry is '-' for no year.
     *
     * @author  Ben Dodson
     * @version 5/21/04
     * @since   5/21/04
     */

    public function getYear()
    {
        global $sql_type, $sql_pw, $sql_usr, $sql_socket, $sql_db;

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        $path = addslashes($this->getPath('String'));

        if ($this->isLeaf()) {
            $results = dbx_query($link, "SELECT year FROM tracks WHERE path = '$path'");

            return $results->data[0][year];
        }  

        $results = dbx_query($link, "SELECT year FROM tracks WHERE path LIKE '${path}%' AND year != '-'");

        $sum = 0;

        $total = 0;

        foreach ($results->data as $row) {
            if (is_numeric($row[year])) {
                $sum += $row[year];

                $total++;
            }
        }

        if (0 == $total) {
            return '-';
        }

        return round($sum / $total);
    }

    // end global_include: overrides.php
}

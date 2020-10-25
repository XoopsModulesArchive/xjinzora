<?php

$count = 0;
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
        $this->_constructor($par);
    }

    /**
     * Updates the cache using $this as the base node.
     *
     * @author  Ben Dodson <bdodson@seas.upenn.edu>
     * @version 5/13/04
     * @since   5/13/04
     */

    public function updateCache()
    {
        global $music_dir, $audio_types, $video_types, $ext_graphic, $fav_image_name, $count;

        echo ++$count . "\n";

        // FOR TESTING!!! REMOVE ME!

        $music_dir = '/mnt/dump/Music';

        $audio_types = 'mp3|ogg|wma|wav';

        $video_types = 'avi|mpg|wmv|mpeg';

        $ext_graphic = 'jpg|gif|png|jpeg';

        $fav_image_name = 'folder.jpg';

        // The database adaptor builds itself based on the filesystem.

        $mdate = date('Y-m-d');

        $mySlashedName = addslashes($this->getName());

        $pathArray = $this->getPath();

        $nodePath = $this->getPathString();

        $slashedNodePath = addslashes($nodePath); // SQL no likey the quotes.

        $level = $this->getLevel();

        // connect to the database.

        $link = jz_db_connect();

        // Mark my children as invalid if they exist in the DB.

        // Mark as valid only if/when they are found.

        $sql = "UPDATE nodes SET valid = 'false' ";

        $sql .= "WHERE level > $level AND path = '${slashedNodePath}%'";

        //jz_db_query($sql, $link);

        // Now handle $this.

        // Was I already in the DB?

        $sql = "SELECT * FROM nodes WHERE path = '$slashedNodePath'";

        if (!$sqlresult = jz_db_query($sql, $link)) {
            die(jz_db_error($link));
        }

        //$results = jz_db_fetch($sqlresult);

        if (!$results) {
            // New node for DB.

            $sql = 'INSERT INTO nodes(name,path,level,date_added) ';

            $sql .= "VALUES('$mySlashedName','$slashedNodePath',$level,'$mdate')";

        // ADD MORE INFO TO DB.
            //jz_db_query($sql, $link) || die (jz_db_error($link));
        } else {
            // Already in DB

            $sql = "UPDATE nodes SET valid = 'true' ";

            $sql .= "WHERE path = '$slashedNodePath'";

            //jz_db_query($sql, $link) || die (jz_db_error($link));
        }

        if (!($handle = opendir($music_dir . '/' . $nodePath))) {
            die("Could not access directory $music_dir" . '/' . (string)$nodePath);
        }

        // let's look for the best files to use while we are scanning this directory:

        $bestImage = '';

        $bestDescription = '';

        while ($file = readdir($handle)) {
            $nextPath = ('' == $nodePath) ? $file : $nodePath . '/' . $file;

            if ('.' == $file || '..' == $file) {
                continue;
            } elseif (is_dir($music_dir . '/' . $nextPath)) {
                $nparray = explode('/', $nextPath);

                $next = new self($nparray);

                $next->updateCache();
            } else {  // is a regular file.
                // That means check for media file (leaf),

                // or picture or text for $this.

                if (preg_match("/\.($ext_graphic)$/i", $file)) {
                    // Yay, an image!

                    // TODO: check for thumbnails etc.

                    if (preg_match("($fav_image_name)", $file)) {
                        $bestImage = $file;
                    } elseif ('' == $bestImage) {
                        $bestImage = $file;
                    }
                } elseif (preg_match("/\.($audio_types)$/i", $file)
                          || preg_match("/\.($video_types)$/i", $file)) {
                    // Yay, a media file!

                    // add it as a node;

                    // TODO: HASHING STUFF

                    // First, am I in the table already?

                    $slashedFileName = addslashes($file);

                    $slashedFilePath = $slashedNodePath . '/' . $slashedFileName;

                    $sql = "SELECT leaf FROM nodes WHERE
							path = '$slashedFilePath'";

                    //if (!$sqlresult = jz_db_query($sql,$link)) die(jz_db_error($link));

                    //$results = jz_db_fetch($sqlresult);

                    if (count($results)) {
                        // A new song

                        $sql = 'INSERT INTO nodes(name,path,level,date_added,leaf) ';

                        $sql .= "VALUES('$slashedFileName','$slashedFilePath',$level+1,'$mdate','true');\n";

                    //	jz_db_query($sql, $link) || die(jz_db_error($link));
                    } else {
                        // A song that was already in the DB

                        // TODO: definitely have to hash here.

                        // add ID3 stuff to leaves table.

                        continue;
                    }
                }

                // TODO: check for description;
                //       check for thumbnails, etc.
            }
        }

        // add new info to $this's database entry.

        $sqlUpdate = '';

        if ('' != $bestImage) {
            // TODO: Make sure this path is set right.

            $bestImage = addslashes($music_dir . '/' . $nodePath . '/' . $bestImage);

            $sqlUpdate .= "main_art = '$bestImage'";
        }

        if ('' != $bestDescription) {
            // similar code here.

            if ('' != $sqlUpdate) {
                $sqlUpdate .= ', ';
            }
        }

        if ('' != $sqlUpdate) {
            $sql = "UPDATE nodes SET $sqlUpdate WHERE path = '$slashedNodePath'";

            //jz_db_query($sql,$link) || die (jz_db_error($link));
        }

        // all done; remove everything beyond $this's path that is still not valid.

        $sql = 'DELETE FROM nodes ';

        $sql .= "WHERE level > $level AND path LIKE '${slashedNodePath}%' AND valid = 'false'";

        //jz_db_query($sql,$link) || die (jz_db_error($link));
    }

    /**
     * Counts the number of subnodes $distance steps down.
     * $distance = -1 does a recursive count.
     *
     * @param mixed $type
     * @param mixed $distance
     * @return
     * @return
     * @author  Ben Dodson <bdodson@seas.upenn.edu>
     * @version 5/14/2004
     * @since   5/14/2004
     */

    public function getSubNodeCount($type = 'both', $distance = 1)
    {
        global $sql_type, $sql_pw, $sql_socket, $sql_db, $sql_usr;

        $pathArray = $this->getPath();

        $level = $this->getLevel();

        $pathString = addslashes($this->getPathString());

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
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

        // leaf is a small field; we just need the count.

        $sql = "SELECT leaf FROM nodes WHERE level $op $level $lim AND path LIKE '${pathString}%'";

        $results = dbx_query($link, $sql);

        return $results->rows;
    }

    /**
     * Returns the subnodes as an array.
     *
     * @param mixed $type
     * @param mixed $random
     * @param mixed $distance
     * @param mixed $limit
     * @return array
     * @return array
     * @since   5/14/2004
     * @author  Ben Dodson <bdodson@seas.upenn.edu>
     * @version 5/15/2004
     */

    public function getSubNodes($type = 'nodes', $random = false, $distance = 1, $limit = 0)
    {
        global $sql_type, $sql_pw, $sql_socket, $sql_db, $sql_usr;

        $pathArray = $this->getPath();

        $level = $this->getLevel();

        $pathString = addslashes($this->getPathString());

        if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
            die('could not connect to database.');
        }

        if ($distance < 0) {
            $op = '>';
        } else {
            $op = '=';

            $level += $distance;
        }

        $sql = "SELECT path,leaf FROM nodes WHERE level $op $level
				AND path LIKE '${pathString}%'";

        if ('leaves' == $type) {
            $sql .= " AND leaf = 'true'";
        } elseif ('nodes' == $type) {
            $sql .= " AND leaf = 'false'";
        }

        if ($random) {
            $sql .= ' ORDER BY rand()';
        }

        if ($limit > 0) {
            $sql .= " LIMIT $limit";
        }

        $results = dbx_query($link, $sql);

        // have $results.

        $arr = [];

        for ($i = 0; $i < $results->rows; $i++) {
            if ('false' == $results->data[$i][leaf]) {
                $arr[] = new self(explode('/', stripslashes($results->data[$i][path])));
            } else {
                $arr[] = new jzMediaTrack(explode('/', stripslashes($results->data[$i][path])));
            }
        }

        // Sort?

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

    public function getAlphabetical($letter, $distance = 1)
    {
        global $sql_type, $sql_pw, $sql_socket, $sql_db, $sql_usr;

        $pathString = addslashes($this->getPathString());

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
				  AND name LIKE '${letter}%'"
            );
        }

        // have $results.

        $arr = [];

        for ($i = 0; $i < $results->rows; $i++) {
            if ('false' == $results->data[$i][leaf]) {
                $arr[] = new self(explode('/', stripslashes($results->data[$i][path])));
            } else {
                $arr[] = new jzMediaTrack(explode('/', stripslashes($results->data[$i][path])));
            }
        }

        // TODO: sort $arr.

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

        $path = addslashes($this->getPathString());

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

        $path = addslashes($this->getPathString());

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

        $path = addslashes($this->getPathString());

        dbx_query($link, "UPDATE nodes SET playcount = playcount+1 WHERE path = '$path'");

        if (count($ar = $this->getPath()) > 0) {
            array_pop($ar);

            $next = new self($ar);

            $next->increasePlayCount();
        }
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

        $path = addslashes($this->getPathString());

        $results = dbx_query($link, "SELECT main_art FROM nodes WHERE path = '$path'");

        return stripslashes($results->data[0][main_art]);
    }

    /**
     * Sets the node's main art
     *
     * @author
     * @version
     * @since
     * @param mixed $image
     */

    public function addMainArt($image)
    {
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
     * @author
     * @version
     * @since
     */

    public function getShortDescripiton()
    {
    }

    /**
     * Adds a brief description.
     *
     * @author
     * @version
     * @since
     * @param mixed $text
     */

    public function addShortDescription($text)
    {
    }

    /**
     * Returns the description of the node.
     *
     * @author
     * @version
     * @since
     */

    public function getDescription()
    {
    }

    /**
     * Adds a description.
     *
     * @author
     * @version
     * @since
     * @param mixed $text
     */

    public function addDescription($text)
    {
    }

    /**
     * Gets the overall rating for the node.
     *
     * @author
     * @version
     * @since
     */

    public function getRating()
    {
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

        $path = addslashes($this->getPathString());

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
     * @author
     * @version
     * @since
     */

    public function getDiscussion()
    {
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

        $path = addslashes($this->getPathString());

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
     * Returns the stringized version of the path in the form:
     * genre/artist/album
     *
     * @author  Ben Dodson
     * @version 5/13/04
     * @since   5/13/04
     */

    public function getPathString()
    {
        return implode('/', $this->getPath());
    }

    // end global_include: overrides.php
}

class jzMediaTrack extends jzMediaTrackClass
{
    /**
     * Constructor wrapper for jzMediaTrack.
     *
     * @author
     * @version
     * @since
     * @param mixed $par
     */

    public function __construct($par = [])
    {
        $this->_constructor($par);
    }

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

        $path = addslashes($this->getPathString());

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

        $path = addslashes($this->getPathString());

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

        $path = addslashes($this->getPathString());

        dbx_query($link, "UPDATE nodes SET playcount = playcount+1 WHERE path = '$path'");

        if (count($ar = $this->getPath()) > 0) {
            array_pop($ar);

            $next = new jzMediaNode($ar);

            $next->increasePlayCount();
        }
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

        $path = addslashes($this->getPathString());

        $results = dbx_query($link, "SELECT main_art FROM nodes WHERE path = '$path'");

        return stripslashes($results->data[0][main_art]);
    }

    /**
     * Sets the node's main art
     *
     * @author
     * @version
     * @since
     * @param mixed $image
     */

    public function addMainArt($image)
    {
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
     * @author
     * @version
     * @since
     */

    public function getShortDescripiton()
    {
    }

    /**
     * Adds a brief description.
     *
     * @author
     * @version
     * @since
     * @param mixed $text
     */

    public function addShortDescription($text)
    {
    }

    /**
     * Returns the description of the node.
     *
     * @author
     * @version
     * @since
     */

    public function getDescription()
    {
    }

    /**
     * Adds a description.
     *
     * @author
     * @version
     * @since
     * @param mixed $text
     */

    public function addDescription($text)
    {
    }

    /**
     * Gets the overall rating for the node.
     *
     * @author
     * @version
     * @since
     */

    public function getRating()
    {
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

        $path = addslashes($this->getPathString());

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
     * @author
     * @version
     * @since
     */

    public function getDiscussion()
    {
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

        $path = addslashes($this->getPathString());

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
     * Returns the stringized version of the path in the form:
     * genre/artist/album
     *
     * @author  Ben Dodson
     * @version 5/13/04
     * @since   5/13/04
     */

    public function getPathString()
    {
        return implode('/', $this->getPath());
    }

    // end global_include: overrides.php
}

$a = new jzMediaNode();
$a->updateCache();

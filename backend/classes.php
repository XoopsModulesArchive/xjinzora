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
 * These are the classes extended by the backend adaptors.
 *
 * @since  05.10.04
 * @author Ross Carlson <ross@jinzora.org>
 */
class jzMediaElement
{
    public $name;

    public $path;

    // If you want to add specifics to the constructor, call _constructor() as well.

    /**
     * Constructor wrapper for a jzMediaElement
     *
     * @author  Ben Dodson
     * @version 5/13/04
     * @since   5/13/04
     * @param mixed $par
     */

    public function __construct($par = [])
    {
        $this->_constructor($par);
    }

    /**
     * Universal Constructor for a jzMediaElement
     *
     * @author  Ben Dodson
     * @version 5/13/04
     * @since   5/13/04
     * @param mixed $arg
     */

    public function _constructor($arg = [])
    {
        if (is_string($arg)) {
            // make sure it's well formatted.

            if ('/' == $arg[0]) {
                $arg = mb_substr($arg, 1);
            }

            if ('/' == $arg[mb_strlen($arg) - 1]) {
                $arg = mb_substr($arg, 0, -1);
            }

            // root?

            if ('' == $arg) {
                $this->path = [];

                $this->name = '';
            } else {
                $arrayize = explode('/', $arg);

                $this->path = $arrayize;

                $this->name = $arrayize[count($arrayize) - 1];
            }
        } else {
            if ($arg == []) {
                $this->name = '';

                $this->path = $arg;
            } else {
                $this->name = $arg[count($arg) - 1];

                $this->path = $arg;
            }
        }
    }

    /**
     * Returns the name of the node.
     *
     * @author  Ben Dodson
     * @version 5/13/04
     * @since   5/13/04
     */

    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the depth of the node.
     *
     * @author  Ben Dodson
     * @version 5/14/04
     * @since   5/14/04
     */

    public function getLevel()
    {
        return ($this->path == []) ? 0 : count($this->path);
    }

    /**
     * Returns the full path to the node.
     *
     * @param mixed $type
     * @return string
     * @return string
     * @since   5/13/04
     * @author  Ben Dodson
     * @version 5/16/04
     */

    public function getPath($type = 'array')
    {
        $type = mb_strtolower($type);

        if ('string' == $type) {
            return implode('/', $this->getPath());
        }
  

        return $this->path;
    }

    /**
     * Returns the date the node was added.
     *
     * @author  Ben Dodson
     * @version 6/5/04
     * @since   6/5/04
     */

    public function getDateAdded()
    {
        $cache = $this->readCache();

        return $cache[6];
    }

    /**
     * Returns the number of times the node has been played.
     *
     * @author  Ben Dodson
     * @version 6/5/04
     * @since   6/5/04
     */

    public function getPlayCount()
    {
        $cache = $this->readCache();

        return $cache[3];
    }

    /**
     * Increments the node's playcount, as well
     * as the playcount of its parents.
     *
     * @author  Ben Dodson
     * @version 6/5/04
     * @since   6/5/04
     */

    public function increasePlayCount()
    {
        $cache = $this->readCache();

        $cache[3] += 1;

        $this->writeCache($cache);

        if (count($ar = $this->getPath()) > 0) {
            array_pop($ar);

            $next = new jzMediaNode($ar);

            $next->increasePlayCount();
        }
    }

    /**
     * Sets this element's playcount directly.
     *
     * @author  Ben Dodson
     * @version 6/5/04
     * @since   6/5/04
     * @param mixed $n
     */

    public function setPlayCount($n)
    {
        $cache = $this->readCache();

        $cache[3] = $n;

        $this->writeCache($cache);
    }

    /**
     * Returns the main art for the node.
     *
     * @author  Ben Dodson
     * @version 6/4/04
     * @since   6/4/04
     */

    public function getMainArt()
    {
        $cache = $this->readCache();

        return ('-' == $cache[1]) ? false : $cache[1];
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
        $cache = $this->readCache();

        $cache[1] = $image;

        $this->writeCache($cache);
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
        $cache = $this->readCache();

        return ('-' == $cache[9]) ? false : $cache[9];
    }

    /**
     * Adds a brief description.
     *
     * @author  Ben Dodson
     * @version 6/5/04
     * @since   6/5/04
     * @param mixed $text
     */

    public function addShortDescription($text)
    {
        $cache = $this->readCache();

        $cache[9] = $text;

        $this->writeCache($cache);
    }

    /**
     * Returns the description of the node.
     *
     * @author  Ben Dodson
     * @version 6/5/04
     * @since   6/5/04
     */

    public function getDescription()
    {
        $cache = $this->readCache();

        return ('-' == $cache[10]) ? false : $cache[10];
    }

    /**
     * Adds a description.
     *
     * @author  Ben Dodson
     * @version 6/5/04
     * @since   6/5/04
     * @param mixed $text
     */

    public function addDescription($text)
    {
        $cache = $this->readCache();

        $cache[10] = $text;

        $this->writeCache($cache);
    }

    /**
     * Gets the overall rating for the node.
     *
     * @author  Ben Dodson
     * @version 6/5/04
     * @since   6/5/04
     */

    public function getRating()
    {
        $cache = $this->readCache();

        return (0 == $cache[5]) ? 0 : $cache[4] / $cache[5];
    }

    /**
     * Returns the date the node was added.
     *
     * @author  Ben Dodson
     * @version 6/5/04
     * @since   6/5/04
     * @param mixed $rating
     */

    public function addRating($rating)
    {
        $cache = $this->readCache();

        $cache[4] += $rating;

        $cache[5] += 1;

        $this->writeCache($cache);
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
        return $this->readCache('discussions');
    }

    /**
     * Adds a blurb to the node's discussion
     *
     * @author  Ben Dodson
     * @version 6/7/04
     * @since   6/7/04
     * @param mixed $text
     * @param mixed $username
     */

    public function addDiscussion($text, $username)
    {
        $discussion = $this->readCache('discussions');

        $i = count($discussion);

        $discussion[$i]['user'] = $username;

        $discussion[$i]['comment'] = $text;

        $this->writeCache($discussion, 'discussions');
    }

    /**
     * Returns the year of the element;
     * if it is a leaf, returns the info from getMeta[year]
     * else, returns the average of the result from its children.
     * Entry is '-' for no year.
     *
     * @author  Ben Dodson
     * @version 6/7/04
     * @since   6//704
     */

    public function getYear()
    {
        $cache = $this->readCache();

        return $cache[11];
    }

    /**
     * Returns whether or not this element is a leaf.
     *
     * @author
     * @version
     * @since
     */

    public function isLeaf()
    {
    }

    /**
     * Returns the cache as an array formatted as specified in updateCache().
     * If the cache does not exist, returns false.
     *
     * @param mixed $type
     * @return array|false|mixed
     * @return array|false|mixed
     * @since   5/10/04
     * @author  Laurent Perrin
     * @version 5/10/04
     */

    public function readCache($type = false)
    {
        global $backend;

        if (false === $type) {
            if ($this->isLeaf()) {
                $type = 'tracks';
            } else {
                $type = 'nodes';
            }
        }

        $type = mb_strtolower($type);

        if (0 == $this->getLevel()) {
            $cachename = 'jzroot';
        } // To avoid 20000+ entries in data/tracks...

        elseif ($this->isLeaf() && 'tracks' == $type) {
            $temp = $this->getPath();

            array_pop($temp);

            $cachename = implode('---', $temp);
        } else {
            $cachename = implode('---', $this->getPath());
        }

        $datapath = "backend/${backend}/data";

        if (!is_file($datapath . "/$type/" . $cachename)) {
            // Give an empty cache.

            // Note that there are different 'empty caches'.

            if ('nodes' == $type) {
                return blankCache('node');
            } elseif ('tracks' == $type) {
                return blankCache('track');
            }
  

            return [];
        }

        if ($this->isLeaf() && 'tracks' == $type) {
            $temp = $this->getPath();

            $name = $temp[count($temp) - 1];

            $temp = unserialize(file_get_contents($datapath . "/$type/" . $cachename));

            for ($i = 0, $iMax = count($temp); $i < $iMax; $i++) {
                if ($temp[$i][2] == $name) {
                    return $temp[$i];
                }
            }

            return false;
        }
  

        return unserialize(file_get_contents($datapath . "/$type/" . $cachename));
    }

    /**
     * Writes the cache.
     *
     * @param mixed $cache
     * @param mixed $type
     * @return bool
     * @return bool
     * @author  Ben Dodson
     * @version 6/4/04
     * @since   6/4/04
     */

    public function writeCache($cache, $type = false)
    {
        global $backend;

        if (false === $type) {
            if ($this->isLeaf()) {
                $type = 'tracks';
            } else {
                $type = 'nodes';
            }
        }

        $type = mb_strtolower($type);

        if (0 == $this->getLevel()) {
            $cachename = 'jzroot';
        } elseif ($this->isLeaf() && 'tracks' == $type) {
            $temp = $this->getPath();

            array_pop($temp);

            $cachename = implode('---', $temp);
        } else {
            $cachename = implode('---', $this->getPath());
        }

        $datapath = "backend/${backend}/data";

        $filename = $datapath . "/$type/" . $cachename;

        if ($this->isLeaf() && 'tracks' == $type) {
            $temp = $this->getPath();

            $name = $temp[count($temp) - 1];

            $oldcache = unserialize(file_get_contents($filename));

            if (!$handle = fopen($filename, 'wb')) {
                return false;
            }

            $i = 0;

            for ($i = 0, $iMax = count($cache); $i < $iMax; $i++) {
                if ($oldcache[$i][2] == $name) {
                    $oldcache[$i] == $cache;

                    fwrite($handle, serialize($cache));

                    fclose($handle);

                    return true;
                }

                $cache[$i] = $cache;

                fwrite($handle, serialize($cache));

                fclose($handle);

                return true;
            }
        } else {
            if (!$handle = fopen($filename, 'wb')) {
                return false;
            }

            fwrite($handle, serialize($cache));
        }

        fclose($handle);

        return true;
    }

    /**
     * Removes the caches found for the node.
     *
     * @author  Ben Dodson
     * @version 6/7/04
     * @since   6/7/04
     */

    public function deleteCache()
    {
        global $backend;

        if ($this->isLeaf()) {
            return false;
            // This is not used right now, but it could be written.
        }

        if (0 == $this->getLevel()) {
            $cachename = 'jzroot';
        } else {
            $cachename = implode('---', $this->getPath());
        }

        $filename = "backend/${backend}/data/nodes/${cachename}";

        unlink($filename);

        $filename = "backend/${backend}/data/tracks/${cachename}";

        unlink($filename);

        // Let's keep discussions for now, since they can't be gotten back...
        // $filename = "backend/${backend}/data/discussions/${cachename}";
        // unlink($filename);
    }
}

class jzMediaNodeClass extends jzMediaElement
{
    public $natural_depth; // if the level before us is 'hidden'

    /**
     * Constructor for a jzMediaNodeClass
     *
     * @author  Ben Dodson
     * @version 5/14/04
     * @since   5/14/04
     * @param mixed $par
     */

    public function __construct($par = [])
    {
        $this->_constructor($par);
    }

    public function _constructor($par = [])
    {
        $this->natural_depth = 1;

        parent::_constructor($par);
    }

    /**
     * Gets the 'natural depth' of this node.
     * This has no real purpose outside of the class.
     *
     * @author  Ben Dodson
     * @version 5/21/04
     * @since   5/21/04
     */

    public function getNaturalDepth()
    {
        return $this->natural_depth;
    }

    /**
     * Sets the natural depth (for searching, counting etc.) of this node.
     * Useful if the node is preceded by a hidden level.
     *
     * @author  Ben Dodson
     * @version 5/14/04
     * @since   5/14/04
     * @param mixed $n
     */

    public function setNaturalDepth($n)
    {
        $this->natural_depth = $n;
    }

    /**
     * Counts the number of subnodes $distance steps down of type $type.
     * $distance = -1 means do it recursively.
     *
     * @param mixed $type
     * @param mixed $distance
     * @return int
     * @return int
     * @author
     * @version
     * @since
     */

    public function getSubNodeCount($type = 'both', $distance = false)
    {
        if (false === $distance) {
            $distance = $this->getNaturalDepth();
        }

        // TEMPORARY EASY METHOD:
        return count($this->getSubNodes($type, $distance, true, 0)); // $random = true is faster than sorting.
        // TODO 1) make another cache for counting.
        // TODO 2) don't return the array; just count as you go.
    }

    /**
     * Returns the subnodes as an array. A $distance of -1 means do it recursively.
     *
     * @param mixed $type
     * @param mixed $distance
     * @param mixed $random
     * @param mixed $limit
     * @return array
     * @return array
     * @since   6/4/04
     * @author  Ben Dodson
     * @version 6/4/04
     */

    public function getSubNodes($type = 'nodes', $distance = false, $random = false, $limit = 0)
    {
        if (false === $distance) {
            $distance = $this->getNaturalDepth();
        }

        // 2 cases:

        $search = [];

        $vals = [];

        // 1) recursive

        if ($distance < 0) {
            $node = $this;

            $search[] = $node;

            while ($search != []) {
                $node = array_pop($search);

                $cache = $node->readCache('nodes');

                if ($nodearray = $cache[7]) {
                    foreach ($nodearray as $name) {
                        $search[] = new jzMediaNode($node->getPath('String') . '/' . $name);

                        if ('nodes' == $type || 'both' == $type) {
                            $vals[] = new jzMediaNode($node->getPath('String') . '/' . $name);
                        }
                    }
                }

                if ('leaves' == $type || 'both' == $type) {
                    if ($trackarray = $cache[8]) {
                        foreach ($trackarray as $track) {
                            $vals[] = new jzMediaTrack($node->getPath('String') . '/' . $track);
                        }
                    }
                }
            }
        } // 2: not.

        else {
            $i = 1;

            $node = $this;

            $search[] = $node;

            while ($distance != $i) {
                $i++;

                $temp = [];

                while ($search != []) {
                    $node = array_pop($search);

                    $cache = $node->readCache('nodes');

                    if ($nodearray = $cache[7]) {
                        foreach ($nodearray as $name) {
                            $temp[] = new jzMediaNode($node->getPath('String') . '/' . $name);
                        }
                    }
                }

                $search = $temp;
            }

            foreach ($search as $node) {
                $cache = $node->readCache('nodes');

                if ('both' == $type || 'nodes' == $type) {
                    if ($nodearray = $cache[7]) {
                        foreach ($nodearray as $name) {
                            $vals[] = new jzMediaNode($node->getPath('String') . '/' . $name);
                        }
                    }
                }

                if ('both' == $type || 'leaves' == $type) {
                    if ($trackarray = $cache[8]) {
                        foreach ($trackarray as $track) {
                            $vals[] = new jzMediaTrack($node->getPath('String') . '/' . $track);
                        }
                    }
                }
            }
        }

        if ($random) {
            mt_srand((float)microtime() * 1000000);

            shuffle($vals);
        } else {
            usort($vals, 'compareNodes');
        }

        if ($limit > 0 && $limit < count($vals)) {
            $final = [];

            for ($i = 0; $i < $limit; $i++) {
                $final[] = $vals[$i];
            }

            return $final;
        }
  

        return $vals;
    }

    /**
     * Returns the 'top' subnodes. $distance = -1 is recursive.
     *
     * @author
     * @version
     * @since
     * @param mixed $type
     * @param mixed $top_type
     * @param mixed $distance
     * @param mixed $limit
     */

    public function getTopSubNodes($type = 'nodes', $top_type = 'most-played', $distance = false, $limit = 0)
    {
        if (false === $distance) {
            $distance = $this->getNaturalDepth();
        }
    }

    /**
     * Returns the subnode named $name.
     *
     * @param mixed $name
     * @return
     * @return
     * @since   5/16/04
     * @author  Ben Dodson
     * @version 5/16/04
     */

    public function getSubNode($name)
    {
        $p = $this->path;

        $p[] = $name;

        // TODO: check for jzMediaTrack or jzMediaNode?

        // I'm not sure how needed this function is anyways...

        return jzMediaElement($p);
    }

    /**
     * Searches a specified level for elements.
     * The level is -1 for any level.
     *
     * @author
     * @version
     * @since
     * @param mixed $searchArray
     * @param mixed $op
     * @param mixed $type
     * @param mixed $depth
     * @param mixed $meta
     * @param mixed $exclude
     * @param mixed $limit
     */

    public function search($searchArray, $op = 'and', $type = 'both', $depth = -1, $meta = [], $exclude = [], $limit = 0)
    {
    }

    /**
     * Updates the cache using this node as a base.
     *
     * @author  Ben Dodson
     * @version 6/7/04
     * @since   5/17/04
     */

    public function updateCache()
    {
        /* Serialized array:
         * nodes/path---to---node:
         * (root is called jzroot)
         *
         * [0]  filepath
         * [1]  art
         * [2]  updated
         * [3]  playcount
         * [4]  rating
         * [5]  ratingcount
         * [6]  dateadded
         * [7]  nodes array
         * [8]  tracks array
         * [9]  short_desc
         * [10] desc
         * [11] year
         *
         * tracks/path---to---node:
         * (root is called jzroot)
         * Each track is a line of the file and is a serialized array of the form:
         *      0      1      2       3         4         5          6        7        8           9       10    11    12     13      14     15      16       17       18       19        20
         * [filepath][art][fname][playcount][rating][ratingcount][dateadded][name][frequency][short_desc][desc][year][size][length][genre][artist][album][extension][lyrics][bitrate][tracknum]
         */

        $this->updateCacheHelper();
    }

    public function updateCacheHelper()
    {
        global $root_dir, $media_dir, $web_root, $audio_types, $video_types, $ext_graphic, $fav_image_name, $backend, $track_num_seperator;

        $datapath = "backend/${backend}/data";

        $mediapath = $web_root . $root_dir . $media_dir;

        $imageroot = $root_dir . $media_dir;

        $nodepath = $this->getPath('String');

        // First add $this.

        // Was I already cached?

        if ($cache = $this->readCache()) {
            $old_nodes = $cache[7];
        } else {
            $cache = blankCache('node');

            $blankfilecache = blankCache('track');

            $cache[0] = $nodepath;

            $cache[6] = date('Y-m-d', filemtime($mediapath . '/' . $nodepath));

            $old_nodes = [];
        }

        // Recurse and add $this's media files.

        if (!($handle = opendir($mediapath . '/' . $nodepath))) {
            die("Could not access directory $music_dir" . '/' . (string)$nodepath);
        }

        // scan for info while going through directory:

        $trackcount = 0;

        $new_nodes = [];

        $new_tracks = [];

        $bestImage = '';

        $bestDescription = '';

        while ($file = readdir($handle)) {
            $childpath = ('' == $nodepath) ? $file : $nodepath . '/' . $file;

            if ('.' == $file || '..' == $file) {
                continue;
            } elseif (is_dir($mediapath . '/' . $childpath)) {
                $next = new jzMediaNode($childpath);

                $next->updateCacheHelper();

                $new_nodes[] = $file;

                if ($old_nodes != []) {
                    $key = array_search($file, $old_nodes, true);

                    if (false !== $key) {
                        unset($old_nodes[$key]);
                    }
                }
            } else {
                if (preg_match("/\.(txt)$/i", $file)) {
                    // TODO: GET THE CORRECT DESCRIPTION IN $bestDescription
                } elseif (preg_match("/\.($ext_graphic)$/i", $file) && !mb_stristr($file, '.thumb.')) {
                    // An image

                    if (preg_match("($fav_image_name)", $file)) {
                        $bestImage = $imageroot . '/' . $nodepath . '/' . $file;
                    } elseif ('' == $bestImage) {
                        $bestImage = $imageroot . '/' . $nodepath . '/' . $file;
                    }
                } elseif (preg_match("/\.($audio_types)$/i", $file)
                          || preg_match("/\.($video_types)$/i", $file)) {
                    //* * * A track * * * *//

                    // Add it to the track list.

                    $new_tracks[] = $file;

                    // And at it's details..

                    $childnode = new jzMediaTrack($childpath);

                    if (('-' == $cache[2] || $cache[2] < date('U', filemtime($mediapath . '/' . $childpath))) || !$childnode->readCache()) {
                        // Add as a new/updated track.

                        if (!$filecache[$trackcount] = $childnode->readCache()) {
                            $filecache[$trackcount] = $blankfilecache;

                            $filecache[$trackcount][6] = date('Y-m-d', filemtime($mediapath . '/' . $childpath));

                            $filecache[$trackcount][0] = $childpath;

                            $filecache[$trackcount][2] = $file;
                        }

                        //////////

                        // META //

                        //////////

                        $getID3 = new getID3();

                        $fileInfo = $getID3->analyze($mediapath . '/' . $childpath);

                        getid3_lib::CopyTagsToComments($fileInfo);

                        if (!empty($fileInfo['audio']['bitrate'])) {
                            $filecache[$trackcount][19] = (round($fileInfo['audio']['bitrate'] / 1000));
                        }

                        if (!empty($fileInfo['playtime_string'])) {
                            $filecache[$trackcount][13] = $fileInfo['playtime_string'];
                        }

                        if (!empty($fileInfo['filesize'])) {
                            $filecache[$trackcount][12] = round($fileInfo['filesize'] / 1000000, 2);
                        }

                        if (!empty($fileInfo['comments']['title'][0])) {
                            $filecache[$trackcount][7] = $fileInfo['comments']['title'][0];
                        }

                        if (!empty($fileInfo['comments']['artist'][0])) {
                            $filecache[$trackcount][15] = $fileInfo['comments']['artist'][0];
                        }

                        if (!empty($fileInfo['comments']['album'][0])) {
                            $filecache[$trackcount][16] = $fileInfo['comments']['album'][0];
                        }

                        if (!empty($fileInfo['comments']['year'][0])) {
                            $filecache[$trackcount][11] = $fileInfo['comments']['year'][0];

                            if ($cache[11] = '-') {
                                $cache[11] = $filecache[$trackcount][11];
                            }
                        }

                        if (!empty($fileInfo['comments']['track'][0])) {
                            $filecache[$trackcount][21] = $fileInfo['comments']['track'][0];
                        }

                        if (!empty($fileInfo['comments']['genre'][0])) {
                            $filecache[$trackcount][14] = $fileInfo['comments']['genre'][0];
                        }

                        if (!empty($fileInfo['audio']['sample_rate'])) {
                            $filecache[$trackcount][8] = round($fileInfo['audio']['sample_rate'] / 1000, 1);
                        }

                        if (!empty($fileInfo['comments']['comment'][0])) {
                            $filecache[$trackcount][9] = $fileInfo['comments']['comment'][0];
                        } else {
                            $filecache[$trackcount][9] = '';
                        }

                        if (!empty($fileInfo['tags']['id3v2']['unsynchronised lyric'][0])) {
                            $filecache[$trackcount][18] = $fileInfo['tags']['id3v2']['unsynchronised lyric'][0];
                        } else {
                            $filecache[$trackcount][18] = '';
                        }

                        // Now let's get the extension

                        $fileInfo = pathinfo($mediapath . '/' . $childpath);

                        $fileExt = $fileInfo['extension'];

                        $filecache[$trackcount][17] = $fileExt;

                        // Now let's see if we need to manually create the name

                        if ('-' == $filecache[$trackcount][7] or 'Tconv' == $filecache[$trackcount][7]) {
                            $filecache[$trackcount][7] = str_replace('.' . $fileExt, '', $slashedFileName);

                            // Let's see if this is a .fake file or not

                            if (mb_stristr($filecache[$trackcount][7], 'fake')) {
                                $filecache[$trackcount][7] = str_replace('.fake', '', $filecache[$trackcount][7]);
                            }
                        }

                        // Now let's see if the name needs the file number stripped off of it (thus giving us the track number)

                        if (is_numeric(mb_substr($filecache[$trackcount][7], 0, 2))) {
                            // Ok, we found numbers so let's fix it up!

                            // Now let's figure out the new track names...

                            $filecache[$trackcount][20] = mb_substr($filecache[$trackcount][7], 0, 2);

                            $filecache[$trackcount][7] = mb_substr($filecache[$trackcount][7], 2, mb_strlen($filecache[$trackcount][7]));

                            $trackSepArray = explode('|', $track_num_seperator);

                            for ($i = 0, $iMax = count($trackSepArray); $i < $iMax; $i++) {
                                if (mb_stristr($filecache[$trackcount][7], $trackSepArray[$i])) {
                                    // Now let's strip from the beginning up to and past the seperator

                                    $filecache[$trackcount][7] = mb_substr($filecache[$trackcount][7], mb_strpos($filecache[$trackcount][7], $trackSepArray[$i]) + mb_strlen($trackSepArray[$i]), 999999);
                                }
                            }
                        } // See if we need the track number even though we didn't need the name.

                        else {
                            if ('-' == $filecache[$trackcount][20] && is_numeric(mb_substr($filecache[$trackcount][2], 0, 2))) {
                                $filecache[$trackcount][20] = mb_substr($filecache[$trackcount][2], 0, 2);
                            }
                        }

                        // Now let's make sure the name wasn't empty and if so just use the full file name...

                        if ('' == $filecache[$trackcount][7]) {
                            $filecache[$trackcount][7] = $file;
                        }

                        // Now let's see if there is a description file...

                        $desc_file = str_replace('.' . $fileExt, '', $mediapath . '/' . $childpath) . '.txt';

                        $long_description = '';

                        if (is_file($desc_file) and 0 != filesize($desc_file)) {
                            // Ok, let's read the description file

                            $handle2 = fopen($desc_file, 'rb');

                            $filecache[$trackcount][10] = fread($handle2, filesize($desc_file));

                            fclose($handle2);
                        } else {
                            $filecache[$trackcount][10] = '';
                        }

                        // Now let's see if there is a thumbnail for this track

                        $filecache[$trackcount][1] = searchThumbnail($mediapath . '/' . $childpath);
                    } else {
                        // slow but necessary..

                        $filecache[$trackcount] = $childnode->readCache();
                    }

                    $trackcount++;
                }
            }
        }

        foreach ($old_nodes as $temp) {
            $node = new jzMediaNode($nodepath . '/' . $temp);

            $temp = $node->getSubNodes('nodes', -1);

            foreach ($temp as $me) {
                $me->deleteCache();
            }

            $node->deleteCache();
        }

        // Update $this

        $cache[1] = $bestImage;

        $cache[2] = date('U');

        natcasesort($new_nodes);

        $cache[7] = $new_nodes;

        natcasesort($new_tracks);

        $cache[8] = $new_tracks;

        // * * * * * * * *

        // Write the cache.

        $this->writeCache($cache, 'nodes');

        if ($filecache != []) {
            $this->writeCache($filecache, 'tracks');
        }
    }

    /**
     * Returns whether or not this is a leaf (which it isn't)
     *
     * @author  Laurent Perrin
     * @version 5/10/04
     * @since   5/10/04
     */

    public function isLeaf()
    {
        return false;
    }

    /**
     * Returns the nodes starting with the specified letter.
     * if $letter is "#" it returns nodes that don't start with a-z.
     * if $letter is "*" it returns all nodes.
     *
     * @param mixed $letter
     * @param mixed $depth
     * @return array|\jzMediaNodeClass[]
     * @return array|\jzMediaNodeClass[]
     * @author  Ben Dodson <bdodson@seas.upenn.edu>
     * @version 6/4/04
     * @since   5/11/04
     */

    public function getAlphabetical($letter, $depth = false)
    {
        if (false === $depth) {
            $depth = $this->getNaturalDepth();
        }

        if (0 == $depth) {
            $first = mb_strtolower(mb_substr($this->getName(), 0, 1));

            $letter = mb_strtolower($letter);

            if ('#' == $letter) {
                if (!($first >= 'a' && $first <= 'z')) {
                    return [$this];
                }
            } elseif ('*' == $letter) {
                return [$this];
            } else { // standard case
                if ($letter == $first) {
                    return [$this];
                }
            }
        } else {
            $array = [];

            foreach ($this->getSubNodes() as $subnode) {
                if (!$subnode->isLeaf()) {
                    if (($arr = $subnode->getAlphabetical($letter, $depth - 1)) != []) {
                        foreach ($arr as $item) {
                            $array[] = $item;
                        }
                    }
                }
            }

            usort($array, 'compareNodes');

            return $array;
        }
    }

    /**
     * Marks this node as 'featured.'
     *
     * @author  Ben Dodson
     * @version 6/8/04
     * @since   6/8/04
     */

    public function addFeatured()
    {
        // Just 1 cache: from the root node.

        $root = new jzMediaNode();

        $cache = $root->readCache('featured');

        $cache[] = $this->getPath('String');

        $root->writeCache($cache, 'featured');
    }

    /**
     * Checks to see if this node is featured
     *
     * @author  Ben Dodson
     * @version 6/8/04
     * @since   6/8/04
     */

    public function isFeatured()
    {
        $root = new jzMediaNode();

        $path = $this->getPath('String');

        $cache = $root->readCache('featured');

        for ($i = 0, $iMax = count($cache); $i < $iMax; $i++) {
            if ($cache[$i] == $path) {
                return true;
            }
        }

        return false;
    }

    /**
     * Removes this node from the featured list.
     *
     * @author  Ben Dodson
     * @version 6/8/04
     * @since   6/8/04
     */

    public function removeFeatured()
    {
        $root = new jzMediaNode();

        $path = $this->getPath('String');

        $cache = $root->readCache('featured');

        for ($i = 0, $iMax = count($cache); $i < $iMax; $i++) {
            if ($cache[$i] == $path) {
                $cache[$i] = $cache[count($cache) - 1];

                unset($cache[count($cache) - 1]);

                $root->writeCache($cache, 'featured');

                return true;
            }
        }

        return false;
    }

    /**
     * Returns featured nodes. Limit 0 means get them all.
     * Order is random.
     *
     * @param mixed $distance
     * @param mixed $limit
     * @return array|false
     * @return array|false
     * @author  Ben Dodson
     * @version 6/8/04
     * @since   6/8/04
     */

    public function getFeatured($distance, $limit = 1)
    {
        $root = new jzMediaNode();

        $cache = $root->readCache('featured');

        $path = $this->getPath('String');

        $vals = [];

        $i = 0;

        if (0 == count($cache)) {
            return false;
        }

        mt_srand((float)microtime() * 10000000);

        $keys = array_rand($cache, count($cache));

        if (!is_array($keys)) {
            // only 1 key:

            $keys = [$keys];
        }

        foreach ($keys as $key) {
            $temp = $cache[$key];

            if ('' == $path || (0 == mb_strpos($temp, $path) && false !== mb_strpos($temp, $path) && $temp != $path)) {
                $vals[$i] = new jzMediaNode($temp);

                $i++;

                if ($i >= $limit) {
                    return $vals;
                }
            }
        }

        return $vals;
    }
}

class jzMediaTrackClass extends jzMediaElement
{
    /**
     * Constructor for a jzMediaTrackClass
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

    /**
     * Returns the track's name (from ID3)
     *
     * @author  Ben Dodson
     * @version 6/7/04
     * @since   6/7/04
     */

    public function getName()
    {
        $cache = $this->readCache();

        return $cache[7];
    }

    /**
     * Returns the track's complete file path (with $media_dir)
     *
     * @author  Ben Dodson
     * @version 6/7/04
     * @since   6/7/04
     */

    public function getFileName()
    {
        global $media_dir;

        // Let's not return the leading "/" in $media_dir...

        if ('/' == $media_dir[0]) {
            $media_dir = mb_substr($media_dir, 1);
        }

        $cache = $this->readCache();

        if ('-' != $cache[0]) {
            return $media_dir . '/' . $cache[0];
        }
  

        return $media_dir . '/' . $this->getPath('String');
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
     * @since   6/7/04
     * @author  Ben Dodson
     * @version 6/7/04
     */

    public function getMeta($mode = 'cache')
    {
        $meta = [];

        $cache = $this->readCache();

        if ('cache' == $mode && '-' != $cache[0]) {
            $meta['title'] = $cache[7];

            $meta['bitrate'] = $cache[19];

            $meta['frequency'] = $cache[8];

            $meta['filename'] = $cache[2];

            $meta['size'] = $cache[12];

            $meta['year'] = $cache[11];

            $meta['comment'] = ('-' == $cache[9]) ? '' : $cache[9];

            $meta['length'] = $cache[13];

            $meta['number'] = $cache[20];

            $meta['genre'] = $cache[14];

            $meta['artist'] = $cache[15];

            $meta['album'] = $cache[16];

            $meta['lyrics'] = ('-' == $cache[18]) ? '' : $cache[18];

            $meta['type'] = $cache[17];
        } else { // Get it from the file.
            $fname = $this->getFileName();

            $temp = $this->getPath();

            $meta['filename'] = $temp[count(temp) - 1];

            $getID3 = new getID3();

            $fileInfo = $getID3->analyze($fname);

            getid3_lib::CopyTagsToComments($fileInfo);

            if (!empty($fileInfo['audio']['bitrate'])) {
                $meta['bitrate'] = (round($fileInfo['audio']['bitrate'] / 1000));
            } else {
                $meta['bitrate'] = '-';
            }

            if (!empty($fileInfo['playtime_string'])) {
                $meta['length'] = $fileInfo['playtime_string'];
            } else {
                $meta['length'] = '-';
            }

            if (!empty($fileInfo['filesize'])) {
                $meta['size'] = round($fileInfo['filesize'] / 1000000, 2);
            } else {
                $meta['size'] = '-';
            }

            if (!empty($fileInfo['comments']['title'][0])) {
                $meta['title'] = $fileInfo['comments']['title'][0];
            } else {
                $meta['title'] = '-';
            }

            if (!empty($fileInfo['comments']['artist'][0])) {
                $meta['artist'] = $fileInfo['comments']['artist'][0];
            } else {
                '-' == $meta['artist'];
            }

            if (!empty($fileInfo['comments']['album'][0])) {
                $meta['album'] = $fileInfo['comments']['album'][0];
            } else {
                $meta['album'] = '-';
            }

            if (!empty($fileInfo['comments']['year'][0])) {
                $meta['year'] = $fileInfo['comments']['year'][0];
            } else {
                $meta['year'] = '-';
            }

            if (!empty($fileInfo['comments']['track'][0])) {
                $meta['number'] = $fileInfo['comments']['track'][0];
            } else {
                $meta['number'] = '-';
            }

            if (!empty($fileInfo['comments']['genre'][0])) {
                $meta['genre'] = $fileInfo['comments']['genre'][0];
            } else {
                $meta['genre'] = '-';
            }

            if (!empty($fileInfo['audio']['sample_rate'])) {
                $meta['frequency'] = round($fileInfo['audio']['sample_rate'] / 1000, 1);
            } else {
                $meta['frequency'] = '-';
            }

            if (!empty($fileInfo['comments']['comment'][0])) {
                $meta['comment'] = $fileInfo['comments']['comment'][0];
            } else {
                $meta['comment'] = '';
            }

            if (!empty($fileInfo['tags']['id3v2']['unsynchronised lyric'][0])) {
                $meta['lyrics'] = $fileInfo['tags']['id3v2']['unsynchronised lyric'][0];
            } else {
                $meta['lyrics'] = '';
            }

            // Now let's get the extension

            $fileInfo = pathinfo($fname);

            $meta['type'] = $fileInfo['extension'];

            // This does NOT currently do extensive checking against filename...
        }

        return $meta;
    }

    /**
     * Returns the track's lyrics.
     *
     * @author  Ben Dodson
     * @version 6/7/04
     * @since   6/7/04
     */

    public function getLyrics()
    {
        $cache = $this->readCache();

        return $cache[18];
    }

    /**
     * Adds lyrics for the track.
     * @author  Ben Dodson
     * @version 6/7/04
     * @since   6/7/04
     * @param mixed $text
     */

    public function addLyrics($text)
    {
        $cache = $this->readCache();

        $cache[18] = $text;

        $this->writeCache($cache);
    }

    /**
     * Returns true, since this element is a leaf.
     *
     * @author  Laurent Perrin
     * @version 5/10/04
     * @since   5/10/04
     */

    public function isLeaf()
    {
        return true;
    }
}

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
     * Counts the number of subnodes $distance steps down.
     * $distance = -1 does a recursive count.
     *
     * @param mixed $type
     * @param mixed $distance
     * @return int
     * @return int
     * @author  Ben Dodson <bdodson@seas.upenn.edu>
     * @version 5/14/2004
     * @since   5/14/2004
     */

    public function getSubNodeCount($type = 'both', $distance = false)
    {
        global $web_root, $root_dir, $media_dir, $audio_types, $video_types;

        $fullpath = $web_root . $root_dir . $media_dir;

        $mypath = $this->getPath('String');

        $fullpath .= '/' . $mypath;

        $sum = 0;

        if (false === $distance) {
            $distance = $this->getNaturalDepth();
        }

        $path_array = [$fullpath];

        $distance_array = [0];

        if ($distance >= 0 && $distance <= 1) {
            while ($path_array != []) {
                $p = array_pop($path_array);

                $d = array_pop($distance_array);

                $dir = opendir($p);

                while ($file = readdir($dir)) {
                    if ('.' == $file || '..' == $file) {
                        continue;
                    } elseif ($distance < 0) {
                        if (preg_match("/\.($audio_types)$/i", $file) || preg_match("/\.($video_types)$/i", $file)) {
                            if ('leaves' == $type || 'both' == $type) {
                                $sum++;
                            }
                        } elseif (is_dir($p . '/' . $file)) {
                            if ('nodes' == $type || 'both' == $type) {
                                $sum++;
                            }

                            $path_array[] = $p . '/' . $file;

                            $distance_array[] = $d + 1;
                        }
                    } elseif ($d == $distance) {
                        if ('nodes' == $type || 'both' == $type) {
                            $sum++;
                        }
                    } elseif ($d + 1 == $distance) {
                        if (preg_match("/\.($audio_types)$/i", $file) || preg_match("/\.($video_types)$/i", $file)) {
                            if ('leaves' == $type || 'both' == $type) {
                                $sum++;
                            }
                        } elseif (is_dir($p . '/' . $file)) {
                            if ('nodes' == $type || 'both' == $type) {
                                $sum++;
                            }
                        }
                    } elseif ($d < $distance) {
                        if (is_dir($p . '/' . $file)) {
                            $path_array[] = $p . '/' . $file;

                            $distance_array[] = $d + 1;
                        }
                    }
                }
            }

            return $sum;
        }
  

        return parent::getSubNodeCount($type, $distance);
    }

    /**
     * Returns the subnodes as an array.
     *
     * @param mixed $type
     * @param mixed $distance
     * @param mixed $random
     * @param mixed $limit
     * @return array|\jzMediaNode[]
     * @return array|\jzMediaNode[]
     * @since   5/14/2004
     * @author  Ben Dodson <bdodson@seas.upenn.edu>
     * @version 5/15/2004
     */

    public function getSubNodes($type = 'nodes', $distance = false, $random = false, $limit = 0)
    {
        global $web_root, $root_dir, $media_dir, $audio_types, $video_types;

        $fullpath = $web_root . $root_dir . $media_dir;

        $mypath = $this->getPath('String');

        $fullpath .= '/' . $mypath;

        if (false === $distance) {
            $distance = $this->getNaturalDepth();
        }

        if ($distance >= 0 && $distance <= 1) { // Handle it.
            $arr = [];

            if (0 == $distance || -1 == $distance) {
                return [$this];
            }  

            if (!($handle = opendir($fullpath))) {
                die("Could not access directory $path");
            }

            while ($file = readdir($handle)) {
                if ('.' == $file || '..' == $file) {
                    continue;
                }  

                $newpath = $mypath . '/' . $file;

                if (is_dir($fullpath . '/' . $file) && ('nodes' == $type || 'both' == $type)) {
                    $next = new self($newpath);

                    $ndistance = (-1 == $distance) ? -1 : $distance - 1;

                    $more = $next->getSubNodes($type, $ndistance, $random, $limit);

                    for ($i = 0, $iMax = count($more); $i < $iMax; $i++) {
                        $arr[] = $more[$i];
                    }
                }

                if (preg_match("/\.($audio_types)$/i", $file)
                            || preg_match("/\.($video_types)$/i", $file)) {
                    if ('leaves' == $type || 'both' == $type) {
                        if (1 == $distance || -1 == $distance) {
                            $arr[] = jzMediaTrack($newpath);
                        }
                    }
                }
            }

            if ($random) {
                mt_srand((float)microtime() * 1000000);

                shuffle($arr);
            } else {
                usort($arr, 'compareNodes');
            }

            if ($limit > 0 && $limit < count($arr)) {
                $final = [];

                for ($i = 0; $i < $limit; $i++) {
                    $final[] = $arr[$i];
                }

                return $final;
            }
  

            return $arr;
        }   // use the cache

        return parent::getSubNodes($type, $distance, $random, $limit);
    }

    /**
     * Alphabetical listing of a node.
     *
     * @param mixed $letter
     * @param mixed $distance
     * @return array|\jzMediaNode[]|\jzMediaNodeClass[]|void
     * @return array|\jzMediaNode[]|\jzMediaNodeClass[]|void
     * @author  Ben Dodson <bdodson@seas.upenn.edu>
     * @version 5/14/2004
     * @since   5/14/2004
     */

    public function getAlphabetical($letter, $distance = false)
    {
        global $web_root, $root_dir, $media_dir, $audio_types, $video_types;

        if (false === $distance) {
            $distance = $this->getNaturalDepth();
        }

        $fullpath = $web_root . $root_dir . $media_dir;

        $mypath = $this->getPath('String');

        $fullpath .= '/' . $mypath;

        $name = mb_strtolower($this->getName());

        $letter = mb_strtolower($letter);

        if ($distance >= 0 && $distance <= 1) { // handle it.
            $arr = [];

            if (0 == $distance || -1 == $distance) {
                if ('#' == $letter) {
                    if (!($name[0] >= 'a' && $name[0] <= 'z')) {
                        return [$this];
                    }
                } elseif ('*' == $letter) {
                    return [$this];
                } else {
                    if ($name[0] == $letter) {
                        return [$this];
                    }
                }

                return;
            }  

            if (!($handle = opendir($fullpath))) {
                die("Could not access directory $path");
            }

            while ($file = readdir($handle)) {
                if ('.' == $file || '..' == $file) {
                    continue;
                }  

                $newpath = $mypath . '/' . $file;

                if (is_dir($fullpath . '/' . $file)) {
                    $next = new self($newpath);

                    $ndistance = (-1 == $distance) ? -1 : $distance - 1;

                    $more = $next->getAlphabetical($letter, $ndistance);

                    for ($i = 0, $iMax = count($more); $i < $iMax; $i++) {
                        $arr[] = $more[$i];
                    }
                }

                if (preg_match("/\.($audio_types)$/i", $file)
                            || preg_match("/\.($video_types)$/i", $file)) {
                    if (-1 == $distance || 1 == $distance) {
                        if ('#' == $letter) {
                            if (!($file[0] >= 'a' && $file[0] <= 'z')) {
                                $arr[] = jzMediaTrack($newpath);
                            }
                        } elseif ('*' == $letter) {
                            $arr[] = jzMediaTrack($newpath);
                        } else {
                            if ($file[0] == $letter) {
                                $arr[] = jzMediaTrack($newpath);
                            }
                        }
                    }
                }
            }

            usort($arr, 'compareNodes');

            return $arr;
        }   // It would be too slow. Use the cache.

        return parent::getAlphabetical($letter, $distance);
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Do NOT modify the below: modify overrides.php instead,        *
     * change to jinzora/backend, and run `php global_include.php`   *
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    // begin global_include: overrides.php
    /* * * * * * * * * * * * * * * * * * *
     *            Overrides              *
     * * * * * * * * * * * * * * * * * * */
    // TO ADD: getMainArt(), getDescription()
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
    // TO ADD: getMainArt(), getDescription()
    // end global_include: overrides.php
}

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
 * This page binds the backend to the frontend.
 *
 * @since  05.10.04
 * @author Ross Carlson <ross@jinzora.org>
 */

// First we have to include our files

require_once __DIR__ . '/system.php';
require_once __DIR__ . '/classes.php';
require_once __DIR__ . '/general.php';
require_once __DIR__ . '/id3classes/getid3.php';

// And our backend:
require_once "backend/${backend}/header.php";

// Now we can build library functions.

// a function to compare nodes/tracks for sorting.
function compareNodes($a, $b)
{
    return strnatcasecmp($a->getName(), $b->getName());
}

// returns a blank cache:
/*
 *  NODE:
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
 *   TRACK:
 *      0      1      2       3         4         5          6        7        8           9       10    11    12     13      14     15      16       17       18       19        20
 * [filepath][art][fname][playcount][rating][ratingcount][dateadded][name][frequency][short_desc][desc][year][size][length][genre][artist][album][extension][lyrics][bitrate][tracknum]
 */
function blankCache($type = 'node')
{
    $cache = [];

    if ('node' == $type) {
        for ($i = 0; $i < 12; $i++) {
            $cache[] = '-';
        }

        $cache[3] = $cache[4] = $cache[5] = 0;

        return $cache;
    } elseif ('track' == $type) {
        for ($i = 0; $i < 21; $i++) {
            $cache[] = '-';
        }

        $cache[3] = $cache[4] = $cache[5] = 0;

        return $cache;
    }

    return false;
}

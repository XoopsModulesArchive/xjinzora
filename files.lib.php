<?php
/**
 * - JINZORA | Web-based Media Streamer -
 *
 * Jinzora is a Web-based media streamer, primarily desgined to stream MP3s
 * (but can be used for any media file that can stream from HTTP).
 * Jinzora can be integrated into a CMS site, run as a standalone application,
 * or integrated into any PHP website.  It is released under the GNU GPL.
 *
 * - Ressources -
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
 * This page contains files reading functions
 *
 * @since  02.02.04
 * @author Laurent Perrin <laurent@la-base.org>
 * @param mixed $type
 * @param mixed $callback
 * @param mixed $nb
 * @param mixed $sort
 * @param mixed $filter
 */

/**
 * Process all data files of the given type through the given callback, eventually sorting them and croping the results to a given number.
 *
 * @param string  $type     Type of file to look into. Valid values are : 'counter', 'ratings', 'discussions', 'tracks'. Return false if any other values are used.
 * @param string  $callback Callback to be applyed to each file. Take the filename as only parameter.
 * @param int $nb       Optional, how many results should be returned maximum. Default to everything (-1).
 * @param int $sort     Optional, 1 to sort forward, -1 to sort reverse or 0 to leave as read. Defaults to reverse (-1).
 * @param string  $filter   Optional, Should we filter the results to a specific genre?
 * @return array array of filenames as keys and callback return as values. empty array if nothing have been found
 * @author  Laurent Perrin
 * @version 02/02/04
 * @since   02/02/04
 */
function processDataFiles($type, $callback, $nb = -1, $sort = -1, $filter = '')
{
    global $web_root, $root_dir;

    // Ok, if $nb is NOT -1 let's double it

    // so we can be sure we get enough records back

    if (-1 != $nb) {
        $nb += $nb;
    }

    // let's figure out where to take the data

    switch ($type) {
        case 'counter':
            $dir = '/data/counter';
            $ext = '.ctr';
            break;
        case 'ratings':
            $dir = '/data/ratings';
            $ext = '.rating';
            break;
        case 'discussions':
            $dir = '/data/discussions';
            $ext = '.disc';
            break;
        case 'tracks':
            $dir = '/data/tracks';
            $ext = '.xml';
            break;
        case 'download':
            $dir = '/data/counter';
            $ext = '.dwn';
            break;
        default:
            // error in $type arg
            return false;
    } // switch

    // gets file list

    $ctrArray = readDirInfo($web_root . $root_dir . $dir, 'file');

    // Ok, now let's read and process each file

    foreach ($ctrArray as $filename) {
        if ('' != $filename and mb_stristr($filename, $ext)) {
            if ('' == $filter) {
                $finalArray[str_replace('---', '/', str_replace($ext, '', $filename))] = $callback($web_root . $root_dir . $dir . '/' . $filename);
            } else {
                if (mb_stristr(mb_strtolower($filename), mb_strtolower($filter))) {
                    $finalArray[str_replace('---', '/', str_replace($ext, '', $filename))] = $callback($web_root . $root_dir . $dir . '/' . $filename);
                }
            }
        }
    }

    // sort & return the desired number of results

    if (isset($finalArray)) {
        if (-1 == $sort) {
            arsort($finalArray);
        } elseif (1 == $sort) {
            asort($finalArray);
        }

        return -1 == $nb ? $finalArray : array_slice($finalArray, 0, $nb);
    }

    // false if nothing have been found

    return [];
}

/**
 * Process media files in the given directory through the given callback, eventually sorting them and croping the results to a given number.
 *
 * @param string  $dir      Dorectory to look in
 * @param string  $callback Callback to be applyed to each file. Take the filename as only parameter.
 * @param int $nb       Optional, how many results should be returned maximum. Default to everything (-1).
 * @param int $sort     Optional, 1 to sort forward, -1 to sort reverse or 0 to leave as read. Defaults to reverse (-1).
 * @return array array of filenames as keys and callback return as values. empty array if nothing have been found
 * @since   04/02/04
 * @author  Laurent Perrin
 * @version 04/02/04
 */
function processMediaFiles($dir, $callback, $nb = -1, $sort = -1)
{
    global $web_root, $root_dir, $media_dir, $audio_types, $video_types;

    $full_dir = $web_root . $root_dir . $media_dir . '/' . $dir . '/';

    // gets file list

    $ctrArray = readDirInfo($full_dir, 'file');

    // Ok, now let's read and process each file

    foreach ($ctrArray as $filename) {
        if (('.' != $filename[0]) && (preg_match("/\.($audio_types)$/i", $filename) || preg_match("/\.($video_types)$/i", $filename))) {
            $finalArray[$dir . '/' . $filename] = $callback($full_dir . $filename);
        }
    }

    // sort & return the desired number of results

    if (isset($finalArray)) {
        if (-1 == $sort) {
            arsort($finalArray);
        } elseif (1 == $sort) {
            asort($finalArray);
        }

        return -1 == $nb ? $finalArray : array_slice($finalArray, 0, $nb);
    }

    // false if nothing have been found

    return [];
}

/**
 * Reads the number of time a track as been discussed in the discussion file.
 *
 * @param string $filename dicussion file name
 * @return Number of time this track as been discussed
 * @since   02/02/04
 * @author  Laurent Perrin
 * @version 02/02/04
 */
function getDiscussNb($filename)
{
    $file = fopen($filename, 'rb');

    $contents = fread($file, filesize($filename));

    fclose($file);

    return substr_count($contents, '|END') + 1 - 1;
}

/**
 * Reads the number of time a track as been rated in the rating file.
 *
 * @param string $filename rate file name
 * @return Number of time this track as been rated
 * @since   02/02/04
 * @author  Laurent Perrin
 * @version 02/02/04
 */
function getRateNb($filename)
{
    return count(file($filename));
}

/**
 * Reads the rate for a track in the rating file.
 *
 * @param string $filename rate file name
 * @return Number of time this track as been rated
 * @since   02/02/04
 * @author  Laurent Perrin
 * @version 02/02/04
 */
function getRate($filename)
{
    $rating = 0;

    $rateArray = file($filename);

    foreach ($rateArray as $rate) {
        $numArray = explode('|', $rate);

        $rating += $numArray[1];
    }

    return $rating / count($rateArray);
}

/**
 * Gets the modification time for a file
 *
 * @param string $filename filename
 * @return false|int modification time, formated with $date_format
 * @since   02/02/04
 * @author  Laurent Perrin
 * @version 02/19/04
 */
function getMTime($filename)
{
    return filemtime($filename);
}

/**
 * Gets the number of time a track has been played
 *
 * @param string $filename counter file name
 * @return Number of time the track has been played
 * @since   02/02/04
 * @author  Laurent Perrin
 * @version 02/02/04
 */
function getNbPlay($filename)
{
    $counter = file($filename);

    return $counter[0];
}

/**
 * Gets track XML filename from genre, artist, and album
 *
 * @param string $genre  genre
 * @param string $artist artist
 * @param string $album  album
 * @return xml file name
 *                       *@version 02/02/04
 * @since  02/02/04
 * @author Laurent Perrin
 */
function xmlFileFromGAA($genre = 'NULL', $artist = 'NULL', $album = 'NULL')
{
    global $web_root, $root_dir;

    return "$web_root$root_dir/data/tracks/$genre---$artist---$album.xml";
}

/**
 * Gets track XML filename from track filename
 *
 * @param string $track track filename
 * @return string xml file name
 *                      *@since 02/02/04
 * @author  Laurent Perrin
 * @version 02/02/04
 */
function xmlFileFromTrack($track)
{
    global $directory_level, $web_root, $root_dir, $media_dir;

    // get directories from filename

    $dirs = explode('/', dirname($track));

    unset($dirs[count($dirs)]);

    /* Now let's set for 1, 2, or 3 level directory structure */

    switch ($directory_level) {
        case '3': # 3 directories deep
            $genre = $dirs[0] ?? 'NULL';
            if (!isset($dirs[2])) {
                if (0 != count(readDirInfo(dirname("$web_root$root_dir$media_dir/$track"), 'dir'))) {
                    $artist = $dirs[1] ?? 'NULL';

                    $album = 'NULL';
                } else {
                    $artist = 'NULL';

                    $album = $dirs[1] ?? 'NULL';
                }
            } else {
                $artist = $dirs[1];

                $album = $dirs[2];
            }
            break;
        case '2': # 2 directories deep
            $genre = 'NULL';
            if (!isset($dirs[1])) {
                if (0 != count(readDirInfo(dirname("$web_root$root_dir$media_dir/$track"), 'dir'))) {
                    $artist = $dirs[0] ?? 'NULL';

                    $album = 'NULL';
                } else {
                    $artist = 'NULL';

                    $album = $dirs[0] ?? 'NULL';
                }
            } else {
                $artist = $dirs[0];

                $album = $dirs[1];
            }
            break;
        case '1': # 2 directories deep
            $genre = 'NULL';
            $artist = 'NULL';
            $album = $dirs[0] ?? 'NULL';

            break;
    }

    if ('.' == $genre) {
        //var_dump(debug_backtrace());
    }

    return xmlFileFromGAA($genre, $artist, $album);
}

/**
 * Gets directory from track XML filename
 *
 * @param string $xmlFile xml file name
 * @return string directory (absolute path)
 *                        *@since 04/02/04
 * @author  Laurent Perrin
 * @version 04/02/04
 */
function dirFromXMLFile($xmlFile)
{
    global $web_root, $root_dir, $media_dir;

    $dirs = explode('---', str_replace('NULL', '', basename(mb_substr($xmlFile, 0, -4))));

    if ('' == $dirs[0]) {
        return "$web_root$root_dir$media_dir";
    }

    if ('' == $dirs[1]) {
        if ('' == $dirs[2]) {
            return "$web_root$root_dir$media_dir/" . $dirs[0];
        }
  

        return "$web_root$root_dir$media_dir/" . $dirs[0] . '/' . $dirs[2];
    }

    if ('' == $dirs[2]) {
        return "$web_root$root_dir$media_dir/" . $dirs[0] . '/' . $dirs[1];
    }

    return "$web_root$root_dir$media_dir/" . $dirs[0] . '/' . $dirs[1] . '/' . $dirs[2];
}

/**
 * Gets track informations
 *
 * @param array $tracks trakc filename (with path)
 * @return array array with filenames (with path) as keys and informations as values
 *                      *@since 02/02/04
 * @author  Laurent Perrin
 * @version 02/02/04
 */
function getTracksInfos($tracks)
{
    foreach ($tracks as $track) {
        $rawTracksInfos = getTracksInfosFromXML(xmlFileFromTrack($track));

        if (isset($rawTracksInfos[basename($track)])) {
            $tracksInfos[$track] = $rawTracksInfos[basename($track)];
        }
    }

    return $tracksInfos ?? null;
}

/**
 * Gets all tracks informations from the given xml file
 *
 * @param string $xmlFile xml file name
 * @param mixed  $checkFile
 * @param mixed  $returnAllData
 * @param mixed  $albumImageOnly
 * @return void|null array with filenames (without path) as keys and informations as values
 *                        *@since 02/02/04
 * @author  Laurent Perrin
 * @version 02/02/04
 */
function getTracksInfosFromXML($xmlFile, $checkFile = true, $returnAllData = true, $albumImageOnly = false)
{
    global $web_root, $root_dir, $media_dir;

    // First let's see if they wanted to check the file or not

    if ($checkFile) {
        checkXMLFile(dirFromXMLFile($xmlFile), $xmlFile);
    }

    // Now let's make sure that file exists

    if (!is_file($xmlFile)) {
        return;
    }

    // Now let's open our XML file and parse it manually

    $handle = fopen($xmlFile, 'rb');

    $cache_data = fread($handle, filesize($xmlFile));

    fclose($handle);

    // Now let' strip the first 2 lines off of it...

    $cache_data = mb_substr($cache_data, mb_strpos($cache_data, '<track ext='), mb_strlen($cache_data));

    // Now let's strip off the </track> just to make it easier

    $cache_data = str_replace('</track>', '', $cache_data);

    // Now let's put that in an array

    $retArray = explode('<track', $cache_data);

    // Now let's populate our table with all the songs

    foreach ($retArray as $ret) {
        // Ok, now let's break that apart by line

        // Yes, Joel hates this but it works!!!

        // If you want to make it better, please do!

        $xmlArray = explode("\n", $ret);

        if (count($xmlArray) > 6) {
            // Now let's figure out all the data

            // This is the standard data that we will always retrun

            // We filter this below to speed up searching

            $filename = trim(str_replace('</filename>', '', str_replace('<filename>', '', $xmlArray[2])));

            $track_name = trim(str_replace('</name>', '', str_replace('<name>', '', $xmlArray[1])));

            $track_path = $tracksinfos[$filename]['path'] = trim(str_replace('</path>', '', str_replace('<path>', '', $xmlArray[3])));

            $fileExt = mb_substr($xmlArray[0], mb_strpos($xmlArray[0], 'ext="') + 5, mb_strlen($xmlArray[0]));

            $fileExt = mb_substr($fileExt, 0, mb_strpos($fileExt, '">'));

            $track_date = trim(str_replace('</date>', '', str_replace('<date>', '', $xmlArray[5])));

            $mp3_comment = trim(str_replace('</desc>', '', str_replace('<desc>', '', $xmlArray[7])));

            $mp3_comment = str_replace('<![CDATA[', '', $mp3_comment);

            $mp3_comment = str_replace(']]>', '', $mp3_comment);

            $long_desc = trim(str_replace('</longdesc>', '', str_replace('<longdesc>', '', $xmlArray[8])));

            $long_desc = str_replace('<![CDATA[', '', $long_desc);

            $long_desc = str_replace(']]>', '', $long_desc);

            $track_number = trim(str_replace('</number>', '', str_replace('<number>', '', $xmlArray[9])));

            $track_rate = trim(str_replace('</rate>', '', str_replace('<rate>', '', $xmlArray[10])));

            $track_freq = trim(str_replace('</freq>', '', str_replace('<freq>', '', $xmlArray[11])));

            $track_size = trim(str_replace('</size>', '', str_replace('<size>', '', $xmlArray[12])));

            $track_length = trim(str_replace('</length>', '', str_replace('<length>', '', $xmlArray[13])));

            $track_year = trim(str_replace('</year>', '', str_replace('<year>', '', $xmlArray[14])));

            $lyrics = trim(str_replace(']]></lyrics>', '', str_replace('<lyrics><![CDATA[', '', $xmlArray[15])));

            if ('' == $lyrics) {
                $lyrics = '-';
            }

            $trackData = str_replace('.xml', '', str_replace($web_root . $root_dir . '/data/tracks/', '', $xmlFile));

            $trackDataArray = explode('---', $trackData);

            $track_genre = $trackDataArray[count($trackDataArray) - 3];

            $track_artist = $trackDataArray[count($trackDataArray) - 2];

            $track_album = $trackDataArray[count($trackDataArray) - 1];

            // Now let's get the length in seconds

            if ('-' != $track_length) {
                $length_seconds = convertMinsSecs($track_length);
            } else {
                $length_seconds = '-';
            }

            // Now let's set the array data

            $tracksinfos[$filename]['filename'] = $filename;

            $tracksinfos[$filename]['name'] = $track_name;

            $tracksinfos[$filename]['path'] = $track_path;

            $tracksinfos[$filename]['fileExt'] = $fileExt;

            $tracksinfos[$filename]['date'] = $track_date;

            $tracksinfos[$filename]['mp3_comment'] = $mp3_comment;

            $tracksinfos[$filename]['long_desc'] = $long_desc;

            $tracksinfos[$filename]['number'] = $track_number;

            $tracksinfos[$filename]['rate'] = $track_rate;

            $tracksinfos[$filename]['freq'] = $track_freq;

            $tracksinfos[$filename]['size'] = $track_size;

            $tracksinfos[$filename]['length'] = $track_length;

            $tracksinfos[$filename]['year'] = $track_year;

            $tracksinfos[$filename]['genre'] = $track_genre;

            $tracksinfos[$filename]['artist'] = $track_artist;

            $tracksinfos[$filename]['album'] = $track_album;

            $tracksinfos[$filename]['length_seconds'] = $length_seconds;

            $tracksinfos[$filename]['lyrics'] = $lyrics;

            // Let's only get this data if they wanted it

            // We don't return this for seaching to make it faster

            if ($returnAllData) {
                $track_thumb = trim(str_replace('</thumbnail>', '', str_replace('<thumbnail>', '', $xmlArray[4])));

                $track_counter = returnCounter($web_root . $tracksinfos[$filename]['path']);

                $track_downloads = returnCounter($web_root . $tracksinfos[$filename]['path'], 'dwn');

                $track_rating = readRating($web_root . $root_dir . '/data/ratings/' . returnFormatedFilename(str_replace($root_dir . $media_dir . '/', '', $tracksinfos[$filename]['path'])) . '.rating');

                $last_played_user = returnCounter($web_root . $tracksinfos[$filename]['path'], 'ctr', 'true');

                $rateVotes = returnVotes($web_root . $root_dir . '/data/ratings/' . returnFormatedFilename(str_replace($root_dir . $media_dir . '/', '', $tracksinfos[$filename]['path'])) . '.rating');

                $discVotes = returnVotes($web_root . $root_dir . '/data/discussions/' . returnFormatedFilename(str_replace($root_dir . $media_dir . '/', '', $tracksinfos[$filename]['path'])) . '.disc');

                $tracksinfos[$filename]['thumbnail'] = $track_thumb;

                $tracksinfos[$filename]['counter'] = $track_counter;

                $tracksinfos[$filename]['lastplayeduser'] = $last_played_user;

                $tracksinfos[$filename]['downloads'] = $track_downloads;

                $tracksinfos[$filename]['rating'] = $track_rating;

                $tracksinfos[$filename]['rateVotes'] = $rateVotes;

                $tracksinfos[$filename]['discVotes'] = $discVotes;
            }
        }
    }

    return $tracksinfos ?? null;
}

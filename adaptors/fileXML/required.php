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
 * This page contains the necessary functions to return media data to Jinzora
 *
 * @since  05.03.04
 * @author Ross Carlson <ross@jinzora.org>
 * @param mixed $level
 */

/**
 * retun an array with the data for the featured album
 *
 * @param string $level
 * @return array Returns a keyed array with the data for the featured album
 * @version 05.03.04
 * @since   05.03.04
 * @author  Ross Carlson
 */
function returnFeaturedAlbum($level = '')
{
    global $web_root, $root_dir, $media_dir;

    // First let's grab a featured artist from the folder

    $fileArray = readDirInfo($web_root . $root_dir . '/data/featured/albums', 'file');

    // Now let's make sure we got data back

    if (0 == count($fileArray)) {
        return null;
    }

    // Ok, let's strip out any non .xml files

    for ($c = 0, $cMax = count($fileArray); $c < $cMax; $c++) {
        if (mb_stristr($fileArray[$c], '.xml')) {
            $nextArray[] = $fileArray[$c];
        }
    }

    unset($fileArray);

    $fileArray = $nextArray;

    // Now let's make sure we didn't need to filter based on where we are

    if ('' != $level) {
        unset($nextArray);

        for ($c = 0, $cMax = count($fileArray); $c < $cMax; $c++) {
            // Ok, now let's filter if we need to

            if (mb_stristr($fileArray[$c], $level . '---')) {
                $nextArray[] = $fileArray[$c];
            }
        }

        unset($fileArray);

        $fileArray = $nextArray;
    }

    // Now let's make sure we got data back

    if (0 == count($fileArray)) {
        return null;
    }

    // Now let's randomize it

    shuffle($fileArray);

    // Now let's grab the first one as our XML file

    $xmlFile = $web_root . $root_dir . '/data/featured/albums/' . $fileArray[0];

    // Now let's get the album data

    $image = '';

    // Ok, now we need to process that file

    $handle = fopen($xmlFile, 'rb');

    $contents = fread($handle, filesize($xmlFile));

    fclose($handle);

    // Now let's read the data from the XML file

    // First let's strip up to the real data

    $contents = mb_substr($contents, mb_strpos($contents, '">') + 2);

    // Now let's get the album data first

    $searchVals = 'genre|artist|album|image|albumDesc';

    $searchArray = explode('|', $searchVals);

    for ($e = 0, $eMax = count($searchArray); $e < $eMax; $e++) {
        $$searchArray[$e] = str_replace(
            ']]>',
            '',
            str_replace(
                '<![CDATA[',
                '',
                mb_substr($contents, mb_strpos($contents, '<' . $searchArray[$e] . '>') + mb_strlen('<' . $searchArray[$e] . '>'), mb_strpos($contents, '</' . $searchArray[$e] . '>') - (mb_strpos($contents, '<' . $searchArray[$e] . '>') + mb_strlen('<' . $searchArray[$e] . '>')))
            )
        );
    }

    // Now let's make an arry we can loop through with the track data, first we'll strip all the album info

    $contents = mb_substr($contents, mb_strpos($contents, '</albumInfo>') + mb_strlen('</albumInfo>'));

    $dataArray = explode('</track>', $contents);

    // Now let's set the search vals

    $searchVals = 'name|filename|path|thumbnail|date|desc|longdesc|number|rate|freq|size|length|year|lyrics';

    $searchArray = explode('|', $searchVals);

    // Now let's get the data

    $i = 0;

    for ($c = 0, $cMax = count($dataArray); $c < $cMax; $c++) {
        // Let's make sure there is data

        if (mb_stristr($dataArray[$c], '<track')) {
            // First we need to get the extension differently

            $trackExt = mb_substr($dataArray[$c], mb_strpos($dataArray[$c], '<track ext="') + 12, mb_strpos($dataArray[$c], '">') - (mb_strpos($dataArray[$c], '<track ext="') + 12));

            // Now let's parse it all out in a loop

            for ($e = 0, $eMax = count($searchArray); $e < $eMax; $e++) {
                // Now let's return them one by one

                $retArray[$c][$searchArray[$e]] = str_replace(
                    ']]>',
                    '',
                    str_replace(
                        '<![CDATA[',
                        '',
                        mb_substr(
                            $dataArray[$c],
                            mb_strpos($dataArray[$c], '<' . $searchArray[$e] . '>') + mb_strlen('<' . $searchArray[$e] . '>'),
                            mb_strpos($dataArray[$c], '</' . $searchArray[$e] . '>') - (mb_strpos($dataArray[$c], '<' . $searchArray[$e] . '>') + mb_strlen('<' . $searchArray[$e] . '>'))
                        )
                    )
                );

                // Now let's set the ablum data too

                $retArray[$c]['genre'] = $genre;

                $retArray[$c]['artist'] = $artist;

                $retArray[$c]['album'] = $album;

                $retArray[$c]['image'] = $image;

                $retArray[$c]['albumDesc'] = $albumDesc;

                $retArray[$c]['trackExt'] = $trackExt;
            }
        }
    }

    return $retArray;
}

/**
 * retun an array with the data for the featured artist
 *
 * @version 05.03.04
 * @since   05.03.04
 * @author  Ross Carlson
 * @param mixed $level
 * @return array Returns a keyed array of data about a featured artist
 */
function returnFeaturedArtist($level = '')
{
    global $web_root, $root_dir, $media_dir;

    // First let's grab a featured artist from the folder

    $fileArray = readDirInfo($web_root . $root_dir . '/data/featured/artists', 'file');

    // Now let's make sure we got data back

    if (0 == count($fileArray)) {
        return null;
    }

    // Ok, let's strip out any non .xml files

    for ($c = 0, $cMax = count($fileArray); $c < $cMax; $c++) {
        if (mb_stristr($fileArray[$c], '.xml')) {
            $nextArray[] = $fileArray[$c];
        }
    }

    unset($fileArray);

    $fileArray = $nextArray;

    // Now let's make sure we didn't need to filter based on where we are

    if ('' != $level) {
        unset($nextArray);

        for ($c = 0, $cMax = count($fileArray); $c < $cMax; $c++) {
            // Ok, now let's filter if we need to

            if (mb_stristr($fileArray[$c], $level . '---')) {
                $nextArray[] = $fileArray[$c];
            }
        }

        unset($fileArray);

        $fileArray = $nextArray;
    }

    // Now let's make sure we got data back

    if (0 == count($fileArray)) {
        return null;
    }

    // Now let's randomize it

    shuffle($fileArray);

    // Now let's grab the first one as our XML file

    $xmlFile = $web_root . $root_dir . '/data/featured/artists/' . $fileArray[0];

    // Ok, now we need to process that file

    $handle = fopen($xmlFile, 'rb');

    $contents = fread($handle, filesize($xmlFile));

    fclose($handle);

    // Now let's get the data out of it

    // First let's move up to the real data

    $contents = mb_substr($contents, mb_strpos($contents, '">'));

    // Now let's get the info about the artist

    $searchVals = 'genre|artist|artistImage|artistDesc|artistRating';

    $searchArray = explode('|', $searchVals);

    for ($e = 0, $eMax = count($searchArray); $e < $eMax; $e++) {
        $$searchArray[$e] = str_replace(
            ']]>',
            '',
            str_replace(
                '<![CDATA[',
                '',
                mb_substr($contents, mb_strpos($contents, '<' . $searchArray[$e] . '>') + mb_strlen('<' . $searchArray[$e] . '>'), mb_strpos($contents, '</' . $searchArray[$e] . '>') - (mb_strpos($contents, '<' . $searchArray[$e] . '>') + mb_strlen('<' . $searchArray[$e] . '>')))
            )
        );
    }

    // Now let's get the info about each album

    $contents = mb_substr($contents, mb_strpos($contents, '<album name='));

    $dataArray = explode('</album>', $contents);

    $searchVals = 'shortname|year|image|rating';

    $searchArray = explode('|', $searchVals);

    for ($c = 0, $cMax = count($dataArray); $c < $cMax; $c++) {
        // Let's make sure there is data

        if (mb_stristr($dataArray[$c], '<album')) {
            // First we need to get the extension differently

            $albumName = mb_substr($dataArray[$c], mb_strpos($dataArray[$c], '<album name="') + 13, mb_strpos($dataArray[$c], '">') - (mb_strpos($dataArray[$c], '<album name="') + 13));

            // Now let's parse it all out in a loop

            for ($e = 0, $eMax = count($searchArray); $e < $eMax; $e++) {
                // Now let's return them one by one

                $retArray[$c][$searchArray[$e]] = str_replace(
                    ']]>',
                    '',
                    str_replace(
                        '<![CDATA[',
                        '',
                        mb_substr(
                            $dataArray[$c],
                            mb_strpos($dataArray[$c], '<' . $searchArray[$e] . '>') + mb_strlen('<' . $searchArray[$e] . '>'),
                            mb_strpos($dataArray[$c], '</' . $searchArray[$e] . '>') - (mb_strpos($dataArray[$c], '<' . $searchArray[$e] . '>') + mb_strlen('<' . $searchArray[$e] . '>'))
                        )
                    )
                );

                // Now let's set the ablum data too

                $retArray[$c]['genre'] = $genre;

                $retArray[$c]['artist'] = $artist;

                $retArray[$c]['artistImage'] = $artistImage;

                $retArray[$c]['artistDesc'] = $artistDesc;

                $retArray[$c]['artistRating'] = $artistRating;

                $retArray[$c]['albumName'] = $albumName;
            }
        }
    }

    // Now let's return the data

    return $retArray;
}

/**
 * retun the number of artists
 *
 * @return int an integer with the number of artists
 * @version 05.03.04
 * @since   05.03.04
 * @author  Ross Carlson
 */
function returnNumAlbums()
{
    $ctr = count(returnAlbumList()) - 1;

    if ($ctr > 0) {
        return $ctr;
    }
  

    return 0;
}

/**
 * retun the number of artists
 *
 * @return int an integer with the number of artists
 * @version 05.03.04
 * @since   05.03.04
 * @author  Ross Carlson
 */
function returnNumArtists()
{
    $ctr = count(returnArtistList()) - 1;

    if ($ctr > 0) {
        return $ctr;
    }
  

    return 0;
}

/**
 * retun the number of genres
 *
 * @return int an integer with the number of genres
 * @version 05.03.04
 * @since   05.03.04
 * @author  Ross Carlson
 */
function returnNumGenres()
{
    $ctr = count(returnGenreList()) - 1;

    if ($ctr > 0) {
        return $ctr;
    }
  

    return 0;
}

/**
 * retun ALL genres in an array
 *
 * @return false|string[]|null an array with ALL genres
 * @version 05.03.04
 * @since   05.03.04
 * @author  Ross Carlson
 */
function returnGenreList()
{
    $retArray = explode("\n", urldecode($_SESSION['genre_list']));

    if (0 != count($retArray)) {
        sort($retArray);

        return $retArray;
    }
  

    return null;
}

/**
 * retun ALL artists in an array
 *
 * @version 05.03.04
 * @since   05.03.04
 * @author  Ross Carlson
 */
function returnArtistList()
{
    $retArray = explode("\n", urldecode($_SESSION['artist_list']));

    if (0 != count($retArray)) {
        sort($retArray);

        return $retArray;
    }
  

    return null;
}

/**
 * retun ALL albums in an array
 *
 * @version 05.03.04
 * @since   05.03.04
 * @author  Ross Carlson
 */
function returnAlbumList()
{
    $retArray = explode("\n", urldecode($_SESSION['album_list']));

    if (0 != count($retArray)) {
        sort($retArray);

        return $retArray;
    }
  

    return null;
}

/**
 * retun ALL tracks in an array
 *
 * @version 05.03.04
 * @since   05.03.04
 * @author  Ross Carlson
 */
function returnTrackList()
{
    $retArray = explode("\n", urldecode($_SESSION['complete_list']));

    if (0 != count($retArray)) {
        sort($retArray);

        return $retArray;
    }
  

    return null;
}

/**
 * retun the data from the Artist XML file into a keyed array
 *
 * @param string $xmlFile the name of the XML file to generate
 * @return mixed
 * @return mixed
 * @since   05.03.04
 * @author  Ross Carlson
 * @version 05.03.04
 */
function returnArtistData($xmlFile)
{
    global $web_root, $root_dir;

    // Ok, first we need to open the XML File and read it

    $handle = fopen($xmlFile, 'rb');

    $contents = fread($handle, filesize($xmlFile));

    fclose($handle);

    // Now let's see if there is a user exclude file

    if (isset($_COOKIE['jz_user_name'])) {
        // Ok, now let's see if they have any personal exclude files or not

        $exclude_file = $web_root . $root_dir . '/data/' . $_COOKIE['jz_user_name'] . '-exclude.lst';

        $personalExcludeArray = readExcludeFile($exclude_file);
    }

    // Now let's see if there is a global exclude file and read it

    $exclude_file = $web_root . $root_dir . '/data/global-exclude.lst';

    // Now let's make sure that file exists

    if (is_file($exclude_file)) {
        $globalExcludeArray = readExcludeFile($exclude_file);

        // Now let's merge the two arrays

        $excludeArray = array_merge($personalExcludeArray, $globalExcludeArray);
    }

    // Ok, now we need to parse this all out

    $contents = mb_substr($contents, mb_strpos($contents, '<album'), mb_strlen($contents));

    $contents = str_replace('</jzCache>', '', $contents);

    // Now let's create an array out of

    $albumArray = explode('</album>', $contents);

    // Now let's loop through that array getting the data out

    for ($i = 0, $iMax = count($albumArray); $i < $iMax; $i++) {
        $album_name = mb_substr($albumArray[$i], mb_strpos($albumArray[$i], '="') + 2, mb_strlen($albumArray[$i]));

        $album_name = mb_substr($album_name, 0, mb_strpos($album_name, '">'));

        $short_name = mb_substr($albumArray[$i], mb_strpos($albumArray[$i], '<shortname>') + 11, mb_strlen($albumArray[$i]));

        $short_name = mb_substr($short_name, 0, mb_strpos($short_name, '</'));

        $year = mb_substr($albumArray[$i], mb_strpos($albumArray[$i], '<year>') + 6, mb_strlen($albumArray[$i]));

        $year = mb_substr($year, 0, mb_strpos($year, '</'));

        $image = mb_substr($albumArray[$i], mb_strpos($albumArray[$i], '<image>') + 7, mb_strlen($albumArray[$i]));

        $image = mb_substr($image, 0, mb_strpos($image, '</'));

        $rating = mb_substr($albumArray[$i], mb_strpos($albumArray[$i], '<rating>') + 8, mb_strlen($albumArray[$i]));

        $rating = mb_substr($rating, 0, mb_strpos($rating, '</'));

        // Now let's make sure none of this should be excluded

        $exclude_item = false;

        if (isset($excludeArray)) {
            for ($e = 0, $eMax = count($excludeArray); $e < $eMax; $e++) {
                // Now let's make sure there isn't a match

                if ('' != $excludeArray[$e]) {
                    if (mb_stristr($excludeArray[$e], $album_name) or mb_stristr($excludeArray[$e], $short_name)) {
                        $exclude_item = true;
                    }
                }
            }
        }

        // Now let's set the array with the data above

        if (false === $exclude_item) {
            $dataArray[$i]['name'] = $album_name;

            $dataArray[$i]['short_name'] = $short_name;

            $dataArray[$i]['year'] = $year;

            $dataArray[$i]['image'] = $image;

            $dataArray[$i]['rating'] = $rating;
        }
    }

    return $dataArray;
}

/**
 * This will check to see if we there is a artist XML file, and if it needs to be updated or not
 *
 * @param string $dirToLookIn Where to look for the data
 * @param string $xmlFile     the name of the XML file to generate
 * @since   05.03.04
 * @author  Ross Carlson
 * @version 05.03.04
 */
function checkArtistXMLFile($dirToLookIn, $xmlFile)
{
    // First let's see if that file even exists yet

    if (!is_file($xmlFile)) {
        // Ok, it doesn't exist, so let's create it

        createArtistXMLFile($dirToLookIn, $xmlFile);
    } else {
        // Ok, it did exist, let's get the current hash and compare the two

        $hashData = filemtime(jzstripslashes($dirToLookIn));

        // Now let's generate the current hash

        $cur_hash = md5($hashData);

        // Now let's read the old hash from the file

        $handle = fopen($xmlFile, 'rb');

        $data = fread($handle, filesize($xmlFile));

        fclose($handle);

        // Now let's parse out the hash

        $old_hash = mb_substr($data, mb_strpos($data, 'hash="') + 6, mb_strlen($data));

        $old_hash = mb_substr($old_hash, 0, mb_strpos($old_hash, '"'));

        // Now let's compare the two hashes

        if ($old_hash != $cur_hash) {
            createArtistXMLFile($dirToLookIn, $xmlFile);
        }
    }
}

/**
 * create the XML file for the artist
 *
 * @param string $dirToLookIn Where to look for the data
 * @param string $xmlFile     the name of the XML file to generate
 * @since   05.03.04
 * @author  Ross Carlson
 * @version 05.03.04
 */
function createArtistXMLFile($dirToLookIn, $xmlFile)
{
    global $album_name_truncate, $sort_by_year, $video_types, $audio_types, $ext_graphic, $root_dir, $media_dir, $genre, $artist, $web_root, $root_dir;

    // Ok, let's start getting all the data

    $retArray = readDirInfo($dirToLookIn, 'dir');

    // Now let's set the hash data

    $hashData = filemtime(jzstripslashes($dirToLookIn));

    // Now let's figure out some information from this item

    $infoArray = explode('---', str_replace('.xml', '', str_replace($web_root . $root_dir . '/data/artists/', '', $xmlFile)));

    $artist = $infoArray[count($infoArray) - 1];

    $genre = $infoArray[count($infoArray) - 2];

    // Now let's see if there is a description for this artist

    $desc_file = $web_root . $root_dir . $media_dir . '/' . $genre . '/' . $artist . '/' . $artist . '.txt';

    if (is_file($desc_file) and 0 != filesize($desc_file)) {
        $handle = fopen($desc_file, 'rb');

        $artistDesc = fread($handle, filesize($desc_file));

        fclose($handle);
    } else {
        $artistDesc = '';
    }

    // Now let's look for artist art

    $artArray = readDirInfo($dirToLookIn, 'file');

    $artistImage = '';

    for ($i = 0, $iMax = count($artArray); $i < $iMax; $i++) {
        if (preg_match("/\.($ext_graphic)$/i", $artArray[$i])) {
            $artistImage = str_replace($web_root, '', $dirToLookIn . '/' . $artArray[$i]);
        }
    }

    // Now let's see if the artist is rated

    $artistRating = '';

    for ($i = 0, $iMax = count($retArray); $i < $iMax; $i++) {
        // now let's set the album long name

        $album_long_name = $retArray[$i];

        // Now let's set the album short name

        if (mb_strlen($retArray[$i]) > $album_name_truncate) {
            $album_short_name = mb_substr($retArray[$i], 0, $album_name_truncate) . '...';
        } else {
            $album_short_name = $retArray[$i];
        }

        // Now let's get the album year, if they have that enabled

        $album_year = '';

        //First we'll need to read the file names in the album

        $yearArray = readDirInfo($dirToLookIn . '/' . $retArray[$i], 'file');

        $album_year_found = false;

        $album_image = '';

        for ($c = 0, $cMax = count($yearArray); $c < $cMax; $c++) {
            // Let's make sure this is an audio or video type

            if ((preg_match("/\.($audio_types)$/i", $yearArray[$c]) or preg_match("/\.($video_types)$/i", $yearArray[$c])) and 'true' == $sort_by_year and false === $album_year_found) {
                $getID3 = new getID3();

                $fileInfo = $getID3->analyze($dirToLookIn . '/' . $retArray[$i] . '/' . $yearArray[$c]);

                getid3_lib::CopyTagsToComments($fileInfo);

                if (!empty($fileInfo['comments']['year'][0])) {
                    $album_year = $fileInfo['comments']['year'][0];
                }

                // Ok, if we found a year let's stop

                if ('' != $album_year) {
                    $album_year_found = true;
                }

                unset($getID3);
            }

            // Ok, now let's see if we found album art or not and make sure it's not a thumbnail

            if (preg_match("/\.($ext_graphic)$/i", $yearArray[$c]) and !mb_stristr($yearArray[$c], '.thumb.')) {
                $album_image = str_replace($web_root, '', $dirToLookIn) . '/' . $retArray[$i] . '/' . $yearArray[$c];
            }
        }

        // Now let's get the rating for this time

        $ratingFile = $genre . '---' . $artist . '---' . $retArray[$i] . '.rating';

        while ('---' == mb_substr($ratingFile, 0, 3)) {
            $ratingFile = mb_substr($ratingFile, 3, mb_strlen($ratingFile));
        }

        $ratingFile = $web_root . $root_dir . '/data/ratings/' . $ratingFile;

        $rating = readRating($ratingFile);

        // Now let's put this in an array so we can sort by year or title

        if ('true' == $sort_by_year) {
            $xmlArray[] = $album_year . '|||' . $album_long_name . '|||' . $album_short_name . '|||' . $album_image . '|||' . $rating;
        } else {
            $xmlArray[] = $album_long_name . '|||' . $album_year . '|||' . $album_short_name . '|||' . $album_image . '|||' . $rating;
        }
    }

    // Now let's sort the array

    if ('true' == $sort_by_year) {
        rsort($xmlArray);
    } else {
        sort($xmlArray);
    }

    // Now let's loop through that array to build the XML File

    $xmlData = '';

    for ($c = 0, $cMax = count($xmlArray); $c < $cMax; $c++) {
        if ('' != $xmlArray[$c]) {
            $valArray = explode('|||', $xmlArray[$c]);

            // now let's figure out the values

            if ('true' == $sort_by_year) {
                $album_long_name = $valArray[1];

                $album_short_name = $valArray[2];

                $album_year = $valArray[0];

                $album_image = $valArray[3];

                $rating = $valArray[4];
            } else {
                $album_long_name = $valArray[0];

                $album_short_name = $valArray[2];

                $album_year = $valArray[1];

                $album_image = $valArray[3];

                $rating = $valArray[4];
            }

            // Now let's build the XML

            $xmlData .= '   <album name="'
                        . $album_long_name
                        . '">'
                        . "\n"
                        . '      <shortname>'
                        . $album_short_name
                        . '</shortname>'
                        . "\n"
                        . '      <year>'
                        . $album_year
                        . '</year>'
                        . "\n"
                        . '      <image>'
                        . $album_image
                        . '</image>'
                        . "\n"
                        . '      <rating>'
                        . $rating
                        . '</rating>'
                        . "\n"
                        . '   </album>'
                        . "\n";
        }
    }

    // Now let's create the hash

    $xmlData = '   <genre>'
               . $genre
               . '</genre>'
               . "\n"
               . '   <artist>'
               . $artist
               . '</artist>'
               . "\n"
               . '   <artistImage>'
               . $artistImage
               . '</artistImage>'
               . "\n"
               . '   <artistDesc><![CDATA['
               . nl2br($artistDesc)
               . ']]></artistDesc>'
               . "\n"
               . '   <artistRating>'
               . $artistRating
               . '</artistRating>'
               . "\n"
               . $xmlData;

    $xmlData = '<jzCache hash="' . md5($hashData) . '">' . "\n" . $xmlData;

    $xmlData = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . $xmlData;

    $xmlData .= '</jzCache>' . "\n";

    // Ok, now we've got the data, let's write it to our file

    if ($handle = @fopen($xmlFile, 'wb')) {
        fwrite($handle, $xmlData);

        fclose($handle);
    } else {
        die(
            '<br>There was an error writing the artist cache file at:<br>' . $xmlFile . '<br><br>' . 'You should check the permissions on that file/folder to make sure it is writeable<br><br>' . "Sorry, this is a fatal error, I've got to stop!"
        );
    }
}

/**
 * check to see if we need to update the cache for this directory
 *
 * @param string $dirToLookIn Where to look for the data
 * @param string $xmlFile     the name of the XML file to generate
 * @return void|bool
 * @return void|bool
 * @author  Ross Carlson
 * @version 05.03.04
 * @since   05.03.04
 */
function checkXMLFile($dirToLookIn, $xmlFile)
{
    global $audio_types, $video_types;

    // First let's make sure the directory we are looking in exists

    if (!is_dir($dirToLookIn)) {
        return;
    }

    // Now let's get all the files from this directory

    $d = dir($dirToLookIn);

    while ($entry = $d->read()) {
        if ('.' == $entry || '..' == $entry) {
            continue;
        }

        $fileArray[] = $dirToLookIn . '/' . $entry;
    }

    // Now let's sort that array

    sort($fileArray);

    $hashData = '';

    for ($c = 0, $cMax = count($fileArray); $c < $cMax; $c++) {
        $file_time = filemtime(jzstripslashes($fileArray[$c]));

        $hashData .= $file_time;
    }

    // Now let's create the hash on that

    $hash = md5($hashData);

    // Now let's get the hash from the data file

    if (is_file($xmlFile)) {
        $handle = fopen($xmlFile, 'rb');

        $data = fread($handle, filesize($xmlFile));

        fclose($handle);
    } else {
        $data = '';
    }

    // Now let's parse out the hash

    $old_hash = mb_substr($data, mb_strpos($data, 'hash="') + 6, mb_strlen($data));

    $old_hash = mb_substr($old_hash, 0, mb_strpos($old_hash, '">'));

    // Now let's compare the two hashes

    if ($old_hash != $hash) {
        // Ok, we need to kill that file and update it

        if (is_file($xmlFile)) {
            unlink($xmlFile);
        }

        createXMLFile($dirToLookIn, $xmlFile);

        return true;
    }
  

    return false;
}

/**
 * This function will create the dat file for a directory that we are viewing
 *
 * @param string $dirToLookIn The directory to read
 * @param the     $xmlFile XML file name to create
 * @since   05.03.04
 * @author  Ross Carlson
 * @version 05.03.04
 */
function createXMLFile($dirToLookIn, $xmlFile)
{
    global $audio_types, $video_types, $track_num_seperator, $web_root, $image, $root_dir, $media_dir, $web_root, $root_dir, $ext_graphic;

    // Let's up the max execution time...

    ini_set('max_execution_time', '600');

    // Let's clean up the directory that we are looking at

    $dirToLookIn = jzstripslashes($dirToLookIn);

    // Now let's get all the files from this directory

    $d = dir($dirToLookIn);

    while ($entry = $d->read()) {
        if ('.' == $entry || '..' == $entry) {
            continue;
        }

        $fileArray[] = $dirToLookIn . '/' . $entry;
    }

    // Now let's sort that array

    sort($fileArray);

    // Now let's figure out the genre/artist/album

    $dataArray = explode('---', str_replace($web_root . $root_dir . '/data/tracks/', '', $xmlFile));

    $genre = str_replace('.xml', '', $dataArray[0]);

    $artist = str_replace('.xml', '', $dataArray[1]);

    $album = str_replace('.xml', '', $dataArray[2]);

    // Now let's see if there is a description of the album

    $desc_file = $web_root . $root_dir . $media_dir . '/' . $genre . '/' . $artist . '/' . $album . '/album-desc.txt';

    if (is_file($desc_file) and 0 != filesize($desc_file)) {
        // Ok, let's read the description file

        $handle = fopen($desc_file, 'rb');

        $albumDesc = fread($handle, filesize($desc_file));

        fclose($handle);
    } else {
        $albumDesc = '';
    }

    // Let's setup the hash data and tracktable

    $hashData = '';

    $trackTable = '';

    for ($c = 0, $cMax = count($fileArray); $c < $cMax; $c++) {
        // Let's make sure this isn't a directory

        if (is_dir($fileArray[$c])) {
            continue;
        }

        // Ok, now that we've got the file, let's get all the info from it

        $getID3 = new getID3();

        $fileInfo = $getID3->analyze($fileArray[$c]);

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
            $name = $fileInfo['comments']['title'][0];
        } else {
            $name = '-';
        }

        if (!empty($fileInfo['comments']['artist'][0])) {
            $artist = $fileInfo['comments']['artist'][0];
        }

        if (!empty($fileInfo['comments']['album'][0])) {
            $album = $fileInfo['comments']['album'][0];
        }

        if (!empty($fileInfo['comments']['year'][0])) {
            $year = $fileInfo['comments']['year'][0];
        } else {
            $year = '-';
        }

        if (!empty($fileInfo['comments']['track'][0])) {
            $track = $fileInfo['comments']['track'][0];
        } else {
            $track = '-';
        }

        if (!empty($fileInfo['comments']['genre'][0])) {
            $genre = $fileInfo['comments']['genre'][0];
        }

        if (!empty($fileInfo['audio']['sample_rate'])) {
            $frequency = round($fileInfo['audio']['sample_rate'] / 1000, 1);
        } else {
            $frequency = '-';
        }

        if (!empty($fileInfo['comments']['comment'][0])) {
            $description = $fileInfo['comments']['comment'][0];
        } else {
            $description = 'NULL';
        }

        if (!empty($fileInfo['tags']['id3v2']['unsynchronised lyric'][0])) {
            $lyrics = $fileInfo['tags']['id3v2']['unsynchronised lyric'][0];
        } else {
            $lyrics = '';
        }

        // Now let's see if we have the album art

        if (preg_match("/\.($ext_graphic)$/i", $fileArray[$c])) {
            $image = str_replace($web_root, '', $fileArray[$c]);
        }

        // Now let's see if there is a prefered image or not

        $pref_image = $web_root . $root_dir . $media_dir . '/' . $genre . '/' . $artist . '/' . $album . '/' . $album . '.jpg';

        if (is_file($pref_image)) {
            $image = $pref_image;
        }

        // Now let's get the extension

        $fileInfo = pathinfo($fileArray[$c]);

        $fileExt = $fileInfo['extension'];

        // Now let's see if we need to manually create the name

        if ('-' == $name or 'Tconv' == $name) {
            $name = str_replace('.' . $fileExt, '', str_replace($dirToLookIn . '/', '', $fileArray[$c]));

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
        }

        // Now let's make sure the name wasn't empty and if so just use the full file name...

        if ('' == $name) {
            $name = str_replace('.' . $fileExt, '', str_replace($dirToLookIn . '/', '', $fileArray[$c]));
        }

        // Now let's see if there is a description file...

        $desc_file = str_replace('.' . $fileExt, '', $fileArray[$c]) . '.txt';

        $long_description = '';

        if (is_file($desc_file) and 0 != filesize($desc_file)) {
            // Ok, let's read the description file

            $handle = fopen($desc_file, 'rb');

            $long_description = fread($handle, filesize($desc_file));

            fclose($handle);
        }

        // Now let's see if there is a thumbnail for this track

        $thumb_file = searchThumbnail($fileArray[$c]);

        // Let's set the data for tha hash

        $file_time = filemtime(jzstripslashes($fileArray[$c]));

        $hashData .= $file_time;

        // Now let's build the XML

        $trackTable .= '   <track ext="'
                       . $fileExt
                       . '">'
                       . "\n"
                       . '      <name>'
                       . $name
                       . '</name>'
                       . "\n"
                       . '      <filename>'
                       . str_replace($dirToLookIn . '/', '', $fileArray[$c])
                       . '</filename>'
                       . "\n"
                       . '      <path>'
                       . str_replace($web_root, '', $fileArray[$c])
                       . '</path>'
                       . "\n"
                       . '      <thumbnail>'
                       . $thumb_file
                       . '</thumbnail>'
                       . "\n"
                       . '      <date>'
                       . $file_time
                       . '</date>'
                       . "\n"
                       . '      <id3>'
                       . "\n"
                       . '         <desc><![CDATA['
                       . nl2br($description)
                       . ']]></desc>'
                       . "\n"
                       . '         <longdesc><![CDATA['
                       . nl2br($long_description)
                       . ']]></longdesc>'
                       . "\n"
                       . '         <number>'
                       . $track
                       . '</number>'
                       . "\n"
                       . '         <rate>'
                       . $bitrate
                       . '</rate>'
                       . "\n"
                       . '         <freq>'
                       . $frequency
                       . '</freq>'
                       . "\n"
                       . '         <size>'
                       . $filesize
                       . '</size>'
                       . "\n"
                       . '         <length>'
                       . $length
                       . '</length>'
                       . "\n"
                       . '         <year>'
                       . $year
                       . '</year>'
                       . "\n"
                       . '         <lyrics><![CDATA['
                       . str_replace("\n", '', nl2br($lyrics))
                       . ']]></lyrics>'
                       . "\n"
                       . '      </id3>'
                       . "\n"
                       . '   </track>'
                       . "\n";
    }

    // Now let's create the hash

    $trackTable = '      <genre>'
                  . $genre
                  . '</genre>'
                  . "\n"
                  . '      <artist>'
                  . $artist
                  . '</artist>'
                  . "\n"
                  . '      <album>'
                  . $album
                  . '</album>'
                  . "\n"
                  . '      <image>'
                  . $image
                  . '</image>'
                  . "\n"
                  . '      <albumDesc><![CDATA['
                  . str_replace("\n", '', nl2br($albumDesc))
                  . ']]></albumDesc>'
                  . "\n"
                  . $trackTable;

    $trackTable = '<jzCache hash="' . md5($hashData) . '">' . "\n" . $trackTable;

    $trackTable = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . $trackTable;

    $trackTable .= '</jzCache>' . "\n";

    // Ok, now we've got the data, let's write it to our file

    if ($handle = @fopen($xmlFile, 'wb')) {
        fwrite($handle, $trackTable);

        fclose($handle);
    } else {
        die(
            '<br>There was an error writing the track cache file at:<br>' . $xmlFile . '<br><br>' . 'You should check the permissions on that file/folder to make sure it is writbable<br><br>' . "Sorry, this is a fatal error, I've got to stop!"
        );
    }
}

/**
 * Goes through each dir one by one and creates it's track XML data
 *
 * @version 05.03.04
 * @since   05.03.04
 * @author  Ross Carlson
 * @param mixed $data
 * @param mixed $xmlData
 * @return string Text of the description
 */
function createAllXML($data, $xmlData)
{
    global $web_root, $root_dir, $media_dir;

    if (lookForMedia($web_root . $root_dir . $media_dir . '/' . $data, 'false', true)) {
        $xmlFile = $web_root . $root_dir . '/data/tracks/' . $xmlData;

        $dirToLookIn = $web_root . $root_dir . $media_dir . '/' . $data;

        if (@!is_file($xmlFile)) {
            // Ok, let's create the cache for this directory...

            flushDisplay();

            createXMLFile($dirToLookIn, $xmlFile);

            return true;
        }  

        // Ok, the file is there, let's see if it needs to be updated

        flushDisplay();

        return checkXMLFile($dirToLookIn, $xmlFile);
    }
}

/**
 * Creates the XML file caches and needed caching session variables
 *
 * @version 05.03.04
 * @since   05.03.04
 * @author  Ross Carlson
 * @param mixed $update
 * @param mixed $recreate
 * @return string Text of the description
 */
function createFileCaches($update = 'false', $recreate = 'false')
{
    global $web_root, $root_dir, $media_dir, $jinzora_temp_dir, $directory_level, $new_days, $cms_mode, $use_cache_file;

    // Let's make sure we need to update this before we do

    if (!isset($_SESSION['album_list']) or 'true' == $update or 'true' == $recreate) {
        // Let's let them know what we are updating ONLY if they pressed the button...

        if (isset($_GET['action'])) {
            echo '<center>Updating header caches<br>Please be patient as this could take quite a while...</center>';

            flushDisplay();
        }

        // First let's see if they were using a cached file

        if ('true' == $use_cache_file and 'false' == $update) {
            $read_file_cache = 'true';

            // Now let's see if the files are there, and if so open them, if not we'll create them

            if (!is_file($web_root . $root_dir . '/data/album_list.lst')) {
                $read_file_cache = 'false';
            }

            if (!is_file($web_root . $root_dir . '/data/artist_list.lst')) {
                $read_file_cache = 'false';
            }

            if (!is_file($web_root . $root_dir . '/data/genre_list.lst')) {
                $read_file_cache = 'false';
            }

            if (!is_file($web_root . $root_dir . '/data/album_only_list.lst')) {
                $read_file_cache = 'false';
            }

            if (!is_file($web_root . $root_dir . '/data/artist_only_list.lst')) {
                $read_file_cache = 'false';
            }

            if (!is_file($web_root . $root_dir . '/data/complete_list.lst')) {
                $read_file_cache = 'false';
            }

            // Now let's see if the files are there and if so let's read them

            if ('true' == $read_file_cache) {
                // Ok, all the files were there, so let's read them in

                $filename = $web_root . $root_dir . '/data/album_list.lst';

                $handle = fopen($filename, 'rb');

                $_SESSION['album_list'] = fread($handle, filesize($filename));

                fclose($handle);

                $filename = $web_root . $root_dir . '/data/artist_list.lst';

                $handle = fopen($filename, 'rb');

                $_SESSION['artist_list'] = fread($handle, filesize($filename));

                fclose($handle);

                $filename = $web_root . $root_dir . '/data/genre_list.lst';

                $handle = fopen($filename, 'rb');

                $_SESSION['genre_list'] = fread($handle, filesize($filename));

                fclose($handle);

                $filename = $web_root . $root_dir . '/data/album_only_list.lst';

                $handle = fopen($filename, 'rb');

                $_SESSION['album_only_list'] = fread($handle, filesize($filename));

                fclose($handle);

                $filename = $web_root . $root_dir . '/data/artist_only_list.lst';

                $handle = fopen($filename, 'rb');

                $_SESSION['artist_only_list'] = fread($handle, filesize($filename));

                fclose($handle);

                $update = 'false';
            } else {
                $update = 'true';
            }
        }

        // Now let's return if we don't need to update

        if ('false' == $update) {
            return;
        }

        // Now let's initalize these variables

        $album_list = '';

        $artist_list = '';

        $genre_list = '';

        $album_only_list = '';

        $artist_only_list = '';

        $complete_list = '';

        // First we need to read the directories to create the file info

        $topDir = $web_root . $root_dir . $media_dir;

        $topArray = readDirInfo($topDir, 'dir');

        // Let's loop through the array and write the data

        $t_ctr = 0;

        $add_ctr = 0;

        for ($ctr = 0, $ctrMax = count($topArray); $ctr < $ctrMax; $ctr++) {
            if ('' != $topArray[$ctr]) {
                // Let's create the XML file for this location

                switch ($directory_level) {
                    case '3':
                        $xmlFile = $topArray[$ctr] . '---NULL---NULL.xml';
                        break;
                    case '2':
                        $xmlFile = 'NULL---' . $topArray[$ctr] . '---NULL.xml';
                        break;
                    case '1':
                        $xmlFile = 'NULL---NULL---' . $topArray[$ctr] . '.xml';
                        break;
                }

                createAllXML($topArray[$ctr], $xmlFile);

                if (0 != $t_ctr) {
                    echo '<center>' . $t_ctr . ' dirs read</center>';
                }

                echo '<br><center><strong>Caching top dir: ' . $topArray[$ctr] . '</strong><br>';

                $t_ctr = 0;

                // Now let's write the data to our toplevel file

                if ('3' == $directory_level) {
                    $genre_list .= rawurlencode($topArray[$ctr]) . "\n";
                }

                if ('2' == $directory_level) {
                    $artist_list .= rawurlencode($topArray[$ctr]) . "\n";
                }

                if ('1' == $directory_level) {
                    $album_list .= rawurlencode($topArray[$ctr]) . "\n";
                }

                if (isset($_GET['action'])) {
                    if (0 == $ctr % 2) {
                        echo '.';

                        flushDisplay();
                    }
                }

                // Now let's go through that array and create the next level down

                $secondArray = readDirInfo($topDir . '/' . $topArray[$ctr], 'dir');

                for ($ctr2 = 0, $ctr2Max = count($secondArray); $ctr2 < $ctr2Max; $ctr2++) {
                    if (isset($_GET['action'])) {
                        if (0 == $ctr2 % 5) {
                            echo '.';

                            flushDisplay();
                        }
                    }

                    if ('' != $secondArray[$ctr2]) {
                        // Let's create the XML file for this location

                        switch ($directory_level) {
                            case '3':
                                $xmlFile = $topArray[$ctr] . '---' . $secondArray[$ctr2] . '---NULL.xml';
                                break;
                            case '2':
                                $xmlFile = 'NULL---' . $topArray[$ctr] . '---' . $secondArray[$ctr2] . '.xml';
                                break;
                        }

                        if (createAllXML($topArray[$ctr] . '/' . $secondArray[$ctr2], $xmlFile)) {
                            $add_ctr++;
                        }

                        // Let's update the master counter

                        $t_ctr++;

                        if ('3' == $directory_level) {
                            $artist_list .= rawurlencode($secondArray[$ctr2]) . '--' . rawurlencode($topArray[$ctr]) . "\n";

                            $artist_only_list .= '--' . rawurlencode($topArray[$ctr] . '--');
                        }

                        if ('2' == $directory_level) {
                            $album_list .= rawurlencode($secondArray[$ctr2]) . '--' . rawurlencode($topArray[$ctr]) . "\n";

                            $album_only_list .= rawurlencode($topArray[$ctr]);
                        }

                        // Now let's go one directory deeper

                        $thirdArray = readDirInfo($topDir . '/' . $topArray[$ctr] . '/' . $secondArray[$ctr2], 'dir');

                        for ($ctr3 = 0, $ctr3Max = count($thirdArray); $ctr3 < $ctr3Max; $ctr3++) {
                            if (isset($_GET['action'])) {
                                if (0 == $ctr3 % 4) {
                                    echo '.';

                                    flushDisplay();
                                }
                            }

                            if ('' != $thirdArray[$ctr3]) {
                                // Let's create the XML file for this location

                                if (createAllXML($topArray[$ctr] . '/' . $secondArray[$ctr2] . '/' . $thirdArray[$ctr3], $topArray[$ctr] . '---' . $secondArray[$ctr2] . '---' . $thirdArray[$ctr3] . '.xml')) {
                                    $add_ctr++;
                                }

                                // Let's update the master counter

                                $t_ctr++;

                                if ('3' == $directory_level and '' != $thirdArray[$ctr3]) {
                                    $album_list .= rawurlencode($thirdArray[$ctr3]) . '--' . rawurlencode($topArray[$ctr]) . '--' . rawurlencode($secondArray[$ctr2]) . "\n";

                                    $album_only_list .= rawurlencode($topArray[$ctr]) . '--' . rawurlencode($secondArray[$ctr2]) . "\n";
                                }
                            }
                        }
                    }
                }
            }
        }

        // Now let's tell them how many we added

        if (0 != $add_ctr) {
            echo '<br><br><center>Added: ' . $add_ctr . ' new albums to Jinzora</center><br><br>';
        } ?>
        <SCRIPT LANGUAGE=JAVASCRIPT TYPE="TEXT/JAVASCRIPT"><!--\
				alert("Cache Updated!");
            -->
        </SCRIPT>
        <?php

        // Now let's get a complete listing of all files...
        //$readCtr = 0; $complete_list = "";
        //echo "<br>Creating complete file list<br>"; flushdisplay();
        //$mainArray = readAllDirs($web_root. $root_dir. $media_dir, $readCtr, $mainArray, "false", "true");
        //for ($ctr=0; $ctr < count($mainArray); $ctr++){
        //$complete_list .= str_replace("/","----",str_replace($web_root. $root_dir. $media_dir. "/", "",$mainArray[$ctr])). "\n";
        //}

        //echo '<br>';

        // Now let's clear the session variables
        $_SESSION['album_list'] = '';

        $_SESSION['artist_list'] = '';

        $_SESSION['genre_list'] = '';

        $_SESSION['album_only_list'] = '';

        $_SESSION['artist_only_list'] = '';

        $_SESSION['complete_list'] = '';

        // Now let's update the file caches, if they wanted us to!

        if ('true' == $use_cache_file) {
            $handle = fopen($web_root . $root_dir . '/data/album_list.lst', 'wb');

            fwrite($handle, $album_list);

            fclose($handle);

            $handle = fopen($web_root . $root_dir . '/data/artist_list.lst', 'wb');

            fwrite($handle, $artist_list);

            fclose($handle);

            $handle = fopen($web_root . $root_dir . '/data/genre_list.lst', 'wb');

            fwrite($handle, $genre_list);

            fclose($handle);

            $handle = fopen($web_root . $root_dir . '/data/album_only_list.lst', 'wb');

            fwrite($handle, $album_only_list);

            fclose($handle);

            $handle = fopen($web_root . $root_dir . '/data/artist_only_list.lst', 'wb');

            fwrite($handle, $artist_only_list);

            fclose($handle);

            $handle = fopen($web_root . $root_dir . '/data/complete_list.lst', 'wb');

            fwrite($handle, $complete_list);

            fclose($handle);

            $_SESSION['album_list'] = $album_list;

            $_SESSION['artist_list'] = $artist_list;

            $_SESSION['genre_list'] = $genre_list;

            $_SESSION['album_only_list'] = $album_only_list;

            $_SESSION['artist_only_list'] = $artist_only_list;

            $_SESSION['complete_list'] = $complete_list;
        } else {
            // Now let's set everything

            $_SESSION['album_list'] = $album_list;

            $_SESSION['artist_list'] = $artist_list;

            $_SESSION['genre_list'] = $genre_list;

            $_SESSION['album_only_list'] = $album_only_list;

            $_SESSION['artist_only_list'] = $artist_only_list;

            $_SESSION['complete_list'] = $complete_list;
        }
    }
}

/**
 * Returns the text of the description for an item
 *
 * @version 05.03.04
 * @since   05.03.04
 * @author  Ross Carlson
 * @param mixed $item
 * @return string Text of the description
 */
function returnDescription($item)
{
    global $web_root, $root_dir, $media_dir;

    // Ok, let's see if there is a description file for this section

    $desc_file = $web_root . $root_dir . $media_dir . '/' . $item . '.txt';

    if (is_file($desc_file) and 0 != filesize($desc_file)) {
        // Ok, it's there so let's open it and display it

        $filename = $desc_file;

        $handle = fopen($filename, 'rb');

        $contents = fread($handle, filesize($filename));

        fclose($handle);

        return $contents;
    }
  

    return false;
}

/**
 * Returns all genres in the form of an array
 *
 * @return array keyed array of all the genres and their links
 * @version 05.03.04
 * @since   05.03.04
 * @author  Ross Carlson
 */
function returnAllGenres()
{
    global $web_root, $root_dir, $media_dir;

    // Let's read the data and return the array

    return readDirInfo($web_root . $root_dir . $media_dir, 'dir');
}

/**
 * Returns all genres in the form of an array
 *
 * @version 05.03.04
 * @since   05.03.04
 * @author  Ross Carlson
 * @param mixed $item
 * @return array keyed array of all the genres and their links
 */
function returnSelectedArtists($item)
{
    global $web_root, $root_dir, $media_dir;

    // Let's read the data and return the array

    return readDirInfo($web_root . $root_dir . $media_dir . '/' . $item, 'dir');
}

/**
 * Returns the ablums from the selected artist
 *
 * @param mixed $location
 * @return array keyed array of all the genres and their links
 * @since   05.03.04
 * @author  Ross Carlson
 * @version 05.03.04
 */
function returnAlbums($location)
{
    global $web_root, $root_dir, $media_dir;

    // Let's set a variable so we know where to look later

    $dirToLookIn = $web_root . $root_dir . $media_dir . '/' . $location;

    // Now let's set what the XML file should be

    $xmlFile = $web_root . $root_dir . '/data/artists/' . str_replace('/', '---', str_replace($web_root . $root_dir . $media_dir . '/', '', $dirToLookIn)) . '.xml';

    while ('---' == mb_substr($xmlFile, 0, 3)) {
        $xmlFile = mb_substr($xmlFile, 3, mb_strlen($xmlFile));
    }

    // Now let's see if they wanted to update the XML file manually

    if (isset($_GET['updatexml'])) {
        if ('artist' == $_GET['updatexml']) {
            // Ok, let's kill it first

            if (is_file($xmlFile)) {
                unlink($xmlFile);
            }
        }
    }

    // Now let's check the cache for this artist, and if we need to update it

    checkArtistXMLFile($dirToLookIn, $xmlFile);

    // Let's load up our array from the XML data

    return returnArtistData($xmlFile);
}

/**
 * returns the number of sub folders for a given folder
 *
 * @param string $item the name of the item we are looking at
 * @param mixed  $where
 * @return string
 * @return string
 * @author  Ross Carlson
 * @version 05/03/04
 * @since   05/03/04
 */
function returnSubNumber($item, $where = '')
{
    global $show_sub_numbers;

    // Now we need to figure out where to look

    $genre = $_GET['genre'] ?? '';

    if ('' == $genre or '' != $where) {
        $whereToLook = $_SESSION['artist_only_list'];

        $item = '--' . $item . '--';
    } else {
        $whereToLook = $_SESSION['album_only_list'];

        $item = '--' . $item . "\n";
    }

    // Let's see if they wanted counting or not

    if ('false' == $show_sub_numbers) {
        return '';
    }

    // Ok, let's count and return

    $i = mb_substr_count(urldecode($whereToLook), $item);

    if (0 != $i) {
        return ' (' . $i . ')';
    }
  

    return '';
}

/**
 * returns the truncated name of an item
 *
 * @param string $item   the item to truncate
 * @param string $length how long should it be?
 * @return string
 * @return string
 * @author  Ross Carlson
 * @version 05/03/04
 * @since   05/03/04
 */
function returnItemShortName($item, $length)
{
    if (mb_strlen($item) > $length) {
        return mb_substr($item, 0, $length) . '...';
    }
  

    return $item;
}

/**
 * returns the HTML code with the artists description and Image
 *
 * @param string $location where to look
 * @param mixed $artist
 * @return string returns the HTML code
 * @since   05/03/04
 * @author  Ross Carlson
 * @version 05/03/04
 */
function returnArtistImageDescHTML($location, $artist)
{
    global $web_root, $root_dir, $media_dir, $ext_graphic;

    // Let's start our variable

    $retVal = '';

    // Now let's display the artist photo if available

    $dirToLookIn = $web_root . $root_dir . $media_dir . '/' . $location;

    $d = dir($dirToLookIn);

    while ($entry = $d->read()) {
        // Let's set a variable for below so we'll know we found some albums here

        if (is_dir($dirToLookIn . '/' . $entry)) {
            if ('.' == $entry || '..' == $entry) {
                continue;
            }

            $albumsFound = 'yes';
        }

        // Let's see if one of the files is an image that we're used to

        if (preg_match("/\.($ext_graphic)$/i", $entry)) {
            $artistImage = $root_dir . $media_dir . '/' . $location . '/' . $entry;

            // Now let's resize the image if necessary

            jzResizeArtist($dirToLookIn, $entry);
        }
    }

    // Now let's add the artist image

    if (0 != mb_strlen($artistImage)) {
        $retVal .= '<img align="left" src="' . urldecode($artistImage) . '" border="0">';
    }

    // Let's see if there is a description

    $desc_file = $web_root . $root_dir . $media_dir . '/' . $location . '/' . $artist . '.txt';

    if (is_file($desc_file) and 0 != filesize($desc_file)) {
        // Ok, it's there so let's open it and display it

        $filename = $desc_file;

        $handle = fopen($filename, 'rb');

        $retVal .= nl2br(fread($handle, filesize($filename))) . '<br><br>';

        fclose($handle);
    }

    // Now let's return our data

    return $retVal;
}

/**
 * returns the HTML for the site description
 *
 * @return string Returns the HTML code for the site description
 * @version 05/03/04
 * @since   05/03/04
 * @author  Ross Carlson
 */
function returnSiteDescription()
{
    global $web_root, $root_dir, $media_dir;

    $desc_file = $web_root . $root_dir . $media_dir . '/site-description.txt';

    if (is_file($desc_file) and 0 != filesize($desc_file)) {
        // Ok, it's there so let's open it and display it

        $filename = $desc_file;

        $handle = fopen($filename, 'rb');

        $contents = fread($handle, filesize($filename));

        fclose($handle);

        return '<center><span class="j_site_desc">' . stripslashes($contents) . '</span></center><br>';
    }
  

    return false;
}

/**
 * returns an array of data that is globably excluded from view
 *
 * @version 05/03/04
 * @since   05/03/04
 * @author  Ross Carlson
 * @param mixed $type
 * @return array Array of data to be excluded
 */
function returnExcludeArray($type)
{
    global $web_root, $root_dir;

    // Let's set the file to read

    if ('personal' == $type) {
        $filename = $web_root . $root_dir . '/data/' . $_COOKIE['jz_user_name'] . '-exclude.lst';
    }

    if ('global' == $type) {
        $filename = $web_root . $root_dir . '/data/global-exclude.lst';
    }

    // Let's read the data and return

    if (is_file($filename)) {
        return readExcludeFile($filename);
    }
  

    return false;
}

/**
 * returns the number of sub items (folders) for a given location
 *
 * @param mixed $location
 * @return int Number of sub items
 * @since   05/03/04
 * @author  Ross Carlson
 * @version 05/03/04
 */
function returnSubItems($location)
{
    global $web_root, $root_dir, $media_dir;

    $retArray = readDirInfo($web_root . $root_dir . $media_dir . '/' . $location, 'dir');

    $i = 0;

    for ($ctr = 0, $ctrMax = count($retArray); $ctr < $ctrMax; $ctr++) {
        if ('' != $retArray[$ctr]) {
            $i++;
        }
    }

    return $i;
}

/**
 * returns information about the item being new or not
 *
 * @param string $item Item to read about
 * @return string When it's new from
 * @since   05/03/04
 * @author  Ross Carlson
 * @version 05/03/04
 */
function checkForNew($item)
{
    global $days_for_new, $word_new_from, $word_new_from_last, $word_today, $word_yesterday, $word_days_of_week, $web_root, $root_dir, $media_dir;

    $item = $web_root . $root_dir . $media_dir . '/' . $item;

    $new_from = '';

    if (0 != $days_for_new) {
        $diff_range = $days_for_new * 86400;

        // Now let's make sure this is a real file...

        if (!is_file($item) and !is_dir($item)) {
            return '';
        }

        $file_time = filemtime(jzstripslashes($item));

        if ((time() - $file_time) < $diff_range) {
            $new_time = true;

            // Now let's set when it's new from and if this is from last week or not

            if ((time() - $file_time) < 605080) {
                // Now let's make sure that isn't from today

                if (date('l', time()) == date('l', filemtime(jzstripslashes($item)))) {
                    $new_from = $word_new_from . ' ' . $word_today;
                } elseif (date('l', time() - 86400) == date('l', filemtime(jzstripslashes($item)))) {
                    $new_from = $word_new_from . ' ' . $word_yesterday;
                } else {
                    $new_from = $word_new_from . ' ' . $word_days_of_week[date('w', filemtime(jzstripslashes($item)))];
                }
            } else {
                $new_from = $word_new_from_last . ' ' . $word_days_of_week[date('w', filemtime(jzstripslashes($item)))];
            }
        }
    }

    return $new_from;
}

/**
 * returns the HTML with the rating for an item
 *
 * @param string $item Item to read about
 * @param mixed $break
 * @param mixed $rating
 * @return string When it's new from
 * @since   4.6.04
 * @author  Ross Carlson
 * @version 05/03/04
 */
function displayRating($item, $break = true, $rating = '')
{
    global $img_star_full, $img_star_half_empty, $img_star_left, $img_star_right, $img_star_full_empty, $web_root, $root_dir;

    $filename = $web_root . $root_dir . '/data/ratings/' . str_replace('/', '---', jzstripslashes($item)) . '.rating';

    if ((!is_file($filename) or null === $filename) and '' == $rating) {
        return;
    }

    $retVal = '';

    if (true === $break) {
        $retVal .= '<br><nobr>';
    }

    // Now let's start the rating icon

    $retVal .= $img_star_left;

    // Now let's read the ratings file and get the rating

    if (null != $item) {
        $handle = fopen($filename, 'rb');

        $contents = fread($handle, filesize($filename));

        fclose($handle);

        $rateArray = explode("\n", $contents);

        $rating = 0;

        for ($ctr = 0, $ctrMax = count($rateArray); $ctr < $ctrMax; $ctr++) {
            $ratingArray = explode('|', $rateArray[$ctr]);

            if (isset($ratingArray[1])) {
                $rating += $ratingArray[1];
            }
        }

        $total_rating = $rating;

        $rating /= ($ctr - 1);
    } else {
        $total_rating = $rating;
    }

    $rating += .49;

    while ($rating > 1) {
        $rating -= 1;

        $retVal .= $img_star_full;
    }

    while ($rating > .5) {
        $rating -= .5;

        $retVal .= $img_star_half_empty;
    }

    // Now we need to finish this off to make 5

    $rating = 5 - $total_rating;

    $rating += .49;

    while ($rating > 1) {
        $rating -= 1;

        $retVal .= $img_star_full_empty;
    }

    // Now let's finish it off

    $retVal .= $img_star_right;

    if (true === $break) {
        $retVal .= '</nobr>';
    }

    return $retVal;
}

/**
 * returns the HTML with the header text contents
 *
 * @return string The contents of the header data
 * @version 05/03/04
 * @since   4.6.04
 * @author  Ross Carlson
 */
function returnHeaderText()
{
    global $web_root, $root_dir, $media_dir;

    // Let's set the file to read

    $filename = $web_root . $root_dir . $media_dir . '/header.txt';

    // Let's make sure it's there with data

    if (!is_file($filename) or 0 != !filesize($filename)) {
        return false;
    }

    // Now let's make sure they are NOT on the login page

    if (isset($_GET['ptype'])) {
        if ('login' == $_GET['ptype']) {
            return null;
        }
    }

    // Ok, let's read that puppy

    $handle = fopen($filename, 'rb');

    $contents = fread($handle, filesize($filename));

    fclose($handle);

    return '<br>' . $contents;
}

/**
 * returns the HTML with the footer text contents
 *
 * @return string The contents of the footer data
 * @version 05/04/04
 * @since   05/04/04
 * @author  Ross Carlson
 */
function returnFooterText()
{
    global $web_root, $root_dir, $media_dir;

    // Let's set the file to read

    $filename = $web_root . $root_dir . $media_dir . '/footer.txt';

    // Let's make sure it's there with data

    if (!is_file($filename) or 0 == filesize($filename)) {
        return null;
    }

    // Now let's make sure they are NOT on the login page

    if (isset($_GET['ptype'])) {
        if ('login' == $_GET['ptype']) {
            return null;
        }
    }

    // Ok, let's read that puppy

    $handle = fopen($filename, 'rb');

    $contents = fread($handle, filesize($filename));

    fclose($handle);

    return $contents;
}

/**
 * Updates the backend database (in this case the file caches)
 *
 * @author  Ross Carlson
 * @version 05/04/04
 * @since   05/04/04
 */
function updateBackend()
{
    createFileCaches(true);
}

?>

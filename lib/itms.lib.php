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
 * This page contains the functions to search iTunes
 *
 * @since  04/28/04
 * @author Ross Carlson <ross@jinzora.org>
 *
 * Example:
 *
 * // These are the different values returned by iTunes for each track
 * "artistName|artistId|bitRate|priceDisplay|composerName|composerId|copyright|dateModified|discCount|discNumber|duration|explicit|fileExtension|genre|genreId|playlistName|playlistArtistName|playlistArtistId|playlistId|previewURL|previewLength|relevance|releaseDate|sampleRate|songId|comments|trackNumber|songName|vendorId|year"
 * // This is the urlencoded search term
 * $searchTerm = "Chick%20Corea"
 *
 * $array = searchiTunes($searchTerm, $searchVals, "trackData");
 *
 * Notes:
 * The final argument to the function is the type of data you'd like back.  There are 4 types:
 * top4Albums, topTracks, topArtists, trackData
 *
 * The array that is returned will contain the data for what you searched for.
 */

// This is the urlencoded search term
//$searchTerm = "David%20Sanborn";
// Now let's search and display
//require_once __DIR__ . '/display.lib.php';
//displayiTunesSearchTracks(searchiTunes($searchTerm, $searchVals, "trackData"));

/**
 * Display the iTunes search bar
 *
 * @author  Ross Carlson
 * @version 04/29/04
 * @since   04/29/04
 */
function displayiTunesSearchBar()
{
    global $word_search, $row_colors, $word_go_button, $link_url;

    // Let's start displaying

    jzTableOpen('100', '5', 'jz_track_table');

    // Now let's show the header row

    jzTROpen($row_colors[0]);

    jzTDOpen('100', 'center', 'top', 'jz_track_table_songs_td', '');

    echo '<strong>' . $word_search . ' iTunes Music Store<strong>';

    jzTDClose();

    jzTRClose();

    jzTROpen($row_colors[1]);

    jzTDOpen('100', 'center', 'top', 'jz_track_table_songs_td', '');

    echo '<form action="' . $link_url . '" name="itmsSearch" method="GET">';

    echo '<input type="hidden" name="search" value="itunes">';

    echo '<input type="input" class="jz_input" size="30" name="info"> <input type="submit" class="jz_submit" name="searchiTunes" value="' . $word_go_button . '">';

    echo '</form>';

    jzTDClose();

    jzTRClose();

    jzTableClose();

    echo '<br>';
}

/**
 * Search iTunes and display the results very nicely...
 *
 * @param array $dataArray The array containing the data
 * @version 04/28/04
 * @since   04/28/04
 * @author  Ross Carlson
 */
function displayiTunesSearchTopArtists($dataArray)
{
    global $css, $img_play, $row_colors, $word_search_results, $word_artist, $word_album, $word_genre, $link_url;

    // Let's start displaying

    jzTableOpen('100', '5', 'jz_track_table');

    // Now let's show the header row

    jzTROpen($row_colors[0]);

    jzTDOpen('100', 'center', 'top', 'jz_track_table_songs_td', '');

    echo '<strong>' . word_top_artists . '<strong>';

    jzTDClose();

    jzTRClose();

    // Now let's display the results

    $i = 1;

    for ($c = 0, $cMax = count($dataArray); $c < $cMax; $c++) {
        if ('' != trim($dataArray[$c]['name'])) {
            // Let's open the row

            jzTROpen($row_colors[$i]);

            // Now let's display the data

            jzTDOpen('100', 'left', 'top', 'jz_track_table_songs_td', '');

            echo '<a href="' . $link_url . 'search=itunes&info=' . urlencode($dataArray[$c]['name']) . '">' . $dataArray[$c]['name'] . '</a><br>';

            jzTDClose();

            // Let's close the row

            jzTRClose();

            // Now let's flush the display

            flushDisplay();

            // Let's increment our counter for the row class

            $i = ++$i % 2;
        }
    }

    // Now let's close out

    jzTableClose();

    echo '<br>';
}

/**
 * Search iTunes and display the results very nicely...
 *
 * @param array $dataArray The array containing the data
 * @version 04/28/04
 * @since   04/28/04
 * @author  Ross Carlson
 */
function displayiTunesSearchTopSongs($dataArray)
{
    global $css, $img_play, $row_colors, $word_search_results, $word_artist, $word_album, $word_genre, $link_url;

    // Let's start displaying

    jzTableOpen('100', '5', 'jz_track_table');

    // Now let's show the header row

    jzTROpen($row_colors[0]);

    jzTDOpen('100', 'center', 'top', 'jz_track_table_songs_td', '');

    echo '<strong>' . word_top_songs . '<strong>';

    jzTDClose();

    jzTRClose();

    // Now let's display the results

    $i = 1;

    for ($c = 0, $cMax = count($dataArray); $c < $cMax; $c++) {
        if ('' != trim($dataArray[$c]['name'])) {
            // Let's open the row

            jzTROpen($row_colors[$i]);

            // Now let's display the data

            jzTDOpen('100', 'left', 'top', 'jz_track_table_songs_td', '');

            echo '<a href="' . $link_url . 'search=itunes&info=' . urlencode($dataArray[$c]['name']) . '">' . $dataArray[$c]['name'] . '</a><br>';

            jzTDClose();

            // Let's close the row

            jzTRClose();

            // Now let's flush the display

            flushDisplay();

            // Let's increment our counter for the row class

            $i = ++$i % 2;
        }
    }

    // Now let's close out

    jzTableClose();

    echo '<br>';
}

/**
 * Search iTunes and display the results very nicely...
 *
 * @param array $dataArray The array containing the data
 * @version 04/28/04
 * @since   04/28/04
 * @author  Ross Carlson
 */
function displayiTunesSearchAlbums($dataArray)
{
    global $css, $img_play, $row_colors, $word_search_results, $word_artist, $word_album, $word_genre, $link_url;

    // Let's start displaying

    jzTableOpen('100', '5', 'jz_track_table');

    // Now let's show the header row

    jzTROpen($row_colors[0]);

    jzTDOpen('100', 'center', 'top', 'jz_track_table_songs_td', '2');

    echo '<strong>' . word_top_albums . '<strong>';

    jzTDClose();

    jzTRClose();

    // Now let's display the results

    $i = 1;

    for ($c = 0, $cMax = count($dataArray); $c < $cMax; $c++) {
        if ('' != $dataArray[$c]['price']) {
            // Let's open the row

            jzTROpen($row_colors[$i]);

            // Now let's display the data

            jzTDOpen('10', 'left', 'top', 'jz_track_table_songs_td', '');

            echo '<img src="' . $dataArray[$c]['image'] . '" border="0">';

            jzTDClose();

            jzTDOpen('90', 'left', 'top', 'jz_track_table_songs_td', '');

            echo '<nobr><strong>' . $word_album . ':</strong> ' . '<a href="' . $link_url . 'search=itunes&info=' . urlencode($dataArray[$c]['album']) . '">' . $dataArray[$c]['album'] . '</a></nobr><br>';

            echo '<nobr><strong>' . $word_artist . ':</strong> ' . '<a href="' . $link_url . 'search=itunes&info=' . urlencode($dataArray[$c]['artist']) . '">' . $dataArray[$c]['artist'] . '</a></nobr><br>';

            echo '<nobr><strong>' . $word_genre . ':</strong> ' . '<a href="' . $link_url . 'search=itunes&info=' . urlencode($dataArray[$c]['genre']) . '">' . $dataArray[$c]['genre'] . '</a></nobr><br>';

            echo '<strong>' . word_price . ':</strong> $' . $dataArray[$c]['price'];

            jzTDClose();

            // Let's close the row

            jzTRClose();

            // Now let's flush the display

            flushDisplay();

            // Let's increment our counter for the row class

            $i = ++$i % 2;
        }
    }

    // Now let's close out

    jzTableClose();

    echo '<br>';
}

/**
 * Search iTunes and display the results very nicely...
 *
 * @param array $dataArray The array containing the data
 * @version 04/28/04
 * @since   04/28/04
 * @author  Ross Carlson
 */
function displayiTunesSearchTracks($dataArray)
{
    global $css, $img_play, $row_colors, $word_search_results, $link_url;

    // Let's start displaying

    jzTableOpen('100', '5', 'jz_track_table');

    // Now let's show the header row

    jzTROpen($row_colors[0]);

    jzTDOpen('100', 'center', 'top', 'jz_track_table_songs_td', '7');

    echo '<strong>' . word_track_matches . '<strong>';

    jzTDClose();

    jzTRClose();

    // Now let's display the tracks

    $i = 1;

    for ($c = 0, $cMax = count($dataArray); $c < $cMax; $c++) {
        // Let's open the row

        jzTROpen($row_colors[$i]);

        jzTDOpen('1', 'left', 'top', 'jz_track_table_songs_td', '');

        echo '<a href="' . $dataArray[$c]['previewURL'] . '">' . $img_play . '</a>';

        jzTDClose();

        jzTDOpen('40', 'left', 'top', 'jz_track_table_songs_td', '');

        echo '<nobr>' . '<a href="' . $dataArray[$c]['previewURL'] . '">' . $dataArray[$c]['songName'] . '</a></nobr>';

        jzTDClose();

        jzTDOpen('5', 'center', 'top', 'jz_track_table_songs_td', '');

        $length = convertSecMins($dataArray[$c]['duration'] / 1000);

        echo '<nobr>' . $length . '</nobr>';

        jzTDClose();

        jzTDOpen('44', 'left', 'top', 'jz_track_table_songs_td', '');

        echo '<a href="' . $link_url . 'search=itunes&info=' . urlencode($dataArray[$c]['playlistName']) . '">' . $dataArray[$c]['playlistName'] . '</a><br>';

        jzTDClose();

        jzTDOpen('44', 'left', 'top', 'jz_track_table_songs_td', '');

        echo '<a href="' . $link_url . 'search=itunes&info=' . urlencode($dataArray[$c]['playlistArtistName']) . '">' . $dataArray[$c]['playlistArtistName'] . '</a><br>';

        jzTDClose();

        jzTDOpen('5', 'left', 'top', 'jz_track_table_songs_td', '');

        $relevance = (round($dataArray[$c]['relevance'] * 100));

        echo '<nobr> ' . $relevance . '% </nobr>';

        jzTDClose();

        jzTDOpen('5', 'center', 'top', 'jz_track_table_songs_td', '');

        if (isset($dataArray[$c]['priceDisplay'])) {
            echo '<nobr>' . $dataArray[$c]['priceDisplay'] . '</nobr>';
        }

        jzTDClose();

        // Let's close the row

        jzTRClose();

        // Now let's flush the display

        flushDisplay();

        // Let's increment our counter for the row class

        $i = ++$i % 2;
    }

    // Now let's close out

    jzTableClose();

    echo '<br>';
}

/**
 * Search iTunes and return the requested data
 *
 * @param string $searchTerm What you want to search for, URL encoded
 * @return Returns an array with the data
 * @version 04/28/04
 * @since   04/28/04
 * @author  Ross Carlson
 */
function searchiTunes($searchTerm)
{
    // Let's open our connection to iTunes

    $fp = fsockopen('phobos.apple.com', 80, $errno, $errstr, 5);

    // Let's create our header to send to iTunes

    $headers = 'GET /WebObjects/MZSearch.woa/wa/com.apple.jingle.search.DirectAction/search?term=' . $searchTerm . " HTTP/1.1\r\nHost:phobos.apple.com\r\n";

    $headers .= "User-Agent: iTunes/4.2 (Macintosh; U; PPC Mac OS X 10.2)\r\n";

    $headers .= "Accept-Language: en-us, en;q=0.50\r\n";

    $headers .= "Cookie: countryVerified=1\r\n";

    $headers .= "Accept-Encoding: gzip, x-aes-cbc\r\n";

    $headers .= "Host: phobos.apple.com\r\n";

    $headers .= "Connection: close\r\n\r\n";

    // Now let's send the request

    fwrite($fp, $headers);

    // Now let's process that by stripping off the header to get the encrypted data

    $blnHeader = true;

    $contents = '';

    while (!feof($fp)) {
        $contents .= fread($fp, 128);
    }

    fclose($fp);

    // let's get the iv from http header

    preg_match("/x-apple-crypto-iv: (\w+)/", $contents, $ivHex);

    $iv = pack('H*', $ivHex[1]);

    // Now let's strip the beginning off the contents

    $contents = mb_substr($contents, mb_strpos($contents, 'NetCache'), mb_strlen($contents));

    $contents = mb_substr($contents, mb_strpos($contents, "\n") + 3, mb_strlen($contents));

    // crunch the key

    $key = '8a9dad399fb014c131be611820d78895';

    $key = pack('H*', $key);

    // Now let's decrypt the data

    $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');

    if (mcrypt_generic_init($td, $key, $iv) >= 0) {
        $decrypted_data = mdecrypt_generic($td, $contents);

        mcrypt_generic_deinit($td);

        mcrypt_module_close($td);
    } else {
        echo 'ERROR';

        exit();
    }

    // Now we need to uncompress this

    return gzinflate(mb_substr($decrypted_data, 10));
}

function parseiTunesData($xmlData, $returnWhat)
{
    global $searchVals;

    // Now let's clean that up and get the data we want out of it

    $topAlbums = mb_substr($xmlData, mb_strpos($xmlData, 'Top Albums'), mb_strlen($xmlData));

    $topAlbums = mb_substr($topAlbums, 0, mb_strpos($topAlbums, 'Top Songs'));

    //$topAlbums = substr($topAlbums,strpos($topAlbums,"<HBoxView"),strlen($topAlbums));

    $topAlbumsArray = explode('</VBoxView>', $topAlbums);

    $c = 0;

    for ($ctr = 0, $ctrMax = count($topAlbumsArray); $ctr < $ctrMax; $ctr++) {
        if (mb_stristr($topAlbumsArray[$ctr], '<HBoxView')) {
            // Ok, now let's get the image

            $albumImage = mb_substr($topAlbumsArray[$ctr], mb_strpos($topAlbumsArray[$ctr], 'http://'), mb_strlen($topAlbumsArray[$ctr]));

            $albumImage = mb_substr($albumImage, 0, mb_strpos($albumImage, '">'));

            $albumName = mb_substr($topAlbumsArray[$ctr], mb_strpos($topAlbumsArray[$ctr], '<B>') + 3, mb_strlen($topAlbumsArray[$ctr]));

            $albumName = mb_substr($albumName, 0, mb_strpos($albumName, '</B>'));

            $albumArtist = mb_substr($topAlbumsArray[$ctr], mb_strpos($topAlbumsArray[$ctr], '<ViewArtist') + 11, mb_strlen($topAlbumsArray[$ctr]));

            $albumArtist = mb_substr($albumArtist, mb_strpos($albumArtist, '>') + 1, mb_strlen($albumArtist));

            $albumArtist = mb_substr($albumArtist, 0, mb_strpos($albumArtist, '</'));

            $albumGenre = mb_substr($topAlbumsArray[$ctr], mb_strpos($topAlbumsArray[$ctr], '<ViewGenre') + 10, mb_strlen($topAlbumsArray[$ctr]));

            $albumGenre = mb_substr($albumGenre, mb_strpos($albumGenre, ': ') + 1, mb_strlen($albumGenre));

            $albumGenre = mb_substr($albumGenre, 0, mb_strpos($albumGenre, '</'));

            $albumPrice = mb_substr($topAlbumsArray[$ctr], mb_strpos($topAlbumsArray[$ctr], '$') + 1, mb_strlen($topAlbumsArray[$ctr]));

            $albumPrice = mb_substr($albumPrice, 0, mb_strpos($albumPrice, '</'));

            $albumID = mb_substr($topAlbumsArray[$ctr], mb_strpos($topAlbumsArray[$ctr], 'id="') + 4, mb_strlen($topAlbumsArray[$ctr]));

            $albumID = mb_substr($albumID, 0, mb_strpos($albumID, '"'));

            $top4Albums[$c]['image'] = $albumImage;

            $top4Albums[$c]['album'] = $albumName;

            $top4Albums[$c]['artist'] = $albumArtist;

            $top4Albums[$c]['genre'] = $albumGenre;

            $top4Albums[$c]['price'] = $albumPrice;

            $top4Albums[$c]['ID'] = $albumID;

            $c++;

            if (4 == $c) {
                $ctr = count($topAlbumsArray) + 2;
            }
        }
    }

    // Now let's see if we should return yet

    if ('top4Albums' == $returnWhat) {
        $return = $top4Albums ?? null;

        return $return;
    }

    // Now let's move to the top songs

    $xmlData = mb_substr($xmlData, mb_strpos($xmlData, '>Top Songs'), mb_strlen($xmlData));

    $topSongs = mb_substr($xmlData, 0, mb_strpos($xmlData, '<View '));

    $topSongs = mb_substr($topSongs, mb_strpos($topSongs, '<TextView'), mb_strlen($topSongs));

    $tsArray = explode('</TextView>', $topSongs);

    $c = 0;

    for ($ctr = 0, $ctrMax = count($tsArray); $ctr < $ctrMax; $ctr++) {
        $topTrack = mb_substr($tsArray[$ctr], mb_strpos($tsArray[$ctr], '<ViewAlbum'), mb_strlen($tsArray[$ctr]));

        $topTrack = mb_substr($topTrack, mb_strpos($topTrack, '>') + 1, mb_strlen($topTrack));

        $topTrack = mb_substr($topTrack, 0, mb_strpos($topTrack, '</'));

        $trackID = mb_substr($tsArray[$ctr], mb_strpos($tsArray[$ctr], 'id="') + 4, mb_strlen($tsArray[$ctr]));

        $trackID = mb_substr($trackID, 0, mb_strpos($trackID, '"'));

        $topTracks[$c]['ID'] = $trackID;

        $topTracks[$c]['name'] = $topTrack;

        $c++;
    }

    // Now let's see if we should return yet

    if ('topTracks' == $returnWhat) {
        $return = $topTracks ?? null;

        return $return;
    }

    // Now let's get the top artist matches

    $xmlData = mb_substr($xmlData, mb_strpos($xmlData, '>Top Artists<'), mb_strlen($xmlData));

    $topArtist = mb_substr($xmlData, mb_strpos($xmlData, '<TextView'), mb_strlen($xmlData));

    $topArtist = mb_substr($topArtist, 0, mb_strpos($topArtist, '</VBoxView>'));

    $taArray = explode('</TextView>', $topArtist);

    $c = 0;

    for ($ctr = 0, $ctrMax = count($taArray); $ctr < $ctrMax; $ctr++) {
        $taData = mb_substr($taArray[$ctr], mb_strpos($taArray[$ctr], '<ViewArtist'), mb_strlen($taArray[$ctr]));

        $taData = mb_substr($taData, mb_strpos($taData, '>') + 1, mb_strlen($taData));

        $taData = mb_substr($taData, 0, mb_strpos($taData, '<'));

        $artistID = mb_substr($tsArray[$ctr], mb_strpos($tsArray[$ctr], 'id="') + 4, mb_strlen($tsArray[$ctr]));

        $artistID = mb_substr($artistID, 0, mb_strpos($artistID, '"'));

        $topArtists[$c]['name'] = $taData;

        $topArtists[$c]['ID'] = $artistID;

        $c++;
    }

    // Now let's see if we should return yet

    if ('topArtists' == $returnWhat) {
        $return = $topArtists ?? null;

        return $return;
    }

    // Now let's get the tracks

    $xmlData = mb_substr($xmlData, mb_strpos($xmlData, '<TrackList>') + mb_strlen('<TrackList>'), mb_strlen($xmlData));

    $trackArray = explode('</dict>', $xmlData);

    $i = 0;

    for ($ctr = 0, $ctrMax = count($trackArray); $ctr < $ctrMax; $ctr++) {
        // Now let's get all the data for this track

        $valArray = explode("\n", $trackArray[$ctr]);

        for ($c = 0, $cMax = count($valArray); $c < $cMax; $c++) {
            if ('' != trim($valArray[$c])) {
                $searchArray = explode('|', $searchVals);

                for ($e = 0, $eMax = count($searchArray); $e < $eMax; $e++) {
                    if (mb_stristr($valArray[$c], '<key>' . $searchArray[$e] . '</key>')) {
                        // Now let's clean up the data

                        $retData = $valArray[$c];

                        $retData = mb_substr($retData, mb_strpos($retData, '</key>') + 6, mb_strlen($retData));

                        $retData = mb_substr($retData, mb_strpos($retData, '>') + 1, mb_strlen($retData));

                        $retData = mb_substr($retData, 0, mb_strpos($retData, '</'));

                        // Now let's set the array with the proper data

                        $trackData[$i][$searchArray[$e]] = $retData;
                    }
                }
            }
        }

        $i++;
    }

    // Now let's return the data

    $return = $trackData ?? null;

    return $return;
}

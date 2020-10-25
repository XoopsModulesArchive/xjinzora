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
 * - Jinzora Author: Ross Carlson <ross@jinzora.org>
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
 * Handles all Jinzora's searching functions
 *
 * @since  02/11/04
 * @author Ross Carlson <ross@jinzora.org>
 * @param mixed $searchData
 * @param mixed $searchType
 */

/*
* This function handles the searching of Allmusic.com for what they wanted to seach on
* And directs them to that new page
*
* @access private
* @author Ross Carlson
* @version 02/11/04
* @since 02/11/04
*/
function searchAMG($searchData, $searchType)
{
    global $this_page, $url_seperator;

    // let's make sure that the form auto submits on load

    echo '<body onLoad="document.amgsearch.submit();">';

    // Now let's echo the form for the search

    echo '<form name="amgsearch" action="http://www.allmusic.com/cg/amg.dll" method=POST target="_blank">' . '<input type=HIDDEN name=P value=amg>' . "<input type=HIDDEN name=sql size=15 maxlength=30 value=\"$searchData\">" . '<input type=HIDDEN ';

    // Now let's set the type of search

    switch ($searchType) {
        case 'albums':
            echo ' value=2 ';
            break;
        case 'artists':
            echo ' value=1 ';
            break;
        case 'songs':
            echo ' value=3 ';
            break;
    }

    echo 'name=opt1></form>';

    // Now let's send them back

    $ref_url = $this_page . $url_seperator . 'ptype=' . $_GET['ptype'] . '&genre=' . urlencode($_GET['genre']) . '&artist=' . urlencode($_GET['artist']) . '&album=' . urlencode($_GET['album']);

    echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=' . $ref_url . '">';
}

/**
 * Reads all track XML file data into a HUGE array for searching
 *
 * @author  Ross Carlson
 * @version 04/29/04
 * @since   04/29/04
 */
function processXMLforSearch()
{
    global $web_root, $root_dir, $word_please_wait;

    // Ok, first we need to get all the files

    $retArray = readDirInfo($web_root . $root_dir . '/data/tracks', 'file');

    // Now let's loop through and process them

    $data = $word_please_wait . '<br>';

    for ($c = 0, $cMax = count($retArray); $c < $cMax; $c++) {
        if (mb_stristr($retArray[$c], '.xml')) {
            // Let's update the please wait word...

            if (0 == $c % 50) {
                $data .= ' .'; ?>
                <script language="JavaScript">
                    <!--
                    function set<?php echo $c; ?>Description(type) {
                        descCell = document.getElementById("pleasewaitcell");
                        descText = "<?php echo $data; ?>";
                        descCell.innerHTML = descText;
                    }

                    set<?php echo $c; ?>Description();
                    // -->
                </script>
                <?php
                flushDisplay();
            }

            // Now let's process each file, one by one

            $dataArray[] = getTracksInfosFromXML($web_root . $root_dir . '/data/tracks/' . $retArray[$c], false, false);
        }
    }

    // Now let's return that big ass array!

    return $dataArray;
}

/**
 * Preform the power search
 *
 * @author  Ross Carlson
 * @version 04/29/04
 * @since   04/29/04
 */
function powerSearch()
{
    global $web_root;

    // Ok, let's get all the variables

    // We need to see if they seached from the form or the URL

    if (isset($_GET['doSearch'])) {
        $song_title = $_GET['song_title'] ?? '';

        $artist = $_GET['artist'] ?? '';

        $album = $_GET['album'] ?? '';

        $genre = $_GET['genre'] ?? '';

        $artist_select = $_GET['artist_select'] ?? '';

        $album_select = $_GET['album_select'] ?? '';

        $genre_select = $_GET['genre_select'] ?? '';

        $duration = $_GET['duration'] ?? '';

        $duration_operator = $_GET['duration_operator'] ?? '';

        $duration_type = $_GET['duration_type'] ?? '';

        $track_number_operator = $_GET['track_number_operator'] ?? '';

        $track_number = $_GET['track_number'] ?? '';

        $year = $_GET['year'] ?? '';

        $year_operator = $_GET['year_operator'] ?? '';

        $bit_rate_operator = $_GET['bit_rate_operator'] ?? '';

        $bit_rate = $_GET['bit_rate'] ?? '';

        $sample_rate_operator = $_GET['sample_rate_operator'] ?? '';

        $sample_rate = $_GET['sample_rate'] ?? '';

        $file_size_operator = $_GET['file_size_operator'] ?? '';

        $file_size = $_GET['file_size'] ?? '';

        $file_format = $_GET['file_format'] ?? '';

        $comment = $_GET['comment'] ?? '';

        $lyrics = $_GET['lyrics'] ?? '';

        $operator = $_GET['operator'] ?? '';
    } else {
        $song_title = $_POST['song_title'] ?? '';

        $artist = $_POST['artist'] ?? '';

        $album = $_POST['album'] ?? '';

        $genre = $_POST['genre'] ?? '';

        $artist_select = $_POST['artist_select'] ?? '';

        $album_select = $_POST['album_select'] ?? '';

        $genre_select = $_POST['genre_select'] ?? '';

        $duration = $_POST['duration'] ?? '';

        $duration_operator = $_POST['duration_operator'] ?? '';

        $duration_type = $_POST['duration_type'] ?? '';

        $track_number_operator = $_POST['track_number_operator'] ?? '';

        $track_number = $_POST['track_number'] ?? '';

        $year = $_POST['year'] ?? '';

        $year_operator = $_POST['year_operator'] ?? '';

        $bit_rate_operator = $_POST['bit_rate_operator'] ?? '';

        $bit_rate = $_POST['bit_rate'] ?? '';

        $sample_rate_operator = $_POST['sample_rate_operator'] ?? '';

        $sample_rate = $_POST['sample_rate'] ?? '';

        $file_size_operator = $_POST['file_size_operator'] ?? '';

        $file_size = $_POST['file_size'] ?? '';

        $file_format = $_POST['file_format'] ?? '';

        $comment = $_POST['comment'] ?? '';

        $lyrics = $_POST['lyrics'] ?? '';

        $operator = $_POST['operator'] ?? '';
    }

    // Now let's see if it was a home page serach

    if (isset($_POST['search_type'])) {
        $song_title = '';

        // Now let's see which one to set

        switch ($_POST['search_type']) {
            case 'tracks':
                $song_title = $_POST['song_title'];
                break;
            case 'genres':
                $genre = $_POST['song_title'];
                break;
            case 'artists':
                $artist = $_POST['song_title'];
                break;
            case 'albums':
                $album = $_POST['song_title'];
                break;
        }
    }

    // Ok, now we need to read ALL the track data in so we can search it

    $dataArray = processXMLforSearch();

    // Now let's search it

    for ($c = 0, $cMax = count($dataArray); $c < $cMax; $c++) {
        if (0 == count($dataArray[$c])) {
            continue;
        }

        foreach ($dataArray[$c] as $track) {
            $trackMatch = false;

            $fullMatch = '';

            // Ok, now let's do the search

            if ('' != $song_title) {
                if (mb_stristr(mb_strtolower($track['name']), mb_strtolower($song_title))) {
                    $trackMatch = true;
                } else {
                    $fullMatch .= 'F';
                }
            }

            if ('' != $song_title) {
                if (mb_stristr(mb_strtolower($track['filename']), mb_strtolower($song_title))) {
                    $trackMatch = true;

                    $fullMatch = '';
                } else {
                    $fullMatch .= 'F';
                }
            }

            if ('' != $artist) {
                // Ok, we need to see if they used an and/or here

                if (mb_stristr($artist, ' and ') or mb_stristr($artist, ' or ')) {
                    $op_match = false;

                    // Ok, let's split it out

                    if (mb_stristr($artist, ' or ')) {
                        $searchVals = explode(' or ', $artist);

                        for ($e = 0, $eMax = count($searchVals); $e < $eMax; $e++) {
                            if (mb_stristr(mb_strtolower($track['artist']), mb_strtolower($searchVals[$e]))) {
                                $op_match = true;
                            }
                        }

                        if ($op_match) {
                            $artistMatches[$c] = $track;

                            $trackMatch = true;
                        } else {
                            $fullMatch .= 'F';
                        } // This is if we wanted this, but it didn't exist
                    }

                    if (mb_stristr($artist, ' and ')) {
                        $searchVals = explode(' and ', $artist);

                        for ($e = 0, $eMax = count($searchVals); $e < $eMax; $e++) {
                            if (mb_stristr(mb_strtolower($track['artist']), mb_strtolower($searchVals[$e]))) {
                                $op_match = true;
                            }
                        }

                        if ($op_match) {
                            $artistMatches[$c] = $track;

                            $trackMatch = true;
                        } else {
                            $fullMatch .= 'F';
                        } // This is if we wanted this, but it didn't exist
                    }
                } else {
                    // Ok, simple search

                    if (mb_stristr(mb_strtolower($track['artist']), mb_strtolower($artist))) {
                        $artistMatches[$c] = $track;

                        $trackMatch = true;
                    } else {
                        $fullMatch .= 'F';
                    } // This is if we wanted this, but it didn't exist
                }
            }

            if ('' != $artist_select) {
                if (mb_stristr(mb_strtolower($track['artist']), mb_strtolower($artist_select))) {
                    $artistMatches[$c] = $track;

                    $trackMatch = true;
                } else {
                    $fullMatch .= 'F';
                } // This is if we wanted this, but it didn't exist
            }

            if ('' != $album) {
                if (mb_stristr($album, ' and ') or mb_stristr($album, ' or ')) {
                    $op_match = false;

                    // Ok, let's split it out

                    if (mb_stristr($album, ' or ')) {
                        $searchVals = explode(' or ', $album);

                        for ($e = 0, $eMax = count($searchVals); $e < $eMax; $e++) {
                            if (mb_stristr(mb_strtolower($track['album']), mb_strtolower($searchVals[$e]))) {
                                $op_match = true;
                            }
                        }

                        if ($op_match) {
                            $albumMatches[$c] = $track;

                            $trackMatch = true;
                        } else {
                            $fullMatch .= 'F';
                        } // This is if we wanted this, but it didn't exist
                    }

                    if (mb_stristr($album, ' and ')) {
                        $searchVals = explode(' and ', $album);

                        for ($e = 0, $eMax = count($searchVals); $e < $eMax; $e++) {
                            if (mb_stristr(mb_strtolower($track['album']), mb_strtolower($searchVals[$e]))) {
                                $op_match = true;
                            }
                        }

                        if ($op_match) {
                            $albumMatches[$c] = $track;

                            $trackMatch = true;
                        } else {
                            $fullMatch .= 'F';
                        } // This is if we wanted this, but it didn't exist
                    }
                } else {
                    // Ok, simple search

                    if (mb_stristr(mb_strtolower($track['album']), mb_strtolower($album))) {
                        $albumMatches[$c] = $track;

                        $trackMatch = true;
                    } else {
                        $fullMatch .= 'F';
                    } // This is if we wanted this, but it didn't exist
                }
            }

            if ('' != $album_select) {
                if (mb_stristr(mb_strtolower($track['album']), mb_strtolower($album_select))) {
                    $albumMatches[$c] = $track;

                    $trackMatch = true;
                } else {
                    $fullMatch .= 'F';
                } // This is if we wanted this, but it didn't exist
            }

            if ('' != $genre) {
                if (mb_stristr($genre, ' and ') or mb_stristr($genre, ' or ')) {
                    $op_match = false;

                    // Ok, let's split it out

                    if (mb_stristr($genre, ' or ')) {
                        $searchVals = explode(' or ', $genre);

                        for ($e = 0, $eMax = count($searchVals); $e < $eMax; $e++) {
                            if (mb_stristr(mb_strtolower($track['genre']), mb_strtolower($searchVals[$e]))) {
                                $op_match = true;
                            }
                        }

                        if ($op_match) {
                            $genreMatches[$c] = $track;

                            $trackMatch = true;
                        } else {
                            $fullMatch .= 'F';
                        } // This is if we wanted this, but it didn't exist
                    }

                    if (mb_stristr($genre, ' and ')) {
                        $searchVals = explode(' and ', $genre);

                        for ($e = 0, $eMax = count($searchVals); $e < $eMax; $e++) {
                            if (mb_stristr(mb_strtolower($track['genre']), mb_strtolower($searchVals[$e]))) {
                                $op_match = true;
                            }
                        }

                        if ($op_match) {
                            $genreMatches[$c] = $track;

                            $trackMatch = true;
                        } else {
                            $fullMatch .= 'F';
                        } // This is if we wanted this, but it didn't exist
                    }
                } else {
                    if (mb_stristr(mb_strtolower($track['genre']), mb_strtolower($genre))) {
                        $genreMatches[$c] = $track;

                        $trackMatch = true;
                    } else {
                        $fullMatch .= 'F';
                    } // This is if we wanted this, but it didn't exist
                }
            }

            if ('' != $genre_select) {
                if (mb_stristr(mb_strtolower($track['genre']), mb_strtolower($genre_select))) {
                    $genreMatches[$c] = $track;

                    $trackMatch = true;
                } else {
                    $fullMatch .= 'F';
                } // This is if we wanted this, but it didn't exist
            }

            // Now let's look at the duration

            if ('' != $duration) {
                if ('-' != $track['length_seconds']) {
                    // Now let's make the search criteria seconds no matter what...

                    if ('minutes' == $duration_type) {
                        $duration = convertMinsSecs($_POST['duration']);
                    } else {
                        $duration = $_POST['duration'];
                    }

                    // Now let's compare

                    switch ($duration_operator) {
                        case '<':
                            if ($track['length_seconds'] < $duration) {
                                $trackMatch = true;
                            } else {
                                $fullMatch .= 'F';
                            }
                            break;
                        case '>':
                            if ($track['length_seconds'] > $duration) {
                                $trackMatch = true;
                            } else {
                                $fullMatch .= 'F';
                            }
                            break;
                        case '=':
                            if ($duration == $track['length_seconds']) {
                                $trackMatch = true;
                            } else {
                                $fullMatch .= 'F';
                            }
                            break;
                    }// end switch
                } else {
                    $fullMatch .= 'F';
                } // This is if we wanted this, but it didn't exist
            }// End if

            // Now let's look at the track number

            if ('' != $track_number) {
                if ('-' != $track['number']) {
                    // Now let's compare

                    switch ($track_number_operator) {
                        case '<':
                            if ($track['number'] < $track_number) {
                                $trackMatch = true;
                            } else {
                                $fullMatch .= 'F';
                            }
                            break;
                        case '>':
                            if ($track['number'] > $track_number) {
                                $trackMatch = true;
                            } else {
                                $fullMatch .= 'F';
                            }
                            break;
                        case '=':
                            if ($track_number == $track['number']) {
                                $trackMatch = true;
                            } else {
                                $fullMatch .= 'F';
                            }
                            break;
                    }// end switch
                } else {
                    $fullMatch .= 'F';
                } // This is if we wanted this, but it didn't exist
            }// End if

            // Now let's look at the track year

            if ('' != $year) {
                if ('-' != $track['year']) {
                    // Now let's compare

                    switch ($year_operator) {
                        case '<':
                            if ($track['year'] < $year) {
                                $trackMatch = true;
                            } else {
                                $fullMatch .= 'F';
                            }
                            break;
                        case '>':
                            if ($track['year'] > $year) {
                                $trackMatch = true;
                            } else {
                                $fullMatch .= 'F';
                            }
                            break;
                        case '=':
                            if ($year == $track['year']) {
                                $trackMatch = true;
                            } else {
                                $fullMatch .= 'F';
                            }
                            break;
                    }// end switch
                } else {
                    $fullMatch .= 'F';
                } // This is if we wanted this, but it didn't exist
            }// End if

            // Now let's look at the bit rate

            if ('' != $bit_rate) {
                if ('-' != $track['rate']) {
                    // Now let's compare

                    switch ($bit_rate_operator) {
                        case '<':
                            if ($track['rate'] < $bit_rate) {
                                $trackMatch = true;
                            } else {
                                $fullMatch .= 'F';
                            }
                            break;
                        case '>':
                            if ($track['rate'] > $bit_rate) {
                                $trackMatch = true;
                            } else {
                                $fullMatch .= 'F';
                            }
                            break;
                        case '=':
                            if ($bit_rate == $track['rate']) {
                                $trackMatch = true;
                            } else {
                                $fullMatch .= 'F';
                            }
                            break;
                    }// end switch
                } else {
                    $fullMatch .= 'F';
                } // This is if we wanted this, but it didn't exist
            }

            // Now let's look at the sample rate

            if ('' != $sample_rate) {
                if ('-' != $track['freq']) {
                    // Now let's compare

                    switch ($sample_rate_operator) {
                        case '<':
                            if ($track['freq'] < $sample_rate) {
                                $trackMatch = true;
                            } else {
                                $fullMatch .= 'F';
                            }
                            break;
                        case '>':
                            if ($track['freq'] > $sample_rate) {
                                $trackMatch = true;
                            } else {
                                $fullMatch .= 'F';
                            }
                            break;
                        case '=':
                            if ($sample_rate == $track['freq']) {
                                $trackMatch = true;
                            } else {
                                $fullMatch .= 'F';
                            }
                            break;
                    }// end switch
                } else {
                    $fullMatch .= 'F';
                } // This is if we wanted this, but it didn't exist
            }// End if

            // Now let's look at the file size

            if ('' != $file_size) {
                if ('-' != $track['size']) {
                    // Now let's compare

                    switch ($file_size_operator) {
                        case '<':
                            if ($track['size'] < $file_size) {
                                $trackMatch = true;
                            } else {
                                $fullMatch .= 'F';
                            }
                            break;
                        case '>':
                            if ($track['size'] > $file_size) {
                                $trackMatch = true;
                            } else {
                                $fullMatch .= 'F';
                            }
                            break;
                        case '=':
                            if ($file_size == $track['freq']) {
                                $trackMatch = true;
                            } else {
                                $fullMatch .= 'F';
                            }
                            break;
                    }// end switch
                } else {
                    $fullMatch .= 'F';
                } // This is if we wanted this, but it didn't exist
            }// End if

            // Now let's look at the file size

            if ('' != $file_format) {
                // Now let's compare

                if ($track['fileExt'] == $file_format) {
                    $trackMatch = true;
                } else {
                    $fullMatch .= 'F';
                }
            }// End if

            // Now let's look at the comments

            if ('' != $comment) {
                // Now let's compare

                if (mb_stristr(mb_strtolower($track['mp3_comment']), mb_strtolower($comment)) or mb_stristr(mb_strtolower($track['long_desc']), mb_strtolower($comment))) {
                    $trackMatch = true;
                } else {
                    $fullMatch .= 'F';
                }
            }// End if

            // Now let's look at the lyrics

            if ('' != $lyrics) {
                // Now let's compare

                if (mb_stristr(mb_strtolower($track['lyrics']), mb_strtolower($lyrics))) {
                    $trackMatch = true;
                } else {
                    $fullMatch .= 'F';
                }
            }// End if

            // Let's see if we found anything

            $reallyAdd = false;

            if ($trackMatch) {
                // Was this an AND or OR search

                if ('and' == $operator) {
                    // Did we find a complete match?

                    if (!mb_stristr($fullMatch, 'F')) {
                        $reallyAdd = true;
                    }
                } else {
                    $reallyAdd = true;
                }
            }

            // Now let's see if we're really going to add it

            // We need to make sure the match actually exists first

            if ($reallyAdd) {
                // Ok, does the file exist?

                if (is_file($web_root . $track['path'])) {
                    $trackMatches[] = $track;
                }
            }
        }
    }

    // Let's update the please wait word... ?>
    <script language="JavaScript">
        <!--
        function set2ndDescription(type) {
            descCell = document.getElementById("pleasewaitcell");
            descText = "";
            descCell.innerHTML = descText;
        }

        set2ndDescription();
        // -->
    </script>
    <?php

    // Now let's display the matches
    if (isset($trackMatches)) {
        displayTrackMatches($trackMatches);
    } else {
        echo '<br><center>' . word_no_results . '</center><br>';

        displayPowerSearch(false);
    }

    if (isset($artistMatches)) {
        //displayArtistMatches($artistMatches);
    }

    if (isset($albumMatches)) {
        //displayAlbumMatches($albumMatches);
    }

    if (isset($genreMatches)) {
        //displayGenreMatches($genreMatches);
    }

    echo '<br><br>';
}

/**
 * This fixes up a URL
 *
 * @param mixed $string
 * @return string|string[]
 * @return string|string[]
 * @since   04/30/04
 * @author  Ross Carlson
 * @version 04/30/04
 */
function preparePathURL($string)
{
    global $root_dir, $media_dir;

    return str_replace($root_dir . $media_dir, '', str_replace('%2F', '/', urlencode($string)));
}

/**
 * Display the track match results from power search
 *
 * @author  Ross Carlson
 * @version 04/30/04
 * @since   04/30/04
 * @param mixed $dataArray
 */
function displayTrackMatches($dataArray)
{
    global $row_colors, $cellspacing, $img_download, $img_more, $img_play, $web_root, $root_dir, $media_dir, $word_artist, $word_album, $word_genre, $directory_level, $this_page, $url_seperator;

    // Let's tell them what this is

    echo '<center><strong>' . word_track_matches . '</strong></center><br>';

    // Now let's start our main table

    jzTableOpen('100', $cellspacing, 'jz_track_table');

    $i = 1;

    // Let's display our header row

    jzTROpen($row_colors[0]);

    jzTDOpen('1', 'center', 'top', 'jz_track_table_songs_td', '');

    echo '&nbsp;';

    jzTDClose();

    jzTDOpen('1', 'center', 'top', 'jz_track_table_songs_td', '');

    echo '&nbsp;';

    jzTDClose();

    jzTDOpen('1', 'center', 'top', 'jz_track_table_songs_td', '');

    echo '&nbsp;';

    jzTDClose();

    jzTDOpen('30', 'left', 'top', 'jz_track_table_songs_td', '');

    echo '<strong>Track Name</strong>';

    jzTDClose();

    if ('3' == $directory_level or '2' == $directory_level) {
        jzTDOpen('15', 'left', 'top', 'jz_track_table_songs_td', '');

        echo '<strong>' . $word_artist . '</strong>';

        jzTDClose();
    }

    jzTDOpen('15', 'left', 'top', 'jz_track_table_songs_td', '');

    echo '<strong>' . $word_album . '</strong>';

    jzTDClose();

    // Let's make sure they get this

    if ('3' == $directory_level) {
        jzTDOpen('15', 'left', 'top', 'jz_track_table_songs_td', '');

        echo '<strong>' . $word_genre . '</strong>';

        jzTDClose();
    }

    jzTDOpen('1', 'center', 'top', 'jz_track_table_songs_td', '');

    echo '<nobr><strong>' . word_length . '</strong></nobr>';

    jzTDClose();

    jzTDOpen('1', 'center', 'top', 'jz_track_table_songs_td', '');

    echo '<nobr><strong>' . word_bit_rate . '</strong></nobr>';

    jzTDClose();

    jzTDOpen('1', 'center', 'top', 'jz_track_table_songs_td', '');

    echo '<nobr><strong>' . word_sample_rate . '</strong></nobr>';

    jzTDClose();

    jzTDOpen('1', 'center', 'top', 'jz_track_table_songs_td', '');

    echo '<nobr><strong>' . word_size . '</strong></nobr>';

    jzTDClose();

    jzTRClose();

    // Let's loop through our results

    foreach ($dataArray as $track) {
        // Let's start our table

        jzTROpen($row_colors[$i]);

        jzTDOpen('1', 'center', 'top', 'jz_track_table_songs_td', '');

        echo '<a href="' . $root_dir . '/download.php?info=' . preparePathURL($track['path']) . '">' . $img_download . '</a>';

        jzTDClose();

        jzTDOpen('1', 'center', 'top', 'jz_track_table_songs_td', '');

        echo '<a href="' . $root_dir . '/mp3info.php?file=' . $web_root . $track['path'] . '" target="_blank" onclick="newWin(this); return false;">' . $img_more . '</a>';

        jzTDClose();

        jzTDOpen('1', 'center', 'top', 'jz_track_table_songs_td', '');

        echo '<a href="' . $root_dir . '/playlists.php?d=1&qptype=song&style=normal&info=' . preparePathURL($track['path']) . '">' . $img_play . '</a>';

        jzTDClose();

        jzTDOpen('30', 'left', 'top', 'jz_track_table_songs_td', '');

        echo '<a href="' . $root_dir . '/playlists.php?d=1&qptype=song&style=normal&info=' . preparePathURL($track['path']) . '">' . $track['name'] . '</a>';

        jzTDClose();

        // Let's make sure we can see this

        if ('3' == $directory_level or '2' == $directory_level) {
            jzTDOpen('15', 'left', 'top', 'jz_track_table_songs_td', '');

            // Let's build the URL for this

            switch ($directory_level) {
                case '3':
                    $url = $this_page . $url_seperator . 'ptype=artist&genre=' . urlencode($track['genre']) . '&artist=' . urlencode($track['artist']);
                    break;
                case '2':
                    $url = $this_page . $url_seperator . 'ptype=artist&genre=&artist=' . urlencode($track['artist']);
                    break;
            }

            echo '<a href="' . $url . '">' . $track['artist'] . '</a>';

            jzTDClose();
        }

        jzTDOpen('15', 'left', 'top', 'jz_track_table_songs_td', '');

        // Let's build the URL for this

        switch ($directory_level) {
            case '3':
                $url = $this_page . $url_seperator . 'ptype=songs&genre=' . urlencode($track['genre']) . '&artist=' . urlencode($track['artist']) . '&album=' . urlencode($track['album']);
                break;
            case '2':
                $url = $this_page . $url_seperator . 'ptype=songs&genre=&artist=' . urlencode($track['artist']) . '&album=' . urlencode($track['album']);
                break;
            case '1':
                $url = $this_page . $url_seperator . 'ptype=songs&genre=&artist=&album=' . urlencode($track['album']);
                break;
        }

        echo '<a href="' . $url . '">' . $track['album'] . '</a>';

        jzTDClose();

        // Let's make sure they get this

        if ('3' == $directory_level) {
            jzTDOpen('15', 'left', 'top', 'jz_track_table_songs_td', '');

            // Let's build the URL for this

            $url = $this_page . $url_seperator . 'ptype=genre&genre=' . urlencode($track['genre']);

            echo '<a href="' . $url . '">' . $track['genre'] . '</a>';

            jzTDClose();
        }

        jzTDOpen('1', 'center', 'top', 'jz_track_table_songs_td', '');

        echo '<nobr> ' . $track['length'] . ' </nobr>';

        jzTDClose();

        jzTDOpen('1', 'center', 'top', 'jz_track_table_songs_td', '');

        if ('-' != $track['rate']) {
            echo '<nobr> ' . $track['rate'] . ' kbps' . ' </nobr>';
        } else {
            echo ' - ';
        }

        jzTDClose();

        jzTDOpen('1', 'center', 'top', 'jz_track_table_songs_td', '');

        if ('-' != $track['freq']) {
            echo '<nobr> ' . $track['freq'] . ' kHz' . ' </nobr>';
        } else {
            echo ' - ';
        }

        jzTDClose();

        jzTDOpen('1', 'center', 'top', 'jz_track_table_songs_td', '');

        if ('0' != $track['size']) {
            echo '<nobr> ' . $track['size'] . ' Mb' . ' </nobr>';
        } else {
            echo ' - ';
        }

        jzTDClose();

        // Now let's close the row

        jzTRClose();

        $i = ++$i % 2;

        // Now let's flush it out

        flushDisplay();
    }

    // Now let's close the table

    jzTableClose();
}

/**
 * Display the power search page
 *
 * @author  Ross Carlson
 * @version 04/29/04
 * @since   04/29/04
 * @param mixed $showHeadFoot
 */
function displayPowerSearch($showHeadFoot = true)
{
    global $this_page, $word_artist, $word_album, $word_genre, $audio_types, $video_types, $word_search, $directory_level;

    // First let's show the header

    if ($showHeadFoot) {
        displayHeader(word_power_search);
    }

    // Let's show them the link to search iTunes

    echo '<center><a href="/dev/jinzora/index.php?search=itunes&info=">Search iTunes Music Store</a><br><br></center>';

    // Now let's show the power search form

    echo '<form action="' . $this_page . '" method="POST">' . "\n";

    // Let's start displaying

    jzTableOpen('100', '3', 'jz_track_table');

    // This is the song title line

    jzTROpen();

    jzTDOpen('38', 'left', 'top', 'jz_header_table_td', '');

    echo '&nbsp;';

    jzTDClose();

    jzTDOpen('7', 'left', 'top', 'jz_header_table_td', '');

    echo '<nobr>' . word_operator . ':' . '</nobr>';

    jzTDClose();

    jzTDOpen('55', 'left', 'top', 'jz_header_table_td', '');

    echo '<input type="radio" name="operator" checked value="and"> ' . word_and . ' <input type="radio" name="operator" value="or"> ' . word_or;

    jzTDClose();

    jzTRClose();

    // This is the song title line

    jzTROpen();

    jzTDOpen('38', 'left', 'top', 'jz_header_table_td', '');

    echo '&nbsp;';

    jzTDClose();

    jzTDOpen('7', 'left', 'top', 'jz_header_table_td', '');

    echo '<nobr>' . word_song_title . '</nobr>';

    jzTDClose();

    jzTDOpen('55', 'left', 'top', 'jz_header_table_td', '');

    echo '<input type="input" name="song_title" class="jz_input" size="30">';

    jzTDClose();

    jzTRClose();

    // This is the artists title line

    jzTROpen();

    jzTDOpen('38', 'left', 'top', 'jz_header_table_td', '');

    echo '&nbsp;';

    jzTDClose();

    jzTDOpen('7', 'left', 'top', 'jz_header_table_td', '');

    echo '<nobr>' . $word_artist . '</nobr>';

    jzTDClose();

    jzTDOpen('55', 'left', 'top', 'jz_header_table_td', '');

    echo '<input type="input" name="artist" class="jz_input" size="20"> ';

    echo returnArtistSelect(false, 'artist_select', '100');

    jzTDClose();

    jzTRClose();

    // This is the album title line

    jzTROpen();

    jzTDOpen('38', 'left', 'top', 'jz_header_table_td', '');

    echo '&nbsp;';

    jzTDClose();

    jzTDOpen('7', 'left', 'top', 'jz_header_table_td', '');

    echo '<nobr>' . $word_album . '</nobr>';

    jzTDClose();

    jzTDOpen('55', 'left', 'top', 'jz_header_table_td', '');

    echo '<input type="input" name="album" class="jz_input" size="20"> ';

    echo returnAlbumSelect(false, 'album_select', '100');

    jzTDClose();

    jzTRClose();

    // This is the genre title line

    jzTROpen();

    jzTDOpen('38', 'left', 'top', 'jz_header_table_td', '');

    echo '&nbsp;';

    jzTDClose();

    jzTDOpen('7', 'left', 'top', 'jz_header_table_td', '');

    echo '<nobr>' . $word_genre . '</nobr>';

    jzTDClose();

    jzTDOpen('55', 'left', 'top', 'jz_header_table_td', '');

    echo '<input type="input" name="genre" class="jz_input" size="20"> ';

    echo returnGenreSelect(false, 'genre_select', '100');

    jzTDClose();

    jzTRClose();

    // This is the song duration line

    jzTROpen();

    jzTDOpen('38', 'left', 'top', 'jz_header_table_td', '');

    echo '&nbsp;';

    jzTDClose();

    jzTDOpen('7', 'left', 'top', 'jz_header_table_td', '');

    echo '<nobr>' . word_duration . '</nobr>';

    jzTDClose();

    jzTDOpen('55', 'left', 'top', 'jz_header_table_td', '');

    echo '<select class="jz_select" name="duration_operator"><option value="=">=</option><option value=">">></option><option value="<"><</option></select>';

    echo ' <input type="input" name="duration" class="jz_input" size="10">';

    echo ' <select style="width: 75px;" class="jz_select" name="duration_type"><option value="minutes">' . word_minutes . '</option><option value="seconds">' . word_seconds . '</option></select>';

    jzTDClose();

    jzTRClose();

    // This is the track number line

    jzTROpen();

    jzTDOpen('38', 'left', 'top', 'jz_header_table_td', '');

    echo '&nbsp;';

    jzTDClose();

    jzTDOpen('7', 'left', 'top', 'jz_header_table_td', '');

    echo '<nobr>' . word_track_number . '</nobr>';

    jzTDClose();

    jzTDOpen('55', 'left', 'top', 'jz_header_table_td', '');

    echo '<select class="jz_select" name="track_number_operator"><option value="=">=</option><option value=">">></option><option value="<"><</option></select>';

    echo ' <input type="input" name="track_number" class="jz_input" size="10">';

    jzTDClose();

    jzTRClose();

    // This is the track year line

    jzTROpen();

    jzTDOpen('38', 'left', 'top', 'jz_header_table_td', '');

    echo '&nbsp;';

    jzTDClose();

    jzTDOpen('7', 'left', 'top', 'jz_header_table_td', '');

    echo '<nobr>' . word_year;

    jzTDClose();

    jzTDOpen('55', 'left', 'top', 'jz_header_table_td', '');

    echo '<select class="jz_select" name="year_operator"><option value="=">=</option><option value=">">></option><option value="<"><</option></select>';

    echo ' <input type="input" name="year" class="jz_input" size="10">';

    jzTDClose();

    jzTRClose();

    // This is the track bit rate line

    jzTROpen();

    jzTDOpen('38', 'left', 'top', 'jz_header_table_td', '');

    echo '&nbsp;';

    jzTDClose();

    jzTDOpen('7', 'left', 'top', 'jz_header_table_td', '');

    echo '<nobr>' . word_bit_rate . '</nobr>';

    jzTDClose();

    jzTDOpen('55', 'left', 'top', 'jz_header_table_td', '');

    echo '<select class="jz_select" name="bit_rate_operator"><option value="=">=</option><option value=">">></option><option value="<"><</option></select>';

    $bit_rates = '32,40,48,56,64,80,96,112,128,160,192,224,256,320';

    $bitArray = explode(',', $bit_rates);

    rsort($bitArray);

    echo ' <select style="width: 60px;" class="jz_select" name="bit_rate">';

    echo '<option value=""> - </option>' . "\n";

    for ($c = 0, $cMax = count($bitArray); $c < $cMax; $c++) {
        echo '<option value="' . $bitArray[$c] . '">' . $bitArray[$c] . '</option>' . "\n";
    }

    echo '</select> kbps';

    jzTDClose();

    jzTRClose();

    // This is the track sample rate line

    jzTROpen();

    jzTDOpen('38', 'left', 'top', 'jz_header_table_td', '');

    echo '&nbsp;';

    jzTDClose();

    jzTDOpen('7', 'left', 'top', 'jz_header_table_td', '');

    echo '<nobr>' . word_sample_rate . '</nobr>';

    jzTDClose();

    jzTDOpen('55', 'left', 'top', 'jz_header_table_td', '');

    echo '<select class="jz_select" name="sample_rate_operator"><option value="=">=</option><option value=">">></option><option value="<"><</option></select>';

    $sample_rates = '48,44.1,32,24,22.05,16,12,11.025,8';

    $sampleArray = explode(',', $sample_rates);

    echo ' <select style="width: 60px;" class="jz_select" name="sample_rate">';

    echo '<option value=""> - </option>' . "\n";

    for ($c = 0, $cMax = count($sampleArray); $c < $cMax; $c++) {
        echo '<option value="' . $sampleArray[$c] . '">' . $sampleArray[$c] . '</option>' . "\n";
    }

    echo '</select> kHz';

    jzTDClose();

    jzTRClose();

    // This is the track size line

    jzTROpen();

    jzTDOpen('38', 'left', 'top', 'jz_header_table_td', '');

    echo '&nbsp;';

    jzTDClose();

    jzTDOpen('7', 'left', 'top', 'jz_header_table_td', '');

    echo '<nobr>' . word_file_size . '</nobr>';

    jzTDClose();

    jzTDOpen('55', 'left', 'top', 'jz_header_table_td', '');

    echo '<select class="jz_select" name="file_size_operator"><option value="=">=</option><option value=">">></option><option value="<"><</option></select>';

    echo ' <input type="input" name="file_size" class="jz_input" size="10"> Mb';

    jzTDClose();

    jzTRClose();

    // This is the track type line

    jzTROpen();

    jzTDOpen('38', 'left', 'top', 'jz_header_table_td', '');

    echo '&nbsp;';

    jzTDClose();

    jzTDOpen('7', 'left', 'top', 'jz_header_table_td', '');

    echo '<nobr>' . word_file_format . '</nobr>';

    jzTDClose();

    jzTDOpen('55', 'left', 'top', 'jz_header_table_td', '');

    echo ' <select style="width: 60px;" class="jz_select" name="file_format">';

    echo '<option value=""> - </option>' . "\n";

    $sampleArray = explode('|', $audio_types);

    for ($c = 0, $cMax = count($sampleArray); $c < $cMax; $c++) {
        echo '<option value="' . $sampleArray[$c] . '">' . $sampleArray[$c] . '</option>' . "\n";
    }

    $sampleArray = explode('|', $video_types);

    for ($c = 0, $cMax = count($sampleArray); $c < $cMax; $c++) {
        echo '<option value="' . $sampleArray[$c] . '">' . $sampleArray[$c] . '</option>' . "\n";
    }

    echo '</select>';

    jzTDClose();

    jzTRClose();

    // This is the comments title line

    jzTROpen();

    jzTDOpen('38', 'left', 'top', 'jz_header_table_td', '');

    echo '&nbsp;';

    jzTDClose();

    jzTDOpen('7', 'left', 'top', 'jz_header_table_td', '');

    echo '<nobr>' . word_comments . '</nobr>';

    jzTDClose();

    jzTDOpen('55', 'left', 'top', 'jz_header_table_td', '');

    echo '<input type="input" name="comment" class="jz_input" size="30">';

    jzTDClose();

    jzTRClose();

    // This is the lyrics line

    jzTROpen();

    jzTDOpen('38', 'left', 'top', 'jz_header_table_td', '');

    echo '&nbsp;';

    jzTDClose();

    jzTDOpen('7', 'left', 'top', 'jz_header_table_td', '');

    echo '<nobr>' . word_lyrics . '</nobr>';

    jzTDClose();

    jzTDOpen('55', 'left', 'top', 'jz_header_table_td', '');

    echo '<input type="input" name="lyrics" class="jz_input" size="30">';

    jzTDClose();

    jzTRClose();

    // This is the lyrics line

    jzTROpen();

    jzTDOpen('38', 'left', 'top', 'jz_header_table_td', '');

    echo '&nbsp;';

    jzTDClose();

    jzTDOpen('7', 'left', 'top', 'jz_header_table_td', '');

    jzTDClose();

    jzTDOpen('55', 'left', 'top', 'jz_header_table_td', '');

    echo '<br><input type="submit" name="doSearch" class="jz_submit" value="' . $word_search . '"><br><br>';

    jzTDClose();

    jzTRClose();

    // Now let's close out

    jzTableClose();

    echo '</form><br>';

    // Now let's show the footer

    if ($showHeadFoot) {
        displayFooter();
    }
}

?>

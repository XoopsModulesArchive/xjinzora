<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* JINZORA | Web-based Media Streamer
*
* Jinzora is a Web-based media streamer, primarily desgined to stream MP3s
* (but can be used for any media file that can stream from HTTP).
* Jinzora can be integrated into a PostNuke site, run as a standalone application,
* or integrated into any PHP website.  It is released under the GNU GPL.
*
* Jinzora Author:
* Ross Carlson: ross@jasbone.com
* http://www.jinzora.org
* Documentation: http://www.jinzora.org/docs
* Support: http://www.jinzora.org/forum
* Downloads: http://www.jinzora.org/downloads
* License: GNU GPL <http://www.gnu.org/copyleft/gpl.html>
*
* Contributors:
* Please see http://www.jinzora.org/modules.php?op=modload&name=jz_whois&file=index
*
* Code Purpose: This page contains the display functions for the Top track rating system
* Created: 9.24.03 by Ross Carlson
*
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

// Ok, is this thing in standalone mode or what?
if (isset($_GET['standalone'])) {
    if ('true' == $_GET['standalone']) {
        //Ok, now let's include what we need...

        require_once __DIR__ . '/settings.php';

        require_once __DIR__ . '/system.php';

        require_once __DIR__ . '/general.php';

        require_once __DIR__ . '/id3classes/getid3.php';

        // Now let's display the stylesheet

        echo $css;
    }
}

function cmp($a, $b)
{
    $cmp = strcmp($a[0], $b[0]);

    return $cmp ?: -1;
}

function cmp3($a, $b)
{
    $cmp = strcmp($a[2], $b[2]);

    return $cmp ?: -1;
}

// Ok, let's index the ratings directory and get the top 5 tracks
$retArray = readDirInfo($web_root . $root_dir . '/data/ratings/', 'file');

// Ok, now let's read each file and get the ratings
for ($ctr = 0, $ctrMax = count($retArray); $ctr < $ctrMax; $ctr++) {
    if ('' != $retArray[$ctr] and mb_stristr($retArray[$ctr], '.rating')) {
        $filename = $web_root . $root_dir . '/data/ratings/' . $retArray[$ctr];

        if (is_file($filename)) {
            $rating = readRating($filename);
        }

        $finalRateArray[$ctr][1] = str_replace('---', '/', str_replace('.rating', '', $retArray[$ctr]));

        $finalRateArray[$ctr][0] = $rating - 10;

        unset($rating);
    }
}

// Now let's sort that array
if (isset($finalRateArray)) {
    usort($finalRateArray, 'cmp');
}

// Let's make sure they wanted to see top tracks
if ('true' == $enable_ratings and '0' != $num_top_ratings and 0 != count($finalRateArray)) {
    displayRatedTracks($finalRateArray, 'true', $num_top_ratings, 'rating');

    unset($finalRateArray);
}

// Now let's display the most played tracks, if they wanted us to...
if ('true' == $enable_most_played and '0' != $num_most_played) {
    flushDisplay();

    // Ok, let's read the data directory and get all the track counter files

    $retArray = readDirInfo($web_root . $root_dir . '/data/counter/', 'file');

    $c = 0;

    for ($ctr = 0, $ctrMax = count($retArray); $ctr < $ctrMax; $ctr++) {
        if ('' != $retArray[$ctr] and mb_stristr($retArray[$ctr], '.ctr')) {
            $filename = $web_root . $root_dir . '/data/counter/' . $retArray[$ctr];

            $handle = fopen($filename, 'rb');

            $contents = fread($handle, filesize($filename));

            fclose($handle);

            $plays = $contents;

            // Now let's see if this track has a rating or not

            $filename = $web_root . $root_dir . '/data/ratings/' . str_replace('.ctr', '.rating', $retArray[$ctr]);

            if (is_file($filename)) {
                // Now let's get this files rating

                $rating = readRating($filename);
            } else {
                $rating = '-20';
            }

            // Now let's build an array that we can sort with

            $sortArray[$c] = ($plays - 99999) . '|' . $rating . '|' . str_replace('---', '/', str_replace('.ctr', '', $retArray[$ctr]));

            $c++;

            // Now let's put this data into an array with the number of plays and the track info

            unset($rating);

            unset($contents);
        }
    }

    // Now let's sort that array

    if (0 != count($sortArray)) {
        sort($sortArray);
    }

    // Now let's break that back out

    for ($ctr = 0, $ctrMax = count($sortArray); $ctr < $ctrMax; $ctr++) {
        //echo $sortArray[$ctr]. '<br>';

        $finalExp = explode('|', $sortArray[$ctr]);

        $finalRateArray[$ctr][1] = $finalExp[2];

        $finalRateArray[$ctr][0] = $finalExp[1] - 10;

        $finalRateArray[$ctr][2] = ($finalExp[0] + 99999);
    }

    // Now let's display what we got back

    if (0 != count($finalRateArray)) {
        displayRatedTracks($finalRateArray, 'true', $num_most_played, 'plays');
    }
}

function displayRatedTracks($finalRateArray, $displayTop, $numTracks, $trackTypes)
{
    global $mp3_dir, $audio_types, $video_types, $ext_graphic, $img_play, $img_download, $get_mp3_info, $song_cellpadding, $row_colors, $main_table_width, $this_page, $word_play_album, $word_download_album, $root_dir, $media_dir, $this_site, $allow_download, $track_num_seperator, $directory_level, $web_root, $num_other_albums, $word_album, $album_name_truncate, $word_play, $img_more, $search_album_art, $word_search_for_album_art, $img_delete, $word_cancel, $word_delete, $word_are_you_sure_delete, $img_add, $img_playlist, $word_check_all, $word_check_none, $word_selected, $word_session_playlist, $word_new_playlist, $playlist_ext, $word_play_random, $img_random_play, $javascript, $get_mp3_info, $colapse_tracks, $jinzora_skin, $word_search, $amg_search, $hide_tracks, $word_hide_tracks, $word_show_tracks, $postnuke, $download_mp3_only, $this_site, $word_change_art, $album_force_height, $album_force_width, $hide_id3_comments, $img_more_dis, $img_play_dis, $img_download_dis, $url_seperator, $enable_ratings, $img_rate, $img_star, $img_half_star, $num_top_ratings, $num_suggestions, $track_plays, $display_time, $display_rate, $display_feq, $display_size, $img_star_half_empty, $img_star_full_empty, $img_star_right, $img_star_half, $img_star_full, $img_star_left, $num_most_played, $word_top, $word_top_rated, $word_top_played;

    if ('true' == $displayTop) {
        if ('rating' == $trackTypes) {
            echo "<strong>$word_top $num_top_ratings $word_top_rated</strong><br>";
        }

        if ('plays' == $trackTypes) {
            echo "<strong>$word_top $num_most_played $word_top_played</strong><br>";
        }
    }

    echo '<table class="jz_track_table" width="' . $main_table_width . '%" cellpadding="' . $song_cellpadding . '" cellspacing="0" border="0">';

    /* Now let's populate our table with all the songs */

    $i = 1;

    for ($loop_ctr = 0, $loop_ctrMax = count($finalRateArray); $loop_ctr < $loop_ctrMax; $loop_ctr++) {
        if (preg_match("/\.($audio_types)$/i", $finalRateArray[$loop_ctr][1]) || preg_match("/\.($video_types)$/i", $finalRateArray[$loop_ctr][1]) || preg_match("/\.(fake.txt)$/i", $finalRateArray[$loop_ctr][1])) {
            $web_root . $root_dir . $media_dir . '/' . $finalRateArray[$loop_ctr][1] . '<br>';

            if (is_file($web_root . $root_dir . $media_dir . '/' . $finalRateArray[$loop_ctr][1])) {
                /* Now let's look and see if there is a corresponding descriptive text file, and if so display it */

                $fileInfo = pathinfo($finalRateArray[$loop_ctr][1]);

                $fileExt = $fileInfo['extension'];

                $desc_file_array[1] = $fileExt;

                $desc_file_array[0] = str_replace('.' . $fileExt, '', $finalRateArray[$loop_ctr][1]);

                // Let's see if this was a .fake file name and if so read it for the data

                if (preg_match("/\.(fake.txt)$/i", $finalRateArray[$loop_ctr][1])) {
                    $desc_file = $mp3_dir . '/' . $genre . '/' . $artist . '/' . $album . '/' . $finalRateArray[$loop_ctr][1];
                } else {
                    $desc_file = $mp3_dir . '/' . $genre . '/' . $artist . '/' . $album . '/' . $desc_file_array[0] . '.txt';
                }

                $mp3_comment = '';

                if (true === is_file($desc_file)) {
                    /* Ok, it's there so let's open it and display it */

                    $filename = $desc_file;

                    $handle = fopen($filename, 'rb');

                    $mp3_comment = fread($handle, filesize($filename));

                    fclose($handle);
                }

                // Let's initalize all these variables in each loop so we don't get dupes

                $mp3_freq = ' - ';

                $mp3_bitrate = ' - ';

                $mp3_size = ' - ';

                $mp3_leng = ' - ';

                $trackDispName = '';

                $desc_file = '';

                $artists = '';

                $album = '';

                // let's pull id3 and mp3 data from this file using our fancy classes IF they wanted us to

                if ('true' == $get_mp3_info) {
                    //$fileInfo = pathinfo($finalRateArray[$loop_ctr][1]);

                    //$fileExt = $fileInfo["extension"];

                    //$fileInfo = GetAllFileInfo($web_root. $root_dir. $media_dir. "/". $finalRateArray[$loop_ctr][1],$fileExt);

                    $getID3 = new getID3();

                    $fileInfo = $getID3->analyze($web_root . $root_dir . $media_dir . '/' . $finalRateArray[$loop_ctr][1]);

                    getid3_lib::CopyTagsToComments($fileInfo);

                    if (!empty($fileInfo['audio']['bitrate'])) {
                        $mp3_bitrate = (round($fileInfo['audio']['bitrate'] / 1000)) . ' kbps';
                    }

                    if (!empty($fileInfo['playtime_string'])) {
                        $mp3_leng = $fileInfo['playtime_string'];
                    }

                    if (!empty($fileInfo['playtime_string'])) {
                        $mp3_size = round($fileInfo['filesize'] / 1024000, 1) . ' Mb';
                    }

                    if (!empty($fileInfo['comments']['title'][0])) {
                        $trackDispName = $fileInfo['comments']['title'][0];
                    }

                    // Let's make sure they wanted the ID3 comments...

                    if ('false' == $hide_id3_comments) {
                        if (!empty($fileInfo['comments']['comment'][0]) and ('' == $mp3_comment)) {
                            $mp3_comment = $fileInfo['comments']['comment'][0];
                        }
                    }

                    if (!empty($fileInfo['audio']['sample_rate'])) {
                        $mp3_freq = round($fileInfo['audio']['sample_rate'] / 1000, 1) . ' kHz';
                    }

                    if (!empty($fileInfo['comments']['artist'][0])) {
                        $artists = $fileInfo['comments']['artist'][0];
                    }

                    if (!empty($fileInfo['comments']['album'][0])) {
                        $album = $fileInfo['comments']['album'][0];
                    }
                } else {
                    $mp3_freq = ' - ';

                    $mp3_bitrate = ' - ';

                    $mp3_size = ' - ';

                    $mp3_comment = '';

                    $mp3_leng = ' - ';

                    $trackDispName = '';
                }

                // let's see if the display name was blank

                if ('' == $trackDispName or 'Tconv' == $trackDispName) {
                    // Ok, let's figure it out by first removing the extension

                    $trackNameArray = explode('/', $finalRateArray[$loop_ctr][1]);

                    $trackNameInfo = $trackNameArray[count($trackNameArray) - 1];

                    $fileInfo = pathinfo($trackNameInfo);

                    $fileExt = $fileInfo['extension'];

                    $trackDispName = str_replace('.' . $fileExt, '', $trackNameInfo);

                    // Ok, now we need to strip off the track number at the beginning, if it's there

                    if (is_numeric(mb_substr($trackDispName, 0, 2))) {
                        // Ok, let's strip that and the seperator

                        $trackDispName = mb_substr($trackDispName, 2, mb_strlen($trackDispName) - 2);

                        $sepArray = explode('|', $track_num_seperator);

                        for ($ctr = 0, $ctrMax = count($sepArray); $ctr < $ctrMax; $ctr++) {
                            if (0 == mb_strpos($trackDispName, $sepArray[$ctr])) {
                                $trackDispName = mb_substr($trackDispName, mb_strlen($sepArray[$ctr]) - 1, mb_strlen($trackDispName));
                            }
                        }
                    }
                }

                echo '<tr class="' . $row_colors[$i] . '">' . "\n";

                /* Let's make sure they aren't a view only user */

                if ('viewonly' != $_SESSION['jz_access_level'] and 'lofi' != $_SESSION['jz_access_level']) {
                    if ('true' == $allow_download) {
                        echo '<td width="1%" align="center" valign="top" class="jz_track_table_songs_td">' . "\n";

                        // Now let's make sure this isn't a fake track

                        if (!preg_match("/\.(fake.txt)$/i", $finalRateArray[$loop_ctr][1])) {
                            // Now let's output the download link

                            $link_url = urlencode($genre) . '/' . urlencode($artist) . '/' . urlencode($album) . '/' . urlencode($finalRateArray[$loop_ctr][1]);

                            // Now let's strip any double slashes from here

                            $link_url = jzstripslashes(str_replace('%2F', '/', $link_url));

                            echo '<a class="jz_track_table_songs_href" href="download.php?info=' . $link_url . '">' . $img_download . '</a>' . "\n";
                        }

                        echo '</td>' . "\n";
                    }

                    // This is the link for the mp3 file details popup window

                    echo '<td width="1%" align="center" valign="top" class="jz_track_table_songs_td">' . "\n";

                    // Now let's make sure this isn't a fake track

                    if (!preg_match("/\.(fake.txt)$/i", $finalRateArray[$loop_ctr][1])) {
                        $link_url = $web_root . $root_dir . $media_dir . '/' . jzstripslashes($finalRateArray[$loop_ctr][1]);

                        echo '<a href="' . $root_dir . '/mp3info.php?file=' . urlencode($link_url) . ' " target="_blank" onclick="newWin(this); return false;">' . $img_more . '</a>' . "\n";
                    }

                    echo '</td>' . "\n";

                    echo '<td width="2%" align="center" valign="top" class="jz_track_table_songs_td">' . "\n";

                    // Now let's make sure this isn't a fake track

                    if (!preg_match("/\.(fake.txt)$/i", $finalRateArray[$loop_ctr][1])) {
                        /* Now let's create the URL for the link */

                        $link_url = jzstripslashes($finalRateArray[$loop_ctr][1]);

                        //$play_song_link = str_replace("?&","?",$this_page. $url_seperator. 'ptype=quickplay&style=normal&qptype=song&info='. urlencode($link_url));

                        $play_song_link = $root_dir . '/playlists.php?d=1&qptype=song&style=normal&info=' . urlencode($link_url) . '&return=' . base64_encode($_SESSION['prev_page']);

                        echo '<a class="jz_track_table_songs_href" href="' . $play_song_link . '">' . $img_play . '</a>' . "\n";
                    }

                    echo '</td>' . "\n";
                } else {
                    echo '<td width="2%" align="center" valign="top" class="jz_track_table_songs_td">' . "\n";

                    // Now let's make sure this isn't a fake track

                    if (!preg_match("/\.(fake.txt)$/i", $finalRateArray[$loop_ctr][1]) and !preg_match("/\.($video_types)$/i", $finalRateArray[$loop_ctr][1])) {
                        echo '<input class="jz_checkbox" type="checkbox" disabled>' . "\n";
                    }

                    echo '</td>' . "\n";

                    // This is the link for the mp3 file details popup window

                    echo '<td width="1%" align="center" valign="top" class="jz_track_table_songs_td">' . "\n";

                    // Now let's make sure this isn't a fake track

                    if (!preg_match("/\.(fake.txt)$/i", $finalRateArray[$loop_ctr][1])) {
                        echo $img_more_dis . "\n";
                    }

                    echo '</td>' . "\n";

                    echo '<td width="2%" align="center" valign="top" class="jz_track_table_songs_td">' . "\n";

                    // Now let's make sure this isn't a fake track

                    if (!preg_match("/\.(fake.txt)$/i", $finalRateArray[$loop_ctr][1])) {
                        echo $img_play_dis . "\n";
                    }

                    echo '</td>' . "\n";
                }

                echo '<td width="38%" valign="top" class="jz_track_table_songs_td">' . "\n";

                /* Let's look and see if the file name has digits at the beginning, indicating the track number and if so don't show it */

                $trackName = $finalRateArray[$loop_ctr][1];

                /* Now let's strip off the file extension by removing the extension */

                $fileInfo = pathinfo($root_dir . $media_dir . '/' . $genre . '/' . $artist . '/' . $album . '/' . $trackName);

                $fileExt = $fileInfo['extension'];

                $trackName = str_replace('.' . $fileExt, '', $trackName);

                if (is_numeric(mb_substr($trackName, 0, 2))) {
                    $trackName = mb_substr($trackName, 2);

                    /* Now let's stip off the track seperator */

                    /* First let's build an array of all the possible track seperators and test them all */

                    $trackSepArray = explode('|', $track_num_seperator);

                    $ctr = 0;

                    while (count($trackSepArray) > $ctr) {
                        if ('' != mb_stristr($trackName, $trackSepArray[$ctr])) {
                            $trackName = trim(str_replace($trackSepArray[$ctr], '', $trackName));
                        }

                        $ctr += 1;
                    }
                }

                /* Now let's create the URL for the link */

                /* Let's make sure they aren't a view only user */

                if ('viewonly' != $_SESSION['jz_access_level'] and 'lofi' != $_SESSION['jz_access_level'] and !preg_match("/\.(fake.txt)$/i", $finalRateArray[$loop_ctr][1])) {
                    $link_url = jzstripslashes($finalRateArray[$loop_ctr][1]);

                    //$play_song_link = str_replace("?&","?",$this_page. $url_seperator. 'ptype=quickplay&style=normal&qptype=song&info='. urlencode($link_url));

                    $play_song_link = $root_dir . '/playlists.php?d=1&qptype=song&style=normal&info=' . urlencode($link_url) . '&return=' . base64_encode($_SESSION['prev_page']);

                    echo '<a class="jz_track_table_songs_href" href="' . $play_song_link . '">' . $trackDispName . '</a>' . "\n";
                } else {
                    if (!preg_match("/\.(fake.txt)$/i", $finalRateArray[$loop_ctr][1])) {
                        echo $trackDispName . "\n";
                    } else {
                        // Now let's strip the .fake off the display name

                        echo mb_substr($trackDispName, 0, -5) . "\n";
                    }
                }

                // Now let's get the artist name and album name

                echo '<br><nobr>' . $artists . '</nobr> - <nobr>' . $album . '</nobr>';

                /* Now let's look and see if there is a corresponding lyric file and if so display a link for it */

                $desc_file = $mp3_dir . '/' . $genre . '/' . $artist . '/' . $album . '/' . $desc_file_array[0] . '.lyrics.txt';

                if (true === is_file($desc_file)) {
                    echo ' - <a class="jz_track_table_songs_href" href="'
                         . $this_site
                         . $url_seperator
                         . $root_dir
                         . '/mp3info.php?type=lyrics&info='
                         . urlencode($genre)
                         . '/'
                         . rawurlencode($artist)
                         . '/'
                         . rawurlencode($album)
                         . '/'
                         . rawurlencode($desc_file_array[0])
                         . '.lyrics.txt" onclick="lyricsWindow(this); return false;">View Lyrics</a>';
                }

                // Now let's look and see if the track had a description in the ID3 tag, and if so display it

                if ('' != $mp3_comment) {
                    // Ok, let's display it...

                    echo '<br>' . stripslashes($mp3_comment);
                }

                echo '</td>' . "\n";

                echo '<td width="8%" align="center" valign="top" class="jz_track_table_songs_td"><nobr>' . "\n";

                // Now let's display the rating, if it isn't -10 (meaning it was not rated)

                if ('-30' != $finalRateArray[$loop_ctr][0]) {
                    echo $img_star_left;

                    $rating = $finalRateArray[$loop_ctr][0] + 10;

                    $total_rating = $rating;

                    $rating += .49;

                    while ($rating > 1) {
                        $rating -= 1;

                        echo $img_star_full;
                    }

                    while ($rating > .5) {
                        $rating -= .5;

                        echo $img_star_half_empty;
                    }

                    // Now we need to finish this off to make 5

                    $rating = 5 - $total_rating;

                    $rating += .49;

                    while ($rating > 1) {
                        $rating -= 1;

                        echo $img_star_full_empty;
                    }

                    // Now let's finish it off

                    echo $img_star_right;

                    unset($total_rating);
                } else {
                    echo ' - ';
                }

                echo '</nobr></td>' . "\n";

                if ('true' == $track_plays) {
                    echo '<td width="10%" align="center" valign="top" class="jz_track_table_songs_td"><nobr>' . "\n";

                    // Now let's get the rating for it, if it's there

                    $filename = $web_root . $root_dir . '/data/counter/' . str_replace('/', '---', $finalRateArray[$loop_ctr][1]) . '.ctr';

                    if (is_file($filename)) {
                        // Now let's read the ratings file and get the rating

                        $handle = fopen($filename, 'rb');

                        $hits = fread($handle, filesize($filename));

                        fclose($handle);

                        echo $hits . ' plays';
                    } else {
                        echo '&nbsp;';
                    }

                    echo '</nobr></td>' . "\n";
                }

                // Now let's see what they wanted to see and didn't want to see

                if ('true' == $display_time) {
                    echo '<td width="10%" align="center" valign="top" class="jz_track_table_songs_td"><nobr>' . "\n" . $mp3_leng . "\n" . '</td></nobr>' . "\n";
                }

                if ('true' == $display_rate) {
                    echo '<td width="10%" align="center" valign="top" class="jz_track_table_songs_td"><nobr>' . "\n" . $mp3_bitrate . "\n" . '</td></nobr>' . "\n";
                }

                if ('true' == $display_feq) {
                    echo '<td width="10%" align="center" valign="top" class="jz_track_table_songs_td"><nobr>' . "\n" . $mp3_freq . "\n" . '</td></nobr>' . "\n";
                }

                if ('true' == $display_size) {
                    echo '<td width="10%" align="center" valign="top" class="jz_track_table_songs_td"><nobr>' . "\n" . $mp3_size . "\n" . '</td></nobr>' . "\n";
                }

                echo '</tr>' . "\n";

                $i = ++$i % 2;

                $found_ctr++;

                // Now let's see how many tracks to display

                if ($found_ctr == $numTracks) {
                    $loop_ctr = count($finalRateArray) + 1;
                }
            }
        }
    }

    echo '</table><br>';
}

// Now let's do the Jinzora's picks part
require_once __DIR__ . '/suggestions.php';

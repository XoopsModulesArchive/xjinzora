<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* JINZORA | Web-based Media Streamer
*
* Jinzora is a Web-based media streamer, primarily desgined to stream MP3s
* (but can be used for any media file that can stream from HTTP).
* Jinzora can be integrated into a CMS site, run as a standalone application,
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
* Code Purpose: This page contains all the "display" related functions
* Created: 9.24.03 by Ross Carlson
*
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

// This Fucntion Displays all the albums for this artist
function displayArtist($header = 'true', $subsearch = '')
{
    global $mp3_dir, $img_play, $ext_graphic, $this_page, $mp3_dir, $img_download, $album_name_truncate, $main_table_width, $word_play_all_albums_from, $word_randomize_all_albums_from, $root_dir, $media_dir, $allow_download, $quick_list_truncate, $directory_level, $word_home, $sort_by_year, $web_root, $audio_types, $artist_img_width, $artist_img_height, $web_root, $javascript, $main_table_width, $song_cellpadding, $word_check_all, $word_check_none, $word_play, $word_selected, $word_delete, $img_delete, $word_session_playlist, $word_new_playlist, $img_playlist, $img_add, $row_colors, $web_root, $root_dir, $playlist_ext, $img_random_play, $img_more, $img_random_play, $img_play_dis, $img_random_play_dis, $img_download_dis, $img_add_dis, $img_playlist_dis, $url_seperator, $days_for_new, $word_new, $img_rate, $enable_ratings, $img_star_half_empty, $img_star_full_empty, $img_star_right, $img_star_half, $img_star_full, $img_star_left, $enable_discussion, $img_discuss, $word_media_management, $word_actions, $jinzora_skin, $amg_search, $word_search, $word_rewrite_tags, $word_download_album, $word_group_features, $word_rate, $word_play_album, $word_play_random, $word_discuss, $word_item_information, $word_change_art, $word_browse_album, $slash_vars, $cms_mode, $cms_type, $word_edit_album_info, $echocloud, $word_information, $word_echocloud, $jz_MenuItemLeft, $jz_MenuSplit, $jz_MenuItemHover, $jz_MainItemHover, $main_img_dir, $jz_MenuItem, $show_sub_numbers, $word_update_cache, $disable_random, $enable_playlist, $word_update_cache, $word_show_hidden, $track_play_only, $info_level, $word_tools, $word_update_cache, $word_upload_center, $word_update_id3v1, $word_user_manager, $word_search_for_album_art, $word_enter_setup, $word_check_for_update, $menus_admin_only, $img_new, $css, $word_please_wait, $bg_c, $text_c, $img_discuss_dis;

    // First let's get all the POST and GET variables and clean them up

    $genre = jzstripslashes(urldecode($_GET['genre']));

    $artist = jzstripslashes(urldecode($_GET['artist']));

    // Let's see if the theme is set or not, and if not set it to the default

    if (isset($_SESSION['cur_theme'])) {
        $_SESSION['cur_theme'] = $jinzora_skin;
    }

    // Now let's see if we had a sub search

    if ('' != $subsearch) {
        $artist .= '/' . $subsearch;
    }

    // Let's look and see if there are any sub folders here

    if (0 == returnSubItems($genre . '/' . $artist)) {
        $location = $this_page . $url_seperator . 'ptype=songs&genre=' . urlencode($_GET['genre']) . '&artist=&album=' . urlencode($_GET['artist']);

        echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=' . $location . '">' . $css . '<center>' . $word_please_wait . '</center>';

        exit();
    }

    // Let's make sure they wanted a header

    if ('true' == $header) {
        // Let's add the page header based on the type of directory structure

        switch ($directory_level) {
            case '3': # 3 directories deep
                displayHeader($genre . ' : ' . $artist . returnSubNumber($artist, ''), 'false');
                break;
            case '2': # 2 directories deep
                displayHeader($artist . returnSubNumber($artist, ''), 'false');
                break;
        }
    }

    // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *vv

    // Ok, lets see if they wanted to unhide something...

    if (isset($_GET['showhidden'])) {
        // Ok, now let's unhide this from the global hide

        $filename = $web_root . $root_dir . '/data/global-exclude.lst';

        $handle = fopen($filename, 'rb');

        $contents = fread($handle, filesize($filename));

        fclose($handle);

        $excludeArray = explode("\n", $contents);

        $contents = '';

        // Now let's strip out what they wanted

        for ($c = 0, $cMax = count($excludeArray); $c < $cMax; $c++) {
            if (!mb_stristr($excludeArray[$c], $_GET['showhidden']) and '' != $excludeArray[$c]) {
                $contents .= $excludeArray[$c] . "\n";
            }
        }

        // Now let's write that back out

        $handle = fopen($filename, 'wb');

        fwrite($handle, $contents);

        fclose($handle);
    }

    // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

    // Now let's get all the albums

    $dataArray = returnAlbums($genre . '/' . $artist);

    // Let's setup our form for below

    echo '<form action="' . $_SESSION['prev_page'] . '" name="albumForm" method="POST" onSubmit="return AreYouSure();">';

    // Let's see if there was any album art

    for ($c = 0, $cMax = count($dataArray); $c < $cMax; $c++) {
        if ('' != $dataArray[$c]['image']) {
            $albumArt = 'yes';
        }
    }

    // Now let's create the table to put our stuff in

    jzTableOpen($main_table_width, '0', 'jz_artist_table');

    jzTROpen('jz_artist_table_tr');

    if ('yes' == $albumArt) {
        $width = '35%';
    } else {
        $width = '100%';
    }

    jzTDOpen($width, 'left', 'top', 'jz_artist_table_td', '0', '');

    echo '<nobr>';

    // Let's see if we need to shorten their name...

    $ls_artist = returnItemShortName($artist, $quick_list_truncate);

    // Let's make sure they are not a view only user

    if ('viewonly' != $_SESSION['jz_access_level'] and 'lofi' != $_SESSION['jz_access_level']) {
        // Let's set the links for the menu system

        $link_url = urlencode($genre) . '/' . urlencode($artist);

        $play_song_link = $root_dir . '/playlists.php?d=1&style=normal&info=' . $link_url . '&return=' . base64_encode($_SESSION['prev_page']);

        $link_url = 'artist&info=' . urlencode($genre) . '/' . urlencode($artist);

        $play_song_link_rand = $root_dir . '/playlists.php?d=1&style=random&info=' . $link_url . '&return=' . base64_encode($_SESSION['prev_page']);

        // Now let's include our fancy menu for here

        // First let's make sure they get to see if

        if ($menus_admin_only) {
            if ('admin' == $_SESSION['jz_access_level']) {
                require_once __DIR__ . '/artist-menu.php';

                echo '<br>';
            }
        } else {
            require_once __DIR__ . '/artist-menu.php';
        }

        echo '<br>';
    }

    // Now let's loop through displaying all the data

    for ($c = 0, $cMax = count($dataArray); $c < $cMax; $c++) {
        // First let's check for a valid entry

        if ('' != $dataArray[$c]['name']) {
            // Let's set all the variables for below

            $album_long_name = $dataArray[$c]['name'];

            $album_short_name = $dataArray[$c]['short_name'];

            $album_year = $dataArray[$c]['year'];

            $album_image = $dataArray[$c]['image'];

            $album_rating = $dataArray[$c]['rating'];

            // Now let's get on with it!

            // Ok, let's see if there was art, and if we need to resize it

            // TO DO - Resize the specific image if found!!!!

            // TO DO - Add the auto search album art code back in

            // TO DO - Sort this array by year, if needed

            // Now let's figure out if we should be using truncation

            if ('' != $album_name_truncate and '0' != $album_name_truncate) {
                $albumName = $album_short_name;
            } else {
                $albumName = $album_long_name;
            }

            // Now let's setup the table for this row

            echo '<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td valign="top"><nobr>';

            // Let's make sure they are not a view only user

            if ('viewonly' != $_SESSION['jz_access_level'] and 'lofi' != $_SESSION['jz_access_level']) {
                $link_url = urlencode($genre . '/' . $artist . '/' . $album_long_name);

                $play_song_link = $root_dir . '/playlists.php?d=1&style=normal&info=' . $link_url . '&return=' . base64_encode($_SESSION['prev_page']);

                $play_song_link_rand = $root_dir . '/playlists.php?d=1&style=random&info=' . $link_url . '&return=' . base64_encode($_SESSION['prev_page']);

                // Let's see if they wanted track plays only

                if ('true' != $track_play_only) {
                    echo '<a class="jz_artist_table_href" href="' . $play_song_link . '">' . $img_play . '</a>';
                }

                // Let's see if they wanted to disable random

                if ('false' == $disable_random) {
                    echo '<a class="jz_artist_table_href" href="' . $play_song_link_rand . '">' . $img_random_play . '</a>';
                }

                // Let's see if they can download or not

                if ('true' == $allow_download) {
                    // Now we have to change the URL if we are in CMS mode

                    if ('true' == $cms_mode) {
                        switch ($cms_type) {
                            case 'postnuke':
                                $link_begin = str_replace('index&', 'download&', $this_page);
                                break;
                            case 'mdpro':
                                $link_begin = str_replace('index&', 'download&', $this_page);
                                break;
                            case 'phpnuke':
                                $link_begin = 'modules/' . $_GET['name'] . '/download.php?';
                                break;
                            case 'nsnnuke':
                                $link_begin = 'modules/' . $_GET['name'] . '/download.php?';
                                break;
                            case 'mambo':
                                $link_begin = 'components/' . $_GET['option'] . '/download.php?';
                                break;
                        }
                    } else {
                        $link_begin = 'download.php?';
                    }

                    //echo '<a class="jz_artist_table_href" href="'. $link_begin. 'info='. urlencode($genre). "/". urlencode($artist). "/". urlencode($album_long_name). '">'. $img_download. '</a>';
                }

                // Now let's show them the rating link, if they wanted it

                if ('true' == $enable_ratings) {
                    echo '<a class="jz_track_table_songs_href" href="' . $root_dir . '/mp3info.php?type=rate&info=' . rawurlencode($genre) . '/' . urlencode($artist) . '/' . rawurlencode($album_long_name) . '" onclick="ratingWindow(this); return false;">' . $img_rate . '</a>';
                }

                if ('true' == $enable_discussion) {
                    // Now let's make sure this isn't a fake track

                    if (!preg_match("/\.(fake.txt)$/i", $album_long_name)) {
                        // Now let's create the URL for the link

                        if (true != checkDiscuss($genre . '/' . $artist . '/' . $album_long_name)) {
                            $img = $img_discuss_dis;
                        } else {
                            $img = $img_discuss;
                        }

                        echo '<a class="jz_track_table_songs_href" href="' . $root_dir . '/mp3info.php?type=discuss&info=' . rawurlencode($genre) . '/' . urlencode($artist) . '/' . rawurlencode($album_long_name) . '" onclick="discussionWindow(this); return false;">' . $img . '</a>';
                    }
                }

                // Now let's make sure playlisting isn't disabled

                if ('false' != $enable_playlist and 'no' != $javascript) {
                    echo '<input class="jz_checkbox" name="track-' . $c . '" type=checkbox value="' . $root_dir . $media_dir . '/' . urlencode($genre) . '/' . urlencode($artist) . '/' . urlencode($album_long_name) . '/"> ';
                } else {
                    echo ' ';
                }
            } else {
                echo $img_play_dis;

                echo $img_random_play_dis;

                echo $img_download_dis . ' ';
            }

            echo '</nobr></td><td width="100%"><nobr>';

            // Now let's see if this is new

            $item_new = checkForNew($web_root . $root_dir . $media_dir . '/' . $genre . '/' . $artist . '/' . $album_long_name);

            echo '<a class="jz_artist_table_href" href="' . $this_page . $url_seperator . 'ptype=songs&genre=' . urlencode($genre) . '&artist=' . urlencode($artist) . '&album=' . urlencode($album_long_name) . '">' . $albumName;

            // Now if there was a year let's display it here

            if ('' != $album_year) {
                echo ' (' . $album_year . ') ';
            }

            echo "</a>\n";

            if ('' != $item_new) {
                $new_data = 'onmouseover="return overlib(' . "'" . $item_new . "'" . ', FGCOLOR, ' . "'" . $bg_c . "'" . ', TEXTCOLOR, ' . "'" . $text_c . "', WIDTH, '" . (mb_strlen($item_new) * 6.2) . "'" . ');" onmouseout="return nd();"';
            } else {
                $new_data = '';
            }

            if ('' != $item_new) {
                echo '<img src="' . $root_dir . '/style/' . $jinzora_skin . '/new.gif" border=0 ' . $new_data . '>';
            }

            echo '</nobr>';

            // Now let's see if this has been rated

            echo displayRating($genre . '/' . $artist . '/' . $album_long_name, false);

            echo '</td></tr>';
        }
    }

    // Now let's finish off our table

    echo '</table>';

    // Ok, before we show all this we need to know if they are using JavaScript or not, if not, tough, "NO PLAYLIST FOR YOU!"

    if ('yes' == $javascript and 'false' != $enable_playlist) {
        echo '<br>';

        // Now let's set a hidden form field to hold the data for the click

        echo '<input type="hidden" name="albumSubmitAction">';

        // Now let's set a field with the number of checkboxes that were here

        echo '<input type="hidden" name="numboxes" value="' . $c . '">';

        // Now let's show our last row for all the other options

        echo '<table class="jz_track_table" width="100%" cellpadding="5" cellspacing="0" border="0">' . '<tr class="' . $row_colors[0] . '">' . '<td width="100%" class="jz_track_table_songs_td">';

        // Now let's build the URL for the playlist

        if ('viewonly' != $_SESSION['jz_access_level'] and 'lofi' != $_SESSION['jz_access_level']) {
            echo "<a class=\"jz_track_table_songs_href\" style=\"cursor:hand\"  onClick='albumForm.albumSubmitAction.value=\"addtoplaylist\";albumForm.submit()';\">" . $img_add . '</a>&nbsp;&nbsp;';
        } else {
            echo $img_add_dis;
        }

        echo ' <select name="albumPlayListToPlay" class="jz_select">';

        echo '<option value="sessionplaylist">' . $word_session_playlist . '</option>';

        echo '<option value="newplaylist">' . $word_new_playlist . '</option>';

        // Now let's get all the other playlists that exist

        $retArray = readDirInfo($web_root . $root_dir . '/data', 'file');

        for ($ctr = 0, $ctrMax = count($retArray); $ctr < $ctrMax; $ctr++) {
            // Let's make sure we're looking at a playlist file

            if (preg_match("/\.($playlist_ext)$/i", $retArray[$ctr])) {
                $optionDisp = str_replace('.' . $playlist_ext, '', $retArray[$ctr]);

                if (mb_strlen($optionDisp) > 15) {
                    $optionDisp = mb_substr($optionDisp, 0, 15) . '...';
                }

                // Now let's display the option and make it look pretty

                echo '<option value="' . $retArray[$ctr] . '">' . $optionDisp . '</option>';
            }
        }

        echo '</select> ';

        if ('viewonly' != $_SESSION['jz_access_level'] and 'lofi' != $_SESSION['jz_access_level']) {
            echo "&nbsp; <a class=\"jz_track_table_songs_href\" style=\"cursor:hand\" onClick='albumForm.albumSubmitAction.value=\"viewplaylist\";albumForm.submit()';\">"
                 . $img_playlist
                 . '</a>'
                 . " <a class=\"jz_track_table_songs_href\" style=\"cursor:hand\"  onClick='albumForm.albumSubmitAction.value=\"playplaylist\";albumForm.submit()';\">"
                 . $img_play
                 . '</a> ';

            if ('false' == $disable_random) {
                echo "<a class=\"jz_track_table_songs_href\" style=\"cursor:hand\"  onClick='albumForm.albumSubmitAction.value=\"randomplaylist\";albumForm.submit()';\">" . $img_random_play . '</a>&nbsp;&nbsp;';
            }
        } else {
            echo '&nbsp; ' . $img_playlist_dis . '&nbsp;&nbsp;' . $img_play_dis . '&nbsp;&nbsp;' . $img_random_play_dis . '&nbsp;&nbsp;';
        }

        echo '</nobr></td>' . '</tr>';

        if ('viewonly' != $_SESSION['jz_access_level'] and 'lofi' != $_SESSION['jz_access_level']) {
            echo '<tr class="'
                 . $row_colors[0]
                 . '">'
                 . '<td width="100%" class="jz_track_table_songs_td">'
                 . "<nobr><a class=\"jz_track_table_songs_href\" style=\"cursor:hand\"  onClick=\"CheckBoxes('albumForm',true);\">"
                 . $word_check_all
                 . '</a>'
                 . '&nbsp;|&nbsp;'
                 . "<a class=\"jz_track_table_songs_href\" style=\"cursor:hand\"  onClick=\"CheckBoxes('albumForm',false);\">"
                 . $word_check_none
                 . '</a>'
                 . '&nbsp;|&nbsp;'
                 . "<a class=\"jz_track_table_songs_href\" style=\"cursor:hand\"  onClick='albumForm.albumSubmitAction.value=\"play\";albumForm.submit()';\">"
                 . word_play_selected
                 . '</a>'
                 . '&nbsp;|&nbsp;'
                 . "<a class=\"jz_track_table_songs_href\" style=\"cursor:hand\"  onClick='albumForm.albumSubmitAction.value=\"playrandom\";albumForm.submit()';\">"
                 . word_random_selected
                 . '</a></nobr>'
                 . '</td>'
                 . '</tr>';
        }

        echo '</table>';

        echo '</form><br>';
    }

    echo '</nobr>';

    // Now let's get the main picture for this artist

    echo returnArtistImageDescHTML($genre . '/' . $artist, $artist);

    // Now let's show the ablum covers

    jzTDOpen('2', 'left', 'top', 'jz_artist_table_td', '0');

    jzTDClose();

    jzTDOpen('63', 'left', 'top', 'jz_artist_table_td', '0');

    if ('false' != $header) {
        displayAlbumCovers('', $dataArray);
    }

    jzTDClose();

    jzTRClose();

    jzTableClose();

    // Let's finish off some form data for later

    // Now let's set a hidden form field to hold the data for the click

    echo '<input type="hidden" name="submitAction">';

    // Now let's set a field with the number of checkboxes that were here

    echo '<input type="hidden" name="numboxes" value="' . $c . '">';

    echo '</form>';

    // Now let's make sure we are ONLY looking at the artist and not really in a song page

    if ('songs' != $_GET['ptype']) {
        // Now let's look and see if there are any songs in this directory that we need to display

        $songsFound = lookForMedia(jzstripslashes(urldecode($web_root . $root_dir . $media_dir . '/' . $genre . '/' . $artist)));

        if ('false' != $enable_playlist) {
            // Now let's show the playlist bar

            displayPlaylistBar($songsFound);
        }
    }
}

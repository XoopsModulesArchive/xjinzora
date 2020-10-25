<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* JINZORA | Web-based Media Streamer
*
* Jinzora is a Web-based media streamer, primarily desgined to stream MP3s
* (but can be used for any media file that can stream from HTTP).
* Jinzora can be integrated into a CMS site, run as a standalone application,
* or integrated into any PHP website.  It is released under the GNU GPL.
* g
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
* Code Purpose: This page contains all the track display related functions
* Created: 9.24.03 by Ross Carlson
*
*
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

// This function displays all the songs for this album
function displaySongs($displayHeader = true)
{
    global $mp3_dir, $audio_types, $video_types, $ext_graphic, $img_play, $img_download, $get_mp3_info, $song_cellpadding, $row_colors, $main_table_width, $this_page, $word_play_album, $word_download_album, $root_dir, $media_dir, $this_site, $allow_download, $track_num_seperator, $directory_level, $web_root, $num_other_albums, $word_album, $album_name_truncate, $word_play, $img_more, $search_album_art, $word_search_for_album_art, $img_delete, $word_cancel, $word_delete, $word_are_you_sure_delete, $img_add, $img_playlist, $word_check_all, $word_check_none, $word_selected, $word_session_playlist, $word_new_playlist, $playlist_ext, $word_play_random, $img_random_play, $javascript, $get_mp3_info, $colapse_tracks, $jinzora_skin, $word_search, $amg_search, $hide_tracks, $word_hide_tracks, $word_show_tracks, $download_mp3_only, $this_site, $word_change_art, $album_force_height, $album_force_width, $hide_id3_comments, $img_more_dis, $img_play_dis, $img_download_dis, $url_seperator, $enable_ratings, $img_rate, $img_star, $img_half_star, $num_top_ratings, $num_suggestions, $track_plays, $enable_discussion, $img_discuss, $word_discuss, $display_time, $display_rate, $display_feq, $display_size, $days_for_new, $word_new, $img_star_half_empty, $img_star_full_empty, $img_star_right, $img_star_half, $img_star_full, $img_star_left, $word_rewrite_tags, $word_media_management, $word_actions, $cms_type, $cms_mode, $word_item_information, $sort_by_year, $word_randomize_all_albums_from, $word_play_all_albums_from, $main_img_dir, $jz_MenuItemLeft, $jz_MenuSplit, $jz_MenuItemHover, $jz_MainItemHover, $main_img_dir, $jz_MenuItem, $word_bulk_edit, $word_information, $word_echocloud, $echocloud, $disable_random, $info_level, $hide_content, $enable_playlist, $word_play_lofi, $img_lofi, $word_lofi, $track_play_only, $word_tools, $word_update_cache, $word_upload_center, $word_update_id3v1, $word_user_manager, $word_search_for_album_art, $word_enter_setup, $word_check_for_update, $menus_admin_only, $img_new, $display_downloads, $word_downloads, $word_plays, $display_track_num, $word_browse_album, $word_play_album, $bg_c, $text_c, $jinzora_skin, $word_add_fake_track, $img_clip, $img_discuss_dis;

    // Let's figure out all the paths and make sure we don't need to fix any special characters

    if (isset($_GET['genre'])) {
        $genre = jzstripslashes(rawurldecode($_GET['genre']));
    } else {
        $genre = '';
    }

    if (isset($_GET['artist'])) {
        $artist = jzstripslashes(rawurldecode($_GET['artist']));
    } else {
        $artist = '';
    }

    if (isset($_GET['album'])) {
        $album = jzstripslashes(rawurldecode($_GET['album']));
    } else {
        $album = '';
    }

    // Let's initialize some variables

    $album_cover = '';

    // Let's set the directory that we are looking at

    if ('' == $root_dir) {
        $dirToLookIn = '.' . $media_dir . '/' . $genre . '/' . $artist . '/' . $album;
    } else {
        $dirToLookIn = $mp3_dir . '/' . $genre . '/' . $artist . '/' . $album;
    }

    // Now let's clean that up

    $dirToLookIn = jzstripslashes($dirToLookIn);

    // Now let's see if we are in "slim" mode

    if (isset($_GET['curdir'])) {
        $slim = 'true';

        global $show_art, $show_desc;

        $dirToLookIn = $web_root . $root_dir . $media_dir . '/' . urldecode($_GET['curdir']);
    } else {
        $show_art = 'true';

        $show_desc = 'true';

        $slim = 'false';
    }

    // Let's make sure we didn't call this from somewhere else and that we don't need to display the header

    $album_year = '';

    if (true === $displayHeader) {
        // Let's see if we should be displaying the year for this data and if it's here

        if ('true' == $sort_by_year) {
            // Ok, now let's get the year off of one of these files

            $retArray = readDirInfo($dirToLookIn, 'file');

            for ($ctr = 0, $ctrMax = count($retArray); $ctr < $ctrMax; $ctr++) {
                if ('' == $album_year) {
                    if (preg_match("/\.($audio_types)$/i", $retArray[$ctr])) {
                        // Now let's read the MP3 info

                        $getID3 = new getID3();

                        $fileInfo = $getID3->analyze($dirToLookIn . '/' . $retArray[$ctr]);

                        getid3_lib::CopyTagsToComments($fileInfo);

                        if (!empty($fileInfo['comments']['year'][0])) {
                            $album_year = ' (' . $fileInfo['comments']['year'][0] . ')';
                        } else {
                            $album_year = '';
                        }
                    }
                }
            }
        }

        // Let's add the page header based on the type of directory structure

        switch ($directory_level) {
            case '3': # 3 directories deep
                if ('' != $genre) {
                    $head_genre = $genre . ' : ';
                }
                if ('' != $artist) {
                    $head_artist = $artist . '<br>';
                } else {
                    $head_artist = '';
                }
                displayHeader($head_genre . $head_artist . '<nobr>' . $album . $album_year . '</nobr>', 'false');
                break;
            case '2': # 2 directories deep
                if ('' != $artist) {
                    $head_artist = $artist . ' : ';
                } else {
                    $head_artist = '';
                }
                displayHeader($head_artist . '<nobr>' . $album . $album_year . '</nobr>', 'false');
                break;
            case '1': # 1 directories deep
                displayHeader('<nobr>' . $album . $album_year . '</nobr>', 'false');
                break;
        }
    }

    // Now let's include the javascript for the popup stuff

    echo '<script type="text/javascript" src="' . $root_dir . '/overlib.js"></script>' . '<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>';

    // First let's see if we need to delete anything for them

    if (isset($_GET['delsong'])) {
        // Ok, let's make sure they really want to delete the file

        if ('' != $_POST['reallydel']) {
            // Ok, delete the damn file already!!!

            unlink($web_root . $root_dir . $media_dir . '/' . $genre . '/' . $artist . '/' . $album . '/' . $_GET['delsong']);
        } else {
            echo $word_are_you_sure_delete . ' <br>' . $_GET['delsong'] . '<br><br>';

            // Let's build the URL for below

            if ('' != $_GET['ptype']) {
                $ptype = '&ptype=' . $_GET['ptype'];
            } else {
                $ptype = '';
            }

            if ('' != $_GET['genre']) {
                $genre = '&genre=' . $genre;
            } else {
                $genre = '';
            }

            if ('' != $artist) {
                $artist = '&artist=' . $artist;
            } else {
                $artist = '';
            }

            if ('' != $album) {
                $album = '&album=' . $album;
            } else {
                $album = '';
            }

            $formAction = $this_page . $url_seperator . $ptype . $genre . $artist . $album . '&delsong=' . $_GET['delsong'];

            // Now let's show our form for this

            echo '<form action="' . $formAction . '" method="post">';

            echo '<input name="reallydel" value="' . $word_delete . '" type="submit" class="jz_submit"> ';

            echo '<input name="cancel" value="' . $word_cancel . '" type="submit" class="jz_submit">';

            echo '</form>';

            exit();
        }
    }

    // Now let's make sure that's a directory

    if (!is_dir($dirToLookIn)) {
        die('Sorry, but something was wrong reading your media directory at:<br>' . $dirToLookIn);
    }

    // Ok, now let's see if there is a cache for this directory and if not create it

    // First let's set the name of the file we'll be looking for

    if ('' == $genre or '/' == $genre) {
        $genreDir = 'NULL';
    } else {
        $genreDir = str_replace('/', '---', $genre);
    }

    if ('' == $artist or '/' == $artist) {
        $artistDir = 'NULL';
    } else {
        $artistDir = str_replace('/', '---', $artist);
    }

    if ('' == $album or '/' == $album) {
        $albumDir = 'NULL';
    } else {
        $albumDir = str_replace('/', '---', $album);
    }

    if (!isset($_GET['curdir'])) {
        $xmlFile = $web_root . $root_dir . '/data/tracks/' . $genreDir . '---' . $artistDir . '---' . $albumDir . '.xml';
    } else {
        $xmlFile = $web_root . $root_dir . '/data/tracks/' . str_replace('/', '---', $_GET['curdir']) . '.xml';
    }

    if (@!is_file($xmlFile)) {
        // Ok, let's create the cache for this directory...

        flushDisplay();

        createXMLFile($dirToLookIn, $xmlFile);
    } else {
        // Ok, the file is there, let's see if it needs to be updated

        flushDisplay();

        checkXMLFile($dirToLookIn, $xmlFile);
    }

    // Let's get the album cover if it's in the directory IF we wanted to see if

    if ('false' != $show_art) {
        $d = dir($dirToLookIn);

        while ($entry = $d->read()) {
            if (preg_match("/\.($ext_graphic)$/i", $entry) and !mb_stristr($entry, '.thumb.')) {
                // Let's see if we are in "slim" mode

                if (isset($_GET['curdir'])) {
                    $cover_root = $root_dir . $media_dir . '/' . urldecode($_GET['curdir']) . '/';
                } else {
                    $cover_root = $root_dir . $media_dir . '/' . $genre . '/' . $artist . '/' . $album . '/';
                }

                $album_cover = $cover_root . $entry;

                // Now let's resize the image if necessary

                jzResizeAlbum($web_root . $cover_root, $entry);

                // Now let's clean up the album cover

                $album_cover = str_replace('%2F', '/', rawurlencode($album_cover));
            }
        }
    }

    // Ok, let's go ahead and display the cover and description IF we are in "slim" mode

    if ('true' == $slim) {
        $desc_file = $mp3_dir . '/' . urldecode($_GET['curdir']) . '/album-desc.txt';

        $contents = '';

        if ('false' != $show_desc) {
            if (true === is_file($desc_file)) {
                // Ok, it's there so let's open it and display it

                $filename = $desc_file;

                $handle = fopen($filename, 'rb');

                $contents = fread($handle, filesize($filename));

                fclose($handle);

                // Now let's do some find and replaces incase they wanted to use some variables here...

                $contents = str_replace('ARTIST_NAME', $artist, $contents);

                $contents = str_replace('ALBUM_NAME', $album, $contents);

                $contents = nl2br(stripslashes($contents));
            }
        }

        // Let's setup our table

        if ('' != $album_cover or '' != $contents) {
            echo '<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td class="jz_artist_table_td" width="100%">';
        }

        if ('' != $album_cover and 'false' != $show_art) {
            echo '<img align="left" width="110" src="' . $album_cover . '" border="0">';
        }

        if ('' != $contents and 'false' != $show_desc) {
            echo stripslashes($contents) . '<br>';
        }

        if ('' != $album_cover or '' != $contents) {
            echo '</td></tr></table><br>';
        }
    }

    // Let's make sure we didn't call this from somewhere else and that we don't need to display the header

    if (true === $displayHeader) {
        // Let's setup the table for all the information

        if ('viewonly' != $_SESSION['jz_access_level'] and 'lofi' != $_SESSION['jz_access_level']) {
            // Now let's setup all the links for the menu

            $play_album_link = $root_dir . '/playlists.php?d=1&style=normal&info=' . jzstripslashes(urlencode($genre) . '/' . urlencode($artist) . '/' . urlencode($album)) . '&return=' . base64_encode($_SESSION['prev_page']);

            $play_album_rand_link = $root_dir . '/playlists.php?d=1&style=random&info=' . jzstripslashes(urlencode($genre) . '/' . urlencode($artist) . '/' . urlencode($album)) . '&return=' . base64_encode($_SESSION['prev_page']);

            $play_artist_link = $root_dir . '/playlists.php?d=1&style=normal&info=' . jzstripslashes(urlencode($genre) . '/' . urlencode($artist)) . '&return=' . base64_encode($_SESSION['prev_page']);

            $play_artist_rand_link = $root_dir . '/playlists.php?d=1&style=random&info=' . jzstripslashes(urlencode($genre) . '/' . urlencode($artist)) . '&return=' . base64_encode($_SESSION['prev_page']);

            echo '<table width="100%"><tr class="jz_track_album_table_tr"><td valign="top" width="100%">';

            // Now let's include the big fancy menu!

            // First let's make sure they get to see if

            if ($menus_admin_only) {
                if ('admin' == $_SESSION['jz_access_level']) {
                    require_once __DIR__ . '/album-menu.php';
                }
            } else {
                require_once __DIR__ . '/album-menu.php';
            }

            echo '</td></tr></table>';
        } else {
            echo '<br>';
        } ?>
        <table class="jz_track_album_table" width="<?php echo $main_table_width; ?>%" cellpadding="0" cellspacing="0" border="0">
            <tr class="jz_track_album_table_tr">
                <?php
                // Ok, now let's see if there is a descriptive text for this item
                $desc_file = $mp3_dir . '/' . $genre . '/' . $artist . '/' . $album . '/album-desc.txt';

        $contents = '';

        if (true === is_file($desc_file)) {
            // Ok, it's there so let's open it and display it

            $filename = $desc_file;

            $handle = fopen($filename, 'rb');

            $contents = fread($handle, filesize($filename));

            fclose($handle);

            // Now let's do some find and replaces incase they wanted to use some variables here...

            $contents = str_replace('ARTIST_NAME', $artist, $contents);

            $contents = str_replace('ALBUM_NAME', $album, $contents);

            $contents = nl2br(stripslashes($contents));
        }

        // let's see if we found album art or not, and if not let them search for it

        if ('' != $album_cover or '' != $contents) {
            // Ok we found art, let's display it

            $link_url = jzstripslashes(urlencode($genre) . '/' . urlencode($artist) . '/' . urlencode($album));

            echo '<td width="100%" valign="top" align="left" class="jz_artist_table_td">';

            // We'll echo time here to make sure the picture doesn't get cached

            if ('' != $album_cover) {
                // Now need to make sure they aren't view only

                if ('viewonly' != $_SESSION['jz_access_level']) {
                    $play_song_link = $root_dir . '/playlists.php?d=1&style=normal&info=' . $link_url . '&return=' . base64_encode($_SESSION['prev_page']);

                    echo '<a class="jz_track_album_table_href" href="' . $play_song_link . '">';
                }

                echo '<img align=left hspace=5 class="jz_album_cover_picture" title="' . $word_play_album . ': ' . $album . '" src="' . $album_cover . '?' . time() . '" border="0"></a>';
            }

            if ('' != $contents) {
                echo stripslashes($contents);
            }

            echo '</td>';
        }

        // Let's the the link for below

        $link_url = urlencode($genre . '/' . $artist . '/' . $album);

        $search_url = urlencode($genre) . '|||' . urlencode($artist) . '|||' . urlencode($album);

        // Let's set the album name and truncate it if needed

        $albumName = $album;

        if (mb_strlen($albumName) > $album_name_truncate) {
            $albumName = mb_substr($albumName, 0, $album_name_truncate) . '...';
        }

        // Let's make sure they really wanted to see other albums

        // and if so create a new cell for it

        echo '<td width="1%">&nbsp;</td><td width="98%" valign="top" class="jz_track_album_table_td" align="right">';

        // Now let's echo the results of the album description if we found it

        echo '<table width="100%" cellpadding="0" cellspacing="0" border="0">' . '<tr>' . '<td width="50%" class="jz_artist_table_td" valign="top">';

        // Ok, let's look and see if there are any sub dirs here, if there are they MUST be additional albums...

        $searchArray = readDirInfo($web_root . $root_dir . $media_dir . $genre . '/' . $artist . '/' . $album, 'dir');

        if (0 != count($searchArray) and 'songs' == $_GET['ptype']) {
            // Ok, we must have found a sub dir, so we'll need to display it!

            displayArtist('false', $album);
        }

        echo '</td>' . '<td width="1%" align="right" valign="top"><nobr>';

        // Let's see if we can find other albums by this artist and display their pictures

        // We need to do this ONLY if we are in the right structure

        $other_art = 'true';

        switch ($directory_level) {
                    case '3':
                        if ('' == $artist or '' == $genre) {
                            $other_art = 'false';
                        }
                        break;
                    case '2':
                        if ('' == $artist) {
                            $other_art = 'false';
                        }
                        break;
                }

        if ('true' == $other_art) {
            $sourceDir = $web_root . $root_dir . $media_dir . '/' . $genre . '/' . $artist;

            $retArray = readDirInfo($sourceDir, 'dir');

            $ctr3 = 0;

            // Now let's shuffle that array

            shuffle($retArray);

            for ($ctr = 0, $ctrMax = count($retArray); $ctr < $ctrMax; $ctr++) {
                // Ok, now we have all the other albums by this artist, so let's see if we can find images

                $albumArray = readDirInfo($sourceDir . '/' . $retArray[$ctr], 'file');

                for ($ctr2 = 0, $ctr2Max = count($albumArray); $ctr2 < $ctr2Max; $ctr2++) {
                    // Now let's make sure it's a graphic file we're looking at

                    if (preg_match("/\.($ext_graphic)$/i", $albumArray[$ctr2])) {
                        // Ok, let's display the album covers if they haven't seen to many already and that this isn't what they are already looking at

                        if ($num_other_albums > $ctr3 and $retArray[$ctr] != $album) {
                            echo ' <a href="' . $this_page . $url_seperator . 'ptype=songs&genre=' . urlencode($genre) . '&artist=' . urlencode($artist) . '&album=' . urlencode($retArray[$ctr]) . '">';

                            // Let's see if they wanted to force the size of this picture

                            if ('' != $album_force_height and '0' != $album_force_height) {
                                // Ok, let's force it

                                echo '<img width="' . $album_force_width . '" height="' . $album_force_height . '" title="' . $word_browse_album . ': ' . $retArray[$ctr] . '" src="' . str_replace(
                                    '%2F',
                                    '/',
                                    rawurlencode(
                                                    $root_dir
                                                    . $media_dir
                                                    . '/'
                                                    . $genre
                                                    . '/'
                                                    . $artist
                                                    . '/'
                                                    . $retArray[$ctr]
                                                    . '/'
                                                    . $albumArray[$ctr2]
                                                )
                                ) . '?' . time() . '" border="0"></a> &nbsp; ';
                            } else {
                                // Ok, no force, let's just show it

                                echo '<img title="'
                                             . $word_browse_album
                                             . ': '
                                             . $retArray[$ctr]
                                             . '" src="'
                                             . str_replace('%2F', '/', rawurlencode($root_dir . $media_dir . '/' . $genre . '/' . $artist . '/' . $retArray[$ctr] . '/' . $albumArray[$ctr2]))
                                             . '?'
                                             . time()
                                             . '" border="0"></a> &nbsp; ';
                            }

                            $ctr3++;
                        }
                    }
                }
            }
        }

        echo '</nobr></td></tr>' . '</table>';

        $ctr3 = 0;

        echo '</td>'; ?>
            </tr>
        </table>
        <br>
        <?php
        // This ends the test above to see if we are showing the header info
    }

    // This tag hides all the tracks IF they wanted to enable this

    if ('true' == $hide_tracks and 'songs' != $_GET['ptype']) {
        echo '<input name="songDisplayButton" class="jz_submit" value="' . $word_show_tracks . '" type="button" onclick="showHideCon(' . "'songs','yes');" . '">';

        echo '<DIV id=songsContent style="display: none;">';
    }

    // Let's setup our form for the checkboxes

    $formAction = $this_page . $url_seperator . $_SERVER['QUERY_STRING'];

    echo '<form action="' . $formAction . '" name="trackForm" method="POST" onSubmit="return AreYouSure();">';

    echo '<table class="jz_track_table" width="' . $main_table_width . '%" cellpadding="' . $song_cellpadding . '" cellspacing="0" border="0">';

    // Now let's get the data back

    require_once __DIR__ . '/files.lib.php';

    $retArray = getTracksInfosFromXML($xmlFile, false);

    // Now let's populate our table with all the songs

    $i = 1;

    $c = 0;

    foreach ($retArray as $track) {
        // Ok, now let's populate all our variables

        $name = $track['name'];

        $filename = $track['filename'];

        $path = $track['path'];

        $fileExt = $track['fileExt'];

        $date = $track['date'];

        $mp3_comment = $track['mp3_comment'];

        $number = $track['number'];

        $rate = $track['rate'];

        $freq = $track['freq'];

        $size = $track['size'];

        $length = $track['length'];

        $thumbnail = $track['thumbnail'];

        // Now let's see if we are in ALL mode, and if so hide temp tracks

        // Custom hack for a donating user

        if (mb_stristr($audio_types, 'all') and mb_stristr($name, $hide_content)) {
            // Now let's clear the name so this track won't show

            $name = '';

            $filename = '';
        }

        if (!isset($filename)) {
            $filename = '';
        }

        if (preg_match("/\.($audio_types)$/i", $filename) || preg_match("/\.($video_types)$/i", $filename) || preg_match("/\.(fake.txt)$/i", $filename) || preg_match("/\.(fake.lnk)$/i", $filename) or (mb_stristr($audio_types, 'all') and !mb_stristr($filename, '.txt') and !preg_match(
            "/\.($ext_graphic)$/i",
            $filename
        )) and '' != $name) {
            // Let's see if they are a lofi only user, and if so stop unless this file is lofi

            if ('lofi' == $_SESSION['jz_access_level']) {
                if (!mb_stristr($filename, '.lofi.') and !mb_stristr($filename, '.clip.')) {
                    // Ok, let's stop here...

                    continue;
                }
            } else {
                // Ok, let's not show the lofi track as a individual track unless they are a lofi only user

                if (mb_stristr($filename, '.lofi.') or mb_stristr($filename, '.clip.')) {
                    // Ok, let's stop here...

                    continue;
                }
            }

            // Now let's look and see if there is a corresponding descriptive text file

            if (preg_match("/\.($audio_types)$/i", $filename) || preg_match("/\.($video_types)$/i", $filename)) {
                $desc_file = str_replace('.' . $fileExt, '', $filename) . '.txt';
            } else {
                $desc_file = '';
            }

            // Let's see if this was a .fake file name and if so read it for the data

            if (preg_match("/\.(fake.txt)$/i", $filename) or preg_match("/\.(fake.lnk)$/i", $filename)) {
                $desc_file = $mp3_dir . '/' . $genre . '/' . $artist . '/' . $album . '/' . $filename;
            } else {
                $desc_file = $mp3_dir . '/' . $genre . '/' . $artist . '/' . $album . '/' . $desc_file;
            }

            // Now let's see if we need to blank out the ID3 comment

            if ('true' == $hide_id3_comments) {
                $mp3_comment = '';
            }

            if (is_file($desc_file) and (0 != filesize($desc_file))) {
                // Ok, it's there so let's open it and display it

                $handle = fopen($desc_file, 'rb');

                $mp3_comment = fread($handle, filesize($desc_file));

                fclose($handle);

                // Now let's see if it was a fake.lnk file and if so read the comment from it

                if (preg_match("/\.(fake.lnk)$/i", $filename)) {
                    // Let's blow that into an array

                    $comArray = explode("\n", $mp3_comment);

                    $mp3_comment = mb_substr($comArray[0], 13, mb_strlen($comArray[0]) - 13);

                    $fake_link = mb_substr($comArray[1], 5, mb_strlen($comArray[1]));
                }
            }

            // let's see if the display name was blank

            if ('' == $name) {
                // Ok, let's figure it out by first removing the extension

                $trackDispName = str_replace('.' . $fileExt, '', $filename);

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

            // Let's make sure they aren't a view only user

            if ('viewonly' != $_SESSION['jz_access_level']) {
                // Let's make sure we aren't in "slim" mode

                if (!isset($_GET['curdir'])) {
                    echo '<td width="1%" align="center" valign="top" class="jz_track_table_songs_td">' . "\n";

                    // Now let's make sure this isn't a fake track

                    if ('false' != $enable_playlist and !preg_match("/\.(fake.txt)$/i", $filename) and !preg_match("/\.($video_types)$/i", $filename) and !preg_match("/\.(fake.lnk)$/i", $filename)) {
                        echo '<input class="jz_checkbox" type="checkbox" name="track-' . $c . '" value="' . str_replace($web_root, '', $dirToLookIn) . '/' . $filename . '">' . "\n";
                    } else {
                        echo '&nbsp;';
                    }

                    echo '</td>' . "\n";
                }

                if ('true' == $allow_download) {
                    echo '<td width="1%" align="center" valign="top" class="jz_track_table_songs_td">' . "\n";

                    // Now let's make sure this isn't a fake track

                    if (!preg_match("/\.(fake.txt)$/i", $filename) and !preg_match("/\.(fake.lnk)$/i", $filename)) {
                        // Now let's output the download link

                        $link_url = urlencode($genre) . '/' . urlencode($artist) . '/' . urlencode($album) . '/' . urlencode($filename);

                        // Now let's strip any double slashes from here

                        $link_url = jzstripslashes(str_replace('%2F', '/', $link_url));

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
                                case 'cpgnuke':
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

                        echo '<a class="jz_track_table_songs_href" href="' . $link_begin . 'info=' . $link_url . '">' . $img_download . '</a>' . "\n";
                    }

                    echo '</td>' . "\n";
                }

                // Let's make sure we aren't in "slim" mode

                if (!isset($_GET['curdir'])) {
                    // Let's make sure they can see the info link

                    if (('all' == $info_level or ('admin' == $info_level and 'admin' == $_SESSION['jz_access_level'])) and 'false' != $javascript) {
                        // This is the link for the mp3 file details popup window

                        echo '<td width="1%" align="center" valign="top" class="jz_track_table_songs_td">' . "\n";

                        // Now let's make sure this isn't a fake track

                        if (!preg_match("/\.(fake.txt)$/i", $filename) and !preg_match("/\.(fake.lnk)$/i", $filename)) {
                            $link_url = $web_root . $root_dir . $media_dir . '/' . $genre . '/' . $artist . '/' . $album . '/' . $filename;

                            echo '<a href="' . $root_dir . '/mp3info.php?file=' . urlencode($link_url) . '&cur_theme=' . $_SESSION['cur_theme'] . '" target="_blank" onclick="newWin(this); return false;">' . $img_more . '</a>' . "\n";
                        }

                        echo '</td>' . "\n";
                    }
                }

                // Now let's see if they are a lofi only user

                if ('lofi' == $_SESSION['jz_access_level']) {
                    echo '<td width="1%" align="center" valign="top" class="jz_track_table_songs_td">' . "\n";

                    // Now let's make sure this isn't a fake track

                    if (!preg_match("/\.(fake.txt)$/i", $filename) and !preg_match("/\.(fake.lnk)$/i", $filename)) {
                        // Now let's create the URL for the link

                        $resample = $_SESSION['resample'] ?? '';

                        $link_url = jzstripslashes(urlencode($genre) . '/' . urlencode($artist) . '/' . urlencode($album) . '/' . urlencode($filename));

                        $play_song_link = $root_dir . '/playlists.php?d=1&r=' . $resample . '&p=1&qptype=song&style=normal&info=' . $link_url . '&return=' . base64_encode($_SESSION['prev_page']);

                        // Now let's figure out which icon to use

                        if (mb_stristr($filename, '.lofi.')) {
                            $img = $img_lofi;
                        }

                        if (mb_stristr($filename, '.clip.')) {
                            // If we are in lofi only mode, let's show them a pretty icon for the clip...

                            $img = $img_play;
                        }

                        echo '<a class="jz_track_table_songs_href" href="' . $play_song_link . '">' . $img . '</a>' . "\n";
                    }

                    echo '</td>' . "\n";
                } else {
                    echo '<td width="1%" align="center" valign="top" class="jz_track_table_songs_td">' . "\n";

                    // Now let's make sure this isn't a fake track

                    if (!preg_match("/\.(fake.txt)$/i", $filename) and !preg_match("/\.(fake.lnk)$/i", $filename)) {
                        // Now let's create the URL for the link

                        // Are we in Slim mode?

                        if ('true' != $slim) {
                            $link_url = jzstripslashes(urlencode($genre) . '/' . urlencode($artist) . '/' . urlencode($album) . '/' . urlencode($filename));

                            $resample = $_SESSION['resample'] ?? '';

                            $play_song_link = $root_dir . '/playlists.php?d=1&r=' . $resample . '&qptype=song&style=normal&info=' . $link_url . '&return=' . base64_encode($_SESSION['prev_page']);
                        } else {
                            $link_url = jzstripslashes(urlencode($_GET['curdir']) . '/' . urlencode($filename));

                            $play_song_link = $root_dir . '/playlists.php?d=1&qptype=song&style=normal&info=' . $link_url . '&return=' . base64_encode($_SESSION['prev_page']);
                        }

                        // Is it lo-fi or not?

                        if (mb_stristr($filename, '.lofi.')) {
                            echo '<a class="jz_track_table_songs_href" href="' . $play_song_link . '">' . $img_lofi . '</a>' . "\n";
                        } else {
                            echo '<a class="jz_track_table_songs_href" href="' . $play_song_link . '">' . $img_play . '</a>' . "\n";
                        }
                    }

                    echo '</td>' . "\n";
                }

                // Now let's see if they wanted to enable ratings

                if ('true' == $enable_ratings) {
                    echo '<td width="1%" align="center" valign="top" class="jz_track_table_songs_td">' . "\n";

                    // Now let's make sure this isn't a fake track

                    if (!preg_match("/\.(fake.txt)$/i", $filename) and !preg_match("/\.(fake.lnk)$/i", $filename)) {
                        // Now let's create the URL for the link

                        echo '<a class="jz_track_table_songs_href" href="'
                             . $root_dir
                             . '/mp3info.php?type=rate&info='
                             . rawurlencode($genre)
                             . '/'
                             . rawurlencode($artist)
                             . '/'
                             . rawurlencode($album)
                             . '/'
                             . rawurlencode($filename)
                             . '&cur_theme='
                             . $_SESSION['cur_theme']
                             . '" onclick="ratingWindow(this); return false;">'
                             . $img_rate
                             . '</a>';
                    }

                    echo '</td>' . "\n";
                }

                // Now let's see if they wanted discussions

                if ('true' == $enable_discussion) {
                    echo '<td width="1%" align="center" valign="top" class="jz_track_table_songs_td">' . "\n";

                    // Now let's make sure this isn't a fake track

                    if (!preg_match("/\.(fake.txt)$/i", $filename) and !preg_match("/\.(fake.lnk)$/i", $filename)) {
                        // Now let's create the URL for the link

                        if (true != checkDiscuss($genre . '/' . $artist . '/' . $album . '/' . $filename)) {
                            $img = $img_discuss_dis;
                        } else {
                            $img = $img_discuss;
                        }

                        echo '<a class="jz_track_table_songs_href" href="'
                             . $root_dir
                             . '/mp3info.php?type=discuss&info='
                             . rawurlencode($genre)
                             . '/'
                             . rawurlencode($artist)
                             . '/'
                             . rawurlencode($album)
                             . '/'
                             . rawurlencode($filename)
                             . '&cur_theme='
                             . $_SESSION['cur_theme']
                             . '" onclick="discussionWindow(this); return false;">'
                             . $img
                             . '</a>';
                    }

                    echo '</td>' . "\n";
                }
            } else {
                echo '<td width="1%" align="center" valign="top" class="jz_track_table_songs_td">' . "\n";

                // Now let's make sure this isn't a fake track

                if (!preg_match("/\.(fake.txt)$/i", $filename) and !preg_match("/\.($video_types)$/i", $filename)) {
                    echo '<input class="jz_checkbox" type="checkbox" disabled>' . "\n";
                }

                echo '</td>' . "\n";

                // This is the link for the mp3 file details popup window

                echo '<td width="1%" align="center" valign="top" class="jz_track_table_songs_td">' . "\n";

                // Now let's make sure this isn't a fake track

                if (!preg_match("/\.(fake.txt)$/i", $filename)) {
                    echo $img_more_dis . "\n";
                }

                echo '</td>' . "\n";

                echo '<td width="1%" align="center" valign="top" class="jz_track_table_songs_td">' . "\n";

                // Now let's make sure this isn't a fake track

                if (!preg_match("/\.(fake.txt)$/i", $filename)) {
                    echo $img_play_dis . "\n";
                }

                echo '</td>' . "\n";
            }

            // Now let's see if they wanted to display the track number

            if ('true' == $display_track_num) {
                echo '<td width="1%" align="center" valign="top" class="jz_track_table_songs_td">' . "\n";

                if ('' != $number) {
                    echo $number;
                }

                echo '</td>' . "\n";
            }

            echo '<td width="100%" valign="top" class="jz_track_table_songs_td">' . "\n";

            // Now let's see if this track is new or not

            $new_item = checkForNew($web_root . $root_dir . $media_dir . '/' . urldecode($link_url));

            if ('' != $new_item) {
                $new_data = 'onmouseover="return overlib(' . "'" . $new_item . "'" . ', FGCOLOR, ' . "'" . $bg_c . "'" . ', TEXTCOLOR, ' . "'" . $text_c . "', WIDTH, '" . (mb_strlen($new_item) * 6.2) . "'" . ');" onmouseout="return nd();"';
            } else {
                $new_data = '';
            }

            // Now let's create the URL for the link

            // Let's make sure they aren't a view only user

            if ('viewonly' != $_SESSION['jz_access_level'] and !preg_match("/\.(fake.txt)$/i", $filename)) {
                // Now let's see if we should get the link from the file if it was a fake link file

                if (preg_match("/\.(fake.lnk)$/i", $filename)) {
                    // Now let's display the link from the track

                    $play_song_link = $fake_link;

                    $target = ' target="_blank"';
                } else {
                    if ('true' != $slim) {
                        $link_url = jzstripslashes(urlencode($genre) . '/' . urlencode($artist) . '/' . urlencode($album) . '/' . urlencode($filename));

                        $play_song_link = $root_dir . '/playlists.php?d=1&r=' . $resample . '&qptype=song&style=normal&info=' . $link_url . '&return=' . base64_encode($_SESSION['prev_page']);
                    } else {
                        $link_url = jzstripslashes(urlencode($_GET['curdir']) . '/' . urlencode($filename));

                        $play_song_link = $root_dir . '/playlists.php?d=1&qptype=song&style=normal&info=' . $link_url . '&return=' . base64_encode($_SESSION['prev_page']);
                    }

                    $target = '';
                }

                // Now, let's see if there is a lofi track with the same name

                $lofi_file = str_replace('.' . $fileExt, '.lofi.' . $fileExt, $filename);

                if (is_file($web_root . $root_dir . $media_dir . '/' . $genre . '/' . $artist . '/' . $album . '/' . $lofi_file)) {
                    $link_lofi = jzstripslashes(urlencode($genre) . '/' . urlencode($artist) . '/' . urlencode($album) . '/' . urlencode($lofi_file));

                    $play_lofi_link = $root_dir . '/playlists.php?d=1&p=1&qptype=song&style=normal&info=' . $link_lofi . '&return=' . base64_encode($_SESSION['prev_page']);

                    echo '<a' . $target . ' class="jz_track_table_songs_href" href="' . $play_lofi_link . '">' . $img_lofi . '</a>' . "\n";
                }

                // Now, let's see if there is a .clip track with the same name

                $clip_file = str_replace('.' . $fileExt, '.clip.' . $fileExt, $filename);

                if (is_file($web_root . $root_dir . $media_dir . '/' . $genre . '/' . $artist . '/' . $album . '/' . $clip_file)) {
                    $link_clip = jzstripslashes(urlencode($genre) . '/' . urlencode($artist) . '/' . urlencode($album) . '/' . urlencode($clip_file));

                    $play_clip_link = $root_dir . '/playlists.php?d=1&p=1&qptype=song&style=normal&info=' . $link_clip . '&return=' . base64_encode($_SESSION['prev_page']);

                    echo '<a' . $target . ' class="jz_track_table_songs_href" href="' . $play_clip_link . '">' . $img_clip . '</a>' . "\n";
                }

                if ('' != $new_data) {
                    echo '&nbsp;<img src="' . $root_dir . '/style/' . $jinzora_skin . '/new.gif" border=0 ' . $new_data . '>&nbsp;&nbsp;';
                }

                echo '<a' . $target . ' class="jz_track_table_songs_href" href="' . $play_song_link . '">' . $name . '</a>' . "\n";
            } else {
                if ('' != $new_item) {
                    echo '&nbsp;' . $img_new . '&nbsp;';
                }

                echo $name . "\n";
            }

            // Now let's see if there was a thumbnail

            if ('' != $thumbnail) {
                echo '<br><img src="' . $thumbnail . '" border="0">';
            }

            // Now let's look and see if there is a corresponding lyric file and if so display a link for it

            $desc_file = $mp3_dir . '/' . $genre . '/' . $artist . '/' . $album . '/' . str_replace('.' . $fileExt, '', $filename) . '.lyrics.txt';

            if (true === is_file($desc_file)) {
                echo ' - <a class="jz_track_table_songs_href" href="'
                     . $this_site
                     . $root_dir
                     . '/mp3info.php?type=lyrics&info='
                     . urlencode($genre)
                     . '/'
                     . rawurlencode($artist)
                     . '/'
                     . rawurlencode($album)
                     . '/'
                     . str_replace('.' . $fileExt, '', $filename)
                     . '.lyrics.txt&cur_theme='
                     . $_SESSION['cur_theme']
                     . '" onclick="lyricsWindow(this); return false;">View Lyrics</a>';
            }

            echo '<br>';

            // Now let's look and see if the track had a description in the ID3 tag, and if so display it

            if ('NULL' != $mp3_comment) {
                // Ok, let's display it...

                echo stripslashes($mp3_comment);
            }

            echo '</td>' . "\n";

            // Now let's see if they wanted the ratings module

            if ('true' == $enable_ratings) {
                echo '<td width="12%" align="center" valign="top" class="jz_track_table_songs_td"><nobr> &nbsp; ' . "\n";

                // Now let's get the rating for it, if it's there

                $rateFile = str_replace('/', '---', jzstripslashes($genre . '/' . $artist . '/' . $album . '/' . $filename));

                echo displayRating($rateFile, false);

                echo ' </nobr></td>' . "\n";
            }

            if ('true' == $track_plays) {
                echo '<td width="10%" align="center" valign="top" class="jz_track_table_songs_td"><nobr> &nbsp; ' . "\n";

                // Now let's get the rating for it, if it's there

                $hits = returnCounter($web_root . $root_dir . $media_dir . '/' . jzstripslashes($genre . '/' . $artist . '/' . $album . '/' . $filename));

                if (0 != $hits) {
                    echo $hits . ' ' . $word_plays;
                } else {
                    echo '&nbsp;';
                }

                echo ' &nbsp; </nobr></td>' . "\n";
            }

            // Now let's see what they wanted to see and didn't want to see

            if ('true' == $display_downloads) {
                echo '<td width="10%" align="center" valign="top" class="jz_track_table_songs_td"><nobr>' . "\n";

                // Ok, but is there a tracker for this file

                $dwnFile = $web_root . $root_dir . '/data/counter/' . str_replace('/', '---', jzstripslashes($genre . '/' . $artist . '/' . $album . '/' . $filename)) . '.dwn';

                if (is_file($dwnFile)) {
                    // Now let's read the ratings file and get the rating

                    $handle = fopen($dwnFile, 'rb');

                    $hits = fread($handle, filesize($dwnFile));

                    fclose($handle);

                    echo ' &nbsp; ' . $hits . ' ' . $word_downloads . ' &nbsp; ';
                } else {
                    echo '&nbsp;';
                }

                echo '</nobr></td>' . "\n";
            }

            if ('true' == $display_time) {
                echo '<td width="10%" align="center" valign="top" class="jz_track_table_songs_td"><nobr> &nbsp; ' . "\n" . $length . "\n" . ' &nbsp; </nobr></td>' . "\n";
            }

            if ('true' == $display_rate) {
                echo '<td width="10%" align="center" valign="top" class="jz_track_table_songs_td"><nobr> &nbsp; ' . "\n";

                echo $rate;

                if ('-' != $rate) {
                    echo ' kbps' . "\n";
                }

                echo ' &nbsp; </nobr></td>' . "\n";
            }

            if ('true' == $display_feq) {
                echo '<td width="10%" align="center" valign="top" class="jz_track_table_songs_td"><nobr> &nbsp; ' . "\n";

                echo $freq;

                if ('-' != $freq) {
                    echo ' kHz' . "\n";
                }

                echo ' &nbsp; </nobr></td>' . "\n";
            }

            if ('true' == $display_size) {
                echo '<td width="10%" align="center" valign="top" class="jz_track_table_songs_td"><nobr> &nbsp; ' . "\n";

                if (0 != $size) {
                    echo $size . ' Mb' . "\n";
                } else {
                    echo '-';
                }

                echo ' &nbsp; </nobr></td>' . "\n";
            }

            echo '</tr>' . "\n";

            $i = ++$i % 2;

            $c++;
        }
    }

    // Now let's set a field with the number of checkboxes that were here

    echo '<input type="hidden" name="numboxes" value="' . $c . '">';

    echo '</table><br>';

    echo '</div>';

    // Now let's show them the playlist bar if we are in song page type

    if (isset($_GET['ptype'])) {
        if ('songs' == $_GET['ptype'] and 'false' != $enable_playlist) {
            displayPlaylistBar('true');
        }
    }
}

?>

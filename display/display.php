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
* Code Purpose: This page contains all the album display related functions
* Created: 9.24.03 by Ross Carlson
*
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

require_once __DIR__ . '/display/head-foot.php';
// NEW FOR BACKEND:
function displayPage($node, $type)
{
    $pageInclude = 'display/' . $type . '.php';

    // if it doesn't exist, set it to be the genre page (for now...):

    if (!is_file($pageInclude)) {
        $pageInclude = 'display/genre.php';
    }

    require_once $pageInclude;

    drawPage($node);
}

// Now let's put in all the standard display functions...

/**
 * returns the HTML code for the CMS stylesheet
 *
 * @return returns HTML code for the javascript includes
 * @version 04/29/04
 * @since   04/29/04
 * @author  Ross Carlson
 */
function returnCMSCSS()
{
    global $bgcolor1, $bgcolor3;

    return "<style type=\"text/css\">.jz_row1 { background-color:$bgcolor1; } .jz_row2 { background-color:$bgcolor3; }</style>";
}

/**
 * returns the HTML code for the stylesheet
 *
 * @return returns HTML code for the javascript includes
 * @version 04/29/04
 * @since   04/29/04
 * @author  Ross Carlson
 */
function returnCSS()
{
    global $css;

    return $css;
}

/**
 * returns the HTML code to close the head
 *
 * @return returns HTML code for the javascript includes
 * @version 04/29/04
 * @since   04/29/04
 * @author  Ross Carlson
 */
function returnCloseHTMLHead()
{
    return '</head>';
}

/**
 * returns the HTML code to open the HEAD tag
 *
 * @version 04/29/04
 * @since   04/29/04
 * @author  Ross Carlson
 * @param mixed $title
 * @return returns HTML code for the javascript includes
 */
function returnHTMLHead($title)
{
    global $root_dir, $site_title;

    $site = $_SERVER['HTTP_HOST'];

    if ('on' == $_SERVER['HTTPS']) {
        $site = 'https://' . $site;
    } else {
        $site = 'http://' . $site;
    }

    return '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><link rel="shortcut icon" href="' . $root_dir . '/style/favicon.ico">' . "\n" . '<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"><title>' . "\n" . $site_title . ' - ' . str_replace(
        '</nobr>',
        '',
        str_replace('<nobr>', '', str_replace('<br>', ' ', $title))
    ) . '</title>' . "\n" . '<link rel="alternate" type="application/rss+xml" title="Jinzora Most Played" href="' . $root_dir . '/rss.php?type=most-played">' . "\n";
}

/**
 * returns the HTML code for the Javascript includes
 *
 * @return returns HTML code for the javascript includes
 * @version 04/29/04
 * @since   04/29/04
 * @author  Ross Carlson
 */
function returnJavascript()
{
    global $root_dir;

    return '<script type="text/javascript" src="' . $root_dir . '/jinzora.js"></script>' . '<script type="text/javascript" src="' . $root_dir . '/overlib.js"></script>' . '<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>';
}

/**
 * returns the HTML code to block right clicking
 *
 * @return returns HTML (javascript) code to block right clicks
 * @version 04/29/04
 * @since   04/29/04
 * @author  Ross Carlson
 */
function displaySecureLinks()
{
    global $secure_links;

    if ('true' == $secure_links) {
        $retVal = '<SCRIPT LANGUAGE="JavaScript1.1">' . "\n";

        $retVal .= 'function noContext(){return false;}' . "\n";

        $retVal .= 'document.oncontextmenu = noContext;' . "\n";

        $retVal .= '// -->' . "\n";

        $retVal .= '</script>' . "\n";

        return $retVal;
    }
  

    return false;
}

/**
 * returns the HTML for the drop down list of Albums
 *
 * @param Should $onclick the select box submit on click?
 * @param What   $boxname is the name of the select box
 * @param Width  $width   in pixels
 * @return string|void
 * @return string|void
 * @version 04/29/04
 * @since   04/29/04
 * @author  Ross Carlson
 */
function returnAlbumSelect($onclick, $boxname, $width)
{
    global $directory_level, $word_pleasechoose, $quick_list_truncate;

    switch ($directory_level) {
        case '3':
            $albumArray = explode("\n", urldecode($_SESSION['album_list']));
            break;
        case '2':
            return;
            break;
        case '1':
            return;
            break;
    }

    if ($onclick) {
        $retVal = '<select name="' . $boxname . '" onChange="submit()" class="jz_select" style="width: ' . $width . 'px;">' . "\n";
    } else {
        $retVal = '<select name="' . $boxname . '" class="jz_select" style="width: ' . $width . 'px;">' . "\n";
    }

    sort($albumArray);

    $retVal .= '<option value="" selected>' . $word_pleasechoose . '</option>';

    for ($ctr = 0, $ctrMax = count($albumArray); $ctr < $ctrMax; $ctr++) {
        if ('' != $albumArray[$ctr]) {
            $albumDisplay = explode('--', $albumArray[$ctr]);

            $title = $albumDisplay[0];

            if (mb_strlen($title) > $quick_list_truncate) {
                $title = mb_substr($title, 0, $quick_list_truncate) . '...';
            }

            // Now let's set for 1, 2, or 3 level directory structure

            switch ($directory_level) {
                case '3': # 3 directories deep
                    $retVal .= '<option value="' . $albumDisplay[0] . '">' . $title . '</option>' . "\n";
                    break;
                case '2': # 2 directories deep
                    $retVal .= '<option value="' . $albumDisplay[0] . '">' . $title . '</option>' . "\n";
                    break;
                case '1': # 1 directories deep
                    $retVal .= '<option value="' . $albumDisplay[0] . '">' . $title . '</option>' . "\n";
                    break;
            }
        }
    }

    $retVal .= '</select>' . "\n";

    return $retVal;
}

/**
 * returns the HTML for the drop down list of Artists
 *
 * @param Should $onclick the select box submit on click?
 * @param What   $boxname is the name of the select box
 * @param Width  $width   in pixels
 * @return string|void
 * @return string|void
 * @version 04/29/04
 * @since   04/29/04
 * @author  Ross Carlson
 */
function returnArtistSelect($onclick, $boxname, $width)
{
    global $directory_level, $word_pleasechoose, $quick_list_truncate;

    switch ($directory_level) {
        case '3':
            $artistArray = explode("\n", urldecode($_SESSION['artist_list']));
            break;
        case '2':
            $artistArray = explode("\n", urldecode($_SESSION['album_list']));
            break;
        case '1':
            return;
            break;
    }

    if ($onclick) {
        $retVal = '<select name="' . $boxname . '" onChange="submit()" class="jz_select" style="width: ' . $width . 'px;">' . "\n";
    } else {
        $retVal = '<select name="' . $boxname . '" class="jz_select" style="width: ' . $width . 'px;">' . "\n";
    }

    sort($artistArray);

    $retVal .= '<option value="" selected>' . $word_pleasechoose . '</option>';

    for ($ctr = 0, $ctrMax = count($artistArray); $ctr < $ctrMax; $ctr++) {
        if ('' != $artistArray[$ctr]) {
            $artistDisplay = explode('--', $artistArray[$ctr]);

            $title = $artistDisplay[0];

            if (mb_strlen($title) > $quick_list_truncate) {
                $title = mb_substr($title, 0, $quick_list_truncate) . '...';
            }

            // Now let's set for 1, 2, or 3 level directory structure

            switch ($directory_level) {
                case '3': # 3 directories deep
                    $retVal .= '<option value="' . ($artistDisplay[0]) . '">' . $title . '</option>' . "\n";
                    break;
                case '2': # 2 directories deep
                    $retVal .= '<option value="' . ($artistDisplay[0]) . '">' . $title . '</option>' . "\n";
                    break;
                case '1': # 1 directories deep
                    $retVal .= '<option value="' . ($artistDisplay[0]) . '">' . $title . '</option>' . "\n";
                    break;
            }
        }
    }

    $retVal .= '</select>' . "\n";

    return $retVal;
}

/**
 * returns the HTML for the drop down list of Genres
 *
 * @param Should $onclick the select box submit on click?
 * @param What   $boxname is the name of the select box
 * @param Width  $width   in pixels
 * @return string
 * @return string
 * @version 04/29/04
 * @since   04/29/04
 * @author  Ross Carlson
 */
function returnGenreSelect($onclick, $boxname, $width)
{
    global $directory_level, $word_pleasechoose, $quick_list_truncate;

    switch ($directory_level) {
        case '3':
            $genreArray = explode("\n", urldecode($_SESSION['genre_list']));
            break;
        case '2':
            $genreArray = explode("\n", urldecode($_SESSION['artist_list']));
            break;
        case '1':
            $genreArray = explode("\n", urldecode($_SESSION['album_list']));
            break;
    }

    sort($genreArray);

    if ($onclick) {
        $retVal = '<select name="' . $boxname . '" onChange="submit()" class="jz_select" style="width: ' . $width . 'px;">' . "\n";
    } else {
        $retVal = '<select name="' . $boxname . '" class="jz_select" style="width: ' . $width . 'px;">' . "\n";
    }

    $retVal .= '<option value="" selected>' . $word_pleasechoose . '</option>';

    for ($ctr = 0, $ctrMax = count($genreArray); $ctr < $ctrMax; $ctr++) {
        if ('' != $genreArray[$ctr]) {
            $title = $genreArray[$ctr];

            if (mb_strlen($title) > $quick_list_truncate) {
                $title = mb_substr($title, 0, $quick_list_truncate) . '...';
            }

            // Now let's set for 1, 2, or 3 level directory structure

            switch ($directory_level) {
                case '3': # 3 directories deep
                    $retVal .= '<option value="' . ($genreArray[$ctr]) . '">' . $title . '</option>' . "\n";
                    break;
                case '2': # 2 directories deep
                    $retVal .= '<option value="' . ($genreArray[$ctr]) . '">' . $title . '</option>' . "\n";
                    break;
                case '1': # 1 directories deep
                    $retVal .= '<option value="' . ($genreArray[$ctr]) . '">' . $title . '</option>' . "\n";
                    break;
            }
        }
    }

    $retVal .= '</select>' . "\n";

    return $retVal;
}

// This function displays the playlist bar at the bottom
function displayPlaylistBar($songs_found)
{
    global $mp3_dir, $audio_types, $video_types, $ext_graphic, $img_play, $img_download, $get_mp3_info, $song_cellpadding, $row_colors, $main_table_width, $this_page, $word_play_album, $word_download_album, $root_dir, $media_dir, $this_site, $allow_download, $track_num_seperator, $directory_level, $web_root, $num_other_albums, $word_album, $album_name_truncate, $word_play, $img_more, $search_album_art, $word_search_for_album_art, $img_delete, $word_cancel, $word_delete, $word_are_you_sure_delete, $img_add, $img_playlist, $word_check_all, $word_check_none, $word_selected, $word_session_playlist, $word_new_playlist, $playlist_ext, $word_play_random, $img_random_play, $javascript, $get_mp3_info, $colapse_tracks, $jinzora_skin, $word_search, $amg_search, $hide_tracks, $word_hide_tracks, $word_show_tracks, $url_seperator;

    // Ok, before we show all this we need to know if they are using JavaScript or not, if not, tough, "NO PLAYLIST FOR YOU!"

    if ('yes' == $javascript and 'viewonly' != $_SESSION['jz_access_level'] and 'lofi' != $_SESSION['jz_access_level']) {
        // Let's setup our form for the checkboxes

        $formAction = $this_page . $url_seperator . $_SERVER['QUERY_STRING'];

        echo '<form action="' . $formAction . '" name="trackForm" method="POST" onSubmit="return AreYouSure();">';

        // Now let's set a hidden form field to hold the data for the click

        echo '<input type="hidden" name="submitAction">';

        // Now let's show our last row for all the other options

        echo '<table class="jz_track_table" width="' . $main_table_width . '%" cellpadding="' . $song_cellpadding . '" cellspacing="0" border="0">' . '<tr class="' . $row_colors[0] . '">';

        // First let's make sure there are really tracks here

        if ('true' == $songs_found) {
            echo '<td width="50%" class="jz_track_table_songs_td"><nobr>'
                 . "<a class=\"jz_track_table_songs_href\" style=\"cursor:hand\" onClick=\"CheckBoxes('trackForm',true);\">"
                 . $word_check_all
                 . '</a>'
                 . ' | '
                 . "<a class=\"jz_track_table_songs_href\" style=\"cursor:hand\" onClick=\"CheckBoxes('trackForm',false);\">"
                 . $word_check_none
                 . '</a></nobr>'
                 . '&nbsp;&nbsp;&nbsp;&nbsp;'
                 . "<nobr><a class=\"jz_track_table_songs_href\" style=\"cursor:hand\" onClick='trackForm.submitAction.value=\"play\";trackForm.submit()';\">"
                 . $img_play
                 . '</a> '
                 . "<a class=\"jz_track_table_songs_href\" style=\"cursor:hand\" onClick='trackForm.submitAction.value=\"play\";trackForm.submit()';\">"
                 . $word_play
                 . '</a></nobr> ';

            // Let's make sure they are an admin

            if ('admin' == $_SESSION['jz_access_level']) {
                echo "&nbsp;<nobr><a name=\"delete\" class=\"jz_track_table_songs_href\" style=\"cursor:hand\" onClick='trackForm.submitAction.value=\"delete\";if (AreYouSure()){trackForm.submit()}';\">"
                     . $img_delete
                     . '</a> '
                     . " <a class=\"jz_track_table_songs_href\" style=\"cursor:hand\" onClick='trackForm.submitAction.value=\"delete\";if (AreYouSure()){trackForm.submit()}';\">"
                     . $word_delete
                     . '</a></nobr>';
            }

            echo '</td>';
        }

        echo '<td width="50%" class="jz_track_table_songs_td" align="right"><nobr>';

        // Let's make sure there are songs to add or don't show the button

        if ('true' == $songs_found) {
            echo "<a class=\"jz_track_table_songs_href\" style=\"cursor:hand\" onClick='trackForm.submitAction.value=\"addtoplaylist\";trackForm.submit()';\">" . $img_add . '</a>';
        }

        $retArray = readDirInfo($web_root . $root_dir . '/data', 'file');

        echo ' <select name="playListToPlay" class="jz_select">';

        echo '<option value="sessionplaylist">' . $word_session_playlist . '</option>';

        echo '<option value="newplaylist">' . $word_new_playlist . '</option>';

        // Now let's get all the other playlists that exist

        for ($ctr = 0, $ctrMax = count($retArray); $ctr < $ctrMax; $ctr++) {
            // Let's make sure we're looking at a playlist file

            if (preg_match("/\.($playlist_ext)$/i", $retArray[$ctr])) {
                // Now let's display the option and make it look pretty

                $optionDisp = str_replace('.' . $playlist_ext, '', $retArray[$ctr]);

                if (mb_strlen($optionDisp) > 15) {
                    $optionDisp = mb_substr($optionDisp, 0, 15) . '...';
                }

                echo '<option value="' . $retArray[$ctr] . '">' . $optionDisp . '</option>';
            }
        }

        echo '</select> '
             . "<a class=\"jz_track_table_songs_href\" style=\"cursor:hand\" onClick='trackForm.submitAction.value=\"viewplaylist\";trackForm.submit()';\">"
             . $img_playlist
             . '</a>&nbsp;'
             . "<a class=\"jz_track_table_songs_href\" style=\"cursor:hand\" onClick='trackForm.submitAction.value=\"playplaylist\";trackForm.submit()';\">"
             . $img_play
             . '</a> '
             . "<a class=\"jz_track_table_songs_href\" style=\"cursor:hand\" onClick='trackForm.submitAction.value=\"randomplaylist\";trackForm.submit()';\">"
             . $img_random_play
             . '</a>&nbsp;&nbsp;'
             . '</nobr></td>'
             . '</tr>'
             . '</table></form>';

        echo '<br>';
    }
}

/* This function displays all the tools available to the user */
function displayTools()
{
    global $main_table_width, $this_page, $mp3_dir, $pathtoId3Tool, $web_root, $mp3_dir, $track_num_seperator, $root_dir, $mp3_dir, $image_dir, $playlist_dir, $web_root, $jinzora_temp_dir, $temp_zip_dir, $cms_mode, $cms_type, $standalone, $get_mp3_info, $cols_in_genre, $cellspacing, $song_cellpadding, $artist_truncate, $quick_list_truncate, $main_table_width, $song_cellpadding, $artistArray, $ephPod_file_name, $ephPod_drive_letter, $ipod_size, $word_id3_tag_tools, $word_update_id3v1, $word_update_id3v2, $word_strip_id3v1, $word_strip_id3v2, $word_directory_other_tools, $word_upload_center, $word_select_for_ipod, $word_fix_file_case, $word_create_new_genre, $word_delete_genre, $word_update_id3v1_desc, $word_update_id3v2_desc, $word_strip_id3v1_desc, $word_strip_id3v2_desc, $word_upload_to_jinzora, $word_ipod_select_desc, $word_fix_file_case_desc, $word_create_new_genre_desc, $word_delete_genre_desc, $word_tools, $word_enter_setup, $media_dir, $directory_level, $word_check_for_update, $word_new_genre, $jinzora_url, $version, $this_pgm, $word_send_tech_email, $this_site, $slash_vars, $word_auto_update, $jinzora_url, $word_auto_update_beta, $path_to_wget, $path_to_tar, $word_shoutcast_tools, $shoutcast, $word_start_shoutcast, $word_stop_shoutcast, $word_shoutcast_tools, $url_seperator, $shoutcast, $word_define_word_donate, $word_donate;

    /* This section got huge, so it's now in an include file */

    require_once __DIR__ . '/tools.php';
}

/* This function displays the login page then authenticaes the user for admin level access */
function displayLogin()
{
    global $word_login, $main_table_width, $cellspacing, $this_page, $word_username, $word_password, $word_remember_me, $url_seperator;

    // Let's show the header

    displayHeader($word_login);

    $formAction = $this_page; ?>
    <form action="<?php echo $formAction; ?>" method="post">
        <input type="hidden" name="returnPage" value="<?php echo $_GET['return']; ?>">
        <table width="<?php echo $main_table_width; ?>%" cellpadding="<?php echo $cellspacing; ?>" cellspacing="0" border="0">
            <tr>
                <td width="50%" align="right">
                    <font size="2">
                        <?php echo $word_username; ?>
                    </font>
                </td>
                <td width="50%">
                    <input class="jz_input" type="text" name="username">
                </td>
            </tr>
            <tr>
                <td width="50%" align="right">
                    <font size="2">
                        <?php echo $word_password; ?>
                    </font>
                </td>
                <td width="50%">
                    <input class="jz_input" type="password" name="admin_pass">
                </td>
            </tr>
            <tr>
                <td width="50%" align="right">

                </td>
                <td width="50%">
                    <font size="2">
                        <input class="jz_checkbox" type="checkbox" name="remember_me"> <?php echo $word_remember_me; ?>
                    </font>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2" align="center">
                    <input class="jz_submit" type="submit" name="submit_login" value="<?php echo $word_login; ?>">
                </td>
            </tr>
        </table>
    </form>
    <?php
}

/**
 * Display a playlist so it can be edited
 *
 * @param string $playList Name of the playlist to be opened
 * @version 05/03/04
 * @since   05/03/04
 * @author  Ross Carlson
 */
function displayPlaylists($playList)
{
    global $web_root, $root_dir, $playlist_ext, $audio_types, $video_types, $main_table_width, $song_cellpadding, $this_page, $row_colors, $word_playlist, $word_check_all, $word_check_none, $word_session_playlist, $word_new_playlist, $img_delete, $word_delete, $word_selected, $img_playlist, $img_add, $img_play, $media_dir, $word_delete, $word_playlist, $word_create_shoutcast_playlist, $shoutcast, $word_create_shoutcast_random_playlist, $url_seperator;

    // Ok, let's open the playlist they are editing so we can display it

    // Let's see if they submitted already and open the old list if they did

    if (isset($_POST['editlistname'])) {
        $filename = $web_root . $root_dir . '/data/' . $_POST['editlistname'];

        // Now let's display the header

        displayHeader($word_playlist . ': ' . str_replace('.' . $playlist_ext, '', $_POST['editlistname']));
    } else {
        $filename = $web_root . $root_dir . '/data/' . $playList;

        // Now let's display the header

        $headTitle = str_replace('.' . $playlist_ext, '', $playList);

        if ('sessionplaylist' == $headTitle) {
            $headTitle = mb_substr($word_session_playlist, 2, -2);
        }

        displayHeader($word_playlist . ': ' . $headTitle);
    }

    // Ok, now that we've got it, we need to display it

    // Let's setup our form for the checkboxes

    $formAction = $this_page;

    echo '<form action="' . $formAction . '" name="trackForm" method="POST" onSubmit="return AreYouSure();">';

    echo '<table class="jz_track_table" width="' . $main_table_width . '%" cellpadding="' . $song_cellpadding . '" cellspacing="0" border="0">';

    // Now let's make sure the file name wasn't "newplaylist", if it doesn't exist they can't view it!

    if (mb_stristr($filename, 'newplaylist')) {
        echo "<center>You can't really view a new playlist until you create it, now can you???</center><br>";

        // Now let's show them the playlist footer

        displayPlaylistFooter();

        // Now let's show them the footer

        displayFooter();

        exit();
    }

    // Let's see if this is the session playlist or not, and open that instead of a file

    if ('sessionplaylist' == $playList) {
        $contents = $_SESSION['sessionPlaylist'];
    } else {
        $handle = fopen($filename, 'rb');

        $contents = fread($handle, filesize($filename));

        fclose($handle);
    }

    // Now let's clean up the contents

    $contents = urldecode($contents);

    // Ok, now that' we've read it, we need to split it into an array so we can read it line by line

    $retArray = explode("\n", $contents);

    /* Now let's populate our table with all the songs */

    $loop_ctr = 0;

    $i = 1;

    for ($ctr = 0, $ctrMax = count($retArray); $ctr < $ctrMax; $ctr++) {
        // Let's make sure this isn't a blank line

        if ('' != $retArray[$ctr]) {
            echo '<tr class="'
                 . $row_colors[$i]
                 . '">'
                 . "\n"
                 . '<td width="2%" align="center" valign="top" class="jz_track_table_songs_td">'
                 . "\n"
                 . '<input class="jz_checkbox" type="checkbox" name="track-'
                 . $ctr
                 . '" value="'
                 . $retArray[$ctr]
                 . '">'
                 . "\n"
                 . '</td>'
                 . "\n"
                 . '<td width="98%" valign="top" class="jz_track_table_songs_td">'
                 . "\n";

            // Let's clean this up a bit...

            if ('/' == mb_substr($retArray[$ctr], mb_strlen($retArray[$ctr]) - 1, 1)) {
                $retArray[$ctr] = mb_substr($retArray[$ctr], 0, -1);
            }

            echo str_replace('/', ' &nbsp; | &nbsp; ', str_replace($web_root . $root_dir . $media_dir . '/', '', $retArray[$ctr])) . '</td>' . '</tr>' . "\n";

            $i = ++$i % 2;
        }
    }

    echo '</table><br>';

    // Now let's show them the playlist footer

    displayPlaylistFooter($playList, $ctr, $i);

    // Now let's show them the footer

    displayFooter();
}

function displayPlaylistFooter($playList = '', $ctr = 0, $i = 0)
{
    global $main_table_width, $song_cellpadding, $word_check_all, $word_check_none, $img_delete, $word_delete, $shoutcast, $img_play, $word_create_shoutcast_playlist, $word_playlist, $word_create_shoutcast_random_playlist, $word_session_playlist, $web_root, $root_dir, $img_playlist, $row_colors, $playlist_ext, $word_grab_url, $word_play, $this_page, $word_send_playlist, $this_site, $jinzora_url, $site_title, $url_seperator;

    // Now let's show them the options at the bottom

    // Now let's set a hidden form field to hold the data for the click

    echo '<input type="hidden" name="submitAction" value="viewplaylist">';

    // Now let's set a field to hold the name of the list we're working on

    if (isset($_POST['editlistname'])) {
        echo '<input type="hidden" name="editlistname" value="' . $_POST['editlistname'] . '">';
    } else {
        echo '<input type="hidden" name="editlistname" value="' . $playList . '">';
    }

    // Now let's set a field with the number of checkboxes that were here

    echo '<input type="hidden" name="numboxes" value="' . $ctr . '">';

    // Now let's show our last row for all the other options

    echo '<table class="jz_track_table" width="'
         . $main_table_width
         . '%" cellpadding="'
         . $song_cellpadding
         . '" cellspacing="0" border="0">'
         . '<tr class="'
         . $row_colors[$i]
         . '">'
         . '<td width="70%" class="jz_track_table_songs_td">'
         . "<a class=\"jz_track_table_songs_href\" style=\"cursor:hand\" onClick=\"CheckBoxes('trackForm',true);\">"
         . $word_check_all
         . '</a>'
         . ' | '
         . "<a class=\"jz_track_table_songs_href\" style=\"cursor:hand\" onClick=\"CheckBoxes('trackForm',false);\">"
         . $word_check_none
         . '</a>'
         . '&nbsp;&nbsp;';

    // Let's make sure they are an admin

    if ('admin' == $_SESSION['jz_access_level']) {
        echo "&nbsp;&nbsp;<a name=\"delete\" class=\"jz_track_table_songs_href\" style=\"cursor:hand\" onClick='trackForm.submitAction.value=\"removefromplaylist\";trackForm.submit()';\">"
             . $img_delete
             . '</a> '
             . " <a class=\"jz_track_table_songs_href\" style=\"cursor:hand\" onClick='trackForm.submitAction.value=\"removefromplaylist\";trackForm.submit()';\">"
             . $word_delete
             . ' '
             . $word_selected
             . '</a>'
             .

             "&nbsp;&nbsp;<a class=\"jz_track_table_songs_href\" style=\"cursor:hand\" onClick='trackForm.submitAction.value=\"deleteplaylist\";trackForm.submit()';\">"
             . $img_delete
             . '</a> '
             . "<a class=\"jz_track_table_songs_href\" style=\"cursor:hand\" onClick='trackForm.submitAction.value=\"deleteplaylist\";trackForm.submit()';\">"
             . $word_delete
             . ' '
             . $word_playlist
             . '</a>';
    }

    // Now let's let them play this playlist

    $playListName = str_replace('.' . $playlist_ext, '', $playList);

    echo "&nbsp;&nbsp;<a class=\"jz_track_table_songs_href\" href='mailto:?subject=Jinzora%20Playlist - $playListName&body=You have been sent a Jinzora Playlist, enjoy!%0D%0A%0D%0ATo play this playlist simply click on the link below:%0D%0A"
         . $this_site
         . $this_page
         . urlencode($url_seperator)
         . 'playlist='
         . urlencode($playList)
         . '%0D%0A%0D%0A%0D%0AGenerated by '
         . $site_title
         . '%0D%0A'
         . $jinzora_url
         . "'\">"
         . $img_play
         . '</a>';

    echo "&nbsp;<a class=\"jz_track_table_songs_href\" href='mailto:?subject=Jinzora%20Playlist - $playListName&body=You have been sent a Jinzora Playlist, enjoy!%0D%0A%0D%0ATo play this playlist simply click on the link below:%0D%0A"
         . $this_site
         . $this_page
         . urlencode($url_seperator)
         . 'playlist='
         . urlencode($playList)
         . '%0D%0A%0D%0A%0D%0AGenerated by '
         . $site_title
         . '%0D%0A'
         . $jinzora_url
         . "'\">"
         . $word_send_playlist
         . '</a>';

    // Now let's let them mark this as a shared playlist

    echo '&nbsp; &nbsp;' . word_shared_playlist . ': <select name="sharedPlaylist" class="jz_select"><option value="false">' . word_false . '</option><option value="true">' . word_true . '</option></select>';

    // Now let's see if they are doing Shoutcast or not

    if ('true' == $shoutcast and 'admin' == $_SESSION['jz_access_level'] and 'Windows_NT' != $_SERVER['OS']) {
        echo "<br><a name=\"delete\" class=\"jz_track_table_songs_href\" style=\"cursor:hand\" onClick='trackForm.submitAction.value=\"createShoutcast\";trackForm.submit()';\">"
             . $img_play
             . '</a>'
             . "<a class=\"jz_track_table_songs_href\" style=\"cursor:hand\" onClick='trackForm.submitAction.value=\"createShoutcast\";trackForm.submit()';\">"
             . $word_create_shoutcast_playlist
             . '</a>'
             . "&nbsp;&nbsp;<a name=\"delete\" class=\"jz_track_table_songs_href\" style=\"cursor:hand\" onClick='trackForm.submitAction.value=\"createShoutcastRandom\";trackForm.submit()';\">"
             . $img_play
             . '</a>'
             . "<a class=\"jz_track_table_songs_href\" style=\"cursor:hand\" onClick='trackForm.submitAction.value=\"createShoutcastRandom\";trackForm.submit()';\">"
             . $word_create_shoutcast_random_playlist
             . '</a>';
    }

    echo '</td>' . '<td width="30%" class="jz_track_table_songs_td" align="right">';

    // Now let's build the URL for the playlist

    echo ' <select name="playListToPlay" class="jz_select">';

    // First let's select the one they are looking at

    echo '<option value="sessionplaylist">' . $word_session_playlist . '</option>';

    // Now let's get all the other playlists that exist

    $retArray = readDirInfo($web_root . $root_dir . '/data/', 'file');

    for ($ctr = 0, $ctrMax = count($retArray); $ctr < $ctrMax; $ctr++) {
        // Let's make sure we're looking at a playlist file

        if (preg_match("/\.($playlist_ext)$/i", $retArray[$ctr])) {
            $optionDisp = str_replace('.' . $playlist_ext, '', $retArray[$ctr]);

            if (mb_strlen($optionDisp) > 15) {
                $optionDisp = mb_substr($optionDisp, 0, 15) . '...';
            }

            // Now let's display the option and make it look pretty

            // Let's also check and see if it is the playlist we are looking at and if so select it!

            if ($retArray[$ctr] == $playList) {
                $selected = 'selected';
            } else {
                $selected = '';
            }

            echo '<option ' . $selected . ' value="' . $retArray[$ctr] . '">' . $optionDisp . '</option>';
        }
    }

    echo '</select> '
         . "&nbsp;&nbsp;<a class=\"jz_track_table_songs_href\" style=\"cursor:hand\" onClick='trackForm.submitAction.value=\"viewplaylist\";trackForm.submit()';\">"
         . $img_playlist
         . '</a>'
         . "&nbsp;&nbsp;<a class=\"jz_track_table_songs_href\" style=\"cursor:hand\" onClick='trackForm.submitAction.value=\"playplaylist\";trackForm.submit()';\">"
         . $img_play
         . '</a>&nbsp;&nbsp;'
         . '</td>'
         . '</tr>'
         . '</table></form><br>';
}

?>

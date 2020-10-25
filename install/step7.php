<?php

// Let's get the path to the images...
if (mb_stristr(@$_SERVER['REQUEST_URI'], 'modules.php') or mb_stristr(@$_SERVER['REQUEST_URI'], 'name=')) {
    $pathArray = explode('/', $_SERVER['REQUEST_URI']);

    unset($pathArray[count($pathArray) - 1]);

    $path = implode('/', $pathArray);

    $img_path = 'modules/' . $_GET['name'] . '/';
} else {
    $img_path = '';
}

// Now let's see if we are in Mambo mode!
if (isset($_SERVER['cms_type'])) {
    if ('mambo' == $_SERVER['cms_type']) {
        $img_path = 'components/com_jinzora/';
    }
}

// Now let's fix the URL for Postnuke/PHPNuke
$href_path = @$_SERVER['REQUEST_URI'];
$href_path2 = str_replace('&install=step7', '', $_SERVER['REQUEST_URI']);
$href_path2 = str_replace('enterinstall=yes', '', $href_path2);

// Ok, first let's figure out the language file...
$inst_lang = $img_path . 'install/lang/' . $_SESSION['inst_lang_var'] . '.php';
include $inst_lang;

if (isset($_SERVER['REQUEST_URI'])) {
    if ('' != mb_strpos($_SERVER['REQUEST_URI'], '?')) {
        $root_page = $_SERVER['REQUEST_URI'] . '&';
    } else {
        $root_page = $_SERVER['REQUEST_URI'] . '?';
    }
} else {
    $root_page = 'index.php?';
}

// Now let's clean up that page
$root_page = str_replace('enterinstall=yes&', '', $root_page);
$root_page = str_replace('&&', '&', str_replace('?&', '?', str_replace('install=step7', '', $root_page) . 'install=write'));

// Let's see if they wanted to save the config file
if (isset($_GET['action'])) {
    if ('save-config' == $_GET['action']) {
        header('Content-type: application/octet-stream');

        header('Content-Disposition: attachment; filename=settings.php');

        echo str_replace('<br>', "\n", str_replace('?&gt;', '?>', str_replace('&lt;?', '<?', str_replace('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', '     ', $_SESSION['settings_file']))));

        exit();
    }

    if ('save-user' == $_GET['action']) {
        header('Content-type: application/octet-stream');

        header('Content-Disposition: attachment; filename=users.php');

        echo str_replace('<br>', "\n", str_replace('?&gt;', '?>', str_replace('&lt;?', '<?', str_replace('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', '     ', $_SESSION['user_file']))));

        exit();
    }
}

// let's see if the user database and settings file will be writeable
$filename = $_POST['web_root'] . $_POST['root_dir'] . '/settings.php';
$error = 'no';
/* Let's make sure the file exists and is writable first. */
if (!is_writable($filename)) {
    if (!file_exists($filename)) {
        /* Ok, it wasn't there, so let's see if we can create it */

        if (@!touch($filename)) {
            $error = 'yes';
        } else {
            $error = 'no';

            /* Now that we created it, let's kill it! */

            unlink($filename);
        }
    } else {
        $error = 'yes';
    }
}

$filename = $_POST['web_root'] . $_POST['root_dir'] . '/users.php';
/* Let's make sure the file exists and is writable first. */
if (!is_writable($filename)) {
    if (!file_exists($filename)) {
        /* Ok, it wasn't there, so let's see if we can create it */

        if (@!touch($filename)) {
            $error = 'yes';
        } else {
            $error = 'no';

            /* Now that we created it, let's kill it! */

            unlink($filename);
        }
    } else {
        $error = 'yes';
    }
}

// Now now we need to see if they wanted to skip along...
if ('expert' != $_SESSION['install_type']) {
    // Now let's include the proper settings file for the install type they choose

    if ('recommend' == $_SESSION['install_type'] or 'simple' == $_SESSION['install_type'] or 'workgroup' == $_SESSION['install_type']) {
        require_once __DIR__ . '/install/' . $_SESSION['install_type'] . '.php';
    } else {
        if ('upgrade' == $_SESSION['install_type']) {
            require_once 'settings.php';
        } else {
            require_once $_SESSION['install_type'] . '.php';
        }
    }

    if ('expert' != $_SESSION['install_type'] and 'yes' != $error) {
        echo '<body onload="document.installer.submit();">';
    }
}
?>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $img_path; ?>install/style.css">
<body>
<?php
if ('expert' != $_SESSION['install_type'] and 'yes' != $error) {
    echo '<form action="' . $root_page . '" method="post" name="installer">';

    require_once $img_path . 'install/postvars.php';

    echo '<br><br><center>' . $word_please_wait . '</center>';

    exit();
}
?>
<form action="<?php echo $root_page; ?>" method="post" name="installer">
    <?php require_once $img_path . 'install/postvars.php'; ?>
    <table width="800" cellpadding="5" cellspacing="0" border="0" align="center">
        <tr>
            <td width="100%">
                <table width="780" cellpadding="5" cellspacing="0" border="0" align="center">
                    <tr>
                        <td width="100%" background="<?php echo $img_path; ?>install/images/blueback.gif">
                            <table width="100%" cellpadding="5" cellspacing="0" border="0" align="center">
                                <tr>
                                    <td width="70%">
                                        &nbsp; &nbsp; <img src="<?php echo $img_path; ?>install/images/main-logo.gif">
                                    </td>
                                    <td width="50%" align="right" valign="middle">
                                        <font size="2" color="white">
                                            <strong><?php echo $this_pgm . ' ' . $version . ' Installer'; ?></strong>
                                            <br>
                                            Step 7/7&nbsp;
                                        </font>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table width="780" cellpadding="5" cellspacing="0" border="0" align="center">
                    <tr>
                        <td width="100%" background="<?php echo $img_path; ?>install/images/bg_table.gif">
                            <br>
                        </td>
                    </tr>
                </table>
                <table width="780" cellpadding="5" cellspacing="0" border="0" align="center">
                    <tr>
                        <td width="100%" background="<?php echo $img_path; ?>install/images/bg_table.gif">
                            <table width="100%" cellpadding="5" cellspacing="0" border="0" align="center">
                                <tr>
                                    <td width="100%" align="center">
                                        <font size="2">
                                            <strong><?php echo $word_verify_config; ?></strong>
                                            <?php
                                            if ('yes' == $error) {
                                                echo '<br><br>' . $word_write_error;
                                            }
                                            ?>
                                        </font>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table width="780" cellpadding="0" cellspacing="0" border="0" align="center">
                    <tr>
                        <td width="780">
                            <img src="<?php echo $img_path; ?>install/images/footer.gif">
                        </td>
                    </tr>
                </table>
                <table width="780" cellpadding="5" cellspacing="0" border="0" align="center">
                    <tr>
                        <td width="100%" background="<?php echo $img_path; ?>install/images/bg_table.gif">
                            <table width="100%" cellpadding="5" cellspacing="0" border="0" align="center">
                                <tr>
                                    <td width="20%" align="left"></td>
                                    <td width="80%" align="left">
                                        <?php
                                        $content = '&lt;?php' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$install_complete = "yes";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$config_version = "' . $version . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$web_root = "' . $_POST['web_root'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$root_dir = "' . $_POST['root_dir'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$media_dir = "' . $_POST['media_dir'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$cms_mode = "' . $_POST['cms_mode'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$cms_type = "' . $_POST['cms_type'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$lang_file = "' . $_POST['lang_file'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$allow_lang_choice = "' . $_POST['allow_lang_choice'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$jinzora_skin = "' . $_POST['jinzora_skin'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$allow_theme_change = "' . $_POST['allow_theme_change'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$allow_download = "' . $_POST['allow_download'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$get_mp3_info = "' . $_POST['get_mp3_info'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$hide_id3_comments = "' . $_POST['hide_id3_comments'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$playlist_ext = "' . $_POST['playlist_ext'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$jinzora_temp_dir = "' . $_POST['jinzora_temp_dir'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$default_access = "' . $_POST['default_access'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$directory_level = "' . $_POST['directory_level'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$show_loggedin_level = "' . $_POST['show_loggedin_level'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$cols_in_genre = "' . $_POST['cols_in_genre'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$cellspacing = "' . $_POST['cellspacing'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$song_cellpadding = "' . $_POST['song_cellpadding'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$artist_truncate = "' . $_POST['artist_truncate'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$quick_list_truncate = "' . $_POST['quick_list_truncate'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$album_name_truncate = "' . $_POST['album_name_truncate'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$main_table_width = "' . $_POST['main_table_width'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$random_play_amounts = "' . $_POST['random_play_amounts'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$random_play_types = "' . $_POST['random_play_types'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$audio_types = "' . $_POST['audio_types'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$video_types = "' . $_POST['video_types'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ext_graphic = "' . $_POST['ext_graphic'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$track_num_seperator = "' . $_POST['track_num_seperator'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ephPod_file_name = "' . $_POST['ephPod_file_name'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ephPod_drive_letter = "' . $_POST['ephPod_drive_letter'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ipod_size = "' . $_POST['ipod_size'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$javascript = "' . $_POST['javascript'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$header_drops = "' . $_POST['header_drops'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$num_other_albums = "' . $_POST['num_other_albums'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$genre_drop = "' . $_POST['genre_drop'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$artist_drop = "' . $_POST['artist_drop'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$album_drop = "' . $_POST['album_drop'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$song_drop = "' . $_POST['song_drop'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$quick_drop = "' . $_POST['quick_drop'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$album_img_width = "' . $_POST['album_img_width'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$album_img_height = "' . $_POST['album_img_height'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$album_force_width = "' . $_POST['album_force_width'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$album_force_height = "' . $_POST['album_force_height'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$artist_img_width = "' . $_POST['artist_img_width'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$artist_img_height = "' . $_POST['artist_img_height'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$keep_porportions = "' . $_POST['keep_porportions'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$search_album_art = "' . $_POST['search_album_art'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$sort_by_year = "' . $_POST['sort_by_year'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$amg_search = "' . $_POST['amg_search'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$hide_tracks = "' . $_POST['hide_tracks'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$shoutcast = "' . $_POST['shoutcast'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$sc_host = "' . $_POST['sc_host'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$sc_port = "' . $_POST['sc_port'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$sc_password = "' . $_POST['sc_password'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$sc_refresh = "' . $_POST['sc_refresh'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$auto_search_art = "' . $_POST['auto_search_art'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$show_sub_numbers = "' . $_POST['show_sub_numbers'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$download_mp3_only = "' . $_POST['download_mp3_only'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$embedded_header = "' . $_POST['embedded_header'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$embedded_footer = "' . $_POST['embedded_footer'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$show_tools_link = "' . $_POST['show_tools_link'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$auth_value = "' . $_POST['auth_value'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$show_all_checkboxes = "' . $_POST['show_all_checkboxes'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$num_rand_albums = "' . $_POST['num_rand_albums'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$use_cache_file = "' . $_POST['use_cache_file'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$cms_user_access = "' . $_POST['cms_user_access'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$help_access = "' . $_POST['help_access'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$enable_ratings = "' . $_POST['enable_ratings'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$num_top_ratings = "' . $_POST['num_top_ratings'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$enable_suggestions = "' . $_POST['enable_suggestions'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$num_suggestions = "' . $_POST['num_suggestions'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$track_plays = "' . $_POST['track_plays'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$enable_discussion = "' . $_POST['enable_discussion'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$display_time = "' . $_POST['display_time'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$display_rate = "' . $_POST['display_rate'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$display_feq = "' . $_POST['display_feq'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$display_size = "' . $_POST['display_size'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$display_downloads = "' . $_POST['display_downloads'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$display_track_num = "' . $_POST['display_track_num'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$word_new_range = "' . $_POST['word_new_range'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$enable_most_played = "' . $_POST['enable_most_played'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$num_most_played = "' . $_POST['num_most_played'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$jukebox = "' . $_POST['jukebox'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$path_to_xmms_shell = "' . $_POST['path_to_xmms_shell'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$auto_refresh = "' . $_POST['auto_refresh'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$num_upcoming = "' . $_POST['num_upcoming'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$jukebox_pass = "' . $_POST['jukebox_pass'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$jukebox_port = "' . $_POST['jukebox_port'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$download_speed = "' . $_POST['download_speed'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$multiple_download_mode = "' . $_POST['multiple_download_mode'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$single_download_mode = "' . $_POST['single_download_mode'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$date_format = "' . $_POST['date_format'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$last_played_nb = "' . $_POST['rss_news_max'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$most_played_nb = "' . $_POST['rss_news_max'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$last_rated_nb = "' . $_POST['rss_news_max'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$most_rated_nb = "' . $_POST['rss_news_max'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$top_rated_nb = "' . $_POST['rss_news_max'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$last_added_nb = "' . $_POST['rss_news_max'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$last_discussed_nb = "' . $_POST['rss_news_max'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$most_discussed_nb = "' . $_POST['rss_news_max'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$echocloud = "' . $_POST['echocloud'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$disable_random = "' . $_POST['disable_random'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$info_level = "' . $_POST['info_level'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$auto_search_lyrics = "' . $_POST['auto_search_lyrics'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$enable_playlist = "' . $_POST['enable_playlist'] . '";' . '<br>';
                                        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$track_play_only = "' . $_POST['track_play_only'] . '";' . '<br>';
                                        $content .= '?&gt;' . '<br>';
                                        echo 'Jinzora Config File (settings.php)<br>' . 'Copy below the dotted line - or - <a href=' . $href_path . '&action=save-config>Save as a file</a><br>---------------------------------------------------------<br>' . $content . '<br><br>';

                                        $_SESSION['settings_file'] = $content;

                                        // Ok, now we need to create the users.php file
                                        if (is_file($_POST['web_root'] . $_POST['root_dir'] . $_POST['jinzora_temp_dir'] . '/users.php')) {
                                            require_once $_POST['web_root'] . $_POST['root_dir'] . $_POST['jinzora_temp_dir'] . '/users.php';
                                        } else {
                                            $user_array = '';
                                        }

                                        // Now let's check to see if this user is in the database or not
                                        $userFound = 'no';
                                        for ($ctr = 0, $ctrMax = count($user_array); $ctr < $ctrMax; $ctr++) {
                                            if (isset($user_array[$ctr][0])) {
                                                if ($user_array[$ctr][0] == $_POST['admin_user']) {
                                                    // Ok, we've got the user, but let's make sure we weren't deleting

                                                    $userFound = 'yes';

                                                    if (isset($_POST['deleteuser'])) {
                                                        $user_array[$ctr][0] = '';

                                                        $user_array[$ctr][1] = '';

                                                        $user_array[$ctr][2] = '';
                                                    } else {
                                                        $user_array[$ctr][2] = 'admin';

                                                        $user_array[$ctr][1] = $_POST['adminpass'];
                                                    }
                                                }
                                            }
                                        }

                                        // Now if we didn't find them above we'll need to add them to the end
                                        if ('no' == $userFound) {
                                            // Ok, let's add them, we'll use time as the pass so it's random

                                            $pass = md5($_POST['adminpass']);

                                            $temp_array = [count($user_array) + 1 => [$_POST['admin_user'], $pass, 'admin']];

                                            $user_array = array_merge($temp_array, $user_array);
                                        }

                                        // Now let's make sure we don't have any blank entries
                                        $i = 0;
                                        for ($ctr = 0, $ctrMax = count($user_array); $ctr < $ctrMax; $ctr++) {
                                            if ('' != $user_array[$ctr][0]) {
                                                $finalArray[$i] = $user_array[$ctr];

                                                $i++;
                                            }
                                        }

                                        // Now let's create the new user database file
                                        $contents = '&lt;?php' . '<br>';
                                        $contents .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$user_array = array(';
                                        for ($ctr = 0, $ctrMax = count($finalArray); $ctr < $ctrMax; $ctr++) {
                                            $contents .= "'" . $ctr . "' => array('" . $finalArray[$ctr][0] . "','" . $finalArray[$ctr][1] . "','" . $finalArray[$ctr][2] . "')," . '<br>';
                                        }
                                        $contents .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);' . '<br>';
                                        $contents .= '?&gt;' . '<br>';
                                        $_SESSION['user_file'] = $contents;

                                        echo 'Jinzora User Database File (users.php)<br>' . 'Copy below the dotted line - or - <a href=' . $href_path . '&action=save-user>Save as a file</a><br>---------------------------------------------------------<br>' . $contents . '<br><br>';

                                        echo '<br><br>';
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table width="780" cellpadding="0" cellspacing="0" border="0" align="center">
                    <tr>
                        <td width="780">
                            <img src="<?php echo $img_path; ?>install/images/footer.gif">
                        </td>
                    </tr>
                </table>
                <table width="780" cellpadding="5" cellspacing="0" border="0" align="center">
                    <tr>
                        <td width="100%" background="<?php echo $img_path; ?>install/images/bg_table.gif">
                            <table width="100%" cellpadding="5" cellspacing="0" border="0" align="center">
                                <tr>
                                    <td width="50%" align="left">

                                    </td>
                                    <td width="50%" align="right">
                                        <br>
                                        <br>
                                        <font size="1">
                                            Write Config >> &nbsp;&nbsp;&nbsp;
                                        </font>
                                        <br>
                                        <?php
                                        if ('yes' != $error) {
                                            echo '<input type="submit" name="step1" value="Finish & Launch >">&nbsp;&nbsp;&nbsp;';
                                        }
                                        ?>
                                        <br><br>
                                        <?php echo $word_launch_note; ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table width="780" cellpadding="0" cellspacing="0" border="0" align="center">
                    <tr>
                        <td width="780">
                            <img src="<?php echo $img_path; ?>install/images/footer.gif">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>
</body>

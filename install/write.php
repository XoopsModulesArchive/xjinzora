<?php

// Ok, now we need to create the users.php file
if (is_file($_POST['web_root'] . $_POST['root_dir'] . '/users.php')) {
    require_once $_POST['web_root'] . $_POST['root_dir'] . '/users.php';
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

                $user_array[$ctr][1] = md5($_POST['adminpass']);
            }
        }
    }
}

// Now if we didn't find them above we'll need to add them to the end
if ('no' == $userFound) {
    // Ok, let's add them, we'll use time as the pass so it's random

    if (isset($_POST['adminpass'])) {
        $pass = md5($_POST['adminpass']);
    } else {
        $pass = time();
    }

    $temp_array = [count($user_array) + 1 => [$_POST['admin_user'], $pass, 'admin']];

    $user_array = array_merge($temp_array, $user_array);
}

// Now let's make sure we don't have any blank entries
$i = 0;
for ($ctr = 0, $ctrMax = count($user_array); $ctr < $ctrMax; $ctr++) {
    if ('' != $user_array[$ctr]) {
        if ('' != $user_array[$ctr][0]) {
            $finalArray[$i] = $user_array[$ctr];

            $i++;
        }
    }
}

// Now let's create the new user database file
$contents = '<?php' . "\n";
$contents .= '$user_array = array(';
for ($ctr = 0, $ctrMax = count($finalArray); $ctr < $ctrMax; $ctr++) {
    $contents .= "'" . $ctr . "' => array('" . $finalArray[$ctr][0] . "','" . $finalArray[$ctr][1] . "','" . $finalArray[$ctr][2] . "')," . "\n";
}
$contents .= ');' . "\n";
$contents .= '?>' . "\n";

// Ok, now let's write the file
$filename = $_POST['web_root'] . $_POST['root_dir'] . '/users.php';
if (!file_exists($filename)) {
    @touch($filename);
}

if (is_writable($filename)) {
    $handle = fopen($filename, 'wb');

    fwrite($handle, $contents);

    fclose($handle);

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

    $root_page = str_replace('&&', '&', str_replace('?&', '?', str_replace('install=write', '', $root_page)));

    /* Now let's send them to Jinzora!!! */

    header('Location: ' . $root_page);
} else {
    echo "Sorry, but I couldn't write the users database file<br><br>"
         . "You'll need to do a chmod 777 "
         . $_POST['web_root']
         . $_POST['root_dir']
         . $_POST['jinzora_temp_dir']
         . '<br><br>'
         . ' ... or ...<br><br>'
         . 'Go back and save the user database as a file and upload it...<br><br>'
         . 'so the installer can create the initial users database...<br>'
         . "Once you've done this please just refresh this page...<br><br>"
         . '... or ...<br><br>'
         . '<a href="index.php">Click Here</a> to go to Jinzora!';

    exit();
}

/* First let's write a variable with all the content */
$content = '<?php' . "\n";
$content .= '     // Configuration written by Jinzora Installer Version ' . $version . "\n";
$content .= '     // ---------------------------------------------------------------------------------------' . "\n";
$content .= '     // If sending this file for tech support please copy below this line to the next point' . "\n";
$content .= '     // ---------------------------------------------------------------------------------------' . "\n";
$content .= '     $config_version = "' . $version . '";' . "\n";
$content .= '     $install_complete = "yes";' . "\n";
$content .= '     $web_root = "' . $_POST['web_root'] . '";' . "\n";
$content .= '     $root_dir = "' . $_POST['root_dir'] . '";' . "\n";
$content .= '     $media_dir = "' . $_POST['media_dir'] . '";' . "\n";
$content .= '     $cms_mode = "' . $_POST['cms_mode'] . '";' . "\n";
$content .= '     $cms_type = "' . $_POST['cms_type'] . '";' . "\n";
$content .= '     $lang_file = "' . $_POST['lang_file'] . '";' . "\n";
$content .= '     $allow_lang_choice = "' . $_POST['allow_lang_choice'] . '";' . "\n";
$content .= '     $jinzora_skin = "' . $_POST['jinzora_skin'] . '";' . "\n";
$content .= '     $allow_theme_change = "' . $_POST['allow_theme_change'] . '";' . "\n";
$content .= '     $allow_download = "' . $_POST['allow_download'] . '";' . "\n";
$content .= '     $get_mp3_info = "' . $_POST['get_mp3_info'] . '";' . "\n";
$content .= '     $hide_id3_comments = "' . $_POST['hide_id3_comments'] . '";' . "\n";
$content .= '     $playlist_ext = "' . $_POST['playlist_ext'] . '";' . "\n";
$content .= '     $jinzora_temp_dir = "' . $_POST['jinzora_temp_dir'] . '";' . "\n";
$content .= '     $default_access = "' . $_POST['default_access'] . '";' . "\n";
$content .= '     $directory_level = "' . $_POST['directory_level'] . '";' . "\n";
$content .= '     $show_loggedin_level = "' . $_POST['show_loggedin_level'] . '";' . "\n";
$content .= '     $cols_in_genre = "' . $_POST['cols_in_genre'] . '";' . "\n";
$content .= '     $cellspacing = "' . $_POST['cellspacing'] . '";' . "\n";
$content .= '     $song_cellpadding = "' . $_POST['song_cellpadding'] . '";' . "\n";
$content .= '     $artist_truncate = "' . $_POST['artist_truncate'] . '";' . "\n";
$content .= '     $quick_list_truncate = "' . $_POST['quick_list_truncate'] . '";' . "\n";
$content .= '     $album_name_truncate = "' . $_POST['album_name_truncate'] . '";' . "\n";
$content .= '     $main_table_width = "' . $_POST['main_table_width'] . '";' . "\n";
$content .= '     $random_play_amounts = "' . $_POST['random_play_amounts'] . '";' . "\n";
$content .= '     $random_play_types = "' . $_POST['random_play_types'] . '";' . "\n";
$content .= '     $audio_types = "' . $_POST['audio_types'] . '";' . "\n";
$content .= '     $video_types = "' . $_POST['video_types'] . '";' . "\n";
$content .= '     $ext_graphic = "' . $_POST['ext_graphic'] . '";' . "\n";
$content .= '     $track_num_seperator = "' . $_POST['track_num_seperator'] . '";' . "\n";
$content .= '     $ephPod_file_name = "' . $_POST['ephPod_file_name'] . '";' . "\n";
$content .= '     $ephPod_drive_letter = "' . $_POST['ephPod_drive_letter'] . '";' . "\n";
$content .= '     $ipod_size = "' . $_POST['ipod_size'] . '";' . "\n";
$content .= '     $javascript = "' . $_POST['javascript'] . '";' . "\n";
$content .= '     $header_drops = "' . $_POST['header_drops'] . '";' . "\n";
$content .= '     $num_other_albums = "' . $_POST['num_other_albums'] . '";' . "\n";
$content .= '     $genre_drop = "' . $_POST['genre_drop'] . '";' . "\n";
$content .= '     $artist_drop = "' . $_POST['artist_drop'] . '";' . "\n";
$content .= '     $album_drop = "' . $_POST['album_drop'] . '";' . "\n";
$content .= '     $song_drop = "' . $_POST['song_drop'] . '";' . "\n";
$content .= '     $quick_drop = "' . $_POST['quick_drop'] . '";' . "\n";
$content .= '     $album_img_width = "' . $_POST['album_img_width'] . '";' . "\n";
$content .= '     $album_img_height = "' . $_POST['album_img_height'] . '";' . "\n";
$content .= '     $album_force_height = "' . $_POST['album_force_height'] . '";' . "\n";
$content .= '     $album_force_width = "' . $_POST['album_force_width'] . '";' . "\n";
$content .= '     $artist_img_width = "' . $_POST['artist_img_width'] . '";' . "\n";
$content .= '     $artist_img_height = "' . $_POST['artist_img_height'] . '";' . "\n";
$content .= '     $keep_porportions = "' . $_POST['keep_porportions'] . '";' . "\n";
$content .= '     $search_album_art = "' . $_POST['search_album_art'] . '";' . "\n";
$content .= '     $sort_by_year = "' . $_POST['sort_by_year'] . '";' . "\n";
$content .= '     $amg_search = "' . $_POST['amg_search'] . '";' . "\n";
$content .= '     $hide_tracks = "' . $_POST['hide_tracks'] . '";' . "\n";
$content .= '     $shoutcast = "' . $_POST['shoutcast'] . '";' . "\n";
$content .= '     $sc_host = "' . $_POST['sc_host'] . '";' . "\n";
$content .= '     $sc_port = "' . $_POST['sc_port'] . '";' . "\n";
$content .= '     $sc_password = "' . $_POST['sc_password'] . '";' . "\n";
$content .= '     $sc_refresh = "' . $_POST['sc_refresh'] . '";' . "\n";
$content .= '     $auto_search_art = "' . $_POST['auto_search_art'] . '";' . "\n";
$content .= '     $show_sub_numbers = "' . $_POST['show_sub_numbers'] . '";' . "\n";
$content .= '     $download_mp3_only = "' . $_POST['download_mp3_only'] . '";' . "\n";
$content .= '     $embedded_header = "' . $_POST['embedded_header'] . '";' . "\n";
$content .= '     $embedded_footer = "' . $_POST['embedded_footer'] . '";' . "\n";
$content .= '     $show_tools_link = "' . $_POST['show_tools_link'] . '";' . "\n";
$content .= '     $auth_value = "' . $_POST['auth_value'] . '";' . "\n";
$content .= '     $show_all_checkboxes = "' . $_POST['show_all_checkboxes'] . '";' . "\n";
$content .= '     $num_rand_albums = "' . $_POST['num_rand_albums'] . '";' . "\n";
$content .= '     $use_cache_file = "' . $_POST['use_cache_file'] . '";' . "\n";
$content .= '     $cms_user_access = "' . $_POST['cms_user_access'] . '";' . "\n";
$content .= '     $help_access = "' . $_POST['help_access'] . '";' . "\n";
$content .= '     $enable_ratings = "' . $_POST['enable_ratings'] . '";' . "\n";
$content .= '     $num_top_ratings = "' . $_POST['num_top_ratings'] . '";' . "\n";
$content .= '     $enable_suggestions = "' . $_POST['enable_suggestions'] . '";' . "\n";
$content .= '     $num_suggestions = "' . $_POST['num_suggestions'] . '";' . "\n";
$content .= '     $track_plays = "' . $_POST['track_plays'] . '";' . "\n";
$content .= '     $enable_discussion = "' . $_POST['enable_discussion'] . '";' . "\n";
$content .= '     $display_time = "' . $_POST['display_time'] . '";' . "\n";
$content .= '     $display_rate = "' . $_POST['display_rate'] . '";' . "\n";
$content .= '     $display_feq = "' . $_POST['display_feq'] . '";' . "\n";
$content .= '     $display_size = "' . $_POST['display_size'] . '";' . "\n";
$content .= '     $display_downloads = "' . $_POST['display_downloads'] . '";' . "\n";
$content .= '     $display_track_num = "' . $_POST['display_track_num'] . '";' . "\n";
$content .= '     $days_for_new = "' . $_POST['days_for_new'] . '";' . "\n";
$content .= '     $enable_most_played = "' . $_POST['enable_most_played'] . '";' . "\n";
$content .= '     $num_most_played = "' . $_POST['num_most_played'] . '";' . "\n";
$content .= '     $jukebox = "' . $_POST['jukebox'] . '";' . "\n";
$content .= '     $path_to_xmms_shell = "' . $_POST['path_to_xmms_shell'] . '";' . "\n";
$content .= '     $jukebox_pass = "' . $_POST['jukebox_pass'] . '";' . "\n";
$content .= '     $jukebox_port = "' . $_POST['jukebox_port'] . '";' . "\n";
$content .= '     $auto_refresh = "' . $_POST['auto_refresh'] . '";' . "\n";
$content .= '     $num_upcoming = "' . $_POST['num_upcoming'] . '";' . "\n";
$content .= '     $download_speed = "' . $_POST['download_speed'] . '";' . "\n";
$content .= '     $multiple_download_mode = "' . $_POST['multiple_download_mode'] . '";' . "\n";
$content .= '     $single_download_mode = "' . $_POST['single_download_mode'] . '";' . "\n";
$content .= '     $date_format = "' . $_POST['date_format'] . '";' . "\n";
$content .= '     $last_played_nb = "' . $_POST['rss_news_max'] . '";' . "\n";
$content .= '     $most_played_nb = "' . $_POST['rss_news_max'] . '";' . "\n";
$content .= '     $last_rated_nb = "' . $_POST['rss_news_max'] . '";' . "\n";
$content .= '     $most_rated_nb = "' . $_POST['rss_news_max'] . '";' . "\n";
$content .= '     $top_rated_nb = "' . $_POST['rss_news_max'] . '";' . "\n";
$content .= '     $last_added_nb = "' . $_POST['rss_news_max'] . '";' . "\n";
$content .= '     $last_discussed_nb = "' . $_POST['rss_news_max'] . '";' . "\n";
$content .= '     $most_discussed_nb = "' . $_POST['rss_news_max'] . '";' . "\n";
$content .= '     $echocloud = "' . $_POST['echocloud'] . '";' . "\n";
$content .= '     $disable_random = "' . $_POST['disable_random'] . '";' . "\n";
$content .= '     $info_level = "' . $_POST['info_level'] . '";' . "\n";
$content .= '     $auto_search_lyrics = "' . $_POST['auto_search_lyrics'] . '";' . "\n";
$content .= '     $track_play_only = "' . $_POST['track_play_only'] . '";' . "\n";
$content .= '     $enable_playlist = "' . $_POST['enable_playlist'] . '";' . "\n";
$content .= '     // ---------------------------------------------------------------------------------------' . "\n";
$content .= '     // Please only copy to the line above this one when sending for tech support' . "\n";
$content .= '     // ---------------------------------------------------------------------------------------' . "\n";
$content .= '?>' . "\n";

/* Now let's write the content to the settings file */
$filename = $_POST['web_root'] . $_POST['root_dir'] . '/settings.php';
/* Let's make sure the file exists and is writable first. */
if (!file_exists($filename)) {
    touch($filename);
}
if (is_writable($filename)) {
    if (!$handle = fopen($filename, 'wb')) {
        print $word_cannot_open;

        exit;
    }

    /* Write $somecontent to our opened file. */

    if (!fwrite($handle, $content)) {
        print $word_cannot_open;

        exit;
    }

    fclose($handle);
} else {
    print $word_cannot_open;
}

exit();

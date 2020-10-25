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

        $cms_type = 'mambo';
    }
}

// Ok, first let's figure out the language file...
$inst_lang = $img_path . 'install/lang/' . $_SESSION['inst_lang_var'] . '.php';
include $inst_lang;

/* let's try to find out where this thing is for them - we can only do this on *NIX machines... */
// Let's se these variables, ONLY if they aren't already set
if ('' == $web_root) {
    if (isset($_SERVER['DOCUMENT_ROOT'])) {
        $web_root = $_SERVER['DOCUMENT_ROOT'];
    }
}
if ('' == $root_dir) {
    /* We need to clean this one up by removing the page name */

    if (isset($_SERVER['REQUEST_URI'])) {
        $root_dir = mb_substr($_SERVER['REQUEST_URI'], 0, mb_strpos($_SERVER['REQUEST_URI'], 'index.php') - 1);
    }

    // No lets make sure they hit the index.php page and if not fix this

    if (!is_dir($web_root . $root_dir)) {
        $root_dir = mb_substr($root_dir, 0, mb_strpos($root_dir, 'install'));

        $root_dir = str_replace('/?', '', $root_dir);
    }
}
if (isset($_SERVER['cms_type'])) {
    if ('mambo' == $_SERVER['cms_type']) {
        $root_dir .= '/components/com_jinzora';
    }
}

if ('' == $media_dir) {
    $media_dir = '/music';
}
/* Ok, let's see if we can figure this out if we think it is a PostNuke page */
if ('' != mb_strpos($root_dir, 'modules.php')) {
    /* Ok, it looks like a postnuke modules, let's see if we can figure out the right paths */

    $pathArray = explode('?', $root_dir);

    $nextArray = explode('&', mb_substr($pathArray[1], mb_strpos($pathArray[1], 'name=') + 5, 10000));

    $modules_root = str_replace('modules.php', '', $pathArray[0]);

    $root_dir = $modules_root . 'modules/' . $nextArray[0];
}
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
$root_page = str_replace('&&', '&', str_replace('?&', '?', str_replace('install=step3', '', $root_page) . 'install=step4'));

// Ok, now let's see if they wanted to do expert
// If not, we'll jump right to the end for them
if ('expert' != $_POST['install_type']) {
    $root_page = str_replace('=step4', '=step7', $root_page);
}

// Now let's see if they choose a CMS mode or not
$cms_mode = 'false';
switch ($_POST['install_type']) {
    case 'postnuke':
        $cms_mode = 'true';
        break;
    case 'phpnuke':
        $cms_mode = 'true';
        break;
    case 'nsnnuke':
        $cms_mode = 'true';
        break;
    case 'mambo':
        $cms_mode = 'true';
        break;
    case 'mdpro':
        $cms_mode = 'true';
        break;
    case 'cpgnuke':
        $cms_mode = 'true';
        break;
}

// Let's try to figure out if this is a PostNuke install and set that for them
if ('' != mb_stristr($HTTP_SERVER_VARS['PHP_SELF'], 'modules.php')) {
    // Ok, it looks like they really want a PostNuke install, let's set that

    $cms_mode = 'true';
}

// Ok, now let's see if we can give them a 1 click install or not
if (is_dir($web_root . $root_dir . $media_dir)) {
    $quick_install = 'yes';
} else {
    $quick_install = 'no';
}
// Now we need to make sure the file is writeable at the end
$filename = $web_root . $root_dir . '/settings.php';
if (is_writable($filename)) {
    $quick_install = 'yes';
} else {
    $quick_install = 'no';
}

// Now let's set a session variable so we'll know what they choose for install type
$_SESSION['install_type'] = $_POST['install_type'];

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
}

$username = 'Admin';
?>
<script type="text/javascript">
    <!--//
    var firstPass;
    var secondPass;

    function verifyPass() {
        firstPass = document.form1.adminpass.value;
        secondPass = document.form1.adminpass2.value;
        if (firstPass != secondPass) {
            alert('Error: passwords do not match!');
        } else {
            alert('<?php echo str_replace("'", '', $install_message); ?>');
            document.form1.submit();
        }
    }

    //-->
</script>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $img_path; ?>install/style.css">
<form action="<?php echo $root_page; ?>" method="post" name="form1">
    <input type="hidden" name="lang_file" value="english">
    <input type="hidden" name="allow_lang_choice" value="<?php echo $allow_lang_choice; ?>">
    <input type="hidden" name="jinzora_skin" value="<?php echo $jinzora_skin; ?>">
    <input type="hidden" name="allow_theme_change" value="<?php echo $allow_theme_change; ?>">
    <input type="hidden" name="allow_download" value="<?php echo $allow_download; ?>">
    <input type="hidden" name="get_mp3_info" value="<?php echo $get_mp3_info; ?>">
    <input type="hidden" name="hide_id3_comments" value="<?php echo $hide_id3_comments; ?>">
    <input type="hidden" name="playlist_dir" value="<?php echo $jinzora_temp_dir; ?>">
    <input type="hidden" name="playlist_ext" value="<?php echo $playlist_ext; ?>">
    <input type="hidden" name="jinzora_temp_dir" value="<?php echo $jinzora_temp_dir; ?>">
    <input type="hidden" name="playlist_directory" value="<?php echo $jinzora_temp_dir; ?>">
    <input type="hidden" name="directory_level" value="<?php echo $directory_level; ?>">
    <input type="hidden" name="show_loggedin_level" value="<?php echo $show_loggedin_level; ?>">
    <input type="hidden" name="cols_in_genre" value="<?php echo $cols_in_genre; ?>">
    <input type="hidden" name="cellspacing" value="<?php echo $cellspacing; ?>">
    <input type="hidden" name="song_cellpadding" value="<?php echo $song_cellpadding; ?>">
    <input type="hidden" name="artist_truncate" value="<?php echo $artist_truncate; ?>">
    <input type="hidden" name="quick_list_truncate" value="<?php echo $quick_list_truncate; ?>">
    <input type="hidden" name="album_name_truncate" value="<?php echo $album_name_truncate; ?>">
    <input type="hidden" name="main_table_width" value="<?php echo $main_table_width; ?>">
    <input type="hidden" name="random_play_amounts" value="<?php echo $random_play_amounts; ?>">
    <input type="hidden" name="random_play_types" value="<?php echo $random_play_types; ?>">
    <input type="hidden" name="audio_types" value="<?php echo $audio_types; ?>">
    <input type="hidden" name="video_types" value="<?php echo $video_types; ?>">
    <input type="hidden" name="ext_graphic" value="<?php echo $ext_graphic; ?>">
    <input type="hidden" name="track_num_seperator" value="<?php echo $track_num_seperator; ?>">
    <input type="hidden" name="ephPod_file_name" value="<?php echo $ephPod_file_name; ?>">
    <input type="hidden" name="ephPod_drive_letter" value="<?php echo $ephPod_drive_letter; ?>">
    <input type="hidden" name="ipod_size" value="<?php echo $ipod_size; ?>">
    <input type="hidden" name="javascript" value="<?php echo $javascript; ?>">
    <input type="hidden" name="header_drops" value="<?php echo $header_drops; ?>">
    <input type="hidden" name="start_page" value="<?php echo $start_page; ?>">
    <input type="hidden" name="num_other_albums" value="<?php echo $num_other_albums; ?>">
    <input type="hidden" name="genre_drop" value="<?php echo $genre_drop; ?>">
    <input type="hidden" name="artist_drop" value="<?php echo $artist_drop; ?>">
    <input type="hidden" name="album_drop" value="<?php echo $album_drop; ?>">
    <input type="hidden" name="song_drop" value="<?php echo $song_drop; ?>">
    <input type="hidden" name="quick_drop" value="<?php echo $quick_drop; ?>">
    <input type="hidden" name="album_img_width" value="<?php echo $album_img_width; ?>">
    <input type="hidden" name="album_img_height" value="<?php echo $album_img_height; ?>">
    <input type="hidden" name="album_force_width" value="<?php echo $album_force_width; ?>">
    <input type="hidden" name="album_force_height" value="<?php echo $album_force_height; ?>">
    <input type="hidden" name="artist_img_width" value="<?php echo $artist_img_width; ?>">
    <input type="hidden" name="artist_img_height" value="<?php echo $artist_img_height; ?>">
    <input type="hidden" name="keep_porportions" value="<?php echo $keep_porportions; ?>">
    <input type="hidden" name="search_album_art" value="<?php echo $search_album_art; ?>">
    <input type="hidden" name="sort_by_year" value="<?php echo $sort_by_year; ?>">
    <input type="hidden" name="amg_search" value="<?php echo $amg_search; ?>">
    <input type="hidden" name="hide_tracks" value="<?php echo $hide_tracks; ?>">
    <input type="hidden" name="shoutcast" value="<?php echo $shoutcast; ?>">
    <input type="hidden" name="sc_host" value="<?php echo $sc_host; ?>">
    <input type="hidden" name="sc_port" value="<?php echo $sc_port; ?>">
    <input type="hidden" name="sc_password" value="<?php echo $sc_password; ?>">
    <input type="hidden" name="sc_refresh" value="<?php echo $sc_refresh; ?>">
    <input type="hidden" name="auto_search_art" value="<?php echo $auto_search_art; ?>">
    <input type="hidden" name="show_sub_numbers" value="<?php echo $show_sub_numbers; ?>">
    <input type="hidden" name="download_mp3_only" value="<?php echo $download_mp3_only; ?>">
    <input type="hidden" name="embedded_header" value="<?php echo $embedded_header; ?>">
    <input type="hidden" name="embedded_footer" value="<?php echo $embedded_footer; ?>">
    <input type="hidden" name="show_tools_link" value="<?php echo $show_tools_link; ?>">
    <input type="hidden" name="auth_value" value="<?php echo $auth_value; ?>">
    <input type="hidden" name="admin_user" value="<?php echo $admin_user; ?>">
    <input type="hidden" name="admin_pass" value="<?php echo $admin_pass; ?>">
    <input type="hidden" name="show_all_checkboxes" value="<?php echo $show_all_checkboxes; ?>">
    <input type="hidden" name="num_rand_albums" value="<?php echo $num_rand_albums; ?>">
    <input type="hidden" name="use_cache_file" value="<?php echo $use_cache_file; ?>">
    <input type="hidden" name="cms_user_access" value="<?php echo $cms_user_access; ?>">
    <input type="hidden" name="help_access" value="<?php echo $help_access; ?>">
    <input type="hidden" name="enable_ratings" value="<?php echo $enable_ratings; ?>">
    <input type="hidden" name="num_top_ratings" value="<?php echo $num_top_ratings; ?>">
    <input type="hidden" name="num_suggestions" value="<?php echo $num_suggestions; ?>">
    <input type="hidden" name="enable_suggestions" value="<?php echo $enable_suggestions; ?>">
    <input type="hidden" name="track_plays" value="<?php echo $track_plays; ?>">
    <input type="hidden" name="enable_discussion" value="<?php echo $enable_discussion; ?>">
    <input type="hidden" name="display_time" value="<?php echo $display_time; ?>">
    <input type="hidden" name="display_rate" value="<?php echo $display_rate; ?>">
    <input type="hidden" name="display_feq" value="<?php echo $display_feq; ?>">
    <input type="hidden" name="display_size" value="<?php echo $display_size; ?>">
    <input type="hidden" name="days_for_new" value="<?php echo $days_for_new; ?>">
    <input type="hidden" name="enable_most_played" value="<?php echo $enable_most_played; ?>">
    <input type="hidden" name="num_most_played" value="<?php echo $num_most_played; ?>">
    <input type="hidden" name="cms_mode" value="<?php echo $cms_mode; ?>">
    <input type="hidden" name="cms_type" value="<?php echo $cms_type; ?>">
    <input type="hidden" name="jukebox" value="<?php echo $jukebox; ?>">
    <input type="hidden" name="path_to_xmms_shell" value="<?php echo $path_to_xmms_shell; ?>">
    <input type="hidden" name="auto_refresh" value="<?php echo $auto_refresh; ?>">
    <input type="hidden" name="num_upcoming" value="<?php echo $num_upcoming; ?>">
    <input type="hidden" name="download_speed" value="<?php echo $download_speed; ?>">
    <input type="hidden" name="multiple_download_mode" value="<?php echo $multiple_download_mode; ?>">
    <input type="hidden" name="single_download_mode" value="<?php echo $single_download_mode; ?>">
    <input type="hidden" name="date_format" value="<?php echo $date_format; ?>">
    <input type="hidden" name="rss_news_max" value="5">
    <input type="hidden" name="echocloud" value="<?php echo $echocloud; ?>">
    <input type="hidden" name="disable_random" value="<?php echo $disable_random; ?>">
    <input type="hidden" name="info_level" value="<?php echo $info_level; ?>">
    <input type="hidden" name="auto_search_lyrics" value="<?php echo $auto_search_lyrics; ?>">
    <input type="hidden" name="track_play_only" value="<?php echo $track_play_only; ?>">
    <input type="hidden" name="enable_playlist" value="<?php echo $enable_playlist; ?>">
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
                                            <?php
                                            if ('expert' == $_SESSION['install_type']) {
                                                echo '<br>Step 3/7&nbsp;';
                                            }
                                            ?>
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
                                            <strong><?php echo $word_primary_settings; ?></strong>
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
                                    <td width="100%" align="center">
                                        <br>
                                        <table width="100%" cellpadding="5" cellspacing="0" border="0">
                                            <tr class="<?php if ('true' != $cms_mode) {
                                                echo 'jz_row1';
                                            } else {
                                                echo 'jz_row2';
                                            } ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <strong><?php echo $word_admin_username; ?></strong>
                                                </td>
                                                <td width="70%">
                                                    <input type="text" name="admin_user" size="30" value="<?php echo $username; ?>">
                                                    <br>
                                                    <?php
                                                    // Now let's hide this if they are NOT in CMS mode
                                                    if ('expert' == $_POST['install_type'] or 'false' != $cms_mode) {
                                                        echo $word_admin_username_note;
                                                    }
                                                    ?>
                                                </td>

                                            </tr>
                                            <?php
                                            // Let's only show the password for non-cms installs
                                            if ('true' != $cms_mode) {
                                                ?>
                                                <tr class="jz_row2">
                                                    <td width="30%" align="right" valign="top">
                                                        <strong><?php echo $word_admin_password; ?></strong>
                                                    </td>
                                                    <td width="70%">
                                                        <input type="password" name="adminpass" size="30"><br>
                                                        <input type="password" name="adminpass2" size="30">
                                                        <br>
                                                    </td>
                                                </tr>
                                                <?php
                                            } else {
                                                ?>
                                                <input type="hidden" name="adminpass" size="30" value="">
                                                <input type="hidden" name="adminpass2" size="30" value="">
                                                <?php
                                            }
                                            ?>
                                            <tr class="jz_row1">
                                                <td width="30%" align="right" valign="top">
                                                    <strong><?php echo $word_web_root; ?></strong>
                                                    <br>
                                                    ($web_root)
                                                </td>
                                                <td width="70%">
                                                    <input type="text" name="web_root" size="20" value="<?php echo $web_root; ?>">
                                                    <?php
                                                    /* Let's verify that this directory exists and let them know */
                                                    if (is_dir($web_root)) {
                                                        // Let's make sure that wasn't blank

                                                        if ('' != $web_root) {
                                                            echo ' <strong><font color=green>Verified!</font></strong>';
                                                        } else {
                                                            echo " <strong><font color=red>Sorry, I couldn't verify this...</font></strong>";
                                                        }
                                                    } else {
                                                        echo " <strong><font color=red>Sorry, I couldn't verify this...</font></strong>";
                                                    }
                                                    ?>
                                                    <br><br>
                                                    <?php echo $word_web_root_note; ?>
                                                </td>

                                            </tr>
                                            <tr class="jz_row2">
                                                <td width="30%" align="right" valign="top">
                                                    <strong><?php echo $word_jinzora_directory; ?></strong><br>
                                                    ($root_dir)
                                                </td>
                                                <td width="70%">
                                                    $web_root "+" <input type="text" name="root_dir" size="20" value="<?php echo $root_dir; ?>">
                                                    <?php
                                                    /* Let's verify that this directory exists and let them know */
                                                    if (is_dir($web_root . $root_dir)) {
                                                        if ('' != $root_dir) {
                                                            echo ' <strong><font color=green>Verified!</font></strong>';
                                                        } else {
                                                            echo " <strong><font color=red>Sorry, I couldn't verify this...</font></strong>";
                                                        }
                                                    } else {
                                                        echo " <strong><font color=red>Sorry, I couldn't verify this...</font></strong>";
                                                    }
                                                    ?>
                                                    <br><br>
                                                    <?php echo $word_jinzora_directory_note; ?>
                                                </td>

                                            </tr>
                                            <tr class="jz_row1">
                                                <td width="30%" align="right" valign="top">
                                                    <strong><?php echo $word_media_directory; ?></strong>
                                                    <br>
                                                    ($media_dir)
                                                </td>
                                                <td width="70%">
                                                    $web_root "+" $root_dir "+" <input type="text" name="media_dir" size="10" value="<?php echo $media_dir; ?>">
                                                    <?php
                                                    /* Let's verify that this directory exists and let them know */
                                                    if (is_dir($web_root . $root_dir . $media_dir)) {
                                                        if ('' != $media_dir) {
                                                            echo ' <strong><font color=green>Verified!</font></strong>';
                                                        } else {
                                                            echo " <strong><font color=red>Sorry, I couldn't verify this...</font></strong>";
                                                        }
                                                    } else {
                                                        echo " <strong><font color=red>Sorry, I couldn't verify this...</font></strong>";
                                                    }
                                                    ?>
                                                    <br><br>
                                                    <?php echo $word_media_directory_note; ?>
                                                </td>

                                            </tr>
                                            <tr class="jz_row2">
                                                <td width="30%" align="right" valign="top">
                                                    <strong><?php echo $word_media_directory_structure; ?></strong>
                                                </td>
                                                <td width="70%">
                                                    <select name="directory_level">
                                                        <?php
                                                        /* Now let's set for 1, 2, or 3 level directory structure */
                                                        switch ($directory_level) {
                                                            case '3': # 3 directories deep
                                                                echo '<option value="3">Genre/Artist/Album/Tracks</option>' . '<option value="2">Artist/Album/Tracks</option>' . '<option value="1">Album/Tracks</option>';
                                                                break;
                                                            case '2': # 2 directories deep
                                                                echo '<option value="2">Artist/Album/Tracks</option>' . '<option value="3">Genre/Artist/Album/Tracks</option>' . '<option value="1">Album/Tracks</option>';
                                                                break;
                                                            case '1': # 1 directories deep
                                                                echo '<option value="1">Album/Tracks</option>' . '<option value="2">Artist/Album/Tracks</option>' . '<option value="3">Genre/Artist/Album/Tracks</option>';
                                                                break;
                                                        }
                                                        ?>

                                                    </select>
                                                    <br><br>
                                                    <?php echo $word_media_directory_structure_note; ?>
                                                </td>

                                            </tr>
                                            <?php
                                            // Now let's hide this if they are NOT in CMS mode
                                            if ('expert' == $_POST['install_type'] or 'false' != $cms_mode) {
                                                ?>
                                                <tr class="jz_row1">
                                                    <td width="30%" align="right" valign="top">
                                                        <strong><?php echo $word_install_type; ?></strong>
                                                    </td>
                                                    <td width="70%">
                                                        <select name="cms_type">
                                                            <?php
                                                            if ('' != $cms_type) {
                                                                echo '<option value="' . $cms_type . '">' . $cms_type . '</option>';
                                                            }

                                                if ('mambo' == $cms_type) {
                                                    echo '<option selected value="mambo">Mambo</option>';
                                                }

                                                echo '<option value="standalone">Standalone</option>'
                                                                 . '<option value="postnuke">PostNuke</option>'
                                                                 . '<option value="phpnuke">PHPNuke</option>'
                                                                 . '<option value="nsnnuke">NSNNuke</option>'
                                                                 . '<option value="cpgnuke">CPGNuke</option>'
                                                                 . '<option value="mambo">Mambo</option>'; ?>
                                                        </select>
                                                        <br><br>
                                                        <?php echo $word_install_type_note; ?>
                                                        <br><br>
                                                    </td>

                                                </tr>
                                                <tr class="jz_row2">
                                                    <td width="30%" align="right" valign="top">
                                                        <strong><?php echo $word_cms_user_type; ?></strong>
                                                    </td>
                                                    <td width="70%">
                                                        <select name="cms_user_access">
                                                            <?php
                                                            echo '<option value="' . $cms_user_access . '">' . $cms_user_access . '</option>'; ?>
                                                            <option value="noaccess">No Access</option>
                                                            <option value="viewonly">Viewonly</option>
                                                            <option value="admin">Admin</option>
                                                            <option value="poweruser">Power User</option>
                                                            <option value="user">Standard User</option>
                                                        </select>
                                                        <br>
                                                        <?php echo $word_cms_user_type_note; ?>
                                                        <br><br>
                                                    </td>
                                                </tr>
                                                <?php
                                            } else {
                                                ?>
                                                <input type="hidden" value="user" name="cms_user_access">
                                                <input type="hidden" value="standalone" name="cms_type">
                                                <?php
                                            }
                                            ?>
                                            <tr class="jz_row1">
                                                <td width="30%" align="right" valign="top">
                                                    <strong><?php echo $word_default_user_access; ?></strong>
                                                </td>
                                                <td width="70%">
                                                    <select name="default_access">
                                                        <?php
                                                        echo '<option value="' . $default_access . '">' . $default_access . '</option>';
                                                        ?>
                                                        <option value="noaccess">No Access</option>
                                                        <option value="lofi">LoFi Only</option>
                                                        <option value="viewonly">Viewonly</option>
                                                        <option value="user">Standard User</option>
                                                        <option value="poweruser">Power User</option>
                                                        <option value="admin">Admin</option>
                                                    </select>
                                                    <br><br>
                                                    <?php echo $word_default_user_access_note; ?>
                                                </td>

                                            </tr>
                                        </table>
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
                                            <?php echo $word_display_settings; ?> >> &nbsp;&nbsp;&nbsp;
                                        </font>
                                        <br>
                                        <?php
                                        if ('expert' != $_SESSION['install_type']) {
                                            ?><input onClick="javascript:verifyPass();" type="button" name="step1" value="Next >">&nbsp;&nbsp;&nbsp;<?php
                                        } else {
                                            ?><input type="submit" name="step1" value="<?php echo $word_next; ?> >">&nbsp;&nbsp;&nbsp;<?php
                                        }
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
            </td>
        </tr>
    </table>
</form>
</body>

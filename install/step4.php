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

/* let's do some checking to see if their values made sense */
$ctr = 0;
$ctr2 = 0;
$dirName = $_POST['web_root'] . $_POST['root_dir'] . $_POST['media_dir'];
if (is_dir($dirName)) {
    $verify = 'yes';
} else {
    $verify = 'no';
}

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
$root_page = str_replace('&&', '&', str_replace('?&', '?', str_replace('install=step4', '', $root_page) . 'install=step5'));

// Let's see if they wanted a 1 click install and if so we'll auto submit the form
if (isset($_POST['1clickgo'])) {
    // Let's auto submit the form

    echo '<body onLoad="document.step2form.submit();">';

    echo '<input type="hidden" name="1clickgo" value="yes">';
}

// Now we need to figure out if they choose PHP Nuke or not
if ('standalone' != $_POST['cms_type']) {
    $cms_mode = 'true';

    $cms_type = $_POST['cms_type'];
} else {
    $cms_mode = 'false';

    $cms_type = '';
}

// Now now we need to see if they wanted to skip along...
if ('expert' != $_SESSION['install_type']) {
    $skip = 'true';
} else {
    $skip = 'false';
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

    if ('expert' != $_SESSION['install_type']) {
        echo '<body onload="document.installer.submit();">';
    }
}
?>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $img_path; ?>install/style.css">
<body>
<form action="<?php echo $root_page; ?>" method="post" name="installer">
    <input type="hidden" name="web_root" value="<?php echo str_replace('\\\\', '\\', $_POST['web_root']); ?>">
    <input type="hidden" name="root_dir" value="<?php echo $_POST['root_dir']; ?>">
    <input type="hidden" name="media_dir" value="<?php echo $_POST['media_dir']; ?>">
    <input type="hidden" name="default_access" value="<?php echo $_POST['default_access']; ?>">
    <input type="hidden" name="start_page" value="<?php echo $_POST['start_page']; ?>">
    <input type="hidden" name="directory_level" value="<?php echo $_POST['directory_level']; ?>">
    <input type="hidden" name="admin_user" value="<?php echo $_POST['admin_user']; ?>">
    <input type="hidden" name="admin_pass" value="<?php echo $_POST['admin_pass']; ?>">
    <input type="hidden" name="cms_user_access" value="<?php echo $_POST['cms_user_access']; ?>">
    <input type="hidden" name="cms_mode" value="<?php echo $cms_mode; ?>">
    <input type="hidden" name="cms_type" value="<?php echo $cms_type; ?>">
    <input type="hidden" name="auto_search_lyrics" value="<?php echo $_POST['auto_search_lyrics']; ?>">
    <?php require_once $img_path . 'install/postvars.php'; ?>

    <table width="800" cellpadding="5" cellspacing="0" border="0" align="center">
        <tr>
            <td width="100%">
                <table width="780" cellpadding="5" cellspacing="0" border="0" align="center">
                    <tr>
                        <td width="100%" background="<?php echo $img_path; ?>install/images/blueback.gif">
                            <table width="100%" cellpadding="5" cellspacing="0" border="0" align="center">
                                <tr>
                                    <td width="50%">
                                        &nbsp; &nbsp; <img src="<?php echo $img_path; ?>install/images/main-logo.gif">
                                    </td>
                                    <td width="50%" align="right" valign="middle">
                                        <font size="2" color="white">
                                            <strong><?php echo $this_pgm . ' ' . $version . ' Installer'; ?></strong>
                                            <br>
                                            Step 4/7&nbsp;
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
                                            <strong><?php echo $word_display_settings; ?></strong>
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
                <?php $row_c = 1; ?>
                <table width="780" cellpadding="5" cellspacing="0" border="0" align="center">
                    <tr>
                        <td width="100%" background="<?php echo $img_path; ?>install/images/bg_table.gif">
                            <table width="100%" cellpadding="5" cellspacing="0" border="0" align="center">
                                <tr>
                                    <td width="100%" align="center">
                                        <table width="100%" cellpadding="5" cellspacing="0" border="0">
                                            <tr class="jz_row<?php if (1 == $row_c) {
    $row_c = 2;
} else {
    $row_c = 1;
}
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_primary_language; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="lang_file">
                                                        <?php
                                                        /* Let's get all the possible languages and display them */
                                                        $lang_dir = $_POST['web_root'] . $_POST['root_dir'] . '/lang';
                                                        $d = dir($lang_dir);
                                                        while ($entry = $d->read()) {
                                                            /* Let's make sure this isn't the local directory we're looking at */

                                                            if ('.' == $entry || '..' == $entry) {
                                                                continue;
                                                            }

                                                            if (str_replace('.php', '', $entry) == $lang_file) {
                                                                echo '<option selected value="' . str_replace('.php', '', $entry) . '">' . str_replace('.php', '', $entry) . '</option>';
                                                            } else {
                                                                echo '<option value="' . str_replace('.php', '', $entry) . '">' . str_replace('.php', '', $entry) . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_primary_language_note; ?>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_allow_language_change; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="allow_lang_choice">
                                                        <option value="false">Cannot change</option>
                                                        <option value="true">Can Change</option>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_allow_language_change_note; ?>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                $row_c = 2;
                                            } else {
                                                $row_c = 1;
                                            }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_theme; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="jinzora_skin">
                                                        <?php
                                                        /* Ok, now let's get the list of themes from the file system */
                                                        $theme_dir = $_POST['web_root'] . $_POST['root_dir'] . '/style';
                                                        // First let's set this to Postnuke if they are in that mode
                                                        if ('true' == $cms_mode) {
                                                            echo '<option selected value="cms-theme">cms-theme</option>';
                                                        }
                                                        $d = dir($theme_dir);
                                                        while ($entry = $d->read()) {
                                                            /* Let's make sure this isn't the local directory we're looking at */

                                                            if ('.' == $entry || '..' == $entry || 'favicon.ico' == $entry || 'images' == $entry) {
                                                                continue;
                                                            }

                                                            if ($entry == $jinzora_skin and 'false' == $cms_mode) {
                                                                echo '<option selected value="' . $entry . '">' . $entry . '</option>';
                                                            } else {
                                                                echo '<option value="' . $entry . '">' . $entry . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_theme_note1; ?>
                                                    <?php
                                                    $sample_dir = $_POST['web_root'] . $_POST['root_dir'] . '/install/images';
                                                    $data = '';
                                                    $d = dir($sample_dir);
                                                    while ($entry = $d->read()) {
                                                        /* Let's make sure this isn't the local directory we're looking at */

                                                        if ('.' == $entry || '..' == $entry || !mb_stristr($entry, 'theme')) {
                                                            continue;
                                                        }

                                                        $data .= '<a target="_blank" href="' . $_POST['root_dir'] . '/install/images/' . $entry . '">' . str_replace('theme-', '', str_replace('.gif', '', $entry)) . '</a> &nbsp;|&nbsp; ';
                                                    }

                                                    echo '<br>' . mb_substr($data, 0, -8);
                                                    ?>
                                                    <?php echo $word_theme_note2; ?>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                        $row_c = 2;
                                                    } else {
                                                        $row_c = 1;
                                                    }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_allow_theme_change; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="allow_theme_change">
                                                        <?php
                                                        if ('true' == $allow_theme_change) {
                                                            echo '<option value="true">Allow Change</option>' . '<option value="false">Dont Allow Change</option>';
                                                        } else {
                                                            echo '<option value="false">Dont Allow Change</option>' . '<option value="true">Allow Change</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_allow_theme_change_note; ?>
                                                    <br><br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_hide_when_found; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="hide_tracks">
                                                        <?php
                                                        if ('true' == $hide_tracks) {
                                                            echo '<option value="true">Hide Tracks</option>' . '<option value="false">Dont Hide Tracks</option>';
                                                        } else {
                                                            echo '<option value="false">Dont Hide Tracks</option>' . '<option value="true">Hide Tracks</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_hide_when_found_note; ?>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_help_icon; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="help_access">
                                                        <?php
                                                        if ('admin' == $help_access) {
                                                            echo '<option value="admin">Admins Only</option>' . '<option value="all">All Users</option>';
                                                        } else {
                                                            echo '<option value="all">All Users</option>' . '<option value="admin">Admins Only</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_help_icon_note; ?>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_disable_random; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="disable_random">
                                                        <?php
                                                        if ('true' == $disable_random) {
                                                            echo '<option value="true">Disable Random</option>' . '<option value="false">Enable Random</option>';
                                                        } else {
                                                            echo '<option value="false">Enable Random</option>' . '<option value="true">Disable Random</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_disable_random_note; ?>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_track_plays_only; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="track_play_only">
                                                        <?php
                                                        if ('true' == $track_play_only) {
                                                            echo '<option value="true">' . $word_true . '</option>' . '<option value="false">' . $word_false . '</option>';
                                                        } else {
                                                            echo '<option value="false">' . $word_false . '</option>' . '<option value="true">' . $word_true . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_track_plays_only_note; ?>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_info_icons; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="info_level">
                                                        <?php
                                                        if ('all' == $info_level) {
                                                            echo '<option value="all">All Users</option>' . '<option value="admin">Admins Only</option>';
                                                        } else {
                                                            echo '<option value="admin">Admins Only</option>' . '<option value="all">All Users</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_info_icons_note; ?>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_auto_search_lyrics; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="auto_search_lyrics">
                                                        <?php
                                                        if ('true' == $auto_search_lyrics) {
                                                            echo '<option value="true">Auto Search</option>' . '<option value="false">Dont Auto Search</option>';
                                                        } else {
                                                            echo '<option value="false">Dont Auto Search</option>' . '<option value="true">Auto Search</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_auto_search_lyrics_note; ?>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_header_drops_drop; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="header_drops">
                                                        <?php
                                                        if ('true' == $header_drops) {
                                                            echo '<option value="true">' . $word_true . '</option>' . '<option value="false">' . $false . '</option>';
                                                        } else {
                                                            echo '<option value="false">' . $false . '</option>' . '<option value="true">' . $word_true . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_header_drops_drop_note; ?>
                                                    <br><br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_display_genre_drop; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="genre_drop">
                                                        <?php
                                                        if ('true' == $genre_drop) {
                                                            echo '<option value="true">Show Genre Drop Down</option>' . '<option value="false">Hide Genre Drop Down</option>';
                                                        } else {
                                                            echo '<option value="false">Hide Genre Drop Down</option>' . '<option value="true">Show Genre Drop Down</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_display_genre_drop_note; ?>
                                                    <br><br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_display_artist_drop; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="artist_drop">
                                                        <?php
                                                        if ('true' == $artist_drop) {
                                                            echo '<option value="true">Show Artist Drop Down</option>' . '<option value="false">Hide Artist Drop Down</option>';
                                                        } else {
                                                            echo '<option value="false">Hide Artist Drop Down</option>' . '<option value="true">Show Artist Drop Down</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_display_artist_drop_note; ?>
                                                    <br><br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_display_album_drop; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="album_drop">
                                                        <?php
                                                        if ('true' == $album_drop) {
                                                            echo '<option value="true">Show Album Drop Down</option>' . '<option value="false">Hide Album Drop Down</option>';
                                                        } else {
                                                            echo '<option value="false">Hide Album Drop Down</option>' . '<option value="true">Show Album Drop Down</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_display_album_drop_note; ?>
                                                    <br><br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_display_track_drop; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="song_drop">
                                                        <?php
                                                        if ('true' == $song_drop) {
                                                            echo '<option value="true">Show Track Drop Down</option>' . '<option value="false">Hide Track Drop Down</option>';
                                                        } else {
                                                            echo '<option value="false">Hide Track Drop Down</option>' . '<option value="true">Show Track Drop Down</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_display_track_drop_note; ?>
                                                    <br><br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_display_quick_drop; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="quick_drop">
                                                        <?php
                                                        if ('true' == $quick_drop) {
                                                            echo '<option value="true">Show Quick Playlist Creator</option>' . '<option value="false">Hide Quick Playlist Creator</option>';
                                                        } else {
                                                            echo '<option value="false">Hide Quick Playlist Creator</option>' . '<option value="true">Show Quick Playlist Creator</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_display_quick_drop_note; ?>
                                                    <br><br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_enable_playlist; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="enable_playlist">
                                                        <?php
                                                        if ('true' == $enable_playlist) {
                                                            echo '<option value="true">' . $word_true . '</option>' . '<option value="false">' . $word_false . '</option>';
                                                        } else {
                                                            echo '<option value="false">' . $word_false . '</option>' . '<option value="true">' . $word_true . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_enable_playlist_note; ?>
                                                    <br><br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_display_time; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="display_time">
                                                        <?php
                                                        if ('true' == $display_time) {
                                                            echo '<option value="true">Display Track Time</option>' . '<option value="false">Hide Track Time</option>';
                                                        } else {
                                                            echo '<option value="false">Hide Track Time</option>' . '<option value="true">Display Track Time</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_display_time_note; ?><br><br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_display_rate; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="display_rate">
                                                        <?php
                                                        if ('true' == $display_rate) {
                                                            echo '<option value="true">Display Track Rate</option>' . '<option value="false">Hide Track Rate</option>';
                                                        } else {
                                                            echo '<option value="false">Hide Track Rate</option>' . '<option value="true">Display Track Rate</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_display_rate_note; ?><br><br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_display_feq; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="display_feq">
                                                        <?php
                                                        if ('true' == $display_feq) {
                                                            echo '<option value="true">Display Track Frequency</option>' . '<option value="false">Hide Track Frequency</option>';
                                                        } else {
                                                            echo '<option value="false">Hide Track Frequency</option>' . '<option value="true">Display Track Frequency</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_display_feq_note; ?><br><br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_display_size; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="display_size">
                                                        <?php
                                                        if ('true' == $display_size) {
                                                            echo '<option value="true">Display Track Size</option>' . '<option value="false">Hide Track Size</option>';
                                                        } else {
                                                            echo '<option value="false">Hide Track Size</option>' . '<option value="true">Display Track Size</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_display_size_note; ?><br><br>
                                                </td>
                                            </tr>

                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_display_downloads; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="display_downloads">
                                                        <?php
                                                        if ('true' == $display_downloads) {
                                                            echo '<option value="true">' . $word_true . '</option>' . '<option value="false">' . $word_false . '</option>';
                                                        } else {
                                                            echo '<option value="false">' . $word_false . '</option>' . '<option value="true">' . $word_true . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_display_downloads_note; ?><br><br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_display_track_num; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="display_track_num">
                                                        <?php
                                                        if ('true' == $display_track_num) {
                                                            echo '<option value="true">' . $word_true . '</option>' . '<option value="false">' . $word_false . '</option>';
                                                        } else {
                                                            echo '<option value="false">' . $word_false . '</option>' . '<option value="true">' . $word_true . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_display_track_num_note; ?><br><br>
                                                </td>
                                            </tr>


                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_num_other_albums; ?>
                                                </td>
                                                <td width="70%">
                                                    <input type="text" name="num_other_albums" value="<?php echo $num_other_albums; ?>" size="5">
                                                    <br>
                                                    <?php echo $word_num_other_albums_note; ?>
                                                    <br><br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                $row_c = 2;
                                            } else {
                                                $row_c = 1;
                                            }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_show_sub_totals; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="show_sub_numbers">
                                                        <?php
                                                        if ('true' == $show_sub_numbers) {
                                                            echo '<option value="true">Show Totals</option>' . '<option value="false">Hide Totals</option>';
                                                        } else {
                                                            echo '<option value="false">Hide Totals</option>' . '<option value="true">Show Totals</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_show_sub_totals_note; ?>
                                                    <br><br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_show_amg_search; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="amg_search">
                                                        <?php
                                                        if ('true' == $amg_search) {
                                                            echo '<option value="true">Show Search</option>' . '<option value="false">Hide Search</option>';
                                                        } else {
                                                            echo '<option value="false">Hide Search</option>' . '<option value="true">Show Search</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_show_amg_search_note; ?>
                                                    <br><br>
                                                </td>
                                            </tr>

                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_search_echocloud; ?>
                                                </td>
                                                <td width="70%">
                                                    <input type="text" size="5" name="echocloud" value="<?php echo $echocloud; ?>">
                                                    <br>
                                                    <?php echo $word_search_echocloud_note; ?>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                $row_c = 2;
                                            } else {
                                                $row_c = 1;
                                            }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_show_search_art; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="search_album_art">
                                                        <?php
                                                        if ('true' == $search_album_art) {
                                                            echo '<option value="true">Show Search</option>' . '<option value="false">Hide Search</option>';
                                                        } else {
                                                            echo '<option value="false">Hide Search</option>' . '<option value="true">Show Search</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_show_search_art_note; ?>
                                                    <br><br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_show_all_checkboxes; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="show_all_checkboxes">
                                                        <?php
                                                        if ('true' == $show_all_checkboxes) {
                                                            echo '<option value="true">Show All Checkboxes</option>' . '<option value="false">Hide All Checkboxes</option>';
                                                        } else {
                                                            echo '<option value="false">Hide All Checkboxes</option>' . '<option value="true">Show All Checkboxes</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_show_all_checkboxes_note; ?>
                                                    <br><br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_album_art_dim; ?>
                                                </td>
                                                <td width="70%">
                                                    <input type="text" name="album_img_width" value="<?php echo $album_img_width; ?>" size="2"> x
                                                    <input type="text" name="album_img_height" value="<?php echo $album_img_height; ?>" size="2">
                                                    <br>
                                                    <?php echo $word_album_art_dim_note; ?>
                                                    <br><br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                $row_c = 2;
                                            } else {
                                                $row_c = 1;
                                            }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_force_dimensions; ?>
                                                </td>
                                                <td width="70%">
                                                    <input type="text" name="album_force_width" value="<?php echo $album_force_width; ?>" size="2"> x
                                                    <input type="text" name="album_force_height" value="<?php echo $album_force_height; ?>" size="2">
                                                    <br>
                                                    <?php echo $word_force_dimensions_note; ?>
                                                    <br><br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                $row_c = 2;
                                            } else {
                                                $row_c = 1;
                                            }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_artist_dimensions; ?>
                                                </td>
                                                <td width="70%">
                                                    <input type="text" name="artist_img_height" value="<?php echo $artist_img_height; ?>" size="2"> x
                                                    <input type="text" name="artist_img_width" value="<?php echo $artist_img_width; ?>" size="2">
                                                    <br>
                                                    <?php echo $word_artist_dimensions_note; ?>
                                                    <br><br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                $row_c = 2;
                                            } else {
                                                $row_c = 1;
                                            }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_keep_porpotions; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="keep_porportions">
                                                        <?php
                                                        if ('true' == $keep_porportions) {
                                                            echo '<option value="true">' . $word_true . '</option>' . '<option value="false">' . $word_false . '</option>';
                                                        } else {
                                                            echo '<option value="false">' . $word_false . '</option>' . '<option value="true">' . $word_true . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_keep_porpotions_note; ?>
                                                    <br>
                                                    <br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_show_random_artist_art; ?>
                                                </td>
                                                <td width="70%">
                                                    <input type="text" name="num_rand_albums" value="<?php echo $num_rand_albums; ?>" size="2">
                                                    <br>
                                                    <?php echo $word_show_random_artist_art_note; ?>
                                                    <br>
                                                    <br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                $row_c = 2;
                                            } else {
                                                $row_c = 1;
                                            }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_sort_by_year; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="sort_by_year">
                                                        <?php
                                                        if ('true' == $sort_by_year) {
                                                            echo '<option value="true">Show by Year</option>' . '<option value="false">Hide by Year</option>';
                                                        } else {
                                                            echo '<option value="false">Hide by Year</option>' . '<option value="true">Show by Year</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_sort_by_year_note; ?>
                                                    <br><br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_pull_media_info; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="get_mp3_info">
                                                        <?php
                                                        if ('true' == $get_mp3_info) {
                                                            echo '<option value="true">Enabled</option>' . '<option value="false">Disabled</option>';
                                                        } else {
                                                            echo '<option value="false">Disabled</option>' . '<option value="true">Enabled</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_pull_media_info_note; ?>
                                                    <br><br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_hide_id3_comments; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="hide_id3_comments">
                                                        <?php
                                                        if ('true' == $hide_id3_comments) {
                                                            echo '<option value="true">Hide Comments</option>' . '<option value="false">Show Comments</option>';
                                                        } else {
                                                            echo '<option value="false">Show Comments</option>' . '<option value="true">Hide Comments</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_hide_id3_comments_note; ?>
                                                    <br><br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_show_loggedin_level; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="show_loggedin_level">
                                                        <?php
                                                        if ('true' == $show_loggedin_level) {
                                                            echo '<option value="true">' . $word_true . '</option>' . '<option value="false">' . $word_false . '</option>';
                                                        } else {
                                                            echo '<option value="false">' . $word_false . '</option>' . '<option value="true">' . $word_true . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_show_loggedin_level_note; ?>
                                                    <br><br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                            $row_c = 2;
                                                        } else {
                                                            $row_c = 1;
                                                        }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_num_columns; ?>
                                                </td>
                                                <td width="70%">
                                                    <select name="cols_in_genre">
                                                        <option value="3">3 Columns</option>
                                                        <option value="1">1 Columns</option>
                                                        <option value="2">2 Columns</option>
                                                        <option value="4">4 Columns</option>
                                                    </select>
                                                    <br>
                                                    <?php echo $word_num_columns_note; ?>
                                                    <br><br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                $row_c = 2;
                                            } else {
                                                $row_c = 1;
                                            }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_artist_length; ?>
                                                </td>
                                                <td width="70%">
                                                    <input type="text" name="artist_truncate" size="2" value="<?php echo $artist_truncate; ?>">
                                                    <br>
                                                    <?php echo $word_artist_length_note; ?>
                                                    <br><br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                $row_c = 2;
                                            } else {
                                                $row_c = 1;
                                            }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_quick_length; ?>
                                                </td>
                                                <td width="70%">
                                                    <input type="text" name="quick_list_truncate" size="2" value="<?php echo $quick_list_truncate; ?>">
                                                    <br>
                                                    <?php echo $word_quick_length_note; ?>
                                                    <br><br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                $row_c = 2;
                                            } else {
                                                $row_c = 1;
                                            }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_album_length; ?>
                                                </td>
                                                <td width="70%">
                                                    <input type="text" name="album_name_truncate" size="2" value="<?php echo $album_name_truncate; ?>">
                                                    <br>
                                                    <?php echo $word_album_length_note; ?>
                                                    <br><br>
                                                </td>
                                            </tr>
                                            <tr class="jz_row<?php if (1 == $row_c) {
                                                $row_c = 2;
                                            } else {
                                                $row_c = 1;
                                            }
                                            echo $row_c; ?>">
                                                <td width="30%" align="right" valign="top">
                                                    <?php echo $word_main_table_width; ?>
                                                </td>
                                                <td width="70%">
                                                    <input type="text" name="main_table_width" size="2" value="<?php echo $main_table_width; ?>">
                                                    <br>
                                                    <?php echo $word_main_table_width_note; ?><br><br>
                                                </td>
                                            </tr>
                                            <input type="hidden" value="false" name="show_tools_link">
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
                                        <font size="1">
                                            <?php echo $word_optional_settings; ?> >> &nbsp;&nbsp;&nbsp;
                                        </font>
                                        <br>
                                        <input type="submit" name="step1" value="<?php echo $word_next; ?> >">&nbsp;&nbsp;&nbsp;
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

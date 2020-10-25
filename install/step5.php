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
$href_path2 = str_replace('&install=step5', '', $_SERVER['REQUEST_URI']);

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
$root_page = str_replace('&&', '&', str_replace('?&', '?', str_replace('install=step5', '', $root_page) . 'install=step6'));

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
    <?php require_once $img_path . 'install/postvars.php'; ?>

    <?php $row_c = 1; ?>
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
                                            Step 5/7&nbsp;
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
                                            <strong><?php echo $word_optional_settings; ?></strong>
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
                                <tr class="jz_row<?php if (1 == $row_c) {
    $row_c = 2;
} else {
    $row_c = 1;
}
                                echo $row_c; ?>">
                                    <td width="30%" align="right" valign="top">
                                        <?php echo $word_use_advanced_caching; ?>
                                    </td>
                                    <td width="70%">
                                        <select name="use_cache_file">
                                            <?php
                                            if ('false' == $use_cache_file) {
                                                echo '<option value="true">Advanced Caching</option>' . '<option value="false">Standard Caching</option>';
                                            } else {
                                                echo '<option value="false">Standard Caching</option>' . '<option value="true">Advanced Caching</option>';
                                            }
                                            ?>
                                        </select>
                                        <br>
                                        <?php echo $word_use_advanced_caching_note; ?>
                                    </td>
                                </tr>
                                <tr class="jz_row<?php if (1 == $row_c) {
                                                $row_c = 2;
                                            } else {
                                                $row_c = 1;
                                            }
                                echo $row_c; ?>">
                                    <td width="30%" align="right" valign="top">
                                        <?php echo $word_javascript; ?>
                                    </td>
                                    <td width="70%">
                                        <select name="javascript">
                                            <option value="yes">Enabled</option>
                                            <option value="no">Disabled</option>
                                        </select>
                                        <br>
                                        <?php echo $word_javascript_note; ?>
                                    </td>
                                </tr>

                                <tr class="jz_row<?php if (1 == $row_c) {
                                    $row_c = 2;
                                } else {
                                    $row_c = 1;
                                }
                                echo $row_c; ?>">
                                    <td width="30%" align="right" valign="top">
                                        <?php echo $word_date_format; ?>
                                    </td>
                                    <td width="70%">
                                        <input type="text" name="date_format" size="10" value="<?php echo $date_format; ?>">
                                        <br>
                                        <?php echo $word_date_format_note; ?>
                                    </td>
                                </tr>

                                <tr class="jz_row<?php if (1 == $row_c) {
                                    $row_c = 2;
                                } else {
                                    $row_c = 1;
                                }
                                echo $row_c; ?>">
                                    <td width="30%" align="right" valign="top">
                                        <?php echo $word_disable_all_downloads; ?>
                                    </td>
                                    <td width="70%">
                                        <select name="allow_download">
                                            <option value="true">Enable Downloads</option>
                                            <option value="false">Disable Downloads</option>
                                        </select>
                                        <br>
                                        <?php echo $word_disable_all_downloads_note; ?>
                                    </td>
                                </tr>
                                <tr class="jz_row<?php if (1 == $row_c) {
                                    $row_c = 2;
                                } else {
                                    $row_c = 1;
                                }
                                echo $row_c; ?>">
                                    <td width="30%" align="right" valign="top">
                                        <?php echo $word_download_type; ?>
                                    </td>
                                    <td width="70%">
                                        <select name="multiple_download_mode">
                                            <option value="zip">ZIP</option>
                                            <option value="tar">TAR</option>
                                        </select>
                                        <br>
                                        <?php echo $word_download_type_note; ?>
                                    </td>
                                </tr>
                                <tr class="jz_row<?php if (1 == $row_c) {
                                    $row_c = 2;
                                } else {
                                    $row_c = 1;
                                }
                                echo $row_c; ?>">
                                    <td width="30%" align="right" valign="top">
                                        <?php echo $word_single_download_type; ?>
                                    </td>
                                    <td width="70%">
                                        <select name="single_download_mode">
                                            <option value="zip">ZIP</option>
                                            <option value="tar">TAR</option>
                                            <option value="raw">RAW</option>
                                        </select>
                                        <br>
                                        <?php echo $word_disable_all_downloads_note; ?>
                                    </td>
                                </tr>
                                <tr class="jz_row<?php if (1 == $row_c) {
                                    $row_c = 2;
                                } else {
                                    $row_c = 1;
                                }
                                echo $row_c; ?>">
                                    <td width="30%" align="right" valign="top">
                                        <?php echo $word_download_speed; ?>
                                    </td>
                                    <td width="70%">
                                        <input type="text" size="5" name="download_speed" value="<?php echo $download_speed; ?>"> Kbps
                                        <br>
                                        <?php echo $word_download_speed_note; ?>
                                    </td>
                                </tr>
                                <tr class="jz_row<?php if (1 == $row_c) {
                                    $row_c = 2;
                                } else {
                                    $row_c = 1;
                                }
                                echo $row_c; ?>">
                                    <td width="30%" align="right" valign="top">
                                        <?php echo $word_auto_search_art; ?>
                                    </td>
                                    <td width="70%">
                                        <select name="auto_search_art">
                                            <?php
                                            if ('true' == $auto_search_art) {
                                                echo '<option value="true">Auto Search</option>' . '<option value="false">Dont Auto Search</option>';
                                            } else {
                                                echo '<option value="false">Dont Auto Search</option>' . '<option value="true">Auto Search</option>';
                                            }
                                            ?>
                                        </select>
                                        <br>
                                        <?php echo $word_auto_search_art_note; ?>
                                    </td>
                                </tr>
                                <tr class="jz_row<?php if (1 == $row_c) {
                                                $row_c = 2;
                                            } else {
                                                $row_c = 1;
                                            }
                                echo $row_c; ?>">
                                    <td width="30%" align="right" valign="top">
                                        <?php echo $word_rating_system; ?>
                                    </td>
                                    <td width="70%">
                                        <select name="enable_ratings">
                                            <?php
                                            if ('true' == $enable_ratings) {
                                                echo '<option value="true">Enable Ratings</option>' . '<option value="false">Disable Ratings</option>';
                                            } else {
                                                echo '<option value="false">Disable Ratings</option>' . '<option value="true">Enable Ratings</option>';
                                            }
                                            ?>
                                        </select>
                                        <br>
                                        <?php echo $word_rating_system_note; ?>
                                        <?php echo $word_top_ratings; ?> <input value="<?php echo $num_top_ratings; ?>" type="text" name="num_top_ratings" size="4">
                                        <br>
                                        <?php echo $word_top_ratings_note; ?>
                                    </td>
                                </tr>
                                <tr class="jz_row<?php if (1 == $row_c) {
                                                $row_c = 2;
                                            } else {
                                                $row_c = 1;
                                            }
                                echo $row_c; ?>">
                                    <td width="30%" align="right" valign="top">
                                        <?php echo $word_suggestions; ?>
                                    </td>
                                    <td width="70%">
                                        <select name="enable_suggestions">
                                            <?php
                                            if ('true' == $enable_suggestions) {
                                                echo '<option value="true">Enable Suggestions</option>' . '<option value="false">Disable Suggestions</option>';
                                            } else {
                                                echo '<option value="false">Disable Suggestions</option>' . '<option value="true">Enable Suggestions</option>';
                                            }
                                            ?>
                                        </select>
                                        <br>
                                        <?php echo $word_suggestions_note; ?>
                                        <br><br>
                                        <?php echo $word_num_suggestions; ?> <input type="text" value="<?php echo $num_suggestions; ?>" name="num_suggestions" size="4">
                                        <br>
                                        <?php echo $word_num_suggestions_note; ?>
                                    </td>
                                </tr>
                                <tr class="jz_row<?php if (1 == $row_c) {
                                                $row_c = 2;
                                            } else {
                                                $row_c = 1;
                                            }
                                echo $row_c; ?>">
                                    <td width="30%" align="right" valign="top">
                                        <?php echo $word_enable_hits; ?>
                                    </td>
                                    <td width="70%">
                                        <select name="track_plays">
                                            <?php
                                            if ('true' == $track_plays) {
                                                echo '<option value="true">Enable Track Counting</option>' . '<option value="false">Disable Track Counting</option>';
                                            } else {
                                                echo '<option value="false">Disable Track Counting</option>' . '<option value="true">Enable Track Counting</option>';
                                            }
                                            ?>
                                        </select>
                                        <br>
                                        <?php echo $word_enable_hits_note; ?>
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
                                        <?php echo $word_enable_discussion; ?>
                                    </td>
                                    <td width="70%">
                                        <select name="enable_discussion">
                                            <?php
                                            if ('true' == $enable_discussion) {
                                                echo '<option value="true">Enable Discussions</option>' . '<option value="false">Disable Discussions</option>';
                                            } else {
                                                echo '<option value="false">Disable Discussions</option>' . '<option value="true">Enable Discussions</option>';
                                            }
                                            ?>
                                        </select>
                                        <br>
                                        <?php echo $word_enable_discussion_note; ?>
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
                                        <?php echo $word_most_played; ?>
                                    </td>
                                    <td width="70%">
                                        <select name="enable_most_played">
                                            <?php
                                            if ('true' == $enable_most_played) {
                                                echo '<option value="true">Enable Most Played</option>' . '<option value="false">Disable Most Played</option>';
                                            } else {
                                                echo '<option value="false">Disable Most Played</option>' . '<option value="true">Enable Most Played</option>';
                                            }
                                            ?>
                                        </select>
                                        <br>
                                        <?php echo $word_most_played_note; ?>
                                        <br><br>
                                        <?php echo $word_num_most_played; ?> <input type="text" value="<?php echo $num_most_played; ?>" name="num_most_played" size="4">
                                        <br>
                                        <?php echo $word_num_most_played_note; ?>
                                    </td>
                                </tr>
                                <tr class="jz_row<?php if (1 == $row_c) {
                                                $row_c = 2;
                                            } else {
                                                $row_c = 1;
                                            }
                                echo $row_c; ?>">
                                    <td width="30%" align="right" valign="top">
                                        <?php echo $word_new_range; ?>
                                    </td>
                                    <td width="70%">
                                        <input type="text" name="days_for_new" value="<?php echo $days_for_new; ?>" size="4">
                                        <br>
                                        <?php echo $word_new_range_note; ?>
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
                                        <?php echo $word_playlist_ext; ?>
                                    </td>
                                    <td width="70%">
                                        <input type="text" name="playlist_ext" size="5" value="<?php echo $playlist_ext; ?>">
                                        <br>
                                        <?php echo $word_playlist_ext_note; ?>
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
                                        <?php echo $word_temp_dir; ?>
                                    </td>
                                    <td width="70%">
                                        <?php echo $_POST['web_root']; ?> "+" <?php echo $_POST['root_dir']; ?> "+" <input type="text" name="jinzora_temp_dir" size="10" value="<?php echo $jinzora_temp_dir; ?>">
                                        <br>
                                        <?php echo $word_temp_dir_note; ?>
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
                                        <?php echo $word_playran_amounts; ?>
                                    </td>
                                    <td width="70%">
                                        <input type="text" name="random_play_amounts" size="30" value="<?php echo $random_play_amounts; ?>">
                                        <br>
                                        <?php echo $word_playran_amounts_note; ?>
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
                                        <?php echo $word_audio_types; ?>
                                    </td>
                                    <td width="70%">
                                        <input type="text" name="audio_types" size="30" value="<?php echo $audio_types; ?>">
                                        <br>
                                        <?php echo $word_audio_types_note; ?>
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
                                        <?php echo $word_video_types; ?>
                                    </td>
                                    <td width="70%">
                                        <input type="text" name="video_types" size="30" value="<?php echo $video_types; ?>">
                                        <br>
                                        <?php echo $word_video_types_note; ?>
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
                                        <?php echo $word_img_types; ?>
                                    </td>
                                    <td width="70%">
                                        <input type="text" name="ext_graphic" size="30" value="<?php echo $ext_graphic; ?>">
                                        <br>
                                        <?php echo $word_img_types_note; ?>
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
                                        <?php echo $word_track_sep; ?>
                                    </td>
                                    <td width="70%">
                                        <input type="text" name="track_num_seperator" size="5" value="<?php echo $track_num_seperator; ?>">
                                        <br>
                                        <?php echo $word_track_sep_note; ?>
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
                                        <?php echo $word_auth; ?>
                                    </td>
                                    <td width="70%">
                                        User:Pass <input type="text" name="auth_value" size="30" value="<?php echo $auth_value; ?>"><br>
                                        <?php echo $word_auth_note; ?>
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
                                        <?php echo $word_embedding; ?>
                                    </td>
                                    <td width="70%">
                                        <?php echo $word_header; ?> <input type="text" name="embedded_header" size="30" value="<?php echo $embedded_header; ?>"><br>
                                        <?php echo $word_footer; ?> <input type="text" name="embedded_footer" size="30" value="<?php echo $embedded_footer; ?>"><br>
                                        <?php echo $word_embedding; ?>

                                        <br><br>
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
                                            <?php echo $word_ipod_shoutcast; ?> >> &nbsp;&nbsp;&nbsp;
                                        </font>
                                        <br>
                                        <?php
                                        if ('yes' != $error) {
                                            echo '<input type="submit" name="step1" value="' . $word_next . ' >">&nbsp;&nbsp;&nbsp;';
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

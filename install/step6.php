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
$href_path2 = str_replace('&install=step5', '', @$_SERVER['REQUEST_URI']);

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
$root_page = str_replace('&&', '&', str_replace('?&', '?', str_replace('install=step6', '', $root_page) . 'install=step7'));

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
                                            Step 6/7&nbsp;
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
                                            <strong><?php echo $word_ipod_shoutcast; ?></strong>
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
                                        <?php echo $word_jukebox_type; ?>:
                                    </td>
                                    <td width="70%">
                                        <select name="jukebox">
                                            <?php
                                            if ('xmms' == $jukebox) {
                                                echo '<option value="xmms">XMMS</option>' . '<option value="winamp">Winamp</option>' . '<option value="false">No Jukebox</option>';
                                            } else {
                                                if ('winamp' == $jukebox) {
                                                    echo '<option value="winamp">Winamp</option>' . '<option value="xmms">XMMS</option>' . '<option value="false">No Jukebox</option>';
                                                } else {
                                                    echo '<option value="false">No Jukebox</option>' . '<option value="xmms">XMMS</option>' . '<option value="winamp">Winamp</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                        <br>
                                        <?php echo $word_jukebox_type_note; ?>
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
                                        <?php echo $word_jukebox_settings; ?>:
                                    </td>
                                    <td width="70%">
                                        <?php echo $word_jukebox_settings_note; ?>
                                        <br><br>
                                        <?php echo $word_path_to_xmms_shell; ?><br>
                                        <input type="text" name="path_to_xmms_shell" size="40" value="<?php echo $path_to_xmms_shell; ?>">
                                        <br><br>
                                        <?php echo $word_auto_refresh; ?><br>
                                        <input type="text" name="auto_refresh" size="40" value="<?php echo $auto_refresh; ?>">
                                        <br><br>
                                        <?php echo $word_num_upcoming; ?><br>
                                        <input type="text" name="num_upcoming" size="40" value="<?php echo $num_upcoming; ?>">
                                        <br><br>

                                        <?php echo $word_juekbox_pass; ?><br>
                                        <input type="text" name="jukebox_pass" size="40" value="<?php echo $jukebox_pass; ?>">
                                        <br><br>
                                        <?php echo $word_jukebox_port; ?><br>
                                        <input type="text" name="jukebox_port" size="40" value="<?php echo $jukebox_port; ?>">
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
                                        <?php echo $word_max_rss_feed_items; ?>
                                    </td>
                                    <td width="70%">
                                        <input type="text" name="rss_news_max" size="2" value="<?php echo $rss_news_max; ?>">
                                        <br>
                                        <?php echo $word_max_rss_feed_items_note; ?>
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
                                        <?php echo $word_ephpod_file; ?>
                                    </td>
                                    <td width="70%">
                                        <input type="text" name="ephPod_file_name" size="40" value="<?php echo $ephPod_file_name; ?>">
                                        <br>
                                        <?php echo $word_ephpod_file_note; ?>
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
                                        <?php echo $word_ephpod_dirve; ?>
                                    </td>
                                    <td width="70%">
                                        <input type="text" name="ephPod_drive_letter" size="2" value="<?php echo $ephPod_drive_letter; ?>">
                                        <br>
                                        <?php echo $word_ephpod_dirve_note; ?>
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
                                        <?php echo $word_ipod_size; ?>
                                    </td>
                                    <td width="70%">
                                        <input type="text" name="ipod_size" size="8" value="<?php echo $ipod_size; ?>">
                                        <br>
                                        <?php echo $word_ipod_size_note; ?>
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
                                        <?php echo $word_shoutcasting; ?>
                                    </td>
                                    <td width="70%">
                                        <select name="shoutcast">
                                            <?php
                                            if ('true' == $shoutcast) {
                                                echo '<option value="true">Enable Shoutcast</option>' . '<option value="false">Disable Shoutcast</option>';
                                            } else {
                                                echo '<option value="false">Disable Shoutcast</option>' . '<option value="true">Enable Shoutcast</option>';
                                            }
                                            ?>
                                        </select>
                                        <?php echo $word_shoutcasting_note; ?>

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
                                        <?php echo $word_shoutcasting_ip; ?>
                                    </td>
                                    <td width="70%">
                                        <input type="text" name="sc_host" size="8" value="<?php echo $sc_host; ?>">
                                        <br>
                                        <?php echo $word_shoutcasting_ip_note; ?>
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
                                        <?php echo $word_shoutcasting_port; ?>
                                    </td>
                                    <td width="70%">
                                        <input type="text" name="sc_port" size="8" value="<?php echo $sc_port; ?>">
                                        <br>
                                        <?php echo $word_shoutcasting_port_note; ?>
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
                                        <?php echo $word_shoutcasting_pass; ?>
                                    </td>
                                    <td width="70%">
                                        <input type="text" name="sc_password" size="8" value="<?php echo $sc_password; ?>">
                                        <br>
                                        <?php echo $word_shoutcasting_pass; ?>
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
                                        <?php echo $word_shoutcasting_refresh; ?>
                                    </td>
                                    <td width="70%">
                                        <input type="text" name="sc_refresh" size="8" value="<?php echo $sc_refresh; ?>">
                                        <br>
                                        <?php echo $word_shoutcasting_refresh; ?>
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
                                            <?php echo $word_verify_config; ?> >> &nbsp;&nbsp;&nbsp;
                                        </font>
                                        <br>
                                        <?php
                                        if ('yes' != $error) {
                                            echo '<input type="submit" name="step1" value="' . $word_verify_config . ' >">&nbsp;&nbsp;&nbsp;';
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

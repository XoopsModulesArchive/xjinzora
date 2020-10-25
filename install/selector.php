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
// Now let's set the session variable for later
$_SESSION['inst_lang_var'] = $_POST['inst_lang'];

// Ok, first let's figure out the language file...
$inst_lang = $img_path . 'install/lang/' . $_SESSION['inst_lang_var'] . '.php';
include $inst_lang;

// Now let's figure out the form URL
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
$root_page = str_replace('&&', '&', str_replace('?&', '?', str_replace('install=selector', '', $root_page) . 'install=step3'));

// Now we're going to see if we can figure this all out for a 1 click install
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
}
if ('' == $media_dir) {
    $media_dir = '/music';
}
// Ok, now let's see if that works or not
if (is_dir($web_root . $root_dir . $media_dir)) {
    $one_click = 'true';
} else {
    $one_click = 'false';
}

// Now let's see if we can do an upgrade or not
if (is_file('settings.php')) {
    // Now let's see if there is data in the file or not

    require __DIR__ . '/settings.php';

    if ('yes' == $install_complete) {
        $upgrade = 'true';
    }
} else {
    $upgrade = 'false';
}
?>
<script language="JavaScript">
    <!--

    function disableFormStuff() {
        /* First let's hide the submit button until they type in AGREE and click the check box */
        document.install_form.step1.value = "You must agree before proceeding...";
        document.install_form.step1.disabled = true;
        document.install_form.install_type.disabled = true;
    }

    function enableForm(checked) {
        if (checked) {
            /* Now let's show them the submit button */
            document.install_form.step1.value = "<?php echo $word_next; ?> >";
            document.install_form.step1.disabled = false;
            document.install_form.install_type.disabled = false;
        } else {
            document.install_form.step1.value = "<?php echo $word_must_agree; ?>";
            document.install_form.step1.disabled = true;
            document.install_form.install_type.disabled = true;
        }
    }

    function setDescription(type) {
        descCell = document.getElementById("installdesc");
        descText = "";
        if (document.install_form.install_type.value == "upgrade") {
            descText = "<?php echo $word_upgrade_install_note; ?>";
        }
        if (document.install_form.install_type.value == "recommend") {
            descText = "<?php echo $word_recomend_install_note; ?>";
        }
        if (document.install_form.install_type.value == "simple") {
            descText = "<?php echo $word_simple_install_note; ?>";
        }
        if (document.install_form.install_type.value == "workgroup") {
            descText = "<?php echo $word_group_install_note; ?>";
        }
        if (document.install_form.install_type.value == "jukebox") {
            descText = "<?php echo $word_jukebox_intall_note; ?>";
        }
        if (document.install_form.install_type.value == "expert") {
            descText = "<?php echo $word_expert_install_note; ?>";
        }
        if (document.install_form.install_type.value == "postnuke") {
            descText = "<?php echo $word_postnuke_note; ?>";
        }
        if (document.install_form.install_type.value == "phpnuke") {
            descText = "<?php echo $word_phpnuke_note; ?>";
        }
        if (document.install_form.install_type.value == "nsnnuke") {
            descText = "<?php echo $word_nsnnuke_note; ?>";
        }
        if (document.install_form.install_type.value == "cpgnuke") {
            descText = "<?php echo $word_cgpnuke_note; ?>";
        }
        if (document.install_form.install_type.value == "mambo") {
            descText = "<?php echo $word_mambo_note; ?>";
        }
        if (document.install_form.install_type.value == "mdpro") {
            descText = "<?php echo $word_mdpro_note; ?>";
        }
        descCell.innerHTML = descText;
    }

    setDescription();
    // -->
</script>
<form name="install_form" action="<?php echo $root_page; ?>" method="post">
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo $img_path; ?>install/style.css">
    <body onLoad="disableFormStuff();setDescription();">
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
                                            <strong><?php echo $word_install_type; ?></strong>
                                        </font>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <?php $row_c = 1; ?>
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
                                        <?php
                                        // Ok, now let's read in the GPL
                                        $filename = $img_path . 'install/lang/' . $_SESSION['inst_lang_var'] . '-gpl.txt';
                                        $handle = fopen($filename, 'rb');
                                        $contents = fread($handle, filesize($filename));
                                        fclose($handle);

                                        ?>
                                        <textarea cols="80" rows="11"><?php echo $contents; ?></textarea>
                                        <br>
                                        <input type="checkbox" name="license" value="agree" onClick="enableForm(this.checked);"> <?php echo $word_agree; ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table width="780" cellpadding="5" cellspacing="0" border="0" align="center">
                    <tr>
                        <td width="100%" background="<?php echo $img_path; ?>install/images/bg_table.gif">
                            <table width="100%" cellpadding="5" cellspacing="0" border="0" align="center">
                                <tr>
                                    <td width="100%" align="center">
                                        <strong>Please choose your install type:</strong><br><br>
                                        <select name="install_type" onChange="setDescription();">
                                            <?php
                                            if ('true' == $upgrade) {
                                                ?>
                                                <option value="upgrade">Upgrade</option>
                                                <option value="">----------</option>
                                                <?php
                                            }
                                            ?>
                                            <option value="recommend">Recommended</option>
                                            <option value="simple">Simple</option>
                                            <option value="workgroup">Workgroup</option>
                                            <option value="jukebox">Jukebox</option>
                                            <option value="expert">Expert</option>
                                            <option value="">----------</option>
                                            <option value="postnuke">Postnuke</option>
                                            <option value="phpnuke">PHPNuke</option>
                                            <option value="nsnnuke">NSNNuke</option>
                                            <option value="cpgnuke">CPGNuke</option>
                                            <option value="mambo">Mambo</option>
                                            <option value="mdpro">MDPro</option>
                                        </select>
                                        <br><br>
                                        <div id="installdesc"></div>
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
                                            Primary Settings >> &nbsp;&nbsp;&nbsp;
                                        </font>
                                        <br>
                                        <input type="submit" name="step1">&nbsp;&nbsp;&nbsp;
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

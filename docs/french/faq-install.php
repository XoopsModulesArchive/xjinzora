<?php

// Let's modify the include path for Jinzora
ini_set('include_path', '.');

// Let's include the main, user settings file
require_once dirname(__DIR__, 2) . '/settings.php';
require_once dirname(__DIR__, 2) . '/system.php';

// Let's output the style sheets
echo "<link rel=\"stylesheet\" href=\"$root_dir/docs/default.css\" type=\"text/css\">";

?>

<body class="bodyBody">
<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td width="100%" class="bodyBody">
            <strong>FAQ Installation</strong>:<br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#filenotexist">Erreur &quot;Le fichier demand&eacute; n'existe pas&quot;</a><br>
                        <br></td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#cantaccessdirectly">Vous ne pouvez acc&eacute;der &agrave; ce fichier</a><br>
                        <br></td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#filenotexist">Impossible d'&eacute;crire dans le fichier de configuration</a><br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#settingsfile">Pourquoi l'installeur ne peut &eacute;crire dans le fichier de configuration?</a><br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#secureftp">Comment s&eacute;curiser Jinzora sans avoir acc&egrave;s &agrave; un terminal (uniquement un acc&egrave;s FTP)?</a><br>
                        <br>
                    </td>
                </tr>
            </table>
            <br><br><br><br><br><br><br><br><br>
            <br><br><br><br><br><br><br><br><br>
            <br><br><br><br><br><br><br><br><br>
            <br><br><br><br><br><br><br><br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <strong><a name="filenotexist">File you requested does not exist error</a></strong><br><br>
                        This is generally the result of a few things. It is most likey because you do not have
                        Jinzora set for the proper directory structure. Make sure that you are using either (Genre/Artist/Album/Tracks -
                        Artist/Album/Tracks - or /Album/Tracks. This needs to be set at install time (or by re-entering
                        the installer per the upgrade/install documentation. Currently these different directory structures
                        are not optional. You also can not mix and match directory structures, Jinzora expects all folders/files
                        to adhere to the correct format (NOTE: This is on the list to be changed as of Jinzora 2.0)
                        <br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <strong><a name="cantaccessdirectly">You can't access this file directly</a></strong><br><br>
                        This almost always means that you've set Jinzora for PostNuke mode and you're trying to view it in standalone
                        mode. Please re-enter setup and make sure that you have Jinzora set in the right mode. If you do make sure
                        that if you are accessing it in Standalone mode that you see only "index.php" at the page name,
                        (not modules.php?op=modload.....)
                        <br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <strong><a name="filenotexist">Cannot open settings file for writing</a></strong><br><br>
                        For some reason Jinzora can not write to the settings file. This generally means that you forgot to run
                        "sh configure.sh" (on *NIX boxes). That script will give EVERYONE write access to the settings file.
                        There could be other reasons that Jinzora can't write to the settings file (settings.php), there are just
                        too many possibilites to cover here, but basically make sure that the webserver user has write permissions to the
                        file (which configure.sh should do easily)
                        <br><br>
                        Don't forget to run "sh secure.sh" when you're finished!
                        <br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <strong><a name="settingsfile">Why can't the installer write the settings file?</a></strong><br><br>
                        There are a few possible reasons for this. The first of which is that you forgot to run "sh configure.sh" for a new
                        install, which creates the empty settings file. Or on Windows you didn't create the blank file settings.php.<br><br>
                        Another reason for this is that for some reason even though you ran "sh configure.sh" (or verified the permissions of the
                        file on Windows) that the webserver can't write to it. Check all the permissions and make sure that the file is
                        world writeable, that isn't the most secure way, but you can always change it later with "sh secure.sh"
                        <br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <strong><a name="secureftp">How do I secure Jinzora without terminal access (via FTP)?</a></strong><br><br>
                        By simpling removing write permissions to the webserver user, chmod 444 should do nicely...
                        <br><br><br>
                    </td>
                </tr>
            </table>
            <br><br><br><br><br><br><br><br><br>
            <br><br><br><br><br><br><br><br><br>
            <br><br><br><br><br><br><br><br><br>
            <br><br><br><br><br><br><br><br><br></td>
    </tr>
</table>
</body>

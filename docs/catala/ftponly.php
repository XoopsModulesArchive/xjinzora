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
            <strong>FTP Only Installation</strong><br>
            <br>
            Ok, so you want to install Jinzora, but you only have FTP Access to your server. While this is a bit
            harder, it shouldn't be that difficult to get done. If you are installing on PHPNuke/Postnuke please read
            that section FIRST, as there are a few things you'll need to do BEFORE launching the web based installer
            at the end of this guide.
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="40%" class="bodyBody" valign="top">
                        <li><strong>Download</strong></li>
                    </td>
                    <td width="60%" class="bodyBody">
                        Seems pretty simple, but it's worth stating. First you've got to download Jinzora.
                        You can get Jinzora from the following<br><br>
                        <a href="http://www.jinzora.org/modules.php?op=modload&name=Downloads&file=index" target="_blank">Jinzora Downloads Page</a>
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="40%" class="bodyBody" valign="top">
                        <li><strong>Extracting</strong></li>
                    </td>
                    <td width="60%" class="bodyBody">
                        Once you've gotten Jinzora downloaded you'll need to extact it on your local (normally your desktop) machine so that you
                        can next upload it (via FTP) to your server.
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="40%" class="bodyBody" valign="top">
                        <li><strong>Uploading</strong></li>
                    </td>
                    <td width="60%" class="bodyBody">
                        Ok, now that you've got Jinzora downloaded and extracted log into your remote server using FTP. This guide
                        will discuss (for reference purposes) how to do this in WS_FTP (but ANY ftp program should be totally fine).
                        <br><br>
                        Now that you're logged into your server, you'll need to create a new director for Jinzora to be installed into. If this
                        is a standalone installation this does not matter at all. If it is a PHPNuke/Postnuke install, this folder MUST be within
                        you /modules directory.
                        <br><br>
                        Once your new directory is created, you'll need to upload all the extracted files from your local machine to the remote
                        server. Once ALL the files are uploaded you're ready to start the web based installation portion
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="40%" class="bodyBody" valign="top">
                        <li><strong>GD Libraries</strong></li>
                    </td>
                    <td width="60%" class="bodyBody">
                        <strong>NOTE:</strong> We don't support installing and configuring the GD libraries via FTP, this section is only
                        left as a reference and a reminder that you'll need those libraries
                        <br><br>
                        To take advantage of the image resizing functions in Jinzora you'll need the <a href="http://www.boutell.com/gd/" target="_blank">Boutell.com GD image libraries</a>.
                        To install these (these are ROUGH guidelines)
                        <br><br>
                        <strong>Windows Users:</strong>
                        <br>
                        1. Download the GD Library <a href="http://www.jinzora.org/modules.php?op=modload&name=Downloads&file=index&req=viewdownload&cid=4" target="_blank">from us</a> (or get it on the net...)<br><br>
                        2. Unzip it to the exact same directory where PHP is installed (c:\php)<br><br>
                        3. Edit php.ini (usually in c:\winnt or c:\windows) and edit the following line:<br>
                        extension=php_gd2.dll (REMOVE the ; at the beginning of the line)
                        <br><br>
                        <strong>*NIX Users:</strong> This can be a bit more complicated on *NIX, so we recommend you view the installation guide
                        located at <a href="http://www.boutell.com/gd/manual2.0.15.html" target="_blank">Boutell.com</a> for assistance
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="40%" class="bodyBody" valign="top">
                        <li><strong>Web Installer</strong></li>
                    </td>
                    <td width="60%" class="bodyBody">
                        Now that you've gotten everything ready browse (in your favorite web browser) to<br><br>
                        http://yoursite/path/to/jinzora/index.php<br><br>
                        And you'll be taken through the web based installer. The web based installer is fully documented and should
                        describe each option that you'll have along the way.
                        <br><br>
                        At the end of the web based installer you'll need to download and save BOTH the settings.php and users.php
                        files. Once you have those 2 files saved to your local machine you'll need to upload them to the server, in the
                        same directory where Jinzora is installed. If this is an upgrade just replace the old files if the exist.
                        <br><br>
                        On *NIX systems you'll want to set the permissions on the temp and music directories. This can be done by executing
                        the following commands (command line FTP)
                        <br><br>
                        chmod -R 777 music/<br>
                        chmod -R 777 music/ (or whatever you named your media directory)<br>
                        chmod -R 777 temp/
                        <br><br>
                        <strong>WS_FTP</strong><br>
                        This can be accomplished by right clicking on the "music" dir and choosing "Properties"<br>
                        Then set the "Numeric Value" to 777<br>
                        <br>
                        Then create the "temp" directory (if it doesn't exist) by click "MkDir" while in the jinzora dir and typing "temp"<br>
                        Then right click on the "temp" dir and choosing "Properties"<br>
                        Then set the "Numeric Value" to 777<br>
                        <br>
                        While there are many ways to do this, these are probably the fastest and easiest<br>
                        <br><br><br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

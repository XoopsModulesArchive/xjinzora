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
            <strong>All Nuke CMS Installation</strong><br>
            <br>
            To install Jinzora in a Nuke based CMS please complete the following steps:
            <br><br>
            <strong>The supported Nuke based CMSes are:</strong><br>
            <li>Postnuke</li>
            <li>PHPNuke</li>
            <li>MDPro</li>
            <li>CPGNuke</li>
            <li>NSNNuke</li>
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
                        <br><br>
                        We suggest that you create a "jinzora" directory to save your download to so you can extract it next
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="40%" class="bodyBody" valign="top">
                        <li><strong>Extracting</strong></li>
                    </td>
                    <td width="60%" class="bodyBody">
                        Once you've got Jinzora downloaded you'll need to extract the download to your web server.
                        <br><br>
                        <strong>Windows:</strong> On Windows we recommend using <a href="http://www.winzip.com" target="_blank">Winzip</a> to extract the
                        downloaded .zip file (assuming that's the file you downloaded).
                        <br><br>
                        <strong>*NIX:</strong> On *NIX you'll need to do a: tar -zxvf jinzora-X.X.tar.gz (where X.X is the version number)
                        to extract Jinzora to the current directory (note: Jinzora will create a subdirectory called "jinzora")
                        <br><br>
                        <strong>NOTE:</strong> This directory MUST be located within the /modules directory of your Postnuke installation
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="40%" class="bodyBody" valign="top">
                        <li><strong>Preparing</strong></li>
                    </td>
                    <td width="60%" class="bodyBody">
                        <strong>Windows Users:</strong> You MUST make sure that the jinzora directory from above is
                        located with in your webserver's root directory (c:\inetpub\www by default). Virtual directories are
                        NOT currently supported (support is planned for the future). You can have your media on a different drive
                        IF and ONLY IF you are using NTFS (see <a href="symlinking.php" target="Body">symlinking</a> in Using Jinzora)
                        <br>
                        You also need to make sure that the webserver has at least read access to the directory you've extracted
                        Jinzora too (which it should unless you've changed things...)
                        <br><br>
                        <strong>*NIX Users:</strong> To make installing Jinzora on *NIX easier (and for those that have SSH access)
                        we've provided a script that will setup everything for Jinzora's installation. Please simply run:<br><br>
                        sh configure.sh
                        <br><br>
                        Inside the Jinzora directory. This will create the necessary files and setup the proper permissions so the
                        web based portion of the installation can complete (if you don't have SSH access don't worry, see <a href="ftp-only.php" target="Body">FTP Only</a>
                        installation for assistance)
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="40%" class="bodyBody" valign="top">
                        <li><strong>GD Libraries</strong></li>
                    </td>
                    <td width="60%" class="bodyBody">
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
                        <li><strong>CMS Integration</strong></li>
                    </td>
                    <td width="60%" class="bodyBody">
                        Now you'll need to create the link for Jinzora in your menu block. This is not required, but you'll probably
                        want to do this so your users can easily access Jinzora. Each of the CMSes does this a bit differently, so
                        please refer to your CMS on how to do this.
                        <br><br>
                        Once you've added your link click on it and continue on...
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="40%" class="bodyBody" valign="top">
                        <li><strong>Web Installer</strong></li>
                    </td>
                    <td width="60%" class="bodyBody">
                        Now you'll be taken through the web based installer. The web based installer is fully documented and should
                        describe each option that you'll have along the way.
                        <br><br>
                        On the second page of the installer you'll be asked for the Install Type. Just select the CMS from the list that you'll be
                        installing for (Postnuke/PHPNuke/etc). You'll then be prompted for the appropriate information
                        <br><br>
                        You can of course choose "Expert" and see all the options, the specific ones for your CMS will just be much faster as the
                        defaults will be taken for you...
                        <br><br>At the very end the installer will create two files for you. The files settings.php and users.php will be
                        generated, and if possible, be written to the server for you. If the installer can't write these files you'll
                        be able to download them manually. You'll need to upload these 2 files to the root directory of the Jinzora
                        installation. Once you've uploaded these files you'll be able to go to the index page for Jinzora.
                        <br><br><br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

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
            <b>Mambo CMS Installation</b><br>
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><b>Download</b></li>
                    </td>
                    <td width="70%" class="bodyBody">
                        Seems pretty simple, but it's worth stating. First you've got to download Jinzora.
                        You can get Jinzora from the following<br><br>
                        <a href="http://www.jinzora.org/modules.php?op=modload&name=Downloads&file=index" target="_blank">Jinzora Downloads Page</a>
                        <br><br>
                        We suggest that you create a "jinzora" directory to save your download to so you can extract it next
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><b>Extracting</b></li>
                    </td>
                    <td width="70%" class="bodyBody">
                        Once you've got Jinzora downloaded you'll need to extract the download to your web server. Please extract it to
                        a location that is accessable by Mambo (do NOT extract it to your "components" directory)
                        <br><br>
                        <b>Windows:</b> On Windows we recommend using <a href="http://www.winzip.com" target="_blank">Winzip</a> to extract the
                        downloaded .zip file (assuming that's the file you downloaded).
                        <br><br>
                        <b>*NIX:</b> On *NIX you'll need to do a: tar -zxvf jinzora-X.X.tar.gz (where X.X is the version number)
                        to extract Jinzora to the current directory (note: Jinzora will create a subdirectory called "jinzora")
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><b>Installing</b></li>
                    </td>
                    <td width="70%" class="bodyBody">
                        Once you've got Jinzora extracted you 'll need to go to the Mambo Administration page
                        <br><br>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li></li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Click "Components - Install/Uninstall"
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li></li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    in "Install from directory" browse to the location on your server where you extracted Jinzora
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li></li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Click "Install"
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li></li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Now copy ALL files from the extracted Jinzora to the new "com_jinzora"
                                    directory that was created under the "components" directory in your Mambo
                                    installation (replace all files if asked)
                                    <br><br>
                                    Yes, this is different from a standard Mambo install, we are working on making this
                                    better, but for now this MUST be done.
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li></li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    In the Mambo Administration page click on "Site - Menu Manager - Main Menu"
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li></li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Click on "New" (at the top of the page)
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li></li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Select "MOS Component" and click "Next"
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li></li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Choose a name (ie Jinzora)<br>
                                    Select "Jinzora" as the "Component"<br>
                                    click "Save"
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li></li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Click the "X" under "Published" to publish Jinzora to the main menu
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li></li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Click the menu item for "Jinzora" (or whatever you called it) -
                                    You'll now be taken through the Jinzora installer -
                                    Choose your language and click Next
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li></li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Go through the installer, it is documented.
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li></li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Once the installer is finished make sure to set the permissions on the
                                    "data" and "temp" directories (within in the Jinzora directory)<br>
                                    <b>NOTE:</b> This is only for non-Windows systems<br><br>
                                    Doing a:<br><br>
                                    chmod 777 data (and make sure to get all the subdirectories)<br>
                                    chmod 777 temp (and make sure to get all the subdirectories)<br>
                                    <br>
                                    Should be all you have to do.
                                    <br><br>
                                    Now click on the new link you added to Mambo and you'll be presented with the web based
                                    installer. On the second page of the installer you'll be asked for the installation type. Just choose
                                    "Mambo" and you'll be all set. You can of course use the "Expert" mode, but that will take much longer.
                                    <br><br>
                                    At the very end the installer will create two files for you. The files settings.php and users.php will be
                                    generated, and if possible, be written to the server for you. If the installer can't write these files you'll
                                    be able to download them manually. You'll need to upload these 2 files to the root directory of the Jinzora
                                    installation. Once you've uploaded these files you'll be able to go to the index page for Jinzora.
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li></li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Enjoy Jinzora on Mambo!!!
                                    <br><br>
                                </td>
                            </tr>
                        </table>
                        <br><br><br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

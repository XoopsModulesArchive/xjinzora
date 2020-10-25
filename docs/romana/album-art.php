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
            <strong>Album Art</strong>
            <br><br>
            There are lots of things Jinzora can do with Album art.
            <br>They are:
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <strong>Displaying</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Jinzora can display alubm art for all the albums in your collection.
                        The requirements for this are simple. All you need to do is to put
                        the art in the folder along with all the media tracks. When Jinzora
                        sees this folder and its corresponding media (including the art) it will
                        select the first image file that it sees and use that as the art everywhere in
                        the system.
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <strong>Searching for</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        There are a few ways that Jinzora can search for album art for you,
                        making adding album art to your collection very easy. They are:
                        <br><br>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="1%" valign="top" class="bodyBody">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody">
                                    <strong>Specifing per album</strong>
                                    <br>
                                    When you are viewing an album that does not have art you can click the link
                                    "Search for Album Art" in the top left hand corner of Jinzora.<br><br>
                                    <strong>NOTE:</strong> You must be logged in with Admin level priveldges to see
                                    this link.
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" valign="top" class="bodyBody">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody">
                                    <strong>Auto Searching</strong>
                                    <br>
                                    If you enable it ($auto_search_art = "true"; in settings.php) Jinzora will automatically
                                    search for album art for albums when you view an artist. Jinzora will download the first
                                    match it finds for a particular album. You can easily click the "Change Art" link below
                                    the album (or on the Track page) to select a different album cover for that album
                                    <br><br>
                                    NOTE: When Jinzora can not find a match on art it will create a template image with the
                                    name of the album dynamically generated on the image for you.
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" valign="top" class="bodyBody">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody">
                                    <strong>Using the Admin Tool</strong>
                                    <br>
                                    If you wish, you can use the "Search for missing album art" tool on the Tools page in Jinzora
                                    to go through each album in your collection, one by one. While this can be time consuming on
                                    a large collection, for smaller ones it can let you choose each album cover you want, one by one
                                    in a relatively quickly fashion
                                    <br><br>
                                    NOTE: When Jinzora can not find a match on art it will create a template image with the
                                    name of the album dynamically generated on the image for you.
                                    <br><br>
                                </td>
                            </tr>
                        </table>
                        <br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

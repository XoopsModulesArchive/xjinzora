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
            <b>Description Files</b>
            <br><br>
            There are many places within Jinzora that you can specify descriptions of items.<br>
            They are:
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <b>Genre/Artist</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        At the Genre/Artist level Jinzora can display a description of each just below the name
                        of the Genre/Artist. For example:
                        <br><br>
                        <img src="images/genre-desc.gif?<?php echo time(); ?>">
                        <br><br>
                        To enable this function simply create a file called Genre.txt (or Artist.txt) at the SAME
                        level as the folder (so basically exactaly what the folder is named, it is case sensitive).
                        When Jinzora sees this file it will display it here.
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <b>Genre Sub Description</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        If you wish, when viewing a Genre (meaning you've clicked on the link for the Genre and are
                        now looking at all the artists in that Genre, or the Artists page) you can add an
                        image and description file to the top area, like this:
                        <br><br>
                        <img src="images/genre-sub-desc.gif?<?php echo time(); ?>">
                        <br><br>
                        To enable this function simply create a .txt and .jpg file with the EXACT same name
                        of the Genre you've selected, within the Genre folder (along side all the Artist folders). This
                        descriptive text will then be displayed here.
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <b>Album View</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        At the Album View you can add a description file describing a particular artist:
                        <br><br>
                        <img src="images/artist-desc.gif?<?php echo time(); ?>">
                        <br><br>
                        This is done much the same way as above, with one change. The file should go within the
                        artist folder, at the same level as all the Album folders. Simply create a file called Artist.txt
                        (so basically exactaly what the folder is named, it is case sensitive).
                        When Jinzora sees this file it will display it here.
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <b>Track View:<br>Album Description</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        At the track view you can also include a description of the album that you are currently viewing:
                        <br><br>
                        <img src="images/album-desc.gif?<?php echo time(); ?>">
                        <br><br>
                        For this file, you'll need to create album-desc.txt INSIDE the album folder. When Jinzora sees that
                        file it will display it's contents in the center of the upper section.
                        <br><br>
                        There are a few variables you can use in this view, they are:
                        <br><br>
                        <b>ARTIST_NAME</b> When you use this variable in your description files it will
                        be replaced by the name of the artist you are viewing
                        <br><br>
                        <b>ALBUM_NAME</b> When you use this variable in your description files it will
                        be replaced by the name of the album you are viewing
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <b>Track View:<br>Track Description</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        At the track view you can also include a description of the individual tracks:
                        <br><br>
                        <img src="images/track-desc.gif?<?php echo time(); ?>">
                        <br><br>
                        There are 2 ways to display this information. They are:
                        <br><br>
                        1. Using the ID3 comment tag. While this is much more limited, due to the
                        limitations on the length of the ID3 comment field, it can be used here
                        <br><br>
                        2. Using a description file (trackname.txt) The description file name must
                        EXACTALLY match the name of the file, including case. If this file exists it will
                        override the ID3 comment field.
                        <br><br><br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

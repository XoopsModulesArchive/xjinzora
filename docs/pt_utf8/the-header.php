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
            <b>Jinzora's Header</b>
            <br><br>
            There are many things that can be changed in the header that is displayed on all
            pages within Jinzora. They are:
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <b>Description</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        If you wish you can add descriptive text to the Header in Jinzora that will
                        display on all pages. This will appear right below the standard info in the header,
                        like the Genre you are viewing, artist, album info, etc. Something like this:
                        <br><br>
                        <img src="images/header-desc.gif">
                        <br><br>
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <b>Genre List</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        (in Genre/Artist/Album mode) you can Disable the Genre drop down list if you wish.
                        This can be done during setup, or by editing settings.php and setting:<br><br>
                        $genre_drop = "false";
                        <br><br>
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <b>Artist List</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        (in Genre/Artist/Album or Artist/Album mode) you can Disable the Artist drop down list if you wish.
                        This can be done during setup, or by editing settings.php and setting:<br><br>
                        $artist_drop = "false";
                        <br><br>
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <b>Album List</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        (All Modes) you can Disable the Album drop down list if you wish.
                        This can be done during setup, or by editing settings.php and setting:<br><br>
                        $album_drop = "false";
                        <br><br>
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <b>Song List</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        (All Modes) you can Enable (this is disabled by default) the Song drop down list if you wish.
                        This can be done during setup, or by editing settings.php and setting:<br><br>
                        $song_drop = "false";
                        <br><br>
                        <b>NOTE:</b> On a large site, this can be INCREDIBLY slow. Since Jinzora must read
                        and therefore generate a select list of every track it can take forever to do. Please only
                        use this on smaller sites or at your own risk!
                        <br><br>
                        <br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

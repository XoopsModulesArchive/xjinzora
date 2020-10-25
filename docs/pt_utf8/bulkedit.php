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
            <b>Bulk Editing Media</b><br>
            <br>
            There are a couple of tools that can be used to bulk edit media within Jinzora. These can be accessed from the
            "Media Management" menu when logged in with admin privledeges (most of these are accessable on the "Tracks" page). They are:
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <b>Change Art</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        This allows you to download new album art for the current album.
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <b>Rewrite ID3 Tags</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        This tells Jinzora to dynamically rewrite the ID3 tags on the tracks based on the filesystem data. It will also,
                        if present, write the album art directly to the ID3 tag (so when the track is streamed the album art can be viewed).
                        <br><br>
                        When writing the tags the filesystem data is used. For example in "Genre" mode (or 3 directory mode) the following file
                        would be written the following way:
                        <br><br>
                        /Jazz/Miles Davis/Kind of Blue/07 - All Blues.mp3
                        <br><br>
                        Genre: Jazz<br>
                        Artist: Miles Davis<br>
                        Album: Kind of Blue<br>
                        Track Name: All Blues<br>
                        Track Number: 07<br>
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <b>Item Information</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        This will bring up the editor page for the currently selected item (if you are viewing an album it will display the
                        information about that album). This will let you update description files and album/artist images.
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <b>Bulk Edit</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        The "Bulk Edit" tool gives you 2 functions. They are:
                        <br><br>
                        <b>Search & Replace</b> - This will also you to edit the names of tracks and bulk remove information. Say
                        each track has the artist name in it, and you'd like to clean it up by removing that.
                        <br><br>
                        <b>Fix Filename Case</b> - This will change a track name from:<br><br>
                        07 - all blues.mp3
                        <br><br>
                        to
                        <br><br>
                        07 - All Blues.mp3
                        <br><br>
                        So it will display prettier.
                        <br><br><br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

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
            <strong>Shortening the display of items</strong><br>
            <br>
            There are many places and ways to shorten the display of items in Jinzora. They are:<br><br>
            <strong>Artist Name</strong>
            <br>
            You can set the variable:
            <br>
            $artist_truncate = "XX";
            <br>
            Where XX is the number of characters you'd like to shorten the artist name to.
            <br><br>
            <strong>Album Name</strong>
            <br>
            You can set the variable:
            <br>
            $album_name_truncate = "XX";
            <br>
            Where XX is the number of characters you'd like to shorten the album name to.
            <br><br>
            <strong>Album Name</strong>
            <br>
            You can set the variable:
            <br>
            $quick_list_truncate = "XX";
            <br>
            Where XX is the number of characters you'd like to shorten the quick list items to.
            <br><br>
            <br><br>
        </td>
    </tr>
</table>
</body>

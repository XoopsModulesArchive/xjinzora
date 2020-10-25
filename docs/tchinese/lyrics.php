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
            <strong>Lyrics Files</strong></strong>
            <br><br>
            If you wish, Jinzora can display a link to a track that would include it's lyrics file.
            This is a very simple link, it just simply links to the .txt file on the server so it can
            be displayed. To add a link to a file, you'll need to create a .lyrics.txt file with the
            EXACT same name as the track. For example:
            <br><br>
            01 - All Blues.mp3
            <br><br>
            Would be:
            <br><br>
            01 - All Blues.lyrics.txt
            <br><br>
            Then a link will appear next to the track that says " - Lyrics"
        </td>
    </tr>
</table>
</body>

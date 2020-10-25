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
            <strong>HTML Playlists</strong><br>
            <br>
            Jinzora can generate HTML playlist if you'd like. Basically Jinzora will create a HTML
            page that lists each Track in the playlist with links to each individual file. This was created
            for a very specific purpose and user, but we though it was cool so we left it in!
            <br><br>
        </td>
    </tr>
</table>
</body>

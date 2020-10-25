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
            <strong>Tracks Only</strong>
            <br><br>
            If you wish you can disable all "Play" and "Play Random" icons within Jinzora so that users
            can only stream individual tracks. This can be useful on a public site where you wish
            to demo individual tracks for your users. To turn on this mode edit "settings.php" and set it to
            <br><br>
            $track_play_only = "true";
        </td>
    </tr>
</table>
</body>

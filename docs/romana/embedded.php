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
            <strong>Using the Embedded Media Player</strong><br>
            <br>
            You can now use an "embedded" media player with Jinzora. The way this works is that any file
            that is requested, rather than being streamed to the user, will be played in a "popup" page
            with an embedded version of Windows Media Player. Right now it is only WMP, sorry to users who
            can't use this player (we are working on a more universal approach for the future). The embedded player
            will auto resize based on wether you are playing audio or video media (both are supported)
            <br><br>
            To enable the embedded media player edit:
            <br><br>
            $play_in_wmp_only = true;
            <br><br>
            <strong>NOTE:</strong> When you enable the embedded player the user can ONLY play individual tracks,
            no playlists or playing multiple tracks (since the embedded player doesn't support that).
        </td>
    </tr>
</table>
</body>

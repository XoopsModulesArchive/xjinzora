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
            <b>Hidding Tracks</b>
            <br><br>
            Jinzora can "Hide" tracks when they are found in areas other than the album
            level. When tracks are hidden a "Show Tracks" button will show just above
            the playlist bar at the bottom of the screen, like this:<br><br>
            <img src="images/hide-tracks.gif">
            <br><br>
            Clicking this button will reveal all the tracks that have been "hidden" from view,
            like this:<br><br>
            <img src="images/show-tracks.gif">
            <br><br>
            This feature can be very useful if you have a lot of tracks in random locations and you
            wish to hide them most of the time. It will help keep your pages shorter and more
            navigatable.
            <br><br><br><br>
        </td>
    </tr>
</table>
</body>

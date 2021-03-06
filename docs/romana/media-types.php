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
            <strong>Media Types</strong><br>
            <br>
            Jinzora has been tested with and supports a number of different media types. Basically any
            media type that can stream over HTTP should work just fine, for playlists it would need to be
            any kind of media file that can be placed inside a playlist (a .m3u by default). For video
            files playlists are not supported, but rather individual files can be played. The following media
            types are known to work well with Jinzora:
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong>Audio</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        <li>MP3</li>
                        <br>
                        <li>WAV</li>
                        <br>
                        <li>OGG (Ogg Vorbis)</li>
                        <br>
                        <li>WMA (Windows Media Audio)</li>
                        <br>
                        <li>RM (Real Media - Single File Only)</li>
                        <br>
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong>Video</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        The following are NOT supported in playlists<br><br>
                        <li>MPG/MPEG (v1 and v2)</li>
                        <br>
                        <li>AVI</li>
                        <br>
                        <li>WMV (Windows Media Video)</li>
                        <br>
                        <li>RM (Real Media)</li>
                        <br>
                        <br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

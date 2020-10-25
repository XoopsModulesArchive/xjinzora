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
            <strong>Types de m&eacute;dias support&eacute;s </strong><br>
            <br>
            Jinzora supporte et a &eacute;t&eacute; test&eacute; avec un grand nombre de m&eacute;dias diff&eacute;rents. A priori tout type de m&eacute;dia qui puisse &ecirc;tre stream&eacute; par HTTP devrait fonctionner. Pour ce qui est des playlists, il devra faire partie des m&eacute;dias
            support&eacute;s dans ces playlists (.M3U par d&eacute;faut). En ce qui concerne les vid&eacute;os, vous ne pourrez les inclure dans les playlists, mais les fichiers seuls ne posent pas de probl&egrave;me. Les formats suivants marcheront parfaitement avec Jinzora:
            <br>
            <br>
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
                        <li>RM (Real Media - Fichiers seuls uniquement)</li>
                        <br>
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong>Video</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Les suivants ne sont PAS support&eacute;s dans les playlists<br>
                        <br>
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

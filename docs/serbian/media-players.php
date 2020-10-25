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
            <strong>Media Players</strong><br>
            <br>
            Jinzora has been tested with many different media players on many
            different OSes. While we obviously can't test and support every media
            player, here is a list of the major ones we've tested with (using .M3U
            playlist files)
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="1%" class="bodyBody" valign="top">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        Winamp 2.x and 3.x
                        <br>
                        This is our player of choice, mainly because it's pretty much
                        the best media player ever written! Also it supports extented playlists
                        which look much prettier when you are streaming (as do others...)
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" class="bodyBody" valign="top">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        Windows Media Player 8.0 - 9.0
                        <br>
                        We have seen some issues with Windows Media Player 7.x
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" class="bodyBody" valign="top">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        XMMS (on Linux)
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" class="bodyBody" valign="top">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        iTunes (on both OS X and Windows)
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" class="bodyBody" valign="top">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        MuiscMatch Jukebox 7.x - 8.x
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" class="bodyBody" valign="top">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        Foobar2000
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" class="bodyBody" valign="top">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        QCD
                        <br><br>
                    </td>
                </tr>
            </table>
            If you've used Jinzora with another player and know it works just fine
            please let us know and we'll add it to the list. And if you know Jinzora
            has issues with your favorite media player, then use one of these! :-) Seriously
            if you know it has issues let us know and we'll try to figure them out!
        </td>
    </tr>
</table>
</body>

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
            <strong>Les Media Players</strong><br>
            <br>
            Jinzora est test&eacute; avec plusieurs &quot;media players&quot; (lecteurs) sous diff&eacute;rents OS. Bien que nous ne soyons en mesure de tester tous les players, voici une liste des principaux d'entre eux (test&eacute;s avec les playlist au format .M3U)<br>
            <br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="1%" class="bodyBody" valign="top">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        Winamp 2.x and 3.x
                        <br>
                        C'est notre player de pr&eacute;dilection, principalement parce qu'il s'agit du meilleur player jamais d&eacute;velopp&eacute;! De plus il supporte les playlists &eacute;tendues, ce qui para&icirc;t mieux quand vous faites du streaming<br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" class="bodyBody" valign="top">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        Windows Media Player 8.0 - 9.0
                        <br>
                        Nous avons eu quelques soucis avec Windows Media Player 7.x
                        <br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" class="bodyBody" valign="top">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        XMMS (Linux)
                        <br>
                        <br></td>
                </tr>
                <tr>
                    <td width="1%" class="bodyBody" valign="top">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        iTunes (Mac OS X et Windows)
                        <br>
                        <br>
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
            </table>
            Si vous utilisez Jinzora avec d'autres players et que tout fonctionne bien, veuillez nous le faire savoir, nous l'ajouterons &agrave; la liste. De la m&ecirc;me fa&ccedil;on si vous avez des probl&egrave;mes avec votre player utilisez-en un de cette liste :-). Plus s&eacute;rieusement,
            si vous avez un souci, nous essaierons d'y rem&eacute;dier!
        </td>
    </tr>
</table>
</body>

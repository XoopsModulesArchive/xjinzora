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
            <strong>Recherches</strong><br>
            <br>
            Il est possible d'effectuer une recherche sur chaque &eacute;l&eacute;ment contenu par Jinzora. Vous devez &ecirc;tre loggu&eacute; autrement qu'en mode &quot;viewonly&quot; pour acc&eacute;der &agrave; cette fonction. Quelques pr&eacute;cisions:<br>
            <br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="1%" class="bodyBody" valign="top">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        Faites attention &agrave; vos majuscules/minuscules, toutes les recherches seront sensibles &agrave; la casse.<br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" class="bodyBody" valign="top">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        Les recherches s'appliqueront &agrave; tous les m&eacute;dias de tous les dossiers dont dispose Jinzora.<br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" class="bodyBody" valign="top">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        Les recherches utilisent le fichier temporaire de cache, tout changement ult&eacute;rieur ne sera pris en compte qu'apr&egrave;s une mise &agrave; jour de ce cache.<br>
                        <br>
                    </td>
                </tr>
            </table>
            <br><br>
        </td>
    </tr>
</table>
</body>

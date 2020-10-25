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
            <strong>Mise à jour de Jinzora sous un système Windows</strong><br>
            <br>
            Mettre à jour Jinzora sous un système Windows est très simple. Tout ce dont vous avez besoin est
            de télécharger la dernière version de Jinzora et vous laisser guider par l'installeur.
            Jinzora est prévu pour importer vos anciens fichiers de paramètres et vous dirigez dans
            le processus de mise à jour (exactement le même que lors de l'installation). Donc pour mettre
            à jour Jinzora, merci de vous référer au guide d'installation approprié:<br><br>
            <li><a href="standalone.php" target="Body">Standalone Install</a></li>
            <br>
            <li><a href="postnuke.php" target="Body">Postnuke Install</a></li>
            <br>
            <li><a href="phpnuke.php" target="Body">PHPNuke Install</a></li>
            <br>
            <li><a href="ftponly.php" target="Body">FTP Only Install</a></li>
            <br>
            <br><br>
        </td>
    </tr>
</table>
</body>

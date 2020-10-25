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
            <strong>Prérequis *NIX</strong>
            <br><br>
            Les Prérequis pour utiliser Jinzora sous *NIX sont:<br><br>
            <li>PHP 4.x (la 5.0 bêta devrait marcher, mais n'a pas été testée)</li>
            <br>
            <li>Apache 1.x/2.x<br>
                &nbsp;&nbsp;&nbsp;(d'autres serveur web peuvent marcher, mais seul Apache a été testé)
            </li>
            <br>
            <li>l'application zip (pour supporter la compression et décompression)</li>
            <br>
            <li>Librairie GD (pour changer la taille des images)</li>
            <br>
            <li>Une collection de medias organisée:</li>
            &nbsp;&nbsp;&nbsp;Genre/Artiste/Album/Piste<br>
            &nbsp;&nbsp;&nbsp;Artiste/Album/Piste<br>
            &nbsp;&nbsp;&nbsp;Album/Piste<br><br>
            <li>Jinzora installé dans le répertoire de base "docroot" d'Apache</li>
            &nbsp;&nbsp;&nbsp;Les répertoires virtuels ne sont pas supportés,<br>
            &nbsp;&nbsp;&nbsp;mais sont prévus<br><br>
            <li>Que le serveur web puisse lire les fichiers de media</li>
            <br>
            <li>Que le serveur web puisse écrire les fichiers de media</li>
            &nbsp;&nbsp;&nbsp;<strong>NOTE:</strong> C'est totalement optionnel, mais est<br>
            &nbsp;&nbsp;&nbsp;requis pour le fonctionnement de plusieurs outils additionnels
        </td>
    </tr>
</table>
</body>

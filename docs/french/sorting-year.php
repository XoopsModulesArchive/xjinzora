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
            <strong>Trier par année</strong>
            <br><br>
            Si vous voulez, Jinzora peut trier vos albums par année de sortie, si cette
            information est disponible dans les fichiers dans le dossier de l'album
            (habituellement le tag ID3 année). Jinzora va lire le premier fichier pour
            lequel il trouve l'année dans chaque dossier et utiliser ces données pour afficher
            l'année des albums. Jinzora va alors trier les albums par année, et ajouter tous
            les albums qui n'ont pas de date à la suite, dans l'ordre alphabétique, comme ceci:
            <br><br>
            <img src="images/sort-year.gif">

            <br><br><br><br>
        </td>
    </tr>
</table>
</body>

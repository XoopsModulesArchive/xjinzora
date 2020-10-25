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
            <strong>Cacher les pistes</strong>
            <br><br>
            Jinzora peut "Cacher" les pistes quand elles sont dans d'autres endroits qu'au niveau
            d'un album. Quand les pistes sont cachées, un bouton "Afficher les pistes" sera visible
            juste au dessus de la barre des listes de lecture au bas de l'écran, comme ceci:<br><br>
            <img src="images/hide-tracks.gif">
            <br><br>
            Cliquer sur ce bouton révélera toutes les pistes qui ont été cachées, comme ceci:<br><br>
            <img src="images/show-tracks.gif">
            <br><br>
            Cette fonctionnalité peut être très utile si vous avez de nombreuses pistes à divers endroits
            et que vous désirez les cacher la plupart du temps. Cela vous aidera à garder vos pages courtes
            et plus aisément navigables.
            <br><br><br><br>
        </td>
    </tr>
</table>
</body>

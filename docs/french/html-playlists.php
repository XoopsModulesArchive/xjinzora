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
            <strong>Listes de lecture HTML</strong><br>
            <br>
            Jinzora peut générer des listes de lecture HTML pour vous. Jinzora créera une page HTML qui
            listera chaque Piste de la liste de lecture avec des liens vers chaque fichier. Cela a été
            créé pour une utilisation spéciale à la demande d'un utilisateur spécifique, mais nous avons
            pensé que c'était intéressant et nous l'avons laissé!
            <br><br>
        </td>
    </tr>
</table>
</body>

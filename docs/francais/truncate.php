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
            <strong>Raccourcir l'affichage des éléments</strong><br>
            <br>
            Il y a beaucoup d'endroits et de manières de raccourcir l'affichage des éléments dans Jinzora. Ils sont:<br><br>
            <strong>Nom de l'artiste</strong>
            <br>
            Vous pouvez utiliser la variable:
            <br>
            $artist_truncate = "XX";
            <br>
            Où XX est le nombre de caractères au bout duquel vous voulez tronquer le nom de l'artiste.
            <br><br>
            <strong>Nom de l'album</strong>
            <br>
            Vous pouvez utiliser la variable:
            <br>
            $album_name_truncate = "XX";
            <br>
            Où XX est le nombre de caractères au bout duquel vous voulez tronquer le nom de l'album.
            <br><br>
            <strong>Eléments de la liste rapide</strong>
            <br>
            Vous pouvez utiliser la variable:
            <br>
            $quick_list_truncate = "XX";
            <br>
            Où XX est le nombre de caractères au bout duquel vous voulez tronquer les éléments de la liste rapide.
            <br><br>
            <br><br>
        </td>
    </tr>
</table>
</body>

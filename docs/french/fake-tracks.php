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
            <strong>Fausses pistes</strong>
            <br><br>
            Jinzora peut afficher de "Fausses" pistes. Cela permet de lister quelques pistes
            d'un artiste, mais pas toutes, à des fin de démonstration. Cela vous permet de donner
            quelques pistes en démonstration, et seulement le nom des autres, ce qui permet à
            l'utilisateur de connaître leur présence.
            <br><br>
            Pour utiliser les fausses pistes, tout ce que vous devez faire est créer un fichier appelé:<br><br>
            <strong>Nom complet de la piste.fake.txt</strong><br><br>
            Jinzora affichera alors la piste comme:<br><br>
            <strong>Nom complet de la piste</strong><br><br>
            Et il utilisera le contenu du fichier comme description (un autre fichier de description
            n'est donc pas nécessaire). Bien entendu, aucune icône lecture, téléchargement, ou liste
            de lecture n'apparaîtra à côté d'une piste .fake.
            <br><br><br><br>
        </td>
    </tr>
</table>
</body>

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
            <strong>Suggestions de Jinzora</strong>
            <br><br>
            Une des fonctionnalités de groupe de Jinzora est les suggestions de Jinzora. Cela autorise Jinzora à suggérer des pistes à l'utilisateur en fonction de leurs notations communes.<br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <strong>Mise en marche</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Il y a peu de choses à faire pour mettre en marche les suggestions de Jinzora. Vous pouvez choisir l'installation "workgroup", qui activera les bonnes options, ou vous assurer que:<br><br>
                        $enable_suggestions = "true";
                        <br><br>
                        Dans votre fichier settings.php.
                        <br><br>
                        Vous devrez également vous assurer que vous avez créer le répertoire "data" (sous le répertoire racine de Jinzora) et que le serveur web y a accès en écriture. Ce répertoire stock tous les fichiers de donées nécessaires aux discussions.
                        <br><br>
                        Vous pouvez régler le nombre de pistes suggérées par Jinzora pour chauqe utilisateur en utilisant:<br><br>
                        <strong>$num_most_played = "5";</strong>
                        <br><br>
                        Ce qui dira à Jinzora d'afficher 5 suggestions à chaque utilisateur.
                        <br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

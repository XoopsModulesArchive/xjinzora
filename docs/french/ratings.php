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
            <strong>Notes</strong>
            <br><br>
            Une des fonctionnalités de groupe de Jinzora est la notation. Cela permet aux utilisateurs d'entrer leur propre note for n'importe quel élément dans Jinzora (Genres/Artistes/Albums/Pistes). Un utilisateur peut voter une seule fois, avec le même nom d'utilisateur ou adresse IP.
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <strong>Mise en marche</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Il y a peu de choses à faire pour mettre en marche la notation. Vous pouvez choisir l'installation "workgroup", qui activera les bonnes options, ou vous assurer que:<br><br>
                        $enable_ratings = "true";
                        <br><br>
                        Dans votre fichier settings.php.
                        <br><br>
                        YVous devrez également vous assurer que vous avez créer le répertoire "data" (sous le répertoire racine de Jinzora) et que le serveur web y a accès en écriture. Ce répertoire stock tous les fichiers de donées nécessaires aux notations.
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <strong>Utilisation<br>de la notation</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Pour utiliser la notation, tout ce que vous avez à faire est de cliquer l'icône "Noter" (étoile) à côté de l'élément que vous voulez noter.
                        <br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

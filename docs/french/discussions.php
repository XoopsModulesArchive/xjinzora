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
            <strong>Discussions</strong>
            <br><br>
            Une des fonctionnalités de groupe de Jinzora sont les discussions. Cela permet
            aux utilisateurs d'ajouter leurs propres commentaires sur un élément de
            Jinzora (Genres/Artistes/Albums/Pistes). Les utilisateurs peuvent commenter
            une seule fois, basé soit sur leur nom d'utilisateur, soit sur leur addresse IP.
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <strong>Activation</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Vous aurez besoin de quelques choses pour activer les discussions.
                        Vous pouvez choisir l'installation de type "workgroup", qui réglera
                        les options convenablement, ou vous assurer que:<br><br>
                        $enable_discussion = "true";
                        <br><br>
                        Dans votre fichier <i>settings.php</i>.
                        <br><br>
                        Vous aurez aussi besoin de vous assurez que vous avez créer
                        le répertoire "data" (dans le répertoire racine de Jinzora) et que
                        le serveur web a accès en écriture à ce dossier. Ce dossier
                        contiens tous les fichiers de données nécessaires aux discussions.
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <strong>Utiliser les <br>Discussions</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Pour utiliser les discussions, tout ce dont vous avez besoin de
                        faire est de cliquer sur l'icône "Discuter l'élément" à côté
                        de l'élément pour lequel vous souhaitez entrer un commentaire.
                        Les utilisateurs sont autorisés à éditer leur propre
                        commentaires seulement.
                        <br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

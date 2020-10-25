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
            <strong>Gestionnaire d'utilisateurs</strong><br>
            <br>
            Jinzora peut être utilisé dans un environement multi-utilisateur, avec différents droits
            pour differents utilisateurs. Vous créez et editez les utilisateurs dans le "Gestionnaire
            d'utilisateurs" dans la section "Outils" de Jinzora. Il y a 5 types d'utilisateur, qui sont:
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong>Pas d'accès</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Cela n'a réellement de sens que pour le niveau d'accès par defaut. Lorsque le
                        niveau par defaut est "noaccess" Jinzora dirigera toujours un utilisateur non
                        identifié vers la page d'identification.
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong>Voir seulement</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Les utilisateurs du niveau "voir seulement" (viewonly) peuvent seulement voir
                        les pistes, mais pas les écouter ou les télécharger. C'est le niveau le plus limité.
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong>Utilisateurs standards</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Les utilisateurs standards (user) peuvent voir toutes les pistes, les
                        écouter, et peuvent créer et enregistrer des listes de lecture.
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong>Utilisateurs avancés</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Les utilisateurs avancés (poweruser) peuvent voir toutes les pistes, les
                        écouter, et peuvent créer et enregistrer des listes de lecture. Ils peuvent
                        également télécharger des pistes (à moins que cela soit désactivé globalement).
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong>Adiminstrateurs</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Les adiminstrateurs (admin) peuvent voir toutes les pistes, les écouter, et
                        peuvent créer et enregistrer des listes de lecture. Ils peuvent également
                        télécharger des pistes (même si cela est désactivé globalement) et peuvent accéder
                        à la section "Outils". Ils peuvent également télécharger automatiquement des images
                        d'album (ou chercher manuellement et sauver des images d'album).
                        <br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

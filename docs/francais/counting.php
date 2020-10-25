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
            <strong>Compteur de requêtes</strong>
            <br><br>
            Une des fonctionnalités de groupe de Jinzora est le compteur de requêtes. Il
            vous permet de connaître combien de fois une piste a été demandée depuis Jinzora.
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <strong>Enabling</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Vous aurez besoin de quelques choses pour activer le compteur
                        de requêtes. Vous pouvez choisir l'installation de type
                        "workgroup", qui réglera les options convenablement, ou vous
                        assurer que:<br><br>
                        $track_plays = "true";
                        <br><br>
                        Dans votre fichier <i>settings.php</i>.
                        <br><br>
                        Vous aurez aussi besoin de vous assurez que vous avez créer
                        le répertoire "data" (dans le répertoire racine de Jinzora) et que
                        le serveur web a accès en écriture à ce dossier. Ce dossier
                        contiens tous les fichiers de données nécessaires au compteur.
                        <br><br>
                        Vous pouvez aussi demander à Jinzora d'afficher les 5 pistes les
                        plus demandées sur la page d'accueil en ajoutant
                        dans <i>settings.php</i>:
                        <br><br>
                        $num_most_played = "5";
                        <br><br>

                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <strong>Utiliser le <br>compteur</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Utiliser le compteur est simple, Jinzora le fait pour vous!
                        <br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

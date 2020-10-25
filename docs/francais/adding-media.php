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
            <strong>Ajouter du contenu à Jinzora</strong>
            <br><br>
            Vous avez de nombreux chois différnets pour ajouter du contenu à Jinzora, quelques uns sont:
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <strong>Centre d'envois</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Le "Centre d'envois" dans la page "Outils" vous permet d'envoyer des albums
                        entiers au travers de l'interface web. Si vous voulez, vous pouvez envoyer
                        un unique fichier ZIP (.tar.gz n'est pas supporté) et Jinzora créera les
                        répertoires appropriés et décompressera le fichier pour vous, créant toutes
                        les pistes.<br>
                        <strong>NOTE:</strong> Il peut y avoir beaucoup de problèmes avec les différents
                        serveurs web et la quantité de donnée qui peut être envoyée en une seule fois.
                        Ce système n'est pas 100% fiable et devrait être testé dans votre environnement
                        avant une utilisation généralisée.
                        <br><br>
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <strong>FTP/SCP<br>SFTP/SMB/etc...</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Il y a beaucoup, beaucoup d'autres moyens d'ajouter du contenu dans Jinzora.
                        Souvenez-vous que Jinzora lit simplement les données dans votre répertoire
                        $media_dir pour trouver ce dont il a besoin. Tout ce que vous devez faire
                        est créer des fichiers et des répertoires à l'intérieur et ils seront tous
                        affichés par Jinzora. Vous pouvez utiliser n'importe quelle méthode pour
                        faire cela, choisissez la plus facile pour vous!
                        <br><br>
                        <br><br>
                    </td>
                </tr>
            </table>
            <br><br>
        </td>
    </tr>
</table>
</body>

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
            <strong>En tête Jinzora</strong>
            <br><br>
            Beaucoup de choses peuvent être changées dans les en tête affichés
            sur toutes les pages de Jinzora. Elles sont:
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <strong>Description</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Si vous voulez, vous pouvez ajouter un texte descriptif à
                        l'en tête que Jinzora affiche sur toutes les pages. Il apparaîtra
                        juste en dessous des informations standards dans l'en tête, comme
                        le genre courant, l'artiste, l'album, etc. Quelque chose comme ça:
                        <br><br>
                        <img src="images/header-desc.gif">
                        <br><br>
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <strong>Liste de genres</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        (dans le mode Genre/Artiste/Album) vous pouvez désactiver la liste
                        déroulante de genre si vous voulez. Cela peut être fait durant
                        l'installation, ou en éditant le fichier settings.php:<br><br>
                        $genre_drop = "false";
                        <br><br>
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <strong>Artist List</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        (dans le mode Genre/Artiste/Album ou Artiste/Album) vous pouvez
                        désactiver la liste déroulante d'artiste si vous voulez. Cela peut
                        être fait durant l'installation, ou en éditant le fichier
                        settings.php:<br><br>
                        $artist_drop = "false";
                        <br><br>
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <strong>Album List</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        (tous les modes) vous pouvez
                        désactiver la liste déroulante d'album si vous voulez. Cela peut
                        être fait durant l'installation, ou en éditant le fichier
                        settings.php:<br><br>
                        $album_drop = "false";
                        <br><br>
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <strong>Liste de pistes</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        (tous les modes) vous pouvez activer (elle est désactivé par défaut)
                        la liste déroulante de piste si vous voulez.
                        Cela peut être fait durant l'installation, ou en éditant le fichier
                        settings.php:<br><br>
                        $song_drop = "false";
                        <br><br>
                        <strong>NOTE:</strong> Pour un gros site, cela peut être INCROYABLEMENT
                        lent. En effet, Jinzora doit lire et générer une liste de toutes les
                        pistes, cela peut prendre une éternité. S'il vous plaît, utilisez
                        cette option seulement sur des petits sites, et en connaissance de cause.
                        <br><br>
                        <br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

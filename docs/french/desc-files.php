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

        <td width="100%" class="bodyBody"><strong>Fichiers de description</strong>
            <br>
            <br>
            Vous pouvez ins&eacute;rer en plusieurs endroits des descriptions pour certains
            &eacute;l&eacute;ments.<br>
            Les voici: <br>
            <br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>

                    <td width="30%" valign="top" class="bodyBody"><strong>Genre/Artiste</strong></td>

                    <td width="70%" class="bodyBody"> Au niveau des Genres/artistes Jinzora
                        peut afficher juste en dessous une description pour chacun d'entre
                        eux. Par exemple:<br>
                        <br>
                        <img src="images/genre-desc.gif?<?php echo time(); ?>">
                        <br><br>
                        Pour activer cette fonction cr&eacute;ez simplement un fichier texte
                        brut nomm&eacute; Genre.txt (ou Artiste.txt) au MEME niveau de l'arborescence
                        que notre dossier (il doit avoir exactement le m&ecirc;me nom que
                        le dossier; faites attention aux majuscules et minuscules, le script
                        est sensoble &agrave; la casse). Lorsque Jinzora d&eacute;tecte un
                        tel fichier il affichera son contenu ici m&ecirc;me.<br>
                    </td>
                </tr>
                <tr>

                    <td width="30%" valign="top" class="bodyBody"><strong>Description d'une
                            sous cat&eacute;gorie</strong></td>

                    <td width="70%" class="bodyBody"><p>Si vous le d&eacute;sirez, lors
                            de la consultation du contenu d'une sous cat&eacute;gorie (un clic
                            sur la cat&eacute;gorie principale liste de tous les sous genres
                            ou artistes) vous pouvez ajouter une image et une description dans
                            la partie sup&eacute;rieure de la page, tel que:<br>
                            <br>
                            <img src="images/genre-sub-desc.gif?<?php echo time(); ?>">
                            <br>
                            <br>
                            Pour activer cette fonction cr&eacute;ez simplement un fichier texte
                            brut .txt et une image .jpg avec le libell&eacute; EXACT du genre
                            pour lesquels ils doivent appara&icirc;tre, et doivent &ecirc;tre
                            plac&eacute;s dans le dossier &quot;Genres&quot; (au cot&eacute;
                            des dossiers des diff&eacute;rents artistes). Le texte de description
                            sera affich&eacute; ici.</p>
                        <br>
                    </td>
                </tr>
                <tr>

                    <td width="30%" valign="top" class="bodyBody"><strong>Vue d'albums</strong></td>

                    <td width="70%" class="bodyBody">Dans la vue des albums, vous pouvez
                        rajouter un fichier qui donnera la description d'un artiste en particulier:<br>
                        <br>
                        <img src="images/artist-desc.gif?<?php echo time(); ?>">
                        <br><br>
                        La m&eacute;thode est la m&ecirc;me que d&eacute;crite ci-dessus,
                        cependant avec une variable. Le fichier doit &ecirc;tre plac&eacute;
                        dans le dossier de l'artiste, au m&ecirc;me niveau que les dossiers
                        des albums. Cr&eacute;ez un fichier appel&eacute; Artist.txt (il doit
                        avoir exactement le m&ecirc;me nom que le dossier; faites attention
                        aux majuscules et minuscules, le script est sensoble &agrave; la casse).
                        Lorsque Jinzora d&eacute;tecte un tel fichier il affichera son contenu
                        ici m&ecirc;me.<br>
                    </td>
                </tr>
                <tr>

                    <td width="30%" valign="top" class="bodyBody"><strong>Vue des pistes:<br>
                            Description d'albums</strong></td>

                    <td width="70%" class="bodyBody"><p>Dans la vue des pistes vous pouvez
                            &eacute;galement inclure une description de l'album dont vous &ecirc;tes
                            en train de consulter la fiche:<br>
                            <br>
                            <img src="images/album-desc.gif?<?php echo time(); ?>">
                            <br>
                            <br>
                            Vous aurez ici besoin de cr&eacute;er un fichier album-desc.txt
                            &agrave; l'INTERIEUR du dossier contenant l'album. Lor+sque Jinzora
                            d&eacute;tecte un tel fichier il affichera son contenu dans la zone
                            centrale sup&eacute;rieure de la page.<br>
                            <br>
                            Il y a quelques variables que vous pouvez utiliser &agrave; cet
                            endroit pr&eacute;cis, elles sont:<br>
                            <br>
                            <strong>ARTIST_NAME</strong> Lorsque vous utilisez cette variable
                            dans votre fichier de description, il sera remplac&eacute; par le
                            nom de l'artiste que vous consultez. <br>
                            <br>
                            <strong>ALBUM_NAME</strong> Lorsque vous utilisez cette variable
                            dans votre fichier de description, il sera remplac&eacute; par le
                            nom de l'album que vous consultez. <br>
                            <br>
                            <br>
                        </p></td>
                </tr>
                <tr>

                    <td width="30%" valign="top" class="bodyBody"><strong>Vue des pistes:<br>
                            Description des pistes</strong></td>

                    <td width="70%" class="bodyBody"> Dans la vue des pistes vous pouvez
                        &eacute;galement inclure une description &quot;individuelle&quot;
                        pour chaque piste:<br>
                        <br>
                        <img src="images/track-desc.gif?<?php echo time(); ?>">
                        <br><br>
                        Il existe deux mani&egrave;res d'afficher cette information:<br>
                        <br>
                        1. En utilisant le commentaire inclus dans le Tag ID3 de votre fichier
                        .mp3. Bien que ceci soit relativement limit&eacute; &agrave; cause
                        du nombre restreint de caract&egrave;res contenus dans ce type de
                        &quot;Tag&quot;, on peut n&eacute;amoins l'utiliser ici.<br>
                        <br>
                        2. En utilisant un fichier de description (nom_de_la_piste.txt). Il
                        doit &ecirc;tre nomm&eacute; EXACTEMENT de la m&ecirc;me fa&ccedil;on
                        que votre fichier .mp3, y compris la casse (MajuscULe - miNIScuLE).
                        Si ce fichier existe et que la lecture du Tag ID3 est aussi sp&eacute;cifi&eacute;e
                        dans le fichier de configuration, il sera affich&eacute; en priorit&eacute;.<br>
                        <br><br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

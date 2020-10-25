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

        <td width="100%" class="bodyBody"><strong>Pochettes d'albums</strong> <br>
            <br>
            Jinzora peut effectuer de nombreuses choses avec les pochettes d'albums.
            <br>
            En voici une liste:
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <strong>Affichage</strong>
                    </td>

                    <td width="70%" class="bodyBody">
                        <div align="justify">Jinzora peut afficher
                            les pochettes des albums pr&eacute;sents dans votre collection.
                            Pour rendre cela possible, les conditions sont simples. Tout ce
                            que vous avez &agrave; faire est de mettre l'image dans le dossier
                            contenant vos fichiers musicaux. Quand Jinzora parcourt un tel dossier
                            (contenant m&eacute;dias sonores et images) il consid&eacute;rera
                            la premi&egrave;re des images comme &eacute;tant la pochette de
                            l'album, dans cette vue comme dans le reste du programme.<br>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <strong>Recherches</strong>
                    </td>

                    <td width="70%" class="bodyBody">
                        <div align="justify">Il existe quelques
                            moyens dont dispose Jinzora pour vous aider &agrave; trouver des
                            images, vous permettant ainsi d'ajouter facilement des pochettes.
                            Les voici:<br>
                            <br>
                        </div>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="1%" valign="top" class="bodyBody">
                                    <li>&nbsp;</li>
                                </td>

                                <td width="99%" class="bodyBody">
                                    <div align="justify"><strong>Par
                                            album</strong> <br>
                                        Lorsque vous consultez une fiche d'album ne comportant aucune
                                        image, vous pouvez cliquer sur le lien &quot;Rechercher une
                                        pochette d'album&quot; dans le coin haut gauche de Jinzora.<br>
                                        <br>
                                        <strong>NOTE:</strong> Vous devez &ecirc;tre loggu&eacute;
                                        avec des droits d'administrateur pour voir appara&icirc;tre
                                        ce lien.<br>
                                        <br>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" valign="top" class="bodyBody">
                                    <li>&nbsp;</li>
                                </td>

                                <td width="99%" class="bodyBody"><p align="justify"><strong>Recherches
                                            automatiques</strong> <br>
                                        Si vous les activez ($auto_search_art = "true"; in settings.php)
                                        Jinzora recherchera automatiquement les pochettes (manquantes?)
                                        lors de la consultation de la fiche de l'artiste concern&eacute;.
                                        Il t&eacute;l&eacute;chargera la premi&egrave;re image correspondant
                                        &agrave; la premi&egrave;re r&eacute;ponse &agrave; sa requ&ecirc;te.
                                        Vous pourrez ensuite facilement utiliser le lien &quot;Changer
                                        l'image&quot; situ&eacute; sous l'album (ou sur la page des
                                        pistes) pour vous permettre de choisir une autre pochette.<br>
                                        <br>
                                        NOTE: Lorsque Jinzora ne peut trouver de r&eacute;ponse ad&eacute;quate,
                                        il g&eacute;n&egrave;rera pour vous une image avec le titre
                                        de l'album. </p>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" valign="top" class="bodyBody">
                                    <li>&nbsp;</li>
                                </td>

                                <td width="99%" class="bodyBody">
                                    <div align="justify">
                                        <p><strong>Utilisation du panel d'administration</strong></p>
                                        <p>Si vous le d&eacute;sirez, vous avez la possibilit&eacute;
                                            d'utiliser la fonction &quot;Rechercher les pochettes manquantes&quot;
                                            dans la page administration de Jinzora qui vous permet de
                                            parcourir chaque album de votre collection. L'op&eacute;ration
                                            pourrait demander un certain temps pour une collection cons&eacute;quente,
                                            alors que pour une plus petite vous avez la possibilit&eacute;
                                            de choisir les pochettes d'albums voulues une &agrave; une
                                            dans un laps de temps restreint.<br>
                                            <br>
                                            NOTE: Lorsque Jinzora ne peut trouver de r&eacute;ponse
                                            ad&eacute;quate, il g&eacute;n&egrave;rera pour vous une
                                            image avec le titre de l'album.<br>
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

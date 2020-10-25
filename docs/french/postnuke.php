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
            <strong><strong>Installation</strong> dans Postnuke</strong><br>
            <br>
            Installer Jinzora tout seul est de loin l'installation la plus simple. Nous recommandons de commencer avec ce type d'installation m&ecirc;me si vous envisagez de l'int&eacute;grer par la suite &agrave; un CMS (m&ecirc;me si le mode integr&eacute; devrait parfaitement fonctionner). <br>
            <br>
            ...si vous vous sentez d'attaque on continue! <br>
            <br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="40%" class="bodyBody" valign="top">
                        <li><strong>T&eacute;l&eacute;charger</strong></li>
                    </td>
                    <td width="60%" class="bodyBody">
                        Ca &agrave; l'air tout simple, mais mieux vaut r&eacute;capituler depuis le d&eacute;but. Vous devez en premier lieu t&eacute;l&eacute;charger Jinzora. Vous le trouverez sur:<br>
                        <br>
                        <a href="http://www.jinzora.org/modules.php?op=modload&name=Downloads&file=index" target="_blank">la page de t&eacute;l&eacute;chargement de Jinzora</a><br>
                        <br>
                        Nous vous conseillons de cr&eacute;er un dossier "jinzora" dans lequel vous d&eacute;poserez l'archive t&eacute;l&eacute;charg&eacute;e et dans lequel vous la d&eacute;compresserez par la suite.<br>
                        <br><br><br></td>
                </tr>
                <tr>
                    <td width="40%" class="bodyBody" valign="top">
                        <li><strong>Extraire</strong></li>
                    </td>
                    <td width="60%" class="bodyBody">
                        Une fois Jinzora t&eacute;l&eacute;charg&eacute; vous devrez extraire puis transf&eacute;rer le contenu sur votre serveur. <br>
                        <br>
                        <strong>Windows:</strong>Sur Windows nous recommandons l'usage de <a href="http://www.winzip.com" target="_blank">Winzip</a> pour extraire vos fichiers .zip (en consid&eacute;rant que vous aurez t&eacute;l&eacute;charg&eacute; un fichier zipp&eacute;). <br>
                        <br>
                        <strong>*NIX:</strong>Sous *NIX vous devrez lancer un: <code>tar -zxvf jinzora-X.X.tar.gz</code> (ou X.X est le num&eacute;ro de version) pour extraire Jinzora dans le dossier courant (note: Jinzora ne cr&eacute;era PAS de sous-dossier) <br>
                        <br>
                        <strong>NOTE:</strong>Ce dossier DOIT &ecirc;tre plac&eacute; dans le dossier /modules de votre PHPNuke. <br>
                        <br><br><br></td>
                </tr>
                <tr>
                    <td width="40%" class="bodyBody" valign="top">
                        <li><strong>Pr&eacute;parer</strong></li>
                    </td>
                    <td width="60%" class="bodyBody">
                        <strong>Utilisateurs Windows:</strong>Vous devez &ecirc;tre S&Ucirc;RS que notre dossier Jinzora est plac&eacute; dans la racine de votre serveur web (c:\inetpub\www par d&eacute;faut). Les dossiers virtuels ne sont actuellement PAS support&eacute;s (leur support est pr&eacute;vu
                        pour les prochaines versions) Vous pouvez placer vos donn&eacute;es sur un disque diff&eacute;rent SI et UNIQUEMENT SI vous utilisez une partition NTFS (cf <a href="symlinking.php" target="Body">symlinking</a> dans &quot;Utiliser Jinzora&quot;) <br>
                        Vous devez aussi &ecirc;tre s&ucirc;r que votre serveur dispose au moins un acc&egrave;s en lecture sur le dossier dans lequel vous avez extrait (qui devrait l'&ecirc;tre &agrave; moins que vous n'ayez chang&eacute; quelque chose...) <br>
                        <br>
                        <strong>Utilisateurs *NIX:</strong> Pour faciliter l'installation de Jinzora (directement sur la machine ou par SSH) nous fournissons un script qui param&egrave;trera le n&eacute;cessaire pour l'installation de Jinzora. Executez tout simplement:<br>
                        <br>
                        # sh configure.sh <br>
                        <i>ou</i><br>
                        # ./configure<br>
                        <br>
                        dans le r&eacute;pertoire Jinzora. Ceci cr&eacute;era les fichiers n&eacute;cessaires et param&egrave;trera les droits des fichiers (en &eacute;criture, lecture et ex&eacute;cution) pour permettre l'installation via l'interface web (si vous ne disposez pas d'acc&egrave;s SSH
                        reportez vous au chapitre d&eacute;di&eacute; &agrave; <a href="ftp-only.php" target="Body">l'installation par FTP uniquement</a>) <br>
                        <br>
                        <br><br><br></td>
                </tr>
                <tr>
                    <td width="40%" class="bodyBody" valign="top">
                        <li><strong>Librairies GD</strong></li>
                    </td>
                    <td width="60%" class="bodyBody"> Pour profiter des fonctions de redimensionnement des images dans Jinzora vous aurez besoin des librairies d'image de <a href="http://www.boutell.com/gd/" target="_blank">Boutell.com</a>. Pour les installer (dans les grandes lignes) :<br>
                        <br>
                        <strong><strong><strong>Environnement</strong></strong> Windows:</strong> <br>
                        1. T&eacute;l&eacute;chargez la librairie depuis <a href="http://www.jinzora.org/modules.php?op=modload&name=Downloads&file=index&req=viewdownload&cid=4" target="_blank">notre site</a> (ou ailleurs sur le net...)<br>
                        <br>
                        2. D&eacute;zippez l'archive dans le m&ecirc;me dossier dans lequel PHP est install&eacute; (c:\php)<br>
                        <br>
                        3. Editez le fichier php.ini (g&eacute;n&eacute;ralement dans c:\winnt ou c:\windows) en modifiant la ligne:<br>
                        extension=php_gd2.dll (d&eacute;commentez en ENLEVANT le ; au d&eacute;but de la ligne) <br>
                        <br>
                        <strong><strong><strong>Environnement</strong></strong> *NIX:</strong> Ce pourrait &ecirc;tre un tantinet plus compliqu&eacute; sur *NIX, nous recommandons donc de suivre le guide de <a href="http://www.boutell.com/gd/manual2.0.15.html" target="_blank">Boutell.com</a> . <br>
                        <br><br></td>
                </tr>
                <tr>
                    <td width="40%" class="bodyBody" valign="top">
                        <li><strong>Liens Postnuke</strong></li>
                    </td>
                    <td width="60%" class="bodyBody"> Ok, vous allez maintenant cr&eacute;er les liens dans votre menu PHPNuke. Rien ne vous oblige &agrave; suivre cette &eacute;tape, mais la plupart des utilisateurs de Jinzora/PHPNuke le voudront. Pour ajouter le lien &agrave; votre bloc:<br>
                        <br>
                        Allez dans le panel administration<br>
                        Ensuite allez &agrave; "Administration"<br>
                        Cliquez sur "Blocks"<br>
                        Cliquez sur "View Blocks"<br>
                        Cliquez sur "Edit" pour le "Main Menu"<br>
                        Et ajoutez <br>
                        &nbsp;&nbsp;&nbsp;Title: "Jinzora"<br>
                        &nbsp;&nbsp;&nbsp;(ou le nom que vous voudrez donner &agrave; votre lien)<br>
                        <br>
                        &nbsp;&nbsp;&nbsp;URL: "[jinzora]"<br>
                        &nbsp;&nbsp;&nbsp;(ou le nom donn&eacute; au dossier o&ugrave; Jinzora a &eacute;t&eacute; install&eacute;)<br>
                        <br>
                        &nbsp;&nbsp;&nbsp;Description: "Jinzora Music"<br>
                        &nbsp;&nbsp;&nbsp;(ou ce qui vous plaira)<br>
                        <br>
                        <br>
                        Cliquez sur "Commit Changes" <br>
                        <br>
                        Et le lien vers Jinzora appara&icirc;tra dans votre menu PHPNuke <br>
                        <br>
                        Cliquez sur les liens r&eacute;cemment cr&eacute;es (vous pouvez poursuivre) <br>
                        <br><br><br></td>
                </tr>
                <tr>
                    <td width="40%" class="bodyBody" valign="top">
                        <li><strong>Installateur Web</strong></li>
                    </td>
                    <td width="60%" class="bodyBody">
                        Vous allez suivre la proc&eacute;dure d'installation via l'interface web. Elle sera document&eacute;e tout au long des diff&eacute;rentes pages, et les diff&eacute;rentes options vous seront expliqu&eacute;es. <br>
                        <br><br><br></td>
                </tr>
                <tr>
                    <td width="40%" class="bodyBody" valign="top">
                        <li><strong>Blocs Postnuke</strong></li>
                    </td>
                    <td width="60%" class="bodyBody">
                        Utiliser Jinzora dans un bloc PostNuke est relativement simple. Il affichera al&eacute;atoirement une image des albums (si des images sont disponibles dans vos dossiers) dans le bloc, accompagn&eacute; du nom de l'artiste et du nom de l'album. Vous pourrez cliquer sur ces
                        trois informations (Artiste, Album, Image). Les listes &quot;drop down&quot; du haut de page de Jinzora sont &eacute;galement disponibles, ce qui vous permet de g&eacute;n&eacute;rer tr&egrave;s rapidement des playlists.<br>
                        <br>
                        Actuellement les m&eacute;dias DOIVENT &ecirc;tre organis&eacute;s sous la forme Genre/Artiste/Album/Pistes, le support pour les autres arborescences viendra par la suite. Afin d'installer votre bloc suivez ces &eacute;tapes:
                        <br>
                        <br>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="1%" valign="top" class="bodyBody">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody"> Allez &agrave; la page "Administration".
                                    <br>
                                    <br></td>
                            </tr>
                            <tr>
                                <td width="1%" valign="top" class="bodyBody">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody">
                                    Cliquez sur "Block"
                                    <br> <br>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" valign="top" class="bodyBody">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody">
                                    Cliquez sur "New Block"
                                    <br>
                                    <br></td>
                            </tr>
                            <tr>
                                <td width="1%" valign="top" class="bodyBody">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody"> D&eacute;finissez un titre <br>
                                    (ce que vous voulez tant qu'il n'est pas trop long)<br>
                                    <br>
                                    Pour le type de bloc choisissez "Core/PHP Script"<br>
                                    <br>
                                    D&eacute;finissez "Position" &agrave; droite ou gauche <br>
                                    (du c&ocirc;t&eacute; o&ugrave; vous voudrez qu'apparaisse votre box)<br>
                                    <br>
                                    Choisissez le "Language" qui vous plaira <br>
                                    <br>
                                    Cliquez sur "Commit changes"<br>
                                    <br> <br></td>
                            </tr>
                            <tr>
                                <td width="1%" valign="top" class="bodyBody">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody">
                                    Laissez le reste des options par d&eacute;faut, et renseignez le champ "Content" par:<br>
                                    <br>
                                    require __DIR__ . '//jinzora/pnblock.php';<br>
                                    (soyez s&ucirc;rs qu'il s'agit du chemin ABSOLU, et pas relatif)
                                    <br>
                                    <br>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" valign="top" class="bodyBody">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody">
                                    Profitez de votre nouveau bloc!
                                    <br>
                                    <br></td>
                            </tr>
                        </table>
                        <br><br><br><br></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

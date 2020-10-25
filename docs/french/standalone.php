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
            <strong> Installation d'un Jinzora isol&eacute; </strong><br>
            <br>
            Installer Jinzora seul est de loin la m&eacute;thode la plus simple. C'est celle qui est recommand&eacute;e m&ecirc;me si vous envisagez de l'int&eacute;grer &agrave; un CMS (l'int&eacute;grer d&egrave;s le d&eacute;part devrait marcher parfaitement).
            <br>
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
                        <br><br><br></td>
                </tr>
                <tr>
                    <td width="40%" class="bodyBody" valign="top">
                        <li><strong>Librairies GD</strong></li>
                    </td>
                    <td width="60%" class="bodyBody">
                        Pour profiter des fonctions de redimensionnement des images dans Jinzora vous aurez besoin des librairies d'image de <a href="http://www.boutell.com/gd/" target="_blank">Boutell.com</a>. Pour les installer (dans les grandes lignes) :<br>
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
                        <br><br><br></td>
                </tr>
                <tr>
                    <td width="40%" class="bodyBody" valign="top">
                        <li><strong>Installateur Web</strong></li>
                    </td>
                    <td width="60%" class="bodyBody">
                        Vous allez suivre la proc&eacute;dure d'installation via l'interface web &agrave;: <br>
                        <br>
                        http://votresite/chemin/vers/jinzora/index.php<br>
                        <br> Elle sera document&eacute;e tout au long des diff&eacute;rentes pages, et les diff&eacute;rentes options vous seront expliqu&eacute;es.<br>
                        <br><br><br></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

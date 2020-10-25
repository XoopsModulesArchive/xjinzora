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
            <strong>Installation uniquement accessible par FTP</strong><br>
            <br>
            Ok, vous voulez donc installer Jinzora, mais ne disposez que d'un acc&egrave;s FTP &agrave; votre serveur. Bien que &ccedil;a ne nous facilite pas la t&acirc;che, &ccedil;a ne nous emp&ecirc;chera pas non plus d'arriver &agrave; nos fins. Si vous l'int&eacute;grez &agrave; un *Nuke
            veuillez D'ABORD lire cette page, car il ya quelques petites choses que vous devez faire AVANT de pointer votre navigateur sur l'installateur web dont on parle &agrave; la fin de ce guide.<br>
            <br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="40%" class="bodyBody" valign="top">
                        <li><strong>T&eacute;l&eacute;charger</strong></li>
                    </td>
                    <td width="60%" class="bodyBody">
                        Ca &agrave; l'air tout simple, mais mieux vaut r&eacute;capituler depuis le d&eacute;but. Vous devez en premier lieu t&eacute;l&eacute;charger Jinzora. Vous le trouverez sur:<br>
                        <br>
                        <a href="http://www.jinzora.org/modules.php?op=modload&name=Downloads&file=index" target="_blank">la page de t&eacute;l&eacute;chargement de Jinzora</a>
                        <br>
                        <br><br><br></td>
                </tr>
                <tr>
                    <td width="40%" class="bodyBody" valign="top">
                        <li><strong>Extraire</strong></li>
                    </td>
                    <td width="60%" class="bodyBody">
                        Une fois t&eacute;l&eacute;charg&eacute; vous devrez extraire l'archive sur votre ordinateur local, ce qui vous permettra ensuite d'uploader ces fichiers sur votre serveur via FTP.<br>
                        <br><br><br></td>
                </tr>
                <tr>
                    <td width="40%" class="bodyBody" valign="top">
                        <li><strong>Uploader</strong></li>
                    </td>
                    <td width="60%" class="bodyBody">
                        Ok, maintenant que vous avez t&eacute;l&eacute;charg&eacute; et d&eacute;compact&eacute; l'archive, connectez vous &agrave; votre serveur FTP distant. Ce petit guide vous d&eacute;crira l'op&eacute;ration avec le logiciel WS_FTP (mais tout autre client FTP fera aussi bien
                        l'affaire).<br>
                        <br>
                        Maintenant que vous &ecirc;tes logu&eacute; sur le serveur, vous allez cr&eacute;er un nouveau dossier dans lequel vous installerez Jinzora. S'il est install&eacute; seul cela n'a aucune importance. Si par contre vous l'int&eacute;grez &agrave; un *Nuke d&eacute;j&agrave; en
                        place, de dossier DOIT se trouver dans votre dossier /modules.<br>
                        <br>
                        Une fois votre nouveau dossier cr&eacute;&eacute;, vous allez y uploader tous les fichiers d&eacute;zipp&eacute;s. Une fois TOUS les fichiers plac&eacute;s vous &ecirc;tes enfin pr&ecirc;t &agrave; proc&eacute;der &agrave; l'installation proprement dite via l'interface
                        web.<br>
                        <br><br><br></td>
                </tr>
                <tr>
                    <td width="40%" class="bodyBody" valign="top">
                        <li><strong>Librairies GD</strong></li>
                    </td>
                    <td width="60%" class="bodyBody">
                        <strong>NOTE:</strong> Nous ne fournissons aucun support quant &agrave; l'installation des librairies GD via FTP. Nous incluons cette section uniquement pour rappeler que vous aurez besoin de GD.<br>
                        <br>
                        Pour profiter du redimensionnement des images dans Jinzora, vous aurez besoin des <a href="http://www.boutell.com/gd/" target="_blank"><a href="http://www.boutell.com/gd/" target="_blank"> <a href="http://www.boutell.com/gd/" target="_blank"></a><a
                                        href="http://www.boutell.com/gd/" target="_blank">librairies d'images </a>GD &agrave; disposition sur </a> Boutell.com</a>.
                        Pour les installer (TRES approximativement):<br>
                        <br>
                        <strong>environnement Windows:</strong>
                        <br>
                        1. T&eacute;l&eacute;chargez les librairies GD <a href="http://www.jinzora.org/modules.php?op=modload&name=Downloads&file=index&req=viewdownload&cid=4" target="_blank">sur notre site</a> (ou ailleurs sur le net...)<br>
                        <br>
                        2. D&eacute;zippez et placez les fichiers dans le m&ecirc;me dossier que celui o&ugrave; est d&eacute;j&agrave; install&eacute; PHP (c:\php)<br>
                        <br>
                        3. Editez le php.ini (g&eacute;n&eacute;ralement dans c:\winnt ou c:\windows) et modifiez la ligne suivante:<br>
                        extension=php_gd2.dll (d&eacute;commentez en ENLEVANT le ; au d&eacute;but de la ligne)
                        <br>
                        <br>
                        <strong><strong>environnement</strong> *NIX:</strong> Ce pourrait &ecirc;tre un tantinet plus compliqu&eacute; sur *NIX, nous recommandons donc de suivre le guide de <a href="http://www.boutell.com/gd/manual2.0.15.html" target="_blank">Boutell.com.</a><br>
                        <br><br></td>
                </tr>
                <tr>
                    <td width="40%" class="bodyBody" valign="top">
                        <li><strong>Installateur Web</strong></li>
                    </td>
                    <td width="60%" class="bodyBody">
                        Tout est fin pr&ecirc;t. Ouvrez votre navigateur favori et dirigez vous vers:<br>
                        <br>
                        http://votre_site/chemin/vers/jinzora/index.php<br>
                        <br>
                        Vous allez &ecirc;tre guid&eacute; &eacute;tape par &eacute;tape par l'installateur web. Toute la proc&eacute;dure est abondamment comment&eacute;e et vous d&eacute;crira chacune des options que vous rencontrerez.
                        <br>
                        <br>
                        Lorsque cette &eacute;tape s'ach&egrave;vera, un message vous demandera de sauvegarder le fichier settings.php ET le users.php. Une fois sur votre PC, vous les uploaderez via FTP dans le dossier dans lequel nous avons install&eacute; Jinzora. S'il s'agit d'une mise &agrave;
                        jour, remplacez les fichiers existants.<br>
                        <br>
                        Sur syst&egrave;mes *NIX vous devrez donner les doits ad&eacute;quats sur les dossiers &quot;music&quot; et &quot;temp&quot;. Vous le ferez en tapant les sommandes suivantes (client FTP en lignes de commande)<br>
                        <br>
                        chmod -R 777 music/ (ou le nom que vous aurez donn&eacute; &agrave; votre dossier)<br>
                        chmod -R 777 temp/
                        <br><br>
                        <strong>WS_FTP</strong><br>
                        Cliquez droit sur le dossier "music" et s&eacute;lectionnez "Properties"<br>
                        Changez la valeur num&eacute;rique &agrave; 777<br>
                        <br>
                        Cr&eacute;ez ensuite le dossier "temp" (s'il n'existe pas d&eacute;j&agrave;) en cliquant sur "MkDir" tout en &eacute;tant positionn&eacute; dans le dossier Jinzora. Remplissez le champ par "temp"<br>
                        Cliquez droit sur ce dossier"temp" et choisissez "Properties"<br>
                        Changez l&agrave; aussi la valeur num&eacute;rique &agrave; 777<br>
                        <br>
                        Bien qu'il y ait de nombreux moyens d'arriver &agrave; ce r&eacute;sultat, cette m&eacute;thode est certainement la plus simple et la plus rapide.<br>
                        <br><br><br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

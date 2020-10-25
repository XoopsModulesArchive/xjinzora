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
            <strong>Diffuser avec Shoutcast</strong><br>
            <br>
            Jinzora supporte les r&eacute;seaux Shoutcast, bien que cette fonction soit encore limit&eacute;e et amen&eacute;e &agrave; &eacute;voluer. Typiquement vous pouvez utiliser les playlists Jinzora comme des playlists Shoutcast, et arr&ecirc;ter/d&eacute;marrer le serveur Shoutcast depuis
            la page "Tools".
            <br>
            <br>
            <strong>Faire fonctionner Shoutcast</strong><br>
            <br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        Tout d'abord, installez et configurez Jinzora. Soyez s&ucirc;r que dans un premier temps tout marche SANS Shoutcast pour &eacute;viter de compliquer les choses...
                        <br>
                        <br></td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        Ok, maintenant que Jinzora marche parfaitement sans Shoutcast (c'est ce que vous avez fait, n'est-ce pas?) configurons-le. Vous trouverez un dossier &quot;shoutcast&quot; dans le dossier o&ugrave; a &eacute;t&eacute; install&eacute; Jinzora. Ce dossier contient tous les
                        fichiers n&eacute;cessaires &agrave; la bonne marche de Shoucast. Il est pr&eacute;vu que cette installation devienne automatis&eacute;e.
                        <br>
                        <br></td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <strong>sc_trans.conf</strong>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="1%" valign="top" class="bodyBody">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody">
                                    Playlistfile = /full/path/to/jinzora/shoutcast/shoutcast.lst
                                    <br>
                                    DOIT &ecirc;tre le chemin complet du fichier<br>
                                    <br>
                                    ServerIP = IP Address or DNS Name
                                    <br>
                                    Si vous streamez pour le public, le serveur doit &ecirc;tre accessible par internet<br>
                                    <br>
                                    ServerPort = XXXX (something like 8100)
                                    <br>
                                    Encore une fois, si vous streamez pour le public, ce port doit &ecirc;tre permis par votre firewall<br>
                                    <br>
                                    Password = XXXX
                                    <br>
                                    C'est le mot de passe utilis&eacute; par le transcoder pour se connecter au serveur Shoutcast<br>
                                    <br>
                                    StreamTitle = XXXX
                                    <br>
                                    Le nom que vous voulez donner au stream...
                                    <br>
                                    <br>
                                    StreamURL = XXXX
                                    <br>
                                    G&eacute;n&eacute;rallement le nom de votre site (ex: http://www.jinzora.org)
                                    <br>
                                    <br>
                                    Genre = XXXX
                                    <br>
                                    Ce que vous voulez...
                                    <br>
                                    <br>
                                    Bitrate = 128000
                                    <br>
                                    Le bitrate auquel le stream sera diffus&eacute; (cf le fichier pour des exemples)
                                    <br>
                                    <br>
                                    SampleRate = 44100
                                    <br>
                                    La fr&eacute;quence d'&eacute;chantillonnage du sample stream&eacute; (cf le fichier pour des exemples)<br>
                                    <br>
                                    Channels = 2
                                    <br>
                                    2 pour st&eacute;r&eacute;o, 1 pour mono
                                    <br>
                                    <br>
                                    Quality = 1
                                    <br>
                                    Qualit&eacute; d'encodage du stream
                                    <br>
                                    <br>
                                    CrossfadeMode = 0 / CrossfadeLength = 8000
                                    <br>
                                    Options de fondu audio (cf le fichier pour des exemples)<br>
                                    <br>
                                    Public=0
                                    <br>
                                    Si vous voulez rendre public le stream pour yp.shoutcast.net param&eacute;trer &agrave; 1
                                    <br>
                                    <br><br><br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <strong>start.sh</strong>
                        <br><br>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="1%" valign="top" class="bodyBody">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody">
                                    soyez s&ucirc;r que le chemin renseign&eacute; dans ce fichier est le chemin complet vers le dossier &quot;shoutcast&quot;.<br>
                                    NOTE: Il est pr&eacute;vu que ce soit automatis&eacute; dans un futur proche.<br>
                                    <br><br><br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <strong>sc_serv.conf</strong>
                        <br><br>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="1%" valign="top" class="bodyBody">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody">
                                    MaxUser = 4
                                    <br>
                                    Le nombre maximum d'utilisateurs pouvant lire simultan&eacute;ment le stream sur ce serveur<br>
                                    <br>
                                    Password = XXXX
                                    <br>
                                    Le m&ecirc;me mot de passe renseign&eacute; plus haut - TRES IMPORTANT
                                    <br>
                                    <br>
                                    PortBase = XXXX
                                    <br>
                                    Le m&ecirc;me Port choisi plus haut - TRES IMPORTANT
                                    <br>
                                    <br>
                                    SrcIP = X.X.X.X
                                    <br>
                                    Important uniquement si vous voulez diffuser le stream Shoutacst sur une adresse IP sp&eacute;cifique<br>
                                    <br><br><br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" valign="top" class="bodyBody">
                        Ca devrait fonctionner, profitez bien de votre stream!!!
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

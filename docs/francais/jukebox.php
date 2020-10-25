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
            <strong>Installation Jukebox</strong><br>
            <br><br>
            Le mode Jukebox est supporté seulement de 2 façons:<br>
            <li>XMMS (ou noxmms) sur les plateformes *NIX</li>
            <li>Winamp (avec le plugin httpQ) sur les plateformes Windows</li>
            <br><br>

            Rappelons également ce que ce guide n'est pas. Ce n'est pas un guide pour:
            <li>Installer Linux/Apache/PHP/Windows/IIS/etc</li>
            <li>Faire fonctionner l'Audio sur votre serveur</li>
            <li>Faire du <a href="http://www.ncausa.org/public/pages/index.cfm?pageid=71" target="_blank">bon café</a></li>
            <br><br>
            Nous considéreront que votre serveur peut jouer avec succès des médias au
            travers de sa carte son AVANT de continuer avec ce guide.
            <br><br>
            <strong>NOTE:</strong> (pour les serveurs *NIX) Rappelez-vous en essayant
            mpg123 (ou quoi que ce soit) devra être capable de marcher et jouer du
            son EN TANT qu'utilisateur du serveur web, puisque c'est comme ca que
            Jinzora interagira avec votre matériel audio.
            <br><br><br><br>
            <strong>Paramétrage sous *NIX</strong><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><strong>No-XMMS</strong></li>
                    </td>
                    <td width="70%" class="bodyBody">
                        Il y a 2 manières possibles de faire fonctionner le mode Jukebox,
                        soit avec XMMS, soit avec noxmms.
                        Nous recommandons FORTEMENT noxmms, puisque vous n'aurez pas besoin
                        de X pour l'utiliser (et donc vous pouvez le faire marcher comme
                        une sorte de daemon). Nous devons donc premièrement télécharger
                        noxmms et l'installer.
                        <br><br>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Télécharger et installer noxmms
                                    <br><br>
                                    La première chose dont vous aurez besoin et de trouver
                                    et installer noxmms. Vous êtes tout à fait libre
                                    d'utiliser XMMS, mais je suppose que si vous
                                    l'utiliser, vous savez comment et vous pouvez sauter
                                    cette étape. Même si vous planifiez l'utilisation
                                    d'XMMS, vous devriez vraiment pensez à utiliser noxmms
                                    à la place, en effet c'est vraiment plus facile car
                                    votre ordinateur n'a pas besoin d'avoir X lancé. Ok,
                                    assez de ça, téléchargez simplement noxmms depuis:
                                    <br><br>
                                    <a href="http://www.jinzora.org/modules.php?op=modload&name=Downloads&file=index&req=viewdownload&cid=5" target="_blank">Télécharger No-XMMS</a>
                                    <br><br>
                                    Une fois que vous l'avez téléchargé, vous devrez
                                    l'extraire et le compiler. Bine que ce guide ne
                                    soit d'aucune manière destiné à être une référence
                                    sur la compilation, généralement, vous devrez faire:
                                    <br><br>
                                    <li>tar -zxvf noxmms-1.2.7.tar.gz</li>
                                    <li>cd noxmms-1.2.7</li>
                                    <li>sh configure --prefix=/usr/local (cela peut
                                        être n'importe quel répertoire)
                                    </li>
                                    <li>make (peut prendre un moment, vous souvenez-vous
                                        de ce liens sur le café???)
                                    </li>
                                    <li>make install (rappelez-vous de faire ça sous un
                                        compte avec les bonnes permissions - comme root)
                                    </li>
                                    <br><br>
                                    Une fois que vous l'avez compilé et installé avec succés,
                                    pour un test simple, tapez:
                                    <li>noxmms</li>
                                    Et assurez-vous qu'il n'y a aucune erreur (il devrait
                                    juste attendre et ne rien faire). Après quelques
                                    secondes, pressez juste controle-C pour sortir et
                                    procédez à l'étape suivante.
                                    <br>
                                    <strong>NOTE:</strong> Vous ne POUREZ PAS
                                    installer XMMS-Shell si vous n'avez pas terminé ceci
                                    avec succès!
                                    <br><br>
                                </td>
                            </tr>
                        </table>
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><strong>XMMS-Shell</strong></li>
                    </td>
                    <td width="70%" class="bodyBody">
                        Maintenant que vous avez XMMS (ou mieux noxmms) installé et
                        fonctionnel, nous devons avoir XMMS-Shell disponible pour que
                        Jinzora puisse contrôler XMMS.
                        <br><br>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Télécharger et Installer XMMS-Shell
                                    <br><br>
                                    Vous aurez tout d'abord besoin de télécharger XMMS-Shell:
                                    <br><br>
                                    <a href="http://sourceforge.net/project/showfiles.php?group_id=5632&package_id=5689&release_id=117891" target="_blank">Télécharger XMMS-Shell</a><br>
                                    (nous testons et utilisons xmms-shell-0.99.3)
                                    <br><br>
                                    Une fois que vous l'avez téléchargé, vous aurez
                                    besoin de l'extraire et de le compiler:
                                    <li>tar -zxvf xmms-shell-0.99.3.tar.gz</li>
                                    <li>cd xmms-shell-0.99.3</li>
                                    <li>ln -s /usr/local/bin/noxmms-config
                                        /usr/bin/xmms-config (puisque nous n'avons pas
                                        XMMS installé)
                                    </li>
                                    <li>Vérifier les permissions sur ce fichier pour
                                        être sur qu'il puisse être lu
                                    </li>
                                    <li>sh configure</li>
                                    <li>make</li>
                                    <li>make install (rappelez-vous de faire ça sous un
                                        compte avec les bonnes permissions - comme root)
                                    </li>
                                </td>
                            </tr>
                        </table>
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><strong>Permissions</strong></li>
                    </td>
                    <td width="70%" class="bodyBody">
                        Ok, maintenant que vous avez tout et que tout est compilé
                        (amusant, hein?) vous devez paramètrer toutes les permissions
                        pour que le serveur web puisse controller XMMS.<br><br>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">

                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Ok, donc mettons quelques permissions!
                                    <br><br>
                                    <li>chmod a+s /usr/local/bin/xmms-shell (ou n'importe
                                        quel endroit ou vous l'avez installé)
                                    </li>
                                    <br>
                                    Ensuite, vous devez faire un lien symbolique sur
                                    le tunnel que XMMS et XMMS-Shell utilisent, pour
                                    que XMMS-Shell puisse communiquer comme s'il était
                                    root (ne vous inquiétez pas, ce n'est pas réellement
                                    root, nous devons juste faire semblant)
                                    <br><br>
                                    <li>ln -s /tmp/xmms_XXXXX.0 /tmp/xmms_root.0 (ou
                                        XXXXX est l'utilisateur utilisé par votre serveur web)
                                    </li>
                                </td>
                            </tr>
                        </table>
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><strong>Lancement de noxmms au demmarage</strong></li>
                    </td>
                    <td width="70%" class="bodyBody">
                        Ok, ensuite nous devons lancer noxmms au démarrage sous
                        le même utilisateur que le serveur web. Nous avons écrit un
                        petit script d'initialisation que nous utilisons pour démarrer
                        ca pour nous. Nous utilisons ce script sur Slackware 9.1 et
                        nous ne sommes pas sur qu'il fonctionnera sur toutes les
                        distributions de Linux.
                        <br><br>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">

                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    <a href="" target="_blank">Télécharger le script de lancement</a>
                                    <br><br>
                                    Une fois que vous avez le script (ou que vous l'avez fait vous même), vous devez démarrer noxmms (souvenez-vous qu'il DOIT fonctionner sous le même utilisateur que le serveur web). Une fois qu'il est en marche, vous devriez pouvoir entrer dans Jinzora (vous DEVEZ
                                    être administrateur pour voir les contrôles du Jukebox) et commencer à jouer de la musique (en admettant que vous ayez choisis "Jukebox Mode" comme type d'installation. Cliquez sur lecture, et vous devriez être bon!
                                </td>
                            </tr>
                        </table>
                        <br><br><br><br>
                    </td>
                </tr>
            </table>
            <br><br><br><br>
            <strong>Paramétrage sous Windows</strong>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><strong>Winamp</strong></li>
                    </td>
                    <td width="70%" class="bodyBody">
                        C'est plutôt simple, vous devez juste avoir Winamp installé. Notez que seul Winamp 2.x est supporté pour le moment, car le plugin httpQ semble instable avec Winamp 5.x. Vous pouvez obtenir une ancienne version de winamp depuis notre site web à <a href="www.jinzora.org">www.jinzora.org</a>.
                        Si nous ne sommes pas autorisés à distribuer ça, nous sommes désolés, faites le nous simplement savoir... <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><strong>Plugin httpQ</strong></li>
                    </td>
                    <td width="70%" class="bodyBody">
                        Maintenant que Winamp est installé, vous devez installer le plugin httpQ pour Winamp. Il peut également être téléchargé depuis nos serveurs à <a href="www.jinzora.org">www.jinzora.org</a> Une fois que vous l'avez, installez le simplement. Une fois installé, vous aurez besoin
                        de le configurer: <br>
                        <li>Ouvrez Winamp</li>
                        <li>Tapez "Ctrl - P" pour ouvrir les "Preferences"</li>
                        <li>Cliquez sur "Plug-ins" "General Purpose"</li>
                        <li>Sélectionnez "Winamp httpQ Plugin Version 2.1" et cliquez sur "Configure"</li>
                        <li>Entrez un mot de passe, Adresse IP (nous recommandons 0.0.0.0), et un Port TCP (nous recommendons 4800)</li>
                        <li>Cochez "Start Service Automatically"</li>
                        <li>Cliquez sur "Start"</li>
                        <br><br>
                        Faites attention à rester loggué et laisser tourner Winamp, pour que Jinzora puisse le contrôler :-)

                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><strong>Paramétrage de Jinzora</strong></li>
                    </td>
                    <td width="70%" class="bodyBody">
                        Maintenant que Winamp est en marche (et httpQ est installé), tout ce dont vous avez besoin est de vous assurer que Jinzora est correctement paramètré pour communiquer avec lui. Dans settings.php, vérifiez que les réglages suivants sont corrects:<br><br>

                        $jukebox = "winamp";<br>
                        $jukebox_pass = "jinzora"; (ou le mot de passe que vous avez configuré dans httpQ)<br>
                        $jukebox_port = "4800"; (ou le port que vous avez configuré dans httpQ)<br>
                        <br><br>
                        Cela doit être tout! Appréciez le support du jukebox sous Windows!!!
                        <br><br><br><br>
                    </td>
                </tr>
                <br><br><br><br>
            </table>
        </td>
    </tr>
</table>
</body>

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
            <strong>Installation avec le CMS Mambo</strong><br>
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><strong>Téléchargement</strong></li>
                    </td>
                    <td width="70%" class="bodyBody">
                        Cela semble plutôt facile, mais il vaut mieux le rappeler. Vous devez d'abord télécharger Jinzora.
                        You can get Jinzora from the following<br><br>
                        <a href="http://www.jinzora.org/modules.php?op=modload&name=Downloads&file=index" target="_blank">Page de téléchargement de Jinzora</a>
                        <br><br>
                        Nous suggerons que vous créiez un répertoire "jinzora" pour sauvegrader ce fichier pour l'extraire ensuite.
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><strong>Extraction</strong></li>
                    </td>
                    <td width="70%" class="bodyBody">
                        Une fois que vous avez téléchargé Jinzora, vous devez l'extraire sur votre serveur web. Merci de l'extraire dans un endroit accessible par Mambo (ne PAS l'extraire dans votre répertoire "components")
                        <br><br>
                        <strong>Windows:</strong> Sous Windows nous recommandons l'usage de <a href="http://www.winzip.com" target="_blank">Winzip</a> pour extraire le fichier .zip téléchargé.
                        <br><br>
                        <strong>*NIX:</strong> Sous *NIX vous devrez taper: tar -zxvf jinzora-X.X.tar.gz (où X.X est le numéro de version) pour extraire Jinzora dans le répertoire courant (note: Jinzora ne créera PAS de sous-répertoire)
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><strong>Installation</strong></li>
                    </td>
                    <td width="70%" class="bodyBody">
                        Une fois que vous avez extrait Jinzora vous devrez aller à la page d'administration de Mambo
                        <br><br>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Cliquez sur "Components - Install/Uninstall"
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Dans "Install from directory" naviguez à l'endroit sur votre serveur où vous avez extrait Jinzora.
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Cliquez sur "Install"
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Copiez maintenant TOUS les fichiers extraits de Jinzora dans le nouveau répertoire "com_jinzora" qui à été créé dans le répertoire "components" de votre installation de Mambo (remplacer tous les fichiers si on vous le demande). <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Dans la page d'administration de Mambo cliquez sur "Site - Menu Manager - Main Menu"
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Cliquer sur "New" (en haut de la page)
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Selectionnez "MOS Component" et cliquez sur "Next"
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Choisissez un nom (en gal Jinzora)<br>
                                    Selectionnez "Jinzora" pour le "Component"<br>
                                    clicquez sur "Save"
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Clicquez sur le "X" sous "Published" pour publier Jinzora dans le menu principal
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Clicquez sur l'élément de menu pour "Jinzora" (ou le nom que vous lui avez donné) -
                                    Vous allez maintenant être dirigé vers l'installeur de Jinzora -
                                    Choisissez votre language et cliquez sur Suivant
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Suivez la procédure d'installation, elle est documentée.
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Une fois que l'installeur a fini, vérifiez les permissions sur les répertoires "data" et "temp" (dans le répertoire de Jinzora)<br>
                                    <strong>NOTE:</strong> Valable seulement pour les systèmes non-Windows<br><br>
                                    Faire:<br><br>
                                    chmod 777 data<br>
                                    chmod 777 temp<br>
                                    <br>
                                    Devrait être tout ce que vous avez à faire.
                                    <br><br>
                                    A la toute fin l'installeur créera deux fichiers pour vous. Les fichiers settings.php et users.php seront générés, et si possible, ecris sur le serveur pour vous. Si l'installeur ne peut pas ecrire ces fichiers, vous pourez les télécharger manuellement. Vous
                                    devrez alors envoyer ces deux fichiers dans le répertoire racine de l'installation de Jinzora. Une fois que vous avez envoyé ces fichiers, vous pourez aller à la page d'index de Jinzora.
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Profitez de Jinzora dans Mambo!!!
                                    <br><br>
                                </td>
                            </tr>
                        </table>
                        <br><br><br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* JINZORA | Web-based Media Streamer
*
* Jinzora is a Web-based media streamer, primarily desgined to stream MP3s
* (but can be used for any media file that can stream from HTTP).
* Jinzora can be integrated into a PostNuke site, run as a standalone application,
* or integrated into any PHP website.  It is released under the GNU GPL.
*
* Jinzora Author:
* Ross Carlson: ross@jasbone.com
* http://www.jinzora.org
* Documentation: http://www.jinzora.org/docs
* Support: http://www.jinzora.org/forum
* Downloads: http://www.jinzora.org/downloads
* License: GNU GPL <http://www.gnu.org/copyleft/gpl.html>
*
* Contributors:
* Please see http://www.jinzora.org/modules.php?op=modload&name=jz_whois&file=index
*
* Code Purpose: This page contains the English translation of the left navigation
* Created: 11.15.03 by Ross Carlson
*
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

// Let's modify the include path for Jinzora
ini_set('include_path', '.');

// Let's include the main, user settings file
require_once dirname(__DIR__) . '/settings.php';
require_once dirname(__DIR__) . '/system.php';

?>
<script type="text/javascript">
    <!--//
    function showHideCon(id, ln) {
        var bSB = false;
        var oContent = document.getElementById(id + "Content");
        var oDisplay = document.getElementById(name + "Display");

        if (!oContent) return;
        if (ln != "yes" && !oDisplay) return;

        bOn = (oContent.style.display.toLowerCase() == "none");

        if (bOn === false) {
            oContent.style.display = "none";
            document.showhideForm.songDisplay.value = "<?php echo $word_show_tracks; ?>";
        } else {
            oContent.style.display = "";
            document.showhideForm.songDisplay.value = "<?php echo $word_hide_tracks; ?>";
        }
    }

    //-->
</script>

<table width="100%" cellpadding="0" cellspacing="0" border="0" class="leftNavBody">
    <tr>
        <td width="100%" class="leftNavBody">
            <strong>Sommaire</strong>
        </td>
    </tr>
    <tr>
        <td width="100%" class="leftNavBody"><br></td>
    </tr>
    <tr>
        <td width="100%" class="leftNavBody">
            <img src="../style/images/plus.gif">
            <a href="#" onclick="showHideCon('requirements','yes');">Prérequis</a>
            <div id=requirementsContent style="display: none;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="leftNavBody">
                    <tr>
                        <td width="10" class="leftNavBody">&nbsp;&nbsp;</td>
                        <td width="100%" class="leftNavBody">
                            <li><a href="<?php echo $lang_file; ?>/unix-req.php" target="Body">Utilisateurs *NIX</a></li>
                            <li><a href="<?php echo $lang_file; ?>/windows-req.php" target="Body">Utilisateurs Windows</a></li>
                            <li><a href="<?php echo $lang_file; ?>/known-working.php" target="Body">Configuration requise</a></li>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
    <tr>
        <td width="100%" class="leftNavBody"><br></td>
    </tr>
    <tr>
        <td width="100%" class="leftNavBody">
            <img src="../style/images/plus.gif">
            <a href="#" onclick="showHideCon('installing','yes');">Installer Jinzora</a>
            <div id=installingContent style="display: none;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="leftNavBody">
                    <tr>
                        <td width="10" class="leftNavBody">&nbsp;&nbsp;</td>
                        <td width="100%" class="leftNavBody">
                            <li><a href="<?php echo $lang_file; ?>/standalone.php" target="Body">Autonome</a></li>
                            <li><a href="<?php echo $lang_file; ?>/postnuke.php" target="Body">Postnuke</a></li>
                            <li><a href="<?php echo $lang_file; ?>/phpnuke.php" target="Body">PHPNuke/NSNNuke</a></li>
                            <li><a href="<?php echo $lang_file; ?>/mambo.php" target="Body">Mambo</a></li>
                            <li><a href="<?php echo $lang_file; ?>/ftponly.php" target="Body">Par FTP seulement</a></li>
                            <li><a href="<?php echo $lang_file; ?>/jukebox.php" target="Body">Mode Jukebox</a></li>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
    <tr>
        <td width="100%" class="leftNavBody"><br></td>
    </tr>
    <tr>
        <td width="100%" class="leftNavBody">
            <img src="../style/images/plus.gif">
            <a href="#" onclick="showHideCon('upgrading','yes');">Mise à jour</a>
            <div id=upgradingContent style="display: none;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="leftNavBody">
                    <tr>
                        <td width="10" class="leftNavBody">&nbsp;&nbsp;</td>
                        <td width="100%" class="leftNavBody">
                            <li><a href="<?php echo $lang_file; ?>/unix-upgrade.php" target="Body">*NIX</a></li>
                            <li><a href="<?php echo $lang_file; ?>/windows-upgrade.php" target="Body">Windows</a></li>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
    <tr>
        <td width="100%" class="leftNavBody"><br></td>
    </tr>
    <tr>
        <td width="100%" class="leftNavBody">
            <img src="../style/images/plus.gif">
            <a href="#" onclick="showHideCon('using','yes');">Utiliser Jinzora</a>
            <div id=usingContent style="display: none;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="leftNavBody">
                    <tr>
                        <td width="10" class="leftNavBody">&nbsp;&nbsp;</td>
                        <td width="100%" class="leftNavBody">
                            <br>
                            <img src="../style/images/plus.gif">
                            <a href="#" onclick="showHideCon('displayIssues','yes');">Affichage des éléments</a>
                            <div id=displayIssuesContent style="display: none;">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="leftNavBody">
                                    <tr>
                                        <td width="10" class="leftNavBody">&nbsp;&nbsp;</td>
                                        <td width="100%" class="leftNavBody">
                                            <li><a href="<?php echo $lang_file; ?>/album-art.php" target="Body">Image d'album</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/desc-files.php" target="Body">Descriptions</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/excluding.php" target="Body">Exclusion d'éléments</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/fake-tracks.php" target="Body">Fausses pistes</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/hidingtracks.php" target="Body">Pistes cachées</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/lyrics.php" target="Body">Paroles</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/sorting-year.php" target="Body">Trier par année</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/truncate.php" target="Body">Raccourcir des éléments</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/the-header.php" target="Body">L'en-tête</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/themes.php" target="Body">Thèmes</a></li>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <br><br>
                            <img src="../style/images/plus.gif">
                            <a href="#" onclick="showHideCon('miscStuff','yes');">Divers</a>
                            <div id=miscStuffContent style="display: none;">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="leftNavBody">
                                    <tr>
                                        <td width="10" class="leftNavBody">&nbsp;&nbsp;</td>
                                        <td width="100%" class="leftNavBody">
                                            <li><a href="<?php echo $lang_file; ?>/file-cachine.php" target="Body">Cache</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/adding-media.php" target="Body">Ajouter du contenu</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/dir-structure.php" target="Body">Structure des répertoires</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/languages.php" target="Body">Langages</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/rss.php" target="Body">Diffusion "Newsfeed" RSS</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/securing.php" target="Body">Sécuriser Jinzora</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/symlinking.php" target="Body">Liens symboliques</a></li>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <br><br>
                            <img src="../style/images/plus.gif">
                            <a href="#" onclick="showHideCon('tools','yes');">Outils</a>
                            <div id=toolsContent style="display: none;">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="leftNavBody">
                                    <tr>
                                        <td width="10" class="leftNavBody">&nbsp;&nbsp;</td>
                                        <td width="100%" class="leftNavBody">
                                            <li><a href="<?php echo $lang_file; ?>/id3tagging.php" target="Body">Tags ID3</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/searching.php" target="Body">Recherche</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/user-access.php" target="Body">Gestion des utilisateurs</a></li>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <br><br>
                            <img src="../style/images/plus.gif">
                            <a href="#" onclick="showHideCon('playingMedia','yes');">Lecture</a>
                            <div id=playingMediaContent style="display: none;">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="leftNavBody">
                                    <tr>
                                        <td width="10" class="leftNavBody">&nbsp;&nbsp;</td>
                                        <td width="100%" class="leftNavBody">
                                            <li><a href="<?php echo $lang_file; ?>/html-playlists.php" target="Body">Listes de lecture HTML</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/media-players.php" target="Body">Lecteurs</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/media-types.php" target="Body">Types de media</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/playlists.php" target="Body">Listes de lecture </a></li>
                                            <li><a href="<?php echo $lang_file; ?>/shoutcasting.php" target="Body">Diffusion "Shoutcast"</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/video-files.php" target="Body">Fichiers vidéo</a></li>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <br><br>
                            <img src="../style/images/plus.gif">
                            <a href="#" onclick="showHideCon('groupFeatures','yes');">Groupes</a>
                            <div id=groupFeaturesContent style="display: none;">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="leftNavBody">
                                    <tr>
                                        <td width="10" class="leftNavBody">&nbsp;&nbsp;</td>
                                        <td width="100%" class="leftNavBody">
                                            <li><a href="<?php echo $lang_file; ?>/discussions.php" target="Body">Discussions</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/ratings.php" target="Body">Notation</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/counting.php" target="Body">Compteur de demandes</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/suggestions.php" target="Body">Suggestions</a></li>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <br><br>
                            <img src="../style/images/plus.gif">
                            <a href="#" onclick="showHideCon('newsFeeds','yes');">Diffusion "Newsfeeds" (blocks)</a>
                            <div id=newsFeedsContent style="display: none;">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="leftNavBody">
                                    <tr>
                                        <td width="10" class="leftNavBody">&nbsp;&nbsp;</td>
                                        <td width="100%" class="leftNavBody">
                                            <li><a href="<?php echo $lang_file; ?>/mostrequested.php" target="Body">Plus demandés</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/highestrated.php" target="Body">Meilleures notes</a></li>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
    <tr>
        <td width="100%" class="leftNavBody"><br></td>
    </tr>
    <tr>
        <td width="100%" class="leftNavBody">
            <img src="../style/images/plus.gif">
            <a href="#" onclick="showHideCon('faq','yes');">FAQ</a>
            <div id=faqContent style="display: none;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="leftNavBody">
                    <tr>
                        <td width="10" class="leftNavBody">&nbsp;&nbsp;</td>
                        <td width="100%" class="leftNavBody">
                            <li><a href="<?php echo $lang_file; ?>/faq-general.php" target="Body">Générale</a></li>
                            <li><a href="<?php echo $lang_file; ?>/faq-install.php" target="Body">Installation</a></li>
                            <li><a href="<?php echo $lang_file; ?>/faq-config.php" target="Body">Configuration</a></li>
                            <li><a href="<?php echo $lang_file; ?>/faq-features.php" target="Body">Demande de fonctionnalité</a></li>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
    <tr>
        <td width="100%" class="leftNavBody"><br></td>
    </tr>
    <tr>
        <td width="100%" class="leftNavBody">
            <img src="../style/images/plus.gif">
            <a href="#" onclick="showHideCon('helping','yes');">Aider le projet</a>
            <div id=helpingContent style="display: none;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="leftNavBody">
                    <tr>
                        <td width="10" class="leftNavBody">&nbsp;&nbsp;</td>
                        <td width="100%" class="leftNavBody">
                            <li><a href="<?php echo $lang_file; ?>/developers.php" target="Body">Développeurs</a></li>
                            <li><a href="<?php echo $lang_file; ?>/donations.php" target="Body">Donations</a></li>
                            <li><a href="<?php echo $lang_file; ?>/beta-testing.php" target="Body">Tests</a></li>
                            <li><a href="<?php echo $lang_file; ?>/translations.php" target="Body">Traductions</a></li>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
    <tr>
        <td width="100%" class="leftNavBody"><br></td>
    </tr>
    <tr>
        <td width="100%" class="leftNavBody">
            <img src="../style/images/plus.gif">
            <a href="#" onclick="showHideCon('gettingsupport','yes');">Support</a>
            <div id=gettingsupportContent style="display: none;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="leftNavBody">
                    <tr>
                        <td width="10" class="leftNavBody">&nbsp;&nbsp;</td>
                        <td width="100%" class="leftNavBody">
                            <li><a href="<?php echo $lang_file; ?>/support-standard.php" target="Body">Standard</a></li>
                            <li><a href="<?php echo $lang_file; ?>/support-premium.php" target="Body">Premium</a></li>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>














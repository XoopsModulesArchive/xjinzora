<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* JINZORA | Web-based Media Streamer
*
* Jinzora is a Web-based media streamer, primarily desgined to stream MP3s
* (but can be used for any media file that can stream from HTTP).
* Jinzora can be integrated into a PostNuke site, run as a standalone application,
* or integrated into any PHP website. It is released under the GNU GPL.
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
            <strong>Topic List</strong>
        </td>
    </tr>
    <tr>
        <td width="100%" class="leftNavBody"><br></td>
    </tr>
    <tr>
        <td width="100%" class="leftNavBody">
            <img src="../style/images/plus.gif">
            <a href="#" onclick="showHideCon('requirements','yes');">Requirements</a>
            <div id=requirementsContent style="display: none;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="leftNavBody">
                    <tr>
                        <td width="10" class="leftNavBody">&nbsp;&nbsp;</td>
                        <td width="100%" class="leftNavBody">
                            <li><a href="<?php echo $lang_file; ?>/unix-req.php" target="Body">*NIX Users</a></li>
                            <li><a href="<?php echo $lang_file; ?>/windows-req.php" target="Body">Windows Users</a></li>
                            <li><a href="<?php echo $lang_file; ?>/known-working.php" target="Body">Working Configs</a></li>
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
            <a href="#" onclick="showHideCon('installing','yes');">Installing Jinzora</a>
            <div id=installingContent style="display: none;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="leftNavBody">
                    <tr>
                        <td width="10" class="leftNavBody">&nbsp;&nbsp;</td>
                        <td width="100%" class="leftNavBody">
                            <li><a href="<?php echo $lang_file; ?>/standalone.php" target="Body">Standalone</a></li>
                            <li><a href="<?php echo $lang_file; ?>/postnuke.php" target="Body">All Nuke CMSes</a></li>
                            <li><a href="<?php echo $lang_file; ?>/mambo.php" target="Body">Mambo</a></li>
                            <li><a href="<?php echo $lang_file; ?>/ftponly.php" target="Body">FTP Only</a></li>
                            <li><a href="<?php echo $lang_file; ?>/jukebox.php" target="Body">Jukebox Mode</a></li>
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
            <a href="#" onclick="showHideCon('upgrading','yes');">Upgrading</a>
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
            <a href="#" onclick="showHideCon('using','yes');">Using Jinzora</a>
            <div id=usingContent style="display: none;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="leftNavBody">
                    <tr>
                        <td width="10" class="leftNavBody">&nbsp;&nbsp;</td>
                        <td width="100%" class="leftNavBody">
                            <br>
                            <img src="../style/images/plus.gif">
                            <a href="#" onclick="showHideCon('displayIssues','yes');">Display Items</a>
                            <div id=displayIssuesContent style="display: none;">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="leftNavBody">
                                    <tr>
                                        <td width="10" class="leftNavBody">&nbsp;&nbsp;</td>
                                        <td width="100%" class="leftNavBody">
                                            <li><a href="<?php echo $lang_file; ?>/album-art.php" target="Body">Album Art</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/desc-files.php" target="Body">Description Files</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/excluding.php" target="Body">Excluding Items</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/fake-tracks.php" target="Body">Fake Tracks</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/hidingtracks.php" target="Body">Hiding Tracks</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/lyrics.php" target="Body">Lyrics</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/sorting-year.php" target="Body">Sorting by Year</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/truncate.php" target="Body">Shortening Items</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/the-header.php" target="Body">The Header</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/the-footer.php" target="Body">The Footer</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/themes.php" target="Body">Themes</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/tracks-only.php" target="Body">Tracks Only</a></li>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <br><br>
                            <img src="../style/images/plus.gif">
                            <a href="#" onclick="showHideCon('miscStuff','yes');">Misc Stuff</a>
                            <div id=miscStuffContent style="display: none;">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="leftNavBody">
                                    <tr>
                                        <td width="10" class="leftNavBody">&nbsp;&nbsp;</td>
                                        <td width="100%" class="leftNavBody">
                                            <li><a href="<?php echo $lang_file; ?>/file-cachine.php" target="Body">File Caching</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/adding-media.php" target="Body">Adding Media</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/dir-structure.php" target="Body">Directory Structure</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/languages.php" target="Body">Languages</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/rss.php" target="Body">RSS Newsfeed</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/securing.php" target="Body">Securing Jinzora</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/symlinking.php" target="Body">Symlinking</a></li>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <br><br>
                            <img src="../style/images/plus.gif">
                            <a href="#" onclick="showHideCon('tools','yes');">Tools</a>
                            <div id=toolsContent style="display: none;">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="leftNavBody">
                                    <tr>
                                        <td width="10" class="leftNavBody">&nbsp;&nbsp;</td>
                                        <td width="100%" class="leftNavBody">
                                            <li><a href="<?php echo $lang_file; ?>/bulkedit.php" target="Body">Bulk Editing</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/id3tagging.php" target="Body">ID3 Tagging</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/searching.php" target="Body">Searching</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/user-access.php" target="Body">User Manager</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/uploading.php" target="Body">Upload Manager</a></li>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <br><br>
                            <img src="../style/images/plus.gif">
                            <a href="#" onclick="showHideCon('playingMedia','yes');">Playing Media</a>
                            <div id=playingMediaContent style="display: none;">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="leftNavBody">
                                    <tr>
                                        <td width="10" class="leftNavBody">&nbsp;&nbsp;</td>
                                        <td width="100%" class="leftNavBody">
                                            <li><a href="<?php echo $lang_file; ?>/embedded.php" target="Body">Embedded Player</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/lofi.php" target="Body">Lo-Fi Files</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/media-players.php" target="Body">Media Players</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/media-types.php" target="Body">Media Types</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/playlists.php" target="Body">Playlists</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/shoutcasting.php" target="Body">Shoutcasting</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/video-files.php" target="Body">Video Files</a></li>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <br><br>
                            <img src="../style/images/plus.gif">
                            <a href="#" onclick="showHideCon('jukeboxmode','yes');">Jukebox Mode</a>
                            <div id=jukeboxmodeContent style="display: none;">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="leftNavBody">
                                    <tr>
                                        <td width="10" class="leftNavBody">&nbsp;&nbsp;</td>
                                        <td width="100%" class="leftNavBody">
                                            <li><a href="<?php echo $lang_file; ?>/embedding-jukebox.php" target="Body">Slim Controls</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/using-jukebox.php" target="Body">Using Jukebox</a></li>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <br><br>
                            <img src="../style/images/plus.gif">
                            <a href="#" onclick="showHideCon('groupFeatures','yes');">Group Features</a>
                            <div id=groupFeaturesContent style="display: none;">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="leftNavBody">
                                    <tr>
                                        <td width="10" class="leftNavBody">&nbsp;&nbsp;</td>
                                        <td width="100%" class="leftNavBody">
                                            <li><a href="<?php echo $lang_file; ?>/discussions.php" target="Body">Discussions</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/dwnload-counting.php" target="Body">Download Counting</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/ratings.php" target="Body">Ratings</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/counting.php" target="Body">Request Counting</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/suggestions.php" target="Body">Suggestions</a></li>
                                            <li><a href="<?php echo $lang_file; ?>/toptracks-embed.php" target="Body">Top Tracks</a></li>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <br><br>
                            <img src="../style/images/plus.gif">
                            <a href="#" onclick="showHideCon('newsFeeds','yes');">Newsfeeds (blocks)</a>
                            <div id=newsFeedsContent style="display: none;">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="leftNavBody">
                                    <tr>
                                        <td width="10" class="leftNavBody">&nbsp;&nbsp;</td>
                                        <td width="100%" class="leftNavBody">
                                            <li><a href="<?php echo $lang_file; ?>/rss.php" target="Body">RSS Newsfeeds</a></li>
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
            <a href="#" onclick="showHideCon('slimzora','yes');">Slimzora</a>
            <div id=slimzoraContent style="display: none;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="leftNavBody">
                    <tr>
                        <td width="10" class="leftNavBody">&nbsp;&nbsp;</td>
                        <td width="100%" class="leftNavBody">
                            <li><a href="<?php echo $lang_file; ?>/slim-config.php" target="Body">Configuring</a></li>
                            <li><a href="<?php echo $lang_file; ?>/slim-hiding.php" target="Body">Hiding Slimzora</a></li>
                            <li><a href="<?php echo $lang_file; ?>/slim-embedding.php" target="Body">Embedding</a></li>
                            <li><a href="<?php echo $lang_file; ?>/slim-launch.php" target="Body">Launching</a></li>
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
                            <li><a href="<?php echo $lang_file; ?>/faq-general.php" target="Body">General</a></li>
                            <li><a href="<?php echo $lang_file; ?>/faq-install.php" target="Body">Install</a></li>
                            <li><a href="<?php echo $lang_file; ?>/faq-config.php" target="Body">Configuration</a></li>
                            <li><a href="<?php echo $lang_file; ?>/faq-features.php" target="Body">Feature Requests</a></li>
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
            <a href="#" onclick="showHideCon('helping','yes');">Helping the Project</a>
            <div id=helpingContent style="display: none;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="leftNavBody">
                    <tr>
                        <td width="10" class="leftNavBody">&nbsp;&nbsp;</td>
                        <td width="100%" class="leftNavBody">
                            <li><a href="<?php echo $lang_file; ?>/developers.php" target="Body">Developers</a></li>
                            <li><a href="<?php echo $lang_file; ?>/donations.php" target="Body">Donations</a></li>
                            <li><a href="<?php echo $lang_file; ?>/beta-testing.php" target="Body">Beta Testing</a></li>
                            <li><a href="<?php echo $lang_file; ?>/translations.php" target="Body">Translations</a></li>
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
            <a href="#" onclick="showHideCon('gettingsupport','yes');">Getting Support</a>
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

<?php
/*
* - JINZORA | Web-based Media Streamer -
*
* Jinzora is a Web-based media streamer, primarily desgined to stream MP3s
* (but can be used for any media file that can stream from HTTP).
* Jinzora can be integrated into a CMS site, run as a standalone application,
* or integrated into any PHP website.  It is released under the GNU GPL.
*
* - Ressources -
* - Jinzora Author: Ross Carlson <ross@jasbone.com>
* - Web: http://www.jinzora.org
* - Documentation: http://www.jinzora.org/docs
* - Support: http://www.jinzora.org/forum
* - Downloads: http://www.jinzora.org/downloads
* - License: GNU GPL <http://www.gnu.org/copyleft/gpl.html>
*
* - Contributors -
* Please see http://www.jinzora.org/modules.php?op=modload&name=jz_whois&file=index
*
* - Code Purpose -
* - Primary start page for Jinzora
*
* @since 08.01.03
* @author Ross Carlson <ross@jinzora.org>
*/

// Let's initalize some of these variables if they aren't set
if (isset($_GET['genre'])) {
} else {
    $_GET['genre'] = '';
} // REMOVE ME
if (isset($_GET['ptype'])) {
} else {
    $_GET['ptype'] = '';
}
if (isset($_GET['artist'])) {
} else {
    $_GET['artist'] = '';
} // REMOVE ME
if (isset($_GET['album'])) {
} else {
    $_GET['album'] = '';
} // REMOVE ME
if (isset($_SERVER['QUERY_STRING'])) {
} else {
    $_SERVER['QUERY_STRING'] = '';
}

// let's make sure we know at first this isn't an upgrade
$upgrade = 'no';

// Let's modify the include path for Jinzora
ini_set('include_path', '.');

// Now let's make sure there was data in the file
if (isset($install_complete)) {
} else {
    // Ok, now let's include the default settings file

    require_once __DIR__ . '/new-settings.php';
}

// Let's include the main, user settings file
@require_once __DIR__ . '/settings.php';

// Now let's set the CMS type for CPGNuke
// TO DO fix this hack...
if ('cpgnuke' == $cms_type) {
    $cms_type = 'phpnuke';
}

// Now let's set for 1, 2, or 3 level directory structure
switch ($directory_level) {
    case '3': # 3 directories deep
        // No change needed here, this is the default
        break;
    case '2': # 2 directories deep
        $_GET['genre'] = '/';
        break;
    case '1': # 2 directories deep
        $_GET['genre'] = '/';
        if (!isset($_GET['artist'])) {
            $_GET['artist'] = '/';
        }
        if (!isset($_GET['ptype'])) {
            $_GET['ptype'] = 'artist';
        }
        break;
}

// Let's see if the session is started, and if it isn't let's start it
session_name('jinzora-session');
session_start();

// Let's see if they wanted to change the language or not before we include it
if (isset($_POST['new_language'])) {
    $_SESSION['new_lang'] = $_POST['new_language'];
}
// Now let's actually set that new language if they choose one in this session
if (isset($_SESSION['new_lang'])) {
    if ('' != $_SESSION['new_lang']) {
        $lang_file = $_SESSION['new_lang'];
    }
}

// Let's see if they wanted to change the language or not before we include it
if (isset($_POST['new_theme'])) {
    $_SESSION['new_theme'] = $_POST['new_theme'];

    $_SESSION['cur_theme'] = $_POST['new_theme'];

    header('Location: ' . $_POST['return']);

    exit();
}
// Now let's actually set that new language if they choose one in this session
if (isset($_SESSION['new_theme']) and '' != $_SESSION['new_theme']) {
    $jinzora_skin = $_SESSION['new_theme'];
}

// Let's see if they wanted to resample
if (isset($allow_resample)) {
    if ('true' == $allow_resample) {
        if (isset($_POST['sample_rate'])) {
            $_SESSION['resample'] = $_POST['sample_rate'];
        }

        if (!isset($_SESSION['resample'])) {
            $_SESSION['resample'] = '';
        }
    }
}

// Let's include the system, non-user variabled
require_once __DIR__ . '/system.php';
// Let's include all the display functions
require_once __DIR__ . '/display/display.php';
require_once __DIR__ . '/lib/display.lib.php';
// Let's include all the playlist functions
require_once __DIR__ . '/playlists.php';
// Let's include our custom classes
require_once __DIR__ . '/classes.php';
require_once __DIR__ . '/id3classes/getid3.php';
// Let's include all the general functions
require_once __DIR__ . '/general.php';

/*******************************************
 * * * * * * * * * * * * * * * * * * * * * *
 *  *  *  *  *  *  *  *  *  *  *  *  *  *  */
// -- FOR NEW BACKEND -- //
// Put this where it belongs and spice it up to suite your needs.
// variables: $hierarchy
// $_GET[path]
// $_GET[ptype] = null.
// remember constructor can be path or string.
$hierarchy = [genre, artist, album, track]; // from settings.php
$backend = 'database'; // from settings.php
$path = $_GET['path'] ?? '';

// Now let's include the functions we need to access the media
// This first one will be removed eventually.
require_once __DIR__ . '/adaptors/' . $adaptor_type . '/required.php';
require_once __DIR__ . '/backend/backend.php'; // that's all we need for the backend.

$node = new jzMediaNode($path);
$level = $node->getLevel();

if ('hidden' == $hierarchy[$level]) { // set this to be misc, or hidden, or whatever you think makes sense.
    while ('hidden' == $hierarchy[$level]) { // allow an arbitrary number of hidden levels.
        $level++;
    }

    $node->setNaturalDepth(1 + $level - $node->getLevel()); // now things like getSubNodes() work correctly.
}
// Now we have:
// *our node ($node), with the naturalDepth set to what we want.
// *our page type ($hierarchy[$level])
// So we just call the function for that page type
// if ptype === null.
/*  *  *  *  *  *  *  *  *  *  *  *  *  *  *
 * * * * * * * * * * * * * * * * * * * * * *
 *******************************************/

// Now let's see if they wanted track plays only
if ('true' == $track_play_only) {
    $disable_random = 'true';
}

// Now let's see if they wanted to do a power search
if (isset($_POST['doSearch']) or isset($_GET['doSearch'])) {
    // Let's start the Jinzora header

    displayHeader(word_power_search);

    echo '<center><div id="pleasewaitcell"></div></center>'; ?>
    <script language="JavaScript">
        <!--
        function setDescription(type) {
            descCell = document.getElementById("pleasewaitcell");
            descText = "<?php echo $word_please_wait; ?>";
            descCell.innerHTML = descText;
        }

        setDescription();
        // -->
    </script>
    <?php

    flushDisplay();

    // Let's do the search

    require_once __DIR__ . '/search.php';

    require_once __DIR__ . '/files.lib.php';

    powerSearch();

    // Let's close out

    displayFooter();

    exit();
}

// We need to see what they want to search
if (isset($_GET['search'])) {
    // Ok, now let's include the search library

    require_once __DIR__ . '/search.php';

    // Ok, now what to search

    switch ($_GET['search']) {
        case 'amg':
            searchAMG(urldecode($_GET['info']), $_GET['type']);
            break;
        case 'itunes':
            // Let's include the iTunes search library
            require_once __DIR__ . '/lib/itms.lib.php';
            require_once __DIR__ . '/lib/display.lib.php';

            // Let's start the Jinzora header
            displayHeader('iTunes ' . $word_search_results . ' : ' . urldecode($_GET['info']));

            // Now let's display the iTunes search bar
            displayiTunesSearchBar();

            // Let's make sure there was something to search with
            if ('' != $_GET['info']) {
                // First let's search iTunes to get the XML data

                $xmlData = searchiTunes(urldecode($_GET['info']));

                // Now let's set the url for the links

                $link_url = '/dev/jinzora/index.php?';

                // Now let's search and display

                jzTableOpen('100', '0', 'jz_track_table');

                jzTROpen();

                jzTDOpen('32', 'center', 'top', '', '');

                displayiTunesSearchAlbums(parseiTunesData($xmlData, 'top4Albums'));

                jzTDClose();

                jzTDOpen('1', 'center', 'top', '', '');

                echo '&nbsp;';

                jzTDClose();

                jzTDOpen('32', 'center', 'top', '', '');

                displayiTunesSearchTopSongs(parseiTunesData($xmlData, 'topTracks'));

                jzTDClose();

                jzTDOpen('1', 'center', 'top', '', '');

                echo '&nbsp;';

                jzTDClose();

                jzTDOpen('32', 'center', 'top', '', '');

                displayiTunesSearchTopArtists(parseiTunesData($xmlData, 'topArtists'));

                jzTDClose();

                jzTRClose();

                jzTableClose();

                displayiTunesSearchTracks(parseiTunesData($xmlData, 'trackData'));
            }

            displayFooter();
            exit();
            break;
    }
}

// Let's see if they were going to add a favorite
if (isset($_SESSION['favTrack'])) {
    // Ok, let's see if the "favorites" playlist exists and if not create it

    $filename = $web_root . $root_dir . '/data/Jukebox-Favorites.m3u';

    $writeData = true;

    if (!is_file($filename)) {
        touch($filename);
    } else {
        // Ok, it existed, let's make sure this track isn't already there

        $handle = fopen($filename, 'rb');

        $data = fread($handle, filesize($filename));

        fclose($handle);

        if (mb_stristr($data, $_SESSION['favTrack'])) {
            $writeData = false;
        }
    }

    // Now let's see if we need to write the track

    if (true === $writeData) {
        if ($handle = @fopen($filename, 'ab')) {
            fwrite($handle, urldecode($_SESSION['favTrack']) . "\n");

            fclose($handle);
        }
    }

    unset($_SESSION['favTrack']);
}

// Let's see if they wanted a power search
if (isset($_POST['searchpower'])) {
    if ('true' == $cms_mode) {
        openCMS();
    }

    displaySearch();

    displayFooter();

    exit();
}

// let's see if they wanted to generate a playlist
if (isset($_GET['playlist'])) {
    playPlaylistFile($_GET['playlist']);

    exit();
}

// Now let's see if they pressed a button for XMMS
if (isset($_POST['xmmscommand'])) {
    require_once __DIR__ . '/jukebox.lib.php';

    // Now let's pass that command

    if ('' != $_POST['xmmsvol']) {
        controlXMMS($_POST['xmmsvol']);
    } else {
        switch ($_POST['xmmscommand']) {
            case 'randomize':
                randomizeJukebox();
                break;
            default:
                controlXMMS($_POST['xmmscommand']);
                break;
        }
    }

    // Now let's set the playback type

    if ('stream' == $_POST['pbType']) {
        $_SESSION['pbtype'] = 'stream';
    } else {
        $_SESSION['pbtype'] = 'jukebox';
    }

    // Now let's set the playback type

    if ('beginning' == $_POST['pbWhere']) {
        $_SESSION['pbWhere'] = 'beginning';
    } else {
        $_SESSION['pbWhere'] = 'end';
    }
}

// Now let's see if they pressed a button for winamp
if (isset($_POST['winampcommand'])) {
    require_once __DIR__ . '/jukebox.lib.php';

    // Now let's pass that command

    if ('' != $_POST['winampvol']) {
        controlWinamp($_POST['winampvol']);
    } else {
        controlWinamp($_POST['winampcommand']);
    }

    // Now let's set the playback type

    if ('stream' == $_POST['pbType']) {
        $_SESSION['pbtype'] = 'stream';
    } else {
        $_SESSION['pbtype'] = 'jukebox';
    }
}

// Now let's see if they wanted to submit a form for playlists or deletion
if (isset($_POST['submitAction']) or isset($_POST['albumSubmitAction'])) {
    // Now let's set the action variable to what they took

    if ('' != $_POST['submitAction']) {
        $submitAction = $_POST['submitAction'];

        $playListToPlay = $_POST['playListToPlay'];
    } else {
        $submitAction = $_POST['albumSubmitAction'];

        $playListToPlay = $_POST['albumPlayListToPlay'];
    }

    $editlistname = $_POST['editlistname'];

    // Alright, they posted to let's do what they wanted!

    switch ($submitAction) {
        case 'play': # Ok, they just wanted to play what was selected
            playSelected();
            break;
        case 'delete': # Ok, they wanted to delete what was selected
            deleteSelected();
            break;
        case 'viewplaylist': # Ok, they wanted to view their playlists
            // First we need to clear all the GET variables so the header won't show crap it shouldn't
            $_GET['genre'] = '';
            $_GET['artist'] = '';
            $_GET['album'] = '';
            $_GET['ptype'] = '';
            // Let's see if we are in CMS mode and if we need to open the page
            if ('true' == $cms_mode) {
                openCMS();
            }
            displayPlaylists($playListToPlay);
            exit();
            break;
        case 'playplaylist': # Ok, they wanted to play the selected playlist
            playPlaylistFile($playListToPlay);
            exit();
            break;
        case 'randomplaylist': # Ok, they wanted to play the selected playlist
            playPlaylistFile($playListToPlay, 'standard', 'true');
            exit();
            break;
        case 'addtoplaylist': # Ok, they wanted to add something to the playlist
            addToPlayList($playListToPlay);
            break;
        case 'removefromplaylist': # Ok, they wanted to remove some things from the playlist
            deleteFromPlaylist($editlistname);
            break;
        case 'deleteplaylist': # Ok, they wanted to just kill this playlist
            deletePlaylist($editlistname);
            break;
        case 'createShoutcast': # Ok, they wanted to create a Shoutcast Playlist File
            playPlaylistFile($editlistname, 'shoutcast');
            break;
        case 'createShoutcastRandom': # Ok, they wanted to create a Shoutcast Playlist File
            playPlaylistFile($editlistname, 'shoutcast', 'true');
            break;
    }
}

// Let's see if they wanted to save album art or not
if (isset($_POST['albumArtInfo'])) {
    // Ok, they want art, let's get it

    grabAlbumArt();
}

// Let's see if they wanted to move to the second step in installation
if (isset($_GET['enterinstall'])) {
    $install_complete = 'no';
}
if (isset($_GET['install'])) {
    // Now let's include the right file

    require_once __DIR__ . '/install/' . $_GET['install'] . '.php';

    exit();
}

// Now let's see if Jinzora has been installed or not
if ('' == $install_complete or 'no' == $install_complete or $config_version != $version) {
    // To make upgrades easy let's see if they have a settings file already

    // If they do we'll include the new one first so the new variable are already

    // populated for them

    if (!is_file('settings.php')) {
        @require_once __DIR__ . '/new-settings.php';

        @require_once __DIR__ . '/settings.php';

        // Let's let them know we are upgrading

        $upgrade = 'Yes';
    }

    // Ok, it hasn't been installed so let's send them to the installer

    require_once __DIR__ . '/install/step1.php';

    exit();
}

// Let's set the default access level for users
if (!isset($_SESSION['jz_access_level'])) {
    // Now let's see if they've logged in before and if so get their access level from the user database

    if (isset($_COOKIE['jz_user_name'])) {
        if (is_file($web_root . $root_dir . '/users.php')) {
            require_once $web_root . $root_dir . '/users.php';
        }

        // Now let's parse the user array to find the correct user, match their password, and get their admin level

        $ctr = 0;

        while (count($user_array) > $ctr) {
            if ($user_array[$ctr][0] == $_COOKIE['jz_user_name']) {
                $_SESSION['jz_access_level'] = $user_array[$ctr][2];
            }

            // Let's move to the next item in the array

            $ctr++;
        }
    } else {
        $_SESSION['jz_access_level'] = $default_access;
    }
}

// Now let's turn off downloading unless they are an admin
if ('admin' != $_SESSION['jz_access_level'] and 'poweruser' != $_SESSION['jz_access_level']) {
    $allow_download = 'false';
}

// Let's see if they submitted the forms (quick drop downs and others) and then go to the right page
if (isset($_POST['genre'])) {
    header("Location: $this_page" . $url_seperator . $_POST['genre']);
}
if (isset($_POST['artist'])) {
    header("Location: $this_page" . $url_seperator . $_POST['artist']);
}
if (isset($_POST['album'])) {
    header("Location: $this_page" . $url_seperator . $_POST['album']);
}
if (isset($_POST['submit_random'])) {
    // Ok, they wanted random, let's give them random

    generateRandom();
}

if (isset($_POST['submit_login'])) {
    // Let's include the user file so we can check what they entered, but first make sure it's there

    if (is_file($web_root . $root_dir . '/users.php')) {
        require_once $web_root . $root_dir . '/users.php';
    }

    // Now let's parse the user array to find the correct user, match their password, and get their admin level

    $ctr = 0;

    while (count($user_array) > $ctr) {
        if (mb_strtolower($_POST['username']) == mb_strtolower($user_array[$ctr][0])) {
            // Ok, we have a match on the username, let's see if it's the right password

            if (md5($_POST['admin_pass']) == $user_array[$ctr][1]) {
                // Ok, we have a match on password, let's set the users access level

                // Did they want to be remembered or not?

                if (isset($_POST['remember_me'])) {
                    $expire = time() + 60 * 60 * 24 * 365;
                } else {
                    $expire = '0';
                }

                $_SESSION['jz_access_level'] = $user_array[$ctr][2];

                setcookie('jz_user_name', $_POST['username'], $expire, '/', '', 0);

                $login_success = 'Yes';
            }
        }

        // Let's move to the next item in the array

        $ctr += 1;
    }

    // Let's give them an error if they logged in incorrectly

    if ('Yes' != $login_success) {
        // Let's output the style sheet

        echo $css;

        echo '<br><center><b>ERROR LOGGING IN!!! - WRONG PASSWORD!!!</b><br><br>Please go back and try again!</center><br>';

        exit();
    }  

    // Let's now redirect them to the home page

    header('Location: ' . $this_site . $this_page . $url_seperator . str_replace('||||', '&', $_POST['returnPage']));
}

if ('noaccess' == $_SESSION['jz_access_level']) {
    if ('true' == $cms_mode) {
        openCMS(true);

        // Now let's make sure they are still noacess before we warn them...

        if ('noaccess' == $_SESSION['jz_access_level']) {
            openCMS();

            echo '<br><br><center>' . $word_noacess . '</center><br><br>';

            exit();
        }
    } else {
        if ('' == $_GET['ptype']) {
            if ('login' != $_GET['ptype'] and ('' == $_COOKIE['jz_user_name'] or 'anonymous' == $_COOKIE['jz_user_name'])) {
                header("Location: $this_site$this_page" . $url_seperator . 'ptype=login');

                exit();
            }
        }
    }
}

// Let's look at the URL and see what they wanted
$pageType = $_GET['ptype'] ?? null;
switch ($pageType) {
    //	case "genre" : # Let's view the Genre they've selected
    //	// Let's see if this is inside CMS or not
    //	if ($cms_mode == "true"){
    //		openCMS();
    //	}
    //	displayGenre();
    //	break;
    //
    //	case "artist" : # Let's view all the albums for this artist
    //	// Let's see if this is inside CMS or not
    //	if ($cms_mode == "true"){
    //		openCMS();
    //	}
    //	displayArtist();
    //	break;
    //
    //	case "songs" : # Let's view all the albums for this artist
    //	// Let's see if this is inside CMS or not
    //	if ($cms_mode == "true"){
    //		openCMS();
    //	}
    //	displaySongs();
    //	break;
    //
    case 'quickplay': # Let's view all the albums for this artist
        quickplay();
        break;
    case 'zip': # The user wants to download something
        createZipFile();
        break;
    case 'tools': # They want the tools page (ID3 tags, etc)
        require_once __DIR__ . '/tools.php';
        break;
    case 'search': # They want the tools page (ID3 tags, etc)
        if ('true' == $cms_mode) {
            openCMS();
        }
        require_once __DIR__ . '/search.php';
        displaySearch();
        break;
    case 'login': # Ok, they wanted to log in to Jinzora
        // First let's set to the default access level
        $_SESSION['jz_access_level'] = $default_access;
        if ('true' == $cms_mode) {
            openCMS();
        }
        displayLogin();
        break;
    case 'logout': # Ok, they wanted to log in as an admin
        // First let's set to the default access level
        $_SESSION['jz_access_level'] = $default_access;
        setcookie('jz_user_name', 'anonymous', '0', '/', '', 0);
        // Now let's redirect them to the logged out home page
        header('Location: ' . $this_page);
        break;
    case 'artsearch': # Ok, they wanted to search for album art
        if ('true' == $cms_mode) {
            openCMS();
        }
        albumArtSearch(urlencode($_GET['info']));
        break;
    case 'showhidden': # Ok, they wanted to show all the files they have excluded
        if (unlink($web_root . $root_dir . '/data/global-exclude.lst')) {
            header('Location: ' . $_SESSION['prev_page']);
        }
        break;
    case 'updatetag': # Ok, so they wanted to update some tags...
        updateTags();
        exit();
        break;
    case 'updatealltag': # Ok, we need to update ALL the tags for this level
        updateAllTags();
        exit();
        break;
    case 'stopjukebox':  # Ok, let's stop the jukebox
        echo $jukebox_stop;
        exit();
        break;
    case 'powersearch': # Let's show them the power search
        require_once __DIR__ . '/search.php';
        require_once __DIR__ . '/lib/display.lib.php';
        displayPowerSearch();
        exit();
        break;
    default: # This is what 'normal' pages call
        // Let's see if this is inside CMS or not
        if ('true' == $cms_mode) {
            openCMS();
        }
        displayPage($node, $hierarchy[$level]);
        break;
}

displayFooter();

// Let's see if this is inside CMS or not
if ('true' == $cms_mode) {
    // Let's display the version info and link

    closeCMS();
}
?>

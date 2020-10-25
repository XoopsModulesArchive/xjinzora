<?php
/**
 * - JINZORA | Web-based Media Streamer -
 *
 * Jinzora is a Web-based media streamer, primarily desgined to stream MP3s
 * (but can be used for any media file that can stream from HTTP).
 * Jinzora can be integrated into a CMS site, run as a standalone application,
 * or integrated into any PHP website.  It is released under the GNU GPL.
 *
 * - Ressources -
 * - Jinzora Author: Ross Carlson <ross@jinzora.org>
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
 * Displays the "slim" version of Jinzora for mobile and small devices
 *
 * @since  02.17.04
 * @author Ross Carlson <ross@jinzora.org>
 */

// First we need to include all the settings and stuff
require_once __DIR__ . '/settings.php';

// Now let's set the theme before we include system
session_name('jinzora-session');
session_start();
if (isset($_GET['cur_theme'])) {
    $_SESSION['cur_theme'] = $_GET['cur_theme'];
}
if ('' != $_SESSION['cur_theme']) {
    $jinzora_skin = $_SESSION['cur_theme'];
}

require_once __DIR__ . '/system.php';
require_once __DIR__ . '/playlists.php';
require_once __DIR__ . '/id3classes/getid3.php';
require_once __DIR__ . '/general.php';
require_once __DIR__ . '/tracks.php';

// Now let's include the specific slim libraries
require_once __DIR__ . '/slim/slim.disp.php';
require_once __DIR__ . '/slim/slim.lib.php';

// Now let's include the functions we need to access the media
require_once __DIR__ . '/adaptors/' . $adaptor_type . '/required.php';

// Now let's set a few defaults
// These can be over-ridden with the prefs file
$display_time = 'true';
$display_rate = 'false';
$display_feq = 'false';
$display_size = 'false';
$allow_download = 'true';
$show_art = 'true';
$show_desc = 'true';
$enable_playlist = 'false';
$javascript = 'false';
$desc_truncate = '150';
$show_year = 'true';
$slim_title = 'Slimzora :: Slim Jinzora Interface';
$slim_mode = 'true';
$enable_ratings = 'false';
$enable_discussion = 'false';
$show_sub_numbers = 'true';
$track_plays = 'false';
$num_upcoming = '5';
$play_in_wmp_only = true;
$slim = true;
$display_downloads = 'false';

// Now let's see if there is a prefs file for the slim interface
if (is_file('slim.prefs.php')) {
    require_once __DIR__ . '/slim.prefs.php';
}

// Ok, right off the bat let's set the session variable of what page we're on
// So we can go back to it easily
$_SESSION['prev_page'] = $_SERVER['REQUEST_URI'];
if ('' == $_SESSION['prev_page']) {
    $_SESSION['prev_page'] = $_SERVER['URL'] . '?' . $_SERVER['QUERY_STRING'];
}

// Now let's set the header table
slimHeader();

// Now we need to display each directory from where we are
// Let's set the dir of where we are
if (isset($_GET['curdir'])) {
    $dirToLookIn = $web_root . $root_dir . $media_dir . '/' . urldecode($_GET['curdir']);

    $currentDir = urldecode($_GET['curdir']) . '/';
} else {
    $dirToLookIn = $web_root . $root_dir . $media_dir;

    $currentDir = '';
}

// Now let's get all the directories here
$retArray = readDirInfo($dirToLookIn, 'dir');

// Now let's display all the directories here
displaySlimDirs($retArray);

// Now let's look and see if there are any files at this level
echo '<table width="100%" cellpadding="0" cellspacing="5" border="0"><tr><td width="100%">';
lookForMedia($dirToLookIn, 'false');
echo '</td></tr></table>';

// Let's close out now
slimFooter();

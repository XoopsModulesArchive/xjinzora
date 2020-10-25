<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* JINZORA | Web-based Media Streamer
*
* Jinzora is a Web-based media streamer, primarily desgined to stream MP3s
* (but can be used for any media file that can stream from HTTP).
* Jinzora can be integrated into a CMS site, run as a standalone application,
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
* Code Purpose: This page contains all the NON-USER settings, please modify at your own risk!
* Created: 9.24.03 by Ross Carlson
*
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

// These are options that they use MIGHT change, but probably shouldn't
$use_ext_playlists = 'true'; # This tells Jinzora to use extended playlists
$site_title = 'Jinzora Media Jukebox';
$enable_logging = 'true'; # Not used just yet
// Now let's set the mime tyes for the video files that MUST have it set
$video_mimes = ['0' => ['asx', 'video/x-ms-asf']];
$audio_mimes = ['0' => ['default', 'audio/mpegurl', 'm3u'], '1' => ['rm', 'audio/x-pn-realaudio', 'ram']];
// This will disable right clicks in Jinzora to help hide your links
// NOTE: This will really piss some users off and should only be used if you know what you're doing!
$secure_links = 'false';
// This will let you match a variable on a track name and hide that type of track
$hide_content = 'temp';
// This decides how many columns the art should show in
$cols_for_albums = '2';
// Should we playback in the browser ONLY - right now only Windows Media Player
$play_in_wmp_only = false;
// Should we playback in the browser ONLY - java Player
$play_in_java_only = false;
// Should we show the popup window for Slimzora?
$show_slimzora = true;
// This sets the path to LAME and the options for resampling
$lame_opts = '/usr/local/bin/lame -a -b 32 --mp3input --resample 22.05 ';
// These are the volume ammounts for Jukebox mode
$jb_volumes = '0|10|20|30|40|50|60|70|80|90|100';
// This decides the length of the clip tracks that are created
// It is really the number of characters in the file that will be used (500000 = roughly 30 seconds)
$clip_length = 500000;
// How many characters into the file should we start?
$clip_start = 500000;
// These are the different values returned by iTunes for each track
$searchVals = 'artistName|artistId|bitRate|priceDisplay|composerName|composerId|copyright|dateModified|discCount|discNumber|duration|'
              . 'explicit|fileExtension|genre|genreId|playlistName|playlistArtistName|playlistArtistId|playlistId|previewURL|previewLength|'
              . 'relevance|releaseDate|sampleRate|songId|comments|trackNumber|songName|vendorId|year';
// These are the bit rates for resampling
$resampleRates = '128|112|96|80|64|56|48|40|32';

// includes the translation lib
$debug_lang = false;
require_once __DIR__ . '/lib/lang.lib.php';

// Let's set some other system wide variables
$this_pgm = 'Jinzora';
$version = '1.1alpha';
$mp3_dir = "$web_root$root_dir$media_dir";
$temp_zip_dir = "$web_root$root_dir$jinzora_temp_dir";
$jinzora_url = 'http://www.jinzora.org';
$show_jinzora_footer = true;
$hide_pgm_name = false;
$this_page = @$HTTP_SERVER_VARS['PHP_SELF'];
if ('true' == $cms_mode) {
    $url_seperator = '&';
} else {
    $url_seperator = '?';
}
if (isset($_SERVER['HTTPS'])) {
    if ('on' == $_SERVER['HTTPS']) {
        $this_site = 'https://' . $_SERVER['HTTP_HOST'];
    } else {
        $this_site = 'http://' . $_SERVER['HTTP_HOST'];
    }
} else {
    $this_site = 'http://' . $_SERVER['HTTP_HOST'];
}
// Let's fix the REQUEST_URI bug
if (!isset($_SERVER['REQUEST_URI']) and isset($_SERVER['SCRIPT_NAME'])) {
    $_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'];

    if (isset($_SERVER['QUERY_STRING']) and !empty($_SERVER['QUERY_STRING'])) {
        $_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
    }
}

if (isset($auth_value) and '' != $auth_value) {
    $this_site = str_replace('://', '://' . $auth_value . '@', $this_site);
}
$slash_vars = '&\ \!\@\$\^\(\)\`\{\}\[\]\;\=\'\"';
$path_to_wget = '/usr/bin';

// Let's see if they are using the defaults or not
if ('' == $root_dir) {
    $css = "<link rel=\"stylesheet\" href=\"style/$jinzora_skin/default.css\" type=\"text/css\">";
} else {
    $css = "<link rel=\"stylesheet\" href=\"$root_dir/style/$jinzora_skin/default.css\" type=\"text/css\">";
}

// Let's set some dynamic style elements
$jz_MenuItemLeft = 'jzMenuItemLeft';
$jz_MenuSplit = 'jzMenuSplit';
$jz_MainItemHover = 'jzMainItemHover';

/* First let's set to the default icons if we are using CMS */
if ('true' == $cms_mode) {
    // let's set some other CMS variables

    $this_name = $GLOBALS['name'];

    if ('postnuke' == $cms_type or 'mdpro' == $cms_type) {
        $this_page = "${this_page}?op=modload&name=$this_name&file=index&";

        $row_colors = ['jz_row2', 'jz_row1'];

        $jz_MenuItemHover = 'jz_row2';

        $jz_MenuItem = 'jz_row1';
    }

    if ('phpnuke' == $cms_type or 'nsnnuke' == $cms_type or 'cpgnuke' == $cms_type) {
        $this_page = 'modules.php?name=' . $_GET['name'] . '&';

        $row_colors = ['jz_row2', 'jz_row1'];

        $jz_MenuItemHover = 'jz_row2';

        $jz_MenuItem = 'jz_row1';
    }

    if ('mambo' == $cms_type) {
        $this_page = mb_substr($_SERVER['REQUEST_URI'], 0, mb_strpos($_SERVER['REQUEST_URI'], '?')) . '?option=com_jinzora&';

        $row_colors = ['sectiontableentry2', 'tabheading'];

        $jz_MenuItemHover = 'tabheading';

        $jz_MenuItem = 'sectiontableentry2';
    }
} else {
    $row_colors = ['jz_row1', 'jz_row2'];

    $jz_MenuItemLeft = 'jzMenuItemLeft';

    $jz_MenuSplit = 'jzMenuSplit';

    $jz_MenuItemHover = 'jzMenuItemHover';

    $jz_MainItemHover = 'jzMainItemHover';

    $jz_MenuItem = 'jzMenuItem';
}
// Now let's set the EXT playlist option to false IF they are using a web based player
if ($play_in_wmp_only) {
    $use_ext_playlists = 'false';

    $track_play_only = 'true';
}

// This is an ugly hack to set the colors for the themes
// So the Java applet will have the right params
// We'll change this in the future
switch ($jinzora_skin) {
    case 'bluegray':
        $fg_c = '#D4D4D4';
        $bg_c = '#5273AD';
        $text_c = '#FFFFFF';
        break;
    case 'darkerlights':
        $fg_c = '#FFFFFF';
        $bg_c = '#4A4A4A';
        $text_c = '#FFFFFF';
        break;
    case 'darklites':
        $fg_c = '#FFFFFF';
        $bg_c = '#4A4A4A';
        $text_c = '#FFFFFF';
        break;
    case 'goldmine':
        $fg_c = '#1A1A1A';
        $bg_c = '#FFB300';
        $text_c = '#000000';
        break;
    case 'greenfields':
        $fg_c = '#CCFFCC';
        $bg_c = '#005900';
        $text_c = '#FFFFFF';
        break;
    case 'iceblue':
        $fg_c = '#69D6FF';
        $bg_c = '#0011A4';
        $text_c = '#FFFFFF';
        break;
    case 'puddle':
        $fg_c = '#DEEBFC';
        $bg_c = '#86C7F8';
        $text_c = '#000000';
        break;
    case 'steel':
        $fg_c = '#D4D4D4';
        $bg_c = '#848484';
        $text_c = '#000000';
        break;
    case 'sunflower':
        $fg_c = '#BFBFBF';
        $bg_c = '#FECC00';
        $text_c = '#000000';
        break;
    case 'vampire':
        $fg_c = '#310101';
        $bg_c = '#570000';
        $text_c = '#FFFFFF';
        break;
    case 'sandstone':
        $fg_c = '#F5F5D0';
        $bg_c = '#CCCC99';
        $text_c = '#000000';
        break;
    default:
        $fg_c = '#FFFFFF';
        $bg_c = '#FFFFFF';
        $text_c = '#000000';
        break;
}

// Now let's include all the icons
require_once 'icons.php';

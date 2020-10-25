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
* Code Purpose: This page defines all the different icons for Jinzora
* Created: 9.24.03 by Ross Carlson
*
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

// Now let's actually define the icons
if ('' == $root_dir) {
    $image_dir = "style/$jinzora_skin/";

    $main_img_dir = 'style/images/';
} else {
    $image_dir = "$root_dir/style/$jinzora_skin/";

    $main_img_dir = "$root_dir/style/images/";
}
$disabled_dir = "$root_dir/style/images/";
$img_add = "<img src=\"${image_dir}add.gif\" border=0 alt=\"$word_add_to\" title=\"$word_add_to\">";
$img_delete = "<img src=\"${image_dir}delete.gif\" border=0 alt=\"$word_delete\" title=\"$word_delete\">";
$img_download = "<img src=\"${image_dir}download.gif\" border=0 alt=\"$word_download\" title=\"$word_download\">";
$img_home = "<img src=\"${image_dir}home.gif\" border=0 alt=\"$word_return_home\" title=\"$word_return_home\">";
$img_more = "<img src=\"${image_dir}more.gif\" border=0 alt=\"$word_more\" title=\"$word_more\">";
$img_play = "<img src=\"${image_dir}play.gif\" border=0 alt=\"$word_play\" title=\"$word_play\">";
$img_blank = "<img src=\"${image_dir}blank.gif\" border=0>";
$img_random_play = "<img src=\"${image_dir}random.gif\" border=0 alt=\"$word_play_random\" title=\"$word_play_random\">";
$img_move = "<img src=\"${image_dir}move.gif\" border=0 alt=\"$word_move_item\" title=\"$word_move_item\">";
$img_up_arrow = "<img src=\"${image_dir}up-arrow.gif\" border=0 alt=\"$word_up_level\" title=\"$word_up_level\">";
$img_playlist = "<img src=\"${image_dir}playlist.gif\" border=0 alt=\"$word_playlist\" title=\"$word_playlist\">";
$img_rate = "<img src=\"${image_dir}rate.gif\" border=0 alt=\"$word_rate\" title=\"$word_rate\">";
$img_star = "<img src=\"${image_dir}star.gif\" border=0 >";
$img_half_star = "<img src=\"${image_dir}half-star.gif\" border=0 >";
$img_discuss = "<img src=\"${image_dir}discuss.gif\" border=0 alt=\"$word_discuss\" title=\"$word_discuss\">";
$img_clear = "<img src=\"${image_dir}clear.gif\" border=0 alt=\"$word_clear\" title=\"$word_clear\">";
$img_star_half_empty = "<img src=\"${image_dir}star-half-empty.gif\" border=0 alt=\"$word_rate\" title=\"$word_rate\">";
$img_star_full_empty = "<img src=\"${image_dir}star-full-empty.gif\" border=0 alt=\"$word_rate\" title=\"$word_rate\">";
$img_star_right = "<img src=\"${image_dir}star-right.gif\" border=0 alt=\"$word_rate\" title=\"$word_rate\">";
$img_star_half = "<img src=\"${image_dir}star-half.gif\" border=0 alt=\"$word_rate\" title=\"$word_rate\">";
$img_star_full = "<img src=\"${image_dir}star-full.gif\" border=0 alt=\"$word_rate\" title=\"$word_rate\">";
$img_star_left = "<img src=\"${image_dir}star-left.gif\" border=0 alt=\"$word_rate\" title=\"$word_rate\">";
$img_fav_track = "<img src=\"${image_dir}rate.gif\" border=0 alt=\"$word_add_to_favorites\" title=\"$word_add_to_favorites\">";
$img_lofi = "<img src=\"${image_dir}play-lofi.gif\" border=0 alt=\"$word_play_lofi\" title=\"$word_play_lofi\">";
$img_new = "<img src=\"${image_dir}new.gif\" border=0 alt=\"$word_new\" title=\"$word_new\">";
$img_slim_pop = "<img src=\"${image_dir}slim-pop.gif\" border=0 alt=\"Slimzora\" title=\"Slimzora\">";
$img_sm_logo = "<img src=\"$root_dir/style/images/powered-by-small.gif\" border=0 alt=\"$this_pgm $version\" title=\"$this_pgm $version\">";
$img_slimzora = "<img src=\"$root_dir/style/images/slimzora.gif\" border=0 alt=\"$this_pgm $version\" title=\"$this_pgm $version\">";

// Now let's create the blank icons
if ('cms-theme' == $jinzora_skin) {
    $img_add_dis = "<img src=\"${disabled_dir}pn-add-disabled.gif\" border=0 alt=\"$word_add_to\" title=\"$word_add_to\">";

    $img_delete_dis = "<img src=\"${disabled_dir}pn-delete-disabled.gif\" border=0 alt=\"$word_delete\" title=\"$word_delete\">";

    $img_download_dis = "<img src=\"${disabled_dir}pn-download-disabled.gif\" border=0 alt=\"$word_download\" title=\"$word_download\">";

    $img_more_dis = "<img src=\"${disabled_dir}pn-more-disabled.gif\" border=0 alt=\"$word_more\" title=\"$word_more\">";

    $img_play_dis = "<img src=\"${disabled_dir}pn-play-disabled.gif\" border=0 alt=\"$word_play\" title=\"$word_play\">";

    $img_random_play_dis = "<img src=\"${disabled_dir}pn-random-disabled.gif\" border=0 alt=\"$word_play_random\" title=\"$word_play_random\">";

    $img_move_dis = "<img src=\"${disabled_dir}pn-move-disabled.gif\" border=0 alt=\"$word_move_item\" title=\"$word_move_item\">";

    $img_up_arrow_dis = "<img src=\"${disabled_dir}pn-up-arrow-disabled.gif\" border=0 alt=\"$word_up_level\" title=\"$word_up_level\">";

    $img_playlist_dis = "<img src=\"${disabled_dir}pn-playlist-disabled.gif\" border=0 alt=\"$word_playlist\" title=\"$word_playlist\">";

    $img_discuss_dis = "<img src=\"${disabled_dir}discuss-disabled.gif\" border=0 alt=\"$word_discuss\" title=\"$word_discuss\">";
} else {
    $img_add_dis = "<img src=\"${disabled_dir}add-disabled.gif\" border=0 alt=\"$word_add_to\" title=\"$word_add_to\">";

    $img_delete_dis = "<img src=\"${disabled_dir}delete-disabled.gif\" border=0 alt=\"$word_delete\" title=\"$word_delete\">";

    $img_download_dis = "<img src=\"${disabled_dir}download-disabled.gif\" border=0 alt=\"$word_download\" title=\"$word_download\">";

    $img_more_dis = "<img src=\"${disabled_dir}more-disabled.gif\" border=0 alt=\"$word_more\" title=\"$word_more\">";

    $img_play_dis = "<img src=\"${disabled_dir}play-disabled.gif\" border=0 alt=\"$word_play\" title=\"$word_play\">";

    $img_random_play_dis = "<img src=\"${disabled_dir}random-disabled.gif\" border=0 alt=\"$word_play_random\" title=\"$word_play_random\">";

    $img_move_dis = "<img src=\"${disabled_dir}move-disabled.gif\" border=0 alt=\"$word_move_item\" title=\"$word_move_item\">";

    $img_up_arrow_dis = "<img src=\"${disabled_dir}up-arrow-disabled.gif\" border=0 alt=\"$word_up_level\" title=\"$word_up_level\">";

    $img_playlist_dis = "<img src=\"${disabled_dir}playlist-disabled.gif\" border=0 alt=\"$word_playlist\" title=\"$word_playlist\">";

    $img_discuss_dis = "<img src=\"${image_dir}discuss-disabled.gif\" border=0 alt=\"$word_discuss\" title=\"$word_discuss\">";
}

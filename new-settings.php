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
* Code Purpose: This page contains all the default install options
* Created: 9.24.03 by Ross Carlson
*
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

/* Default Configuration Data */

$backend = 'filesytem';
$hierarchy = [genre, artist, album, track];
$adaptor_type = 'fileXML';

$config_version = '';
$install_complete = '';
$web_root = '';
$root_dir = '';
$media_dir = '';
$cms_mode = 'false';
$cms_type = '';
$lang_file = 'english';
$allow_lang_choice = 'false';
$jinzora_skin = 'sandstone';
$allow_theme_change = 'false';
$allow_download = 'true';
$get_mp3_info = 'true';
$playlist_ext = 'm3u';
$jinzora_temp_dir = '/temp';
$default_access = 'viewonly';
$directory_level = '3';
$show_loggedin_level = 'false';
$cols_in_genre = '3';
$cellspacing = '5';
$song_cellpadding = '5';
$artist_truncate = '20';
$quick_list_truncate = '20';
$album_name_truncate = '35';
$main_table_width = '100';
$random_play_amounts = '5|10|25|50|100';
$default_random_play_amount = '5';
$random_play_types = 'Songs|Albums|Artists|Genres';
$default_random_play_type = 'Songs';
$audio_types = 'mp3|ogg|wma|wav';
$video_types = 'avi|mpg|wmv|mpeg';
$ext_graphic = 'jpg|gif|png|jpeg';
$fav_image_name = '';
$path_to_zip = '/usr/bin/';
$pathtoId3Tool = '/usr/local/bin';
$track_num_seperator = ' - |.';
$ephPod_file_name = 'syncdirs.dat';
$ephPod_drive_letter = 'M';
$ipod_size = '18500';
$javascript = 'yes';
$header_drops = 'true';
$num_other_albums = '2';
$genre_drop = 'true';
$artist_drop = 'true';
$album_drop = 'true';
$song_drop = 'false';
$quick_drop = 'true';
$album_img_width = '0';
$album_img_height = '0';
$album_force_height = '0';
$album_force_width = '0';
$artist_img_width = '0';
$artist_img_height = '0';
$keep_porportions = 'true';
$search_album_art = 'true';
$sort_by_year = 'false';
$hide_tracks = 'false';
$sc_host = 'localhost';
$sc_port = '8100';
$sc_password = 'Jinzora';
$sc_refresh = '60';
$auto_search_art = 'true';
$show_sub_numbers = 'true';
$download_mp3_only = 'false';
$embedded_header = '';
$embedded_footer = '';
$show_tools_link = 'false';
$auth_value = '';
$hide_id3_comments = 'false';
$show_all_checkboxes = 'false';
$num_rand_albums = '0';
$cms_user_access = 'noaccess';
$enable_ratings = 'false';
$num_top_ratings = '0';
$num_suggestions = '0';
$enable_suggestions = 'false';
$track_plays = 'false';
$enable_discussion = 'false';
$display_time = 'true';
$display_rate = 'true';
$display_feq = 'true';
$display_size = 'true';
$days_for_new = '0';
$enable_most_played = 'true';
$num_most_played = '0';
$echocloud = '5';
$disable_random = 'false';
$info_level = 'all';
$auto_search_lyrics = 'true';
$track_play_only = 'false';
$enable_playlist = 'true';

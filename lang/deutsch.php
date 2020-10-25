<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* JINZORA | Web-basierender Media Streamer
*
* Jinzora ist ein Web-basierender media streamer, primär programmiert um MP3s zu streamen.
* (aber Du kannst es benutzen um andere media files zu streamen mit HTTP).
* Jinzora kann als PostNuke Modul eingesetzt werden, oder als standalone application,
* ist integrierbar in jede PHP website.  Es ist veröffentlicht unter GNU GPL.
*
* Jinzora Author:
* Ross Carlson: ross@jasbone.com
* http://www.jinzora.org/
* Documentation: http://www.jinzora.org/docs
* Support: http://www.jinzora.org/forum
* Downloads: http://www.jinzora.org/downloads
* License: GNU GPL <http://www.gnu.org/copyleft/gpl.html>
*
* Contributors:
* Please see http://www.jinzora.org/modules.php?op=modload&name=jz_whois&file=index
*
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

/* Let's define all the words here */
$word_genres = 'Genres';
$word_genre = 'Genres';
$word_search_results = 'Such Ergebnisse';
$word_tools = 'Tools';
$word_search = 'Suche:';
$word_artist = 'Artists';
$word_album = 'Albums';
$word_pleasechoose = 'Bitte wähle...';
$word_play = 'Play';
$word_play_all_albums_from = 'Play alle Albums von:';
$word_randomize_all_albums_from = 'Randomize alle Albums von:';
$word_play_album = 'Play Album';
$word_download_album = 'Download Album';
$word_id3_tag_tools = 'MP3 ID3 Tag Tools';
$word_update_id3v1 = 'Update ID3 Tags';
$word_update_id3v1_desc = 'Dynamisches erzeugen aller ID3 Tags von Genre/Artist/Album/Track Number - Filename';
$word_strip_id3v1_desc = 'Entferne alle ID3 tags von allen files';
$word_update_id3v2 = 'Erneuere ID3 Tags';
$word_update_id3v2_desc = 'Dynamisches erzeugen aller ID3 Tags von Genre/Artist/Album/Track Number - Filename';
$word_strip_id3v2_desc = 'Entferne alle ID3 tags von allen files';
$word_strip_id3v1 = 'Entferne ID3 Tags';
$word_strip_id3v2 = 'Entferne ID3 Tags';
$word_directory_other_tools = 'Directory | File Tools | Misc Tools';
$word_upload_center = 'Upload Zentrum';
$word_select_for_ipod = 'Wähle für iPod Sync';
$word_fix_file_case = 'Fix File Name Case';
$word_create_new_genre = 'Erzeuge neues Genre';
$word_delete_genre = 'Lösche Genre';
$word_upload_to_jinzora = 'Upload Music to Jinzora';
$word_ipod_select_desc = 'Allows Artists to be selected for Sync to an iPod using ephPod';
$word_fix_file_case_desc = 'Changes the case to Initial caps for all words';
$word_create_new_genre_desc = 'Neues Genre hinzufügen';
$word_delete_genre_desc = 'Lösche Genre ';
$word_add_to = 'Hinzufügen:';
$word_delete = 'Löschen';
$word_download = 'Download';
$word_return_home = 'Return Home';
$word_more = 'Mehr';
$word_play_random = 'Play Random';
$word_move_item = 'Move Item';
$word_login = 'Einloggen';
$word_random_select = 'Random Erzeugen:';
$word_logout = 'Ausloggen';
$word_up_level = 'Up Level';
$word_down_level = 'Down Level';
$word_enter_setup = 'Enter Setup';
$word_go_button = 'Go';
$word_username = 'Username:';
$word_password = 'Password:';
$word_home = 'Home';
$word_language = 'Sprache:';
$word_theme = 'Thema:';
$word_secure_warning = "Jinzora ist nicht gesichert, bitte starte 'sh secure.sh' in der shell!";
$word_check_for_update = 'Prüfe auf Jinzora Updates';
$word_new_genre = 'Neues Genre:';
$word_search_for_album_art = 'Suche Album Cover für';
$word_cancel = 'Abbruch';
$word_are_you_sure_delete = 'Sind sie sicher das sie löschen möchten:';
$word_playlist = 'Playlist';
$word_check_all = 'Prüfe alle';
$word_check_none = 'keine';
$word_selected = 'Ausgewählt';
$word_session_playlist = ' - Session Playlist - ';
$word_new_playlist = ' - Neue Playlist - ';
$word_send_tech_email = 'Sende technische info zum support';
$word_auto_update = 'Automatisches update';
$word_auto_update_beta = 'Automatisches update (beta release)';
$word_rewrite_files_from_id3 = 'Überschreibe file namen von ID3 info';
$word_create_shoutcast_playlist = 'Erzeuge Shoutcast Playlist';
$word_hide_tracks = 'Verstecke Tracks';
$word_show_tracks = 'Zeige Tracks';
$word_shoutcast_tools = 'Shoutcast Tools';
$word_start_shoutcast = 'Starte Shoutcast Server';
$word_stop_shoutcast = 'Stop Shoutcast Server';
$word_create_shoutcast_random_playlist = 'Randomize Shoutcast Playlist';
$word_fix_media_names = 'Repariere media file names';
$word_remember_me = 'Erinnere mich';
$word_show_hidden = 'Zeige versteckte';
$word_update_cache = 'Erneuere Cache';
$word_search_missing_album_art = 'Suche nach fehlenden album Covers';
$word_define = 'Define';
$word_define_uc = 'The Upload Center erlaubt Benutzern das Uplod von Files';
$word_define_id3_update = 'Dieses tool erlaubt dem user das dynamische updaten aller ID3 tags von allen MP3 files <br><br>For example in 3 directory mode:<br><br>Jazz/Miles Davis/Kind of Blue/01 - All Blues.mp3<br><br>...becomes...<br><br>Genre: Jazz<br>Artist: Miles Davis<br>Album: Kind of Blue<br>Track Number: 01<br>Track Name: All Blues<br><br>In 2 dir mode the Genre field is ignored';
$word_define_id3_strip = 'Diese tool entfernt Genre, Artist, Album, Tracknumber, Trackname von einem MP3 ID3 tag';
$word_define_create_genre = 'Dieses tool erzeugt einen ID3v1 tag für genre';
$word_define_delete_genre = 'Dieses tool löscht den Eintrag Genre, und alle sub files<br><br> VORSICHT!!!';
$word_define_ipod_sync = 'This lets the user select Artists to be synced to an iPod MP3 player, using ephPod';
$word_define_check_updates = 'Fragt beim Jinzora Homeserver nach der neusten Version';
$word_define_send_tech_info = 'Erzeugt ein Report file umd mailt es zum Jinzora Support<br><br> Bitte nur wenn der Support danach fragt benutzen!';
$word_define_enter_setup = 'Startet erneut das Setup und macht die Konfiguration einfacher<br><br>NOTE: Bitte starte configure.sh zuerst!';
$word_define_start_shoutcast = 'Startet den Shoutcast server, wenn shoutcast aktiviert ist';
$word_define_stop_shoutcast = 'Beendet den Shoutcast server, wenn shoutcast aktiviert ist';
$word_define_fix_media = 'These are some tools to help with bulk file management tasks';
$word_define_update_cache = 'This updates the current session cache information<br><br>This should be run if changes to the files or directory strucutre are done while actively browsing<br><br>Cachine the files this way makes Jinzora much faster';
$word_define_search_for_art = 'This presents the user with screens of possible album art, album by album from images.google.com<br><br>The user can choose the art they want, or the system generated default art';
$word_define_rewrite_from_id3 = 'Erneuert und überschreibt alle file namen mit ID3 tag informationen für track nummer und track name<br><br>NOTE: The first track seperator value - if multiple - will become the track seperator for the new file names';
$word_change_art = 'Ändere Cover';
$word_survey = 'Jinzora Survey';
$word_define_survey = 'Just a simple survey so we can learn more about how Jinzora is used to make it better!';
$word_user_manager = 'User Manager';
$word_define_user_manager = 'Erlaubt verschiedene rechte für user zu setzen';
$word_add_user = 'User hinzufügen';
$word_access_level = 'Access Level';
$word_update_successful = 'Update erfolgreich!';
$word_send_playlist = 'Sende Playlist';
$word_rate = 'Rate this item';
$word_discuss = 'Discuss this item';
$word_new = 'Neu!';
$word_editcomment = 'Bearbeite Kommentar';
$word_rewrite_tags = 'Überschreibe ID3 Tags';
$word_media_management = 'Media Management';
$word_actions = 'Actions';
$word_group_features = 'Group Features';
$word_item_information = 'Item Information';
$word_browse_album = 'Suche Album';
$word_new_from = 'Neu seit: ';
$word_new_from_last = 'Neu seit letztem: ';
$word_jukebox_controls = 'Jukebox Controls';
$word_pause = 'Pause';
$word_stop = 'Stop';
$word_next = 'Nächster';
$word_previous = 'Letzer';
$word_volume = 'Laut';
$word_mute = 'Still';
$word_up = 'Hoch';
$word_down = 'Runter';
$word_nowplaying = 'Now Playing';
$word_refresh_in = 'Refresh In:';
$word_upcoming = 'Upcoming Tracks:';
$word_stopped = 'Angehalten';
$word_next_track = 'Nächster Track';
$word_pause = 'Pause';
$word_playback_to = 'Playback to:';
$word_jukebox = 'Jukebox';
$word_stream = 'Stream';
$word_information = 'Suche';
$word_echocloud = 'Echocloud Similar';
$word_clear = 'Clear Playlist';

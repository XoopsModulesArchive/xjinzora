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
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

/* Let's define all the words here */
/* Let's define all the words here */
$word_genres = 'Hem';
$word_genre = 'Genre';
$word_search_results = 'Sök resultat';
$word_tools = 'Verktyg';
$word_search = 'Sök:';
$word_artist = 'Artister';
$word_album = 'Album';
$word_pleasechoose = 'Välj...';
$word_play = 'Spela';
$word_play_all_albums_from = 'Spela alla album av:';
$word_randomize_all_albums_from = 'Spela slumpmässigt alla album av:';
$word_play_album = 'Spela album';
$word_download_album = 'Ladda ner album';
$word_id3_tag_tools = 'MP3 ID3 tag verktyg';
$word_update_id3v1 = 'Uppdatera ID3 taggar';
$word_update_id3v1_desc = 'Skapa dynamiskt alla ID3 taggar från Genre/Artist/Album/Spår Nummer - Filnamn';
$word_strip_id3v1_desc = 'Ta bort alla ID3 taggar från samtliga filer';
$word_update_id3v2 = 'Uppdatera ID3 taggar';
$word_update_id3v2_desc = 'Dynamically create all ID3 Tags from Genre/Artist/Album/Track Number - Filename';
$word_strip_id3v2_desc = 'Ta bort alla ID3 taggar från samtliga filer';
$word_strip_id3v1 = 'Ta bort ID3 taggar';
$word_strip_id3v2 = 'Ta bort ID3 taggar';
$word_directory_other_tools = 'Katalog | Filverktyg | Andra verktyg';
$word_upload_center = 'Uppladdningscenter';
$word_select_for_ipod = 'Välj för iPod synk';
$word_fix_file_case = 'Ordna versaler/gemener för filnamn';
$word_create_new_genre = 'Skapa ny genre';
$word_delete_genre = 'Ta bort genre';
$word_upload_to_jinzora = 'Ladda upp musik till Jinzora';
$word_ipod_select_desc = 'Tillåter att artister blir valda för Synk till en iPod som använder ephPod';
$word_fix_file_case_desc = 'Ändrar stor/liten bokstav till stor bokstav i början på alla ord';
$word_create_new_genre_desc = 'Lägg till en ny genre i Jinzora';
$word_delete_genre_desc = 'Ta bort en genre från Jinzora';
$word_add_to = 'Lägg till till:';
$word_delete = 'Ta bort';
$word_download = 'Ladda ner';
$word_return_home = 'Återvänd Hem';
$word_more = 'Mer';
$word_play_random = 'Spela slumpmässigt';
$word_move_item = 'Flytta post';
$word_login = 'Logga in';
$word_random_select = 'Generera slumpmässigt:';
$word_logout = 'Logga ut';
$word_up_level = 'Upp en nivå';
$word_down_level = 'Ner en nivå';
$word_enter_setup = 'Gå till konfiguration';
$word_go_button = 'Kör';
$word_username = 'Användarnamn:';
$word_password = 'Lösenord:';
$word_home = 'Hem';
$word_language = 'Språk:';
$word_theme = 'Tema:';
$word_secure_warning = "Jinzora är inte säkert, kör 'sh secure.sh' i kommandotolken!";
$word_check_for_update = 'Kontrollera om det finns uppdateringar till Jinzora';
$word_new_genre = 'Ny genre:';
$word_search_for_album_art = 'Sök efter skivomslag för';
$word_cancel = 'Ångra';
$word_are_you_sure_delete = 'Är du säker på att du vill ta bort:';
$word_playlist = 'Spellista';
$word_check_all = 'Markera alla';
$word_check_none = 'Ingen';
$word_selected = 'Vald';
$word_session_playlist = ' - Session spellista - ';
$word_new_playlist = ' - Ny spellista - ';
$word_send_tech_email = 'Sänd teknisk info till support';
$word_auto_update = 'Automatisk uppdatering';
$word_auto_update_beta = 'Automatisk uppdatering (beta utgivning)';
$word_rewrite_files_from_id3 = 'Ändra filnamn utifrån ID3 info';
$word_create_shoutcast_playlist = 'Skapa Shoutcast spellista';
$word_hide_tracks = 'Göm spår';
$word_show_tracks = 'Visa spår';
$word_shoutcast_tools = 'Shoutcast verktyg';
$word_start_shoutcast = 'Starta Shoutcast Server';
$word_stop_shoutcast = 'Stoppa Shoutcast Server';
$word_create_shoutcast_random_playlist = 'Gör Shoutcast spellista slumpmässig';
$word_fix_media_names = 'Ordna media filnamn';
$word_remember_me = 'Kom ihåg mig';
$word_show_hidden = 'Visa gömd';
$word_update_cache = 'Uppdatera cachen';
$word_search_missing_album_art = 'Sök efter saknade skivalbum';
$word_define = 'Definiera';
$word_define_uc = 'Uppladdningscentret tillåter användare att ladda upp filer till Jinzora';
$word_define_id3_update = 'Detta verktyg möjliggör för användaren att dynamiskt uppdatera alla ID3 taggar på alla MP3 filer med hjälp av data från katalogstrukturen<br><br>For exempel i 3 katalogsläge:<br><br>Jazz/Miles Davis/Kind of Blue/01 - All Blues.mp3<br><br>...blir...<br><br>Genre: Jazz<br>Artist: Miles Davis<br>Album: Kind of Blue<br>Track Nummer: 01<br>Track Name: All Blues<br><br> I 2 katalogsläge ignoreras genrefältet';
$word_define_id3_strip = 'Detta verktyg tar bort Genre, Artist, Album, Spårnummer, Spårnamn värden från en MP3 ID3 tag';
$word_define_create_genre = 'Denna låter användaren skapa en ID3v1 tag vänlig Genre';
$word_define_delete_genre = 'Denna låter användaren ta bort en hel Genre, och ALLA underliggande filer<br><br>VAR AKTSAM!!!';
$word_define_ipod_sync = 'Denna låter användaren välja Artister som ska synkas med en iPod MP3 spelare med hjälp av ephPod';
$word_define_check_updates = 'Denna låter Jinzora kontakta huvudservern för att se om det finns en ny version tillgänglig eller inte';
$word_define_send_tech_info = 'Denna genererar en rapport som mailas till Jinzora tech support<br><br>ANVÄND INTE DENNA om tech support inte väntar mailet!';
$word_define_enter_setup = 'Denna återstartar konfigurationsprocessen för att underlätta konfigurationsändringar<br><br>NOTE:Kör configure.sh först!';
$word_define_start_shoutcast = 'Denna låter användaren starta Shoutcast servern, om användande av shoutcast är påkopplat';
$word_define_stop_shoutcast = 'Denna låter användaren stoppa Shoutcast servern, om användande av shoutcast är påkopplat';
$word_define_fix_media = 'Detta är några verktyg som hjälper till med hantering av flera filer samtidigt';
$word_define_update_cache = 'Denna uppdaterar den pågående sessionens cache information<br><br>Den ska köras om ändringar till fil- eller katalogstrukturen görs medan man aktivt använder Jinzora<br><br>Att cacha filerna på detta sätt gör Jinzora mycket snabbare';
$word_define_search_for_art = 'Denna presenterar skärmbilder för användaren, som visar möjliga skivomslag, album för album från images.google.com<br><br>Användaren kan välja det skivomslag han eller hon vill ha, eller det standard skivomslag som systemet genererar';
$word_define_rewrite_from_id3 = 'Detta verktyg skriver alla filnamn med hjälp av ID3 tag informationen för varje spår och spårnamn<br><br>NOTERA: Det första spår separatorvärdet  - om det är flera - blir spårseparator för de nya filnamnen';
$word_change_art = 'Ändra skivomslag';
$word_survey = 'Jinzora Enkät';
$word_define_survey = 'En enkel enkät så vi får reda på hur Jinzora används i syfte att gör det bättre!';
$word_user_manager = 'Användaradministration';
$word_define_user_manager = 'Ger dig möjlighet att ge olika behörighet till användare';
$word_add_user = 'Lägg till användare';
$word_access_level = 'Behörighetsnivå';
$word_update_successful = 'Uppdateringen lyckades!';
$word_send_playlist = 'Sänd Spellista';
$word_rate = 'Bedöm denna post';
$word_discuss = 'Diskutera denna post';
$word_new = 'Ny!';
$word_editcomment = 'Ändra kommentar';
$word_rewrite_tags = 'Skriv om ID3 Taggar';
$word_media_management = 'Media administration';
$word_actions = 'Åtgärder';
$word_group_features = 'Grupp egenskaper';
$word_item_information = 'Post Information';
$word_browse_album = 'Titta på Album';
$word_new_from = 'Ny sedan: ';
$word_new_from_last = 'Ny sedan senaste: ';
$word_jukebox_controls = 'Jukebox Kontroller';
$word_pause = 'Paus';
$word_stop = 'Stoppa';
$word_next = 'Nästa';
$word_previous = 'Föregående';
$word_volume = 'Vol';
$word_mute = 'Tyst';
$word_up = 'Upp';
$word_down = 'Ner';
$word_nowplaying = 'Spelas nu';
$word_refresh_in = 'Uppdatera om:';
$word_upcoming = 'Kommande Spår';
$word_stopped = 'Stannad';
$word_next_track = 'Nästa Spår';
$word_pause = 'Pausad';
$word_playback_to = 'Spela av till:';
$word_jukebox = 'Jukebox';
$word_stream = 'Ström';
$word_information = 'Sök';
$word_echocloud = 'Echocloud liknande';
$word_clear = 'ta bort spellista';
$word_bulk_edit = 'Ändra flera';
$word_complete_playlist = 'Fullständig Spellista';
$word_add_at = 'Lägg till vid:';
$word_current = 'Nuvarande';
$word_end = 'Slut';
$word_add_to_favorites = 'Lägg till nuvarande spår till Favoriter';
$word_noacess = 'Tyvärr, du har inte tillräcklig behörighet!';
$word_pleasewait = 'Vänta medan du loggas in...';
$word_play_lofi = 'Spela Lo-Fi';
$word_lofi = 'Lo-Fi';
$word_donate = 'Donera till Jinzora!';
$word_define_word_donate = 'Donera till Jinzora Development Team!';
$word_description = 'Beskrivning:';
$word_exclude_genre = 'Uteslut Genre';
$word_update_description = 'Uppdatera Beskrivning';
$word_close = 'Stäng';
$word_update_close = 'Uppdatera & Stäng';
$word_short_description = 'Kort Beskr.:';
$long_short_description = 'Lång Beskr.:';
$word_artist_image = 'Artist Bild:';
$word_new_image = 'Ny Bild:';
$word_delete_artist = 'Ta bort Artist';
$word_exclude_artist = 'Uteslut Artist';
$word_album_name = 'Album Namn:';
$word_album_description = 'Album Beskrivning:';
$word_album_image = 'Album Bild:';
$word_album_year = 'Album År:';
$word_delete_album = 'Ta bort Album';
$word_global_exclude = 'Uteslut globalt';
$word_track_number = 'Spår nummer:';
$word_track_name = 'Spår namn:';
$word_file_name = 'Fil namn:';
$word_not_writable = 'Går ej att skriva!!!';
$word_track_time = 'Spår tid:';
$word_bit_rate = 'Bit Rate:';
$word_sample_rate = 'Sample Rate:';
$word_file_size = 'Fil storlek:';
$word_file_date = 'Fil datum:';
$word_id3_description = 'ID3 Beskrivning:';
$word_thumbnail = 'Miniatyr:';
$word_search_lyrics = 'Sök automatiskt efter sångtexter';
$word_update = 'Uppdatera';
$word_search_new = 'Sök efter ny Media';
$word_search_new_define = 'Söker efter och visar ny media som definierat i settings filen';
$word_new_media = 'Ny Media';
$word_updating_information = 'Uppdaterar Information om: ';
$word_please_wait_artist = 'Vänta medan vi uppdaterar alla spår av denna artist...<br>Det här kan ta en stund...';
$word_updating_track = 'Uppdaterar spår';
$word_updating_album = 'Updaterar album';
$word_please_wait = 'Vänta...';
$word_tracks = 'Spår';
$word_plays = 'spelar';
$word_downloads = 'nedladdningar';
$word_select_destination = 'Välj Destination';
$word_dest_path = 'Destinationssökväg';
$word_add_files = 'Lägg till filer...';
$word_upload = 'Ladda upp';
$word_clear_list = 'Rensa listan';
$word_current_file = 'Nuvarande fil';
$word_total_complete = 'Komplett';
$word_new_subdirectory = 'Ny Underkatalog';
$word_select = 'Välj';
$word_up_onelevel = 'Upp en nivå';
$word_subdirs = 'Underkataloger';
$word_finished = 'Uppladdning avslutad!';

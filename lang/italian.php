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
* http://jinzora.jasbone.com
* Documentation: http://jinzora.jasbone.com/docs
* Support: http://jinzora.jasbone.com/forum
* Downloads: http://jinzora.jasbone.com/downloads
* License: GNU GPL <http://www.gnu.org/copyleft/gpl.html>
*
* Contributors:
* Please see http://jinzora.jasbone.com/modules.php?op=modload&name=jz_whois&file=index
*
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

/* Let's define all the words here */
$word_genres = 'Generi'; /*Sarebbe Generi ma ho messo Categorie*/
$word_genre = 'Genere'; /*Sarebbe Genere ma ho messo Categoria*/
$word_search_results = 'Risultati della ricerca';
$word_tools = 'Strumenti';
$word_search = 'Cerca:';
$word_artist = 'Artisti';
$word_album = 'Album'; /*Sarebbe Album ma avevo messo "" */
$word_pleasechoose = 'Prego scegli...';
$word_play = 'Play';
$word_play_all_albums_from = 'Suona tutti gli Album da:';
$word_randomize_all_albums_from = 'Suona a caso tutti gli Album da:';
$word_play_album = 'Suona Album';
$word_download_album = 'Scarica Album';
$word_id3_tag_tools = 'Strumenti per Tag ID3 degli MP3';
$word_update_id3v1 = 'Aggiorna ID3 Tags';
$word_update_id3v1_desc = 'Crea dinamicamente tutti i tag ID3 da Genere/Artista/Album/Numero traccia - Nome file';
$word_strip_id3v1_desc = 'Togli tutti i tag ID3 da tutti i file';
$word_update_id3v2 = 'Aggiorna i tag ID3';
$word_update_id3v2_desc = 'Crea dinamicamente tutti i tag ID3 da Genere/Artista/Album/Numero traccia - Nome file';
$word_strip_id3v2_desc = 'Cancella tutti i tag ID3 da tutti i file';
$word_strip_id3v1 = 'Togli tag ID3';
$word_strip_id3v2 = 'Togli tag ID3';
$word_directory_other_tools = 'Directory | Strumenti File | Strumenti vari';
$word_upload_center = 'Upload Center';
$word_select_for_ipod = 'Scegli per iPod Sync';
$word_fix_file_case = 'Aggiusta MAIUSC/minusc per nomi file';
$word_create_new_genre = 'Crea nuovo Genere';
$word_delete_genre = 'Cancella Genere';
$word_upload_to_jinzora = 'Carica Musica su Jinzora';
$word_ipod_select_desc = 'Permetti agli Artisti di essere selezionati per il Sync verso un iPod usando ephPod';
$word_fix_file_case_desc = 'Metti a tutte le parole la prima lettera Maiuscola';
$word_create_new_genre_desc = 'Aggiungi un nuovo Genere a Jinzora';
$word_delete_genre_desc = 'Cancella un Genere da Jinzora';
$word_add_to = 'Aggiungi a:';
$word_delete = 'Cancella';
$word_download = 'Download';
$word_return_home = 'Torna a Home';
$word_more = 'Altro';
$word_play_random = 'Suona un brano a caso';
$word_move_item = 'Sposta oggetto';
$word_login = 'Login';
$word_random_select = 'Genera causalmente:';
$word_logout = 'Esci';
$word_up_level = 'Su di un Livello';
$word_down_level = 'Giù di un Livello';
$word_enter_setup = 'Entra nel Setup';
$word_go_button = 'Vai';
$word_username = 'Username:';
$word_password = 'Password:';
$word_home = 'Home';
$word_language = 'Lingua:';
$word_theme = 'Tema';
$word_secure_warning = "Jinzora non è sicuro, lancia 'sh secure.sh' sulla shell!";
$word_check_for_update = 'Controlla se esistono update per Jinzora';
$word_new_genre = 'Nuovo Genere:';
$word_search_for_album_art = 'Cerca immagini di Album';
$word_cancel = 'Annulla';
$word_are_you_sure_delete = 'Sei sicuro di voler cancellare:';
$word_playlist = 'Playlist';
$word_check_all = 'Seleziona tutto';
$word_check_none = 'Nessuno';
$word_selected = 'Selezionati';
$word_session_playlist = ' - Playlist della sezione - ';
$word_new_playlist = ' - Nuova Playlist - ';
$word_send_tech_email = 'Manda informazioni tecniche al supporto';
$word_auto_update = 'Auto update';
$word_auto_update_beta = 'Auto update (beta release)';
$word_rewrite_files_from_id3 = 'Riscrivi nomi dei file in base alle info dei tag ID3';
$word_create_shoutcast_playlist = 'Crea Playlint di Shoutcast';
$word_hide_tracks = 'Nascondi Tracce';
$word_show_tracks = 'Mostra Tracce';
$word_shoutcast_tools = 'Strumenti di Shoutcast';
$word_start_shoutcast = 'Avvia il server Shoutcast';
$word_stop_shoutcast = 'Ferma il server Shoutcast';
$word_create_shoutcast_random_playlist = 'Randomizza la Playlist di Shoutcast';
$word_fix_media_names = 'Aggiusta i nomi dei file dei media';
$word_remember_me = 'Ricordati di me';
$word_show_hidden = 'Mostra nascosti';
$word_update_cache = 'Aggiorna Cache';
$word_search_missing_album_art = 'Cerca immagini mancanti di Album';
$word_define = 'Definisci';
$word_define_uc = "L'Upload Center permette agli utenti di aggiungere file in Jinzora";
$word_define_id3_update = 'Questo strumento permette di aggiornare dinamicamente tutti i tag ID3 su tutti i file  MP3 usando i dati dalla struttura di cartelle<br><br>Per esempio in modalità a 3 cartelle:<br><br>Jazz/Miles Davis/Kind of Blue/01 - All Blues.mp3<br><br>...becomes...<br><br>Genere: Jazz<br>Artista: Miles Davis<br>Album: Kind of Blue<br>Numero traccia: 01<br>Track Nome: All Blues<br><br>Nella modalità a 2 cartelle il campo Genere è ignorato';
$word_define_ipod_sync = "Questo permette all'utente di selezionare gli Artisti da sincronizzare con un iPod 	usando ephPod";
$word_define_check_updates = "Questo permette a Jinzora di controllare se c'è una nuova versione di Jinzora 	disponibile o meno";
$word_define_enter_setup = 'Questo fa ripartire il processo di setup per rendere più semplici cambi di configurazione<br><br>NB: Prima lancia configure.sh !';
$word_define_start_shoutcast = "Questo permette all'utente di avviare il server Shoutcast, sempre che lo 	shoutcasting sia abilitato";
$word_define_stop_shoutcast = "Questo permette all'utente di stoppare il server Shoutcast server, sempre che lo shoutcasting sia abilitato";
$word_define_update_cache = 'Questo aggiorna le informazioni della cache della corrente sessione<br><br>Questo dovrebbe essere lanciato se i cambi a file o alla struttura delle cartelle sono fatti mentre si sta sfogliando attivamente<br><br>Questo rende Jinzora più veloce';
$word_define_search_for_art = "Questo presenta all'utente le schermate di una possibile immagine di Album, album per album da images.google.com<br><br>L'utente può scegliere l'immagine che vuole o quella di default generata dal sistema";
$word_define_rewrite_from_id3 = 'Questo strumento ri-scriverà tutti i nomi dei file usando le info dai tag ID3 dal numero di traccia e dal nome della traccia<br><br>NB: Il primo separatore di traccia -se ce ne sono molti - diventerà il separatore di traccia per i nuovi nomi di file';
$word_change_art = 'Cambia Immagine';
$word_survey = 'Sondaggio di Jinzora';
$word_user_manager = 'Gestione utenti';
$word_define_user_manager = 'Ti permette di dare differenti permessi ad utenti diversi';
$word_add_user = 'Aggiungi utente';
$word_access_level = 'Livello di accesso';
$word_update_successful = 'Aggiornamento riuscito!';
$word_send_playlist = 'Spedisci Playlist';
$word_rate = 'Vota questa traccia';
$word_discuss = 'Commenta questo oggetto';
$word_new = 'Nuovo!';
$word_editcomment = 'Modifica commento';
$word_rewrite_tags = 'Riscrivi i tag ID3';
$word_media_management = 'Gestione Media';
$word_actions = 'Azioni';
$word_group_features = 'Group Features';
$word_item_information = 'Informazioni oggetto';
$word_browse_album = 'Sfoglia gli Album';
$word_new_from = 'Novità da: ';
$word_new_from_last = "Novità dall'ultimo: ";
$word_jukebox_controls = 'Controlli Jukebox';
$word_pause = 'Pausa';
$word_stop = 'Stop';
$word_next = 'Prossimo';
$word_previous = 'Precedente';
$word_volume = 'Volume';
$word_mute = 'Muto';
$word_up = 'Su';
$word_down = 'Giù';
$word_nowplaying = 'Ora in linea';
$word_refresh_in = 'Refresh in:';
$word_upcoming = 'Prossime tracce:';
$word_stopped = 'Fermato';
$word_next_track = 'Prossima traccia';
$word_pause = 'In pausa';
$word_playback_to = 'Playback a:';
$word_jukebox = 'Jukebox';
$word_stream = 'Stream';
$word_information = 'Cerca';
$word_echocloud = 'Echocloud Simili';
$word_clear = 'Pulisci Playlist';
$word_bulk_edit = 'Edit di massa';
$word_complete_playlist = 'Completa Playlist';
$word_add_at = 'Aggiungi a:';
$word_current = 'Corrente';
$word_end = 'Fine';
$word_add_to_favorites = 'Aggiungi traccia corrente ai preferiti';
$word_noacess = 'Mi spiace, accesso non autorizzato!';
$word_pleasewait = 'Prego attendere. Connessione in corso...';
$word_play_lofi = 'Play Lo-Fi';
$word_lofi = 'Lo-Fi';
$word_donate = 'Donazioni a Jinzora!';
$word_define_word_donate = 'Dona al gruppo di sviluppo di Jinzora!';
$word_description = 'Descrizione:';
$word_exclude_genre = 'Escludi Genere';
$word_update_description = 'Aggiorna Descrizione';
$word_close = 'Chiudi';
$word_update_close = 'Aggiorna & chiudi';
$word_short_description = 'Descrizione breve:';
$long_short_description = 'Descrizione lunga:';
$word_artist_image = 'Immagine Artista:';
$word_new_image = 'Nuova Immagine:';
$word_delete_artist = 'Cancella Artista';
$word_exclude_artist = 'Escludi Artista';
$word_album_name = 'Nome Album:';
$word_album_description = 'Descrizione Album:';
$word_album_image = 'Immagine Album:';
$word_album_year = 'Anno Album:';
$word_delete_album = 'Cancella Album';
$word_global_exclude = 'Escludi globalmente';
$word_track_number = 'Numero Traccia:';
$word_track_name = 'Nome Traccia:';
$word_file_name = 'Nome File:';
$word_not_writable = 'Non Scrivibile!!!';
$word_track_time = 'Tempo Traccia:';
$word_bit_rate = 'Bit Rate:';
$word_sample_rate = 'Sample Rate:';
$word_file_size = 'Dimensione File:';
$word_file_date = 'Data del File:';
$word_id3_description = 'Descrizione ID3:';
$word_thumbnail = 'Thumbnail:';
$word_search_lyrics = 'Ricerca automatica di Testi';
$word_update = 'Aggiorna';
$word_search_new = 'Cerca Nuovi Media';
$word_search_new_define = 'Cerca e mostra nuovi media come definito nel file dei setting';
$word_new_media = 'Nuovi Media';
$word_updating_information = 'Aggiornando le informazioni su: ';
$word_please_wait_artist = 'Prego attendere mentre aggioniamo tutte le tracce di questo Artista...<br>Potrebbe servire qualche secondo...';
$word_updating_track = 'Aggiornando le Tracce';
$word_updating_album = 'Aggiornando gli Album';
$word_please_wait = 'Prego attendere...';
$word_tracks = 'Tracce';
$word_plays = 'plays';
$word_downloads = 'download';
$word_select_destination = 'Seleziona Destinazione';
$word_dest_path = 'Percorso Destinazione';
$word_add_files = 'Aggiunge file...';
$word_upload = 'Upload';
$word_clear_list = 'Cancella lista';
$word_current_file = 'File corrente';
$word_total_complete = 'Totale Completati';
$word_new_subdirectory = 'Nuova sottodirectory';
$word_select = 'Seleziona';
$word_up_onelevel = 'Su di un livello';
$word_subdirs = 'Sottodirectory';
$word_finished = 'Upload completo!';
$word_create_low_fi = 'Crea Lo-Fi';
$word_delete_low_fi = 'Cancella Lo-Fi';




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
$word_genres = 'Genres';
$word_genre = 'Genres';
$word_search_results = 'Résultats de la Recherche';
$word_tools = 'Outils';
$word_search = 'Recherche:';
$word_artist = 'Artistes';
$word_album = 'Albums';
$word_pleasechoose = 'Choisissez svp...';
$word_play = 'Lecture';
$word_play_all_albums_from = 'Lecture de tous les albums de:';
$word_randomize_all_albums_from = 'Lecture aléatoire de tous les albums de:';
$word_play_album = "Lecture de l'album entier";
$word_download_album = "Télécharger l'album";
$word_id3_tag_tools = 'Outils de tags ID3';
$word_update_id3v1 = 'Mise à jour des tags ID3v1';
$word_update_id3v1_desc = 'Création dynamique de tous les tags ID3v1 à partir de Genre/Artiste/Album/Numéro de Piste - Nom de fichier';
$word_strip_id3v1_desc = 'Suppression de tous les tags ID3v1 de tous les fichiers';
$word_update_id3v2 = 'Mise à jour des tags ID3v2';
$word_update_id3v2_desc = 'Création dynamique de tous les tags ID3v2 à partir de Genre/Artiste/Album/Numéro de Piste - Nom de fichier';
$word_strip_id3v2_desc = 'Suppression de tous les tags ID3v2 de tous les fichiers';
$word_strip_id3v1 = 'Suppression des tags ID3v1';
$word_strip_id3v2 = 'Suppression des tags ID3v2';
$word_directory_other_tools = 'Annuaire | Outils de Fichier | Outils Divers';
$word_upload_center = "Centre d'envois";
$word_select_for_ipod = 'Séléctionner pour syncronisation avec un iPod';
$word_fix_file_case = 'Réparer la casse du nom de fichier';
$word_create_new_genre = 'Créer un nouveau genre';
$word_delete_genre = 'Effacer le Genre';
$word_upload_to_jinzora = 'Envoyer la Musique à Jinzora';
$word_ipod_select_desc = 'Permet de choisir des Artistes pour Synchroniser un iPod grace à ephPod';
$word_fix_file_case_desc = 'Change la première lettre en majusucle pour tous mots';
$word_create_new_genre_desc = 'Ajoute un nouveau Genre à Jinzora';
$word_delete_genre_desc = 'Efface un Genre de Jinzora';
$word_add_to = 'Ajouter à:';
$word_delete = 'Effacer';
$word_download = 'Téléchargement';
$word_return_home = "Retourner à l'accueil";
$word_more = 'Plus';
$word_play_random = 'Lecture aléatoire';
$word_move_item = "Déplacer l'élément";
$word_login = "S'identifier";
$word_random_select = 'Générer au hasard:';
$word_logout = 'Sortie du système';
$word_up_level = 'Niveau supèrieur';
$word_down_level = 'Niveau infèrieur';
$word_enter_setup = 'Paramètres';
$word_go_button = 'OK';
$word_username = "Nom d'utilisateur:";
$word_password = 'Mot de passe:';
$word_home = 'Accueil';
$word_language = 'Langue:';
$word_theme = 'Thème:';
$word_secure_warning = "Jinzora n'est pas sécurisé, éxécutez 'sh secure.sh' s'il vous plaît";
$word_check_for_update = 'Chercher les mises à jour de Jinzora';
$word_new_genre = 'Nouveau Genre:';
$word_search_for_album_art = "Chercher l'image d'album pour";
$word_cancel = 'Annuler';
$word_are_you_sure_delete = 'Etest vous sûr de vouloir effacer:';
$word_playlist = 'Liste de lecture';
$word_check_all = 'Tous';
$word_check_none = 'Aucun';
$word_selected = 'Choisi';
$word_session_playlist = ' - Liste de lecture de session - ';
$word_new_playlist = ' - Nouvelle liste de lecture - ';
$word_send_tech_email = 'Envoyer un message au support technique';
$word_auto_update = 'Mise à jour automatique';
$word_auto_update_beta = 'Mise à jour automatique (version de bêta)';
$word_rewrite_files_from_id3 = 'Mise à jour des noms de fichiers à partir des tags ID3';
$word_create_shoutcast_playlist = 'Créer une liste de lecture Shoutcast';
$word_hide_tracks = 'Cacher les pistes';
$word_show_tracks = 'Montrer les pistes';
$word_shoutcast_tools = 'Outils Shoutcast';
$word_start_shoutcast = 'Lancer le serveur Shoutcast';
$word_stop_shoutcast = 'Arreter le serveur Shoutcast';
$word_create_shoutcast_random_playlist = 'Créer une liste de lecture Shoutcast aléatoire';
$word_fix_media_names = 'Réparer les noms de fichiers';
$word_remember_me = 'Se souvenir de moi';
$word_show_hidden = 'Afficher les pistes cachées';
$word_update_cache = 'Mettre à jour le Cache';
$word_search_missing_album_art = 'Chercher les images manquantes';
$word_define = 'Définition';
$word_define_uc = "Le centre d\\'envois permet aux utiliateurs d\\'envoyer des fichiers à Jinzora";
$word_define_id3_update = "Cet outils permet à l\\'utilisateur de mettre à jour dynamiquement tous les tags ID3 de tous les fichiers MP3 en utilisant la structure des répertoires<br><br>Par exemple dans le mode 3 répertoires:<br><br>Jazz/Miles Davis/Kind of Blue/01 - All Blues.mp3<br><br>...deviens...<br><br>Genre: Jazz<br>Artiste: Miles Davis<br>Album: Kind of Blue<br>Piste numéro: 01<br>Nom: All Blues<br><br>Dans le mode 2 répertoires, le champs Genre est ignoré";
$word_define_ipod_sync = "Permet à l\\'utilisateur de selectionner des artistes pour une synchronisation avec un lecteur MP3 iPod, en utilisant ephPod";
$word_define_check_updates = "Permet à Jinzora de verifier la disponibilité d\\'une nouvelle version sur le serveur mère";
$word_define_enter_setup = "Redémarre le processus d\\'installation pour faciliter le changement des paramètres<br><br>NOTE: Lancez configure.sh avant svp!";
$word_define_start_shoutcast = "Permet à l\\'utilisateur de démarrer le serveur Shoutcast, si la difusion est activée";
$word_define_stop_shoutcast = "Permet à l\\'utilisateur d'arreter le serveur Shoutcast, si la difusion est activée";
$word_define_update_cache = 'Mets à jour les informations contenues dans le cache<br><br>Devrait être lancé si des changements au fichiers ou au répertoires ont lieu pendant la navigation<br><br>Cette methode de mise en cache rend Jinzora beaucoup plus rapide';
$word_define_search_for_art = "Présente à l\\'utilisateur des écrans d\\'images d\\'album, album par album, depuis images.google.com<br><br>L\\'utilisateur peut choisir l\\'image qu\\'il veut, ou l\\'image par defaut générée par le système";
$word_define_rewrite_from_id3 = 'Cet outil re-écrit tous les noms de fichiers en utilisant les numéros de pistes et noms contenus dans les tags ID3<br><br>NOTE: Le premiere séparateur - si il y en a plusieurs - sera utilisé pour les nouveaux noms de fichier';
$word_change_art = "Changer l'image";
$word_survey = 'Sondage Jinzora';
$word_define_survey = "Un simple sondage pour nous renseigner sur l'utilisation de Jinorza et permettre son amélioration!";
$word_user_manager = "Gestionnaire d'utilisateurs";
$word_define_user_manager = 'Permet de donner differentes permissions à chaque utilisateur';
$word_add_user = 'Ajouter un utilisateur';
$word_access_level = "Niveau d'accès";
$word_update_successful = 'Mise à jour réussie!';
$word_send_playlist = 'Envoyer la liste de lecture';
$word_rate = 'Noter cette piste';
$word_discuss = 'Discuter de cet élément';
$word_new = 'Nouveau!';
$word_editcomment = 'Editer le commentaire';
$word_rewrite_tags = 'Re-écrire les tags ID3';
$word_media_management = 'Gestion des médias';
$word_actions = 'Actions';
$word_group_features = 'Fonctions de groupe';
$word_item_information = "Informations sur l'élément";
$word_browse_album = "Parcourir l'album";
$word_new_from = 'Nouveau depuis: ';
$word_new_from_last = 'Nouveau depuis le dernier: ';
$word_jukebox_controls = 'Contrôles du Jukebox';
$word_pause = 'Pause';
$word_stop = 'Stop';
$word_next = 'Suivant';
$word_previous = 'Précédent';
$word_volume = 'Vol';
$word_mute = 'Silence';
$word_up = 'Haut';
$word_down = 'Bas';
$word_nowplaying = 'Piste en cours';
$word_refresh_in = 'Rafraichissement dans:';
$word_upcoming = 'Pistes à venir:';
$word_stopped = 'Arrété';
$word_next_track = 'Piste suivante';
$word_pause = 'En pause';
$word_playback_to = 'Jouer à:';
$word_jukebox = 'Jukebox';
$word_stream = 'Flux';
$word_information = 'Chercher';
$word_echocloud = 'Recommendation Echocloud';
$word_clear = 'Effacer la liste de lecture';
$word_bulk_edit = 'Edition simple';
$word_complete_playlist = 'Finir la liste de lecture';
$word_add_at = 'Ajouter à:';
$word_current = 'Courant';
$word_end = 'Fin';
$word_add_to_favorites = 'Ajouter la piste courante aux favoris';
$word_noacess = "Désolé, vous n'avez pas accé!";
$word_pleasewait = "S'il vous plaît, patientez pendant votre entrée dans le système...";
$word_play_lofi = 'Jouer en basse fidelité';
$word_lofi = 'basse fidelité';
$word_donate = 'Donner à Jinzora!';
$word_define_word_donate = "Donner à l\\'équipe de développement de Jinzora!";
$word_description = 'Description:';
$word_exclude_genre = 'Exclure le Genre';
$word_update_description = 'Mise à jour de la description';
$word_close = 'Fermer';
$word_update_close = 'Metre à jour & Fermer';
$word_short_description = 'Courte Desc:';
$long_short_description = 'Longue Desc:';
$word_artist_image = 'Image de l\'Artiste:';
$word_new_image = 'Nouvelle Image:';
$word_delete_artist = 'Effacer l\'Artiste';
$word_exclude_artist = 'Exclure l\'Artiste';
$word_album_name = 'Nom de l\'Album:';
$word_album_description = 'Description de l\'Album :';
$word_album_image = 'Image de l\'Album:';
$word_album_year = 'Année de l\'Album:';
$word_delete_album = 'Effacer l\'Album';
$word_global_exclude = 'Exclure globalement';
$word_track_number = 'Piste numéro:';
$word_track_name = 'Nom de la Piste:';
$word_file_name = 'Nom du Fichier:';
$word_not_writable = 'En lecture seule!!!';
$word_track_time = 'Durée de la Piste:';
$word_bit_rate = 'Bit Rate:';
$word_sample_rate = 'Sample Rate:';
$word_file_size = 'Taille du Fichier:';
$word_file_date = 'Date du Fichier:';
$word_id3_description = 'Description ID3:';
$word_thumbnail = 'Miniature:';
$word_search_lyrics = 'Recherche automatique des paroles';
$word_update = 'Mise à jour';
$word_search_new = 'Recherche de nouveau média';
$word_search_new_define = 'Recherche et affiche les nouveaux média comme définit dans le fichier "settings"';
$word_new_media = 'Nouveau Média';
$word_updating_information = 'Mise à jour des informations de: ';
$word_please_wait_artist = 'Merci de patineter pendant que nous mettons à jour toutes les pistes de cet artiste...<br>Cela peut prendre un peu de temps...';
$word_updating_track = 'Mise à jour de la Piste';
$word_updating_album = "Mise à jour de l'Album";
$word_please_wait = 'Patientez SVP...';
$word_tracks = 'Pistes';
$word_plays = 'lectures';
$word_downloads = 'téléchargements';
$word_select_destination = 'Choisir la Destination';
$word_dest_path = 'Répertoire de Destination';
$word_add_files = 'Ajouter des fichiers...';
$word_upload = 'Envoyer';
$word_clear_list = 'Effacer la liste';
$word_current_file = 'Fichier courant';
$word_total_complete = 'Total';
$word_new_subdirectory = 'Nouveau sous-répertoire';
$word_select = 'Séléctionner';
$word_up_onelevel = "Retour d'un niveau";
$word_subdirs = 'sous-répertoires';
$word_finished = 'Envois terminé!';
$word_new_subdirectory = 'Nouveau sous-répertoire';
$word_select = 'Séléctionner';
$word_up_onelevel = 'Niveau supèrieur';
$word_subdirs = 'sous-répertoires';
$word_create_low_fi = 'Créer basse fidelité';
$word_delete_low_fi = 'Effacer basse fidelité';
$word_add_fake_track = 'Ajouter une fausse piste';
$word_error = 'Erreur!';
$word_today = "Aujourd\\'hui";
$word_yesterday = 'Hier';
$word_days_of_week = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
$word_logged_in_pre = "Vous avez un niveau d'accès";
$word_logged_in_post = '';
$word_top = 'Top';
$word_top_rated = 'mieux notées';
$word_top_played = 'plus jouées';

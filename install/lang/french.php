<?php

// Let's set some default values
if (!isset($href_path)) {
    $href_path = '';
}
if (!isset($href_path2)) {
    $href_path2 = '';
}
$word_requirements = 'Prérequis Jinzora';
$word_primary_settings = 'Paramètres Principaux';
$word_display_settings = "Paramètres d'affichage";
$word_verify_config = 'Vérifier la Configuration';
$word_write_error = "Désolé, mais je n'ai pas pu ouvrir le fichier de paramètres ou la base donnée des utilisateurs en écriture<br><br>"
                                       . 'Vous pouvez soit faire un copier-coller du contenu suivant<br><br>...ou...<br><br>'
                                       . '<a href='
                                       . $href_path
                                       . '&action=save-config>Cliquer Ici</a> pour télécharger le fichier de paramètres<br>'
                                       . '<a href='
                                       . $href_path
                                       . '&action=save-user>Cliquer Ici</a> pour télécharger la base donnée des utilisateurs<br><br><br>'
                                       . 'Une fois terminé, <a href='
                                       . $href_path2
                                       . '>Cliquer Ici</a> pour lancer Jinzora!';
$word_admin_username = "Nom d'utilisateur de l'administrateur:";
$word_admin_username_note = "NOTE: Pour une installation dans un CMS, vous DEVEZ choisir le même nom d'utilisateur" . "que l'administrateur utilise dans le CMS";
$word_admin_password = "Mot de passe de l'administrateur:";
$word_web_root = 'Répertoire racine du serveur web:';
$word_web_root_note = 'Doit être le chemin physique de la racine de votre serveur web. ' . 'Donc si votre serveur web est dans /var/www, vous devez utiliser ça ici (SANS slash final!)<br><br>';
$word_jinzora_directory = 'Répertoire de Jinzora:';
$word_jinzora_directory_note = "C'est le répertoire racine de Jinzora, relatif au répertoire racine de votre serveur web. <br><br>";
$word_media_directory = 'Répertoire des Médias:';
$word_media_directory_note = "C'est le répertoire racine de votre collection de médias." . 'La valeur par défaut devrait fonctionner correctement avec les MP3 inclus en test.<br><br>';
$word_media_directory_structure = 'Structure de Répertoire des Médias:';
$word_media_directory_structure_note = 'Indique à Jinzora combien de répertoires traverser en cherchant les médias. ' . "Jinzora les affichera qu'il les trouve n'importe où, c'est seulement pour " . 'que Jinzora sache où sont les Artistes et les Albums<br><br>';
$word_install_type = "Type d'Installation:";
$word_install_type_note = 'Permet de choisir si Jinzora sera un module PostNuke, un module PHPNuke, ou une application indépendante.';
$word_cms_user_type = "Niveau d'accès CMS:";
$word_cms_user_type_note = "Pour une installation avec un CMS, définit le niveau d'accès pour les utilisateurs "
                                       . "enregistrés dans le CMS (par opposition à un utilisateur anonyme). Ce sont les utilisateurs enregistrés dans le CMS mais qui n'ont "
                                       . 'pas de droits spécifiques dans Jinzora.'
                                       . '<br><br>'
                                       . '<strong>NOTE:</strong> Tout droit spécifique écrasera ces paramètres pour un utilisateur donné';
$word_default_user_access = "Niveau d'accès par défaut:";
$word_default_user_access_note = "Définit le niveau d'accès par defaut à Jinzora (pour les utilisateurs non enregistrés).<br><br>";
$word_use_advanced_caching = 'Utilisation du cache avancé:';
$word_use_advanced_caching_note = "L'utilisation du cache avancé permet à Jinzora d'enregistrer toutes ses données dans des fichiers locaux sur le serveur. "
                                       . 'Cela peut améliorer dramatiquement la durée du chargement initial de Jinzora pour un gros site.<br>'
                                       . '<strong>NOTE:</strong> Si vous utilisez le cache avancé, vous DEVEZ aller dans la section outils '
                                       . "et lancer l'outil 'Mise à jour du Cache' pour reconstruire les fichiers de cache chaque fois qu'un changement est fait "
                                       . 'à votre collection de média';
$word_primary_language = 'Langue principale:';
$word_primary_language_note = 'Spécifie la langue utilisée par Jinzora. Les différents fichiers de langue ' . 'sont situés dans le répertoire /lang dans Jinzora. Lisez notre documentation pour ' . "plus d'informations sur la traduction de Jinzora dans une autre langue<br><br>";
$word_allow_language_change = 'Autoriser le changement de langue:';
$word_allow_language_change_note = "Détermine si l'utilisateur est autorisé ou pas à changer la langue utilisée en cours de fonctionnement<br><br>";
$word_theme = 'Theme:';
$word_theme_note1 = "Choisit le thème que Jinzora utilisera.<br><br>Images d'exemple:";
$word_theme_note2 = '<br><br>Pour créer des thèmes pour Jinzora, lisez notre <a href=http://jinzora.jasbone.com/modules.php?op=modload&name=jz_docs&file=eng-theme>Theme' . 'Development Guide</a> (en anglais) pour plus de détails<br><br>';
$word_javascript = 'JavaScript Activer/Désactiver:';
$word_javascript_note = 'Détermine si vous voulez activer ou désactiver tout le JavaScript dans Jinzora<br><br>';
$word_disable_all_downloads = 'Désactiver toutes les icônes de téléchargement:';
$word_disable_all_downloads_note = 'Mets en marche ou arrête la possibilité de télécharger dans tout le système, quelque '
                                       . "soit le niveau d'accès de l'utilisateur. Donc si vous voulez le désactiver ailleurs, choisissez 'non'."
                                       . "Note: Cela ne dois pas être pris en compte du point de vue sécurité, il s'agit seulement de cacher"
                                       . 'les icônes permettant de créer facilement des fichiers zip à télécharger<br><br>';
$word_download_type = 'Télécharger Zip ou MP3:';
$word_download_type_note = "Pour les téléchargements de simples fichiers, Jinzora peut créer des fichiers zip. Cela n'affecte PAS la création de fichier zip pour le téléchargement d'albums<br><br>";
$word_hide_when_found = 'Cacher les pistes isolées:';
$word_hide_when_found_note = "Jinzora peut 'cacher' les pistes qui se trouvent à d'autres endroits qu'un répertoire d'album. Cela affichera un bouton "
                                       . "'Afficher les Pistes' que vous pouvez cliquer pour les afficher. Peut être utile si vous avez BEAUCOUP de pistes dans des endroits bizarres<br><br>";
$word_auto_search_art = "Recherche automatique d'images d'album:";
$word_auto_search_art_note = "Jinzora peut chercher automatiquement des images d'album quand un artiste est affiché. Cela téléchargera "
                                       . "et sauvegardera la première image trouvée, ce qui tombe juste à peu près 70% du temps (ne vous en faites pas, vous pouvez changer l'image "
                                       . "téléchargée par Jinzora si vous ne l'aimez pas!)<br><br>";
$word_help_icon = "Quels utilisateurs voient l'icône d'aide:";
$word_help_icon_note = "Détermine quel type d'utilisateurs peut voir les icônes d'aide<br><br>";
$word_display_quick_drop = 'Afficher les listes déroulantes:';
$word_dispaly_quick_drop_note = "Détermine l'affichage des listes déroulantes dans l'en-tête.<br><br>";
$word_rating_system = 'Activer le système de notation';
$word_rating_system_note = 'Active le système de notation dans Jinzora<br><br>';
$word_jinzora_dir_success = 'Répertoire de médias Vérifié!<br>';
$word_jinzora_dir_failure = 'Problème avec le répertoire de médias!<br>';
$word_rating_dir_success = 'Répertoire de données Vérifié!<br>';
$word_rating_dir_failure = "Problème avec le répertoire de données!<br>&nbsp;&nbsp;&nbsp;Cela veut généralement dire que le répertoire 'data' n'a pas été crée<br>";
$word_setting_file_success = 'Fichier de paramètres Vérifié!<br>';
$word_setting_file_failure = "Problème avec le fichier de paramètres!<br>&nbsp;&nbsp;&nbsp;Cela veut généralement dire que le fichier 'settings.php' n'existe pas<br>";
$word_setting_write_success = 'Ecriture du fichier de paramètres OK!<br>';
$word_setting_write_failure = "Problème avec l'écriture du fichier de paramètres!<br>&nbsp;&nbsp;&nbsp;Cela veut généralement dire que le fichier 'settings.php' ne peut pas être écrit<br>";
$word_users_file_success = 'Fichier des utilisateurs Vérifié!<br>';
$word_users_file_failure = 'Problème avec le fichier des utilisateurs!<br>';
$word_users_write_success = 'Ecriture du fichier des utilisateurs OK!<br>';
$word_users_write_failure = "Problème avec l'écriture du fichier des utilisateurs!<br>";
$word_errors_found = "Des erreurs ont été trouvées, mais il se pourait qu'elles ne soient pas critiques. Passez les en revue et corrigez les si possible avant de continuer.<br><br>" . "Généralement sous *NIX, cela veut dire que vous n'avez pas lancé configure.sh";
$word_top_ratings = "Nombre de 'top' pistes:";
$word_top_ratings_note = "Combien de pistes afficher dans le 'top' des pistes sur la page principale<br>(0 désactivera cette option)";
$word_suggestions = 'Activer les suggestions:';
$word_suggestions_note = "Active l'utilisation des données du système de notation pour suggérer des pistes qu'il pourait apprécier à l'utilisateur";
$word_num_suggestions = 'Nombre de pistes suggérées:';
$word_num_suggestions_note = "Le nombre de pistes suggérées à afficher à l'utilisateur";
$word_optional_settings = 'Paramètres Optionnels';
$word_ipod_shoutcast = 'iPod, Shoutcasting et Mode Jukebox';
$word_enable_hits = 'Activer le compteur de chanson';
$word_enable_hits_note = "Active l'enregistrement du nombre de fois qu'une piste a été ajoutée à une liste de lecture (c'est à dire jouée). C'est " . "uniquement le nombre de fois qu'elle a été ajoutée, pas nécessairement le nombre de fois qu'elle a été écoutée";
$word_display_time = 'Afficher la durée de la piste:';
$word_display_time_note = "Active l'affichage de la durée de la piste quand elle est trouvée";
$word_display_rate = 'Afficher le bitrate de la piste:';
$word_display_rate_note = "Active l'affichage du bitrate auquel la piste a été encodée";
$word_display_feq = 'Afficher la fréquence de la piste:';
$word_display_feq_note = "Active l'affichage de la fréquence à laquelle la piste a été encodée";
$word_display_size = 'Afficher la taille de la piste';
$word_display_size_note = "Active l'affichage de la taille de la piste";
$word_enable_discussion = 'Activer les discussions';
$word_enable_discussion_note = 'Active le système de discussion inclus';
$word_new_range = 'Nouvel élément depuis:';
$word_new_range_note = "Spécifie combien de temps un nouvel élément sera marqué 'Nouveau'.<br>NOTE: Mettre 0 ici désactivera cette fonction";
$word_most_played = 'Afficher les pistes les plus demandées';
$word_most_played_note = "Active l'affichage des pistes les plus demandées sur la page principale";
$word_num_most_played = 'Nombre de pistes les plus demandées:';
$word_num_most_played_note = "Spécifie le nombre de piste à afficher lors de l'affichage des pistes les plus demandées";
$word_launch_note = 'NOTE: La première fois que Jinzora est lancé, il créera un cache. Pour une grosse collection cela peut prendre ' . 'un TRES long moment, merci de patienter...';
$word_install_type = "Type d'installation de Jinzora";
$word_simple_install = 'Installation Simple';
$word_simple_install_note = "Si vous voulez juste diffuser de la musique et vous n'avez pas besoin de fonctionnalités avancées";
$word_group_install = 'Installation Groupe';
$word_group_install_note = 'Si vous voulez activer les fonctionnalités de groupe<br>(comme les discussions, notes, top)';
$word_expert_install = 'Installation Expert';
$word_expert_install_note = 'Si vous voulez voir toutes les options et décider vous même';
$word_recomend_install = 'Installation Jinzora par défaut ';
$word_recomend_install_note = 'Vous ne savez pas quoi choisir? Prenez nos réglages par defaut.<br>Il semble que nous pouvons tout régler pour vous, alors laisser nous faire...';
$word_standalone_install = 'Installations autonomes';
$word_cms_install = 'Installation dans un CMS';
$word_cms_install_note = "L'Installation dans un CMS sélectionnera les options d'une Installation Groupe<br>(comme les discussions, notes, top)";
$word_postnuke = 'Postnuke';
$word_postnuke_note = 'Cela sélectionne les options pour le CMS Postnuke';
$word_phpnuke = 'PHPNuke';
$word_phpnuke_note = 'Cela sélectionne les options pour le CMS PHPNuke';
$word_nsnnuke = 'NSNNuke';
$word_nsnnuke_note = 'Cela sélectionne les options pour le CMS NSNNuke';
$word_upgrade_install = 'Mise à jour';
$word_upgrade_install_note = 'Conservera vos réglages<br>et ajoutera les paramètres recommandés par Jinzora';
$word_mambo = 'Mambo';
$word_mambo_note = 'Cela sélectionne les options pour le CMS Mambo';
$word_jukebox_intall = 'Installation Jukebox';
$word_jukebox_intall_note = 'Cela sélectionne les options par défaut pour utiliser Jinzora comme serveur Jukebox (pas de diffusion) ' . "Ces options sont pour une installation sous *NIX uniquement, en utilisant noxmms (lisez l'aide pour plus d'information à ce sujet svp)";
$word_jukebox_type = 'Type de Jukebox';
$word_jukebox_type_note = 'Séléctione le type de Jukebox que vous voulez utiliser';
$word_jukebox_settings = 'Paramètres de Jukebox';
$word_jukebox_settings_note = 'Ce sont les différentes options pour le mode Jukebox';
$word_num_upcoming = 'Nombre de pistes à venir à afficher';
$word_path_to_xmms_shell = "Chemin d'accès à xmms-shell";
$word_auto_refresh = 'Le temps (en secondes) que la page doit attendre avant de se rafraîchir<br>(pour mettre à jour la liste de lecture courante)';
$word_download_type = 'Type de fichiers téléchargés:';
$word_download_type_note = "Lors du téléchargement d'un album entier quel type de fichier doit être généré";
$word_single_download_type = 'Type de fichiers téléchargés (fichier unique):';
$word_single_download_type_note = "Lors du téléchargement d'un seul fichier quel type de fichier doit être généré";
$word_download_speed = 'Limiter la vitesse de téléchargement:';
$word_download_speed_note = "Jinzora peut réguler la vitesse à laquelle les éléments sont téléchargés. Cela n'affecte pas la vitesse de diffusion," . ' seulement la vitesse de téléchargement. 0 désactive cette fonctionnalité';
$word_date_format = 'Format de date:';
$word_date_format_note = "Le format d'affichage de dates avec la syntaxe PHP. Lisez <a target=_blank href=http://www.php.net/manual/fr/function.date.php>PHP Date Référence</a>" . " pour plus d'information sur l'utilisation de cette option";
$word_max_rss_feed_items = "Nombre d'éléments RSS:";
$word_max_rss_feed_items_note = "Spécifie le nombre maximum d'éléments que Jinzora va générer en créant un Newsfeeds RSS en XML";
$word_search_echocloud = 'Chercher Echocloud:';
$word_search_echocloud_note = "Active la recherche automatique d'artistes similaire dans la base de donnée <a href=http://www.echocloud>Echocloud</a> " . ' , et spécifie le nombre de résultats à retourner. 0 désactive cette fonctionnalité';
$install_message = "Notez que comme vous n'avez pas choisit l'installation Expert, les écrans suivants serons validé automatiquement " . "afin d'utiliser les défauts correspondant au type d'installation que vous avez choisi.\\n\\nMerci de patienter quelques secondes...";

$word_juekbox_pass = 'Mot de passe du serveur Jukebox:';
$word_jukebox_port = 'Port TCP du serveur Jukebox:';
$word_mdpro = 'MDPro';
$word_mdpro_note = 'Cela sélectionne les options pour le CMS MDPro';
$word_cgpnuke = 'CPGNuke';
$word_cgpnuke_note = 'Cela sélectionne les options pour le CMS CPGNuke';
$word_disable_random = 'Désactiver la lécture aléatoire:';
$word_disable_random_note = 'Cela désactivera toutes les icône de génération aléatoire';
$word_info_icons = "Qui peut voir les icônes d'information?";
$word_info_icons_note = "Spécifie quels utilisateurs peuvent voir les pages d'information";
$word_auto_search_lyrics = 'Recherche automatique des paroles:';
$word_auto_search_lyrics_note = "Active la recherche automatique des paroles sur le site \"Leo's Lyrics\" lors de l'affichage des détails d'une piste";
$word_cannot_open = "Impossible d'ouvrir le fichier en écriture...";
$word_next = 'Suivant';
$word_allow_theme_change = 'Authoriser le changement de Thème:';
$word_allow_theme_change_note = 'Spécifie si un utilisateur standard peut changer le theme de Jinzora pour la session courante';
$word_display_genre_drop = 'Afficher la liste déroulante de Genres :';
$word_display_genre_drop_note = "Spécifie si Jinzora affiche la liste déroulante de Genres dans l'en-tête";

$word_display_artist_drop = "Afficher la liste déroulante d'Artistes:";
$word_display_artist_drop_note = "Spécifie si Jinzora affiche la liste déroulante d'Artistes dans l'en-tête";
$word_display_album_drop = "Afficher la liste déroulante d'Albums:";
$word_display_album_drop_note = "Spécifie si Jinzora affiche la liste déroulante d'Albums dans l'en-tête";
$word_display_track_drop = 'Afficher la liste déroulante de Pistes:';
$word_display_track_drop_note = "Spécifie si Jinzora affiche la liste déroulante de Pistes dans l'en-tête<br><strong>WARNING:</strong> Pour un gros site, cela peut être INCROYABLEMENT lent!!!";
$word_display_quick_drop = 'Afficher la liste déroulante de lecture rapide:';
$word_display_quick_drop_note = "Spécifie si Jinzora affiche la liste déroulante de lecture rapide dans l'en-tête";
$word_num_other_albums = "Nombre d'autres albums:";
$word_num_other_albums_note = "Spécifie combien d'autres albums aléatoire (du même artiste) Jinzora va afficher lors de l'affichage des pistes d'un album (0 désactive cette fonction)";
$word_show_sub_totals = 'Afficher sous-totals:';
$word_show_sub_totals_note = "Si vous activez ça, Jinzora vous affichera les sub totaux (soit d'artistes soit d'albums) pour chaque Genre et/ou Artiste juste à côté du nom de Genre/Artiste.";
$word_show_amg_search = "Afficher 'Rechercher: AMG'";
$word_show_amg_search_note = "Active ou désactive les liens pour chercher des informations sur l'album courant sur AMG (allmusic.com)";
$word_show_search_art = "Afficher 'Rechercher des images d'album':";
$word_show_search_art_note = "Active ou désactive les liens pour chercher des images d'albums lors de l'affichage d'un album qui n'a pas encore d'image.<br>NOTE: Seuls les administrateurs peuvent voir cet outil!";
$word_show_all_checkboxes = 'Afficher toutes les cases à cocher:';
$word_show_all_checkboxes_note = "Active ou désactive l'affichage des cases à cocher sur les pages de Genre/Artistes pour ajouter facilement des éléments aux listes de lecture. C'est désactivé par défaut car l'affichage peut devenir brouillon...";
$word_album_art_dim = "Dimensions des images d'album:";
$word_album_art_dim_note = "Spécifie le redimensionnement des images d'albums trouvées.<br> NOTE: Les images resterons toujours de proportions correctes<br> NOTE: Mettre les deux à '0' désactivera cette fonctionnalité<br>"
                                    . '<strong>NOTE</strong>: Le serveur web DOIT avoir accès en écriture au dossier de médias pour que cette fonctionnalité marche<br> <strong>NOTE</strong>: La librairie GD DOIT être installer pour que cette fonctionnalité marche';
$word_force_dimensions = 'Forcer les dimensions:';
$word_force_dimensions_note = "Active la taille forcée des images sur la page des pistes.<br> NOTE: Cela ne redimensionne PAS le fichier, seulement l'affichage qui en est fait<br> NOTE: Mettre les deux à '0' désactivera cette fonctionnalité";
$word_artist_dimensions = "Dimensions des images d'artiste:";
$word_artist_dimensions_note = "Spécifie le redimensionnement des images d'artites trouvées.<br> NOTE: Les images resterons toujours de proportions correctes<br> NOTE: Mettre les deux à '0' désactivera cette fonctionnalité<br>"
                                    . '<strong>NOTE</strong>: Le serveur web DOIT avoir accès en écriture au dossier de médias pour que cette fonctionnalité marche<br> <strong>NOTE</strong>: La librairie GD DOIT être installer pour que cette fonctionnalité marche';
$word_keep_porpotions = 'Garder les proportions des images:';
$word_keep_porpotions_note = "Spécifie la conservation ou non des proportions lors du redimensionnement des images. Si vous utiliser 'Skew' les images seront redimensionnées aux format exact que vous avez spécifiées."
                                    . '<strong>NOTE</strong>: Le serveur web DOIT avoir accès en écriture au dossier de médias pour que cette fonctionnalité marche<br> <strong>NOTE</strong>: La librairie GD DOIT être installer pour que cette fonctionnalité marche';
$word_show_random_artist_art = "Afficher des images aléatoire sur la page d'artiste:";
$word_show_random_artist_art_note = "Spécifie combien (ou aucun) d'image d'album aléatoire afficher lors de l'affichage d'un Genre.<br><strong>NOTE</strong>: Vous DEVEZ être dans le mode Genre/Artiste/Album.<br><strong>NOTE</strong>: 0 désactive cette fonctionnalité.";
$word_sort_by_year = 'Trier les albums par année:';
$word_sort_by_year_note = "Active le tri d'albums par année en lisant les tags ID3 (si disponibles) des fichiers contenus dans le répertoire de l'album";
$word_pull_media_info = 'Lire les informations dans les fichiers de média:';
$word_pull_media_info_note = "Active ou désactive l'examen des MP3 pour lire leurs informations (comme le tag ID3, la taille du fichier, la durée, le bitrate, etc)";
$word_hide_id3_comments = 'Cacher les commentaires ID3:';
$word_hide_id3_comments_note = "Active ou désactive l'affichage du contenu du champs commentaire des tags ID3 sous le nom de la piste si il existe";
$word_show_loggedin_level = "Afficher le niveau d'accès de l'utilisateur:";
$word_show_loggedin_level_note = "Active ou désactive l'affichage du niveau d'accès de l'utilisateur dans le pied de page.";
$word_true = 'Oui';
$word_false = 'Non';
$word_num_columns = 'Colonnes Affichées dans Genre/Artistes:';
$word_num_columns_note = "Spécifie le nombre de colonnes à créer lors de l'affichage des Genres et des Artistes.";
$word_artist_length = "Longueur max des noms d'artistes:";
$word_artist_length_note = 'Spécifie le nombre de caractères maximum à partir duquel tronquer le nom des artistes lors de leur affichage.';
$word_quick_length = 'Longueur max des noms dans les listes déroulantes:';
$word_quick_length_note = "Spécifie le nombre de caractères maximum à partir duquel tronquer le nom des entrées ajoutées aux listes déroulantes, dans l'en-tête.";
$word_album_length = "Longueur max des noms d'album:";
$word_album_length_note = "Spécifie le nombre de caractères maximum à partir duquel tronquer le nom des albums dans la page d'un artiste.";
$word_main_table_width = 'Largeur du tableau principal:';
$word_main_table_width_note = 'Spécifie la taille des tableaux HTML, en pourcent (100 = 100%).';
$word_playlist_ext = 'Extension des fichiers de listes de lecture:';
$word_playlist_ext_note = "Spécifie l'extension des fichiers de listes de lecture générées";
$word_temp_dir = 'Répertoire temporaire de Jinzora:';
$word_temp_dir_note = "Spécifie l'endroit où écrire les fichiers temporaires. Si vous le changez, il DOIT être à l'intérieur du répertoire de Jinzora.<br><strong>NOTE</strong>: Il est relatif à la racine de l'installation de Jinzora, comme dans l'étape 1";
$word_playran_amounts = 'Nombre de pistes aléatoires:';
$word_playran_amounts_note = "Spécifie combien de choix afficher dans la liste déroulante aléatoire en haut à droite de l'en-tête. (Séparés par '|')";
$word_audio_types = 'Types Audio:';
$word_audio_types_note = 'Spécifie le type de fichiers audio que Jinzora affichera<br> Note: Assurez-vous de garder ce format et que le type que vous ajoutez peut être diffusé par HTTP.<br> (DOIT être séparé par |)';
$word_video_types = 'Types Vidéo:';
$word_video_types_note = 'Spécifie le type de fichiers vidéo que Jinzora affichera<br> Note: Assurez-vous de garder ce format et que le type que vous ajoutez peut être diffusé par HTTP.<br> (DOIT être séparé par |)';
$word_img_types = 'Types Image:';
$word_img_types_note = 'Spécifie le type de fichiers image que Jinzora examinera.';
$word_track_sep = 'Séparateur numéro de piste/nom de fichier:';
$word_track_sep_note = "vos MP3s sont nommés '01 - Nom De La Piste.mp3' ' - ' est la valeur correcte. Par contre, s'ils étaient nommés '01_NomDeLaPiste.mp3' vous devriez" . "utiliser '_' ici.<br><strong>NOTE</strong>: les valeurs DOIVENT être séparé par |";
$word_auth = 'Authentification User/Pass:';
$word_auth_note = "Spécifie une authentification a ajouter lors de la génération d'URLs pour les listes de lectures. Le format doit être<br>nom:motdepasse <br>(tout le reste est automatique)";
$word_embedding = 'Intégrer Jinzora:';
$word_embedding_note = "Permet d'intégrer Jinzora dans un site web éxistant. Pour plus d'informations sur le sujet, reportez vous à la documentation<br><br>" . "La page d'en-tête sera inclue avant Jinzora<br>La page de pied de page sera inclue après Jinzora";
$word_header = "Page d'en-tête:";
$word_footer = 'Page de pied de page:';
$word_ephpod_file = "Nom du fichier de synchronisation d'ephPod:";
$word_ephpod_file_note = "C'est le nom du fichier qui sera généré pour être importé dans ephPod afin de synchroniser votre collection de MP3 et votre iPod";
$word_ephpod_dirve = "Lettre de lecteur Windows d'ephPod:";
$word_ephpod_dirve_note = "C'est la lettre de lecteur Windows que vous avez assignée à votre répertoire de média "
                                    . 'au dessus. Par example si vos MP3s sont dans /var/www/modules/jinzora/music et que vous partagez ce dossier avec par example, samba,'
                                    . ' et vous avez connecté un lecteur réseau à ce répertoire (pour que ephPod puisse le voir, et donc synchroniser avec votre iPod) ce doit être cette lettre de lecteur.';
$word_ipod_size = 'Taille de votre iPod (en MO):';
$word_ipod_size_note = "C'est la taille UTILISABLE de votre iPod en MO. Par example mon iPod 20 GO à une taille utilisable"
                                    . "d'environ 18.5 GO ma valeur sera donc '18500'. Cela permet à Jinzora de savoir combien d'espace il reste sur votre iPod après selection d'un artiste pour la synchronisation...";
$word_shoutcasting = "Support de 'Shoutcast':";
$word_shoutcasting_note = "Active ou désactive le support de Shoutcast. Le serveur Shoutcast doit être configuré pour cela. Pour plus d'information, lisez la documentation";
$word_shoutcasting_ip = 'Adresse IP du serveur Shoutcast:';
$word_shoutcasting_ip_note = "C'est l'adresse IP du serveur local qui enverras le flux Shoutcast";
$word_shoutcasting_port = 'Port du serveur Shoutcast:';
$word_shoutcasting_port_note = "C'est le Port IP du serveur local qui enverras le flux Shoutcast";
$word_shoutcasting_pass = 'Mot de passe du serveur Shoutcast:';
$word_shoutcasting_pass_note = "C'est le mot de passe du serveur local qui enverras le flux Shoutcast";
$word_shoutcasting_refresh = "Rafraîchissement de la page 'Shoutcast':";
$word_shoutcasting_refresh_note = "Spécifie le temps (en secondes) qu'une page doit attendre avant de se rafraîchir quand le Shoutcast est activé. C'est pour que l'information sur la piste en coure en bas de page ne devienne pas obsolète. 0 désactive cette fonctionnalité.";
$word_track_plays_only = 'Jouer seulement les pistes';
$word_track_plays_only_note = "Séléctionner cette option permet d'afficher l'icône de lecture à côté d'une piste (et nul part ailleurs)";
$word_enable_playlist = 'Activer les listes de lecture';
$word_enable_playlist_note = 'Active les listes de lecture côté serveur';
$word_display_downloads = 'Afficher le nombre de téléchargements';
$word_display_downloads_note = "Active l'affichage du nombre de fois qu'une piste à été téléchargée";
$word_display_track_num = 'Afficher les numéros de pistes';
$word_display_track_num_note = "Active l'affichage du numéro de piste à côté de son nom";
$word_please_wait = 'Merci de patienter...';
$word_agree = "J'accepte";
$word_must_agree = 'Vous devez accepter avant de continuer...';

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
$word_genres = 'Жанр';
$word_genre = 'Жанр';
$word_search_results = 'Резултат от търсенето';
$word_tools = 'Опции';
$word_search = 'Търсене:';
$word_artist = 'Певец';
$word_album = 'Албум';
$word_pleasechoose = 'Моля изберете...';
$word_play = 'Пускане';
$word_play_all_albums_from = 'Пуснете всички албуми от:';
$word_randomize_all_albums_from = 'Произволено - всички албуми от: ';
$word_play_album = 'Пускане на албум';
$word_download_album = 'Сваляне на албум';
$word_id3_tag_tools = 'MP3 ID3 Tag Tools';
$word_update_id3v1 = 'Обнови ID3 Tags';
$word_update_id3v1_desc = 'Динамично създаване на всички ID3 Tags от Жанр/Певец/Албум/Номер на песента - име Име на файла';
$word_strip_id3v1_desc = 'Премахни всички ID3 tags от всички файлове';
$word_update_id3v2 = 'Обнови ID3 Tags';
$word_update_id3v2_desc = 'Динамично създаване на всички ID3 Tags от Жанр/Певец/Албум/Номер на песента - име Име на файла';
$word_strip_id3v2_desc = 'Премахни всички ID3 tags от всички файлове';
$word_strip_id3v1 = 'Премахни ID3 Tags';
$word_strip_id3v2 = 'Премахни ID3 Tags';
$word_directory_other_tools = 'Директория | File Tools | Misc Tools';
$word_upload_center = 'Качване';
$word_select_for_ipod = 'Избери за iPod Sync';
$word_fix_file_case = 'Оправи името на файловете';
$word_create_new_genre = 'Създай нов жанр';
$word_delete_genre = 'Изтриване на жанр';
$word_upload_to_jinzora = 'Качване на музкика в Jinzora';
$word_ipod_select_desc = 'Разреши певците да бъдат избирани от  Sync към  iPod използвайки ephPod';
$word_fix_file_case_desc = 'Смени имената на всички думи - да почват с главна буква';
$word_create_new_genre_desc = 'Добавяне на нова категория в Jinzora';
$word_delete_genre_desc = 'Изтриване на категория от Jinzora';
$word_add_to = 'Добави към:';
$word_delete = 'Изтриване';
$word_download = 'Сваляне';
$word_return_home = 'В началото';
$word_more = 'Още';
$word_play_random = 'Свири разбъркано';
$word_move_item = 'Премести артикула';
$word_login = 'Влизане';
$word_random_select = 'Генериране произволно: :';
$word_logout = 'Излизане';
$word_up_level = 'Назад';
$word_down_level = 'Надолу';
$word_enter_setup = 'Инсталация';
$word_go_button = 'Старт';
$word_username = 'Име:';
$word_password = 'Парола:';
$word_home = 'В началото';
$word_language = 'Език:';
$word_theme = 'Тема:';
$word_secure_warning = "Jinzora не е защитена, моля пуснете 'sh secure.sh' като защита (щит)!";
$word_check_for_update = 'Проверете за нова версиа на Jinzora';
$word_new_genre = 'Нов жанр:';
$word_search_for_album_art = 'Търсене на снимка за албум:';
$word_cancel = 'Отказ';
$word_are_you_sure_delete = 'Сигурен ли сте, че искате да изтриете :';
$word_playlist = 'Плейлист';
$word_check_all = 'Маркирай всички';
$word_check_none = 'Нищо';
$word_selected = 'Избрани';
$word_session_playlist = ' - Плейлисти - ';
$word_new_playlist = ' - Нов плейлист - ';
$word_send_tech_email = 'Прати техническа информация на подръжката';
$word_auto_update = 'Автоматично обновяване';
$word_auto_update_beta = 'Автоматично обновяване (beta release)';
$word_rewrite_files_from_id3 = 'Пренапиши имената на файловете от  ID3 информацията';
$word_create_shoutcast_playlist = 'Create Shoutcast Playlist';
$word_hide_tracks = 'Скрии песните';
$word_show_tracks = 'Покажи песните';
$word_shoutcast_tools = 'Shoutcast Tools';
$word_start_shoutcast = 'Start Shoutcast Server';
$word_stop_shoutcast = 'Stop Shoutcast Server';
$word_create_shoutcast_random_playlist = 'Randomize Shoutcast Playlist';
$word_fix_media_names = 'Оправи файловите имена на песните';
$word_remember_me = 'Запомни ме...';
$word_show_hidden = 'Покажи скритите';
$word_update_cache = 'Обнови кеша';
$word_search_missing_album_art = 'Търсене за липсващи постери в албумите';
$word_define = 'Определяне';
$word_define_uc = 'Центърът за качване позволява на потребителите да качват файлове в Jinzora';
$word_define_id3_update = 'Тази опция позволява на потребителите да динамично да обновят всички ID3 tags на всички МР3-ки, изполващ данните от директория <br><br>.  This tool allows the user to dynamically update all the ID3 tags on all MP3 files using the data from the folder structure<br><br>. За пример в 3 директории. Пример:<br><br>Jazz/Miles Davis/Kind of Blue/01 - All Blues.mp3<br><br>...becomes...<br><br>Genre: Jazz<br>Artist: Miles Davis<br>Album: Kind of Blue<br>Track Number: 01<br>Track Name: All Blues<br><br>In 2 dir mode the Genre field is ignored';
$word_define_id3_strip = 'Тази опция премахва имената на: Жанра, Певеца, Албума, Номера на песента, Името на песента - от MP3 ID3 tag';
$word_define_create_genre = 'Това позволява на потребителите да създават в ID3v1 tag приятелски жанр';
$word_define_delete_genre = 'Това позволява на потребителите да изтриват Жанра и всички подфайлове<br><br>МОЛЯ БЪДЕТЕ ВНИМАТЕЛНИ!!!';
$word_define_ipod_sync = 'Това позволява на потребителите да избират Певец  да бъде синхронизиран в iPod MP3 player, използващ ephPod';
$word_define_check_updates = 'Това позволява на Jinzora да се свърже с главният сървър за да провери дали има нова версия';
$word_define_send_tech_info = 'Това генерира рапорт, които ще се прати на техническият екип на Jinzora <br><br>Моля НЕИЗПОЛЗВАЙТЕ ТАЗИ ОПЦИЯ ако техническият екип неочаква email-а ви!';
$word_define_enter_setup = 'Това рестартира инсталацията за да направи промените в конфигурацията лесни<br><br>БЕЛЕЖКА: Моля първо пуснете configure.sh !';
$word_define_start_shoutcast = 'Това позволява на потребителите да стартират Shoutcast сървър, ако shoutcasting е разрешен';
$word_define_stop_shoutcast = 'Това позволява на потребителите да спират Shoutcast сървъра, ако shoutcasting е разрешен';
$word_define_fix_media = 'Това са някой опции който помагат за bulk file management tasks';
$word_define_update_cache = 'Това обновява текущата кеш информация<br><br>Това трябва да бъде стартирано ако се сменят файловата и директорната структура по време на активно използване<br><br>Кеширането на файлове прави Jinzora по бърза';
$word_define_search_for_art = 'Това показва на потребитвлят снимки на албумите. Албум по албум от images.google.com<br><br> Потребителят може да избира снимките, който иска или системата генерира снимка по-подразбиране.';
$word_define_rewrite_from_id3 = 'Тази опция ще пренапише имената на всички мр3-ки използвайки ID3 tag информацията от името и номера на песента<br><br>БЕЛЕЖКА: The first track seperator value - if multiple - will become the track seperator for the new file names';
$word_change_art = 'Смяна на картината';
$word_survey = 'Jinzora Survey';
$word_define_survey = 'Просто проучване за да можем да узнаем повече как се използва Jinzora, за да я направим по добра!';
$word_user_manager = 'Управление на потребителите';
$word_define_user_manager = 'Позволява да избирате различни нива на достъп за всеки потребител.';
$word_add_user = 'Добавяне на потребител';
$word_access_level = 'Ниво на достъпа';
$word_update_successful = 'Обновяването успешно!';
$word_send_playlist = 'Прати плейлиста';

$word_rate = 'Дай оценка за тази песен';
$word_discuss = 'Обсъждане на песента';
$word_new = 'НОВ!';
$word_editcomment = 'Редактирай коментара';
$word_rewrite_tags = 'Пренапиши ID3 Tags';

$word_media_management = 'Управление на медията';
$word_actions = 'Действие';
$word_group_features = 'Group Features';
$word_item_information = 'Информация на артикула';
$word_browse_album = 'Прелистване албум';
$word_new_from = 'Нови от: ';
$word_new_from_last = 'Последно прибавени: ';
$word_jukebox_controls = 'Jukebox контрол';
$word_pause = 'Пауза';
$word_stop = 'Стоп';
$word_next = 'Следваща';
$word_previous = 'Предишна';
$word_volume = 'Сила';
$word_mute = 'Без звук';
$word_up = 'На горе';
$word_down = 'На долу';
$word_nowplaying = 'Now Playing';
$word_refresh_in = 'Refresh In:';
$word_upcoming = 'Upcoming Tracks';
$word_stopped = 'Stopped';
$word_next_track = 'Следваща песен';
$word_pause = 'Paused';
$word_playback_to = 'Playback to:';
$word_jukebox = 'Jukebox';
$word_stream = 'Stream';
$word_information = 'Търсене';
$word_echocloud = 'Echocloud Similar';
$word_clear = 'Изчисти плейлиста';
$word_bulk_edit = 'Редакция на размера';
$word_complete_playlist = 'Завършен плейлист';
$word_add_at = 'Добави като:';
$word_current = 'Текущ';
$word_end = 'Край';
$word_add_to_favorites = 'Добави текущата песен към любими';
$word_noacess = 'Съжелявам, нямате достъп!';
$word_pleasewait = 'Моля изчакайте докато влезете...';
$word_play_lofi = 'Свири Lo-Fi';
$word_lofi = 'Lo-Fi';
$word_donate = 'Подкрепете Jinzora!';
$word_define_word_donate = 'Donate to the Jinzora Development Team!';
$word_description = 'Описание:';
$word_exclude_genre = 'Изключване на жанр';
$word_update_description = 'Обнови описанието';
$word_close = 'Затвори';
$word_update_close = 'Обнови и затвори';
$word_short_description = 'Кратко Опис.:';
$long_short_description = 'Подробно Опис.:';
$word_artist_image = 'Певец/Група - Снимка:';
$word_new_image = 'Нова снимка:';
$word_delete_artist = 'Изтриване на Певец/Група';
$word_exclude_artist = 'Изключване а Певец/Група';
$word_album_name = 'Име на Албум:';
$word_album_description = 'Описание на албума:';
$word_album_image = 'Снимка на албум:';
$word_album_year = 'Година на Албума:';
$word_delete_album = 'Изтриване на албума';
$word_global_exclude = 'Скриване';
$word_track_number = 'Номер на песента:';
$word_track_name = 'Име на песента:';
$word_file_name = 'Име на файла:';
$word_not_writable = 'Защитена!!!';
$word_track_time = 'Време на песента:';
$word_bit_rate = 'Bit Rate:';
$word_sample_rate = 'Sample Rate:';
$word_file_size = 'Големина на файла:';
$word_file_date = 'Дата на файла:';
$word_id3_description = 'ID3 описание:';
$word_thumbnail = 'Малка снимка:';
$word_search_lyrics = 'Автоматично търсене за Lyrics (лирично)';
$word_update = 'Обновяване';
$word_search_new = 'Търсене за нова медия';
$word_search_new_define = 'Търсене за и показване на нова медия както е описано в settings file';
$word_new_media = 'Нова медия';
$word_updating_information = 'Обновяване на информацията на: ';
$word_please_wait_artist = 'Моля изчакайте докато обновим всички песни на певеца или групата...<br>Това може да отнеме малко време...';
$word_updating_track = 'Обновяване на песента';
$word_updating_album = 'Обновяване на албум';
$word_please_wait = 'Моля изчакайте...';
$word_tracks = 'Песни';
$word_plays = 'пускани(я)';
$word_downloads = 'свалян(а)';
$word_select_destination = 'Изберете дестинация';
$word_dest_path = 'Път';
$word_add_files = 'Добави файлове...';
$word_upload = 'Качване';
$word_clear_list = 'Изчисти листа';
$word_current_file = 'Текущ файл';
$word_total_complete = 'Напълно завършено';
$word_new_subdirectory = 'Нова под директория';
$word_select = 'Избери';
$word_up_onelevel = 'Едно ниво на зад';
$word_subdirs = 'Под директории';
$word_finished = 'Качването завършено!';

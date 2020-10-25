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
$word_genres = 'Стили музыки';
$word_genre = 'Стиль музыки';
$word_search_results = 'Результаты поиска';
$word_tools = 'Управление';
$word_search = 'Поиск:';
$word_artist = 'Исполнитель';
$word_album = 'Альбомы';
$word_pleasechoose = 'Сделайте свой выбор...';
$word_play = 'Играть';
$word_play_all_albums_from = 'Играть все альбомы из:';
$word_randomize_all_albums_from = 'Случайный выбор из:';
$word_play_album = 'Играть альбом';
$word_download_album = 'Скачать Альбом';
$word_id3_tag_tools = 'Управление тэгами MP3 ID3';
$word_update_id3v1 = 'Обновить ID3 тэги';
$word_update_id3v1_desc = 'Динамическое создание всех ID3 тегов по типу  Стиль музыки/Исполнитель/Альбом/Номер трека - Имя файла';
$word_strip_id3v1_desc = 'Вырезать все ID3 теги из всех файлом';
$word_update_id3v2 = 'Обновить ID3 тэги';
$word_update_id3v2_desc = 'Динамическое создание всех ID3 тегов по типу  Стиль музыки/Исполнитель/Альбом/Номер трека - Имя файла';
$word_strip_id3v2_desc = 'Вырезать все ID3 теги из всех файлом';
$word_strip_id3v1 = 'Вырезать ID3 тэги';
$word_strip_id3v2 = 'Вырезать ID3 тэги';
$word_directory_other_tools = 'Директория | Файловые  | Misc Tools';
$word_upload_center = 'Управление загрузками на сервер';
$word_select_for_ipod = 'Выбор синхронизации с iPod';
$word_fix_file_case = 'Исправить регистр в именах файлов';
$word_create_new_genre = 'Добавить новый стиль музыки';
$word_delete_genre = 'Удалить стиль музыки';
$word_upload_to_jinzora = 'Загрузить музыку в Jinzora';
$word_ipod_select_desc = 'Разрешить выделять Исполнителей для синхронизации с iPod используя ephPod';
$word_fix_file_case_desc = 'Изменяет первую букву на заглавную во всех словах';
$word_create_new_genre_desc = 'Добавить новый стиль музыки в Jinzora';
$word_delete_genre_desc = 'Удалить слить музыки из Jinzora';
$word_add_to = 'Добавить в:';
$word_delete = 'Удалить';
$word_download = 'Скачать';
$word_return_home = 'Вернуться на главную';
$word_more = 'Help';
$word_play_random = 'Играть случайные трек';
$word_move_item = 'Переместить';
$word_login = 'Войти';
$word_random_select = 'Создать наугад:';
$word_logout = 'Выйти';
$word_up_level = 'Выше на уровень';
$word_down_level = 'Ниже на уровень';
$word_enter_setup = 'Изменить конфигурацию';
$word_go_button = 'искать';
$word_username = 'Имя:';
$word_password = 'Пароль:';
$word_home = 'Начало';
$word_language = 'Язык:';
$word_theme = 'Тема оформления:';
$word_secure_warning = "Jinzora не находится в защищенном режиме, пожалуйста запустите 'sh secure.sh' в режиме командной строки шела!";
$word_check_for_update = 'Проверить обновления Jinzora';
$word_new_genre = 'Новый стиль музыки:';
$word_search_for_album_art = 'Искать обложки для альбома';
$word_cancel = 'Отмена';
$word_are_you_sure_delete = 'Вы уверены что хотите удалить:';
$word_playlist = 'Плейлист';
$word_check_all = 'Выделить все';
$word_check_none = 'Ничего';
$word_selected = 'Выделенное';
$word_session_playlist = 'Плейлист текущего сеанса';
$word_new_playlist = 'Новый плейлист';
$word_send_tech_email = 'Послать информацию и конфигурации в службу потдержки';
$word_auto_update = 'Автоматическое обновление';
$word_auto_update_beta = 'Автоматическое обновление (beta release)';
$word_rewrite_files_from_id3 = 'Переименовать файлы опираясь на информацию из ID3';
$word_create_shoutcast_playlist = 'Создать Shoutcast плейлист';
$word_hide_tracks = 'Скрыть трек';
$word_show_tracks = 'Показать трек';
$word_shoutcast_tools = 'Управление Shoutcast';
$word_start_shoutcast = 'Запустить Shoutcast сервер';
$word_stop_shoutcast = 'Остановить Shoutcast сервер';
$word_create_shoutcast_random_playlist = 'Перемешать в произвольном порядке плейлист Shoutcast';
$word_fix_media_names = 'Исправить имена мультимедиа файлов';
$word_remember_me = 'Запомните меня пожалуйста i`ll be back';
$word_show_hidden = 'Показать скрытое';
$word_update_cache = 'Обновить кэш';
$word_search_missing_album_art = 'Искать отсутствующие обложки альбомов';
$word_define = 'Выбрать';
$word_define_uc = 'Центр загрузок позволяет юзерам закачивать файлы в Jinzora';
$word_define_id3_update = 'Позволяет динамически обновлять все ID3 тэги у всех MP3 файлов используя данные структуры папок<br><br>Напримере 3х уровневой структуры папок:<br><br>Jazz/Miles Davis/Kind of Blue/01 - All Blues.mp3<br><br>...получится...<br><br>Стиль: Jazz<br>Исполнитель: Miles Davis<br>Альбом: Kind of Blue<br>Номер трэка: 01<br>Название трэка: All Blues<br><br>При 2х уровневой структуре папок Поле:Стиль музыки игнорируется';
$word_define_ipod_sync = 'Позволяет выбрать Исполнителя для синхронизации с iPod MP3 плеером, используя ephPod';
$word_define_check_updates = 'Проверить наличие свежей версии Jinzora';
$word_define_enter_setup = 'Перезапустить процесс настройки<br><br>Внимание: Сначала запустите configure.sh !';
$word_define_start_shoutcast = 'Это позволит запустить Shoutcast сервер, если потоковое воспроизведение файлов разрешено';
$word_define_stop_shoutcast = 'Это позволит остановить Shoutcast сервер, если потоковое воспроизведение файлов разрешено';
$word_define_update_cache = 'Обновить информацию в кеше<br><br>Следует запускать если изменилась структура каталогов или вы добавили или удалили некоторые медиа файлы<br><br>Кеширование файлов ускоряет работу Jinzora';
$word_define_search_for_art = 'Поиск обложек на images.google.com<br><br>Пользователи могут выбирать любую картинку или система выберет сама';
$word_define_rewrite_from_id3 = 'Переименование медиа фалов используя информацию из ID3 тэгов о номере и названии трэка<br><br>NOTE: The first track seperator value - if multiple - will become the track seperator for the new file names';
$word_change_art = 'Сменить обложку альбома';
$word_survey = 'Jinzora голосование';
$word_user_manager = 'Управление юзерами';
$word_define_user_manager = 'Разрешить выставлять различные уровни доступа для каждого юзера';
$word_add_user = 'Добавить юзера';
$word_access_level = 'Уровень доступа';
$word_update_successful = 'Обновление прошло успешно!';
$word_send_playlist = 'Послать плейлист';
$word_rate = 'Выставить свою оценку';
$word_discuss = 'Обсудить этот мультимедиа файл';
$word_new = 'Новое!';
$word_editcomment = 'Редактировать коментарии';
$word_rewrite_tags = 'Перезаписать ID3 тэги';
$word_media_management = 'Медиа менеджер';
$word_actions = 'Действия';
$word_group_features = 'Возможности групп';
$word_item_information = 'Информация';
$word_browse_album = 'Просмотреть Альбом';
$word_new_from = 'Обновления с даты: ';
$word_new_from_last = 'Обновления с момента последнего обновления: ';
$word_jukebox_controls = 'Управление Jukebox';
$word_pause = 'Пауза';
$word_stop = 'Стоп';
$word_next = 'Следующий';
$word_previous = 'Предыдущий';
$word_volume = 'Громкость';
$word_mute = 'Убавить громкость';
$word_up = 'Вверх';
$word_down = 'Вниз';
$word_nowplaying = 'Сейчас играет';
$word_refresh_in = 'Обновить в:';
$word_upcoming = 'Следующие трек';
$word_stopped = 'Стоп';
$word_next_track = 'Следующий трэк';
$word_pause = 'Пауза';
$word_playback_to = 'Проиграть с:';
$word_jukebox = 'Jukebox';
$word_stream = 'Поток';
$word_information = 'Поиск';
$word_echocloud = 'Echocloud Similar';
$word_clear = 'Очистить плейлист';
$word_bulk_edit = 'Массовое редактирование';
$word_complete_playlist = 'Полный плейлист';
$word_add_at = 'Добавить к:';
$word_current = 'Текущий';
$word_end = 'Конец';
$word_add_to_favorites = 'Добавить выделенный файл в избранное';
$word_noacess = 'Вы не имеете доступа';
$word_pleasewait = 'Пожалуйста подождите пока выполняется вход...';
$word_play_lofi = 'Играть Lo-Fi';
$word_lofi = 'Lo-Fi';
$word_donate = 'Отблагодарить $ Jinzora!';
$word_define_word_donate = 'Отблагодарить $ Jinzora Development Team!';
$word_description = 'Описание:';
$word_exclude_genre = 'Исключить Стиль музыки';
$word_update_description = 'Описание обновления';
$word_close = 'Закрыть';
$word_update_close = 'Обновить и закрыть';
$word_short_description = 'Короткое описание:';
$long_short_description = 'Полное описание:';
$word_artist_image = 'Фото исполнителя:';
$word_new_image = 'Новое изображение:';
$word_delete_artist = 'Удалить исполнителя';
$word_exclude_artist = 'Исключить исполнителя';
$word_album_name = 'Название альбома:';
$word_album_description = 'Описание альбома:';
$word_album_image = 'Обложка альбома:';
$word_album_year = 'Год выпуска альбома:';
$word_delete_album = 'Удалить альбом';
$word_global_exclude = 'Полное исключение';
$word_track_number = 'Номер дорожки:';
$word_track_name = 'Название трэка:';
$word_file_name = 'Имя файла:';
$word_not_writable = 'невозможно записать!!!';
$word_track_time = 'Время звучания:';
$word_bit_rate = 'Сжато с бит рейтом:';
$word_sample_rate = 'Герц:';
$word_file_size = 'Размер файла:';
$word_file_date = 'Дата файла:';
$word_id3_description = 'ID3 описание:';
$word_thumbnail = 'Превьюшки:';
$word_search_lyrics = 'Автопоиск стихов';
$word_update = 'Обновить';
$word_search_new = 'Искать новые мультимедиа файлы';
$word_search_new_define = 'Поиск и вывод новых медиа файлов (типы определены в конфигурационном файле)';
$word_new_media = 'Новые записи';
$word_updating_information = 'Обновление информации: ';
$word_please_wait_artist = 'Подождите пока мы обновим все трек этого Артиста...<br>Придется немного подождать...';
$word_updating_track = 'Обновить трэк';
$word_updating_album = 'Обновить альбом';
$word_please_wait = 'Пожалуйста подождите...';
$word_tracks = 'трек';
$word_plays = 'играет';
$word_downloads = 'Загрузки';
$word_select_destination = 'Выбрать путь назначения';
$word_dest_path = 'Путь назначения (в пределах вашей директории с музыкой)';
$word_add_files = 'Добавить файлы...';
$word_upload = 'Закачать';
$word_clear_list = 'Очистить список';
$word_current_file = 'Текущий файл';
$word_total_complete = 'Все сделано БОСС :)';
$word_new_subdirectory = 'Новая поддиректория';
$word_select = 'Выбрать';
$word_up_onelevel = 'Вверх на один уровень';
$word_subdirs = 'Вложенные директории';
$word_finished = 'Загрузка замершена!';
$word_create_low_fi = 'Создать Lo-Fi';
$word_delete_low_fi = 'Удалить Lo-Fi';

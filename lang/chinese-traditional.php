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
$word_genres = '曲風';
$word_genre = '曲風';
$word_search_results = '搜尋結果';
$word_tools = '工具';
$word_search = '搜尋:';
$word_artist = '藝人';
$word_album = '專輯';
$word_pleasechoose = '請選擇...';
$word_play = '播放';
$word_play_all_albums_from = '播放所有專輯:';
$word_randomize_all_albums_from = '隨選所有專輯從:';
$word_play_album = '播放專輯';
$word_download_album = '下載專輯';
$word_id3_tag_tools = 'MP3 ID3 標籤工具';
$word_update_id3v1 = '更新 ID3v1 標籤';
$word_update_id3v1_desc = '動態建立所有 ID3v1 標籤由 Genre/Artist/Album/Track Number - 檔名';
$word_strip_id3v1_desc = '去所有檔案 ID3v1 標籤';
$word_update_id3v2 = '更新 ID3v2 Tags';
$word_update_id3v2_desc = '動態建立所有 ID3v2 標籤由 Genre/Artist/Album/Track Number - 檔名';
$word_strip_id3v2_desc = '去所有檔案 ID3v2 標籤';
$word_strip_id3v1 = '去 ID3v1 標籤';
$word_strip_id3v2 = '去 ID3v2 標籤';
$word_directory_other_tools = '資料夾 | 檔案工具 | 其它工具';
$word_upload_center = '上傳中心';
$word_select_for_ipod = 'iPod 同步化選擇';
$word_fix_file_case = '修改檔名';
$word_create_new_genre = '建立新曲風';
$word_delete_genre = '刪除曲風';
$word_upload_to_jinzora = '上傳音樂到 Jinzora';
$word_ipod_select_desc = '使用 ephPod可以選擇藝人同步化 iPod';
$word_fix_file_case_desc = '改變檔名每字開頭為大寫';
$word_create_new_genre_desc = '增加曲風到 Jinzora';
$word_delete_genre_desc = '從 Jinzora 刪除一曲風';
$word_add_to = '增加到:';
$word_delete = '刪除';
$word_download = '下載';
$word_return_home = '返回首頁';
$word_more = '更多';
$word_play_random = '隨選播放';
$word_move_item = '移動項目';
$word_login = '登入';
$word_random_select = '隨選產生:';
$word_logout = '登出';
$word_up_level = '上層';
$word_enter_setup = '進入設定';
$word_go_button = '前往';
$word_username = '用戶名稱:';
$word_password = '密碼:';
$word_home = '首頁';
$word_language = '語言:';
$word_theme = '佈景主題:';
$word_secure_warning = "Jinzora 沒有在安全模式, 請執行 'sh secure.sh' 在終端機文字視窗!";
$word_check_for_update = '更新 Jinzora 前的檢查';
$word_new_genre = '新的音樂分類:';
$word_search_for_album_art = '搜尋相簿封面';
$word_cancel = '取消';
$word_are_you_sure_delete = '確定要刪除:';
$word_playlist = '播放列表';
$word_check_all = '全選';
$word_check_none = '全不選';
$word_selected = '已選擇';
$word_session_playlist = ' - 工作階段播放列表 - ';
$word_new_playlist = ' - 新的播放列表 - ';
$word_send_tech_email = '傳送提供支援的技術資訊';
$word_auto_update = '自動更新';
$word_auto_update_beta = '自動更新 (beta 測試版)';
$word_create_shoutcast_playlist = '建立Shoutcast播放列表';
$word_hide_tracks = '隱藏曲目';
$word_show_tracks = '顯示曲目';
$word_shoutcast_tools = 'Shoutcast工具';
$word_start_shoutcast = '開始Shoutcast主機';
$word_stop_shoutcast = '停止Shoutcast主機';
$word_create_shoutcast_random_playlist = '隨選Shoutcast播放列表';
$word_fix_media_names = '修正媒體檔案名稱';
$word_remember_me = '記住我';
$word_show_hidden = '顯示隱藏';
$word_update_cache = '更新快取';
$word_search_missing_album_art = '搜尋遺失的專輯封面';
$word_define = '定義';
$word_define_uc = '升級中心允許用戶上傳檔案到 Jinzora';
$word_define_id3_update = '此工具允許用戶在全部 MP3 檔案使用資料夾結構的日期動態更新所有 ID3 標籤<br><br>例如在3層目錄模式:<br><br>Jazz/Miles Davis/Kind of Blue/01 - All Blues.mp3<br><br>...會變成...<br><br>曲風: Jazz<br>藝人: Miles Davis<br>專輯: Kind of Blue<br>Track Number: 01<br>歌名: All Blues<br><br>在 2 層目錄模式曲風欄被忽略';
$word_define_id3_strip = '此工具會去掉ID3 標籤中的曲風, 藝人, 專輯, 曲目編號, 歌名的值';
$word_define_create_genre = '這讓用戶方便地建立一個 ID3v1 標籤的曲風';
$word_define_delete_genre = '這讓用戶刪除一個完整的曲風, 及其下所有檔案<br><br>請小心使用!!!';
$word_define_ipod_sync = '這讓用戶選擇藝人要同步化到 iPod MP3 播放器, 使用 ephPod';
$word_define_check_updates = '這讓 Jinzora 呼叫程式發展者的主機看看 Jinzora 是否有新的版本';
$word_define_send_tech_info = '這會產生一個報表寄到 Jinzora 技術支援<br><br>除非計術支援需要此 email, 否則請不要使用這個功能!';
$word_define_enter_setup = '這會重新開始設定 Jinzora 來變更稍早的設定<br><br>注意: 請先執行 configure.sh!';
$word_define_start_shoutcast = '如果 shoutcasting 有打開, 這讓用戶啟用 Shoutcast 主機';
$word_define_stop_shoutcast = '如果 shoutcasting 有打開, 這讓用戶停止 Shoutcast 主機';
$word_define_fix_media = '有一些工具來幫助大量檔案管理工作';
$word_define_update_cache = '這會更新目前的 session 快取資訊<br><br>假如檔案或目錄結構已改變, 在起動瀏覽時, 這應該被執行<br><br>快取檔案的方式使 Jinzora 速度快很多';
$word_define_search_for_art = '這提供用戶可能的專輯封面畫面, 專輯封面圖片來自 images.google.com<br><br>用戶可以選擇他們想要的封面, 或者細統自動產生預設的封面圖片';
$word_define_rewrite_from_id3 = '這工具會使用 ID3 標籤資訊的曲目編號及歌名重寫所有檔案名稱<br><br>說明: 第一個曲目分隔線 - ,假如有多個曲目 - 曲目分隔線會變成為新的檔名';
$word_change_art = '改變封面';
$word_survey = 'Jinzora 意見調查';
$word_define_survey = '只是一個簡單的意見調查使我們能知道如何使 Jinzora 更好!';
$word_user_manager = '會員管理';
$word_define_user_manager = '你可以將每位用戶設不同的權限';
$word_add_user = '增加用戶';
$word_access_level = '存取等級';
$word_update_successful = '更新成功!';
$word_send_playlist = '送出播放清單';

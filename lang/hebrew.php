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
* Hebrew Translations by : Noam A aka Eterenity575 at www.compustatic.net / admin@compustatic.net
* Contributors:
* Please see http://www.jinzora.org/modules.php?op=modload&name=jz_whois&file=index
*
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

/* Let's define all the words here */
$word_genres = 'סוגי מוזיקה';
$word_genre = 'סוגי מוזיקה';
$word_search_results = 'תוצאות חיפוש';
$word_tools = 'כלים';
$word_search = 'חיפוש:';
$word_artist = 'אמנים';
$word_album = 'אלבומים';
$word_pleasechoose = 'אנא בחרו...';
$word_play = 'נגן';
$word_play_all_albums_from = 'ניגון כל האלבומים מאת:';
$word_randomize_all_albums_from = 'ניגון אקראי של האלבומים מאת:';
$word_play_album = 'נגן אלבום';
$word_download_album = 'הורדת אלבום';
$word_id3_tag_tools = 'כלי ID3';
$word_update_id3v1 = 'עדכון תגיות ID3';
$word_update_id3v1_desc = 'יצירת כל תגיות הID3 מקובץ הMP3';
$word_strip_id3v1_desc = 'הורדת כל תגיות הID3 מכל הקבצים';
$word_update_id3v2 = 'עדכון תגיות ID3';
$word_update_id3v2_desc = 'יצירת כל תגיות הID3 מקובץ הMP3';
$word_strip_id3v2_desc = 'הורדת כל תגיות הID3 מכל הקבצים';
$word_strip_id3v1 = 'הודת תגיות ID3';
$word_strip_id3v2 = 'הודת תגיות ID3';
$word_directory_other_tools = 'אינדקס | כלי קובץ | כלים שונים';
$word_upload_center = 'מרכז העלאה';
$word_select_for_ipod = 'בחרו לסנכרון IPOD';
$word_fix_file_case = 'תיקון של הקובץ';
$word_create_new_genre = 'יצירת סוג מוזיקה חדש';
$word_delete_genre = 'מחיקת סוג מוזיקה';
$word_upload_to_jinzora = 'העלאת מוזיקה למערכת';
$word_ipod_select_desc = 'מאפשר אומנים לתת לגולשים לסנכרן את המוזיקה ישירות לIPOD';
$word_fix_file_case_desc = 'משנה לאותיות גדולות - אנגלית בלבד';
$word_create_new_genre_desc = 'הוספת סוג מוזיקה חדש למערכת';
$word_delete_genre_desc = 'מחיקת סוג מוזיקה מהמערכת';
$word_add_to = 'הוספה אל:';
$word_delete = 'מחיקה';
$word_download = 'הורדה';
$word_return_home = 'חזרה לבית';
$word_more = 'עוד';
$word_play_random = 'ניגון אקראי';
$word_move_item = 'הזז פריט';
$word_login = 'התחברות';
$word_random_select = 'יצירת אקראי:';
$word_logout = 'התנתקות';
$word_up_level = 'אחד למעלה';
$word_down_level = 'אחד למטה';
$word_enter_setup = 'כניסה להגדרות';
$word_go_button = 'אישור';
$word_username = 'שם משתמש:';
$word_password = 'סיסמה:';
$word_home = 'בית';
$word_language = 'שפה:';
$word_theme = 'ערכה:';
$word_secure_warning = "Jinzora is not secure, please run 'sh secure.sh' at the shell!";
$word_check_for_update = 'בדיקת עדכונים למערכת';
$word_new_genre = 'סוג מוזיקה חדש:';
$word_search_for_album_art = 'חיפוש תמונת אלבום ל';
$word_cancel = 'ביטול';
$word_are_you_sure_delete = 'האם אתם בטוחים שאתם רוצים למחוק:';
$word_playlist = 'רשימת שירים';
$word_check_all = 'בחרו הכל';
$word_check_none = 'אין';
$word_selected = 'נבחרו';
$word_session_playlist = ' - רשימת שירים - ';
$word_new_playlist = ' - רשימת שירים חדשה - ';
$word_send_tech_email = 'שלחו מידע טכני לתמיכה';
$word_auto_update = 'עדכון אוטומטי';
$word_auto_update_beta = 'עדכון אוטומטי - ניסיוני';
$word_rewrite_files_from_id3 = 'שיכתוב שמות קבצים מתגיות ID3';
$word_create_shoutcast_playlist = 'יצירת רשימות שירים לSHOUTCAST';
$word_hide_tracks = 'הסתר שירים';
$word_show_tracks = 'הצג שירים';
$word_shoutcast_tools = 'כלי SHOUTCAST';
$word_start_shoutcast = 'הפעל שרת SHOUTCAST';
$word_stop_shoutcast = 'כבה שרת SHOUTCAST';
$word_create_shoutcast_random_playlist = 'צור רשימות שירים אקראיות לSHOUTCAST';
$word_fix_media_names = 'תיקון שמות קבצים';
$word_remember_me = 'זכור אותי';
$word_show_hidden = 'הצג נסתרים';
$word_update_cache = 'עדכון מטמון';
$word_search_missing_album_art = 'חיפוש תמונה לאלבום';
$word_define = 'הגדרה';
$word_define_uc = 'מרכז ההעלאות מאפשר למשתמשים להעלות את השירים שלהם למערכת';
$word_define_id3_update = 'כלי זה מאפשר למשתמש לעדכן את כל תגיות הID3 שלהם מתוך ספריה<br><br>For example in 3 directory mode:<br><br>Jazz/Miles Davis/Kind of Blue/01 - All Blues.mp3<br><br>...becomes...<br><br>Genre: Jazz<br>Artist: Miles Davis<br>Album: Kind of Blue<br>Track Number: 01<br>Track Name: All Blues<br><br>In 2 dir mode the Genre field is ignored';
$word_define_id3_strip = 'כלי זה, יוריד את כל המידע על השיר מתגיות הID3';
$word_define_create_genre = 'נותןו למשתמש את האפשרות ליצור סוג מוזיקה שמתאים לID3';
$word_define_delete_genre = 'מאפשר למשתמש למחוק סוג מוזיקה שלם כולל תת קטגוריות ושירים<br><br>אין דרך לשחזר מידע שנמחק!!!';
$word_define_ipod_sync = 'נותן למשתמש אפשרות לבחור שירים ולסנכרן אותם ישירות למכשיר האייפוד';
$word_define_check_updates = 'יוצר קשר עם שרתי המערכת לבדיקת גרסה חדשה';
$word_define_send_tech_info = 'יוצר דוח אשר נשלח ליוצרי המערכת. אנא אל תשתמשו באפשרות זו אם הם לא מצפים לדואר מכם!';
$word_define_enter_setup = 'איתחול מערכת ההתקנה לשינויים קלים יותר<br><br>אנא הריצו את הקובץ configure.sh קודם!';
$word_define_start_shoutcast = 'מאפשר למשתמש להפעיל את שרת הרדיו במחשב שלו, אם האפשרות מופעלת';
$word_define_stop_shoutcast = 'מאפשר למשתמש לכבות את השרת הרדיו במחשב שלו, אם האפשרות מופעלת';
$word_define_fix_media = 'כלים שיאפשרו לכם לטפל במספר גדול של קבצים';
$word_define_update_cache = 'עדכון מידע המטמון<br><br>יש להריץ אפשרות זו אם נעשו שינויים במבנה השירים בזמן העיון<br><br>אי רענון לא פוגע במהירות העבודה, להפך';
$word_define_search_for_art = 'מציג למשתמש עטיפות של דיסקים, אחד אחרי השני מהאתר images.google.com<br><br>המשתמש יכול לבחור את התמונה או להשתמש בברירת המחדל';
$word_define_rewrite_from_id3 = 'אפשרות זו תשכתב את כל שמות הקבצים מתגי הID3<br><br>';
$word_change_art = 'שינוי תמונה';
$word_survey = 'סקר מערכת';
$word_define_survey = 'סקר קטן על מנת לדעת האם המערכת מוצאת חן בעיניכם!';
$word_user_manager = 'ניהול משתמשים';
$word_define_user_manager = 'מאפשר לכם לקבוע גישות והרשאות למשתמשים שונים';
$word_add_user = 'הוספת משתמש';
$word_access_level = 'רמת גישה';
$word_update_successful = 'עודכן בהצלחה!';
$word_send_playlist = 'שלח רשימת שירים';
$word_rate = 'דרגו את זה';
$word_discuss = 'דברו על זה';
$word_new = 'חדש!';
$word_editcomment = 'עריכת תגובה';
$word_rewrite_tags = 'שכתוב תגיות ID3';
$word_media_management = 'ניהול מדיה';
$word_actions = 'פעולות';
$word_group_features = 'אפשרויות קבוצות';
$word_item_information = 'מידע על הפריט';
$word_browse_album = 'עיון באלבום';
$word_new_from = 'חד שמאז: ';
$word_new_from_last = 'חדש מאז האחרון: ';
$word_jukebox_controls = 'בקרי תיבת נגינה';
$word_pause = 'השהה';
$word_stop = 'עצור';
$word_next = 'הבא';
$word_previous = 'הקודם';
$word_volume = 'עצמה';
$word_mute = 'השתקה';
$word_up = 'למעלה';
$word_down = 'למטה';
$word_nowplaying = 'עכשיו מנגן';
$word_refresh_in = 'רענון תוך:';
$word_upcoming = 'שירים בקרוב:';
$word_stopped = 'נעצר';
$word_next_track = 'שיר הבא';
$word_pause = 'מושהה';
$word_playback_to = 'ניגון אל:';
$word_jukebox = 'תיבת נגינה';
$word_stream = 'השמע';
$word_information = 'חיפוש';
$word_echocloud = 'Echocloud Similar';
$word_clear = 'ניקוי רשימת שירים';

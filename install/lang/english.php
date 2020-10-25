<?php

// Let's set some default values
if (!isset($href_path)) {
    $href_path = '';
}
if (!isset($href_path2)) {
    $href_path2 = '';
}
$word_requirements = 'Jinzora Requirements';
$word_primary_settings = 'Primary Settings';
$word_display_settings = 'Display Settings';
$word_verify_config = 'Verify Configuration';
$word_write_error = "Sorry, but I couldn't open either the settings file or the users database file for writing<br><br>"
                                       . 'You can either do a copy and paste of the contents below<br><br>...or...<br><br>'
                                       . '<a href='
                                       . $href_path
                                       . '&action=save-config>Click Here</a> to download the settings file<br>'
                                       . '<a href='
                                       . $href_path
                                       . '&action=save-user>Click Here</a> to download the user database<br><br><br>'
                                       . 'Once complete <a href='
                                       . $href_path2
                                       . '>Click Here</a> to launch Jinzora!';
$word_admin_username = 'Admin Username:';
$word_admin_username_note = 'NOTE: For cms installation you MUST make this match the username ' . 'that the admin will log into the CMS with';
$word_admin_password = 'Admin Password:';
$word_web_root = 'Root Directory of the webserver:';
$word_web_root_note = 'This must be set to the physical path of the root of your webserver. ' . 'So if your web server is in /var/www then that should be the value here (with NO trailing slash!)<br><br>';
$word_jinzora_directory = 'Jinzora Directory:';
$word_jinzora_directory_note = 'This the root dir of Jinzora, relative to your webserver root directory. <br><br>';
$word_media_directory = 'Media Directory:';
$word_media_directory_note = 'This is the top level of the directory structure for all your media files.' . 'The default should work fine with the included MP3 file for testing purposes.<br><br>';
$word_media_directory_structure = 'Media Directory Structure:';
$word_media_directory_structure_note = 'This tells Jinzora how many directories to traverse when looking for media. ' . 'Jinzora will display media no matter where it finds it, this is just so that ' . 'Jinzora will know where Artists and Albums are<br><br>';
$word_install_type = 'Install Type:';
$word_install_type_note = 'This decides if Jinzora will be a PostNuke module, a PHPNuke module, or a standalone application.';
$word_cms_user_type = 'CMS User Access:';
$word_cms_user_type_note = 'For CMS installs this will set the access level for users '
                                       . 'logged into the CMS (vs just an anonymous user). These are users that have logged into the CMS but do not have '
                                       . 'specific rights in Jinzora.'
                                       . '<br><br>'
                                       . '<strong>NOTE:</strong> Any specific rights will over-ride these settings for a specific user';
$word_default_user_access = 'Default Access Level:';
$word_default_user_access_note = 'This sets the default access level to Jinzora (for non-logged in users).<br><br>';
$word_use_advanced_caching = 'Use Advanced Caching:';
$word_use_advanced_caching_note = 'Advanced Caching tells Jinzora to cache all data to local files on the server.  Doing '
                                       . 'this can dramatically speed up the inital loading of Jinzora in a big site.<br>'
                                       . '<strong>NOTE:</strong> When using advanced caching you MUST go to the tools section '
                                       . "and run the 'Update Cache' tool to rebuild the cache files anytime changes are made "
                                       . 'to your media collection (or simply delete all the .cache files in the Jinzora temp director)<br><br>';
$word_primary_language = 'Primary Language:';
$word_primary_language_note = 'This specifies the Language for Jinzora to be run in. The different language files ' . 'are located in the /lang directory within Jinzora. Please see our documentation section ' . 'for information on translating Jinzora into other languages<br><br>';
$word_allow_language_change = 'Allow Language Change:';
$word_allow_language_change_note = 'This tells Jinzora whether or not the user is allowed to change the display language on the fly<br><br>';
$word_theme = 'Theme:';
$word_theme_note1 = 'This sets the theme that Jinzora will use.<br><br>Sample Images:';
$word_theme_note2 = '<br><br>To create themes for Jinzora please see our <a href=http://www.jinzora.org/modules.php?op=modload&name=jz_docs&file=eng-theme>Theme' . 'Development Guide</a> for more details<br><br>';
$word_javascript = 'JavaScript Enabled/Disabled:';
$word_javascript_note = 'This tells Jinzora whether not you want to Enable or Disable all JavaScript inside Jinzora<br><br>';
$word_disable_all_downloads = 'Disable All Download Icons:';
$word_disable_all_downloads_note = 'This will turn on or off the downloading ability in the entire system, regardless'
                                       . "of the users access level. So if you want downloading turned off everywhere set this to 'false'."
                                       . 'Note: This should not be trusted from a security standpoint, it is merely turning off the'
                                       . 'easy to use icons that create the zipfiles for the user to download<br><br>';
$word_download_type = 'Download Zip or MP3:';
$word_download_type_note = 'When downloading single files this will tell Jinzora whether or not to create zip files. This does NOT affect the creation of Zip files when downloading albums<br><br>';
$word_hide_when_found = 'Hide tracks when found:';
$word_hide_when_found_note = "This tells Jinzora to 'hide' tracks that are found in places other than in an album folder.  It gives you a button" . "that says 'Show Tracks' that you can click to show them.  Can be useful if you have a LOT of songs in strange places<br><br>";
$word_auto_search_art = 'Auto Search for Album Art:';
$word_auto_search_art_note = 'This tells Jinzora whether or not it should automatically search for album art when an artist is being viewed.  It will download'
                                       . "and save the first image that it finds a match on, which is right about 70% of the time (don't worry you can change the downloaded"
                                       . "art using Jinzora if you don't like what it grabbed for you!)<br><br>";
$word_help_icon = 'What users see the Help Icon:';
$word_help_icon_note = 'This tells Jinzora what type of users can see the built in help icon<br><br>';
$word_display_quick_drop = 'Display quick-drop downs:';
$word_dispaly_quick_drop_note = 'This will tell Jinzora whether or not all the drop downs in the header should be displayed or not.<br><br>';
$word_rating_system = 'Enable Rating System';
$word_rating_system_note = 'This enables the rating system in Jinzora<br><br>';
$word_jinzora_dir_success = 'Media Directory Verified!<br>';
$word_jinzora_dir_failure = 'Media Directory Verification Failed!<br>';
$word_rating_dir_success = 'Data Directory Verified!<br>';
$word_rating_dir_failure = "Data Directory Verification Failed!<br>&nbsp;&nbsp;&nbsp;This generally means the directory 'data' has not been created<br>";
$word_setting_file_success = 'Settings File Verified!<br>';
$word_setting_file_failure = "Settings File Verification Failed!<br>&nbsp;&nbsp;&nbsp;This generally means the 'settings.php' file does not exist<br>";
$word_setting_write_success = 'Settings File is Writable!<br>';
$word_setting_write_failure = "Settings File Writable Verification Failed!<br>&nbsp;&nbsp;&nbsp;This generally means the 'settings.php' files is not writable<br>";
$word_users_file_success = 'Users File Verified!<br>';
$word_users_file_failure = 'Users File Verification Failed!<br>';
$word_users_write_success = 'Users File is Writable!<br>';
$word_users_write_failure = 'Users File Writable Verification Failed!<br>';
$word_errors_found = 'Errors were found, but they may not be critical.  Please review them and if possible correct any errors before continuing.<br><br>' . "Generally on *NIX this means you didn't run configure.sh";
$word_top_ratings = 'Number of top tracks:';
$word_top_ratings_note = 'This tells Jinzora how many Top Tracks to display on the home page<br>(a setting of 0 will turn this off)';
$word_suggestions = 'Enable Suggestions:';
$word_suggestions_note = 'This tells Jinzora to use the data found in the rating system to suggest tracks to the user they may like';
$word_num_suggestions = 'Number of suggested tracks:';
$word_num_suggestions_note = 'This tells Jinzora how many suggested tracks to show the user';
$word_optional_settings = 'Optional Settings';
$word_ipod_shoutcast = 'iPod, Shoutcasting and Jukebox Mode';
$word_enable_hits = 'Enable Song Counter';
$word_enable_hits_note = 'This tells Jinzora to track how many times a song has been added to a play list (basically played).  This is' . " only the number of times it is added to a playlist, not necessarily how many times it's been listened to";
$word_display_time = 'Display Track Length:';
$word_display_time_note = 'This tells Jinzora wether or not it should display the length of a track when it is found';
$word_display_rate = 'Display Track bitrate:';
$word_display_rate_note = 'This tells Jinzora if it should display the bitrate at which a track was encoded';
$word_display_feq = 'Display Track Frequency';
$word_display_feq_note = 'This tells Jinzora if it should display the frequency at which the track was encoded';
$word_display_size = 'Display Track Size:';
$word_display_size_note = 'This tells Jinzora if it should display the size of the track';
$word_enable_discussion = 'Enable Discussions';
$word_enable_discussion_note = 'This tells Jinzora to enable the built in discussions system';
$word_new_range = 'New item range:';
$word_new_range_note = "This tells Jinzora how many days old something is to be displayed as 'New'.<br>NOTE: Settings this to 0 turns this feature off";
$word_most_played = 'Display most played tracks';
$word_most_played_note = 'This tells Jinzora to display the most played tracks on the front page';
$word_num_most_played = 'Number of most played tracks:';
$word_num_most_played_note = 'This tells Jinzora how many tracks to display when displaying most played tracks';
$word_launch_note = 'NOTE: The first time Jinzora is run it will create the caching information.  On a large collection this can take a VERY ' . 'long time, please be patient...';
$word_install_type = 'Jinzora Install Type';
$word_simple_install = 'Simple Install';
$word_simple_install_note = "If you just want to stream music and don't need any of the extended features";
$word_group_install = 'Workgroup Install';
$word_group_install_note = "If you'd like to enable the groupware features<br>(such as discussions, ratings, request tracker)";
$word_expert_install = 'Expert Install';
$word_expert_install_note = 'If you want to see all the options and decide for yourself, here you go!';
$word_recomend_install = 'Jinzora Recommends';
$word_recomend_install_note = 'Not sure which one?  Just take our defaults.<br>It looks like we can figure it all out for you, so just let us...';
$word_standalone_install = 'Standalone Installs';
$word_cms_install = 'CMS Installs';
$word_cms_install_note = 'The CMS installs will select the options for Workgroup type install<br>(such as discussions, ratings, request tracker)';
$word_postnuke = 'Postnuke';
$word_postnuke_note = 'This will select the options for the Postnuke CMS';
$word_phpnuke = 'PHPNuke';
$word_phpnuke_note = 'This will select the options for the PHPNuke CMS';
$word_nsnnuke = 'NSNNuke';
$word_nsnnuke_note = 'This will select the options for the NSNNuke CMS';
$word_upgrade_install = 'Upgrade Install';
$word_upgrade_install_note = 'This will take your current settings<br>and add the settings the Jinzora Recommends for you';
$word_mambo = 'Mambo';
$word_mambo_note = 'This will select the options for the Mambo CMS';
$word_jukebox_intall = 'Jukebox Install';
$word_jukebox_intall_note = 'This will select the default options for using Jinzora as a server playing media Jukebox (non-streaming) ' . 'These options are for *NIX installs only, using noxmms (please read the help guides on this';
$word_jukebox_type = 'Jukebox Type';
$word_jukebox_type_note = 'This selects the type of Jukebox mode you wish to use';
$word_jukebox_settings = 'Jukebox Settings';
$word_jukebox_settings_note = 'These are the different options for Jukebox mode';
$word_num_upcoming = 'Number of upcoming tracks to display';
$word_path_to_xmms_shell = 'The path to xmms-shell';
$word_auto_refresh = 'The amount of time (in seconds) the page should wait to refresh<br>(to update the current playing track)';
$word_download_type = 'Download File Type:';
$word_download_type_note = 'When downloading an entire album what type of file should be generated';
$word_single_download_type = 'Single File Download Type:';
$word_single_download_type_note = 'When downloading a single file what type of file should be generated';
$word_download_speed = 'Limit Download Bandwidth:';
$word_download_speed_note = 'This will let Jinzora regulate the speed at which items are downloaded.  This does not affect streaming speed,' . ' only the speed at which items are downloaded.  A setting of 0 turns this feature off';
$word_date_format = 'Date Format:';
$word_date_format_note = 'The PHP based format of how dates will be displayed.  Please see <a target=_blank href=http://www.php.net/manual/en/function.date.php>PHP Date Reference</a>' . ' for specific details on the use of this';
$word_max_rss_feed_items = 'Maximum RSS Items:';
$word_max_rss_feed_items_note = 'This sets the maximum number of items that Jinzora will generate when creating XML based RSS Newsfeeds';
$word_search_echocloud = 'Search Echocloud:';
$word_search_echocloud_note = 'This tells Jinzora if it should automatically search the <a href=http://www.echocloud>Echocloud</a> database for' . ' similar artists to the one that is being viewd, and how many to return.  A setting of 0 turns this feature off';
$install_message = 'Please note that as you have not choosen Expert mode installation the following screens will be submitted automatically.' . 'We\\n\\nSit back and relax we will be done in just a second...';

$word_juekbox_pass = 'Jukebox Server Password:';
$word_jukebox_port = 'Jukebox Server TCP Port:';
$word_mdpro = 'MDPro CMS';
$word_mdpro_note = 'This will select the options for the MDPro CMS';
$word_cgpnuke = 'CPGNuke CMS';
$word_cgpnuke_note = 'This will select the options for the CPGNuke CMS';
$word_disable_random = 'Disable Random:';
$word_disable_random_note = 'This will disable all the random generate icons';
$word_info_icons = 'Who can see info icons?';
$word_info_icons_note = 'This selects what users can see the info popup pages';
$word_auto_search_lyrics = 'Auto Search for Lyrics:';
$word_auto_search_lyrics_note = "This tells Jinzora to automatically search Leo's Lyrics for song lyrics when viewing the details for a track";
$word_cannot_open = 'Cannot open settings file for writing...';
$word_next = 'Next';
$word_allow_theme_change = 'Allow Theme change:';
$word_allow_theme_change_note = 'This will tell Jinzora if a standard user can change the theme for Jinzora in their current session';
$word_display_genre_drop = 'Display Genre drop down:';
$word_display_genre_drop_note = 'This tells Jinzora whether or not to show the Genre quick drop-down in the header';

$word_display_artist_drop = 'Display Artist drop down:';
$word_display_artist_drop_note = 'This tells Jinzora whether or not to show the Artist quick drop-down in the header';
$word_display_album_drop = 'Display Album drop down:';
$word_display_album_drop_note = 'This tells Jinzora whether or not to show the Album quick drop-down in the header';
$word_display_track_drop = 'Display Track drop down:';
$word_display_track_drop_note = 'This tells Jinzora whether or not to show the Track quick drop-down in the header<br><strong>WARNING:</strong> On a big site this can be PAINFULLY slow!!!';
$word_display_quick_drop = 'Display Quick Play drop down:';
$word_display_quick_drop_note = 'This tells Jinzora whether or not to show the Quick Play quick drop-down in the header';
$word_num_other_albums = 'Number of other albums:';
$word_num_other_albums_note = 'This tells Jinzora how many other, random albums (from the same artist) to show when viewing tracks from an album (a setting of 0 turns this off)';
$word_show_sub_totals = 'Show subtotals:';
$word_show_sub_totals_note = 'If you enable this Jinzora will show you the sub totals (either artists or albums) for each Genre and/or Artist right next to the Genre/Artist name.';
$word_show_amg_search = "Show 'Search: AMG'";
$word_show_amg_search_note = 'This enables or disables the link to search AMG (allmusic.com) for information on the current album';
$word_show_search_art = "Show 'Search for Album Art':";
$word_show_search_art_note = "This tells Jinzora if it should show the 'Search for album art' links when viewing an album that doesn't already have album art for it.<br>NOTE: Only admins can see this tool!";
$word_show_all_checkboxes = 'Show All Checkboxes:';
$word_show_all_checkboxes_note = "This tells jinzora whether or not it should display check boxes on the Genre/Artists pages so that items can be easily added to playlists.  It's off by default because the display can get rather cluttered...";
$word_album_art_dim = 'Album Art Dimensions:';
$word_album_art_dim_note = "This tells Jinzora what dimensions to resize the album art to when found.<br> NOTE: The art will always stay the correct dimensions<br> NOTE: Setting each of these to '0' will turn this feature off<br>"
                                    . '<strong>NOTE</strong>: The webserver MUST have write access to the media directory for this feature to work<br> <strong>NOTE</strong>: The GD Libraries MUST be installed for this feature to work';
$word_force_dimensions = 'Force Dimensions:';
$word_force_dimensions_note = "This tells Jinzora to force the size of the album art on the Tracks page.<br> NOTE: This does NOT resize the actual file, just the display of the file<br> NOTE: Setting each of these to '0' will turn this feature off";
$word_artist_dimensions = 'Artist Image Dimensions:';
$word_artist_dimensions_note = "This tells Jinzora what dimensions to resize the Artists art to when found.<br> NOTE: The art will always stay the correct proportions<br> NOTE: Setting each of these to '0' will turn this feature off<br>"
                                    . '<strong>NOTE</strong>: The webserver MUST have write access to the media directory for this feature to work<br> <strong>NOTE</strong>: The GD Libraries MUST be installed for this feature to work';
$word_keep_porpotions = 'Keep Art Proportions:';
$word_keep_porpotions_note = "This tells Jinzora whether or not to keep the proportions on the art as it resizes it. If this is set to 'Skew' then art will be resized to the exact dimensions you specify."
                                    . '<strong>NOTE</strong>: The webserver MUST have write access to the media directory for this feature to work<br> <strong>NOTE</strong>: The GD Libraries MUST be installed for this feature to work';
$word_show_random_artist_art = 'Show Random Art on Artist Page:';
$word_show_random_artist_art_note = 'This tells Jinzora how many (if any) random album covers to show when viewing a specific Genre.<br><strong>NOTE</strong>: You MUST be in Genre/Artist/Album mode.<br><strong>NOTE</strong>: A setting of 0 turns this feature off.';
$word_sort_by_year = 'Sort Albums by Year:';
$word_sort_by_year_note = 'This tells Jinzora to sort albums by and display the year information of albums by reading the ID3 tags (if available) of the files contained in the album folder';
$word_pull_media_info = 'Pull info from media files:';
$word_pull_media_info_note = 'This tells Jinzora whether or not it should look at the MP3 files it finds to read their information (like ID3 tags, filesize, track length, bitrate, etc)';
$word_hide_id3_comments = 'Hide ID3 Comments:';
$word_hide_id3_comments_note = 'This tells Jinzora whether or not it should display the contents of the ID3 comments field under the track name if it finds this data';
$word_show_loggedin_level = 'Show Logged in Access Level:';
$word_show_loggedin_level_note = 'This tells Jinzora whether or not to show the level each user is logged in as in the footer. For example if the default access is viewonly the footer would tell each user this.';
$word_true = 'True';
$word_false = 'False';
$word_num_columns = 'Columns displayed in Genre/Artists:';
$word_num_columns_note = 'This tells Jinzora how many columns to create when displaying the Genres and Artists.';
$word_artist_length = 'Max Artists Display Length:';
$word_artist_length_note = 'This tells Jinzora how many characters to truncate the names of the Artists to when displaying them.';
$word_quick_length = 'Quick List Display Length:';
$word_quick_length_note = 'This tells Jinzora how many characters to truncate the names of the entries that are added to the drop down, quick lists in the header section.';
$word_album_length = 'Album Name Display Length:';
$word_album_length_note = 'This tells Jinzora how many characters to truncate the names of the albums in the view artist page.';
$word_main_table_width = 'Main Table Width:';
$word_main_table_width_note = 'This tells Jinzora how wide to make all the tables, in percent (100 = 100%).';
$word_playlist_ext = 'Playlist File Extension:';
$word_playlist_ext_note = 'This tells Jinzora the extension of the playlist file that it will generate';
$word_temp_dir = 'Jinzora Temp Directory:';
$word_temp_dir_note = 'This tells Jinzora where to write data when doing some operations. If it is changed it MUST be a location inside the jinzora directory.<br><strong>NOTE</strong>: This is relative to the root of where Jinzora is installed, per step 1';
$word_playran_amounts = 'Random Play Amounts:';
$word_playran_amounts_note = "These decide how many choices show in the drop down, random play list in the top right hand corner of the header. (Seperated with a '|')";
$word_audio_types = 'Audio Types:';
$word_audio_types_note = 'These decide what types of audio files Jinzora will display for playback<br> Note: Please make sure if you add any types that you keep this format and that the media type you add can be streamed over HTTP.<br> (MUST be seperated with |)';
$word_video_types = 'Video Types:';
$word_video_types_note = 'These decided what types of video files Jinzora will display for playback<br>Note: Please make sure if you add any types that you keep this format and that the media type you add can be streamed over HTTP.<br> (MUST be seperated with |)';
$word_img_types = 'Image Types:';
$word_img_types_note = 'These decided what types of image files Jinzora will look at for Album art.';
$word_track_sep = 'Track Number/File Name Separator:';
$word_track_sep_note = "your MP3s are named '01 - Track Name Here.mp3' ' - ' would be the correct value. In contrast if they were named '01_TrackNameHere.mp3' you would" . "want to use '_' here.<br><strong>NOTE</strong>: The values here MUST be separated with a pipe | symbol";
$word_auth = 'Auth User/Pass:';
$word_auth_note = 'This tells Jinzora to add this value to the URL when generating playlists.  Format should be<br>username:password <br>(everything else is automatic)';
$word_embedding = 'Embedding Jinzora:';
$word_embedding_note = 'This tells Jinzora to embed itself in an existing web site.  Please see our documentation section for more details on this because while it works, there are some rules to follow!<br><br>'
                                    . 'The Header Page is the page that will be included as the header above Jinzora<br>The Footer Page is the page that will be included as the footer below Jinzora';
$word_header = 'Header Page:';
$word_footer = 'Footer Page:';
$word_ephpod_file = 'ephPod Sync Filename:';
$word_ephpod_file_note = 'This is the name of the file that will be generated to be imported into ephPod to make for easy syncing of your MP3 collection to an iPod';
$word_ephpod_dirve = 'ephPod Windows Driveletter:';
$word_ephpod_dirve_note = 'This is the drive letter that you have mapped in Windows to the location of your'
                                    . 'media_dir above. For example if you MP3s are located in /var/www/modules/jinzora/music and you shared that directory using, say, samba,'
                                    . ' then you mapped a drive to that directory (so ephPod could see it, and therefore sync your iPod) this would be that drive letter.';
$word_ipod_size = 'iPod Size (in MB):';
$word_ipod_size_note = 'This is the USABLE size of your iPod in MB. For example my 20 GB iPod has a usable' . "space of about 18.5 GB so my value would be '18500'. This lets Jinzora tell you how much free space you'll have on your iPod once you select Artists for syncing..";
$word_shoutcasting = 'Shoutcasting Support:';
$word_shoutcasting_note = 'This tells Jinzora whether you want to enable Shoutcast support or not. The Shoutcast server must be configured for this please see the documentation for how to do this.';
$word_shoutcasting_ip = 'Shoutcast Server IP Address:';
$word_shoutcasting_ip_note = 'This is the IP address of the local server that will be providing the Shoutcast stream';
$word_shoutcasting_port = 'Shoutcast Server Port:';
$word_shoutcasting_port_note = 'This is the IP Port of the local server that will be providing the Shoutcast stream';
$word_shoutcasting_pass = 'Shoutcast Server Password:';
$word_shoutcasting_pass_note = 'This is the Shoutcast password of the local server that will be providing the Shoutcast stream';
$word_shoutcasting_refresh = 'Shoutcast Page Refresh:';
$word_shoutcasting_refresh_note = "This sets the amount of time in seconds that Jinzora will refresh a page when Shoutcasting is enabled.  This is so the information in the footer about what track is being streamed won't get old.  A setting of 0 turns this off.";
$word_track_plays_only = 'Track Plays Only';
$word_track_plays_only_note = 'Selecting this option will only show the play icon next to a track (and no where else)';
$word_enable_playlist = 'Enable Playlists';
$word_enable_playlist_note = 'This will enable the server side playlist options';
$word_display_downloads = 'Display Download Tracking';
$word_display_downloads_note = 'This will display the number of times a track was downloaded';
$word_display_track_num = 'Display Track Numbers';
$word_display_track_num_note = 'This will display the track number next to the name of a track';
$word_please_wait = 'Please Wait...';
$word_agree = 'Agree';
$word_must_agree = 'You must agree before proceeding...';

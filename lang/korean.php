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
$word_genres = '장르';
$word_genre = '장르';
$word_search_results = '검색 결과';
$word_tools = '관리 도구';
$word_search = '검색:';
$word_artist = '아티스트';
$word_album = '앨범';
$word_pleasechoose = '선택해주세요...';
$word_play = '재생';
$word_play_all_albums_from = '모든 앨범 재생:';
$word_randomize_all_albums_from = '모든 앨범 임의 순서로 하기:';
$word_play_album = '앨범 재생';
$word_download_album = '앨범 다운로드';
$word_id3_tag_tools = 'MP3 ID3 태그 관리 도구';
$word_update_id3v1 = 'ID3 태그 업데이트';
$word_update_id3v1_desc = '모든 ID3 태그 자동적으로 생성하기 장르/아티스트/앨범/트랙 번호 - 파일명';
$word_strip_id3v1_desc = '모든 ID3 태그 지워버리기';
$word_update_id3v2 = 'ID3 태그 업데이트';
$word_update_id3v2_desc = '모든 ID3 태그 자동적으로 생성하기 장르/아티스트/앨범/트랙 번호 - 파일명';
$word_strip_id3v2_desc = '모든 ID3 태그 지워버리기';
$word_strip_id3v1 = 'ID3 태그 지워버리기';
$word_strip_id3v2 = 'ID3 태그 지워버리기';
$word_directory_other_tools = '디렉토리 | 파일 도구 | 기타 도구';
$word_upload_center = '업로드 센터';
$word_select_for_ipod = 'iPod 싱크 선택하기';
$word_fix_file_case = '파일 이름 고정시키기';
$word_create_new_genre = '새로운 장르 만들기';
$word_delete_genre = '장르 삭제';
$word_upload_to_jinzora = 'Jinzora에 업로드 하기';
$word_ipod_select_desc = 'ephPod를 이용하여 iPod에 싱크할 아티스트를 선택합니다';
$word_fix_file_case_desc = '모든 단어의 첫글자를 대문자로 바꿉니다';
$word_create_new_genre_desc = 'Jinzora에 새로운 장르 추가하기';
$word_delete_genre_desc = 'Jinzora에 장르 삭제하기';
$word_add_to = '추가:';
$word_delete = '삭제';
$word_download = '다운로드';
$word_return_home = '초기화면으로 돌아가기';
$word_more = '더 찾아보기';
$word_play_random = '임의 순서로 재생';
$word_move_item = '아이템 이동';
$word_login = '로그인';
$word_random_select = '임의 순서로 선택하기:';
$word_logout = '로그아웃';
$word_up_level = '레벨 올리기';
$word_down_level = '레벨 낮추기';
$word_enter_setup = '셋업메뉴 들어가기';
$word_go_button = '들어가기';
$word_username = '사용자:';
$word_password = '비밀번호:';
$word_home = '초기화면';
$word_language = '언어:';
$word_theme = '주제:';
$word_secure_warning = "Jinzora는 안전하지 않습니다, 쉘에서 'sh secure.sh'을 실행시켜주세요!";
$word_check_for_update = 'Jinzora 업데이트 확인하기';
$word_new_genre = '새로운 장르:';
$word_search_for_album_art = '앨범 아트 검색하기';
$word_cancel = '취소';
$word_are_you_sure_delete = '정말 삭제할까요:';
$word_playlist = '재생 목록';
$word_check_all = '모두 선택';
$word_check_none = '모든 선택 취소';
$word_selected = '선택되었습니다';
$word_session_playlist = ' - 세션 재생 목록 - ';
$word_new_playlist = ' - 새로운 재생 목록 - ';
$word_send_tech_email = '기술지원팀으로 정보 보내기';
$word_auto_update = '자동 업데이트';
$word_auto_update_beta = '자동 업데이트 (beta release)';
$word_rewrite_files_from_id3 = 'ID3 정보로 파일이름 다시 쓰기';
$word_create_shoutcast_playlist = 'Shoutcast 재생 목록 만들기';
$word_hide_tracks = '트랙 감추기';
$word_show_tracks = '트랙 보여주기';
$word_shoutcast_tools = 'Shoutcast 도구';
$word_start_shoutcast = 'Shoutcast Server 시작';
$word_stop_shoutcast = 'Shoutcast Server 멈추기';
$word_create_shoutcast_random_playlist = 'Shoutcast Playlist 임의 순으로';
$word_fix_media_names = '미디어 파일 이름 고정시키기';
$word_remember_me = '사용자 정보 기억하기';
$word_show_hidden = '감춰진 것 보기';
$word_update_cache = '정보(캐쉬) 업데이트';
$word_search_missing_album_art = '잃어버린 앨범 아트 검색';

$word_define = 'Define';

$word_define_uc = '업로드 센터는 사용자로 하여금 Jinzora에 파일을 업로드 하게 합니다';
$word_define_id3_update = '이 도구는 사용자로 하여금 폴더 구조 자체의 정보를 이용하여 모든 MP3 파일의 ID3 태그를 다이내믹하게 업데이트 하도록 도와줍니다\\n\\n예를 들어, 3 디렉토리 모드에서:\\n\\nJazz\\Miles Davis\\Kind of Blue\\01 - All Blues.mp3\\n\\n...이 경우,...\\n\\n장르: Jazz\\n아티스트: Miles Davis\\n앨범: Kind of Blue\\n트랙 번호: 01\\n트랙 이름: All Blues\\n\\n 2 디렉토리 모드에서는 장르 칸을 무시하고 넘어갑니다';
$word_define_ipod_sync = '이 도구는 ephPod를 이용하여 사용자로 하여금 iPod MP3 player에 싱크할 아티스트를 선택하게 합니다';
$word_define_check_updates = 'Jinzora 메인 서버에 연결하여 새로운 버젼이 나왔는지 확인합니다';
$word_define_enter_setup = '설정사항을 쉽게 바꿀 수 있도록 셋업 과정을 다시 시작합니다\\n\\n주의: 먼저 configure.sh를 실행시켜 주십시오!';
$word_define_start_shoutcast = '(shoutcast가 가능할 경우) Shoutcast server를 시작합니다';
$word_define_stop_shoutcast = '(shoutcast가 가능할 경우) Shoutcast server를 멈춥니다';
$word_define_update_cache = '이 도구는 현재 세션 캐쉬 정보를 업데이트 합니다\\n\\n실행 중, 파일이나 디렉토리 구조에 변경 사항이 있을 때 실행시켜주십시오\\n\\n이러한 방식이 Jinzora를 훨씬 더 빠르게 만듭니다';
$word_define_search_for_art = '이 도구는 사용자에게 images.google.com으로부터 앨범 별로 가능한 앨범 아트를 보여줍니다\\n\\n사용자는 마음에 드는 아트를 선택할 수 있습니다, 또는 시스템이 디폴트 아트를 생성합니다';
$word_define_rewrite_from_id3 = "이 도구는 ID3 태그의 트랙 번호와 트랙 이름을 이용하여 모든 파일 이름을 새로 작성합니다\\n\\n주의: 첫번째 트랙 구분자는 '-'입니다, 중복될 경우 '-' 새로운 파일 이름의 트랙 구분자가 될 것입니다";
$word_change_art = '아트 바꾸기';
$word_survey = 'Jinzora 설문';
$word_user_manager = '사용자 관리';
$word_define_user_manager = '각각의 사용자들마다 다른 레벨로 접근하는 것을 허락합니다';
$word_add_user = '사용자 추가';
$word_access_level = '접근 레벨';
$word_update_successful = '업데이트 성공!';
$word_send_playlist = '재생 목록 보내기';
$word_rate = '점수 주기';
$word_discuss = '의견 달기';
$word_new = 'New!';
$word_editcomment = '코멘트 편집하기';
$word_rewrite_tags = 'ID3 태그 새로 쓰기';
$word_media_management = '미디어 관리';
$word_actions = '액션';
$word_group_features = '그룹 상세 정보';
$word_item_information = '아이템 정보';
$word_browse_album = '앨범 열어보기';
$word_new_from = '금주의 새로운 아이템: ';
$word_new_from_last = '이전의 새로운 아이템: ';
$word_jukebox_controls = '주크박스 제어';
$word_pause = '잠시 멈춤';
$word_stop = '정지';
$word_next = '다음';
$word_previous = '이전';
$word_volume = '음량';
$word_mute = '음소거';
$word_up = '위로';
$word_down = '아래로';
$word_nowplaying = '재생 중';
$word_refresh_in = '새로 고침:';
$word_upcoming = '다음 연주할 트랙';
$word_stopped = '정지';
$word_next_track = '다음 트랙';
$word_pause = '잠시 멈춤';
$word_playback_to = '뒤로:';
$word_jukebox = '주크박스';
$word_stream = '스트림';
$word_information = '검색';
$word_echocloud = 'Echocloud에서 비슷한 곡 찾아보기';
$word_clear = '재생목록 모두 지우기';
$word_bulk_edit = '여러개 묶어서 편집하기';
$word_complete_playlist = '재생목록 완성';
$word_add_at = '추가:';
$word_current = '현재';
$word_end = '끝';
$word_add_to_favorites = '지금 트랙을 favorites에 추가하기';
$word_noacess = '죄송합니다, 들어갈 수 없습니다!';
$word_pleasewait = '로그인 하는 동안 기다려주세요...';
$word_play_lofi = 'Lo-Fi 재생';
$word_lofi = 'Lo-Fi';
$word_donate = 'Jinzora에 기부하기!';
$word_define_word_donate = 'Jinzora Development Team에 기부하기!';
$word_description = '설명:';
$word_exclude_genre = '장르 차단';
$word_update_description = '업데이트 설명';
$word_close = '닫기';
$word_update_close = '업데이트 & 닫기';
$word_short_description = '짧은 설명:';
$long_short_description = '긴 설명:';
$word_artist_image = '아티스트 이미지:';
$word_new_image = '새로운 이미지:';
$word_delete_artist = '아티스트 삭제';
$word_exclude_artist = '아티스트 차단';
$word_album_name = '앨범 이름:';
$word_album_description = '앨범 설명:';
$word_album_image = '앨범 이미지:';
$word_album_year = '앨범 연도:';
$word_delete_album = '앨범 삭제';
$word_global_exclude = '전체 차단';
$word_track_number = '트랙 번호:';
$word_track_name = '트랙 이름:';
$word_file_name = '파일 이름:';
$word_not_writable = '파일에 기록할 수 없습니다!!!';
$word_track_time = '트랙 시간:';
$word_bit_rate = 'Bit Rate:';
$word_sample_rate = 'Sampling Rate:';
$word_file_size = '파일 크기:';
$word_file_date = '파일 날짜:';
$word_id3_description = 'ID3 태그 설명:';
$word_thumbnail = '작은 이미지 보기:';
$word_search_lyrics = '가사 자동 검색';
$word_update = '업데이트';
$word_search_new = '새로운 미디어 검색';
$word_search_new_define = '설정 파일에 정의된 새로운 미디어를 찾아서 보여줍니다';
$word_new_media = '새로운 미디어';
$word_updating_information = '정보를 업데이트 하고 있습니다: ';
$word_please_wait_artist = '이 아티스트에 대한 모든 트랙을 업데이트 하는 동안 기다려주세요...<br>시간이 조금 걸릴 수 있습니다...';
$word_updating_track = '트랙을 업데이트 하고 있습니다';
$word_updating_album = '앨범을 업데이트 하고 있습니다';
$word_please_wait = '기다려주세요...';
$word_tracks = '트랙';
$word_plays = '재생';
$word_downloads = '다운로드';
$word_select_destination = '대상을 선택하세요';
$word_dest_path = '대상 경로 (미디어 디렉토리 내)';
$word_add_files = '파일 추가하기...';
$word_upload = '업로드';
$word_clear_list = '목록 지우기';
$word_current_file = '현재 파일';
$word_total_complete = '전체 완료';
$word_new_subdirectory = '서브 디렉토리 만들기';
$word_select = '선택하기';
$word_up_onelevel = '레벨 하나 올리기';
$word_subdirs = '하위 디렉토리';
$word_finished = '업로드가 끝났습니다!';
$word_create_low_fi = 'Lo-Fi 생성';
$word_delete_low_fi = 'Lo-Fi 삭제';
$word_today = '오늘';
$word_yesterday = '어제';
$word_days_of_week = ['일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일'];

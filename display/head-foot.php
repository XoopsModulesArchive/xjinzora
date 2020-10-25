<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* JINZORA | Web-based Media Streamer
*
* Jinzora is a Web-based media streamer, primarily desgined to stream MP3s
* (but can be used for any media file that can stream from HTTP).
* Jinzora can be integrated into a CMS site, run as a standalone application,
* or integrated into any PHP website.  It is released under the GNU GPL.
*
* Jinzora Author:
* Ross Carlson: ross@jasbone.com
* http://www.jinzora.org
* Documentation: http://www.jinzora.org/docs
* Support: http://www.jinzora.org/forum
* Downloads: http://www.jinzora.org/downloads
* License: GNU GPL http://www.gnu.org/copyleft/gpl.html
*
* Contributors:
* Please see http://www.jinzora.org/modules.php?op=modload&name=jz_whois&file=index
*
* Code Purpose: This page contains all the Header and Footer display related functions
* Created: 9.24.03 by Ross Carlson
*
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

// This function adds the header to the top of the pages
function displayHeader($title, $endBreak = 'true')
{
    global $this_page, $img_home, $main_table_width, $quick_list_truncate, $img_random_play, $cms_mode, $word_genre, $word_artist, $word_album, $word_tools, $word_search, $word_pleasechoose, $word_login, $random_play_amounts, $word_random_select, $random_play_types, $word_logout, $directory_level, $img_up_arrow, $word_go_button, $word_home, $header_drops, $genre_drop, $artist_drop, $album_drop, $quick_drop, $root_dir, $word_playlist, $web_root, $word_show_hidden, $embedded_header, $word_tracks, $song_drop, $audio_types, $video_types, $media_dir, $img_more, $img_random_play_dis, $url_seperator, $help_access, $jukebox, $disable_random, $lang_file, $show_slimzora, $img_slim_pop, $allow_resample, $resampleRates, $default_random_play_type, $default_random_play_amount;

    // Ok, right off the bat let's set the session variable of what page we're on so we can go back to it easily

    setPreviousPage();

    // First let's see if the cache has been created or not

    if (!isset($_SESSION['album_list'])) {
        updateBackend();
    }

    // Let's make sure cur_theme is set

    if (!isset($_SESSION['cur_theme'])) {
        $_SESSION['cur_theme'] = '';
    }

    // First let's get all the POST and GET variables and clean them up

    $genre = jzstripslashes(urldecode($_GET['genre']));

    $artist = jzstripslashes(urldecode($_GET['artist']));

    $album = jzstripslashes(urldecode($_GET['album']));

    // Ok, now we need to see if they are embedding this or not

    checkForEmbed();

    // Let's set the head and a title if we are in standalone mode

    if ('false' == $cms_mode and '' == $embedded_header) {
        // Let's create the HTML header

        echo returnHTMLHead($title);

        // Now let's see if they wanted to secure right clicks

        echo displaySecureLinks();
    }

    // Let's include the normal javascript and for the popup stuff

    echo returnJavascript();

    // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

    // Now let's see if they wanted to edit something using the drop down menu

    if (isset($_GET['editmenu'])) {
        // Ok, now what to edit...

        switch ($_GET['editmenu']) {
            case 'album':
                // Now let's open the album edit window
                ?>
                <SCRIPT LANGUAGE=JAVASCRIPT TYPE="TEXT/JAVASCRIPT"><!--\
						albumEditAutoWin("<?php echo $root_dir . '/mp3info.php?type=album&info=' . urlencode($genre) . '/' . urlencode($artist) . '/' . urlencode($album) . '&cur_theme=' . $_SESSION['cur_theme']; ?>");
                    history.back();
                    -->
                </SCRIPT>
                <?php
                break;
            case 'artist':
                // Now let's open the artist edit window
                ?>
                <SCRIPT LANGUAGE=JAVASCRIPT TYPE="TEXT/JAVASCRIPT"><!--\
						albumEditAutoWin("<?php echo $root_dir . '/mp3info.php?type=artist&info=' . urlencode($genre) . '/' . urlencode($artist) . '&cur_theme=' . $_SESSION['cur_theme']; ?>");
                    history.back();
                    -->
                </SCRIPT>
                <?php
                break;
            case 'bulkalbum':
                // Now let's open the artist edit window
                ?>
                <SCRIPT LANGUAGE=JAVASCRIPT TYPE="TEXT/JAVASCRIPT"><!--\
						albumBulkEditAutoWin("<?php echo $root_dir . '/mp3info.php?type=bulkalbum&info=' . urlencode($genre) . '/' . urlencode($artist) . '/' . urlencode($album) . '&cur_theme=' . $_SESSION['cur_theme']; ?>");
                    history.back();
                    -->
                </SCRIPT>
                <?php
                break;
            case 'addfake':
                // Now let's open the artist edit window
                ?>
                <SCRIPT LANGUAGE=JAVASCRIPT TYPE="TEXT/JAVASCRIPT"><!--\
						albumBulkEditAutoWin("<?php echo $root_dir . '/mp3info.php?type=addfake&info=' . urlencode($genre) . '/' . urlencode($artist) . '/' . urlencode($album) . '&cur_theme=' . $_SESSION['cur_theme']; ?>");
                    history.back();
                    -->
                </SCRIPT>
                <?php
                break;
        }
    }

    // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

    // let's close our head

    if ('false' == $cms_mode and '' == $embedded_header) {
        echo returnCloseHTMLHead();
    }

    // Let's output the style sheet and set some style elements

    echo returnCSS();

    if ('true' == $cms_mode) {
        echo returnCMSCSS();
    }

    // Now let's get our arrays from the session content so we can display everything

    switch ($directory_level) {
        case '3':
            $genreArray = returnGenreList();
            $artistArray = returnArtistList();
            $albumArray = returnAlbumList();
            break;
        case '2':
            $genreArray = returnArtistList();
            $artistArray = returnAlbumList();
            break;
        case '1':
            $genreArray = returnAlbumList();
            break;
    }

    // Now let's see if they wanted the full song list too

    if ('true' == $song_drop) {
        $songArray = returnTrackList();
    }

    // Now let's get how many items there are

    $num_genre = returnNumGenres();

    $num_artist = returnNumArtists();

    $num_album = returnNumAlbums();

    // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

    if (isset($songArray)) {
        // Ok, now let's sort it by the last column

        if (count($songArray) > 1) {
            for ($ctr = 0, $ctrMax = count($songArray); $ctr < $ctrMax; $ctr++) {
                $titleArray = explode('----', $songArray[$ctr]);

                $songArray[$ctr] = $titleArray[count($titleArray) - 1] . '|||||' . $songArray[$ctr];
            }

            sort($songArray);

            // Ok, now let's put it back

            for ($ctr = 0, $ctrMax = count($songArray); $ctr < $ctrMax; $ctr++) {
                $finalArray = explode('|||||', $songArray[$ctr]);

                $songArray[$ctr] = $finalArray[1];
            }

            $num_song = count($songArray) - 1;
        }
    }

    // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

    // Now let's start displaying our tables

    jzTableOpen($main_table_width, '0', 'jz_header_table');

    jzTROpen('jz_header_table_tr');

    jzTDOpen('80', 'left', 'top', 'jz_header_table_outer', '0', '');

    jzTableOpen('80', '0', '', '');

    jzTROpen('jz_header_table_tr');

    jzTDOpen('80', 'left', 'top', '', '0', '');

    // let's make sure the line doesn't break

    echo '<nobr>';

    // Let's display the home icon

    jzHREF($this_page, '', 'jz_col_table_href', '', $img_home);

    echo '&nbsp;';

    // Let's make sure they are not a view only user

    if ('viewonly' != $_SESSION['jz_access_level'] and 'lofi' != $_SESSION['jz_access_level'] and 'noaccess' != $_SESSION['jz_access_level']) {
        // Let's show them the random link for where they are

        if ('' != $genre) {
            $link_url = 'genre&info=' . $genre;

            if ('' != $artist) {
                $link_url = 'artist&info=' . $genre . '/' . $artist;
            }

            if ('' != $album) {
                $link_url = 'album&info=' . $genre . '/' . $artist . '/' . $album;
            }

            // Let's see if we are looking at a playlist or not

            if ('' == mb_stristr($title, $word_playlist . ': ') and 'false' == $disable_random) {
                $item_url = $root_dir . '/playlists.php?d=1&style=normal&info=' . $link_url;

                jzHREF($item_url, '', 'jz_col_table_href', '', $img_random_play);

                echo '&nbsp;';
            }
        } else {
            // Let's see if we are looking at a playlist or not

            if ('' == mb_stristr($title, $word_playlist . ': ') and 'false' == $disable_random) {
                $item_url = $root_dir . '/playlists.php?d=1&style=normal&info=/';

                jzHREF($item_url, '', 'jz_col_table_href', '', $img_random_play);

                echo '&nbsp;';
            }
        }
    } else {
        // Sorry, view only....

        echo $img_random_play_dis . ' ';
    }

    // Let's setup the link for the help docs IF they have access to it

    if ($help_access == $_SESSION['jz_access_level'] or 'all' == $help_access) {
        $item_url = $root_dir . '/docs/help.php?language=' . $lang_file;

        jzHREF($item_url, '_blank', 'jz_col_table_href', 'helpWin(this); return false;', $img_more);

        echo '&nbsp;';
    }

    // Now let's show them the Slimzora popup

    if (true === $show_slimzora and ('noaccess' != $_SESSION['jz_access_level'] and 'viewonly' != $_SESSION['jz_access_level'])) {
        $item_url = $root_dir . '/slim.php?cur_theme=' . $_SESSION['cur_theme'];

        jzHREF($item_url, '_blank', 'jz_col_table_href', 'slimWin(this); return false;', $img_slim_pop);
    }

    // Now let's close out

    echo '</nobr>';

    jzTDClose();

    jzTRClose();

    jzTableClose();

    jzTDClose();

    // Let's move on

    jzTDOpen('100', 'left', 'top', 'jz_header_table_outer', '0');

    jzTableOpen('100', '0', 'jz_header_table');

    jzTROpen('jz_header_table_tr');

    jzTDOpen('50', 'left', 'top', 'jz_header_table_td', '0');

    // Now let's set the header text

    echo '<span class="jz_headerTitle">' . jzstripslashes($title) . '</span>';

    // Let's see if there is a file that we want to put in the header here

    echo returnHeaderText();

    jzTDClose();

    jzTDOpen('50', 'right', 'top', 'jz_header_table_td', '0');

    // First let's see if the username is set and if not make it blank

    if (!isset($_COOKIE['jz_user_name'])) {
        $_COOKIE['jz_user_name'] = '';
    }

    // Let's see if the user has logged in, and if not let's show that link

    if ('anonymous' == $_COOKIE['jz_user_name'] and 'false' == $cms_mode) {
        $item_url = $this_page . $url_seperator . 'ptype=login&return=' . str_replace('&', '||||', str_replace('ptype', 'ptype', $_SERVER['QUERY_STRING']));

        jzHREF($item_url, '', 'jz_header_table_href', '', $word_login);
    } else {
        // Now let's make sure they aren't in CMS mode and that they have logged in

        if ('false' == $cms_mode and '' != $_COOKIE['jz_user_name']) {
            $item_url = $this_page . $url_seperator . 'ptype=logout';

            jzHREF($item_url, '', 'jz_header_table_href', '', $word_logout);

            echo ' | ';
        } else {
            if ('false' == $cms_mode) {
                $item_url = $this_page . $url_seperator . 'ptype=login&return=' . str_replace('&', '||||', str_replace('ptype', 'ptype', $_SERVER['QUERY_STRING']));

                jzHREF($item_url, '', 'jz_header_table_href', '', $word_login);

                echo ' | ';
            }
        }

        // Now let's see if there are excluded items and if so let them un-exclude them

        if (returnExcludeArray('global') and 'admin' == $_SESSION['jz_access_level']) {
            $item_url = $this_page . $url_seperator . 'ptype=showhidden';

            jzHREF($item_url, '', 'jz_header_table_href', '', $word_show_hidden);

            echo ' | ';
        }
    }

    // Now let's see if they've logged in or not and give them the appropriate level of access

    // Let's make sure this variable is set

    if (!isset($_SESSION['jz_access_level'])) {
        $_SESSION['jz_access_level'] = '';
    }

    if ('admin' == $_SESSION['jz_access_level']) {
        $item_url = $this_page . $url_seperator . 'ptype=tools';

        jzHREF($item_url, '', 'jz_header_table_href', '', $word_tools);

        echo ' | ';
    }

    // Now let's show them the search box

    if ('noaccess' != $_SESSION['jz_access_level'] and 'viewonly' != $_SESSION['jz_access_level'] and 'lofi' != $_SESSION['jz_access_level']) {
        echo '<nobr>';

        echo '<form action="' . $this_page . $url_seperator . '"ptype=search" method="post">';

        $item_url = $this_page . $url_seperator . 'ptype=powersearch';

        jzHREF($item_url, '', 'jz_header_table_href', '', $word_search);

        echo ' <input class="jz_input" type="text" name="song_title" size="15">';

        echo ' <select class="jz_select" name="search_type" style="width: 60px;">';

        echo '<option value="tracks">' . $word_tracks . '</option>';

        // Now let's show them the choices

        if ('3' == $directory_level) {
            echo '<option value="genres">' . $word_genre . '</option>';
        }

        if ('3' == $directory_level or '2' == $directory_level) {
            echo '<option value="artists">' . $word_artist . '</option>';
        }

        echo '<option value="albums">' . $word_album . '</option>';

        echo '</select>';

        echo ' <input class="jz_submit" type="submit" name="doSearch" value="' . $word_go_button . '">';

        echo '</form>';

        echo '</nobr>';
    }

    // Let's show them the bread crums

    jzTableOpen('100', '0', 'jz_header_table');

    jzTROpen('');

    jzTDOpen('100', 'right', 'top', 'jz_header_table_td', '0');

    // Let's show them the up arrow, unless they are viewing the first page

    if ('' != $_GET['ptype']) {
        echo '<br>' . $img_up_arrow . ' ';

        jzHREF($this_page, '', '', '', $word_home);
    }

    // Now if they are viewing the artist let's show them the next level up arrow

    if ('artist' == $_GET['ptype'] or 'songs' == $_GET['ptype']) {
        // Now let's set for 1, 2, or 3 level directory structure

        switch ($directory_level) {
            case '3': # 3 directories deep
                if ('' != $genre) {
                    echo ' ' . $img_up_arrow . ' ';

                    $item_url = $this_page . $url_seperator . 'genre=' . urlencode($genre) . '&ptype=genre';

                    jzHREF($item_url, '', 'jz_header_table_href', '', jzstripslashes(urldecode($genre)));
                }
                break;
        }
    }

    // Now if they are viewing the album let's show them the next level up arrow

    if (('songs' == $_GET['ptype'] and '1' != $directory_level) or mb_stristr($artist, '/')) {
        if ('' != $artist) {
            // Now we need to eheck for slashes in the data and create the links accordingly...

            if (mb_stristr($artist, '/')) {
                // Ok, we found slashes, so we need to create multiple selections here...

                $artistArray = explode('/', $artist);

                $art_link = '';

                for ($ctr = 0, $ctrMax = count($artistArray); $ctr < $ctrMax; $ctr++) {
                    if ('' != $art_link) {
                        $art_link .= '/' . $artistArray[$ctr];
                    } else {
                        $art_link .= $artistArray[$ctr];
                    }

                    switch ($directory_level) {
                        case '3': # 3 directories deep
                            echo ' ' . $img_up_arrow . ' ';
                            $item_url = $this_page . $url_seperator . 'genre=' . urlencode($genre) . '&artist=' . urlencode($art_link) . '&ptype=artist';
                            jzHREF($item_url, '', 'jz_header_table_href', '', $artistArray[$ctr]);
                            break;
                    }
                }
            } else {
                echo ' ' . $img_up_arrow . ' ';

                $item_url = $this_page . $url_seperator . 'genre=' . urlencode($genre) . '&artist=' . urlencode($artist) . '&ptype=artist';

                jzHREF($item_url, '', 'jz_header_table_href', '', jzstripslashes(urldecode($artist)));
            }
        }
    }

    // Now let's close out

    jzTDClose();

    jzTRClose();

    jzTableClose();

    jzTDClose();

    jzTRClose();

    jzTableClose();

    jzTDClose();

    jzTRClose();

    // Now let's see if they are in Jukebox mode, but are NOT an admin they can only stream

    if ('true' == $jukebox and 'admin' != $_SESSION['jz_access_level']) {
        $jukebox = 'false';
    }

    // Let's see if they get the jukebox stuff

    if (('xmms' == $jukebox or 'winamp' == $jukebox) and 'admin' == $_SESSION['jz_access_level']) {
        // First let's include the library

        require_once __DIR__ . '/jukebox.lib.php';

        jzCloseTable();

        echo '<iframe frameborder="0" name="jukebox" src="' . $root_dir . '/jukebox.lib.php?jbar=' . $jukebox . '" style="border: 0px solid black;" height="235" width="100%" scrolling="no"></iframe>';

        // Let's close the above

        jzTableOpen($main_table_width, '0', 'jz_header_table');
    }

    // Let's see if they wanted to turn the drop down boxes off

    if ('true' == $header_drops and 'noaccess' != $_SESSION['jz_access_level']) {
        jzTROpen('jz_header_table_tr');

        jzTDOpen('100', 'right', 'top', 'jz_header_table_outer', '2');

        jzTableOpen('100', '0', '');

        jzTROpen('jz_header_table_tr');

        // Let's make sure they wanted to see the Genre drop down

        if ('true' == $genre_drop) {
            jzTDOpen('20', '', 'top', 'jz_header_table_td', '');

            // Let's see if they are looking at 2 levels or 3

            // Now let's set for 1, 2, or 3 level directory structure

            switch ($directory_level) {
                case '3': # 3 directories deep
                    $linkWord = $word_genre . ': ' . $num_genre;
                    $popType = 'allgenre';
                    break;
                case '2': # 2 directories deep
                    $linkWord = $word_artists . ': ' . $num_genre;
                    $popType = 'allartists';
                    break;
                case '1': # 1 directories deep
                    $linkWord = $word_album . ': ' . $num_genre;
                    $popType = 'allalbums';
                    break;
            }

            // Now let's echo it out

            $item_url = $root_dir . '/mp3info.php?type=' . $popType . '&cur_theme=' . $_SESSION['cur_theme'] . '&return=' . rawurlencode($_SESSION['prev_page']);

            jzHREF($item_url, '_blank', 'jz_header_table_href', 'artistPopup(this); return false;', $linkWord);

            echo '<br> ';

            echo '<form action="' . $this_page . '" method="post">';

            // Now we need to know if the browser does JavaScript or not

            echo '<select name="genre" onChange="submit()" class="jz_select">';

            echo '<option value="" selected>' . $word_pleasechoose . '</option>';

            for ($ctr = 0, $ctrMax = count($genreArray); $ctr < $ctrMax; $ctr++) {
                if ('' != $genreArray[$ctr]) {
                    $title = returnItemShortName($genreArray[$ctr], $quick_list_truncate);

                    // Now let's set for 1, 2, or 3 level directory structure

                    switch ($directory_level) {
                        case '3': # 3 directories deep
                            echo '<option value="ptype=genre&genre=' . urlencode($genreArray[$ctr]) . '">' . $title . '</option>';
                            break;
                        case '2': # 2 directories deep
                            echo '<option value="ptype=artist&genre=/&artist=' . urlencode($genreArray[$ctr]) . '">' . $title . '</option>';
                            break;
                        case '1': # 1 directories deep
                            echo '<option value="ptype=songs&genre=/&artist=/&album=' . urlencode($genreArray[$ctr]) . '">' . $title . '</option>';
                            break;
                    }
                }
            }

            echo '</select>';

            echo '</form>';

            # Now let's close the IF statemet from above
        }

        jzTDClose();

        // Let's see if they are looking at 2 levels or 3 and show them the artists select box

        if (('3' == $directory_level or '2' == $directory_level) and 'true' == $artist_drop) {
            // Now let's show the artist/album selector

            jzTDOpen('20', 'left', 'top', 'jz_header_table_td', '0');

            // Ok, first let's build the url for the popup artist listing

            switch ($directory_level) {
                case '3': # 3 directories deep
                    $popType = 'allartists';
                    $linkWord = $word_artist . ': ' . $num_artist;
                    break;
                case '2': # 2 directories deep
                    $popType = 'allalbums';
                    $linkWord = $word_album . ': ' . $num_artist;
                    break;
            }

            // Now let's display the popup link

            $item_url = $root_dir . '/mp3info.php?type=' . $popType . '&cur_theme=' . $_SESSION['cur_theme'] . '&return=' . rawurlencode($_SESSION['prev_page']);

            jzHREF($item_url, '_blank', 'jz_header_table_href', 'artistPopup(this); return false;', $linkWord);

            echo '<br>';

            // Let's start the select box

            echo '<form action="' . $this_page . '" method="post">';

            echo '<select name="artist" onChange="submit()" class="jz_select">';

            echo '<option value="" selected>' . $word_pleasechoose . '</option>';

            for ($ctr = 0, $ctrMax = count($artistArray); $ctr < $ctrMax; $ctr++) {
                if ('' != $artistArray[$ctr]) {
                    // Let's check and make sure the title isn't too long

                    $artistDisplay = explode('--', $artistArray[$ctr]);

                    $title = returnItemShortName($artistDisplay[0], $quick_list_truncate);

                    // Now let's set for 1, 2, or 3 level directory structure

                    switch ($directory_level) {
                        case '3': # 3 directories deep
                            echo '<option value="ptype=artist&genre=' . urlencode($artistDisplay[1]) . '&artist=' . urlencode($artistDisplay[0]) . '">' . $title . '</option>';
                            break;
                        case '2': # 2 directories deep
                            echo '<option value="ptype=songs&genre=/&artist=' . urlencode($artistDisplay[1]) . '&album=' . urlencode($artistDisplay[0]) . '">' . $title . '</option><br>';
                            break;
                    }
                }
            }

            echo '</select>';

            echo '</form>';

            // Now let's close the IF from above

            jzTDClose();
        }

        // Now let's show them the album drop down IF in 3 dir mode

        if ('3' == $directory_level and 'true' == $album_drop) {
            // Now let's display the album drop

            jzTDOpen('20', 'left', 'top', 'jz_header_table_td', '0');

            // Now let's show the link to the popup page

            $item_url = $root_dir . '/mp3info.php?type=allalbums&cur_theme=' . $_SESSION['cur_theme'] . '&return=' . rawurlencode($_SESSION['prev_page']);

            jzHREF($item_url, '_blank', 'jz_header_table_href', 'artistPopup(this); return false;', $word_album . ': ' . $num_album);

            echo '<br>';

            echo '<form action="' . $this_page . '" method="post">';

            echo '<select name="album" onChange="submit()" class="jz_select">';

            echo '<option value="" selected>' . $word_pleasechoose . '</option>';

            for ($ctr = 0, $ctrMax = count($albumArray); $ctr < $ctrMax; $ctr++) {
                if ('' != $albumArray[$ctr]) {
                    // Let's check and make sure the title isn't too long

                    $albumDisplay = explode('--', $albumArray[$ctr]);

                    $title = returnItemShortName($albumDisplay[0], $quick_list_truncate);

                    echo '<option value="ptype=songs&genre=' . urlencode($albumDisplay[1]) . '&artist=' . urlencode($albumDisplay[2]) . '&album=' . urlencode($albumDisplay[0]) . '">' . $title . '</option>';
                }
            }

            echo '</select>';

            echo '</form>';
        }

        jzTDClose();

        // Now let's show the song drop IF they have it on

        if ('true' == $song_drop) {
            jzTDOpen('20', 'left', 'top', 'jz_header_table_td', '0');

            echo $word_tracks . ': ' . $num_song;

            echo '<br>';

            echo '<form action="' . $this_page . '" method="post">';

            echo '<select name="album" onChange="submit()" class="jz_select">';

            echo '<option value="" selected>' . $word_pleasechoose . '</option>';

            for ($ctr = 0, $ctrMax = count($songArray); $ctr < $ctrMax; $ctr++) {
                if ('' != $songArray[$ctr]) {
                    // Let's check and make sure the title isn't too long

                    $songDisplay = explode('----', str_replace($web_root . $root_dir . $media_dir, '', $songArray[$ctr]));

                    $title = returnItemShortName($songDisplay[count($songDisplay) - 1], $quick_list_truncate);

                    if (preg_match("/\.($audio_types)$/i", $title) || preg_match("/\.($video_types)$/i", $title)) {
                        if ('3' == $directory_level) {
                            $info = urlencode($songDisplay[count($songDisplay) - 4]) . '/' . urlencode($songDisplay[count($songDisplay) - 3]) . '/' . urlencode($songDisplay[count($songDisplay) - 2]) . '/' . urlencode($songDisplay[count($songDisplay) - 1]);
                        }

                        if ('2' == $directory_level) {
                            $info = urlencode($songDisplay[count($songDisplay) - 3]) . '/' . urlencode($songDisplay[count($songDisplay) - 2]) . '/' . urlencode($songDisplay[count($songDisplay) - 1]);
                        }

                        if ('2' == $directory_level) {
                            $info = urlencode($songDisplay[count($songDisplay) - 2]) . '/' . urlencode($songDisplay[count($songDisplay) - 1]);
                        }

                        echo '<option value="ptype=quickplay&style=normal&qptype=song&info=' . $info . '">' . $title . '</option>';
                    }
                }
            }

            echo '</select>';

            echo '</form>';

            jzTDClose();
        }

        // Now let's display the random playlist generator

        if ('true' == $quick_drop and 'viewonly' != $_SESSION['jz_access_level'] and 'lofi' != $_SESSION['jz_access_level']) {
            jzTDOpen('20', 'left', 'top', 'jz_header_table_td', '0');

            echo '<nobr>';

            echo $word_random_select;

            echo '<br>';

            echo '<form action="' . $this_page . '" method="post">';

            echo '<select name="random_play_number" class="jz_select_sm1">';

            $random_play = explode('|', $random_play_amounts);

            $ctr = 0;

            while (count($random_play) > $ctr) {
                echo '<option value="' . $random_play[$ctr] . '"';

                if ($random_play[$ctr] == $default_random_play_amount) {
                    echo ' selected';
                }

                echo '>' . $random_play[$ctr] . '</option>';

                $ctr += 1;
            }

            echo '</select> ';

            echo '<select name="random_play_type" class="jz_select_sm2">';

            // Now let' see what we need to remove from the list

            if ('2' == $directory_level) {
                // Ok, let's remove "Genre" from the list

                $random_play_types = str_replace('Genres', '', $random_play_types);
            }

            if ('1' == $directory_level) {
                // Ok, let's remove "Genre" from the list

                $random_play_types = str_replace('Genres', '', $random_play_types);

                $random_play_types = str_replace('Artists', '', $random_play_types);
            }

            $random_play = explode('|', $random_play_types);

            $ctr = 0;

            while (count($random_play) > $ctr) {
                // Let's make sure this isn't blank

                if ('' != $random_play[$ctr]) {
                    echo '<option value="' . $random_play[$ctr] . '"';

                    if ($random_play[$ctr] == $default_random_play_type) {
                        echo ' selected';
                    }

                    echo '>' . $random_play[$ctr] . '</option>';
                }

                $ctr++;
            }

            echo '</select>';

            echo ' <input class="jz_submit" type="submit" name="submit_random" value="' . $word_go_button . '" class="submit">';

            echo '</form>';

            echo '</nobr>';

            jzTDClose();
        }

        // Now let's display the resampler

        if ('true' == $allow_resample and 'viewonly' != $_SESSION['jz_access_level'] and 'lofi' != $_SESSION['jz_access_level']) {
            jzTDOpen('5', 'left', 'top', 'jz_header_table_td', '0');

            echo '<nobr>';

            echo word_resample;

            echo '<br>';

            echo '<form action="' . $_SESSION['prev_page'] . '" method="post">';

            echo '<select name="sample_rate" class="jz_select" onChange="submit()">';

            echo '<option value=""> - </option>';

            // Now let's create all the options

            $optArray = explode('|', $resampleRates);

            for ($c = 0, $cMax = count($optArray); $c < $cMax; $c++) {
                echo '<option ';

                if ($_SESSION['resample'] == $optArray[$c]) {
                    echo 'selected ';
                }

                echo 'value="' . $optArray[$c] . '">' . $optArray[$c] . '</option>';
            }

            echo '</select> kHz';

            echo '</form>';

            echo '</nobr>';

            jzTDClose();
        }

        jzTRClose();

        jzTableClose();

        jzTDClose();

        jzTRClose();
    }

    // This closes our big table above

    jzTableClose();

    if ('true' == $endBreak) {
        echo '<br>';
    }
}

function displayFooter()
{
    global $main_table_width, $jinzora_url, $this_pgm, $version, $allow_lang_choice, $word_language, $this_page, $web_root, $root_dir, $javascript, $word_go_button, $allow_theme_change, $cms_mode, $jinzora_skin, $show_loggedin_level, $word_secure_warning, $word_theme, $lang_file, $shoutcast, $sc_refresh, $sc_host, $sc_port, $sc_password, $embedded_footer, $url_seperator, $jukebox, $show_jinzora_footer, $hide_pgm_name, $media_dir, $img_sm_logo, $word_logged_in_pre, $word_logged_in_post;

    // First let's make sure they didn't turn the footer off

    if ($show_jinzora_footer) {
        jzTableOpen($main_table_width, '0', 'jz_footer_table');

        jzTROpen('jz_footer_table_tr');

        jzTDOpen('100', 'center', 'top', 'jz_footer_table_td', '0');

        echo '<br>';

        if ('true' == $allow_lang_choice) {
            echo $word_language;

            // Now let's setup the forms

            echo ' <form action="' . $this_page . '" method="post">';

            echo '<select name="new_language" onChange="submit()" class="jz_select">';

            // Let's get all the possible languages and display them

            $lang_dir = $web_root . $root_dir . '/lang';

            $d = dir($lang_dir);

            while ($entry = $d->read()) {
                // Let's make sure this isn't the local directory we're looking at

                if ('.' == $entry || '..' == $entry) {
                    continue;
                }

                if (str_replace('.php', '', $entry) == $lang_file) {
                    echo '<option selected value="' . str_replace('.php', '', $entry) . '">' . str_replace('.php', '', $entry) . '</option>';
                } else {
                    echo '<option value="' . str_replace('.php', '', $entry) . '">' . str_replace('.php', '', $entry) . '</option>';
                }
            }

            echo '</select>';

            echo '</form>';
        }

        // let's see if they are allowed to change the theme on the fly

        if ('true' == $allow_theme_change) {
            echo '<form action="' . $this_page . '" method="post">';

            echo '<input type="hidden" name="return" value="' . $_SERVER['REQUEST_URI'] . '">';

            echo ' ' . $word_theme . ' <select name="new_theme" onChange="submit()" class="jz_select">';

            // Ok, now let's get the list of themes from the file system

            $theme_dir = $web_root . $root_dir . '/style';

            $d = dir($theme_dir);

            while ($entry = $d->read()) {
                // Let's make sure this isn't the local directory we're looking at

                if ('.' == $entry || '..' == $entry || 'favicon.ico' == $entry || 'images' == $entry) {
                    continue;
                }

                // If this is a CMS site they don't get to see the theme changer...  sorry, no theme for you!

                if ('cms-theme' == $entry and 'false' == $cms_mode) {
                    continue;
                }

                $themeArray[$c] = $entry;

                $c++;
            }

            sort($themeArray);

            for ($ctr = 0, $ctrMax = count($themeArray); $ctr < $ctrMax; $ctr++) {
                if ('' != $themeArray[$ctr]) {
                    if ($themeArray[$ctr] == $jinzora_skin) {
                        echo '<option selected value="' . $themeArray[$ctr] . '">' . $themeArray[$ctr] . '</option>';
                    } else {
                        echo '<option value="' . $themeArray[$ctr] . '">' . $themeArray[$ctr] . '</option>';
                    }
                }
            }

            echo '</select>';

            echo '</form>';
        }

        if ('true' == $show_loggedin_level) {
            echo "<br>$word_logged_in_pre " . $_SESSION['jz_access_level'] . " $word_logged_in_post";
        }

        // let's echo one line break to make it look pretty

        if ('true' == $allow_lang_choice or 'true' == $allow_theme_change) {
            echo '<br>&nbsp;';
        }

        // Let's show them some shoutcast info

        if ('true' == $shoutcast) {
            // Let's put this in a little frame...

            require __DIR__ . '/sc-stats.php';
        }

        // Let's see if there is a footer TXT file and if so display it

        echo returnFooterText();

        // Now let's see if we should inlucde PHP in the footer

        $filename = $web_root . $root_dir . $media_dir . '/footer.php';

        if (is_file($filename) and filesize($filename)) {
            // Now let's just include that

            require_once $filename;
        }

        // Should we display the Jinzora logo in the footer?

        if (!$hide_pgm_name and 'noaccess' != $_SESSION['jz_access_level'] and 'viewonly' != $_SESSION['jz_access_level']) {
            echo '<br>';

            jzHREF($jinzora_url, '', 'jz_col_table_href', '', $img_sm_logo);

            echo '<br><br>';
        }

        jzTDClose();

        jzTRClose();

        jzTableClose();

        // Now let's see if they are embedding and if they wanted a footer

        if ('' != $embedded_footer) {
            // Ok, they want an embedded footer, so let's get to it!

            if (is_file($embedded_footer)) {
                // Ok, it's there so freakin' include it!

                require_once $embedded_footer;
            }
        } else {
            // Ok let's close out the HTML for them

            echo '</html>';
        }
    }
}

?>

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
* License: GNU GPL <http://www.gnu.org/copyleft/gpl.html>
*
* Contributors:
* Please see http://www.jinzora.org/modules.php?op=modload&name=jz_whois&file=index
*
* Code Purpose: This page contains all the Genre/Artist display related functions
* Created: 9.24.03 by Ross Carlson
*
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

// This function displays all the Genres or Artists
function drawPage($node)
{
    global $cols_in_genre, $cellspacing, $this_page, $img_play, $artist_truncate, $main_table_width, $img_random_play, $word_genres, $directory_level, $word_artist, $word_album, $web_root, $root_dir, $img_more, $media_dir, $show_sub_numbers, $show_all_checkboxes, $img_more_dis, $img_play_dis, $img_random_play_dis, $url_seperator, $days_for_new, $word_new, $img_rate, $enable_ratings, $enable_discussion, $img_discuss, $show_sub_numbers, $disable_random, $info_level, $enable_playlist, $track_play_only, $word_please_wait, $css, $jinzora_skin, $bg_c, $text_c, $img_discuss_dis, $hierarchy;

    // Let's see if the theme is set or not, and if not set it to the default

    if (isset($_SESSION['cur_theme'])) {
        $_SESSION['cur_theme'] = $jinzora_skin;
    }

    // Now let's display the header

    // Let's see if they are viewing the Genre or not

    if ('' != $node->getName()) {
        displayHeader($node->getName()); // this is probably wrong.
    } else {
        displayHeader($word_genres);
    }

    // Now let's get all the data for this level

    $retArray = $node->getSubNodes();

    // Let's see if the user has logged in and if they have any personal exclude files or not

    //	if (isset($_COOKIE['jz_user_name'])){

    //		// Ok, now let's see if they have any personal exclude files or not

    //		$personalExcludeArray = returnExcludeArray("personal");

    //	}

    //	// Now let's see if we have a global exclude file and remove the stuff they don't want to see

    //	$globalExcludeArray = returnExcludeArray("global");

    //	// Now let's merge the two arrays

    //	$excludeArray = array_merge($personalExcludeArray, $globalExcludeArray);

    //	// Now let's remove our exclusions

    //	$retArray = array_values(array_diff($retArray,$excludeArray));

    // Now let's display the site description

    if ('' == $node->getName()) {
        $site_desc = returnSiteDescription();

        if ($site_desc) {
            echo $site_desc;
        }
    }

    // Now let's start our table to put the stuff in

    jzTableOpen($main_table_width, $cellspacing, 'jz_col_table_main');

    jzTROpen('jz_col_table_tr');

    // Now let's figure out how wide our colum should be

    $col_width = returnColWidth(count($retArray));

    // Now let's figure out how many artists per column

    // adding the .49 make sure it always rounds up

    $folder_per_column = round(count($retArray) / $cols_in_genre + .49, 0);

    $first_loop = '';

    // Let's initialize some variables

    $ctr = 1;

    // Now let's loop through that array, displaying the items

    for ($lctr = 0, $lctrMax = count($retArray); $lctr < $lctrMax; $lctr++) {
        // Let's make sure that we found items to display

        if ($retArray[$lctr]->isLeaf()) {
            continue;
        }  

        // Now let's see if this is a NEW directory or not

        //$new_from = checkForNew(jzstripslashes($genre. "/". $retArray[$lctr]));

        // NEW BACKEND: don't know how to handle this yet.

        // Let's count so we know where we are in making the columns

        // Then we'll add the links to the sub pages

        if (1 == $ctr) {
            if ('' == $first_loop) {
                $first_loop = 'no';

                jzTDOpen($col_width, 'left', 'top', '', '0');
            } else {
                jzTDClose();

                jzTDOpen($col_width, 'left', 'top', '', '0');
            }
        }

        // Let's see if we need to truncate the name

        $displayItem = returnItemShortName($retArray[$lctr]->getName(), $artist_truncate);

        // Now let's get the number of sub items

        $fldr_ctr = $retArray[$lctr]->getSubNodeCount();

        // Let's setup our form for below

        echo '<form action="' . $_SESSION['prev_page'] . '" name="trackForm" method="POST" onSubmit="return AreYouSure();">';

        // Let's setup or links

        $link_url = urlencode($retArray[$lctr]->getPath('string'));

        // Let's open our table

        jzTableOpen('100', '0', 'jz_col_table');

        jzTROpen('jz_col_table_tr');

        // Let's see if they are only a viewing user or not

        if ('viewonly' != $_SESSION['jz_access_level'] and 'lofi' != $_SESSION['jz_access_level']) {
            // Now let's show them the info button

            if ('all' == $info_level or ('admin' == $info_level and 'admin' == $_SESSION['jz_access_level'])) {
                jzTDOpen('1', 'left', 'top', '', '0');

                $item_url = $root_dir . '/mp3info.php?type=' . $hierarchy[$retArray[$lctr]->getLevel()] . '&info=' . urlencode($retArray[$lctr]->getPath('String')) . '&cur_theme=' . $_SESSION['cur_theme'];

                jzHREF($item_url, '_blank', 'jz_col_table_href', 'newWindow(this); return false;', $img_more);

                jzTDClose();
            }

            // Now let's see if they only wanted to see track plays

            if ('true' != $track_play_only) {
                jzTDOpen('1', 'left', 'top', '', '0');

                $item_url = $root_dir . '/playlists.php?d=1&style=normal&info=' . $link_url . '&return=' . base64_encode($_SESSION['prev_page']);

                jzHREF($item_url, '', 'jz_col_table_href', '', $img_play);

                jzTDClose();
            }

            // Now let's see if they wanted to see random icons

            if ('false' == $disable_random) {
                jzTDOpen('1', 'left', 'top', '', '0');

                $item_url = $root_dir . '/playlists.php?d=1&style=random&info=' . $link_url . '&return=' . base64_encode($_SESSION['prev_page']);

                jzHREF($item_url, '', 'jz_col_table_href', '', $img_random_play);

                jzTDClose();
            }

            // Now let's show them the rating link, if they wanted it

            if ('true' == $enable_ratings) {
                jzTDOpen('1', 'left', 'top', '', '0');

                $item_url = $root_dir . '/mp3info.php?type=rate&info=' . rawurlencode($retArray[$lctr]->getPath('String')) . '&cur_theme=' . $_SESSION['cur_theme'];

                jzHREF($item_url, '_blank', '', 'ratingWindow(this); return false;', $img_rate);

                jzTDClose();
            }

            if ('true' == $enable_discussion) {
                jzTDOpen('1', 'left', 'top', '', '0');

                $item_url = $root_dir . '/mp3info.php?type=discuss&info=' . rawurlencode($retArray[$lctr]->getPath('String')) . '&cur_theme=' . $_SESSION['cur_theme'];

                // Now let's figure out which icon to use

                if (true != checkDiscuss($genre . '/' . $retArray[$lctr])) {
                    $img = $img_discuss_dis;
                } else {
                    $img = $img_discuss;
                }

                jzHREF($item_url, '_blank', '', 'discussionWindow(this); return false;', $img);

                jzTDClose();
            }
        } else {
            // Ok, they are view only, so let's show them the disabled icons

            jzTDOpen('1', 'left', 'top', '', '0');

            echo $img_more_dis;

            jzTDClose();

            jzTDOpen('1', 'left', 'top', '', '0');

            echo $img_play_dis;

            jzTDClose();

            if ('false' == $disable_random) {
                jzTDOpen('1', 'left', 'top', '', '0');

                echo $img_random_play_dis;

                jzTDClose();
            }
        }

        // Let's give them the check box for the playlist addition IF they wanted it

        if ('true' == $show_all_checkboxes and 'false' != $enable_playlist) {
            jzTDOpen('1', 'left', 'top', '', '0');

            echo '<input class="jz_checkbox" name="track-' . $lctr . '" type=checkbox value="' . $root_dir . $media_dir . '/' . rawurlencode($genre) . '/' . urlencode($retArray[$lctr]) . '/">';

            jzTDClose();
        } // NEW BACKEND: This part will need a bit more work.

        jzTDOpen('1', 'left', 'top', '', '0');

        echo '&nbsp;';

        jzTDClose();

        // Let's see if the data is new or not

        $new_data = '';

        if ('' != $new_from) {
            $new_data = 'onmouseover="return overlib('
                            . "'"
                            . $new_from
                            . "'"
                            . ', FGCOLOR, '
                            . "'"
                            . $bg_c
                            . "'"
                            . ', TEXTCOLOR, '
                            . "'"
                            . $text_c
                            . "'"
                            . ', FGCOLOR, '
                            . "'"
                            . $bg_c
                            . "'"
                            . ', TEXTCOLOR, '
                            . "'"
                            . $text_c
                            . "', WIDTH, '"
                            . (mb_strlen($new_from) * 6.2)
                            . "'"
                            . ');" onmouseout="return nd();"';
        }

        jzTDOpen('90', 'left', 'top', '', '0');

        $item_url = $this_page . $url_seperator . 'path=' . rawurlencode($retArray[$lctr]->getPath('String'));

        // Now let's display the link

        jzHREF($item_url, '', 'jz_col_table_href', '', $displayItem . ' (' . $fldr_ctr . ')');

        // Let's see if this is new or not

        if ('' != $new_from) {
            echo ' <img src="' . $root_dir . '/style/' . $jinzora_skin . '/new.gif" border=0 ' . $new_data . '>';
        }

        // Now let's see if they wanted ratings

        if ('true' == $enable_ratings) {
            // Ok, now let's see if there is a rating file
                echo displayRating(jzstripslashes($retArray[$lctr])); // NEW BACKEND: this needs work.
        }

        // Now let's return the description

        $descData = $retArray[$lctr]->getDescription();

        if ($descData) {
            echo '<br>' . stripslashes($descData) . '<br><br>';
        }

        // Now let's close out

        jzTDClose();

        jzTRClose();

        jzTableClose();

        // Now let's increment for out column counting

        if ($ctr == $folder_per_column) {
            $ctr = 1;
        } else {
            $ctr++;
        }
    } // go to next loop

    // Now let's set a hidden form field so we'll know how many boxes there were

    echo '<input type="hidden" name="numboxes" value="' . $lctr . '">';

    // Now let's close our table

    jzTableClose();

    echo "<br>\n";

    // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    //
    // Need to update this to new abstraction layer
    //
    // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

    // Now let's look and see if there are any songs in this directory that we need to display
    // This will also test for the chart boxes and display them
    // NEW BACKEND: This needs to be reworked. (Check array for isLeaf == ture
    //$songsFound = lookForMedia(jzstripslashes(urldecode($web_root. $root_dir. $media_dir. "/". $genre)));

    // Now let's show the playlist bar
    //if ($enable_playlist <> "false"){ displayPlaylistBar($songsFound); }
}

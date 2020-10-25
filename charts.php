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
* Code Purpose: This page displays the charts of all rated items
* Created: 4.28.04 by Ross Carlson
*
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

// Ok, is this thing in standalone mode or what?
if (isset($_GET['standalone'])) {
    if ('true' == $_GET['standalone']) {
        //Ok, now let's include what we need...

        require_once __DIR__ . '/settings.php';

        require_once __DIR__ . '/system.php';

        require_once __DIR__ . '/general.php';

        require_once __DIR__ . '/display.php';

        require_once __DIR__ . '/id3classes/getid3.php';

        // Now let's display the stylesheet

        echo $css;
    }
}

// Let's include the display libraries
require_once __DIR__ . '/lib/display.lib.php';
require_once __DIR__ . '/files.lib.php';

// Now let's figure out if we are looking at a specific level or not
$level = $_GET['genre'] ?? '';

// Let's start our table
jzTableOpen('100', '5', 'jz_track_table');

// Now let's show the features
// First we'll see if there is a customize file here
if (is_file('chart_layout.php')) {
    require_once __DIR__ . '/chart_layout.php';
} else {
    jzTROpen();

    jzTDOpen('50', 'center', 'top', '', '');

    showFeaturedArtist('8', $level); // We pass this how many albums we want to see

    showMostPlayed($level);

    //showHighestRated($level);

    //showMostDownloaded($level);

    //showMostDiscussed($level);

    jzTDClose();

    jzTDOpen('50', 'center', 'top', '', '');

    showFeaturedAlbum('5', $level); // We pass this how many tracks we want to see

    showLastPlayed($level);

    //showLastRated($level);

    //showLastDownloaded($level);

    //showLastDiscussed($level);

    jzTDClose();

    jzTRClose();
}

// Now let's close out
jzTableClose();

// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
//
// These are the functions needed by above
//
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
/**
 * Displays the currently featured artist
 *
 * @author  Ross Carlson
 * @version 05/05/04
 * @since   05/05/04
 * @param mixed $numTracks
 * @param mixed $level
 */
function showFeaturedAlbum($numTracks = '', $level = '')
{
    global $row_colors, $word_album, $img_play, $img_random_play, $this_page, $url_seperator, $root_dir, $img_download, $media_dir, $allow_download, $img_play_dis, $img_download_dis, $audio_types, $video_types, $web_root;

    // Let's get the data from the abstraction layer

    $dataArray = returnFeaturedAlbum($level);

    // let's make sure we had data

    if (0 == count($dataArray)) {
        return;
    }

    // Now let's see if the user can see the tracks or not

    $play = true;

    if ('lofi' == $_SESSION['jz_access_level'] or 'viewonly' == $_SESSION['jz_access_level']) {
        $play = false;
    }

    // Now let's display the HTML

    jzTableOpen('100', '10', 'jz_track_table');

    jzTROpen($row_colors[1]);

    jzTDOpen('100', 'center', 'top', 'jz_track_table_songs_td', '0');

    echo '<strong>' . word_featured_album;

    if ('' != $level) {
        echo ' (' . $level . ')';
    }

    echo ' - ';

    // Now let's link to the data

    $item_link = $this_page . $url_seperator . 'ptype=artist&genre=' . urlencode($dataArray[0]['genre']) . '&artist=' . urlencode($dataArray[0]['artist']);

    jzHREF($item_link, '', '', '', $dataArray[0]['artist']);

    echo ' | ';

    $item_link = $this_page . $url_seperator . 'ptype=songs&genre=' . urlencode($dataArray[0]['genre']) . '&artist=' . urlencode($dataArray[0]['artist']) . '&album=' . urlencode($dataArray[0]['album']);

    jzHREF($item_link, '', '', '', $dataArray[0]['album']);

    echo '</strong>';

    jzTDClose();

    jzTRClose();

    jzTableClose();

    jzTableOpen('100', '10', 'jz_track_table');

    jzTROpen($row_colors[0]);

    jzTDOpen('100', 'center', 'top', 'jz_track_table_songs_td', '0');

    // Now let's display the data

    jzTableOpen('100', '0', 'jz_track_table');

    jzTROpen();

    jzTDOpen('40', 'left', 'top', '', '0');

    $item_link = $this_page . $url_seperator . 'ptype=songs&genre=' . urlencode($dataArray[0]['genre']) . '&artist=' . urlencode($dataArray[0]['artist']) . '&album=' . urlencode($dataArray[0]['album']);

    $img = str_replace($web_root, '', $dataArray[0]['image']);

    jzHREF($item_link, '', '', '', '<img src="' . $img . '" border="0" width="100" align="left">');

    echo returnItemShortName($dataArray[0]['albumDesc'], 250);

    jzTDClose();

    jzTDOpen('1', 'left', 'top', '', '0');

    echo '&nbsp;';

    jzTDClose();

    jzTDOpen('59', 'left', 'top', '', '0');

    // Now let's loop through and display the tracks

    $i = 1;

    jzTableOpen('100', '5', '');

    jzTROpen($row_colors[0]);

    jzTDOpen('100', '', 'top', 'jz_track_table', '3');

    echo '<strong>' . word_sample_tracks . '</strong>';

    jzTDClose();

    jzTRClose();

    $c = 1;

    foreach ($dataArray as $track) {
        // Let's make sure we can see this row

        if (preg_match("/\.($audio_types)$/i", $track['filename']) and !mb_stristr($track['filename'], '.clip.') || preg_match("/\.($video_types)$/i", $track['filename']) || preg_match("/\.(fake.txt)$/i", $track['filename']) || preg_match("/\.(fake.lnk)$/i", $track['filename']) or (mb_stristr(
            $audio_types,
            'all'
        ) and !mb_stristr(
                                                                                                                                                                                                                                                                                            $track['filename'],
                                                                                                                                                                                                                                                                                            '.txt'
                                                                                                                                                                                                                                                                                        ) and !preg_match("/\.($ext_graphic)$/i", $track['filename'])) and '' != $track['name']) {
            // Ok, now let's display the data

            jzTROpen($row_colors[$i]);

            jzTDOpen('5', '', 'top', 'jz_track_table', '0');

            if ('false' != $allow_download) {
                $item_link = $root_dir . '/download.php?info=' . urlencode(str_replace($root_dir . $media_dir, '', $track['path']));

                jzHREF($item_link, '', '', '', $img_download);
            } else {
                echo $img_download_dis;
            }

            jzTDClose();

            jzTDOpen('5', '', 'top', 'jz_track_table', '0');

            if ($play) {
                $item_link = $root_dir . '/playlists.php?d=1&qptype=song&style=normal&info=' . urlencode(str_replace($root_dir . $media_dir, '', $track['path']));

                jzHREF($item_link, '', '', '', $img_play);
            } else {
                echo $img_play_dis;
            }

            jzTDClose();

            jzTDOpen('60', '', 'top', 'jz_track_table', '0');

            if ($play) {
                $item_link = $root_dir . '/playlists.php?d=1&qptype=song&style=normal&info=' . urlencode(str_replace($root_dir . $media_dir, '', $track['path']));

                jzHREF($item_link, '', '', '', $track['name']);
            } else {
                echo $track['name'];
            }

            jzTDClose();

            jzTDOpen('30', 'right', 'top', 'jz_track_table', '0');

            echo '<nobr>&nbsp;' . $track['length'] . '&nbsp;</nobr>';

            jzTDClose();

            jzTRClose();

            // Let's increment our counter for the row class

            $i = ++$i % 2;

            // Now let's see if we should exit

            $c++;

            if ('' != $numTracks) {
                if ($c > $numTracks) {
                    break;
                }
            }
        }
    }

    // Now let's close all the way out

    jzTableClose();

    jzTDClose();

    jzTDClose();

    jzTRClose();

    jzTableClose();

    jzTDClose();

    jzTRClose();

    jzTableClose();

    echo '<br>';
}

/**
 * Displays the currently featured artist
 *
 * @author  Ross Carlson
 * @version 05/05/04
 * @since   05/05/04
 * @param mixed $numAlbums
 * @param mixed $level
 */
function showFeaturedArtist($numAlbums = '', $level = '')
{
    global $row_colors, $word_album, $img_play, $img_random_play, $this_page, $url_seperator, $root_dir, $img_play_dis, $img_random_play_dis, $img_more, $web_root;

    // Let's get the data from the abstraction layer

    $dataArray = returnFeaturedArtist($level);

    // let's make sure we had data

    if (0 == count($dataArray)) {
        return;
    }

    // Now let's see if the user can see the tracks or not

    $play = true;

    if ('lofi' == $_SESSION['jz_access_level'] or 'viewonly' == $_SESSION['jz_access_level']) {
        $play = false;
    }

    // Now let's display the HTML

    jzTableOpen('100', '10', 'jz_track_table');

    jzTROpen($row_colors[1]);

    jzTDOpen('100', 'center', 'top', 'jz_track_table_songs_td', '0');

    echo '<strong>' . word_featured_artist;

    if ('' != $level) {
        echo ' (' . $level . ')';
    }

    echo ' - ';

    // Now let's link to the artist

    $item_link = $this_page . $url_seperator . 'ptype=artist&genre=' . urlencode($dataArray[0]['genre']) . '&artist=' . urlencode($dataArray[0]['artist']);

    jzHREF($item_link, '', '', '', $dataArray[0]['artist']);

    echo '</strong>';

    if ('NULL' != $dataArray[0]['rating']) {
        echo ' ' . displayRating(null, '', $dataArray[0]['rating']);
    }

    jzTDClose();

    jzTRClose();

    jzTableClose();

    jzTableOpen('100', '10', 'jz_track_table');

    jzTROpen($row_colors[0]);

    jzTDOpen('100', 'center', 'top', 'jz_track_table_songs_td', '0');

    // Now let's display the data

    jzTableOpen('100', '0', 'jz_track_table');

    jzTROpen();

    jzTDOpen('50', 'left', 'top', '', '0');

    $item_link = $this_page . $url_seperator . 'ptype=artist&genre=' . urlencode($dataArray[0]['genre']) . '&artist=' . urlencode($dataArray[0]['artist']);

    $img = str_replace($web_root, '', $dataArray[0]['artistImage']);

    jzHREF($item_link, '', '', '', '<img src="' . $img . '" border="0" width="100" align="left">');

    echo returnItemShortName($dataArray[0]['artistDesc'], 300);

    jzTDClose();

    jzTDOpen('1', 'left', 'top', '', '0');

    echo '&nbsp;';

    jzTDClose();

    jzTDOpen('49', 'left', 'top', '', '0');

    echo '<strong>' . $word_album . '</strong><br>';

    // Now let's loop through all the albums

    $i = 0;

    foreach ($dataArray as $item) {
        jzTableOpen('100', '0', '');

        jzTROpen();

        jzTDOpen('5', '', 'top', 'jz_track_table', '0');

        echo '<nobr>';

        // If they are an admin let's show them the info link

        if ('admin' == $_SESSION['jz_access_level']) {
            $item_url = $root_dir . '/mp3info.php?type=album&info=' . urlencode($item['genre']) . '/' . urlencode($item['artist']) . '/' . urlencode($item['albumName']) . '&cur_theme=' . $_SESSION['cur_theme'];

            jzHREF($item_url, '_blank', 'jz_col_table_href', 'newWindow(this); return false;', $img_more);
        }

        if ($play) {
            $item_link = $root_dir . '/playlists.php?d=1&style=normal&info=' . urlencode($item['genre']) . '/' . urlencode($item['artist']) . '/' . urlencode($item['albumName']);

            jzHREF($item_link, '', '', '', $img_play);

            $item_link = $root_dir . '/playlists.php?d=1&style=random&info=' . urlencode($item['genre']) . '/' . urlencode($item['artist']) . '/' . urlencode($item['albumName']);

            jzHREF($item_link, '', '', '', $img_random_play);
        } else {
            echo $img_play_dis . $img_random_play_dis;
        }

        echo ' </nobr>';

        jzTDClose();

        jzTDOpen('95', '', 'top', 'jz_track_table', '0');

        // Now let's show them the link to the ablum

        $item_link = $this_page . $url_seperator . 'ptype=songs&genre=' . urlencode($item['genre']) . '&artist=' . urlencode($item['artist']) . '&album=' . urlencode($item['albumName']);

        jzHREF($item_link, '', '', '', $item['albumName']);

        // Now let's see if there is a year

        if ('' != $item['year']) {
            echo ' (' . $item['year'] . ')';
        }

        // Now let's see if there is a rating

        if ('NULL' != $item['rating']) {
            echo '<br>' . displayRating(null, '', $item['rating']);
        }

        echo '<br>';

        // Let's close that up

        jzTDClose();

        jzTRClose();

        jzTableClose();

        $i++;

        if ('' != $numAlbums) {
            if ($i > $numAlbums) {
                break;
            }
        }
    }

    jzTDClose();

    jzTRClose();

    jzTableClose();

    // Now let's close all the way out

    jzTDClose();

    jzTRClose();

    jzTableClose();

    echo '<br>';
}

/**
 * Displays the table with the data that was found
 *
 * @param mixed $tracks_info
 * @param mixed $tracks
 * @param mixed $title
 * @param mixed $type
 * @param mixed $lastplayed
 * @version 04/28/04
 * @since   04/28/04
 * @author  Ross Carlson
 */
function displayChartData($tracks_info, $tracks, $title, $type, $lastplayed = 'false')
{
    global $most_played_nb, $img_play, $img_more, $word_plays, $row_colors, $web_root, $root_dir, $media_dir, $cellspacing, $img_download, $img_download_dis, $img_play_dis, $allow_download, $word_downloads, $directory_level, $this_page, $url_seperator;

    $i = 0;

    $c = 1;

    $loop_ctr = $most_played_nb;

    jzTableOpen('100', '10', 'jz_track_table');

    jzTROpen($row_colors[1]);

    jzTDOpen('1', 'center', 'top', 'jz_track_table_songs_td', '0');

    echo '<strong>' . $title . '</strong>';

    jzTDClose();

    jzTRClose();

    jzTableClose();

    // Now let's see if the user can see the tracks or not

    $play = true;

    if ('lofi' == $_SESSION['jz_access_level'] or 'viewonly' == $_SESSION['jz_access_level']) {
        $play = false;
    }

    // Now let's start our main table

    jzTableOpen('100', $cellspacing, 'jz_track_table');

    // Now let's loop through each item

    foreach ($tracks as $track => $loop_ctr) {
        // Let's make sure the title isn't blank

        // We'll only show tracks here

        if (isset($tracks_info[$track]['name'])) {
            // Let's start our table

            jzTROpen($row_colors[$i]);

            jzTDOpen('1', 'left', 'top', 'jz_track_table_songs_td', '');

            echo '<strong>' . $c . '</strong>';

            jzTDClose();

            if ('false' != $allow_download) {
                jzTDOpen('1', 'left', 'top', 'jz_track_table_songs_td', '');

                echo '<a href="' . $root_dir . '/download.php?info=' . urlencode(str_replace($root_dir . $media_dir . '/', '', $tracks_info[$track]['path'])) . '">' . $img_download . '</a>';

                jzTDClose();
            }

            jzTDOpen('1', 'left', 'top', 'jz_track_table_songs_td', '');

            if ($play) {
                echo '<a href="' . $root_dir . '/playlists.php?d=1&qptype=song&style=normal&info=' . urlencode(str_replace($root_dir . $media_dir . '/', '', $tracks_info[$track]['path'])) . '">' . $img_play . '</a>';
            } else {
                echo $img_play_dis;
            }

            jzTDClose();

            jzTDOpen('58', 'left', 'top', 'jz_track_table_songs_td', '');

            if ($play) {
                echo '<a href="' . $root_dir . '/playlists.php?d=1&qptype=song&style=normal&info=' . urlencode(str_replace($root_dir . $media_dir . '/', '', $tracks_info[$track]['path'])) . '">' . $tracks_info[$track]['name'] . '</a>';
            } else {
                echo $tracks_info[$track]['name'];
            }

            // Now let's link

            if ('3' == $directory_level) {
                echo '<br>';

                $item_link = $this_page . $url_seperator . 'ptype=artist&genre=' . urlencode($tracks_info[$track]['genre']) . '&artist=' . urlencode($tracks_info[$track]['artist']);

                jzHREF($item_link, '', '', '', $tracks_info[$track]['artist']);

                echo ' - ';

                $item_link = $this_page . $url_seperator . 'ptype=song&genre=' . urlencode($tracks_info[$track]['genre']) . '&artist=' . urlencode($tracks_info[$track]['artist']) . '&album=' . urlencode($tracks_info[$track]['album']);

                jzHREF($item_link, '', '', '', $tracks_info[$track]['album']);
            } else {
                echo '<br>' . $tracks_info[$track]['artist'] . ' - ' . $tracks_info[$track]['album'];
            }

            jzTDClose();

            jzTDOpen('15', 'center', 'top', 'jz_track_table_songs_td', '');

            echo '<nobr>';

            if ('NULL' != $tracks_info[$track]['rating']) {
                echo displayRating(null, false, $tracks_info[$track]['rating']);
            }

            echo '</nobr>';

            jzTDClose();

            jzTDOpen('15', 'center', 'top', 'jz_track_table_songs_td', '');

            echo '<nobr>' . $tracks_info[$track]['counter'] . ' ' . $word_plays;

            if ('' != $tracks_info[$track]['lastplayeduser'] and 'false' != $lastplayed) {
                echo '<br>Last by: ' . $tracks_info[$track]['lastplayeduser'];
            }

            echo '</nobr>';

            jzTDClose();

            jzTDOpen('15', 'center', 'top', 'jz_track_table_songs_td', '');

            if ('NULL' != $tracks_info[$track]['rateVotes'] and 'rating' == $type) {
                echo '<nobr>' . $tracks_info[$track]['rateVotes'] . ' ' . word_votes . '</nobr>';
            }

            if ('NULL' != $tracks_info[$track]['discVotes'] and 'discuss' == $type) {
                echo '<nobr>' . $tracks_info[$track]['discVotes'] . ' ' . word_votes . '</nobr>';
            }

            if ('NULL' != $tracks_info[$track]['downloads'] and 'download' == $type) {
                echo '<nobr>' . $tracks_info[$track]['downloads'] . ' ' . $word_downloads . '</nobr>';
            }

            jzTDClose();

            // Now let's close out

            jzTDClose();

            jzTRClose();

            // Let's increment our counter for the row class

            $i = ++$i % 2;

            // Let's make sure we don't go to far

            $c++;

            if ($c > $most_played_nb) {
                jzTableClose();

                echo '<br>';

                return;
            }
        }
    }

    jzTableClose();

    echo '<br>';
}

/**
 * Displays the Most Played tracks in a table
 *
 * @author  Ross Carlson
 * @version 04/28/04
 * @since   04/28/04
 * @param mixed $level
 */
function showMostPlayed($level = '')
{
    global $most_played_nb;

    // Let's get the data back

    $tracks = processDataFiles('counter', 'getNbPlay', $most_played_nb, -1, $level);

    // reads track XML files to get tracks name and description

    $tracks_info = getTracksInfos(array_keys($tracks));

    // Let's make sure there is something to display

    if (0 != count($tracks_info)) {
        // Now let's display it

        displayChartData($tracks_info, $tracks, word_most_played, 'rating');
    }
}

/**
 * Displays the Most Played tracks in a table
 *
 * @author  Ross Carlson
 * @version 04/28/04
 * @since   04/28/04
 * @param mixed $level
 */
function showLastPlayed($level = '')
{
    global $most_played_nb;

    // Let's get the data back

    $tracks = processDataFiles('counter', 'getMTime', $most_played_nb, -1, $level);

    // reads track XML files to get tracks name and description

    $tracks_info = getTracksInfos(array_keys($tracks));

    // Let's make sure there is something to display

    if (0 != count($tracks_info)) {
        // Now let's display it

        displayChartData($tracks_info, $tracks, word_last_played, 'rating', 'true');
    }
}

/**
 * Displays the Most Played tracks in a table
 *
 * @author  Ross Carlson
 * @version 04/28/04
 * @since   04/28/04
 * @param mixed $level
 */
function showMostDiscussed($level = '')
{
    global $most_played_nb;

    // Let's get the data back

    $tracks = processDataFiles('discussions', 'getMTime', $most_played_nb, -1, $level);

    // reads track XML files to get tracks name and description

    $tracks_info = getTracksInfos(array_keys($tracks));

    // Let's make sure there is something to display

    if (0 != count($tracks_info)) {
        // Now let's display it

        displayChartData($tracks_info, $tracks, word_most_discussed, 'discuss');
    }
}

/**
 * Displays the Most Played tracks in a table
 *
 * @author  Ross Carlson
 * @version 04/28/04
 * @since   04/28/04
 * @param mixed $level
 */
function showHighestRated($level = '')
{
    global $most_played_nb;

    // Let's get the data back

    $tracks = processDataFiles('ratings', 'getRate', $most_played_nb, -1, $level);

    // reads track XML files to get tracks name and description

    $tracks_info = getTracksInfos(array_keys($tracks));

    // Let's make sure there is something to display

    if (0 != count($tracks_info)) {
        // Now let's display it

        displayChartData($tracks_info, $tracks, word_highest_rated, 'rating');
    }
}

/**
 * Displays the Most Played tracks in a table
 *
 * @author  Ross Carlson
 * @version 04/28/04
 * @since   04/28/04
 * @param mixed $level
 */
function showLastRated($level = '')
{
    global $most_played_nb;

    // Let's get the data back

    $tracks = processDataFiles('ratings', 'getMTime', $most_played_nb, -1, $level);

    // reads track XML files to get tracks name and description

    $tracks_info = getTracksInfos(array_keys($tracks));

    // Let's make sure there is something to display

    if (0 != count($tracks_info)) {
        // Now let's display it

        displayChartData($tracks_info, $tracks, word_last_rated, 'rating');
    }
}

/**
 * Displays the Most Played tracks in a table
 *
 * @author  Ross Carlson
 * @version 04/28/04
 * @since   04/28/04
 * @param mixed $level
 */
function showLastDiscussed($level = '')
{
    global $most_played_nb;

    // Let's get the data back

    $tracks = processDataFiles('discussions', 'getMTime', $most_played_nb, -1, $level);

    // reads track XML files to get tracks name and description

    $tracks_info = getTracksInfos(array_keys($tracks));

    // Let's make sure there is something to display

    if (0 != count($tracks_info)) {
        // Now let's display it

        displayChartData($tracks_info, $tracks, word_last_discussed, 'discuss');
    }
}

/**
 * Displays the last downloaded tracks in a table
 *
 * @author  Ross Carlson
 * @version 04/28/04
 * @since   04/28/04
 * @param mixed $level
 */
function showLastDownloaded($level = '')
{
    global $most_played_nb;

    // Let's get the data back

    $tracks = processDataFiles('download', 'getMTime', $most_played_nb, -1, $level);

    // reads track XML files to get tracks name and description

    $tracks_info = getTracksInfos(array_keys($tracks));

    // Let's make sure there is something to display

    if (0 != count($tracks_info)) {
        // Now let's display it

        displayChartData($tracks_info, $tracks, word_last_downloaded, 'download');
    }
}

/**
 * Displays the last downloaded tracks in a table
 *
 * @author  Ross Carlson
 * @version 04/28/04
 * @since   04/28/04
 * @param mixed $level
 */
function showMostDownloaded($level = '')
{
    global $most_played_nb;

    // Let's get the data back

    $tracks = processDataFiles('download', 'getNbPlay', $most_played_nb, -1, $level);

    // reads track XML files to get tracks name and description

    $tracks_info = getTracksInfos(array_keys($tracks));

    // Let's make sure there is something to display

    if (0 != count($tracks_info)) {
        // Now let's display it

        displayChartData($tracks_info, $tracks, word_most_downloaded, 'download');
    }
}

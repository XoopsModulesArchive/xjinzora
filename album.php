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
* Code Purpose: This page contains all the album related related functions
* Created: 9.24.03 by Ross Carlson
*
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

function displayAlbumCovers($dirToLookIn, $dataArray)
{
    global $ext_graphic, $main_table_width, $this_page, $media_dir, $mp3_dir, $root_dir, $album_name_truncate, $album_img_width, $album_img_height, $web_root, $img_height, $word_change_art, $auto_search_art, $word_play_album, $album_force_width, $album_force_height, $url_seperator, $days_for_new, $word_new, $sort_by_year, $audio_types, $cms_mode, $genre, $artist, $cols_for_albums;

    // Let's see if they wanted to auto search for album art or not

    if ('true' == $auto_search_art and 'viewonly' != $_SESSION['jz_access_level'] and 'lofi' != $_SESSION['jz_access_level']) {
        // First let's get all the albums for this location

        $searchArray = readDirInfo($dirToLookIn, 'dir');

        $search = 'false';

        $i = 0;

        $c = 0;

        while (count($searchArray) > $i) {
            $readDir = $dirToLookIn . '/' . $searchArray[$i];

            $imgArray = readDirInfo($readDir, 'file');

            $dataFound = 'no';

            while (count($imgArray) > $c) {
                if (preg_match("/\.($ext_graphic)$/i", $imgArray[$c])) {
                    $dataFound = 'yes';
                }

                $c++;
            }

            $c = 0;

            // Now, if we didn't find art let's auto search for it

            if ('no' == $dataFound) {
                if ('' != $searchArray[$i]) {
                    autoSearchArt(urldecode($_GET['artist']) . '|||' . $searchArray[$i]);

                    $search = 'true';
                }
            }

            $i++;
        }

        if ('true' == $search) {
            // Now let's set what the XML file should be

            $xmlFile = $web_root . $root_dir . '/data/artists/' . str_replace('/', '---', str_replace($web_root . $root_dir . $media_dir . '/', '', $dirToLookIn)) . '.xml';

            while ('---' == mb_substr($xmlFile, 0, 3)) {
                $xmlFile = mb_substr($xmlFile, 3, mb_strlen($xmlFile));
            }

            // Now let's update the artist XML since we updated the photo

            createArtistXMLFile($dirToLookIn, $xmlFile);

            echo '<meta http-equiv="refresh" content="0">';

            exit();
        }
    }

    // This sets how many album columns to show

    // We'll set 3 for standalone and 2 for CMS

    if ('true' == $cms_mode) {
        $ctr = $cols_for_albums - 1;
    } else {
        $ctr = $cols_for_albums;
    }

    // Now let's figure out the width of the cells

    $tdWidth = 100 / $ctr;

    $i = 1;

    // Now let's display the albums

    echo '<br><br>';

    echo '<table class="jz_album_cover_table" width="100%" cellpadding="0" cellspacing="0" border="0">';

    echo '<tr>' . "\n";

    for ($c = 0, $cMax = count($dataArray); $c < $cMax; $c++) {
        $FullAlbumName = $dataArray[$c]['name'];

        $album_short_name = $dataArray[$c]['short_name'];

        $album_year = $dataArray[$c]['year'];

        $img_src = $dataArray[$c]['image'];

        $album_rating = $dataArray[$c]['rating'];

        // Now let's make sure there really is data here

        if ('' != $FullAlbumName and '' != $img_src) {
            // Now let's figure out if we should be using truncation

            if ('' != $album_name_truncate and '0' != $album_name_truncate) {
                $albumName = $album_short_name;
            } else {
                $albumName = $FullAlbumName;
            }

            // Now let's clean up the display name IF we are in year sort mode

            if ('true' == $sort_by_year and '' != $dataArray[$c]['year']) {
                $albumName .= ' (' . $dataArray[$c]['year'] . ')';
            }

            // Now let's display the art we found

            echo '<td width="'
                 . $tdWidth
                 . '%" class="jz_album_cover_table_td" valign="top" align="center"><nobr>'
                 . "\n"
                 . '<a class="jz_album_cover_table_href" href="'
                 . $this_page
                 . $url_seperator
                 . 'ptype=songs&genre='
                 . urlencode($_GET['genre'])
                 . '&artist='
                 . urlencode($_GET['artist'])
                 . '&album='
                 . urlencode($FullAlbumName)
                 . '">'
                 . $albumName
                 . "</a>\n";

            // Now let's see if this is a new album or not

            echo '</nobr><br>';

            echo '<a class="jz_album_cover_table_href" href="' . $this_page . $url_seperator . 'ptype=songs&genre=' . urlencode($_GET['genre']) . '&artist=' . urlencode($_GET['artist']) . '&album=' . urlencode($FullAlbumName) . '">';

            if ('' != $album_force_height and '0' != $album_force_height) {
                echo '<img width="' . $album_force_width . '" height="' . $album_force_height . '" class="jz_album_cover_picture" src="' . $img_src . '?' . time() . '" title="' . $dirArray[$c] . '"></a>';
            } else {
                echo '<img class="jz_album_cover_picture" src="' . $img_src . '?' . time() . '" title="' . $albumName . '" alt="' . $albumName . '"></a>';
            }

            echo '<br><nobr><span class="jz_sm_font"><em>';

            $new_check = checkForNew($web_root . $root_dir . $media_dir . '/' . $genre . '/' . $artist . '/' . $FullAlbumName);

            if (true === $new_check) {
                echo $new_check . '<br>';
            }

            echo '</em></span></nobr><br><br></td>' . "\n";

            // Now let's put a little space between them

            echo '<td width="1"><nobr>&nbsp;&nbsp;</nobr></td>';

            if (0 == $i % $ctr) {
                echo '</tr><tr>';
            }

            $i++;
        }
    }

    echo '</table><br>' . "\n";
}

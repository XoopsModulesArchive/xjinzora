<?php

// Let's show the header
function slimHeader()
{
    global $css, $root_dir, $jinzora_skin, $img_home, $img_next, $img_previous, $jukebox, $img_play, $this_page, $word_home, $jinzora_url, $img_random_play, $slim_title, $cms_mode, $web_root, $media_dir, $play_in_wmp_only;

    // Now let's output the CSS

    // First let's see if we are in CMS mode and if so select Sandstone as the default

    if ('true' == $cms_mode) {
        $css = "<link rel=\"stylesheet\" href=\"$root_dir/style/sandstone/default.css\" type=\"text/css\">";
    }

    echo $css;

    // Now let's display the header if there is one

    $head_file = $web_root . $root_dir . $media_dir . '/slim-header.txt';

    if (is_file($head_file) and 0 != filesize($head_file)) {
        $handle = fopen($head_file, 'rb');

        $contents = fread($handle, filesize($head_file));

        fclose($handle);

        echo '<center>' . stripslashes($contents) . '</center>';
    }

    // Now let's figure out the page one up from here

    if (isset($_GET['curdir'])) {
        // Ok, Now let's figure out the back dir

        $backArray = explode('/', $_GET['curdir']);

        unset($backArray[count($backArray) - 1]);

        $back_page = 'curdir=' . implode('/', $backArray);

        $slim_title = str_replace('/', ' - ', $_GET['curdir']);
    }

    echo '<title>' . $slim_title . '</title>';

    echo '<body style="margin-left: 0px;" rightmargin="0">';

    // Now let's show them the seperator bar

    echo '<tr><td height="6" width="100%" colspan="2" background="' . $root_dir . '/style/images/slim-sep.gif"></td></tr></table>';

    echo '<table with="100%" cellspacing="0" cellpadding="5" border="0"><tr>';

    echo '<td width="1%" valign="top"><nobr><img src="' . $root_dir . '/style/images/open-folder.gif"></nobr></td>';

    // Now let's show each of our breadcrums

    echo '<td width="99%" colspan="2" class="jz_artist_table_td"><a href="' . $root_dir . '/slim.php">' . $word_home . '</a>';

    if (isset($_GET['curdir'])) {
        // Ok, since it's set let's show the open icon and the breadcrums

        $bArray = explode('/', urldecode($_GET['curdir']));

        $link = '';

        for ($i = 0; $i < count($bArray) - 1; $i++) {
            // Let's not show the first link

            $link .= '/' . $bArray[$i];

            // Now let's strip that first slash

            if ('/' == mb_substr($link, 0, 1)) {
                $link = mb_substr($link, 1, mb_strlen($link));
            }

            echo ' / <a href="' . $root_dir . '/slim.php?curdir=' . $link . '">' . $bArray[$i] . '</a>';
        }

        // Now let's close out

        echo '</td></tr>';

        // Now let's show them the artist they are current on

        $link_play = $root_dir . '/playlists.php?d=1&style=normal&info=' . $_GET['curdir'] . '&slim=true&return=' . base64_encode($_SESSION['prev_page']);

        $link_random = $root_dir . '/playlists.php?d=1&style=random&info=' . $_GET['curdir'] . '&slim=true&return=' . base64_encode($_SESSION['prev_page']);

        echo '<tr><td width="1%"></td><td width="98%" class="jz_artist_table_td"><strong>'
             . $bArray[count($bArray) - 1]
             . '</strong></td><td align="right" width="1%"><nobr>'
             . '<a href="'
             . $link_play
             . '">'
             . $img_play
             . '</a> '
             . '<a href="'
             . $link_random
             . '">'
             . $img_random_play
             . '</a></nobr>';

        // Now let's close out

        echo '</td></tr></table>';
    } else {
        // Now let's show them the artist they are current on

        $link_play = $root_dir . '/playlists.php?d=1&style=normal&info=/' . '&slim=true&return=' . base64_encode($_SESSION['prev_page']);

        $link_random = $root_dir . '/playlists.php?d=1&style=random&info=/' . '&slim=true&return=' . base64_encode($_SESSION['prev_page']);

        echo '<td align="right" width="1%"><nobr>' . '<a href="' . $link_play . '">' . $img_play . '</a> ' . '<a href="' . $link_random . '">' . $img_random_play . '</a></nobr>';

        echo '</td></tr></table>';
    }

    // We'll only show the rest for jukebox mode

    if ('false' != $jukebox) {
        displaySlimJuke();
    }

    // Now let's show them the seperator bar

    echo '<table  cellspacing="0" cellpadding="0" border="0" width="100%"><tr><td height="6" width="100%" background="' . $root_dir . '/style/images/slim-sep.gif"></td></tr></table>';

    // Now let's close out

    echo '<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td width="100%" bgcolor="#999999">' . '<img height="1" src="' . $root_dir . '"/style/images/blank.gif"></td></tr></table>';
}

function displaySlimDirs($retArray)
{
    global $web_root, $root_dir, $media_dir, $img_play, $this_page, $url_seperator, $currentDir, $show_art, $row_colors, $img_random_play, $show_desc, $desc_truncate, $ext_graphic, $show_year, $audio_types, $play_in_wmp_only, $img_download, $display_downloads;

    // let's start our table out

    echo '<table width="100%" cellspacing="0" cellpadding="5" border="0">';

    $e = 0;

    $album_found = 'false';

    for ($i = 0, $iMax = count($retArray); $i < $iMax; $i++) {
        // Now let's see if there is a description for this album IF we wanted to

        $contents = '';

        if ('false' != $show_desc) {
            $desc_file = $web_root . $root_dir . $media_dir . '/' . $currentDir . $retArray[$i] . '/album-desc.txt';

            if (!is_file($desc_file)) {
                // Ok, there wasn't , let's see if there is an genre/artist description

                $desc_file = $web_root . $root_dir . $media_dir . '/' . $currentDir . $retArray[$i] . '/' . $retArray[$i] . '.txt';
            }

            if (!is_file($desc_file)) {
                // Ok, there wasn't , let's see if there is an genre/artist description

                $desc_file = $web_root . $root_dir . $media_dir . '/' . $currentDir . '/' . $retArray[$i] . '.txt';
            }

            if (is_file($desc_file) and 0 != filesize($desc_file)) {
                // Ok, it's there so let's open it and display it

                $handle = fopen($desc_file, 'rb');

                $contents = fread($handle, filesize($desc_file));

                fclose($handle);

                // Now let's do some find and replaces incase they wanted to use some variables here...

                if (isset($artist)) {
                    $contents = str_replace('ARTIST_NAME', $artist, $contents);
                }

                if (isset($album)) {
                    $contents = str_replace('ALBUM_NAME', $album, $contents);
                }

                $contents = nl2br(stripslashes($contents));
            }
        }

        // Now did they want art?

        if ('false' != $show_art) {
            // Ok, let's look for it!

            $dirArray = readDirInfo($web_root . $root_dir . $media_dir . '/' . $currentDir . $retArray[$i], 'file');

            $album_img = '';

            for ($c = 0, $cMax = count($dirArray); $c < $cMax; $c++) {
                if (preg_match("/\.($ext_graphic)$/i", $dirArray[$c])) {
                    $album_img = $root_dir . $media_dir . '/' . $currentDir . rawurlencode($retArray[$i]) . '/' . rawurlencode($dirArray[$c]);
                }
            }
        }

        // Did they want to see the year?

        $album_year = '';

        if ('false' != $show_year) {
            // Let's read the art dir array if there to save time

            if (!isset($dirArray)) {
                $dirArray = readDirInfo($web_root . $root_dir . $media_dir . '/' . $currentDir . $retArray[$i], 'file');
            }

            for ($c = 0, $cMax = count($dirArray); $c < $cMax; $c++) {
                if (preg_match("/\.($audio_types)$/i", $dirArray[$c])) {
                    // Now let's read the first one

                    require_once __DIR__ . '/id3classes/getid3.php';

                    $getID3 = new getID3();

                    $fileInfo = $getID3->analyze($web_root . $root_dir . $media_dir . '/' . $currentDir . $retArray[$i] . '/' . $dirArray[$c]);

                    getid3_lib::CopyTagsToComments($fileInfo);

                    if (!empty($fileInfo['comments']['year'][0])) {
                        $album_year = $fileInfo['comments']['year'][0];

                        $c = count($dirArray) + 1;
                    }
                }
            }
        }

        // now let's start our row and show our folder icon

        echo '<tr class="' . $row_colors[$e] . '">';

        echo '<td valign="top" width="10" align="left" class="jz_artist_table_td">';

        echo '<img src="' . $root_dir . '/style/images/folder.gif" borde="0">';

        // Now let's create the link for the item

        $link = $root_dir . '/slim.php?curdir=' . $currentDir . urlencode($retArray[$i]);

        // Now let's show our next column with the folder name

        echo '<td width="70%" align="left" class="jz_artist_table_td">';

        echo '<a href="' . $link . '">' . $retArray[$i] . '</a>';

        // Now let's see if we found a year

        if ('false' != $show_year) {
            if ('' != $album_year) {
                echo ' (' . $album_year . ')';
            }
        }

        echo '<br>';

        // Let's make sure $_GET['curdir'] is set

        if (!isset($_GET['curdir'])) {
            $_GET['curdir'] = '/';
        }

        // Now let's see if this item is new

        $new_item = checkForNew($web_root . $root_dir . jzstripslashes($media_dir . '/' . urldecode($_GET['curdir']) . '/' . $retArray[$i]));

        if ('' != $new_item) {
            echo '<em><font size="1">' . $new_item . '</font></em>';
        }

        // Now let's end the cell and start the next one

        echo '</td><td valign="top" width="30%" align="right" class="jz_artist_table_td"><nobr>';

        // Now let's show the subnumbers for this location

        $sub_items = readSubItems($web_root . $root_dir . jzstripslashes($media_dir . '/' . urldecode($_GET['curdir']) . '/' . $retArray[$i]));

        if (0 != $sub_items) {
            echo ' (' . $sub_items . ')';
        }

        // Now let' show the play links

        $link_play = $root_dir . '/playlists.php?d=1&style=normal&info=' . $_GET['curdir'] . '/' . urlencode($retArray[$i]) . '&slim=true&return=' . base64_encode($_SESSION['prev_page']);

        $link_random = $root_dir . '/playlists.php?d=1&style=random&info=' . $_GET['curdir'] . '/' . urlencode($retArray[$i]) . '&slim=true&return=' . base64_encode($_SESSION['prev_page']);

        echo ' <a href="' . $link_play . '"><strong>' . $img_play . '</strong></a> ' . ' <a href="' . $link_random . '"><strong>' . $img_random_play . '</strong></a>';

        if ('true' == $display_downloads) {
            $link_dwnl = $root_dir . '/download.php?info=' . $_GET['curdir'] . '/' . urlencode($retArray[$i]);

            echo ' <a href="' . $link_dwnl . '"><strong>' . $img_download . '</strong></a>';
        }

        echo '</nobr>';

        if ('' != $contents or '' != $album_img) {
            // Now let's show the row for the description

            echo '</td><tr class="' . $row_colors[$e] . '"><td width="10"></td><td valign="top" width="100%" colspan="2" align="left" class="jz_artist_table_td">';

            if ('' != $album_img) {
                echo '<a href="' . $link . '"><img align=left hspace=6 width="75" src="' . $album_img . '" border="0"></a>';
            }

            if ('' != $contents) {
                // Now let's only echo so much of this IF set

                if (0 != $desc_truncate) {
                    if (mb_strlen($contents) > $desc_truncate) {
                        $contents = mb_substr($contents, 0, $desc_truncate) . '...';
                    }
                }

                echo '<font size="1">' . stripslashes($contents) . '</font>';
            }
        }

        $album_found = 'false';

        $album_img = '';

        // Now let's close out the row

        echo '</td></tr>';

        // Now let's flush this out to the browser

        flushDisplay();

        // Now let's change our row counter

        $e = ++$e % 2;
    }

    echo '</table>';
}

// This function will display the footer for the slim mode
// Added by Ross Carlson 4.10.04
function slimFooter()
{
    global $this_pgm, $version, $jinzora_url, $img_slimzora, $web_root, $root_dir, $media_dir, $play_in_wmp_only;

    // Now let's display the header if there is one

    $foot_file = $web_root . $root_dir . $media_dir . '/slim-footer.txt';

    if (is_file($foot_file) and 0 != filesize($foot_file)) {
        $handle = fopen($foot_file, 'rb');

        $contents = fread($handle, filesize($foot_file));

        fclose($handle);

        echo '<center>' . stripslashes($contents) . '</center><br>';
    }

    echo '<center><a href="' . $jinzora_url . '">' . $img_slimzora . '</a></center></body>';
}

// This function will display the jukebox bar
// Added 4.10.04 by Ross Carlson
function displaySlimJuke()
{
    global $web_root, $root_dir, $jinzora_skin, $img_home, $jinzora_url, $jukebox;

    // Let's include the slim display stuff

    // We do it this way so you can access the controls all alone

    require_once __DIR__ . '/slim.jukebox.php';
}

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
* Purpose: Jinzora's add on tools
*
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

// First we need to see if they were auto searching for album art and if so do that - before we display the header
if (isset($_GET['action'])) {
    if ('searchforart' == $_GET['action']) {
        require_once __DIR__ . '/settings.php';

        require_once __DIR__ . '/system.php';

        require_once __DIR__ . '/general.php';

        require_once __DIR__ . '/display.php';

        require_once __DIR__ . '/playlists.php';

        require_once __DIR__ . '/classes.php';

        // Ok, let's do it!

        searchForAlbumArt();

        exit();
    }
}

// First we need to know if we are redirecting for setup mode
if (isset($_GET['action'])) {
    if ('entersetup' == $_GET['action']) {
        if ('false' == $cms_mode) {
            header('Location: ' . 'index.php?enterinstall=yes');
        } else {
            switch ($cms_type) {
                case 'mambo':
                    header('Location: ' . 'index.php?option=com_jinzora&file=index&enterinstall=yes');
                    break;
                case 'nsnnuke':
                    header('Location: ' . 'modules.php?op=modload&name=' . $_GET['name'] . '&file=index&enterinstall=yes');
                    break;
                case 'cpgnuke':
                    header('Location: ' . 'modules.php?op=modload&name=' . $_GET['name'] . '&file=index&enterinstall=yes');
                    break;
                case 'postnuke':
                    header('Location: ' . 'modules.php?op=modload&name=' . $_GET['name'] . '&file=index&enterinstall=yes');
                    break;
                case 'phpnuke':
                    header('Location: ' . 'modules.php?op=modload&name=' . $_GET['name'] . '&file=index&enterinstall=yes');
                    break;
            }
        }
    }
}

// Let's run the function if we're NOT in CMS mode (PN mode does this automatically)
// upload doesn't like session...
if ('false' == $cms_mode && !isset($_POST['submit_upload'])) {
    // Let's make sure they really are an admin

    if ('admin' != $_SESSION['jz_access_level']) {
        echo "<br><br><center>Ok cheese ball, you're not supposed to be here, so piss off!!!</center><br><br>";

        exit();
    }
}

jinzora_admin_main();

function jinzora_admin_main()
{
    global $root_dir, $word_tools, $cms_mode, $media_dir, $web_root, $jinzora_skin, $mp3_dir, $word_stop_shoutcast, $word_start_shoutcast, $word_enter_setup, $word_send_tech_email, $word_check_for_update, $word_select_for_ipod, $word_delete_genre, $word_create_new_genre, $word_strip_id3v1_desc, $word_update_id3v1, $word_upload_center, $word_fix_media_names, $word_update_cache, $word_search_missing_album_art, $word_define, $word_define_uc, $word_define_id3_update, $word_define_id3_strip, $word_define_id3_strip, $word_define_create_genre, $word_define_delete_genre, $word_define_ipod_sync, $word_define_check_updates, $word_define_send_tech_info, $word_define_enter_setup, $word_define_start_shoutcast, $word_define_stop_shoutcast, $word_define_fix_media, $word_define_update_cache, $word_define_search_for_art, $word_rewrite_files_from_id3, $word_define_rewrite_from_id3, $word_define_survey, $word_survey, $word_user_manager, $word_define_user_manager, $version, $word_define_word_donate, $word_donate, $word_search_new, $word_search_new_define, $shoutcast;

    if ('false' != $cms_mode) {
        include 'settings.php';

        include 'system.php';

        // Let's open up our CMS

        openCMS();

        // Let's set a page name variable for later

        $link_url = $this_page . 'ptype=tools';
    } else {
        // Let's set a page name variable for later

        $link_url = 'index.php?ptype=tools';
    }

    // Now let's show the header

    displayHeader($word_tools);

    // Up here we need to check all the form submissions....

    /* Let's see if they wanted to upload something or not */

    if (isset($_POST['submit_upload'])) {
        global $web_root, $root_dir, $media_dir;

        if ('false' != $cms_mode) {
            include 'settings.php';

            include 'system.php';
        }

        // Let's initalize a variable so we'll know if we were good or not

        $success = 'true';

        /* Now let's deal with the file they uploaded - first making sure they uploaded a file*/

        if ('' != $_FILES['attfile']['name']) {
            // First let's clean up the new path by converting it to forward slashes incase they used back slashes

            $file_path = dirname($_FILES['attfile']['name']);

            // Now let's see if that structure exists, and if not we'll create it!

            $pathArray = explode('/', $file_path);

            $searchPath = $web_root . $root_dir . $media_dir;

            for ($c = 0, $cMax = count($pathArray); $c < $cMax; $c++) {
                if ('' != $pathArray[$c]) {
                    $searchPath .= '/' . $pathArray[$c];

                    if (!is_dir($searchPath)) {
                        if (!mkdir($searchPath, 0700)) {
                            $success = 'false';
                        }
                    }
                }
            }

            $file_name = basename($_FILES['attfile']['name']);

            /* Now let's put the file into the temp dir so we can deal with it */

            copy($_FILES['attfile']['tmp_name'], $searchPath . '/' . $file_name);

            /* Now let's see if it's a zip file or not */

            if ('' != mb_stristr($file_name, '.zip')) {
                // Let's extract that file...

                require_once __DIR__ . '/pclzip.lib.php';

                $archive = new PclZip($searchPath . '/' . $file_name);

                $archive->extract($searchPath, '');

                // Now let's kill the source file

                unlink($searchPath . '/' . $file_name);
            }
        } else {
            echo "Um, didn't you mean to upload something?  I don't see it if you did...<br>";
        }

        if ('true' == $success) {
            /* Let them know we were successful */

            echo '<br><center><strong>Files successfuly uploaded into Jinzora!</strong></center><br><br>';
        } else {
            echo '<br><center><strong>Sorry, I had a problem uploading the tracks...</strong></center><br><br>';
        }

        // Let's update the cache now, if they wanted to...

        if (isset($_POST['update_cache'])) {
            if ('on' == $_POST['update_cache']) {
                createFileCaches('true', 'true');
            }
        }
    }

    /* Let's see if they wanted to move something */

    if (isset($_GET['move'])) {
        /* Ok they wanted to move something so let's give them the choices */

        /* First let's break apart the Genre/Artist */

        $dataArray = explode('/', $_GET['move']);

        echo '<strong>Move Artist to new Genre</strong><br><br>'
             . '<form action="'
             . $this_page
             . $url_seperator
             . 'ptype=tools" method="post">'
             . '<table width="100%" cellpadding="'
             . $song_cellpadding
             . '" cellspacing="0" border="0">'
             . '<tr>'
             . '<td width="20%" align="right">'
             . 'Artist: &nbsp;'
             . '</td>'
             . '<td width="80%">'
             . $dataArray[1]
             . '</td>'
             . '</tr>'
             . '<tr>'
             . '<td width="20%" align="right">'
             . 'Current Genre: &nbsp;'
             . '</td>'
             . '<td width="80%">'
             . $dataArray[0]
             . '</td>'
             . '</tr>'
             . '<tr>'
             . '<td width="20%" align="right">'
             . 'New Genre: &nbsp;'
             . '</td>'
             . '<td width="80%">'
             . '<select name="newgenre">';

        /* Let's get all the Genre's from the top level */

        $d = dir($mp3_dir);

        $ctr = 0;

        while ($genreDir = $d->read()) {
            /* Let's check what we got back */

            if ('.' == $genreDir || '..' == $genreDir) {
                continue;
            }

            if ('dir' == filetype($mp3_dir . '/' . $genreDir)) {
                $genreArray[$ctr] = $genreDir;

                $ctr += 1;
            }
        }

        /* Now let's sort what we got back */

        sort($genreArray);

        $ctr = 0;

        while (count($genreArray) > $ctr) {
            echo '<option value="' . $genreArray[$ctr] . '">' . $genreArray[$ctr];

            $ctr += 1;
        }

        echo '</select>'
             . '<input type="hidden" name="originalLocation" value="'
             . $_GET['move']
             . '">'
             . '</td>'
             . '</tr>'
             . '<tr>'
             . '<td width="20%" align="right">'
             . '</td>'
             . '<td width="80%">'
             . '<input type="submit" name="moveItem" value="Move to new Genre">'
             . '</td>'
             . '</tr>'
             . '</table>'
             . '</form>';
    }

    // Let's make sure they didn't want to do something

    if (isset($_GET['action'])) {
        // Ok, let's see what they wanted to do

        switch ($_GET['action']) {
            case 'upid3': # Ok, show the ID3 update tool
                displayID3update('update');
                break;
            case 'stid3': # Ok, show the ID3 update tool
                displayID3update('strip');
                break;
            case 'uploadcenter': # Ok, they wanted to upload
                uploadCenter();
                break;
            case 'updateid3': # Ok, they wanted to fix the ID3 tags
                updateID3tags('write');
                break;
            case 'stripid3': # Ok, they wanted to strip the ID3 tags
                updateID3tags('strip');
                break;
            case 'creategenre': # Ok, they wanted to create a genre
                createGenre();
                break;
            case 'deletegenre': # Ok, they wanted to delete a genre
                deletegenre();
                break;
            case 'ipodsync': # Ok, they wanted to select stuff for the iPod
                require_once __DIR__ . '/ipod.php';
                break;
            case 'checkforupdates': # Ok, they wanted to check for updates
                checkUpdates();
                break;
            case 'sendtechinfo': # Ok, they wanted to send the support email
                sendTechSupport();
                break;
            case 'startshoutcast': # Ok, they wanted to Start Shoutcasting
                startShoutcast();
                break;
            case 'stopshoutcast': # Ok, they wanted to Stop Shoutcasting
                stopShoutcast();
                break;
            case 'fixtracks': # Ok, they wanted to Stop Shoutcasting
                fixTracks();
                break;
            case 'usermanager': # Ok, they wanted the user manager
                userManager();
                break;
            case 'updatecache': # This will update the file cache for faster performance
                createFileCaches('true', 'true');
                echo '<br><center>File Caching updated!</center><br><br>';
                break;
            case 'searchforart': # This let's them search for missing album art
                searchForAlbumArt();
                break;
            case 'rewritefromid3': # Ok, let's rewrite all the file names based on the ID3 tags
                rewriteFromID3();
                break;
            case 'autoupdate':
                downloadUpdate($_GET['updatetype']);
                break;
        }
    }

    if ('true' == $cms_mode) {
        displayFooter();

        // Let's close out our CMS

        closeCMS();
    }
}

// This function let's the user fix the ID3 tags in a batch way
function displayID3update($actionType)
{
    global $web_root, $root_dir, $media_dir, $this_page, $cms_mode, $url_seperator, $cms_type;

    if ('false' != $cms_mode) {
        include 'settings.php';

        include 'system.php';

        switch ($cms_type) {
            case 'nsnnuke':
                $formAction = 'modules.php?name=jinzora&ptype=tools&action=updateid3';
                break;
            case 'cpgnuke':

                break;
            case 'postnuke':

                break;
            case 'phpnuke':

                break;
        }
    } else {
        $formAction = 'index.php?ptype=tools&action=updateid3';
    } ?>
    <form action="<?php echo $formAction; ?>" name="fixTracks" method="post">
        <table width="100%" cellpadding="0" cellspacing="0" border="0" class="jz_footer_table">
            <tr>
                <td width="25%">&nbsp;</td>
                <td width="50%" class="jz_artist_table_td">
                    <input class="jz_checkbox" type="checkbox" name="update_genre">Genre Name
                    | <a href="#" onClick="alert('This will rewrite the Genre tag based on the Genre folder the track is in\n\nFor Example:\nJazz\\Miles Davis\\Kind Of Blue\\01 - All Blues.mp3\n\nJazz will become the genre');">Define</a><br>

                    <input class="jz_checkbox" type="checkbox" name="update_artist">Artist Name
                    | <a href="#" onClick="alert('This will rewrite the Artist tag based on the Artist folder the track is in\n\nFor Example:\nJazz\\Miles Davis\\Kind Of Blue\\01 - All Blues.mp3\n\nMiles Davis will become the artist');">Define</a><br>

                    <input class="jz_checkbox" type="checkbox" name="update_album">Album Name
                    | <a href="#" onClick="alert('This will rewrite the Album tag based on the Album folder the track is in\n\nFor Example:\nJazz\\Miles Davis\\Kind Of Blue\\01 - All Blues.mp3\n\nKind of Blue will become the album');">Define</a><br>

                    <input class="jz_checkbox" type="checkbox" name="update_track_num">Track Number
                    | <a href="#" onClick="alert('This will rewrite the Track Number tag based on the Track Number in the the track (if available - 0 if not)\n\nFor Example:\nJazz\\Miles Davis\\Kind Of Blue\\01 - All Blues.mp3\n\n01 will become the track number');">Define</a><br>

                    <input class="jz_checkbox" type="checkbox" name="update_track_name">Track Name
                    | <a href="#" onClick="alert('This will rewrite the Track Name tag based on the File Name (excluding the track nubmer if available)\n\nFor Example:\nJazz\\Miles Davis\\Kind Of Blue\\01 - All Blues.mp3\n\nAll Blues will become the Track Name');">Define</a><br><br>

                    <input class="jz_select" type="submit" name="fixtrackstuff" value="Fix Items">
                    <br><br>
                </td>
                <td width="25%">&nbsp;</td>
            </tr>
        </table>
    </form>
    <br>
    <?php
}

function uploadCenter()
{
    global $mp3_dir, $this_page, $main_table_width, $url_seperator, $root_dir, $word_select_destination, $word_dest_path, $word_add_files, $word_upload, $word_clear_list, $word_current_file, $word_total_complete, $word_upload_center, $bg_c, $fg_c, $cms_mode, $text_c;

    if ('false' != $cms_mode) {
        include 'settings.php';

        include 'system.php';
    }

    if ('true' == $cms_mode) {
        // Let's set a page name variable for later

        $link_url = 'modules.php?op=modload&name=' . $_GET['name'] . '&file=index&ptype=tools&upload=yes';
    } else {
        // Let's set a page name variable for later

        $link_url = 'index.php?ptype=tools&upload=yes';
    } ?>
    <table width="<?php echo $main_table_width; ?>%" cellpadding="0" cellspacing="0" border="0" class="jz_footer_table">
        <tr>
            <td width="100%" align="center" class="jz_artist_table_td">
                <strong><?php echo $word_upload_center; ?></strong>
                <br>
                <?php
                echo '<a class="jz_header_table_td" href="' . $root_dir . '/mp3info.php?type=uploadbrowser&cur_theme=' . $_SESSION['cur_theme'] . '&return=' . rawurlencode($_SESSION['prev_page']) . '" target="_blank" onclick="uploadPopup(this); return false;">' . $word_select_destination . '</a>'; ?>
                <br>
                <APPLET CODE="upload.class" ARCHIVE="<?php echo $root_dir; ?>/upload/upload.jar" WIDTH=510 HEIGHT=290>
                    <PARAM NAME="server" VALUE="<?php echo $_SERVER['SERVER_NAME']; ?>">
                    <PARAM NAME="script" VALUE="<?php echo $root_dir . '/' . $link_url; ?>">
                    <PARAM NAME="port" VALUE="<?php echo $_SERVER['SERVER_PORT']; ?>">
                    <PARAM NAME="path" VALUE="<?php echo urldecode($_GET['uploadDest']); ?>">
                    <PARAM NAME="bg_color" VALUE="<?php echo $bg_c; ?>">
                    <PARAM NAME="fg_color" VALUE="<?php echo $fg_c; ?>">
                    <PARAM NAME="text_color" VALUE="<?php echo $text_c; ?>">
                    <PARAM NAME="border_color" VALUE="#000000">
                    <PARAM NAME="word_dest_path" VALUE="<?php echo $word_dest_path; ?>">
                    <PARAM NAME="word_add_files" VALUE="<?php echo $word_add_files; ?>">
                    <PARAM NAME="word_upload" VALUE="<?php echo $word_upload; ?>">
                    <PARAM NAME="word_clear_list" VALUE="<?php echo $word_clear_list; ?>">
                    <PARAM NAME="word_current_file" VALUE="<?php echo $word_current_file; ?>">
                    <PARAM NAME="word_total_complete" VALUE="<?php echo $word_total_complete; ?>">
                </APPLET>
            </td>
        </tr>
    </table>
    <br><br>
    <?php
}

function updateID3tags($updateType)
{
    global $mp3_dir, $directory_level, $track_num_seperator, $web_root, $root_dir, $media_dir, $cms_mode;

    // Let's tell them we started

    echo 'Beginning to auto update ID3 tags based on file system information...<br>';

    echo 'Sit back and relax, this may take a while...<br><br>Reading All Media Files<br>';

    flushDisplay();

    // Let's reset the maximum executution time, as this may take a while....

    ini_set('max_execution_time', '600');

    if ('false' != $cms_mode) {
        include 'settings.php';

        include 'system.php';
    }

    /* Let's start looping through the directories to create our array of file names */

    $d = dir($mp3_dir);

    while ($genreDir = $d->read()) {
        /* Let's check what we got back */

        if ('.' == $genreDir || '..' == $genreDir) {
            continue;
        }

        if ('dir' == filetype($mp3_dir . '/' . $genreDir)) {
            /* Let's set the genre that we're in */

            $genre = $genreDir;

            $d2 = dir($mp3_dir . '/' . $genreDir);

            while ($artistDir = $d2->read()) {
                /* Let's check what we got back */

                if ('.' == $artistDir || '..' == $artistDir) {
                    continue;
                }

                if ('dir' == filetype($mp3_dir . '/' . $genreDir . '/' . $artistDir)) {
                    /* Let's set the artist that we're in */

                    $artist = $artistDir;

                    $d3 = dir($mp3_dir . '/' . $genreDir . '/' . $artistDir);

                    while ($albumDir = $d3->read()) {
                        /* Let's check what we got back */

                        if ('.' == $albumDir || '..' == $albumDir) {
                            continue;
                        }

                        if ('dir' == filetype($mp3_dir . '/' . $genreDir . '/' . $artistDir . '/' . $albumDir)) {
                            /* Let's set the album that we're in */

                            $ablum = $albumDir;

                            $d4 = dir($mp3_dir . '/' . $genreDir . '/' . $artistDir . '/' . $albumDir);

                            while ($track = $d4->read()) {
                                /* Let's check what we got back */

                                if ('.' == $track || '..' == $track) {
                                    continue;
                                }

                                if ('file' == filetype($mp3_dir . '/' . $genreDir . '/' . $artistDir . '/' . $albumDir . '/' . $track)) {
                                    /* Let's set the track that we're in and add to our array - bur let's make sure it's really a MP3 file */

                                    if (preg_match("/\.(mp3)$/i", $track)) {
                                        $fileArray[$ctr] = $genre . '-----' . $artist . '-----' . $ablum . '-----' . $track;

                                        /* Let's increment our counter each time we add something */

                                        $ctr += 1;

                                        if (0 == $ctr % 10) {
                                            echo '.';

                                            flushDisplay();
                                        }
                                    }
                                }
                            }

                            $d4->close();
                        }
                    }

                    $d3->close();
                }
            }

            $d2->close();
        }
    }

    $d->close();

    /* Let's reset that counter */

    $ctr = 0;

    // Now let's include our ID3 classes

    require_once $web_root . $root_dir . '/id3classes/getid3.php';

    echo '<br><br>Writing all ID3 Tags (much slower...)<br>';

    /* Let's make sure they have actually done something */

    if ('' != isset($fileArray)) {
        /* Now let's loop through our Array and process the songs */

        while (count($fileArray) > $ctr) {
            // Let's make sure that isn't blank

            if ('' != $fileArray[$ctr]) {
                /* Let's break apart that variable into all it's parts, then set the variables */

                $fileInfo = explode('-----', $fileArray[$ctr]);

                /* Let's create the variabled based on the folder structure they are using */

                switch ($directory_level) {
                    case '3':
                        $genre = $fileInfo[0];
                        $artist = $fileInfo[1];
                        $album = $fileInfo[2];
                        $fileName = $fileInfo[3];
                        $song = str_replace('.mp3', '', $fileInfo[3]); # We'll strip off the .mp3 for display reasons
                        break;
                    case '2':
                        $genre = $fileInfo[0];
                        $artist = $fileInfo[1];
                        $album = $fileInfo[2];
                        $fileName = $fileInfo[3];
                        $song = str_replace('.mp3', '', $fileInfo[3]); # We'll strip off the .mp3 for display reasons

                        break;
                    case '1':
                        $genre = $fileInfo[0];
                        $artist = $fileInfo[1];
                        $album = $fileInfo[2];
                        $fileName = $fileInfo[3];
                        $song = str_replace('.mp3', '', $fileInfo[3]); # We'll strip off the .mp3 for display reasons

                        break;
                }

                /* Now let's see if the first 2 digits are the track number */

                /* First let's set a default track number */

                $trackNumber = '01';

                if (1 == is_numeric(mb_substr($song, 0, 2))) {
                    // Now let's make sure that's really the track number

                    // First we need to split out the track number seperator

                    $sepArray = explode('|', $track_num_seperator);

                    for ($c = 0, $cMax = count($sepArray); $c < $cMax; $c++) {
                        // Now let's do our test

                        if (mb_substr($song, 2, 3) == $sepArray[$c]) {
                            $trackNumber = mb_substr($song, 0, 2);

                            $song = mb_substr($song, 5);
                        }
                    }
                }

                /* Now let's build the full path to the file */

                $fileNamePath = $web_root . $root_dir . $media_dir . '/' . $genre . '/' . $artist . '/' . $album . '/' . $fileName;

                switch ($updateType) {
                    case 'write': 
                        // Let's write the tags
                        $getID3 = new getID3();
                        getid3_lib::IncludeDependency($web_root . $root_dir . '/id3classes/write.php', __FILE__, true);
                        $tagwriter = new getid3_writetags();
                        $tagwriter->overwrite_tags = false;
                        $fileInfo = $getID3->analyze($fileNamePath);
                        getid3_lib::CopyTagsToComments($fileInfo);

                        if (!empty($fileInfo['comments']['year'][0])) {
                            $year = $fileInfo['comments']['year'][0];
                        } else {
                            $year = '';
                        }
                        $description = '';
                        if (!empty($fileInfo['comments']['comment'][0])) {
                            $description = $fileInfo['comments']['comment'][0];
                        } else {
                            $description = '';
                        }

                        // Now let's set all the data
                        $data['title'][] = $song;
                        $data['artist'][] = $artist;
                        $data['album'][] = $album;
                        $data['genre'][] = $genre;
                        $data['track'][] = $trackNumber;
                        $data['comment'][] = $description;
                        $data['year'][] = $year;

                        // Now let's write the tags
                        $tagwriter->tag_data = $data;
                        $tagwriter->filename = $fileNamePath;
                        $tagwriter->tagformats = ['id3v1', 'id3v2.3'];
                        $success = $tagwriter->WriteTags();

                        unset($data);

                        if (0 == $ctr % 10) {
                            echo '.';

                            flushDisplay();
                        }
                        if (0 == $ctr % 250) {
                            echo $ctr . ' tracks updated<br>';

                            flushDisplay();
                        }

                        // Now let's make sure it was successful
                        //if ($success === true){
                        //echo " - <font color=green>Successful</font><br>";
                        //} else {
                        //echo " - <font color=red>Failed</font><br>";
                        //}

                        break;
                    case 'strip':
                        // Not used now
                        break;
                }
            }

            /* Let's incrememt the counter for the next loop */

            $ctr += 1;
        }
    }

    // Now let's tell them we did it

    echo "<br><center>Succesfully updated $ctr media files!</center><br><br>";
}

// This function allows the user to create a Genre
function createGenre()
{
    global $root_dir, $word_new_genre, $word_create_new_genre, $cms_mode;

    if ('false' != $cms_mode) {
        include 'settings.php';

        include 'system.php';
    }

    // Let's set the page URL for them

    if ('true' == $cms_mode) {
        // Let's set a page name variable for later

        $link_url = 'modules.php?op=modload&name=' . $_GET['name'] . '&file=index&ptype=tools';
    } else {
        // Let's set a page name variable for later

        $link_url = 'index.php?ptype=tools';
    }

    // Ok, let's show them the fields so they can create a new genre
    ?>
    <br>
    <form action="<?php echo $link_url . '&ptype=tools'; ?>" method="post">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td width="20%" align="right" valign="top" class="jz_artist_table_td">
                    <?php echo $word_new_genre; ?>
                </td>
                <td width="1%">&nbsp;</td>
                <td width="79%" class="jz_artist_table_td">
                    <select name="newgenre" class="jz_select">
                        <?php
                        // Ok, now let's get the listing of ALL genres so they can create a safe one
                        $genreArray = returnGenres();

    // Now let's sort it

    sort($genreArray);

    // Now let's loop throough them and display them all

    for ($i = 0, $iMax = count($genreArray); $i < $iMax; $i++) {
        echo '<option value="' . $genreArray[$i] . '">' . $genreArray[$i] . '</option>';
    } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td width="20%" align="right">

                </td>
                <td width="1%">&nbsp;</td>
                <td width="79%">
                    <br>
                    <input type="submit" value="<?php echo $word_create_new_genre; ?>" name="creategenre" class="jz_submit">
                </td>
            </tr>
        </table>
    </form>
    <br><br>
    <?php
}

// This function will go out and auto download the version of Jinzora they ask for
// Added 3.11.04 by Ross Carlson
function downloadUpdate($type)
{
    global $web_root, $root_dir;

    echo 'Opening the Jinzora site for download...';

    flushDisplay();

    // Ok, let's open the file

    if (@fsockopen('www.jinzora.org', 80, $errno, $errstr, 5)) {
        echo '<font color=green>Success!</font><br><br>';

        // Let's set the file name

        $zipFile = $web_root . $root_dir . '/data/jinzora-update-tmp.zip';

        $contents = '';

        $handle = fopen('http://www.jinzora.org/download/jinzora-auto.zip', 'rb');

        while (!feof($handle)) {
            $contents .= fread($handle, 1024);
        }

        fclose($handle);

        // Now let's write out the new zip file

        $fileData = fopen($zipFile, 'wb');

        fwrite($fileData, $contents);

        fclose($fileData);

        echo 'Extracting Zip file into directories...';

        flushDisplay();

        // Ok, now we've got the file downloaded, all we need to do is extract it

        require __DIR__ . '/pclzip.lib.php';

        $archive = new PclZip($zipFile);

        if ($archive->extract($web_root . $root_dir . '/data/temp', '')) {
            echo '<font color=green>Success!</font><br><br>';
        } else {
            echo '<font color=red>Error!</font><br>';

            exit();
        }

        //Now let's kill the source file

        echo 'Removing Temporary File...';

        flushDisplay();

        if (unlink($zipFile)) {
            echo '<font color=green>Success!</font><br><br>';
        } else {
            echo '<font color=red>Error!</font><br>';

            exit();
        }

        echo 'Refreshing and beginning installer...';

        flushDisplay();
    } else {
        echo '<font color=red>Error!</font><br>';

        exit();
    }

    exit();

    sleep(1);
}

// This function checks the Jinzora site for updates
function checkUpdates()
{
    global $jinzora_url, $word_auto_update, $word_auto_update_beta, $cms_mode, $version, $this_page, $url_seperator;

    if ('false' != $cms_mode) {
        include 'settings.php';

        include 'system.php';
    }

    // First let's connect to the jinzora site to see if the update is there

    // Code provided by Joel Wampler, thanks Joel!!!

    $searchURL = $jinzora_url . '/modules.php?op=modload&name=Changelog&file=index&checkforupdate=yes';

    $rstatus = @fopen($searchURL, 'rb');

    if (!$rstatus) {
        $relstat1 = "<FONT color=\"red\">Sorry, there was an error talking to $jinzora_url </FONT>";
    } else {
        while (!feof($rstatus)) {
            $line = fgets($rstatus, 1024);
        }
    }

    fclose($rstatus);

    // Now let's parse out the different versions

    $versions = explode('---', $line);

    // Now let's look at the contents to see what we got back and tell them

    echo '<center>You are currently running version: ' . $version . '<br><br>';

    echo 'The latest released version is: ' . $versions[0] . '<br>';

    echo 'The latest test release is: ' . $versions[1] . '<br><br>';

    echo 'To download updates please visit <a href=http://www.jinzora.org/download>Jinzora Downloads</a><br><br>';

    if ($version == $versions[1]) {
        echo 'You are running the latest beta version, thanks for helping us test!<br><br><br>';
    }

    if ($version == $versions[0]) {
        echo 'You are running the latest release version, only upgrade if you are testing or having problems...<br><br><br>';
    }

    $off = true;

    if (false === $off) {
        ?>
        <a title="<?php echo $word_auto_update; ?>" href="<?php echo $this_page . $url_seperator . 'ptype=tools&action=autoupdate&updatetype=release'; ?>"><?php echo $word_auto_update; ?></a> |
        <a title="<?php echo $word_auto_update_beta; ?>" href="<?php echo $this_page . $url_seperator . 'ptype=tools&action=autoupdate&updatetype=beta'; ?>"><?php echo $word_auto_update_beta; ?></a></center><br><br><br>
        <?php
        echo '<br>';
    }
}

// This function send the support email
function sendTechSupport()
{
    global $jinzora_url, $word_auto_update, $word_auto_update_beta, $cms_mode, $this_site, $web_root, $root_dir;

    if ('false' != $cms_mode) {
        include 'settings.php';

        include 'system.php';
    }

    echo '<center><br>A full dump of information was just sent to techsupport, thanks!</center><br>';

    // Let's start off

    $contents = 'Full tech dump from: ' . $this_site . '<br>';

    // Let's read the settings file into a variable

    $filename = $web_root . $root_dir . '/settings.php';

    $handle = fopen($filename, 'rb');

    $contents .= fread($handle, filesize($filename));

    fclose($handle);

    // Now let's strip off the <?PHP stuff

    $contents = str_replace('<?php', '', $contents);

    $contents = str_replace('?>', '', $contents);

    // Now let's convert the LN's to BR

    $contents = nl2br($contents) . '<br><br>phpInfo Dump<br><br>';

    // Let's open the techsupport page and read it into a variable

    $site = str_replace('http://', '', $this_site);

    $path = str_replace('index.php?', 'techsupport.php', $this_page . $url_seperator);

    $fp = fsockopen($site, 80, $errno, $errstr, 5);

    $path = ($path);

    fwrite($fp, "GET $path HTTP/1.1\n");

    fwrite($fp, "Host: $host\n");

    fwrite($fp, "Content-type: application/x-www-form-urlencoded\n");

    fwrite($fp, 'Content-length: ' . mb_strlen($data) . "\n");

    fwrite($fp, "Connection: close\n\n");

    while (!feof($fp)) {
        $contents .= fgets($fp, 128);
    }

    fclose($fp);

    // Now let's send the message

    $headers = "MIME-Version: 1.0\r\n";

    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

    $headers .= 'From: Jinzora User at: ' . mb_substr($this_site, 7, mb_strlen($this_site)) . "\r\n";

    // Now let's send it

    mail('jinzora@jasbone.com', 'Tech Support Email', $contents, $headers);
}

/* This function reads the directory size */
function getSize($theDir)
{
    $tot = 0;

    //echo 'Dir: ' . $theDir . '<br>';

    $dir = dir($theDir);

    while ($entry = $dir->read()) {
        if ('.' == $entry || '..' == $entry) {
            continue;
        }

        $entry = $theDir . '/' . $entry;

        if (is_file($entry)) {
            if (preg_match("/\.(mp3)$/i", $entry)) {
                $tot += round((filesize($entry) / 1024) / 1020, 0);

                //echo filesize($entry). "<br>";
            }

            //echo "Entry: $entry (". filesize($entry) ." bytes)<br>";
        } else {
            $tot += getSize($entry);
        }
    }

    $dir->close();

    return $tot;
}

function startShoutcast()
{
    global $web_root, $root_dir;

    session_write_close();

    exec($web_root . $root_dir . '/shoutcast/start.sh > /dev/null 2>&1 &');

    echo '<br><center>Server Start command sent...</center><br><br>';

    sleep(5);
}

function stopShoutcast()
{
    exec('killall sc_serv > /dev/null 2>&1 &');

    exec('killall sc_trans_linux > /dev/null 2>&1 &');

    echo '<br><center>Server Stop command sent...</center><br><br>';

    sleep(5);
}

function userManager()
{
    global $web_root, $root_dir, $media_dir, $this_page, $this_pgm, $word_user_manager, $word_pleasechoose, $word_username, $word_access_level, $word_go_button, $word_update_successful, $jinzora_temp_dir, $word_add_user, $word_delete, $word_user_manager, $this_pgm, $word_update_failed, $url_seperator, $this_page, $prefix, $db, $user_prefix, $cms_type, $cms_mode, $word_password, $database;

    // Now let's see if they updated the user or not

    if (isset($_POST['updateuser']) or isset($_POST['adduser']) or isset($_POST['deleteuser'])) {
        // Ok, we need to update the user database...

        if (is_file($web_root . $root_dir . '/users.php')) {
            include $web_root . $root_dir . '/users.php';
        } else {
            $user_array = '';
        }

        // Now let's check to see if this user is in the database or not

        $userFound = 'no';

        for ($ctr = 0, $ctrMax = count($user_array); $ctr < $ctrMax; $ctr++) {
            if (mb_strtolower($user_array[$ctr][0]) == mb_strtolower($_POST['jz_user'])) {
                // Ok, we've got the user, but let's make sure we weren't deleting

                $userFound = 'yes';

                if (isset($_POST['deleteuser'])) {
                    $user_array[$ctr][0] = '';

                    $user_array[$ctr][1] = '';

                    $user_array[$ctr][2] = '';
                } else {
                    $user_array[$ctr][2] = $_POST['access_level'];

                    // Now let's see if we were changing the password or not

                    if ('oldpassword' != $_POST['password']) {
                        $user_array[$ctr][1] = md5($_POST['password']);
                    }
                }
            }
        }

        // Now if we didn't find them above we'll need to add them to the end

        if ('no' == $userFound) {
            // Ok, let's add them, we'll use time as the pass so it's random

            if (isset($_POST['password'])) {
                $pass = md5($_POST['password']);
            } else {
                $pass = time();
            }

            $temp_array = [count($user_array) + 1 => [$_POST['jz_user'], $pass, $_POST['access_level']]];

            $user_array = array_merge($temp_array, $user_array);
        }

        // Now let's make sure we don't have any blank entries

        $i = 0;

        for ($ctr = 0, $ctrMax = count($user_array); $ctr < $ctrMax; $ctr++) {
            if ('' != $user_array[$ctr][0]) {
                $finalArray[$i] = $user_array[$ctr];

                $i++;
            }
        }

        // Now let's create the new user database file

        $contents .= '<?php' . "\n";

        $contents .= '$user_array = array(';

        for ($ctr = 0, $ctrMax = count($finalArray); $ctr < $ctrMax; $ctr++) {
            $contents .= "'" . $ctr . "' => array('" . $finalArray[$ctr][0] . "','" . $finalArray[$ctr][1] . "','" . $finalArray[$ctr][2] . "')," . "\n";
        }

        $contents .= ');' . "\n";

        $contents .= '?>' . "\n";

        // Ok, now let's write the file

        if (is_writable($web_root . $root_dir . '/users.php')) {
            $handle = fopen($web_root . $root_dir . '/users.php', 'wb');

            fwrite($handle, $contents);

            fclose($handle);

            // Ok, let's tell them we updated

            echo '<br><center><strong>' . $word_update_successful . '</strong></center><br>';
        } else {
            echo '<br><center><strong>Update Failed!</strong><br>' . "It looks like the users file isn't writable, sorry...</center><br>";
        }
    } else {
        // Now let's get the action for this form

        $form_action = $this_page . $url_seperator . '&ptype=tools&action=usermanager';

        echo '<form action="' . $form_action . '" name="usermanagerform" method="post">';

        // Now let's open our table

        jzTableOpen('100', '', 'jz_footer_table', '%');

        jzTROpen();

        jzTDOpen('100', 'center', 'top', '', '3', '');

        echo '<br>' . '<strong>' . $this_pgm . ' ' . $word_user_manager . '</strong>' . '<br><br>';

        jzTDClose();

        jzTRClose();

        jzTROpen();

        jzTDOpen('45', 'right', 'top', '', '', '');

        echo $word_username;

        jzTDClose();

        jzTDOpen('1', 'right', 'top', '', '', '');

        echo '&nbsp;';

        jzTDClose();

        jzTDOpen('54', 'left', 'top', '', '', '%');

        // Let's make sure they didn't want to create a user

        if (!isset($_GET['create'])) {
            echo '<select name="jz_user" class="jz_select" onChange="form.submit();">';

            if (isset($_POST['jz_user'])) {
                echo '<option value="' . $_POST['jz_user'] . '">' . $_POST['jz_user'] . '</option>';
            } else {
                echo '<option value="">' . $word_pleasechoose . '</option>';
            }

            if ('true' == $cms_mode) {
                switch ($cms_type) {
                    case 'postnuke':
                        [$dbconn] = pnDBGetConn();
                        $pntable = pnDBGetTables();
                        $userscolumn = &$pntable['users_column'];
                        $userstable = $pntable['users'];
                        /* Figure out the uid for this uname */
                        $query = "SELECT $userscolumn[uid], $userscolumn[uname] FROM $userstable order by $userscolumn[uname]";
                        $result = $GLOBALS['xoopsDB']->queryF($query);
                        while (list($ID, $uname) = $GLOBALS['xoopsDB']->fetchRow($result)) {
                            echo '<option value="' . $uname . '">' . $uname . '</option>';
                        }
                        break;
                    case 'phpnuke':
                        $sql = 'SELECT user_id, username FROM ' . $prefix . '_users';
                        $result = $db->sql_query($sql);
                        while (false !== ($row = $db->sql_fetchrow($result))) {
                            echo '<option value="' . $row[1] . '">' . $row[1] . '</option>';
                        }
                        break;
                    case 'cpgnuke':
                        $sql = 'SELECT user_id, username FROM ' . $prefix . '_users';
                        $result = $db->sql_query($sql);
                        while (false !== ($row = $db->sql_fetchrow($result))) {
                            echo '<option value="' . $row[1] . '">' . $row[1] . '</option>';
                        }
                        break;
                    case 'nsnnuke':
                        $sql = 'SELECT user_id, username FROM ' . $prefix . 'a_users';
                        $result = $db->sql_query($sql);
                        while (false !== ($row = $db->sql_fetchrow($result))) {
                            echo '<option value="' . $row[1] . '">' . $row[1] . '</option>';
                        }
                        break;
                    case 'mambo':
                        $database->setQuery('SELECT * FROM #__users');
                        $user_array = $database->loadObjectList();
                        for ($ctr = 0, $ctrMax = count($user_array); $ctr < $ctrMax; $ctr++) {
                            echo '<option value="' . $user_array[$ctr]->username . '">' . $user_array[$ctr]->username . '</option>';
                        }
                        break;
                    case 'mdpro':
                        [$dbconn] = pnDBGetConn();
                        $pntable = pnDBGetTables();
                        $userscolumn = &$pntable['users_column'];
                        $userstable = $pntable['users'];
                        /* Figure out the uid for this uname */
                        $query = "SELECT $userscolumn[uid], $userscolumn[uname] FROM $userstable order by $userscolumn[uname]";
                        $result = $GLOBALS['xoopsDB']->queryF($query);
                        while (list($ID, $uname) = $GLOBALS['xoopsDB']->fetchRow($result)) {
                            echo '<option value="' . $uname . '">' . $uname . '</option>';
                        }
                        break;
                }
            } else {
                // Let's include the password database and get the info from it

                require_once $web_root . $root_dir . '/users.php';

                // Now let's create a new array with just the user names

                for ($ctr = 0, $ctrMax = count($user_array); $ctr < $ctrMax; $ctr++) {
                    $nameArray[] = mb_strtolower($user_array[$ctr][0]);
                }

                // Now let's sort it

                sort($nameArray);

                // Now let's loop through the array

                for ($ctr = 0, $ctrMax = count($nameArray); $ctr < $ctrMax; $ctr++) {
                    echo '<option value="' . $nameArray[$ctr] . '">' . $nameArray[$ctr] . '</option>';
                }
            }

            echo '</select>';

            // Let's let them add a user if we aren't in CMS mode

            if ('false' == $cms_mode) {
                echo ' - <a href="index.php?ptype=tools&action=usermanager&create=true">create user</a>';
            }
        } else {
            // Ok, they wanted to add a user so let's show them the box

            echo '<input type="text" name="jz_user" class="jz_input">';
        }

        jzTDClose();

        jzTRClose();

        if (isset($_GET['create'])) {
            jzTROpen();

            jzTDOpen('45', 'right', 'top', '', '', '%');

            echo $word_password;

            jzTDClose();

            jzTDOpen('1', 'right', 'top', '', '', '%');

            echo '&nbsp;';

            jzTDClose();

            jzTDOpen('54', 'left', 'top', '', '', '%');

            echo '<input type="password" class="jz_input" name="password"><br>'
                 . '<select name="access_level" class="jz_select">'
                 . '<option value="viewonly">viewonly</option>'
                 . '<option value="lofi">Lo-Fi</option>'
                 . '<option value="user">user</option>'
                 . '<option value="poweruser">poweruser</option>'
                 . '<option value="admin">admin</option>'
                 . '</select><br>'
                 . '<input type="submit" class="jz_submit" name="adduser" value="'
                 . $word_add_user
                 . '">';

            jzTDClose();

            jzTRClose();
        }

        // Now let's see if they've submited the form or not

        if (isset($_POST['jz_user'])) {
            if ('false' == $cms_mode) {
                jzTROpen();

                jzTDOpen('45', 'right', 'top', '', '', '%');

                echo $word_password;

                jzTDClose();

                jzTDOpen('1', 'right', 'top', '', '', '%');

                echo '&nbsp;';

                jzTDClose();

                jzTDOpen('54', 'left', 'top', '', '', '%');

                echo '<input type="password" name="password" class="jz_input" value="oldpassword"><br>';

                jzTDClose();

                jzTRClose();
            }

            jzTROpen();

            jzTDOpen('45', 'right', 'top', '', '', '%');

            echo $word_access_level;

            jzTDClose();

            jzTDOpen('1', 'right', 'top', '', '', '%');

            echo '&nbsp;';

            jzTDClose();

            jzTDOpen('54', 'left', 'top', '', '', '%');

            echo '<select name="access_level" class="jz_select">';

            // Now let's get their access level

            require_once $web_root . $root_dir . '/users.php';

            for ($ctr = 0, $ctrMax = count($user_array); $ctr < $ctrMax; $ctr++) {
                // Let's find the right user

                if (mb_strtolower($user_array[$ctr][0]) == mb_strtolower($_POST['jz_user'])) {
                    echo '<option value="' . $user_array[$ctr][2] . '">' . $user_array[$ctr][2] . '</option>';
                }
            }

            echo '<option value="viewonly">viewonly</option>' . '<option value="user">user</option>' . '<option value="poweruser">poweruser</option>' . '<option value="admin">admin</option>' . '</select>';

            jzTDClose();

            jzTRClose();

            jzTROpen();

            jzTDOpen('45', 'right', 'top', '', '', '%');

            jzTDClose();

            jzTDOpen('1', 'right', 'top', '', '', '%');

            echo '&nbsp;';

            jzTDClose();

            jzTDOpen('54', 'left', 'top', '', '', '%');

            echo '<input type="submit" class="jz_submit" name="updateuser" value="' . $word_go_button . '"> ' . '<input type="submit" class="jz_submit" name="deleteuser" value="' . $word_delete . '">';

            jzTDClose();

            jzTRClose();

            // This closes the IF from above
        }

        jzTROpen();

        jzTDOpen('45', 'right', 'top', '', '', '%');

        jzTDClose();

        jzTDOpen('1', 'right', 'top', '', '', '%');

        echo '&nbsp;';

        jzTDClose();

        jzTDOpen('54', 'left', 'top', '', '', '%');

        echo '<br>';

        jzTDClose();

        jzTRClose();

        jzTableClose();

        echo '</form>';
    } // This closes the big IF from above

    echo '<br>';
}

// This function will return ALL files everywhere in the system
function readAllFiles($dir)
{
    global $track_num_seperator;

    if ('false' != $cms_mode) {
        include 'settings.php';

        include 'system.php';
    }

    $d = dir($dir);

    while ($entry = $d->read()) {
        if ('.' == $entry || '..' == $entry) {
            continue;
        }

        if (is_file($dir . '/' . $entry)) {
            if (preg_match("/\.(mp3)$/i", $entry)) {
                // Now let's figure out the new file name

                $newFile = $track . ' - ' . $entry;

                // Now let's see if the first 2 characters of the old file are numeric or not

                if (is_numeric(mb_substr($entry, 0, 2)) and '' == mb_substr($entry, 2, 1)) {
                    // Now let's rename it!

                    echo($entry . '----' . $newFile . '<br>');
                }
            }
        } else {
            readAllFiles($dir . '/' . $entry);
        }
    }

    $d->close();
}

?>

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
* Code Purpose: This page contains all the "playlist" related functions
* Created: 9.24.03 by Ross Carlson
*
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

// First we'll need to see if they accessed this directly to generate a playlist
if (isset($_GET['d'])) {
    // Ok, we'll need to include some stuff

    require_once __DIR__ . '/settings.php';

    require_once __DIR__ . '/system.php';

    require_once __DIR__ . '/general.php';

    // Now let's see if they wanted the embedded player in slim mode

    if (isset($_GET['ep'])) {
        if ('1' == $_GET['ep']) {
            $play_in_wmp_only = true;
        }
    }

    if (isset($_GET['slim'])) {
        $slim = 'true';
    }

    // Now let's generate the playlist

    quickplay();

    exit();
}

// This function removes items from a playlist
function deleteFromPlaylist($listName)
{
    global $web_root, $root_dir, $playlist_ext;

    // Let's see if they wanted to open the session playlist for editing or not

    if ('sessionplaylist' == $listName) {
        $contents = $_SESSION['sessionPlaylist'];
    } else {
        // Ok, now we need to read the old list into an array first

        $filename = $web_root . $root_dir . '/data/' . $listName;

        $handle = fopen($filename, 'rb');

        $contents = fread($handle, filesize($filename));

        fclose($handle);
    }

    // Now let's create an array out of that

    $contArray = explode("\n", $contents);

    // Ok, now let's go through this array and remove any blank items

    $ctr = 0;

    $ctr2 = 0;

    while (count($contArray) > $ctr) {
        if ('' != $contArray[$ctr]) {
            $oldArray[$ctr2] = $contArray[$ctr];

            $ctr2++;
        }

        $ctr++;
    }

    // Ok, now we have that array, we need to get an array with what they wanted to kill

    $ctr = 0;

    $ctr2 = 0;

    $numBoxes = $_POST['numboxes'];

    while ($numBoxes > $ctr) {
        // Now let's see what they selected

        if ('' != $_POST['track-' . $ctr]) {
            // Ok, now we've got the tracks, let's create an array for them

            // First we need to make sure that there are no double slashes, so we'll loop through and kill them

            $trackPath = $_POST['track-' . $ctr];

            while (0 != mb_strpos($trackPath, '//')) {
                $trackPath = str_replace('//', '/', $trackPath);
            }

            $delArray[$ctr2] = $trackPath;

            $ctr2 += 1;
        }

        $ctr += 1;
    }

    // Now let's remove stuff from the original array so we can rewrite the file

    $finalArray = array_values(array_diff($oldArray, $delArray));

    // Let's again make sure they aren't editing the session playlist or not

    if ('sessionplaylist' == $listName) {
        // First let's kill the old session list

        $_SESSION['sessionPlaylist'] = '';

        $ctr = 0;

        while (count($finalArray) > $ctr) {
            $_SESSION['sessionPlaylist'] .= $finalArray[$ctr] . "\n";

            $ctr += 1;
        }
    } else {
        // Let's open the file for writing

        $handle = fopen($filename, 'wb');

        $ctr = 0;

        while (count($finalArray) > $ctr) {
            fwrite($handle, $finalArray[$ctr] . "\n");

            $ctr += 1;
        }

        // Now let's close the file

        fclose($handle);
    }

    // Now let's return to where we were...

    displayPlaylists($listName);

    exit();
}

// This function deletes a playlist
function deletePlaylist($playlist)
{
    global $web_root, $root_dir;

    // Let's see if it's the session playlist or not

    if ('sessionplaylist' == $playlist) {
        $_SESSION['sessionPlaylist'] = '';
    } else {
        // Ok, they wanted to kill it, so let's kill it!

        unlink($web_root . $root_dir . '/data/' . $playlist);
    }
}

// This function let's the user play a Genre, Artist, Album, or song
function quickplay()
{
    global $playlist_dir, $this_site, $mp3_dir, $audio_types, $root_dir, $media_dir, $video_types, $playlist_ext, $single_file_playlist, $web_root, $temp_zip_dir, $jinzora_temp_dir, $slash_var, $jukebox_player_path, $jukebox_player_path_end, $jukebox, $track_plays, $this_site, $cms_type, $video_mimes, $use_ext_playlists, $play_in_wmp_only, $slim, $play_in_java_only, $allow_resample, $resample_rate, $path_to_lame;

    // Now let's load up our simple ID3 class

    require_once __DIR__ . '/id3classes/simple.id3.php';

    // Now let's see if we need to change the jukebox variable

    if (is_file($web_root . $root_dir . '/temp/pbtype.status')) {
        $filename = $web_root . $root_dir . '/temp/pbtype.status';

        $handle = fopen($filename, 'rb');

        $pbtype = fread($handle, filesize($filename));

        fclose($handle);

        if ('stream' == $pbtype) {
            $jukebox = 'false';
        }
    }

    // Let's reset the maximum executution time, as this may take a while....

    ini_set('max_execution_time', '600');

    // Let's set the base for the tracks and a counter for later

    $base_url = $this_site;

    $ctr = 0;

    // Let's clean up any variables that we would use

    $info = $_GET['info'];

    if (!isset($_GET['qptype'])) {
        $_GET['qptype'] = '';
    }

    // Now let's read all the files from that point down IF it's not a single file

    if ('song' != $_GET['qptype']) {
        $readCtr = 0;

        $fileArray = str_replace($web_root . $root_dir . $media_dir . '/', '', readAllDirs($web_root . $root_dir . $media_dir . '/' . jzstripslashes($info), $readCtr, $mainArray));
    } else {
        // Ok, let's see if they want to resample

        if ('true' == $allow_resample and !mb_stristr($info, '.lofi.') and '' != $_GET['r']) {
            // First, let's see if we need to clean up any files in the temp dir first

            $retArray = readDirInfo($web_root . $root_dir . '/temp', 'file');

            $c = 0;

            for ($i = 0, $iMax = count($retArray); $i < $iMax; $i++) {
                if (mb_stristr($retArray[$i], '.lofi.mp3')) {
                    $c++;
                }
            }

            // Did we find too many?

            if ($c > 5) {
                // Ok, let's kill the first 5

                for ($i = 0; $i < 5; $i++) {
                    @unlink($web_root . $root_dir . '/temp/' . $retArray[$i]);
                }
            }

            // Ok, let's resample it and create the temp file

            $tempArray = explode('/', $info);

            $fileInfo = pathinfo($info);

            $fileExt = $fileInfo['extension'];

            $temp_file_name = str_replace('.' . $fileExt, '', $tempArray[count($tempArray) - 1]) . '-' . time() . '.lofi.mp3';

            // Now let's re-encode the file into a temp file

            exec($path_to_lame . ' -b ' . $_GET['r'] . ' "' . $web_root . $root_dir . $media_dir . '/' . $_GET['info'] . '" "' . $web_root . $root_dir . '/temp/' . $temp_file_name . '"');

            // Let's set the header

            header('Content-type: audio/mpegurl');

            header('Content-Disposition: inline; filename=resample.m3u');

            header('Cache-control: private');

            // Let's send the playlist with the encoded file in the path

            echo $this_site . $root_dir . '/temp/' . rawurlencode($temp_file_name);

            exit();
        }  

        // Let's get the tracks file extension for later

        $fileInfo = pathinfo($info);

        $fileExt = $fileInfo['extension'];

        $fileArray[0] = urldecode($info);

        if ($play_in_wmp_only) {
            $singleFile = $web_root . $root_dir . $media_dir . '/' . urldecode($info);

            // Now let's make sure that file exists first

            if (is_file($singleFile)) {
                // Now let's grab the name of the track for later

                if (preg_match("/\.($video_types)$/i", $fileArray[0])) {
                    $getID3 = new getID3();

                    $fileInfo = $getID3->analyze($singleFile);

                    getid3_lib::CopyTagsToComments($fileInfo);

                    if (!empty($fileInfo['video']['resolution_x'])) {
                        $width = $fileInfo['video']['resolution_x'] + 100;
                    }

                    if (!empty($fileInfo['video']['resolution_y'])) {
                        $height = $fileInfo['video']['resolution_y'] + 150;
                    }
                } else {
                    $id3 = new id3($singleFile, true);

                    $name = $id3->title . ' - ' . $id3->artist;

                    unset($id3);
                }
            }
        }
    }

    // Ok, now are we using a java web based player only?

    if ($play_in_java_only) {
        // Now now let's popup the wmp window if they aren't in SLIM

        if ($slim) {
            // Ok, now we need to send them back to the slim interface where they were, but

            // we need to pass the playlist back to the embedded player

            $return = base64_decode($_GET['return'], true);

            header('Location: ' . $return . '&embplay=' . $fileArray[0]);
        } else {
            ?>
            <SCRIPT LANGUAGE=JAVASCRIPT TYPE="TEXT/JAVASCRIPT"><!--\
						function popPlayWindow() {

                            var sw = screen.width;
                            var sh = screen.height;
                            var winOpt = "width=350,height=200,left=" + ((sw - 350) / 2) + ",top=" + ((sh - 200) / 2) + ",menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no";
                            thisWin = window.open("<?php echo $root_dir . '/mp3info.php?type=displayJava&track=' . $fileArray[0] . '&name=' . $name . '&width=350&height=200'; ?>", 'WMP', winOpt);
                            history.back();
                        }

                popPlayWindow();
                -->
            </SCRIPT>
            <?php
        }

        exit();
    }

    // Ok, now are we using a web based player only?

    if ($play_in_wmp_only) {
        // Now let's clean up the content

        $output_content = $this_site . $root_dir . $media_dir . '/' . $fileArray[0];

        // Now let's see if this is video or audio

        if (preg_match("/\.($audio_types)$/i", $fileArray[0])) {
            $width = '350';

            $height = '175';
        }

        // Now now let's popup the wmp window if they aren't in SLIM

        if ($slim) {
            // Ok, now we need to send them back to the slim interface where they were, but

            // we need to pass the playlist back to the embedded player

            $return = base64_decode($_GET['return'], true);

            header('Location: ' . $return . '&embplay=' . $output_content);
        } else {
            ?>
            <SCRIPT LANGUAGE=JAVASCRIPT TYPE="TEXT/JAVASCRIPT"><!--\
						function popPlayWindow() {

                            var sw = screen.width;
                            var sh = screen.height;
                            var winOpt = "width=<?php echo $width; ?>,height=<?php echo $height; ?>,left=" + ((sw - <?php echo $width; ?>) / 2) + ",top=" + ((sh - <?php echo $height; ?>) / 2) + ",menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no";
                            thisWin = window.open("<?php echo $root_dir . '/mp3info.php?type=displayWMA&track=' . $output_content . '&name=' . $name . '&width=' . $width . '&height=' . $height; ?>", 'WMP', winOpt);

                            //playlistpop = window.open("<?php echo $root_dir . '/mp3info.php?type=displayWMA&track=' . $output_content; ?>","playlistpop","toolbar=no,location=no,scrollbars=no,resizable=no,width=1,height=1,left=500,top=200")
                            history.back();
                        }

                popPlayWindow();
                -->
            </SCRIPT>
            <?php
        }

        //echo $output_content;

        exit();
    }

    // Let's see if they wanted a random shuffle here or not

    if ('random' == $_GET['style']) {
        shuffle($fileArray);
    }

    // Let's initalize the output variable

    $output_content = '';

    if (!isset($fileExt)) {
        $fileExt = '';
    }

    // If this is an M3U playlist lets make it pretty

    if ('m3u' == mb_strtolower($playlist_ext) and 'false' == $jukebox and 'true' == $use_ext_playlists and 'rm' != $fileExt) {
        $output_content .= '#EXTM3U' . "\n";
    }

    for ($ctr = 0, $ctrMax = count($fileArray); $ctr < $ctrMax; $ctr++) {
        if (preg_match("/\.($video_types)$/i", $fileArray[0])) {
            // Now let's let them play that one file

            $fileName = $this_site . str_replace('%2F', '/', rawurlencode(jzstripslashes('/' . $root_dir . $media_dir . '/' . $fileArray[$ctr])));

            $fileInfo = pathinfo($fileName);

            $fileExt = $fileInfo['extension'];

            $mime_type = '';

            // Now let's figure out the header type

            for ($c = 0, $cMax = count($video_mimes); $c < $cMax; $c++) {
                if ($fileExt == $video_mimes[$c][0]) {
                    $mime_type = $video_mimes[$c][1];
                }
            }

            // Now let's set the header if we needed to

            if ('' != $mime_type) {
                $data_file = jzstripslashes($web_root . $root_dir . $media_dir . '/' . $fileArray[$ctr]);

                $handle = fopen($data_file, 'rb');

                $file_content = fread($handle, filesize($data_file));

                fclose($handle);

                header('Content-type: ' . $mime_type);

                header('Content-Disposition: inline; filename=video.' . $fileExt);

                header('Cache-control: private');

                echo $file_content;
            } else {
                header('Location: ' . $fileName);
            }

            exit();
        }  

        // First let's clean up the content

        $path = str_replace(stripslashes($this_site . $mp3_dir) . '/', '', $fileArray[$ctr]);

        $path = str_replace('%2F', '/', rawurlencode(jzstripslashes($path)));

        // Now let's get the full path to the file so we can make the playlist pretty by reading the ID3 info from the file

        $filename = $web_root . $root_dir . $media_dir . '/' . $fileArray[$ctr];

        // Now let's see if it's a lofi or clip track, if it is we don't play it

        if ((mb_stristr($filename, '.lofi.') or mb_stristr($filename, '.clip.')) and '1' != $_GET['p']) {
            continue;
        }

        if ('false' == $jukebox) {
            // Now let's make sure they wanted extended playlists

            if ('true' == $use_ext_playlists and 'rm' != $fileExt) {
                // Now lets make sure that file exists

                if (is_file($filename)) {
                    // Let's grab the information from each file for the EXT3 playlist

                    $id3 = new id3($filename);

                    $length = '';

                    $name = '';

                    $artist = '';

                    $artist = $id3->artist;

                    $name = $id3->title;

                    $length = $id3->lengths;

                    $output_content .= '#EXTINF:' . $length . ',' . $artist . ' - ' . $name . "\n";

                    unset($id3);
                }
            }

            // Now we need to strip off the extra slashes...

            $path = jzstripslashes($path);

            // Now let's see if this has a corresponding rmdata file IF this is a .rm file

            if ('rm' == $fileExt) {
                $rmtimeArray = returnRMStartStop($web_root . $root_dir . '/data/tracks/' . returnFormatedFilename($fileArray[$ctr]) . '.rmdata');

                $append = '';

                if (0 != count($rmtimeArray)) {
                    $append = '?start=' . $rmtimeArray[0] . '&end=' . $rmtimeArray[1];
                }

                $output_content .= $this_site . $root_dir . $media_dir . '/' . $path . $append . "\n";
            } else {
                $output_content .= $this_site . $root_dir . $media_dir . '/' . $path . "\n";
            }
        } else {
            $content .= $web_root . $root_dir . $media_dir . '/' . urldecode($path) . "\n";
        }

        // Now let's write the hit tracker out, if they wanted to

        if ('true' == $track_plays) {
            // Ok, let's see if there is a tracker file for this song

            $file = str_replace('/', '---', jzstripslashes(urldecode($path))) . '.ctr';

            if ('---' == mb_substr($file, 0, 3)) {
                $file = mb_substr($file, 3, mb_strlen($file));
            }

            $fileName = $web_root . $root_dir . '/data/counter/' . $file;

            $hits = 0;

            if (!is_file($fileName)) {
                touch($fileName);
            } else {
                $handle = fopen($fileName, 'rb');

                $hitData = fread($handle, filesize($fileName));

                fclose($handle);

                // Now let's get the number

                $hits = mb_substr($hitData, 0, mb_strpos($hitData, '|'));
            }

            // Now let's increment the number of hits

            $hits++;

            $handle = fopen($fileName, 'wb');

            fwrite($handle, $hits . '|' . $_COOKIE['jz_user_name']);

            fclose($handle);

            // Now let's write this to the users last played tracking file

            $trackingFile = $web_root . $root_dir . '/data/users/' . $_COOKIE['jz_user_name'] . '.last';

            if (!is_file($trackingFile)) {
                touch($trackingFile);
            }

            $handle = fopen($trackingFile, 'wb');

            fwrite($handle, str_replace('/', '---', jzstripslashes(urldecode($path))));

            fclose($handle);
        }
    }

    if ('xmms' == $jukebox or 'winamp' == $jukebox) {
        require_once __DIR__ . '/jukebox.lib.php';

        // now we need to know what to control

        if ('xmms' == $jukebox) {
            // First lets see if we are adding this at the beginning

            $filename = $web_root . $root_dir . '/temp/barge.status';

            $handle = fopen($filename, 'rb');

            $pbWhere = trim(fread($handle, filesize($filename)));

            fclose($handle);

            if ('beginning' == $pbWhere) {
                // Ok, first we have to get the current playlist to add at the end of the new one

                $curList = controlXMMS('list filenames');

                $cur_found = false;

                for ($e = 0, $eMax = count($curList); $e < $eMax; $e++) {
                    if (!mb_stristr($curList[$e], 'is empty')) {
                        // Now let's figure out where we are

                        $cur_filename = trim(mb_substr($curList[$e], mb_strpos($curList[$e], '.') + 1, mb_strlen($curList[$e])));

                        if ($cur_found) {
                            $afterArray[] = $cur_filename;
                        } else {
                            $prevArray[] = $cur_filename;
                        }

                        if ('*' == mb_substr($curList[$e], 0, 1)) {
                            $cur_found = true;

                            $cur_track = mb_substr($curList[$e], 1, mb_strlen($curList[$e]));

                            $cur_track = trim(mb_substr($cur_track, 0, mb_strpos($cur_track, '.')));

                            $cur_track++;
                        }
                    }
                }

                // Now we need to combine the 3 items

                for ($e = 0, $eMax = count($prevArray); $e < $eMax; $e++) {
                    $preContent .= $prevArray[$e] . "\n";
                }

                for ($e = 0, $eMax = count($afterArray); $e < $eMax; $e++) {
                    $afterContent .= $afterArray[$e] . "\n";
                }

                $content = $preContent . $content . $afterContent;
            }

            // First we'll need to build our temp file

            $fileName = $web_root . $root_dir . $jinzora_temp_dir . '/jinzora-jukbox.pls.m3u';

            $handle = fopen($fileName, 'wb');

            fwrite($handle, $content);

            fclose($handle);

            // Now let's control XMMS

            if ('beginning' == $pbWhere) {
                controlXMMS('clear');
            }

            // Ok, now were going to send this playlist to XMMS

            controlXMMS('load "' . $fileName . '"');

            if ('beginning' == $pbWhere) {
                controlXMMS('jump ' . $cur_track);
            }

            // Let's take a quick pause...

            sleep(1);

            if ('playing' != $_SESSION['play_status']) {
                controlXMMS('play');
            }
        }

        if ('winamp' == $jukebox) {
            $status = '';

            while ('' == $status) {
                $status = controlWinamp('playfile');
            }

            $status = '';

            // Now let's see if we should start the jukebox IF it's not running

            $status = controlWinamp('isplaying');

            if ('0' == $status) {
                controlWinamp('play');
            }
        }

        // Now let' send them back to where they were

        header('Location: ' . base64_decode($_GET['return'], true) . '&clearpl=true');

        exit();
    }

    // Let's see if this is a video type or an audio type and output the appropriate header

    if (preg_match("/\.($audio_types)$/i", $fileArray[0]) or 'rm' == $fileExt) {
        // Now let's send the playlist

        echoPlaylist($output_content, $fileExt);

        exit;
    }  

    // Now let's clean up the file...

    $fileName = $root_dir . $media_dir . '/' . $fileArray[0];

    while (0 != mb_strpos($fileName, '//')) {
        $fileName = str_replace('//', '/', $fileName);
    }

    header('Location: ' . $fileName);

    exit();

    exit();
}

// This function generates the random playlist from the drop down boxes in the header
function generateRandom()
{
    global $web_root, $root_dir, $media_dir, $audio_types, $this_site;

    // Let's initalize some variables

    $final_ctr = 0;

    // Ok, now let's see what kind of random list they wanted

    switch ($_POST['random_play_type']) {
        case 'Songs': # Ok, they wanted some random songs
            // Now let's read EVERYTHING and create that session variable
            $mainArray = '';
            $readCtr = 0;
            readAllDirs($web_root . $root_dir . $media_dir, $readCtr, $mainArray);
            for ($ctr = 0, $ctrMax = count($mainArray); $ctr < $ctrMax; $ctr++) {
                if ('' != $mainArray[$ctr]) {
                    $finalArray[$final_ctr] = str_replace('/', '----', str_replace($web_root . $root_dir . $media_dir, '', $mainArray[$ctr]));

                    $final_ctr++;
                }
            }

            // Now let's shuffle it
            shuffle($finalArray);

            // Now let's get jut the entries we wanted
            $ctr2 = 0;
            for ($ctr = 0, $ctrMax = count($finalArray); $ctr < $ctrMax; $ctr++) {
                if ($ctr < $_POST['random_play_number']) {
                    $songArray[$ctr2] = $this_site . $root_dir . $media_dir . '/' . str_replace('----', '/', $finalArray[$ctr]);

                    $ctr2 += 1;
                }
            }

            // Now let's create the playlist
            createPlayList($songArray);
            break;
        case 'Albums': # Ok, they wanted some random Albums
            // Ok, let's get some songs for them!
            // First let's read the first directory
            $genreArray = readDirInfo($web_root . $root_dir . $media_dir, 'dir');
            // Now let's loop through that and read all the other dirs
            $ctr = 0;
            while (count($genreArray) > $ctr) {
                $artistArray = readDirInfo($web_root . $root_dir . $media_dir . '/' . $genreArray[$ctr], 'dir');

                // Now let's loop through that

                $ctr2 = 0;

                while (count($artistArray) > $ctr2) {
                    $albumArray = readDirInfo($web_root . $root_dir . $media_dir . '/' . $genreArray[$ctr] . '/' . $artistArray[$ctr2], 'dir');

                    // Now let's loop through that

                    $ctr3 = 0;

                    while (count($albumArray) > $ctr3) {
                        $finalArray[$final_ctr] = $root_dir . $media_dir . '/' . $genreArray[$ctr] . '/' . $artistArray[$ctr2] . '/' . $albumArray[$ctr3];

                        $final_ctr += 1;

                        $ctr3 += 1;
                    }

                    $ctr2 += 1;
                }

                $ctr += 1;
            }
            // Ok, now that we have our albums, we'll need the tracks in those albums
            // First let's shuffle the array
            shuffle($finalArray);

            // Now let's create a temp array
            $tempArray = $finalArray;

            // Now let's loop throught the number of albums that they wanted and get the tracks
            $ctr = 0;
            $final_ctr = 0;
            while (count($tempArray) > $ctr) {
                // Let's make sure we haven't looked at too many albums

                if ($ctr < $_POST['random_play_number']) {
                    // Now let's get the tracks for these dirs

                    $retArray = readDirInfo($web_root . $tempArray[$ctr], 'file');

                    $ctr1 = 0;

                    // Now let's loop through that array reading the tracks as we go

                    while (count($retArray) > $ctr1) {
                        // Let's make sure it's an audio file

                        if (preg_match("/\.($audio_types)$/i", $retArray[$ctr1])) {
                            $albumArray[$final_ctr] = $this_site . $tempArray[$ctr] . '/' . $retArray[$ctr1];

                            $final_ctr += 1;
                        }

                        $ctr1 += 1;
                    }
                }

                $ctr += 1;
            }

            // Now let's create the playlist
            createPlayList($albumArray);
            break;
        case 'Artists': # Ok, they wanted some random Artists
            // Ok, let's get some songs for them!
            // First let's read the first directory
            $genreArray = readDirInfo($web_root . $root_dir . $media_dir, 'dir');
            // Now let's loop through that and read all the other dirs
            $ctr = 0;
            while (count($genreArray) > $ctr) {
                $artistArray = readDirInfo($web_root . $root_dir . $media_dir . '/' . $genreArray[$ctr], 'dir');

                // Now let's loop through that

                $ctr2 = 0;

                while (count($artistArray) > $ctr2) {
                    $finalArray[$final_ctr] = $root_dir . $media_dir . '/' . $genreArray[$ctr] . '/' . $artistArray[$ctr2];

                    $final_ctr += 1;

                    $ctr2 += 1;
                }

                $ctr += 1;
            }
            // Ok, now that we have our albums, we'll need the tracks in those albums
            // First let's shuffle the array
            shuffle($finalArray);

            // Now let's create a temp array
            $tempArray = $finalArray;

            // Now let's loop throught the number of artists that they wanted and get the tracks
            $ctr = 0;
            $ctr3 = 0;
            $final_ctr = 0;
            while (count($tempArray) > $ctr) {
                // Let's make sure we haven't looked at too many artists

                if ($ctr < $_POST['random_play_number']) {
                    // Now let's get the albums and tracks for these dirs

                    $albumArray = readDirInfo($web_root . $tempArray[$ctr], 'dir');

                    $ctr1 = 0;

                    // Now let's loop through that array reading the albums as we go

                    while (count($albumArray) > $ctr1) {
                        $trackArray = readDirInfo($web_root . $tempArray[$ctr] . '/' . $albumArray[$ctr1], 'file');

                        $ctr2 = 0;

                        while (count($trackArray) > $ctr2) {
                            // Let's make sure it's an audio file

                            if (preg_match("/\.($audio_types)$/i", $trackArray[$ctr2])) {
                                // Let's use our little function to fix the special characters

                                $songArray[$ctr3] = $this_site . $tempArray[$ctr] . '/' . $albumArray[$ctr1] . '/' . $trackArray[$ctr2];

                                $ctr3 += 1;
                            }

                            $ctr2 += 1;
                        }

                        $ctr1 += 1;
                    }
                }

                $ctr += 1;
            }

            // Now let's create the playlist
            createPlayList($songArray);

            break;
        case 'Genres': # Ok, they wanted some random Genres
            // Ok, let's get some songs for them!
            // First let's read the first directory
            $genreArray = readDirInfo($web_root . $root_dir . $media_dir, 'dir');
            // Now let's loop through that and read all the other dirs
            $ctr = 0;
            $final_ctr = 0;
            while (count($genreArray) > $ctr) {
                $finalArray[$final_ctr] = $root_dir . $media_dir . '/' . $genreArray[$ctr] . '/' . $artistArray[$ctr2];

                $final_ctr += 1;

                $ctr += 1;
            }
            // Ok, now that we have our albums, we'll need the tracks in those albums
            // First let's shuffle the array
            shuffle($finalArray);

            // Now let's create a temp array
            $tempArray = $finalArray;

            // Now let's loop throught the number of albums that they wanted and get the tracks
            $ctr = 0;
            $ctr3 = 0;
            $final_ctr = 0;
            while (count($tempArray) > $ctr) {
                // Let's make sure we haven't looked at too many artists

                if ($ctr < $_POST['random_play_number']) {
                    // Now let's get the albums and tracks for these dirs

                    $artistArray = readDirInfo($web_root . $tempArray[$ctr], 'dir');

                    $ctr1 = 0;

                    // Now let's loop through that array reading the albums as we go

                    while (count($artistArray) > $ctr1) {
                        $albumArray = readDirInfo($web_root . $tempArray[$ctr] . '/' . $artistArray[$ctr1], 'dir');

                        $ctr2 = 0;

                        while (count($albumArray) > $ctr2) {
                            // Let's make sure it's an audio file

                            $trackArray = readDirInfo($web_root . $tempArray[$ctr] . '/' . $artistArray[$ctr1] . '/' . $albumArray[$ctr2], 'file');

                            $ctr3 = 0;

                            while (count($trackArray) > $ctr3) {
                                // Let's make sure it's an audio file

                                if (preg_match("/\.($audio_types)$/i", $trackArray[$ctr3])) {
                                    $songArray[$final_ctr] = $this_site . $tempArray[$ctr] . '/' . $artistArray[$ctr1] . '/' . $albumArray[$ctr2] . '/' . $trackArray[$ctr3];

                                    $final_ctr += 1;
                                }

                                $ctr3 += 1;
                            }

                            $ctr2 += 1;
                        }

                        $ctr1 += 1;
                    }
                }

                $ctr += 1;
            }

            // Now let's create the playlist
            createPlayList($songArray);

            break;
    }
}

function echoPlaylist($content, $fileExt = 'm3u')
{
    global $playlist_ext, $web_root, $root_dir, $media_dir, $audio_mimes;

    // Now let's look at our audio mimetypes array to see how to set the header

    for ($c = 0, $cMax = count($audio_mimes); $c < $cMax; $c++) {
        if ($audio_mimes[$c][0] == $fileExt) {
            $con_type = $audio_mimes[$c][1];

            $playlist_ext = $audio_mimes[$c][2];
        }
    }

    // Now let's make sure we got a type, and if not use the default one

    if (!isset($con_type)) {
        $con_type = $audio_mimes[0][1];

        $playlist_ext = $audio_mimes[0][2];
    }

    // Now let's set the proper header

    header('Accept-Range: bytes');

    header('Content-Length: ' . mb_strlen($content));

    header('Content-Type: ' . $con_type);

    header('Content-Disposition: inline; filename=playlist.' . $playlist_ext);

    header('Cache-control: private'); #IE seems to need this.

    echo $content;
}

// This function actually creates the playlist
function createPlayList($listArray)
{
    global $playlist_ext, $web_root, $root_dir, $media_dir, $this_site, $use_ext_playlists, $jukebox, $jinzora_temp_dir;

    // Let's start our variable

    $content = '';

    // If this is an M3U playlist lets make it pretty

    if ('m3u' == mb_strtolower($playlist_ext) and 'true' == $use_ext_playlists and 'false' == $jukebox) {
        $content .= '#EXTM3U';
    }

    // Now let's load up our simple ID3 class

    require_once __DIR__ . '/id3classes/simple.id3.php';

    // Now let's output our playlist

    for ($ctr = 0, $ctrMax = count($listArray); $ctr < $ctrMax; $ctr++) {
        // Now let's get the full path to the file so we can make the playlist pretty by reading the ID3 info from the file

        $filename = str_replace($this_site, $web_root, urldecode($listArray[$ctr]));

        if ('m3u' == mb_strtolower($playlist_ext) and 'true' == $use_ext_playlists and 'false' == $jukebox) {
            $id3 = new id3($filename, true);

            $length = '';

            $name = '';

            $artist = '';

            $artists = $id3->artist;

            $name = $id3->title;

            $length = $id3->lengths;

            $output_content .= '#EXTINF:' . $length . ',' . $artists . ' - ' . $name . "\n";

            unset($id3);
        }

        if ('' == $name) {
            // Let's explode the filename so we can get this

            $dataArray = explode('/', $filename);

            $name = $dataArray[count($dataArray) - 1];
        }

        if ('' == $artist) {
            // Let's explode the filename so we can get this

            $dataArray = explode('/', $filename);

            $artist = $dataArray[count($dataArray) - 3];
        }

        // Let's be sure they wanted extended playlists

        if ('m3u' == mb_strtolower($playlist_ext) and 'true' == $use_ext_playlists and 'false' == $jukebox) {
            $content .= '#EXTINF:' . $length . ',' . $artists . ' - ' . $name . "\n";
        }

        if ('false' == $jukebox) {
            $content .= str_replace('%3A/', '://', str_replace('%2F', '/', rawurlencode(jzstripslashes($listArray[$ctr])))) . "\n";
        } else {
            $content .= $web_root . jzstripslashes(str_replace($this_site, '', $listArray[$ctr])) . "\n";
        }
    }

    // Now let's see if we are in jukebox mode or not

    if ('false' == $jukebox) {
        // Now let's send the playlist

        echoPlaylist($content);
    } else {
        $fileName = $web_root . $root_dir . $jinzora_temp_dir . '/jinzora-jukbox.pls.m3u';

        $handle = fopen($fileName, 'wb');

        fwrite($handle, $content);

        fclose($handle);

        require_once __DIR__ . '/jukebox.lib.php';

        // now we need to know what to control

        if ('xmms' == $jukebox) {
            // Ok, now were going to send this playlist to XMMS

            controlXMMS('load "' . $fileName . '"');

            if ('playing' != $_SESSION['play_status']) {
                controlXMMS('play');
            }
        }

        if ('winamp' == $jukebox) {
            $status = '';

            while ('' == $status) {
                $status = controlWinamp('playfile');
            }

            $status = '';

            // Now let's see if we should start the jukebox IF it's not running

            $status = controlWinamp('isplaying');

            if ('0' == $status) {
                controlWinamp('play');
            }
        }

        // Now let' send them back to where they were ?>
        <SCRIPT LANGUAGE=JAVASCRIPT TYPE="TEXT/JAVASCRIPT"><!--
            history.back();
            -->
        </SCRIPT>
        <?php
        exit();
    }

    exit();
}

// This function will play the selected tracks that they choose
function playSelected($random = false)
{
    global $this_site, $web_root, $root_dir, $audio_types;

    // Ok, first we need to loop through what they selected

    $numBoxes = $_POST['numboxes'];

    $ctr = 0;

    $ctr2 = 0;

    while ($numBoxes > $ctr) {
        // Now let's see what they selected

        if ('' != $_POST['track-' . $ctr]) {
            // Ok, now we've got the tracks, let's create an array for them

            // First we need to make sure that there are no double slashes, so we'll loop through and kill them

            $trackPath = $_POST['track-' . $ctr];

            while (0 != mb_strpos($trackPath, '//')) {
                $trackPath = str_replace('//', '/', $trackPath);
            }

            // Now let's see if this is a dir or not

            if (is_dir($web_root . urldecode($trackPath))) {
                // Now let's get all the files

                $retArray = readDirInfo($web_root . urldecode($trackPath), 'file');

                for ($e = 0, $eMax = count($retArray); $e < $eMax; $e++) {
                    if (preg_match("/\.($audio_types)$/i", $retArray[$e])) {
                        $trackArray[] = $this_site . urldecode($trackPath) . $retArray[$e];
                    }
                }
            } else {
                $trackArray[] = $this_site . '/' . $trackPath;
            }
        }

        $ctr++;
    }

    // Let's make sure that array wasn't empty

    if (0 != count($trackArray)) {
        // Now let's see if they wanted random or not

        if ($random) {
            // Now let's shuffle the array

            shuffle($trackArray);
        } else {
            // Now let's sort the array

            sort($trackArray);
        }

        // Now let's create the playlist

        createPlayList($trackArray);
    }
}

// This function generates the playlist from the one stored on the server
function playPlaylistFile($file, $type = 'standard', $random = 'false')
{
    global $web_root, $root_dir, $media_dir, $this_site, $audio_types, $video_types;

    // Let's see if they wanted the session playlist or a real one

    if ('sessionplaylist' == $file) {
        // Ok, let's read the session playlist then

        $contents = $_SESSION['sessionPlaylist'];
    } else {
        // Ok, we know what file to open, so let's get at it!

        $filename = $web_root . $root_dir . '/data/' . $file;

        $handle = fopen($filename, 'rb');

        $contents = fread($handle, filesize($filename));

        fclose($handle);
    }

    // Ok, now let's split that into an array

    $playlistArray = explode("\n", $contents);

    // Now let's loop through that array

    $ctr2 = 0;

    for ($ctr = 0, $ctrMax = count($playlistArray); $ctr < $ctrMax; $ctr++) {
        // Let's make sure this line wasn't blank

        if ('' != $playlistArray[$ctr]) {
            // Now that we've got the lines, let's format them and build another array for later

            $trackArray[$ctr2] = $playlistArray[$ctr];

            $ctr2++;
        }
    }

    // Now that we've got the file in an array, let's see if there are any directories that we need to turn into actual files

    $ctr2 = 0;

    $ctr3 = 0;

    for ($ctr = 0, $ctrMax = count($trackArray); $ctr < $ctrMax; $ctr++) {
        // let's look at the last character to see if it is a slash, telling us where to look...

        if ('/' == mb_substr($trackArray[$ctr], mb_strlen($trackArray[$ctr]) - 1, 1)) {
            // Ok, now we need to search that directory for the files in it and all sub dirs

            // When we read it let's remove the trailing slash

            $filePath = urldecode(mb_substr($trackArray[$ctr], 0, -1));

            readAllDirs($filePath, $ctr2, $mainArray);

            $ctr2++;
        } else {
            $finalArray[$ctr3] = $trackArray[$ctr];

            $ctr3++;
        }
    }

    // Now that we got all that data back, let's put it into yet another new array, for our final array

    // But, let's make sure there is data from above for this

    if (isset($mainArray)) {
        if (0 != count($mainArray)) {
            for ($i = 0, $iMax = count($mainArray); $i < $iMax; $i++) {
                $finalArray[$ctr3] = $mainArray[$i];

                $ctr3++;
            }
        }
    }

    // Ok, now that we've got our new array, let's parse it out correctly into a real playlist

    for ($ctr = 0, $ctrMax = count($finalArray); $ctr < $ctrMax; $ctr++) {
        // First let's make sure the item isn't blank

        if ('' != $finalArray[$ctr]) {
            // Ok, now let's reconstruct this line

            $finalArray[$ctr] = $this_site . str_replace('%2F', '/', str_replace($web_root, '', $finalArray[$ctr]));
        }
    }

    // Let's see if we need to shuffle the playlist

    if ('true' == $random) {
        shuffle($finalArray);
    }

    // Now let's play the playlist or create the Shoutcase one

    if ('shoutcast' == $type) {
        createShoutcast($finalArray, $file);
    } else {
        createPlayList($finalArray);
    }
}

// This function adds the posted data to the end of the playlist
function addToPlayList($selectedPlaylist)
{
    global $web_root, $root_dir, $media_dir, $this_site, $this_page, $playlist_ext, $url_seperator;

    // Ok, we know what playlist to add to, let's first get the data we want to add

    // Ok, first we need to loop through what they selected

    $ctr2 = 0;

    for ($ctr = 0; $ctr < $_POST['numboxes']; $ctr++) {
        // Now let's see what they selected

        if (isset($_POST['track-' . $ctr])) {
            if ('' != $_POST['track-' . $ctr]) {
                // Ok, now we've got the data they selected, let's build an array

                // First we need to make sure that there are no double slashes, so we'll loop through and kill them

                $trackPath = $_POST['track-' . $ctr];

                while (0 != mb_strpos($trackPath, '//')) {
                    $trackPath = str_replace('//', '/', $trackPath);
                }

                $trackArray[$ctr2] = $web_root . $trackPath;

                $ctr2 = $ctr + 1;
            }
        }
    }

    // Ok, now we've got our array of what they selected, let's add it to the playlist file

    // First let's look at the playlist type to know what to do

    switch ($selectedPlaylist) {
        case 'newplaylist': # Ok, they want a new playlist
            // First let's look and see if they've created the playlist already and if not give them the option to do it
            // Let's create a small form to hold the name of the playlist and set the type for later
            // We also need to store all the data from all the check boxes that they checked
            echo '<form action="'
                 . $this_page
                 . $url_seperator
                 . $_SERVER['QUERY_STRING']
                 . '" method="POST" name="playlistForm">'
                 . '<input type="hidden" name="playlistName">'
                 . '<input type="text" name="submitAction" value="addtoplaylist" style="width: 0px; border: 0px white;">'
                 . '<input type="hidden" name="numboxes" value="'
                 . $_POST['numboxes']
                 . '">';
            // Now let's recreate all the check boxes
            $ctr2 = 0;
            for ($ctr = 0; $ctr < $_POST['numboxes']; $ctr++) {
                echo '<input type="hidden" name="track-' . $ctr . '" value="' . $_POST['track-' . $ctr] . '">';
            }
            echo '</form>';
            // Let's call the JavaSript to get the name of the new playlist
            ?>
            <script language="JavaScript"><!--

                function getPlayListName() {
                    var strInput;
                    strInput = window.prompt("New Playlist Name?");
                    document.playlistForm.playlistName.value = strInput;
                }

                function submitForm() {
                    document.playlistForm.submit();
                }

                getPlayListName();
                submitForm();

                //--></script>
            <?php
            exit();
            break;
        case 'sessionplaylist': # Ok, they want a session playlist
            // First we need to open the old playlist so we can make sure we don't get dupes
            $oldPlaylist = explode("\n", $_SESSION['sessionPlaylist']);
            // Now let's merge the two arrays
            $finalArray = array_unique(array_merge($trackArray, $oldPlaylist));

            // Now let's kill the old list so we can recreate it below
            $_SESSION['sessionPlaylist'] = '';

            // Now let's loop through our array writing data as we go
            for ($ctr = 0, $ctrMax = count($finalArray); $ctr < $ctrMax; $ctr++) {
                // Let's make sure the item isn't blank

                if ('' != $finalArray[$ctr]) {
                    // Ok let's write the data

                    $_SESSION['sessionPlaylist'] .= $finalArray[$ctr] . "\n";
                }
            }
            break;
        default: # Ok, they must want to add to OR create a new playlist
            if (isset($_POST['playlistName'])) {
                // Ok, they wanted to create a new playlist to add to

                $fileName = $web_root . $root_dir . '/data/' . $_POST['playlistName'] . '.' . $playlist_ext;
            } else {
                // Let's set the filename from the existing playlist

                $fileName = $web_root . $root_dir . '/data/' . $selectedPlaylist;

                // Let's open the file and create an array from it so we can compare for dupes

                $handle = fopen($fileName, 'rb');

                $contents = fread($handle, filesize($fileName));

                fclose($handle);

                $oldPlaylist = explode("\n", $contents);

                // Now let's merge the two arrays

                $trackArray = array_unique(array_merge($oldPlaylist, $trackArray));
            }

            // let's open the file for appending, ok?
            $handle = fopen($fileName, 'wb');
            // Now let's loop through our array writing data as we go
            for ($ctr = 0, $ctrMax = count($trackArray); $ctr < $ctrMax; $ctr++) {
                // Let's make sure the item isn't blank

                if ('' != $trackArray[$ctr]) {
                    // Ok let's write the data

                    $result = fwrite($handle, $trackArray[$ctr] . "\n");
                }
            }
            // Now let's close the file
            fclose($handle);
            break;
    }
}

// This function builds the Shoutcast playlist file and stores it on the server
function createShoutcast($trackArray, $playlist)
{
    global $web_root, $root_dir, $media_dir, $this_site, $word_create_shoutcast_playlist;

    // Ok, now that we have our array back, we need to clean it up for the shoutcast playlist

    for ($ctr = 0, $ctrMax = count($trackArray); $ctr < $ctrMax; $ctr++) {
        $trackArray[$ctr] = str_replace($this_site, $web_root, urldecode($trackArray[$ctr]));
    }

    // Ok, now that it's cleaned up, let's create the streamfile

    $handle = fopen($web_root . $root_dir . '/data/shoutcast.lst', 'wb');

    for ($ctr = 0, $ctrMax = count($trackArray); $ctr < $ctrMax; $ctr++) {
        $result = fwrite($handle, $trackArray[$ctr] . "\n");
    }

    fclose($handle);

    // Now let's restart Shoutcast to play the new list

    exec('killall sc_trans_linux -USR1 > /dev/null 2>&1 &');

    exec('killall sc_trans_linux -WINCH > /dev/null 2>&1 &');

    //exec ("nice -5 -- /usr/local/shoutcast/sc_trans_linux /usr/local/shoutcast/sc_trans.conf > /dev/null 2>&1 &");

    displayPlaylists($playlist);

    exit();
}

?>

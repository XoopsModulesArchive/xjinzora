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
    * Code Purpose: This page contains all the "display" related functions
    * Created: 9.24.03 by Frank Zeko jinzora@dogstone.com
    *
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

// First we need to see if they were generating a playlist from the popup
if (isset($_GET['playlist'])) {
    header('Content-type: audio/mpegurl');

    header('Content-Disposition: inline; filename=playlist.m3u');

    header('Cache-control: private');

    echo $_GET['playlist'];

    exit();
}

// Let's modify the include path for Jinzora
ini_set('include_path', '.');

// Let's include the main, user settings file
require_once __DIR__ . '/settings.php';
require_once __DIR__ . '/system.php';
require_once __DIR__ . '/classes.php';
require_once __DIR__ . '/general.php';
require_once __DIR__ . '/id3classes/getid3.php';
// Now let's include the functions we need to access the media
require_once __DIR__ . '/adaptors/' . $adaptor_type . '/required.php';
require_once __DIR__ . '/lib/display.lib.php';

// Now let's see if the CMS theme is set
if (isset($_GET['cur_theme'])) {
    if ('' != $_GET['cur_theme']) {
        $cur_theme = $_GET['cur_theme'];

        $jinzora_skin = $_GET['cur_theme'];
    }
}

// Now let's get the security level of the user
// Now let's get their access level
require_once $web_root . $root_dir . '/users.php';
for ($ctr = 0, $ctrMax = count($user_array); $ctr < $ctrMax; $ctr++) {
    if (mb_strtolower($_COOKIE['jz_user_name']) == mb_strtolower($user_array[$ctr][0])) {
        /* Ok, we have a match on the username, let's see if it's the right password */

        $_SESSION['jz_access_level'] = $user_array[$ctr][2];
    }
}

// Let's see if they wanted art and description from Allmusic
if (isset($_POST['infofromurl'])) {
    // Now let's show the page

    displayPageTop();

    // Ok, let's break the URL up

    $hostName = str_replace('http://', '', $_POST['infourl']);

    $hostArray = explode('/', $hostName);

    $hostName = $hostArray[0];

    // Now let's get the path

    $path = str_replace('http://', '', $_POST['infourl']);

    $path = str_replace($hostName, '', $path);

    echo '<br><center>';

    echo 'Opening connection...<br>';

    flushDisplay();

    echo 'Reading the album description<br>';

    flushDisplay();

    // Now let's make sure we got the image

    $imgUrl = 'NULL';

    $c = 0;

    while ($c < 20) {
        $contents = returnHTML($hostName, $path);

        // Now let's parse out the data

        $contents = mb_substr($contents, mb_strpos($contents, 'alt="[To Top]"'), mb_strlen($contents));

        $contents = mb_substr($contents, mb_strpos($contents, '<IMG'), mb_strlen($contents));

        $img = mb_substr($contents, 0, mb_strpos($contents, '>') + 1);

        $img = mb_substr($img, mb_strpos($img, 'src=') + 4, mb_strlen($img));

        $imgUrl = mb_substr($img, 0, mb_strpos($img, ' '));

        $contents = mb_substr($contents, mb_strpos($contents, '</a>') + 4, mb_strlen($contents));

        $description = str_replace('<a ', '<', mb_substr($contents, 0, mb_strpos($contents, '  -- ')));

        if ('NULL' != $imgUrl or '' != $imgUrl) {
            break;
        }

        // Let's make sure we don't loop forever

        $c++;
    }

    if ('NULL' == $imgUrl or '' == $imgUrl) {
        echo "Sorry, we didn't get the right data back...";

        flushDisplay();

        sleep(2);

        closeWindow();

        exit();
    }

    // Now let's write the description

    $albumArray = explode('/', $_POST['origalbumName']);

    $descFile = $web_root . $root_dir . $media_dir . '/' . $_POST['origalbumName'] . '/album-desc.txt';

    $handle = fopen($descFile, 'wb');

    fwrite($handle, $description);

    fclose($handle);

    // Now let's write the image

    echo 'Reading the album image<br>';

    flushDisplay();

    $handle = fopen($imgUrl, 'rb');

    $contents = '';

    while (@!feof($handle)) {
        $contents .= fread($handle, 8192);
    }

    fclose($handle);

    $imgFile = $web_root . $root_dir . $media_dir . '/' . $_POST['origalbumName'] . '/' . $albumArray[count($albumArray) - 1] . '.jpg';

    // Let's make sure the old file didn't exist

    @unlink($imgFile);

    // Now that we have the data, let's write it to the new file

    if (!file_exists($imgFile)) {
        @touch($imgFile);
    }

    if (is_writable($imgFile)) {
        $handle = fopen($imgFile, 'wb');

        fwrite($handle, $contents);

        fclose($handle);
    }

    echo '<br>All updates complete!';

    flushDisplay();

    sleep(2);

    closeWindow();

    exit();
}

function returnHTML($hostName, $path)
{
    $contents = '';

    // Ok, Now let's open the page

    $fp = @fsockopen($hostName, 80, $errno, $errstr, 5);

    // Let's make sure that opened ok

    if ($fp) {
        flushDisplay();

        fwrite($fp, "GET $path HTTP/1.1\r\nHost:" . $hostName . "\r\n\r\n");

        fwrite($fp, "Connection: close\n\n");

        // Now let's read all the data

        $blnHeader = true;

        while (!feof($fp)) {
            if ($blnHeader) {
                if ("\r\n" == fgets($fp, 1024)) {
                    $blnHeader = false;
                }
            } else {
                $contents .= fread($fp, 1024);
            }
        }

        fclose($fp);
    }

    return $contents;
}

// Let's see if they wanted to rename tracks using Allmusic
if (isset($_POST['renamefromurl'])) {
    // Ok, let's break the URL up

    $hostName = str_replace('http://', '', $_POST['renameurl']);

    $hostArray = explode('/', $hostName);

    $hostName = $hostArray[0];

    // Now let's get the path

    $path = str_replace('http://', '', $_POST['renameurl']);

    $path = str_replace($hostName, '', $path);

    // Ok, Now let's open the page

    $fp = fsockopen($hostName, 80, $errno, $errstr, 5);

    // Let's make sure that opened ok

    if ($fp) {
        fwrite($fp, "GET $path HTTP/1.1\r\nHost:" . $hostName . "\r\n\r\n");

        //fputs($fp, "Content-type: application/x-www-form-urlencoded\n");

        fwrite($fp, "Connection: close\n\n");

        // Now let's read all the data

        $blnHeader = true;

        $contents = '';

        while (!feof($fp)) {
            if ($blnHeader) {
                if ("\r\n" == fgets($fp, 1024)) {
                    $blnHeader = false;
                }
            } else {
                $contents .= fread($fp, 1024);
            }
        }

        fclose($fp);

        // Now let's process the data

        $contents = mb_substr($contents, mb_strpos($contents, '<A Name="TRACK">'), mb_strlen($contents));

        $contents = mb_substr($contents, mb_strpos($contents, '</tr>') + 5, mb_strlen($contents));

        $contents = mb_strtolower(mb_substr($contents, 0, mb_strpos($contents, '<A Name="REL">')));

        $dataArray = explode('</tr>', $contents);

        for ($i = 0, $iMax = count($dataArray); $i < $iMax; $i++) {
            // Now let's split out the TD's

            $tdArray = explode('</td>', $dataArray[$i]);

            // Now let's get the data

            $char = '';

            $ctr = 0;

            $trackNum = str_replace('.', '', mb_substr($tdArray[3], mb_strpos($tdArray[3], '>') + 1));

            if (mb_strlen($trackNum) < 2) {
                $trackNum = '0' . $trackNum;
            }

            $trackName = mb_substr($tdArray[5], mb_strpos($tdArray[5], '">') + 2, mb_strlen($tdArray[5]));

            $trackName = mb_substr($trackName, 0, mb_strpos($trackName, '</'));

            $trackLength = mb_substr($tdArray[5], mb_strpos($tdArray[5], ' - ') + 3, mb_strlen($tdArray[5]));

            // Now let's set the array

            $nameArray[$i]['trackNum'] = $trackNum;

            $nameArray[$i]['trackName'] = $trackName;

            $nameArray[$i]['trackLength'] = $trackLength;
        }

        // Now let's read all the files in the directory

        $retArray = readDirInfo($web_root . $root_dir . $media_dir . '/' . $_POST['origalbumName'], 'file');

        for ($i = 0, $iMax = count($retArray); $i < $iMax; $i++) {
            if (preg_match("/\.($audio_types)$/i", $retArray[$i])) {
                $origName = mb_strtolower($retArray[$i]);

                $originalName = $web_root . $root_dir . $media_dir . '/' . $_POST['origalbumName'] . '/' . $retArray[$i];

                // Now let's look at the array we got back

                for ($c = 0, $cMax = count($nameArray); $c < $cMax; $c++) {
                    // Now let's see if there is a match

                    if (mb_stristr($nameArray[$c]['trackName'], $origName) or mb_stristr($origName, $nameArray[$c]['trackName'])) {
                        // Ok, let's rename it IF it's wrong

                        if (!is_numeric(mb_substr(ucwords($origName), 0, 1))) {
                            $newName = $web_root . $root_dir . $media_dir . '/' . $_POST['origalbumName'] . '/' . $nameArray[$c]['trackNum'] . ' - ' . ucwords($origName);

                            // Now let's save that for later

                            $renameArray[] = $retArray[$i] . '|||' . $nameArray[$c]['trackNum'] . ' - ' . ucwords($origName);
                        }
                    }
                }
            }
        }

        // Now let's show the page

        displayPageTop();

        echo '<center><br>';

        // Now let's see if we got stuff to rename

        if (isset($renameArray)) {
            // Now let's show them what we'd do

            echo '<form action="' . $root_dir . '/mp3info.php" method="POST">';

            echo '<strong>Matches Found:</strong><br>';

            echo '<select size="10" name="renameMatches" class="jz_select">' . "\n";

            for ($i = 0, $iMax = count($renameArray); $i < $iMax; $i++) {
                echo '<option value="">' . str_replace('|||', ' --- ', $renameArray[$i]) . "\n";
            }

            echo '</select>';

            for ($i = 0, $iMax = count($renameArray); $i < $iMax; $i++) {
                echo '<input type="hidden" name="rename' . $i . '" value="' . $renameArray[$i] . '">';
            }

            echo '<input type="hidden" name="numboxes" value="' . $i . '">';

            echo '<input type="hidden" name="path" value="' . $web_root . $root_dir . $media_dir . '/' . $_POST['origalbumName'] . '">';

            echo '<br><br>';

            echo '<input type="submit" value="Rename" name="renameFoundTracks" class="jz_submit">';

            echo '</form>';
        } else {
            echo '<br>Sorry, nothing was found that would have worked...';
        }
    }

    exit();
}

// Let's see if they actually wanted to do the track rename
if (isset($_POST['renameFoundTracks'])) {
    // Now let's show the page

    displayPageTop();

    echo '<center><br>';

    echo 'Renaming Files...<br><br></center>';

    flushDisplay();

    // Now let's process the fields

    $ctr = 0;

    $error = false;

    while ($ctr < $_POST['numboxes']) {
        $retData = explode('|||', $_POST['rename' . $ctr]);

        $originalName = $_POST['path'] . '/' . $retData[0];

        $newName = $_POST['path'] . '/' . $retData[1];

        // Now let's rename it

        echo ' &nbsp; Renaming: ' . $retData[0] . ' to ' . $retData[1];

        if (rename($originalName, $newName)) {
            echo ' - Success!';
        } else {
            echo ' - Failed!';

            $error = true;
        }

        echo '<br>';

        flushDisplay();

        $ctr++;
    }

    echo '<br><center>Renaming Files Completed';

    if ($error) {
        echo ' with errors!';
    }

    flushDisplay();

    sleep(2);

    // Now let's close out

    closeWindow();

    exit();
}

// Let's see if they wanted to scan a mailbox for files
if (isset($_POST['scanMailbox'])) {
    // Let's display the top of our page

    displayPageTop();

    echo '<center>Opening Mailbox...<br>';

    flushDisplay();

    $mbox = @imap_open('{' . $email_server . ':110/pop3}', $email_username, $email_password) || die("can't connect: " . imap_last_error());

    echo 'Scanning for messages... (this can take a while...)<br>';

    flushDisplay();

    $headers = imap_headers($mbox);

    if (false === $headers) {
        echo "Call failed<br>\n";
    } else {
        while (list($key, $val) = each($headers)) {
            // Now let's check for the Jinzora message to grab

            if (mb_stristr(mb_strtolower($val), $email_subject)) {
                $msg_number = $key + 1;
            }
        }
    }

    function get_structure($mbox, $i)
    {
        $structure = imap_fetchstructure($mbox, $i);

        return $structure;
    }

    function get_attached_file($structure, $k, $i)
    {
        global $mbox, $web_root, $root_dir, $media_dir;

        $encoding = $structure->parts[$k]->encoding;

        $Name = mb_strtolower($structure->parts[$k]->dparameters[0]->value);

        $NewFile[$k - 1] = $Name;

        if ($Name) {
            // Let's let them know what we're doing

            echo 'Adding file: ' . ucwords($Name);

            flushDisplay();

            // Now let's create the actual file

            $fileName = $web_root . $root_dir . $media_dir . '/' . $_POST['destPath'] . '/' . ucwords($Name);

            $File = base64_decode(imap_fetchbody($mbox, $i, $k + 1), true);

            $fp = fopen($fileName, 'w+b');

            if ($fp) {
                echo ' - Success!<br>';

                flushDisplay();

                fwrite($fp, $File, 99999999999999999999);

                fclose($fp);
            } else {
                echo ' - Error!<br>';

                flushDisplay();
            }
        }
    }

    // Now let's loop through each attachment and grab it

    $struct = get_structure($mbox, $msg_number);

    if (count($struct->parts) > 0) {
        echo '<center>Adding media to Jinzora<br><br>';

        // Now let's see if we need to create the directory or not

        if (!is_dir($web_root . $root_dir . $media_dir . '/' . $_POST['destPath'])) {
            // Ok, let's create it

            $destArray = explode('/', $_POST['destPath']);

            $destDir = '';

            for ($i = 0, $iMax = count($destArray); $i < $iMax; $i++) {
                $destDir .= '/' . $destArray[$i];

                if (!is_dir($web_root . $root_dir . $media_dir . $destDir)) {
                    mkdir($web_root . $root_dir . $media_dir . '/' . $destDir);
                }
            }
        }
    } else {
        echo '<center>No media found to add!<br><br>Verify that there is email in the mailbox for user: ' . $email_username . ' and that it has the EXACT subject of "Add to Jinzora"<br><br>';

        flushDisplay();
    }

    $i = 0;

    while (count($struct->parts) > $i) {
        get_attached_file(get_structure($mbox, $msg_number), $i, $msg_number);

        $i++;
    }

    if (count($struct->parts) > 0) {
        echo '<br>Adding Media Complete, deleting message<br>';

        if (imap_delete($mbox, $msg_number)) {
            echo '<br>Message successfully deleted!<br><br>';

            imap_expunge($mbox);

            flushDisplay();
        }
    }

    imap_close($mbox);

    sleep(3);

    closeWindow();

    exit();
}

// Now let's see if they wanted to upload media
if (isset($_POST['uploadFiles'])) {
    // Let's display the top of our page

    displayPageTop();

    // Let's give them status

    echo '<center><br>Beginning file upload<br><br>';

    flushDisplay();

    // First let's see if the destination exists or not

    if (!is_dir($web_root . $root_dir . $media_dir . '/' . $_POST['destPath'])) {
        // Ok, now we need to create it

        $destArray = explode('/', $_POST['destPath']);

        $destDir = '';

        for ($i = 0, $iMax = count($destArray); $i < $iMax; $i++) {
            $destDir .= '/' . $destArray[$i];

            if (!is_dir($web_root . $root_dir . $media_dir . $destDir)) {
                mkdir($web_root . $root_dir . $media_dir . '/' . $destDir);
            }
        }
    }

    // Ok, we're uploading so let's move the stuff into place

    $c = 1;

    while ($c < 10) {
        if ('' != $_FILES['file' . $c]['name']) {
            echo 'Uploading: ' . $_FILES['file' . $c]['name'];

            if (copy($_FILES['file' . $c]['tmp_name'], $web_root . $root_dir . $media_dir . '/' . $_POST['destPath'] . '/' . $_FILES['file' . $c]['name'])) {
                echo ' - Success!<br>';
            } else {
                echo ' - Failed!<br>';
            }

            flushDisplay();
        }

        $c++;
    }

    echo '<br>File uploads complete!';

    sleep(1);

    // Now let's close out

    closeWindow();

    exit();
}

// Let's set the filename from the GET variable
// We need to decode it from the URL and strip the slashes from it
if (isset($_GET['file'])) {
    $file = stripslashes(urldecode($_GET['file']));
} else {
    $file = '';
}

// Now let's see if they wanted to update one of the site description files
if (isset($_POST['updateSiteDesc'])) {
    // Now let's write it

    $handle = fopen($web_root . $root_dir . $media_dir . '/header.txt', 'wb');

    fwrite($handle, $_POST['header']);

    fclose($handle);

    // Now let's write it

    $handle = fopen($web_root . $root_dir . $media_dir . '/footer.txt', 'wb');

    fwrite($handle, $_POST['footer']);

    fclose($handle);

    // Now let's write it

    $handle = fopen($web_root . $root_dir . $media_dir . '/site-description.txt', 'wb');

    fwrite($handle, $_POST['site']);

    fclose($handle);

    // Now let's write it

    $handle = fopen($web_root . $root_dir . $media_dir . '/slim-header.txt', 'wb');

    fwrite($handle, $_POST['slim-head']);

    fclose($handle);

    // Now let's write it

    $handle = fopen($web_root . $root_dir . $media_dir . '/slim-footer.txt', 'wb');

    fwrite($handle, $_POST['slim-foot']);

    fclose($handle);

    closeWindow();

    exit();
}

// Did they want to create a fake file or not?
if (isset($_POST['createfake'])) {
    // Let's figure out the fake track name

    $fakeTrack = $web_root . $root_dir . $media_dir . '/' . $_POST['desc_filename'] . '/' . $_POST['fakeTrackName'] . '.fake.lnk';

    // Now let's start the page...

    echo $css;

    echo '<br><br><br><br><br><br><center>';

    // Now let's make sure we can create that file

    if (touch($fakeTrack)) {
        // Now let's create the complete file

        $handle = fopen($fakeTrack, 'wb');

        fwrite($handle, 'Description: ' . $_POST['fakeTrackDesc'] . "\n" . 'Link:' . $_POST['fakeTrackLink']);

        fclose($handle);

        echo $word_update_successful;

        flushDisplay();
    } else {
        echo $word_error;

        flushDisplay();
    }

    // Now let's close out

    sleep(2);

    closeWindow();

    exit();
}

// Did they want to delete a clip file?
if (isset($_POST['deleteclip'])) {
    // Ok, let's wack it

    $filename = $_POST['filename'];

    $fileInfo = pathinfo(urldecode(filename));

    $fileExt = $fileInfo['extension'];

    $clipFilename = str_replace('.mp3' . $fileExt, '.clip.mp3', $filename);

    unlink($clipFilename);

    closeWindow();

    exit();
}

// Did they want to delete a lo-fi file?
if (isset($_POST['deletelowfi'])) {
    // Ok, let's wack it

    $filename = $_POST['filename'];

    $fileInfo = pathinfo(urldecode(filename));

    $fileExt = $fileInfo['extension'];

    $lofiFilename = str_replace('.mp3' . $fileExt, '.lofi.mp3', $filename);

    unlink($lofiFilename);

    closeWindow();

    exit();
}

// Did they want to delete all the clips in a directory?
if (isset($_POST['deleteclips'])) {
    // Let's echo out the header

    echo $css;

    // Let's let them know what we are doing

    echo 'Deleting all clips from directory<br>' . $_POST['origalbumName'] . '<br><br>';

    $retArray = readDirInfo($web_root . $root_dir . $media_dir . '/' . $_POST['origalbumName'], 'file');

    for ($i = 0, $iMax = count($retArray); $i < $iMax; $i++) {
        // Now let's create the clip files IF they are valid

        if (mb_stristr($retArray[$i], '.clip.')) {
            if (unlink($web_root . $root_dir . $media_dir . '/' . $_POST['origalbumName'] . '/' . $retArray[$i])) {
                echo 'Deleted: ' . $retArray[$i] . '<br>';
            } else {
                echo 'Error Deleting: ' . $retArray[$i] . '<br>';
            }
        }

        flushDisplay();
    }

    echo '<br>Clip deletion complete!';

    flushDisplay();

    sleep(2);

    closeWindow();

    exit();
}

// Did they want to create clips of all tracks in an album?
if (isset($_POST['createclips'])) {
    // Let's echo out the header

    echo $css;

    // Let's let them know what we are doing

    echo 'Creating clips from directory<br>' . $_POST['origalbumName'] . '<br><br>';

    // Let's read all the tracks in that directory

    // And create a clip from each one

    $retArray = readDirInfo($web_root . $root_dir . $media_dir . '/' . $_POST['origalbumName'], 'file');

    for ($i = 0, $iMax = count($retArray); $i < $iMax; $i++) {
        // Now let's create the clip files IF they are valid

        if (preg_match("/\.($audio_types)$/i", $retArray[$i]) and !mb_stristr($retArray[$i], '.lofi.') and !mb_stristr($retArray[$i], '.clip.') and !mb_stristr($retArray[$i], '.txt') and !mb_stristr($retArray[$i], '.fake')) {
            if (createClip($web_root . $root_dir . $media_dir . '/' . $_POST['origalbumName'] . '/' . $retArray[$i])) {
                echo 'Created: ' . $retArray[$i] . '<br>';
            } else {
                echo 'Error: ' . $retArray[$i] . '<br>';
            }
        }

        flushDisplay();
    }

    echo '<br>Clip creation complete!';

    flushDisplay();

    sleep(2);

    closeWindow();

    exit();
}

// Ok, did they want to create a clip of the track?
if (isset($_POST['createclip'])) {
    // Let's echo out the header

    echo $css;

    // Now let's create the clip

    echo '<br><br><center>Please wait while we process the file for you,<br>this may take quite a while...<br><br>You will be notified when complete<br><br>';

    echo '<img src="' . $root_dir . '/style/images/convert.gif?' . time() . '"><br>creating...';

    flushDisplay();

    // Now let's create the files

    createClip($_POST['filename']);

    echo '<br><br>Clip File Created Successfully!</center>';

    flushDisplay();

    // Let's pause for a second so they can see the message...

    sleep(2);

    closeWindow();

    exit();
}

// This function creates the clip file
function createClip($sourceFile)
{
    global $clip_start, $clip_length;

    if ($handle = fopen($sourceFile, 'rb')) {
        $return = true;
    } else {
        $return = false;
    }

    $realTrack = fread($handle, filesize($sourceFile));

    fclose($handle);

    // Now let's write the clip track

    $fileInfo = pathinfo(urldecode(sourceFile));

    $fileExt = $fileInfo['extension'];

    $clipFilename = str_replace('.mp3' . $fileExt, '.clip.mp3', $sourceFile);

    // First let's see if it already exists and if so wack it!

    if (is_file($clipFilename)) {
        if (unlink($clipFilename)) {
            $return = true;
        } else {
            $return = false;
        }
    }

    if ($handle = fopen($clipFilename, 'wb')) {
        $return = true;
    } else {
        $return = false;
    }

    fwrite($handle, mb_substr($realTrack, $clip_start, $clip_length));

    fclose($handle);

    return $return;
}

// Ok, did they want to create a lo-fi track?
if (isset($_POST['createlowfi'])) {
    $filename = $_POST['filename'];

    // Let's echo out the header

    echo $css;

    // Now let's figure out the lofi filename

    $fileInfo = pathinfo(urldecode(filename));

    $fileExt = $fileInfo['extension'];

    $lofiFilename = str_replace('.mp3' . $fileExt, '.lofi.mp3', $filename);

    // Now let's create the lofi file IF we can

    $error = true;

    if (!is_file($lofiFilename)) {
        if (touch($lofiFilename)) {
            unlink($lofiFilename);

            $error = false;
        }
    }

    // Now let's proceed IF we didn't have an error

    if (!$error) {
        echo '<br><br><center>Please wait while we process the file for you,<br>this may take quite a while...<br><br>You will be notified when complete<br><br>';

        echo '<img src="' . $root_dir . '/style/images/convert.gif?' . time() . '"><br>converting...';

        flushDisplay();

        $command = $lame_opts . '"' . $filename . '" "' . $lofiFilename . '"';

        exec($command, $output, $returnvalue);

        echo $output[0];

        echo '<br><br>LoFi File Created Successfully!</center>';

        flushDisplay();
    }

    sleep(2);

    closeWindow();

    exit();
}

// Now let's see if they wanted to update the track or not
if (isset($_POST['closeupdate']) or isset($_POST['updatedata'])) {
    // Now let's update the description file

    $fileName = $_POST['desc_filename'];

    $handle = fopen($fileName, 'wb');

    fwrite($handle, $_POST['long_desc']);

    fclose($handle);

    // Ok, they posted the form, let's update the information for them...

    $file = $_POST['filename'];

    // Now let's get the path to this file

    // First we need the path

    $pathArray = explode('/', $_POST['filename']);

    $i = 0;

    $path = '';

    while (count($pathArray) > $i) {
        if ('' != $pathArray[$i]) {
            if ($i != count($pathArray) - 1) {
                if ('' != $pathArray[$i]) {
                    $path .= $pathArray[$i] . '/';
                }
            }
        }

        $i++;
    }

    $path = mb_substr($path, 0, -1);

    // Let's write the tag

    $getID3 = new getID3();

    getid3_lib::IncludeDependency('id3classes/write.php', __FILE__, true);

    $tagwriter = new getid3_writetags();

    // Now let's set all the data

    $data['title'][] = $_POST['trackname'];

    $data['artist'][] = $_POST['artistname'];

    $data['album'][] = $_POST['albumname'];

    $data['comment'][] = $_POST['description'];

    $data['genre'][] = $_POST['genre'];

    $data['track'][] = $_POST['tracknumber'];

    $data['year'][] = $_POST['year'];

    // Now let's see if there is art for this file and if so write it to the tag

    $albumArt = '';

    $retArray = readDirInfo($path, 'file');

    for ($i = 0, $iMax = count($retArray); $i < $iMax; $i++) {
        if (preg_match("/\.($ext_graphic)$/i", $retArray[$i])) {
            $albumArt = $path . '/' . $retArray[$i];

            $pic_name = $retArray[$i];

            $fileInfo = pathinfo($retArray[$i]);

            $pic_extension = $fileInfo['extension'];
        }
    }

    if ('' != $albumArt) {
        if ($fd = @fopen($albumArt, 'rb')) {
            $APICdata = fread($fd, filesize($albumArt));

            fclose($fd);

            [$APIC_width, $APIC_height, $APIC_imageTypeID] = getimagesize($albumArt);

            $imagetypes = [1 => 'gif', 2 => 'jpeg', 3 => 'png'];

            if (isset($imagetypes[$APIC_imageTypeID])) {
                $data['attached_picture'][0]['data'] = $APICdata;

                $data['attached_picture'][0]['picturetypeid'] = $pic_extension;

                $data['attached_picture'][0]['description'] = $pic_name;

                $data['attached_picture'][0]['mime'] = 'image/' . $imagetypes[$APIC_imageTypeID];
            }
        }
    }

    // Now let's see if there are lyrics to write to the tag too

    if ('' != $_POST['lyrics']) {
        // now let's make sure we didn't already have leo's header in there

        if (mb_stristr($_POST['lyrics'], "Leo's Lyrics")) {
            $lyric_header = '';
        } else {
            $lyric_header = "Lyrics Provided by: Leo's Lyrics" . "\n" . 'http://www.leoslyrics.com' . "\n\n";
        }

        $data['unsynchronised_lyrics'][] = $lyric_header . $_POST['lyrics'];
    }

    // Now let's write the tags

    $tagwriter->tag_data = $data;

    $tagwriter->filename = $file;

    $tagwriter->tagformats = ['id3v1', 'id3v2.3'];

    $tagwriter->WriteTags();

    // Now let's make sure the beginning of the path is valid

    if (!mb_stristr($path, ':/')) {
        $path = '/' . $path;
    }

    // Now let's change the file name

    $newFile = $path . '/' . $_POST['newfilename'];

    $oldFile = $path . '/' . $pathArray[count($pathArray) - 1];

    // Ok, now let's move the file

    if ($oldFile != $newFile) {
        rename($oldFile, $newFile);
    }

    // Now let's see if they wanted to upload a thumbnail

    if ('none' != $_FILES['thumbnail']['tmp_name']) {
        // Now let's figure out what the name of the image should be

        $fileInfo = pathinfo(urldecode($_POST['filename']));

        $trackExt = $fileInfo['extension'];

        $fileInfo = pathinfo(urldecode($_FILES['thumbnail']['name']));

        $imgExt = $fileInfo['extension'];

        $thumbFile = str_replace('.' . $trackExt, '.thumb.' . $imgExt, $file);

        // Now let's kill that file if it exists

        if (is_file($thumbFile)) {
            unlink($thumbFile);
        }

        // Now let's copy that file into place

        @copy($_FILES['thumbnail']['tmp_name'], $thumbFile);
    }

    // Ok, now let's see if there is a start or stop time

    if (isset($_POST['start_time'])) {
        // Ok, there was so let's write it out to the tracks directory

        $rmdataFile = $web_root . $root_dir . '/data/tracks/' . returnFormatedFilename(str_replace($web_root . $root_dir . $media_dir . '/', '', $filename)) . '.rmdata';

        $handle = fopen($rmdataFile, 'wb');

        fwrite($handle, $_POST['start_time'] . '|||' . $_POST['stop_time']);

        fclose($handle);
    }

    // Now let's write out the track counter

    $ctrFile = $web_root . $root_dir . '/data/counter/' . returnFormatedFilename(str_replace($web_root . $root_dir . $media_dir . '/', '', $filename)) . '.ctr';

    $handle = fopen($ctrFile, 'wb');

    fwrite($handle, $_POST['trackplays'] . '|');

    fclose($handle);

    // Now let's close the window by creating a little javascript function IF they wanted that

    if (isset($_POST['closeupdate'])) {
        closeWindow();

        exit();
    }
}

// Now let's see if they wanted to delete a thumbnail
if (isset($_POST['deletethumb'])) {
    // Ok, let's wack it!

    unlink($web_root . rawurldecode($_POST['thumb_image']));
}

// Now let's see if they wanted to bulk edit an album
if (isset($_POST['replacealbumdata']) or isset($_POST['fixalbumcase']) or isset($_POST['replacealbumdataclose'])) {
    // Let's display the top of our page

    displayPageTop();

    echo 'Please wait while we edit the files...<br><br>';

    // Ok, let's do some renaming!

    // First we need to get a listing of all the files in this directory

    $retArray = readDirInfo($web_root . $root_dir . $media_dir . '/' . $_POST['origalbumName'], 'file');

    for ($i = 0, $iMax = count($retArray); $i < $iMax; $i++) {
        $old_name = $web_root . $root_dir . $media_dir . '/' . $_POST['origalbumName'] . '/' . $retArray[$i];

        if (preg_match("/\.($audio_types)$/i", $retArray[$i]) or preg_match("/\.($video_types)$/i", $retArray[$i])) {
            // Did they want to rename?

            if (isset($_POST['replacealbumdata']) or isset($_POST['replacealbumdataclose'])) {
                // Ok, we have the old name, let's generate the new name

                $new_name = $web_root . $root_dir . $media_dir . '/' . $_POST['origalbumName'] . '/' . str_replace($_POST['search'], $_POST['replace'], $retArray[$i]);

                if ($old_name != $new_name) {
                    echo '<nobr>Renaming: ' . $retArray[$i] . '...';

                    if (rename($old_name, $new_name)) {
                        echo '<font color=green>Success!</font>';
                    } else {
                        echo '<font color=red>Failed!</font>';
                    }
                }
            }

            if (isset($_POST['fixalbumcase'])) {
                // Ok, we have the old name, let's generate the new name

                $new_name = $web_root . $root_dir . $media_dir . '/' . $_POST['origalbumName'] . '/' . ucwords($retArray[$i]) . '.jz_tmp_file';

                if (copy($old_name, $new_name)) {
                    unlink($old_name);

                    echo '<font color=green>Success!</font>';
                } else {
                    echo '<font color=red>Failed!</font>';
                }
            }

            echo '</nobr><br>';

            flushDisplay();
        }
    }

    // If we did a file name fix, we'll need to remove the temp extension

    if (isset($_POST['fixalbumcase'])) {
        $retArray = readDirInfo($web_root . $root_dir . $media_dir . '/' . $_POST['origalbumName'], 'file');

        for ($i = 0, $iMax = count($retArray); $i < $iMax; $i++) {
            $old_name = $web_root . $root_dir . $media_dir . '/' . $_POST['origalbumName'] . '/' . $retArray[$i];

            $new_name = $web_root . $root_dir . $media_dir . '/' . $_POST['origalbumName'] . '/' . str_replace('.jz_tmp_file', '', $retArray[$i]);

            rename($old_name, $new_name);
        }
    }

    // Now we need to force an update to the XML cache

    $xmlArray = explode('/', $_POST['origalbumName']);

    $album = $xmlArray[count($xmlArray) - 1];

    $artist = $xmlArray[count($xmlArray) - 2];

    $genre = $xmlArray[count($xmlArray) - 3];

    if ('' == $genre) {
        $genreDir = 'NULL';
    } else {
        $genreDir = str_replace('/', '---', $genre);
    }

    if ('' == $artist) {
        $artistDir = 'NULL';
    } else {
        $artistDir = str_replace('/', '---', $artist);
    }

    if ('' == $album) {
        $albumDir = 'NULL';
    } else {
        $albumDir = str_replace('/', '---', $album);
    }

    $xmlFile = $web_root . $root_dir . '/data/tracks/' . $genreDir . '---' . $artistDir . '---' . $albumDir . '.xml';

    createXMLFile($web_root . $root_dir . $media_dir . '/' . $_POST['origalbumName'], $xmlFile);

    if (isset($_POST['replacealbumdataclose']) or isset($_POST['fixalbumcase'])) {
        closeWindow();
    } else {
        ?>
        <SCRIPT LANGUAGE=JAVASCRIPT TYPE="TEXT/JAVASCRIPT"><!--
            history.back();
            -->
        </SCRIPT>
        <?php
    }

    exit();
}

// Now let's see if they wanted to discuss a track or not
if (isset($_POST['discusstrack'])) {
    $client_ip = $_SERVER['REMOTE_ADDR'];

    $desc_file_name = str_replace('/', '---', jzstripslashes($_POST['filename'])) . '.disc';

    if ('---' == mb_substr($desc_file_name, 0, 3)) {
        $desc_file_name = mb_substr($desc_file_name, 3, 9999);
    }

    $disc_file = $web_root . $root_dir . '/data/discussions/' . $desc_file_name;

    $new_rating = $_POST['new_comments'];

    // Let's see if they are editing or adding

    if ('new' == $_POST['insert_type']) {
        // First let's see if this user has rated this file yet or not

        if (is_file($disc_file)) {
            $handle = fopen($disc_file, 'rb');

            $contents = fread($handle, filesize($disc_file));

            fclose($handle);

            // Now let's look to see if they've commented on it yet

            if (mb_stristr($contents, $_COOKIE['jz_user_name'] . '|')) {
                $not_rated = 'false';
            } else {
                $not_rated = 'true';
            }
        } else {
            $not_rated = 'true';
        }

        // Ok, if they haven't rated it yet, let's

        if ('true' == $not_rated) {
            if (!is_file($disc_file)) {
                touch($disc_file);
            }

            if (is_writable($disc_file)) {
                $handle = fopen($disc_file, 'ab');

                fwrite($handle, time() . '|' . $client_ip . '|' . $_COOKIE['jz_user_name'] . '|' . mb_substr($_POST['new_comments'], 0, 1000) . '|END');

                fclose($handle);
            }
        }
    } else {
        // Ok, let's edit, first we need to read in the old comment file....

        if (is_file($disc_file)) {
            $handle = fopen($disc_file, 'rb');

            $contents = fread($handle, filesize($disc_file));

            fclose($handle);

            // Ok, now we need to split that into an array

            $comArray = explode('|END', $contents);

            for ($i = 0, $iMax = count($comArray); $i < $iMax; $i++) {
                // Now let's find the comment by this user by creating yet another array

                $dataArray = explode('|', $comArray[$i]);

                if ($dataArray[2] == $_COOKIE['jz_user_name']) {
                    // Ok, lets update the date and comment

                    $dataArray[3] = $_POST['new_comments'];

                    $dataArray[0] = time();
                }

                // Now let's glue that back together

                $comArray[$i] = implode('|', $dataArray);
            }

            // Now let's write it out...

            if (is_writable($disc_file)) {
                $handle = fopen($disc_file, 'wb');

                for ($i = 0, $iMax = count($comArray); $i < $iMax; $i++) {
                    fwrite($handle, $comArray[$i] . '|END');
                }

                fclose($handle);
            }
        }
    }

    closeWindow('true');

    exit();
}

// Now let's see if they wanted to rate a track or not
if (isset($_POST['ratetrack'])) {
    $client_ip = $_SERVER['REMOTE_ADDR'];

    $rating_file_name = str_replace('/', '---', jzstripslashes($_POST['filename'])) . '.rating';

    if ('---' == mb_substr($rating_file_name, 0, 3)) {
        $rating_file_name = mb_substr($rating_file_name, 3, 9999);
    }

    $rating_file = $web_root . $root_dir . '/data/ratings/' . $rating_file_name;

    $new_rating = $_POST['rating'];

    // First let's see if this user has rated this file yet or not

    if (is_file($rating_file)) {
        $handle = fopen($rating_file, 'rb');

        $contents = fread($handle, filesize($rating_file));

        fclose($handle);

        // Now let's look to see if they've rated it yet

        if (mb_stristr($contents, $_COOKIE['jz_user_name'] . '|')) {
            $not_rated = 'false';
        } else {
            $not_rated = 'true';
        }
    } else {
        $not_rated = 'true';
    }

    // Now let's create the XML data

    $xmlData = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . '<jzRating ipaddress="' . $client_ip . '">' . "\n" . '   <username>' . $_COOKIE['jz_user_name'] . '</username>' . "\n" . '   <rating>' . $new_rating . '</rating>' . "\n" . '   <filedata>' . str_replace(
        '/',
        '---',
        jzstripslashes(
                $_POST['filename']
            )
    ) . '</filedata>' . "\n" . '</jzRating>' . "\n";

    // Ok, if they haven't rated it yet, let's

    if ('true' == $not_rated) {
        if (!is_file($rating_file)) {
            touch($rating_file);
        }

        if (is_writable($rating_file)) {
            $handle = fopen($rating_file, 'ab');

            fwrite($handle, $client_ip . '|' . $new_rating . '|' . $_COOKIE['jz_user_name'] . '|' . str_replace('/', '---', jzstripslashes($_POST['filename'])) . "\n");

            fclose($handle);
        }
    }

    closeWindow();

    exit();
}

// Now let's see if they wanted to close the window or not
if (isset($_POST['justclose']) or isset($_POST['closealbum'])) {
    closeWindow();

    exit();
}

// Let's see if they wanted to update a description
if (isset($_POST['updatedesc'])) {
    $fileName = $_POST['filename'];

    $handle = fopen($fileName, 'wb');

    fwrite($handle, $_POST['desc_contents']);

    fclose($handle);

    closeWindow();

    exit();
}

// Let's see if they wanted to update a description
if (isset($_POST['updateartdesc'])) {
    closeWindow('false');

    exit();
}

// Now let's see if they wanted to remove this featured artist
if (isset($_POST['removefeaturedalbum']) or isset($_POST['removefeaturedartist'])) {
    // Ok let's delete the feature file

    unlink($_POST['featuredXML']);

    closeWindow('false');

    exit();
}

// Did they want to add a featured artist
if (isset($_POST['addfeaturedartist'])) {
    // Now all we need to do is copy the corresponding XML file to the featured artists area

    $xmlFile = $web_root . $root_dir . '/data/artists/' . str_replace('/', '---', jzstripslashes($_POST['origgenreName'] . '/' . $_POST['origartistName'])) . '.xml';

    $destFile = $web_root . $root_dir . '/data/featured/artists/' . str_replace('/', '---', jzstripslashes($_POST['origgenreName'] . '/' . $_POST['origartistName'])) . '.xml';

    // Let's double verify

    if (is_file($xmlFile)) {
        // Ok, now let's copy it

        copy($xmlFile, $destFile);
    } else {
        // Ok, we need to build the XML file first

        createArtistXMLFile($web_root . $root_dir . $media_dir . '/' . $_POST['origgenreName'] . '/' . $_POST['origartistName'], $xmlFile);

        copy($xmlFile, $destFile);
    }

    closeWindow('false');

    exit();
}

// Let's see if they wanted to add something as a featured album
if (isset($_POST['addfeaturedalbum'])) {
    // Now all we need to do is copy the corresponding XML file to the featured artists area

    $xmlFile = $web_root . $root_dir . '/data/tracks/' . str_replace('/', '---', jzstripslashes($_POST['origgenreName'] . '/' . $_POST['origartistName'] . '/' . $_POST['origalbumName'])) . '.xml';

    $destFile = $web_root . $root_dir . '/data/featured/albums/' . str_replace('/', '---', jzstripslashes($_POST['origgenreName'] . '/' . $_POST['origartistName'] . '/' . $_POST['origalbumName'])) . '.xml';

    // Let's double verify

    if (is_file($xmlFile)) {
        // Ok, now let's copy it

        copy($xmlFile, $destFile);
    }

    closeWindow('false');

    exit();
}

if (isset($_POST['excludealbum'])) {
    // Ok, let's write that to the global exclude file

    $fileName = $web_root . $root_dir . '/data/global-exclude.lst';

    $handle = fopen($fileName, 'ab');

    fwrite($handle, $_POST['origartistName'] . '/' . $_POST['origalbumName'] . "\n");

    fclose($handle);

    closeWindow('true');

    exit();
}

// Let's see if they wanted to update a description
if (isset($_POST['updatealbumdesc'])) {
    closeWindow();

    exit();
}

// Let's see if they wanted to update a description
if (isset($_POST['updatesongdesc'])) {
    closeWindow();

    exit();
}

// Let's see if they wanted to delete the ablum
if (isset($_POST['deletealbum'])) {
    // Ok, let's kill it

    deldir($web_root . $root_dir . $media_dir . '/' . $_POST['origgenreName'] . '/' . $_POST['origartistName'] . '/' . $_POST['origalbumName']);

    // Now let's close this window and refresh the parent

    closeWindow();

    exit();
}

// Let's see if they wanted to update the data or not
if (isset($_POST['closeupdateartistdata'])) {
    // Now let's update the description file

    if ('' != $_POST['desc_contents']) {
        $fileName = $_POST['filename'];

        $handle = fopen($fileName, 'wb');

        fwrite($handle, $_POST['desc_contents']);

        fclose($handle);
    }

    if ('' != $_POST['long_desc']) {
        $fileName = $_POST['long_file_name'];

        $handle = fopen($fileName, 'wb');

        fwrite($handle, $_POST['long_desc']);

        fclose($handle);
    }

    if ('none' != $_FILES['artist_img']['tmp_name']) {
        // First let's kill any images that where there

        $retArray = readDirInfo($img_path, 'file');

        for ($i = 0, $iMax = count($retArray); $i < $iMax; $i++) {
            if (preg_match("/\.($ext_graphic)$/i", $retArray[$i])) {
                // Alright let's kill them...

                unlink($img_path . '/' . $retArray[$i]);
            }
        }

        $img_path = $_POST['img_path'];

        copy($_FILES['artist_img']['tmp_name'], $img_path . '/' . $_FILES['artist_img']['name']);
    }

    // Ok, now we need to figure out what they wanted to do:

    $origGenre = $web_root . $root_dir . $media_dir . '/' . $origgenreName;

    $origArtist = $web_root . $root_dir . $media_dir . '/' . $origgenreName . '/' . $origartistName;

    $origAlbum = $web_root . $root_dir . $media_dir . '/' . $origgenreName . '/' . $origartistName . '/' . $origalbumName;

    // Ok, now let's get the new stuff

    $newGenre = $web_root . $root_dir . $media_dir . '/' . $genreName;

    $newArtist = $web_root . $root_dir . $media_dir . '/' . $genreName . '/' . $origartistName;

    $newAlbum = $web_root . $root_dir . $media_dir . '/' . $genreName . '/' . $origartistName . '/' . $origalbumName;

    // Ok, let's see what we need to do, if anything...

    if ($newGenre != $origGenre) {
        // Ok, we need to move the album to a new genre too

        // First let's see if the new artist folder exists

        if ('Windows_NT' != $_ENV['OS']) {
            exec('mv "' . $origGenre . '/' . $origartistName . '" "' . $newGenre . '/' . $origartistName . '"');
        }

        if ('Windows_NT' == $_ENV['OS']) {
            exec('move "' . $origGenre . '/' . $origartistName . '" "' . $newGenre . '/' . $origartistName . '"');
        }

        $origArtist = $web_root . $root_dir . $media_dir . '/' . $genreName . '/' . $artistName;

        $origAlbum = $web_root . $root_dir . $media_dir . '/' . $genreName . '/' . $artistName . '/' . $origalbumName;
    }

    if ($newArtist != $origArtist) {
        // Ok, we need to move the album to a new artist

        // First we need to see if we need to create a new directory for the new stuff

        if (!is_dir($newArtist)) {
            mkdir($newArtist, 0700);
        }

        $origAlbum;

        rename($origAlbum, $newArtist . '/' . $origalbumName);

        // Now we need to fix the variables incase we need to do more moves

        $origAlbum = $web_root . $root_dir . $media_dir . '/' . $origgenreName . '/' . $artistName . '/' . $origalbumName;
    }

    if ($newAlbum != $origAlbum) {
        // Ok, we need to rename the album

        rename($origAlbum, $newAlbum);
    }

    // Now let's close this window and refresh the parent

    closeWindow();

    exit();
}

// Let's see if they wanted to update an ablum
if (isset($_POST['closeupdatealbumdata'])) {
    $origGenre = $_POST['origgenreName'];

    $origArist = $_POST['origartistName'];

    $origAlbum = $_POST['origalbumName'];

    $newGenre = $_POST['origgenreName'];

    $newArtist = $_POST['origartistName'];

    $newAlbum = $_POST['albumName'];

    // Ok, now let's move it

    if ('Windows_NT' != $_ENV['OS']) {
        exec('mv "' . $web_root . $root_dir . $media_dir . '/' . $origGenre . '/' . $origArist . '/' . $origAlbum . '" "' . $web_root . $root_dir . $media_dir . '/' . $newGenre . '/' . $origartistName . '/' . $newAlbum . '"');
    }

    if ('Windows_NT' == $_ENV['OS']) {
        exec('move "' . $web_root . $root_dir . $media_dir . '/' . $origGenre . '/' . $origArist . '/' . $origAlbum . '" "' . $web_root . $root_dir . $media_dir . '/' . $newGenre . '/' . $origartistName . '/' . $newAlbum . '"');
    }

    // Let's output the stylesheet

    echo "<link rel=\"stylesheet\" href=\"style/$jinzora_skin/default.css\" type=\"text/css\">";

    // First let's let them know we are updating the data

    echo 'Please wait while we update the data';

    flushDisplay();

    // Now let's get on with it...

    $fileName = $_POST['desc_filename'];

    if ('' != $_POST['desc_contents']) {
        $handle = fopen($fileName, 'wb');

        fwrite($handle, $_POST['desc_contents']);

        fclose($handle);
    }

    if ('' != $_FILES['album_img']['tmp_name']) {
        // First let's kill any images that where there

        $retArray = readDirInfo($img_path, 'file');

        for ($i = 0, $iMax = count($retArray); $i < $iMax; $i++) {
            if (preg_match("/\.($ext_graphic)$/i", $retArray[$i])) {
                // Alright let's kill them...

                unlink($img_path . '/' . $retArray[$i]);
            }
        }

        $img_path = $_POST['img_path'];

        echo '<br><br>Uploading new image...';

        if (copy($_FILES['album_img']['tmp_name'], $img_path . '/' . $_FILES['album_img']['name'])) {
            echo '<font color=green>Success!</font><br><br>';
        } else {
            echo '<font color=red>Failed!</font><br><br>';
        }

        flushDisplay();
    }

    // Now let's see if they wanted to update the year on all the ID3 tags

    if ('' != $_POST['album_year']) {
        echo 'Updating the year on all subtracks:<br><br>';

        flushDisplay();

        // Ok, let's get all the files and write the year on them

        $retArray = readDirInfo($img_path, 'file');

        for ($i = 0, $iMax = count($retArray); $i < $iMax; $i++) {
            if (preg_match("/\.($audio_types)$/i", $retArray[$i])) {
                echo '<nobr>' . $retArray[$i];

                flushDisplay();

                // Alright let's update the year

                $getID3 = new getID3();

                getid3_lib::IncludeDependency('id3classes/write.php', __FILE__, true);

                $tagwriter = new getid3_writetags();

                $data['year'][] = $_POST['album_year'];

                // Now let's write the tags

                $tagwriter->tag_data = $data;

                $tagwriter->filename = $img_path . '/' . $retArray[$i];

                $tagwriter->tagformats = ['id3v1', 'id3v2.3'];

                if ($tagwriter->WriteTags()) {
                    echo ' - <font color=green>Success!</font><br>';
                } else {
                    echo ' - <font color=red>Failed!</font><br>';
                }

                echo '</nobr>';

                flushDisplay();

                unset($getID3);
            }
        }
    }

    // Now let's set what the XML file should be

    $fileArray = explode('/', $img_path);

    unset($fileArray[count($fileArray) - 1]);

    $artistPath = implode('/', $fileArray);

    $xmlFile = $web_root . $root_dir . '/data/artists/' . str_replace('/', '---', str_replace($web_root . $root_dir . $media_dir . '/', '', $artistPath)) . '.xml';

    while ('---' == mb_substr($xmlFile, 0, 3)) {
        $xmlFile = mb_substr($xmlFile, 3, mb_strlen($xmlFile));
    }

    echo '<br><br>Updating Artist XML Cache...';

    flushDisplay();

    createArtistXMLFile($artistPath, $xmlFile);

    echo '<br><br>Updates Complete!';

    flushDisplay();

    sleep(1);

    closeWindow();

    exit();
}

// Now let's see if they wanted to exclude an artist
if (isset($_POST['excludeartist'])) {
    // Ok, let's exclude what they wanted

    excludeItem($_POST['origartistName']);

    closeWindow();

    exit();
}

// Now let's see if they wanted to exclude an artist
if (isset($_POST['excludegenre'])) {
    // Ok, let's exclude what they wanted

    excludeItem($_POST['origgenreName']);

    // Now let's close this window and refresh the parent

    closeWindow();

    exit();
}

// Now let's delete the genre
if (isset($_POST['deletegenre'])) {
    echo $_POST['origgenreName'];

    deldir($web_root . $root_dir . $media_dir . '/' . $_POST['origgenreName']);

    // Now let's close this window and refresh the parent

    closeWindow();

    exit();
}

// This function figures out the page to return too
// Added 4.6.04 by Ross Carlson
// Returns the page to go back to
function returnGoBackPage($page)
{
    global $cms_mode;

    // Now let's split this into an array so we can get all the paramaters

    $pageArray = explode('&', $page);

    // Let's split the page name from the paramaters

    $splitArray = explode('?', $pageArray[0]);

    $pageName = $splitArray[0];

    // Now let's fix up the first one, so we'll have just the URL

    $pageArray[0] = $splitArray[1];

    for ($i = 0, $iMax = count($pageArray); $i < $iMax; $i++) {
        // now let's fix it up

        if (mb_stristr($pageArray[$i], 'genre')) {
            $pageArray[$i] = '';
        }

        if (mb_stristr($pageArray[$i], 'artist')) {
            $pageArray[$i] = '';
        }

        if (mb_stristr($pageArray[$i], 'album')) {
            $pageArray[$i] = '';
        }
    }

    // Now let's put it back together

    $page = implode('&', $pageArray);

    // Now let's remove any &&

    while (mb_stristr($page, '&&')) {
        $page = str_replace('&&', '', $page);
    }

    $page = $pageName . '?' . $page;

    return $page;
}

// Now let's se if they selected a Genre
if (isset($_POST['chosenGenre'])) {
    $return = returnGoBackPage($_POST['return']);

    switch ($directory_level) {
        case '3': # 3 directories deep
            $url = $return . $return . '&ptype=genre&genre=' . $_POST['chosenGenre'];
            break;
    }

    // Now let's fix that if we need to

    if (mb_stristr($url, '?&')) {
        $url = str_replace('?&', '?', $url);
    }

    // Ok, now that we've got the URL let's refresh the parent and close this window

    echo '<body onload="opener.location.href=\'' . $url . '\';window.close();">';

    exit();
}

// Now let's see if they submitted the artist select form or not
if (isset($_POST['chosenArtist'])) {
    $return = returnGoBackPage($_POST['return']);

    // Ok, now we know who they selected, so we need to refresh the parent with that data

    // First let's split the stuff out

    $artistData = explode('--', $_POST['chosenArtist']);

    switch ($directory_level) {
        case '3': # 3 directories deep
            $url = $return . '&ptype=artist&genre=' . $artistData[1] . '&artist=' . $artistData[0];
            break;
        case '2': # 2 directories deep
            $url = $return . '&ptype=artist&genre=/&artist=' . $artistData[0];
            break;
    }

    // Now let's fix that if we need to

    if (mb_stristr($url, '?&')) {
        $url = str_replace('?&', '?', $url);
    }

    // Ok, now that we've got the URL let's refresh the parent and close this window

    echo '<body onload="opener.location.href=\'' . $url . '\';window.close();">';

    exit();
}

// Now let's see if they submitted the artist select form or not
if (isset($_POST['chosenAlbum'])) {
    $return = returnGoBackPage($_POST['return']);

    // Ok, now we know who they selected, so we need to refresh the parent with that data

    // First let's split the stuff out

    $artistData = explode('--', $_POST['chosenAlbum']);

    switch ($directory_level) {
        case '3': # 3 directories deep
            $url = $return . '&ptype=songs&genre=' . $artistData[1] . '&artist=' . $artistData[2] . '&album=' . $artistData[0];
            break;
        case '2': # 2 directories deep
            $url = $return . '&ptype=songs&genre=/&artist=' . $artistData[1] . '&album=' . $artistData[0];
            break;
    }

    // Ok, now that we've got the URL let's refresh the parent and close this window

    echo '<body onload="opener.location.href=\'' . $url . '\';window.close();">';

    exit();
}

// This function will display the complete list of Genres
// Added 4.6.04 by Ross Carlson
function displayAllGenre()
{
    global $web_root, $root_dir;

    // Let's display the top of our page

    displayPageTop();

    echo '<center>';

    // Now let's give them a list of choices

    $this_page = $_SERVER['REQUEST_URI'];

    if ('' == $this_page) {
        $this_page = $_SERVER['URL'] . '?' . $_SERVER['QUERY_STRING'];
    }

    if (mb_stristr($this_page, '&g=')) {
        $this_page = mb_substr($this_page, 0, mb_strpos($this_page, '&g'));
    }

    $i = 97;

    $c = 2;

    echo '<a href="' . $this_page . '&g=NUM">1-10</a> | ';

    while ($i < 123) {
        echo '<a href="' . $this_page . '&g=' . chr($i) . '">' . mb_strtoupper(chr($i)) . '</a>';

        if (0 == $c % 9) {
            echo '<br>';
        } else {
            echo ' | ';
        }

        $i++;

        $c++;
    }

    echo '<br><br>';

    // Now let's setup our form

    echo '<form action="' . $this_page . '" method="post" name="selectGenre">';

    // Now let's set so we'll know where to go back to

    echo '<input type="hidden" name="return" value="' . $_GET['return'] . '">';

    // Now let's see if they wanted a letter or not

    if (isset($_GET['g'])) {
        // Now let's get all the artists from our cache file

        $filename = $web_root . $root_dir . '/data/genre_list.lst';

        $handle = fopen($filename, 'rb');

        $artistList = fread($handle, filesize($filename));

        fclose($handle);

        // Now let's loop through that list

        $artArray = explode("\n", $artistList);

        sort($artArray);

        echo '<select name="chosenGenre" size="22" class="jz_select" style="width: 200px" onChange="submit()">';

        for ($i = 0, $iMax = count($artArray); $i < $iMax; $i++) {
            // Now let's see if we have a match

            if ($_GET['g'] == mb_strtolower(mb_substr(urldecode($artArray[$i]), 0, 1))) {
                $dispArray = explode('--', $artArray[$i]);

                echo '<option value="' . $artArray[$i] . '">' . urldecode($artArray[$i]);
            }

            if ('NUM' == $_GET['g'] and is_numeric(mb_strtolower(mb_substr(urldecode($artArray[$i]), 0, 1)))) {
                echo '<option value="' . $artArray[$i] . '">' . urldecode($artArray[$i]);
            }
        }

        echo '</select>';
    }

    echo '</form>';

    echo '</center>';

    exit();
}

// This function will display the complete list of artists
function displayAllArtists()
{
    global $web_root, $root_dir;

    // Let's display the top of our page

    displayPageTop();

    echo '<center>';

    // Now let's give them a list of choices

    $this_page = $_SERVER['REQUEST_URI'];

    if ('' == $this_page) {
        $this_page = $_SERVER['URL'] . '?' . $_SERVER['QUERY_STRING'];
    }

    if (mb_stristr($this_page, '&i=')) {
        $this_page = mb_substr($this_page, 0, mb_strpos($this_page, '&i'));
    }

    $i = 97;

    $c = 2;

    echo '<a href="' . $this_page . '&i=NUM">1-10</a> | ';

    while ($i < 123) {
        echo '<a href="' . $this_page . '&i=' . chr($i) . '">' . mb_strtoupper(chr($i)) . '</a>';

        if (0 == $c % 9) {
            echo '<br>';
        } else {
            echo ' | ';
        }

        $i++;

        $c++;
    }

    echo '<br><br>';

    // Now let's setup our form

    echo '<form action="' . $this_page . '" method="post" name="selectArtist">';

    // Now let's set so we'll know where to go back to

    echo '<input type="hidden" name="return" value="' . $_GET['return'] . '">';

    // Now let's see if they wanted a letter or not

    if (isset($_GET['i'])) {
        // Now let's get all the artists from our cache file

        $filename = $web_root . $root_dir . '/data/artist_list.lst';

        $handle = fopen($filename, 'rb');

        $artistList = fread($handle, filesize($filename));

        fclose($handle);

        // Now let's loop through that list

        $artArray = explode("\n", $artistList);

        sort($artArray);

        echo '<select name="chosenArtist" size="22" class="jz_select" style="width: 200px" onChange="submit()">';

        for ($i = 0, $iMax = count($artArray); $i < $iMax; $i++) {
            // Now let's get just the artist

            $artistArray = explode('--', $artArray[$i]);

            // Now let's see if we have a match

            if ($_GET['i'] == mb_strtolower(mb_substr(urldecode($artArray[$i]), 0, 1))) {
                $dispArray = explode('--', $artArray[$i]);

                echo '<option value="' . $artArray[$i] . '">' . urldecode($dispArray[0]);
            }

            if ('NUM' == $_GET['i'] and is_numeric(mb_strtolower(mb_substr(urldecode($artArray[$i]), 0, 1)))) {
                $dispArray = explode('--', $artArray[$i]);

                echo '<option value="' . $artArray[$i] . '">' . urldecode($dispArray[0]);
            }
        }

        echo '</select>';
    }

    echo '</form>';

    echo '</center>';

    exit();
}

// This function will display the complete list of artists
function displayAllAlbums()
{
    global $web_root, $root_dir, $directory_level;

    // Let's display the top of our page

    displayPageTop();

    echo '<center>';

    // Now let's give them a list of choices

    $this_page = $_SERVER['REQUEST_URI'];

    if ('' == $this_page) {
        $this_page = $_SERVER['URL'] . '?' . $_SERVER['QUERY_STRING'];
    }

    if (mb_stristr($this_page, '&i=')) {
        $this_page = mb_substr($this_page, 0, mb_strpos($this_page, '&i'));
    }

    $i = 97;

    $c = 2;

    echo '<a href="' . $this_page . '&a=NUM">1-10</a> | ';

    while ($i < 123) {
        echo '<a href="' . $this_page . '&a=' . chr($i) . '">' . mb_strtoupper(chr($i)) . '</a>';

        if (0 == $c % 9) {
            echo '<br>';
        } else {
            echo ' | ';
        }

        $i++;

        $c++;
    }

    echo '<br><br>';

    // Now let's setup our form

    echo '<form action="' . $this_page . '" method="post" name="selectAlbum">';

    // Now let's set so we'll know where to go back to

    echo '<input type="hidden" name="return" value="' . $_GET['return'] . '">';

    // Now let's see if they wanted a letter or not

    if (isset($_GET['a'])) {
        // Now let's get all the artists from our cache file

        $filename = $web_root . $root_dir . '/data/album_list.lst';

        $handle = fopen($filename, 'rb');

        $artistList = fread($handle, filesize($filename));

        fclose($handle);

        // Now let's loop through that list

        $artArray = explode("\n", $artistList);

        sort($artArray);

        echo '<select name="chosenAlbum" size="22" class="jz_select" style="width: 200px" onChange="submit()">';

        for ($i = 0, $iMax = count($artArray); $i < $iMax; $i++) {
            // Now let's get just the artist

            $artistArray = explode('--', $artArray[$i]);

            // Now let's see if we have a match

            if ($_GET['a'] == mb_strtolower(mb_substr(urldecode($artArray[$i]), 0, 1))) {
                $dispArray = explode('--', $artArray[$i]);

                echo '<option value="' . $artArray[$i] . '">' . urldecode($dispArray[0]);
            }

            if ('NUM' == $_GET['a'] and is_numeric(mb_strtolower(mb_substr(urldecode($artArray[$i]), 0, 1)))) {
                $dispArray = explode('--', $artArray[$i]);

                echo '<option value="' . $artArray[$i] . '">' . urldecode($dispArray[0]);
            }

            // Now let's show them the artist

            switch ($directory_level) {
                case '3':
                    echo ' &nbsp; - &nbsp; (' . urldecode($dispArray[2]) . ')';
                    break;
                case '2':
                    echo ' &nbsp; - &nbsp; (' . urldecode($dispArray[1]) . ')';
                    break;
            }
        }

        echo '</select>';
    }

    echo '</form>';

    echo '</center>';

    exit();
}

// This function will close the window
function closeWindow($parent_reload = 'true')
{
    if ('true' == $parent_reload) {
        echo '<body onload="opener.location.reload(true);window.close();">';
    } else {
        echo '<body onload="window.close();">';
    }
}

// Now let's see if they chose a directory to upload something into
if (isset($_POST['submit_newdir'])) {
    // Let's set where to go back to

    $url = $_POST['return_page'] . '&uploadDest=' . urlencode($_POST['newdir']);

    // Ok, now that we've got the URL let's refresh the parent and close this window

    echo '<body onload="opener.location.href=\'' . $url . '\';window.close();">';

    exit();
}

// Let's see what kind of page this is:
if (isset($_GET['type'])) {
    switch ($_GET['type']) {
        case 'album': # Ok they wanted to see album info
            displayAlbumInfo();
            break;
        case 'artist': # Ok they wanted to see album info
            displayArtistInfo();
            break;
        case 'genre': # Ok they wanted to see album info
            displayGenreInfo();
            break;
        case 'lyrics': # Ok they wanted to view some lyrics
            displayLyrics();
            break;
        case 'rate':
            displayRatingPopup();
            break;
        case 'discuss':
            displayDiscuss();
            break;
        case 'bulkalbum':
            displayBulkAlbum();
            exit();
            break;
        case 'allgenre':
            displayAllGenre();
            exit();
            break;
        case 'allartists':
            displayAllArtists();
            exit();
            break;
        case 'allalbums':
            displayAllAlbums();
            exit();
            break;
        case 'uploadbrowser':
            displayUploadBrowser();
            exit();
            break;
        case 'displayWMA':
            displayWMAPlayer();
            exit();
            break;
        case 'displayJava':
            displayJavaPlayer();
            exit();
            break;
        case 'addfake':
            displayAddFake();
            exit();
            break;
        case 'descEdit':
            displayDescEdit();
            exit();
            break;
        case 'addmedia':
            displayAddMedia();
            exit();
            break;
        default: # Ok, they must have wanted a single track
            displayTrackInfo();
            break;
    }
} else {
    displayTrackInfo();
}
/**
 * Displays the page with the forms for uploading media
 *
 * @author  Ross Carlson
 * @version 05/26/04
 * @since   05/26/04
 */
function displayAddMedia()
{
    global $mp3_dir, $this_page, $main_table_width, $url_seperator, $root_dir, $word_select_destination, $word_dest_path, $word_add_files, $word_upload, $word_clear_list, $word_current_file, $word_total_complete, $word_upload_center, $bg_c, $fg_c, $cms_mode, $text_c;

    // Now let's see what type of upload they wanted

    $formType = $_GET['formType'] ?? $_COOKIE['jz_upload_applet_type'] ?? 'applet';

    // Let's write the cookie that they selected this

    setcookie('jz_upload_applet_type', $formType, time() + 60 * 60 * 24 * 365, '/', '', 0);

    // Let's display the top of our page

    displayPageTop($bg_c);

    // Let's display our tabs so they can select the upload type to use

    jzHREF('mp3info.php?type=addmedia&uploadDest=' . urlencode($_GET['uploadDest']) . '&cur_theme=' . $_GET['cur_theme'] . '&formType=applet', '', '', '', 'Applet');

    echo ' | ';

    jzHREF('mp3info.php?type=addmedia&uploadDest=' . urlencode($_GET['uploadDest']) . '&cur_theme=' . $_GET['cur_theme'] . '&formType=form', '', '', '', 'Form');

    echo ' | ';

    jzHREF('mp3info.php?type=addmedia&uploadDest=' . urlencode($_GET['uploadDest']) . '&cur_theme=' . $_GET['cur_theme'] . '&formType=email', '', '', '', 'Email');

    // Now let's display the appropriate form

    switch ($formType) {
        case 'applet':
            // Now let's display the Java applet
            ?>
            <center>
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
            </center>
            <?php
            break;
        case 'form':
            // Now let's display the HTML form for uploading
            ?>
            <br>
            <center>
                <form action="mp3info.php" name="addMediaForm" enctype="multipart/form-data" method="post">
                    Destination Path:<br>
                    <input size="50" type="text" name="destPath" value="<?php echo urldecode($_GET['uploadDest']); ?>" class="jz_input"><br><br>
                    File 1: <input size="50" type="file" name="file1" class="jz_input"><br><br>
                    File 2: <input size="50" type="file" name="file2" class="jz_input"><br><br>
                    File 3: <input size="50" type="file" name="file3" class="jz_input"><br><br>
                    File 4: <input size="50" type="file" name="file4" class="jz_input"><br><br>
                    File 5: <input size="50" type="file" name="file5" class="jz_input"><br><br>
                    File 6: <input size="50" type="file" name="file6" class="jz_input"><br><br>
                    File 7: <input size="50" type="file" name="file7" class="jz_input"><br><br>
                    File 8: <input size="50" type="file" name="file8" class="jz_input"><br><br>
                    File 9: <input size="50" type="file" name="file9" class="jz_input"><br><br>
                    <input type="submit" name="uploadFiles" value="Upload Now" class="jz_submit">
                </form>
            </center>
            <?php
            break;
        case 'email':
            // Now let's display the HTML form for uploading
            ?>
            <br>
            <center>
                <form action="mp3info.php" name="addMediaForm" method="post">
                    Destination Path:<br>
                    <input size="50" type="text" name="destPath" value="<?php echo urldecode($_GET['uploadDest']); ?>" class="jz_input"><br><br>
                    <input type="submit" name="scanMailbox" value="Scan Mailbox and Upload" class="jz_submit">
                </form>
            </center>
            <?php
            break;
        case 'url':
            // Now let's display the HTML form for uploading
            ?>
            <br>
            <center>
                <form action="mp3info.php" name="addMediaForm" method="post">
                    Destination Path:<br>
                    <input size="50" type="text" name="destPath" value="<?php echo urldecode($_GET['uploadDest']); ?>" class="jz_input"><br><br>
                    File: <input size="50" type="text" name="urlPath" class="jz_input"><br><br>
                    <input type="submit" name="uploadFiles" value="Upload Now" class="jz_submit">
                </form>
            </center>
            <?php
            break;
    }
}

// This function displays the window to allow the user to edit the site description files
// Added 4.18.04 by Ross Carlson
function displayDescEdit()
{
    global $word_update_description, $web_root, $root_dir, $media_dir, $word_header_contents, $word_footer_contents, $word_site_desc, $word_slim_header, $word_slim_footer;

    // Let's display the top of our page

    displayPageTop();

    // Now let's read the files

    $desc_file = $web_root . $root_dir . $media_dir . '/header.txt';

    if (is_file($desc_file)) {
        $handle = fopen($desc_file, 'rb');

        $header_con = fread($handle, filesize($desc_file));

        fclose($handle);
    }

    $desc_file = $web_root . $root_dir . $media_dir . '/footer.txt';

    if (is_file($desc_file)) {
        $handle = fopen($desc_file, 'rb');

        $footer_con = fread($handle, filesize($desc_file));

        fclose($handle);
    }

    $desc_file = $web_root . $root_dir . $media_dir . '/site-description.txt';

    if (is_file($desc_file)) {
        $handle = fopen($desc_file, 'rb');

        $site_con = fread($handle, filesize($desc_file));

        fclose($handle);
    }

    $desc_file = $web_root . $root_dir . $media_dir . '/slim-header.txt';

    if (is_file($desc_file)) {
        $handle = fopen($desc_file, 'rb');

        $slim_head = fread($handle, filesize($desc_file));

        fclose($handle);
    }

    $desc_file = $web_root . $root_dir . $media_dir . '/slim-footer.txt';

    if (is_file($desc_file)) {
        $handle = fopen($desc_file, 'rb');

        $slim_foot = fread($handle, filesize($desc_file));

        fclose($handle);
    }

    echo '<form action="mp3info.php" method="POST" name="mp3infoform" enctype="multipart/form-data">'
         . "\n"
         . '<table width="100%" cellpadding="'
         . $song_cellpadding
         . '" cellspacing="0" class="jz_track_table">'
         . "\n"
         . '<tr class="jz_row1">'
         . "\n"
         . '<td class="jz_track_table_songs_td" align="center">'
         . $word_header_contents
         . '<br>'
         . '<textarea name="header" cols="30" rows="4" class="jz_input">'
         . $header_con
         . '</textarea><br><br>'
         . $word_footer_contents
         . '<br>'
         . '<textarea name="footer" cols="30" rows="4" class="jz_input">'
         . $footer_con
         . '</textarea><br><br>'
         . $word_site_desc
         . '<br>'
         . '<textarea name="site" cols="30" rows="4" class="jz_input">'
         . $site_con
         . '</textarea><br><br>'
         . $word_slim_header
         . '<br>'
         . '<textarea name="slim-head" cols="30" rows="4" class="jz_input">'
         . $slim_head
         . '</textarea><br><br>'
         . $word_slim_footer
         . '<br>'
         . '<textarea name="slim-foot" cols="30" rows="4" class="jz_input">'
         . $slim_foot
         . '</textarea><br><br>'
         . '<input class="jz_submit" type="submit" name="updateSiteDesc" value="'
         . $word_update_description
         . '"><br><br>'
         . '</td>'
         . "\n"
         . '</tr>'
         . "\n"
         . '</table>'
         . "\n"
         . '</form></body>'
         . "\n";
}

// This function show the box where the user can create a "fake" track for Jinzora to display
// Added 4.18.04 by Ross Carlson
function displayAddFake()
{
    // Let's display the top of our page

    displayPageTop();

    echo '<form action="mp3info.php" method="POST" name="mp3infoform" enctype="multipart/form-data">'
         . "\n"
         . '<input type="hidden" name="desc_filename" value="'
         . $_GET['info']
         . '">'
         . '<table width="100%" cellpadding="'
         . $song_cellpadding
         . '" cellspacing="0" class="jz_track_table">'
         . "\n"
         . '<tr class="jz_row1">'
         . "\n"
         . '<td class="jz_track_table_songs_td">Track Name:</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . '<input class="jz_input" type="text" name="fakeTrackName" size="30"><br>'
         . '</td>'
         . "\n"
         . '</tr>'
         . "\n"
         . '<tr class="jz_row2">'
         . "\n"
         . '<td class="jz_track_table_songs_td">Link:</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . '<input class="jz_input" type="text" name="fakeTrackLink" value="http://" size="30"><br>'
         . '</td>'
         . "\n"
         . '</tr>'
         . "\n"
         . '<tr class="jz_row1">'
         . "\n"
         . '<td class="jz_track_table_songs_td">Description:</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . '<input class="jz_input" type="text" name="fakeTrackDesc" size="30"><br>'
         . '</td>'
         . "\n"
         . '</tr>'
         . "\n"
         . '<tr class="jz_row2">'
         . "\n"
         . '<td class="jz_track_table_songs_td" colspan="2" width="100%" align="center">'
         . '<br><input type=submit class="jz_submit" name="createfake" value="Create"><br><br>'
         . '</td>'
         . "\n"
         . '</tr>'
         . "\n"
         . '</table>'
         . "\n"
         . '</form></body>'
         . "\n";
}

// This function displays the windows media player embedded players
// Added 4.2.04 by Ross Carlson
function displayWMAPlayer()
{
    global $word_nowplaying, $audio_types;

    // Let's display the top of our page

    displayPageTop();

    echo '<br><center>';

    if ('' != $_GET['name']) {
        echo '<strong>' . $word_nowplaying . '</strong><br>';

        echo '<br>' . $_GET['name'] . '<br>';
    }

    echo '<br>';

    // Now let's figure out the width and height

    if (preg_match("/\.($audio_types)$/i", $_GET['track'])) {
        $height = 45;

        $width = 280;
    } else {
        $height = $_GET['height'] - 100;

        $width = $_GET['width'] - 100;
    }

    // Now let's show the player

    echo '<OBJECT ID="Player"'
         . 'WIDTH="'
         . $width
         . '"'
         . 'HEIGHT="'
         . $height
         . '"'
         . 'CLASSID="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95"'
         . 'CODEBASE="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,7,1112"'
         . 'STANDBY="Loading Windows Media Player components..."'
         . 'TYPE="application/x-oleobject"'
         . 'ALIGN="bottom" '
         . 'VIEWASTEXT>'
         . '<PARAM NAME="FileName" VALUE="'
         . $_GET['track']
         . '">'
         . '<PARAM NAME="AutoStart" VALUE="1">'
         . '<PARAM NAME="AutoSize" VALUE="1">'
         . '<PARAM NAME="ShowStatusBar" VALUE="0">'
         . '<PARAM NAME="Displaysize" VALUE="0">'
         . '<PARAM NAME="EnableContextMenu" VALUE="0">'
         . '<PARAM NAME="ShowControls" VALUE="1">'
         . '<EMBED '
         . 'TYPE="video/x-ms-asf-plugin"'
         . 'PLUGINSPAGE="http://www.microsoft.com/windows/mediaplayer/download/default.asp"'
         . 'SRC="'
         . $_GET['track']
         . '"'
         . 'SHOWCONTROLS="1"'
         . 'SHOWSTATUSBAR="0"'
         . 'SHOWPOSITIONCONTROLS="0"'
         . 'AUTOSIZE="1"'
         . 'HEIGHT="'
         . $height
         . '"'
         . 'WIDTH="'
         . $width
         . '"'
         . 'DISPLAYSIZE="0">'
         . '</EMBED>'
         . '</OBJECT>';

    echo '</center>';

    // First let's set it so they can't right click ?>
    <SCRIPT LANGUAGE="JavaScript1.1">
			function noContext(){return false;}
			document.oncontextmenu = noContext;
			// -->

    </script>
    <?php

    exit();
}

// This function displays the java player
// Added 4.22.04 by Laurent Perrin
function displayJavaPlayer()
{
    global $word_nowplaying, $audio_types, $root_dir, $server_key, $client_key;

    // Let's display the top of our page

    displayPageTop();

    echo '<br><center>';

    if ('' != $_GET['name']) {
        echo '<strong>' . $word_nowplaying . '</strong><br>';

        echo '<br>' . $_GET['name'] . '<br>';
    }

    echo '<br>';

    // Now let's show the player

    echo '<OBJECT classid="clsid:8AD9C840-044E-11D1-B3E9-00805F499D93"
  WIDTH = "275"
  HEIGHT = "116"
name="player"
codebase="http://java.sun.com/products/plugin/1.3/jinstall-13-win32.cab#Version=1,3,0,0">
  <PARAM NAME = CODE VALUE = "javazoom.jlGui.applet.Player" >
  <PARAM NAME = ARCHIVE VALUE = "javaplayer/jlGuiApplet2.2.jar,javaplayer/jlGui2.2.jar,javaplayer/mp3sp.1.6.jar,javaplayer/jid3.jar,javaplayer/jl030.jar,
                                                     javaplayer/orbisspi0.7.jar,javaplayer/jorbis-0.0.12.jar,javaplayer/jogg-0.0.5.jar">
  <PARAM NAME="type" VALUE="application/x-java-applet;version=1.3">
  <PARAM NAME = "skin" VALUE ="/' . $root_dir . '/javaplayer/skins/baseskin.wsz">
  <PARAM NAME = "song" VALUE ="/' . $root_dir . '/javaplayer/get_song.php?info=' . str_replace(' ', '%20', $_GET['track']) . '">
  <PARAM NAME = "init" VALUE ="/' . $root_dir . '/javaplayer/jlgui.ini">
  <PARAM NAME = "server_key" VALUE ="' . $server_key . '">
  <PARAM NAME = "client_key" VALUE ="' . $client_key . '">
<COMMENT>
<EMBED type="application/x-java-applet;version=1.3"
  CODE = "javazoom.jlGui.applet.Player"
  ARCHIVE = "javaplayer/jlGuiApplet2.2.jar,javaplayer/jlGui2.2.jar,javaplayer/mp3sp.1.6.jar,javaplayer/jid3.jar,javaplayer/jl030.jar,
                   javaplayer/vorbisspi0.7.jar,javaplayer/jorbis-0.0.12.jar,javaplayer/jogg-0.0.5.jar"
  WIDTH = "275"
  HEIGHT = "116"
  name="player"
  skin = "http://' . $_SERVER['HTTP_HOST'] . '/' . $root_dir . '/javaplayer/skins/baseskin.wsz"
  song = "http://' . $_SERVER['HTTP_HOST'] . '/' . $root_dir . '/javaplayer/get_song.php?info=' . str_replace(' ', '%20', $_GET['track']) . '"
  init = "http://' . $_SERVER['HTTP_HOST'] . '/' . $root_dir . '/javaplayer/jlgui.ini"
  server_key ="' . $server_key . '"
  client_key ="' . $client_key . '"
pluginspage="http://java.sun.com/products/plugin/1.3/plugin-install.html">
<NOEMBED>
</COMMENT>
</NOEMBED></EMBED>
</OBJECT>';

    echo '</center>';

    // First let's set it so they can't right click ?>
    <SCRIPT LANGUAGE="JavaScript1.1">
			function noContext(){return false;}
			document.oncontextmenu = noContext;
			// -->

    </script>
    <?php

    exit();
}

// This displays the file upload browser
// Added 4/1/2004 by Ross Carlson
function displayUploadBrowser()
{
    global $web_root, $root_dir, $media_dir, $word_dest_path, $word_new_subdirectory, $word_select, $word_up_onelevel, $word_subdirs;

    // Let's display the top of our page

    displayPageTop();

    // Now let's get the URL for this page

    $this_page = $_SERVER['REQUEST_URI'];

    if ('' == $this_page) {
        $this_page = $_SERVER['URL'] . '?' . $_SERVER['QUERY_STRING'];
    }

    if (mb_stristr($this_page, '&path=')) {
        $this_page = mb_substr($this_page, 0, mb_strpos($this_page, '&path='));
    }

    if (mb_stristr($this_page, '%26uploadDest')) {
        $this_page = mb_substr($this_page, 0, mb_strpos($this_page, '%26uploadDest'));
    }

    $this_page = str_replace('%26%26', '%26', $this_page);

    echo '<center><strong>' . $word_dest_path . '</strong></center><br>';

    if (isset($_GET['path'])) {
        $path = $_GET['path'];

        $up_path = $path;

        $upArray = explode('/', $up_path);

        unset($upArray[count($upArray) - 1]);

        $up_path = implode('/', $upArray);

        if ('' == $up_path) {
            $up_path = '/';
        }
    } else {
        $path = '';

        $up_path = '';
    }

    $path = jzstripslashes($path);

    // Now let's setup our form

    echo '<form action="' . $this_page . '" method="POST">';

    echo '<input type="hidden" name="return_page" value="' . $_GET['return'] . '" name="uploadSelector">';

    echo ' &nbsp; ' . $word_new_subdirectory . ':<br> &nbsp; <input value="' . $path . '" type="text" size="40" name="newdir" class="jz_input"> ' . '<input type="submit" name="submit_newdir" value="' . $word_select . '" class="jz_submit"><br><br>';

    echo ' &nbsp; <img src="' . $root_dir . '/style/images/folder.gif" border="0"> <a href="' . $this_page . '&path=' . $up_path . '">' . $word_up_onelevel . '</a><br><br> &nbsp; <strong>' . $word_subdirs . ':</strong><br>';

    // Now let's get the level they are at so we can show them the choices

    $retArray = readDirInfo($web_root . $root_dir . $media_dir . '/' . $path, 'dir');

    for ($i = 0, $iMax = count($retArray); $i < $iMax; $i++) {
        echo '<nobr> &nbsp; &nbsp; &nbsp; <img src="' . $root_dir . '/style/images/folder.gif" border="0"> <a href="' . $this_page . '&path=' . $path . '/' . urlencode($retArray[$i]) . '">' . $retArray[$i] . '</a></nobr><br>';
    }

    echo '</form>';

    echo '<br>';
}

// This function starts off our pages
function displayPageTop($bg_color = '')
{
    global $web_root, $root_dir, $jinzora_skin, $cms_mode, $cms_type, $cur_theme;

    /* Let's include the javascript */

    echo '<script type="text/javascript" src="' . $root_dir . '/jinzora.js"></script>';

    // Let's start our page

    echo '<title>Item Details</title>';

    // Now let's see if they wanted a different background color

    if ('' == $bg_color) {
        echo '<body marginwidth=0 marginheight=0 style="margin: 0px">';
    } else {
        echo '<span style="font-size:0px">.</span><body marginwidth=0 marginheight=0 style="margin: 0px" style="background-color:' . $bg_color . '">';
    }

    // Now let's output the CMS style sheet, if necessary

    if ('false' != $cms_mode) {
        switch ($cms_type) {
            case 'phpnuke':
                echo '<link rel="stylesheet" href="../../themes/' . $cur_theme . '/style/style.css" type="text/css">';
                break;
            case 'cpgnuke':
                echo '<link rel="stylesheet" href="../../themes/' . $cur_theme . '/style/style.css" type="text/css">';
                break;
        }
    }

    // Let's output the Jinzora style sheet

    echo "<link rel=\"stylesheet\" href=\"$root_dir/style/" . $jinzora_skin . '/default.css" type="text/css">';
}

function displayLyrics()
{
    global $web_root, $root_dir, $media_dir;

    // Let's display the top of our page

    displayPageTop();

    // Now let's get the data from the file

    $filename = $web_root . $root_dir . $media_dir . '/' . urldecode($_GET['info']);

    $handle = fopen($filename, 'rb');

    $contents = fread($handle, filesize($filename));

    fclose($handle);

    echo '<table width="100%" cellpadding="'
         . $song_cellpadding
         . '" cellspacing="0" class="jz_track_table" height="100%">'
         . "\n"
         . '<tr class="jz_row1">'
         . "\n"
         . '<td width="100%" class="jz_track_table_songs_td" valign="top">'
         . $contents
         . "\n"
         . '<br><br><center><input class="jz_submit" value="Close Window" type="button" onClick="window.close();"></center><br><br>'
         . "\n"
         . '</td>'
         . "\n"
         . '</tr>'
         . "\n"
         . '</table>'
         . "\n";
}

// This function displays the album bluk edit window
function displayBulkAlbum()
{
    global $directory_level, $web_root, $root_dir, $media_dir, $song_cellpadding, $ext_graphic;

    // Let's display the top of our page

    displayPageTop();

    echo '<form action="mp3info.php" method="POST" name="mp3infoform" enctype="multipart/form-data">'
         . "\n"
         . '<table width="100%" cellpadding="'
         . $song_cellpadding
         . '" cellspacing="0" class="jz_track_table">'
         . "\n"
         . '<tr class="jz_row1">'
         . "\n"
         . '<td width="30%" class="jz_track_table_songs_td" valign="top">Item:</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . '<input class="jz_input" type="hidden" name="origalbumName" size="30" value="'
         . $_GET['info']
         . '">';

    switch ($directory_level) {
        case '3':
            echo $_GET['info'];
            break;
        case '2':
            echo mb_substr($_GET['info'], 2, mb_strlen($_GET['info']));
            break;
        case '1':
            echo mb_substr($_GET['info'], 3, mb_strlen($_GET['info']));
            break;
    }

    echo '</td>'
         . "\n"
         . '</tr><tr class="jz_row2">'
         . "\n"
         . '<td class="jz_track_table_songs_td">String Replace:</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . 'Search:<br>'
         . '<input class="jz_input" type="text" name="search" size="30" value="'
         . $artistName
         . '"><br>'
         . 'Replace:<br>'
         . '<input class="jz_input" type="text" name="replace" size="30" value="'
         . $artistName
         . '"><br>'
         . '<br><input type=submit class="jz_submit" name="replacealbumdata" value="Replace"> '
         . '<input type=submit class="jz_submit" name="replacealbumdataclose" value="Replace & Close"> '
         . '</td>'
         . "\n"
         . '</tr>'
         . "\n"
         .

         '<tr class="jz_row1">'
         . "\n"
         . '<td class="jz_track_table_songs_td">Fix Case:</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . '<input type=submit class="jz_submit" name="fixalbumcase" value="Fix Filename Case"> '
         . '</td>'
         . "\n"
         . '</tr>'
         . "\n"
         .

         '<tr class="jz_row2">'
         . "\n"
         . '<td class="jz_track_table_songs_td">Auto Rename from Allmusic:</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . 'URL:<br><input class="jz_input" type="text" name="renameurl" size="30"> '
         . '<br><input type=submit class="jz_submit" name="renamefromurl" value="Rename"> '
         . '</td>'
         . "\n"
         . '</tr>'
         . "\n"
         .

         '<tr class="jz_row1">'
         . "\n"
         . '<td class="jz_track_table_songs_td">Grab info from Allmusic:</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . 'URL:<br><input class="jz_input" type="text" name="infourl" size="30"> '
         . '<br><input type=submit class="jz_submit" name="infofromurl" value="Grab"> '
         . '</td>'
         . "\n"
         . '</tr>'
         . "\n"
         .

         '<tr class="jz_row2">'
         . "\n"
         . '<td class="jz_track_table_songs_td">Sample Track:</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td">';

    $retArray = readDirInfo($web_root . $root_dir . $media_dir . '/' . urldecode($_GET['info']), 'file');

    echo $retArray[1];

    flushDisplay();

    echo '</td>'
         . "\n"
         . '</tr>'
         . "\n"
         . '<tr class="jz_row1">'
         . "\n"
         . '<td class="jz_track_table_songs_td">Clips:</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . '<input type=submit class="jz_submit" name="createclips" value="Create Clips"> <input type=submit class="jz_submit" name="deleteclips" value="Delete Clips">'
         . '</td>'
         . "\n"
         . '</tr>'
         . "\n"
         . '</table>'
         . "\n"
         . '</form></body>'
         . "\n";
}

// This function let's the user view/edit a single album
function displayAlbumInfo()
{
    global $directory_level, $web_root, $root_dir, $media_dir, $song_cellpadding, $ext_graphic, $word_album, $word_artist, $word_genre, $word_album_description, $word_new_image, $word_album_year, $word_update_close, $word_delete_album, $word_global_exclude, $word_update_description, $word_close, $word_album_image;

    // Let's display the top of our page

    displayPageTop();

    // Let's parse out some of the data we'll need

    $infoArray = explode('/', urldecode($_GET['info']));

    // Now let's see what dir mode we are in

    switch ($directory_level) {
        case '3': # Ok, 3 dir mode
            $albumName = $infoArray[count($infoArray) - 1];
            $artistName = $infoArray[count($infoArray) - 2];
            $genreName = $infoArray[count($infoArray) - 3];
            break;
        case '2': # Ok, 2 dir mode
            $albumName = $infoArray[count($infoArray) - 1];
            $artistName = $infoArray[count($infoArray) - 2];
            $genreName = '';
            break;
        case '1': # Ok, 1 dir mode
            $albumName = $infoArray[count($infoArray) - 1];
            $artistName = '';
            $genreName = '';
            break;
    }

    $filename = $web_root . $root_dir . $media_dir . '/' . urldecode($_GET['info']) . '/album-desc.txt';

    if (is_file($filename)) {
        $handle = fopen($filename, 'rb');

        $contents = fread($handle, filesize($filename));

        fclose($handle);
    } else {
        $contents = '';
    }

    echo '<form action="mp3info.php" method="POST" name="mp3infoform" enctype="multipart/form-data">'
         . "\n"
         . '<input type="hidden" name="desc_filename" value="'
         . $filename
         . '">'
         . '<table width="100%" cellpadding="'
         . $song_cellpadding
         . '" cellspacing="0" class="jz_track_table">'
         . "\n"
         . '<tr class="jz_row1">'
         . "\n"
         . '<td width="30%" class="jz_track_table_songs_td">'
         . $word_album
         . ':</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . '<input class="jz_input" type="hidden" name="origalbumName" size="30" value="'
         . $albumName
         . '">'
         . '<input class="jz_input" type="text" name="albumName" size="30" maxlength="100" value="'
         . $albumName
         . '"></td>'
         . "\n"
         . '</tr><tr class="jz_row2">'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . $word_artist
         . ':</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . '<input class="jz_input" type="hidden" name="origartistName" size="30" value="'
         . $artistName
         . '">'
         . $artistName
         . '</td>'
         . "\n";

    // Ok if in 3 dir mode

    if (3 == $directory_level) {
        echo '<tr class="jz_row1">' . "\n" . '<td width="30%" class="jz_track_table_songs_td">' . $word_genre . ':</td>' . "\n" . '<td class="jz_track_table_songs_td">' . // Ok, let's build our select list of Genres
             '<input class="jz_input" type="hidden" name="origgenreName" value="' . $genreName . '">' . $genreName . '</td></tr>' . "\n";
    }

    echo '</tr><tr class="jz_row2">' . "\n" . '<td class="jz_track_table_songs_td">' . $word_album_description . '</td>' . "\n" . '<td class="jz_track_table_songs_td">' . '<textarea class="jz_input" name="desc_contents" rows="8" cols="25">' . $contents . '</textarea>' . '</td>' . "\n";

    echo '</tr><tr class="jz_row1">' . "\n" . '<td class="jz_track_table_songs_td">' . $word_album_image . '</td>' . "\n" . '<td class="jz_track_table_songs_td">';

    // Ok, let's get the current image

    $artArray = readDirInfo($web_root . $root_dir . $media_dir . '/' . urldecode($_GET['info']), 'file');

    for ($i = 0, $iMax = count($artArray); $i < $iMax; $i++) {
        if (preg_match("/\.($ext_graphic)$/i", $artArray[$i])) {
            $albumArt = $root_dir . $media_dir . '/' . $_GET['info'] . '/' . rawurlencode($artArray[$i]);
        }
    }

    if ('' != $albumArt) {
        echo '<img src="' . $albumArt . '" border="0"><br><br>';
    }

    echo $word_new_image . '<br><input type="file" name="album_img" class="jz_input">' . '<input type="hidden" name="img_path" value="' . $web_root . $root_dir . $media_dir . '/' . urldecode($_GET['info']) . '">' . '</td>' . "\n";

    echo '</tr><tr class="jz_row2">' . "\n" . '<td class="jz_track_table_songs_td">' . $word_album_year . '</td>' . "\n" . '<td class="jz_track_table_songs_td">' . '<input type="input" name="album_year" class="jz_input" size="5">' . '</td>' . "\n";

    echo '<tr class="jz_row1">' . "\n" . '<td width="100%" colspan="2" class="jz_track_table_songs_td" align="center" valign="center">';

    if ('admin' == $_SESSION['jz_access_level']) {
        echo '<br><input type=submit class="jz_submit" name="closeupdatealbumdata" value="'
             . $word_update_close
             . '"> '
             . '<input type=submit class="jz_submit" name="deletealbum" value="'
             . $word_delete_album
             . '">'
             . '<br><br><input type=submit class="jz_submit" name="excludealbum" value="'
             . $word_global_exclude
             . '"> ';

        // Now let's see if they are already featured and if so let them unfeature

        $xmlFile = $web_root . $root_dir . '/data/featured/albums/' . $genreName . '---' . $artistName . '---' . $albumName . '.xml';

        if (is_file($xmlFile)) {
            echo '<input type=submit class="jz_submit" name="removefeaturedalbum" value="' . word_remove_from_featured . '"> ';
        } else {
            echo '<input type=submit class="jz_submit" name="addfeaturedalbum" value="' . word_add_to_featured . '"> ';
        }

        echo '<input type="hidden" name="featuredXML" value="' . $xmlFile . '">';
    }

    echo '<input type=submit class="jz_submit" name="closealbum" value="' . $word_close . '"><br><br>' . '</td>' . "\n" .

         '</tr>' . "\n" . '</table>' . "\n" . '</form></body>' . "\n";
}

function displayArtistInfo()
{
    global $directory_level, $web_root, $root_dir, $media_dir, $song_cellpadding, $ext_graphic, $word_artist, $word_genre, $word_short_description, $long_short_description, $word_update_close, $word_artist_image, $word_new_image, $word_close, $word_update_description, $word_delete_artist, $word_exclude_artist;

    // Let's display the top of our page

    displayPageTop();

    // Let's parse out some of the data we'll need

    $infoArray = explode('/', urldecode($_GET['info']));

    // Now let's see what dir mode we are in

    switch ($directory_level) {
        case '3': # Ok, 3 dir mode
            $artistName = $infoArray[count($infoArray) - 1];
            $genreName = $infoArray[count($infoArray) - 2];
            $desc1 = 'Genre';
            $desc2 = 'Aritst';
            $desc3 = 'Album';
            break;
        case '2': # Ok, 2 dir mode
            $artistName = $infoArray[count($infoArray) - 1];
            $genreName = '';
            $desc1 = 'Aritst';
            $desc2 = 'Album';
            $desc3 = '';
            break;
        case '1': # Ok, 1 dir mode
            $albumName = '';
            $artistName = '';
            $genreName = '';
            $desc1 = 'Album';
            $desc2 = '';
            $desc3 = '';
            break;
    }

    // Now let's see if there is a description file here

    $filename = $web_root . $root_dir . $media_dir . '/' . urldecode($_GET['info']) . '.txt';

    if (is_file($filename) and 0 != filesize($filename)) {
        $handle = fopen($filename, 'rb');

        $contents = fread($handle, filesize($filename));

        fclose($handle);
    } else {
        $contents = '';
    }

    $dataArray = explode('/', urldecode($_GET['info']));

    $long_file_name = $web_root . $root_dir . $media_dir . '/' . urldecode($_GET['info']) . '/' . $dataArray[count($dataArray) - 1] . '.txt';

    if (is_file($long_file_name)) {
        $handle = fopen($long_file_name, 'rb');

        $long_desc = fread($handle, filesize($long_file_name));

        fclose($handle);
    } else {
        $long_desc = '';
    }

    echo '<form action="mp3info.php" method="POST" name="mp3infoform" enctype="multipart/form-data">'
         . "\n"
         . '<input type="hidden" name="filename" value="'
         . $filename
         . '">'
         . '<input type="hidden" name="long_file_name" value="'
         . $long_file_name
         . '">'
         . '<table width="100%" cellpadding="'
         . $song_cellpadding
         . '" cellspacing="0" class="jz_track_table">'
         . "\n"
         . '</tr><tr class="jz_row2">'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . $word_artist
         . ':</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . '<input class="jz_input" type="hidden" name="origartistName" size="30" value="'
         . $artistName
         . '">'
         . $artistName
         . '<tr class="jz_row1">'
         . "\n"
         . '<td width="30%" class="jz_track_table_songs_td">'
         . $word_genre
         . ':</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . // Ok, let's build our select list of Genres
         '<input class="jz_input" type="hidden" name="origgenreName" value="'
         . $genreName
         . '">'
         . '<select class="jz_select" name="genreName">';

    // let's get all the different genre's they already have

    $genreDir = $web_root . $root_dir . $media_dir;

    $d = dir($genreDir);

    $i = 0;

    while ($entry = $d->read()) {
        /* Let's make sure this isn't the local directory we're looking at */

        if ('.' == $entry || '..' == $entry) {
            continue;
        }

        if (is_dir($genreDir . '/' . $entry)) {
            $genreArray[$i] = $entry;

            $i++;
        }
    }

    // Now let's sort that array

    sort($genreArray);

    // Now let's create our select box

    for ($i = 0, $iMax = count($genreArray); $i < $iMax; $i++) {
        // Let's see if we find a match

        if ($genreName == $genreArray[$i]) {
            echo '<option selected value="' . $genreArray[$i] . '">' . $genreArray[$i] . '</option>';
        } else {
            echo '<option value="' . $genreArray[$i] . '">' . $genreArray[$i] . '</option>';
        }
    }

    echo '</select>'
         . '</td>'
         . "\n"
         . '</tr><tr class="jz_row2">'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . $word_short_description
         . '</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . '<textarea class="jz_input" name="desc_contents" rows="10" cols="25">'
         . $contents
         . '</textarea>'
         . '</tr><tr class="jz_row1">'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . $long_short_description
         . '</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . '<textarea class="jz_input" name="long_desc" rows="10" cols="25">'
         . $long_desc
         . '</textarea>'
         . '</tr><tr class="jz_row2">'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . $word_artist_image
         . '</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td">';

    // Ok, let's get the current image

    $albumArt = '';

    $artArray = readDirInfo($web_root . $root_dir . $media_dir . '/' . urldecode($_GET['info']), 'file');

    for ($i = 0, $iMax = count($artArray); $i < $iMax; $i++) {
        if (preg_match("/\.($ext_graphic)$/i", $artArray[$i])) {
            $albumArt = $root_dir . $media_dir . '/' . $_GET['info'] . '/' . rawurlencode($artArray[$i]);
        }
    }

    if ('' != $albumArt) {
        echo '<img src="' . $albumArt . '" border="0"><br><br>';
    }

    echo $word_new_image
         . '<br><input type="file" name="artist_img" class="jz_input">'
         . '<input type="hidden" name="img_path" value="'
         . $web_root
         . $root_dir
         . $media_dir
         . '/'
         . urldecode($_GET['info'])
         . '">'
         . '</tr><tr class="jz_row1">'
         . "\n"
         . '<td width="100%" colspan="2" class="jz_track_table_songs_td" align="center" valign="center">';

    if ('admin' == $_SESSION['jz_access_level']) {
        echo '<br><input type=submit class="jz_submit" name="closeupdateartistdata" value="' . $word_update_close . '"> ';
    }

    echo '<input type=submit class="jz_submit" name="closealbum" value="' . $word_close . '">';

    if ('admin' == $_SESSION['jz_access_level']) {
        echo '<br><br><input type=submit class="jz_submit" name="deleteartist" value="' . $word_delete_artist . '">' . ' <input type=submit class="jz_submit" name="excludeartist" value="' . $word_exclude_artist . '"> ';

        // Now let's add the featured buttons

        $xmlFile = $web_root . $root_dir . '/data/featured/artists/' . $genreName . '---' . $artistName . '.xml';

        if (is_file($xmlFile)) {
            echo '<br><br><input type=submit class="jz_submit" name="removefeaturedartist" value="' . word_remove_from_featured . '"> ';
        } else {
            echo '<br><br><input type=submit class="jz_submit" name="addfeaturedartist" value="' . word_add_to_featured . '"> ';
        }

        echo '<input type="hidden" name="featuredXML" value="' . $xmlFile . '">';
    }

    echo '<br><br><br>' . '</td>' . "\n" .

         '</tr>' . "\n" . '</table>' . "\n" . '</form></body>' . "\n";
}

// This function displays the rating page
function displayRatingPopup()
{
    global $directory_level, $web_root, $root_dir, $media_dir, $song_cellpadding;

    // Let's display the top of our page

    displayPageTop();

    //Now let's figure out the track name

    $trackArray = explode('/', urldecode($_GET['info']));

    $trackName = $trackArray[count($trackArray) - 1];

    echo '<form action="mp3info.php" method="POST" name="mp3infoform">'
         . "\n"
         . '<table width="100%" cellpadding="'
         . $song_cellpadding
         . '" cellspacing="0" class="jz_track_table">'
         . "\n"
         . '</tr><tr class="jz_row1">'
         . "\n"
         . '<td class="jz_track_table_songs_td">Item:</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . $trackName
         . '</tr><tr class="jz_row2">'
         . "\n"
         . '<td class="jz_track_table_songs_td">Rating:</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . '<select name="rating" class="jz_select">'
         . '<option value="5">5 Stars</option>'
         . '<option value="4.5">4.5 Stars</option>'
         . '<option value="4">4 Stars</option>'
         . '<option value="3.5">3.5 Stars</option>'
         . '<option value="3">3 Stars</option>'
         . '<option value="2.5">2.5 Stars</option>'
         . '<option value="2">2 Stars</option>'
         . '<option value="1.5">1.5 Stars</option>'
         . '<option value="1">1 Stars</option>'
         . '<option value=".5">.5 Stars</option>'
         . '<option value="0">0 Stars</option>'
         . '</select>'
         . '<input type="hidden" name="filename" value="'
         . urldecode($_GET['info'])
         . '">'
         . '</tr><tr class="jz_row1">'
         . "\n"
         . '<td width="100%" colspan="2" class="jz_track_table_songs_td" align="center" valign="center">'
         . '<br><input type=submit class="jz_submit" name="ratetrack" value="Rate & Close"><br>'
         . '<br><br><br><br>'
         . '</td>'
         . "\n"
         . '</tr>'
         . "\n"
         . '</table>'
         . "\n"
         . '</form></body>'
         . "\n";
}

// This function displays the rating page
function displayDiscuss()
{
    global $directory_level, $web_root, $root_dir, $media_dir, $song_cellpadding, $word_editcomment;

    // Let's display the top of our page

    displayPageTop();

    //Now let's figure out the track name

    $trackArray = explode('/', urldecode($_GET['info']));

    $trackName = $trackArray[count($trackArray) - 1];

    // Now let's read all the previous comments

    $contents = returnComments($web_root . $root_dir . '/data/discussions/' . returnFormatedFilename(jzstripslashes(urldecode($_GET['info']))) . '.disc');

    echo '<form action="mp3info.php" method="POST" name="mp3infoform">'
         . "\n"
         . '<table width="100%" cellpadding="'
         . $song_cellpadding
         . '" cellspacing="0" class="jz_track_table">'
         . "\n"
         . '</tr><tr class="jz_row1">'
         . "\n"
         . '<td class="jz_track_table_songs_td">Track:</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . $trackName
         . '</tr><tr class="jz_row2">'
         . "\n"
         . '<td class="jz_track_table_songs_td">Comment:</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td">';

    // Now let's see if they wanted to edit this comment or not

    $oldComments = '';

    $insertType = 'new';

    if (isset($_GET['edit'])) {
        // Now we need to get the comment from this user

        if ('' != $contents) {
            $commentArray = explode('|END', $contents);

            for ($ctr = 0, $ctrMax = count($commentArray); $ctr < $ctrMax; $ctr++) {
                // Now let's break out all the data

                $valArray = explode('|', $commentArray[$ctr]);

                if (isset($_COOKIE['jz_user_name'])) {
                    if ($_COOKIE['jz_user_name'] == $valArray[2]) {
                        $oldComments = stripslashes($valArray[3]);

                        $insertType = 'edit';
                    }
                }
            }
        }
    }

    echo '<textarea class="jz_input" rows="10" cols="60" name="new_comments">'
         . $oldComments
         . '</textarea>'
         . '<input type="hidden" name="insert_type" value="'
         . $insertType
         . '">'
         . '<input type="hidden" name="filename" value="'
         . urldecode($_GET['info'])
         . '">'
         . '</tr><tr class="jz_row1">'
         . "\n"
         . '<td class="jz_track_table_songs_td" colspan="2" align="center">'
         . "\n"
         . '<br><input type=submit class="jz_submit" name="discusstrack" value="Comment & Close"><br><br>'
         . '</tr><tr class="jz_row2">'
         . "\n"
         . '<td class="jz_track_table_songs_td" colspan="2">';

    if ('' != $contents) {
        // Now let's setup our table

        echo '<table width="100%" cellpadding="' . $song_cellpadding . '" cellspacing="0" class="jz_track_table">' . "\n";

        // Now let's break the comments into an array for display

        $commentArray = explode('|END', $contents);

        // Now let's sort that array

        if (0 != count($commentArray)) {
            usort($commentArray, 'cmp');
        }

        for ($ctr = 0, $ctrMax = count($commentArray); $ctr < $ctrMax; $ctr++) {
            // Now let's make sure that wasn't blank

            if ('' != $commentArray[$ctr]) {
                // Now let's break out all the data

                $valArray = explode('|', $commentArray[$ctr]);

                // Now let's display this stuff...

                echo '<tr class="jz_row1"><td width="50%" style="border-top: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black;">' . $valArray[2];

                // Now let's see if this is this users comments, and if so give them the edit

                if (isset($_COOKIE['jz_user_name'])) {
                    if ($_COOKIE['jz_user_name'] == $valArray[2]) {
                        echo ' - <a href="mp3info.php?type=discuss&edit=true&info=' . $_GET['info'] . '">' . $word_editcomment . '</a>';
                    }
                }

                echo '</td><td width="50%" align="right" style="border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">'
                     . date('n/j/y g:i:s', $valArray[0])
                     . '</td></tr>'
                     . '<tr class="jz_row2"><td width="100%" colspan="2" style="border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black;">'
                     . stripslashes(nl2br($valArray[3]))
                     . '<br><br></td></tr>';
            }
        }

        echo '</table><br><br><br><br><br><br><br>';
    }

    echo '</tr>' . "\n" . '</table>' . "\n" . '</form></body>' . "\n";
}

// This function helps us sort an array
function cmp($a, $b)
{
    $cmp = strcmp($a[0], $b[0]);

    return $cmp ?: -1;
}

function displayGenreInfo()
{
    global $directory_level, $web_root, $root_dir, $media_dir, $song_cellpadding, $word_genre, $word_description, $word_delete_genre, $word_exclude_genre, $word_update_description, $word_close;

    // Let's display the top of our page

    displayPageTop();

    // Let's parse out some of the data we'll need

    $infoArray = explode('/', urldecode($_GET['info']));

    // Now let's see what dir mode we are in

    switch ($directory_level) {
        case '3': # Ok, 3 dir mode
            $genreName = $infoArray[count($infoArray) - 1];
            $desc1 = 'Genre';
            $desc2 = 'Aritst';
            $desc3 = 'Album';
            break;
        case '2': # Ok, 2 dir mode
            $artistName = '';
            $genreName = '';
            $desc1 = 'Album';
            $desc2 = '';
            $desc3 = '';
            break;
        case '1': # Ok, 1 dir mode
            $albumName = '';
            $artistName = '';
            $genreName = '';
            $desc1 = '';
            $desc2 = '';
            $desc3 = '';
            break;
    }

    // Now let's see if there is a description file here

    $filename = $web_root . $root_dir . $media_dir . urldecode($_GET['info']) . '.txt';

    if (is_file($filename)) {
        $handle = fopen($filename, 'rb');

        $contents = fread($handle, filesize($filename));

        fclose($handle);
    } else {
        $contents = '';
    }

    echo '<form action="mp3info.php" method="POST" name="mp3infoform">'
         . "\n"
         . '<table width="100%" cellpadding="'
         . $song_cellpadding
         . '" cellspacing="0" class="jz_track_table">'
         . "\n"
         . '</tr><tr class="jz_row1">'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . $word_genre
         . ':</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . '<input class="jz_input" type="hidden" name="origgenreName" size="30" value="'
         . $genreName
         . '">'
         . $genreName
         . '</tr><tr class="jz_row2">'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . $word_description
         . '</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . '<textarea class="jz_input" name="desc_contents" rows="10">'
         . $contents
         . '</textarea>'
         . '<input type="hidden" name="filename" value="'
         . $filename
         . '">'
         . '</tr><tr class="jz_row1">'
         . "\n"
         . '<td width="100%" colspan="2" class="jz_track_table_songs_td" align="center" valign="center">';

    if ('admin' == $_SESSION['jz_access_level']) {
        echo '<br><input type=submit class="jz_submit" name="deletegenre" value="'
             . $word_delete_genre
             . '" onClick="return AreYouSure();">'
             . ' <input type=submit class="jz_submit" name="excludegenre" value="'
             . $word_exclude_genre
             . '">'
             . '<br><br><input type=submit class="jz_submit" name="updatedesc" value="'
             . $word_update_description
             . '"> ';
    }

    echo '<input type=submit class="jz_submit" name="closealbum" value="' . $word_close . '"><br>' . '<br><br><br><br><br><br><br><br><br><br>' . '</td>' . "\n" . '</tr>' . "\n" . '</table>' . "\n" . '</form></body>' . "\n";
}

// This function let's the user view/edit a single track
function displayTrackInfo()
{
    global $root_dir, $song_cellpadding, $jinzora_skin, $auto_search_lyrics, $date_format, $word_track_number, $word_track_name, $word_file_name, $word_not_writable, $word_artist, $word_album, $word_genre, $word_album_year, $word_track_time, $word_bit_rate, $word_sample_rate, $word_file_size, $word_file_date, $word_id3_description, $long_short_description, $word_thumbnail, $word_delete, $word_search_lyrics, $word_update_close, $word_update, $word_update_description, $word_close, $word_start, $word_stop, $web_root, $root_dir, $media_dir, $word_create_low_fi, $lame_opts, $word_delete_low_fi, $word_plays;

    $file = jzstripslashes($_GET['file']);

    // Let's display the top of our page

    displayPageTop();

    // Let's set some defaults

    $bitrate = '';

    $length = '';

    $filesize = '';

    $name = '';

    $artists = '';

    $album = '';

    $year = '';

    $track = '';

    $genre = '';

    $frequency = '';

    $description = '';

    // Let's read all the info

    //$fileInfo = GetAllFileInfo($file);

    $getID3 = new getID3();

    $fileInfo = $getID3->analyze($file);

    getid3_lib::CopyTagsToComments($fileInfo);

    if (!empty($fileInfo['audio']['bitrate'])) {
        $bitrate = (round($fileInfo['audio']['bitrate'] / 1000));
    }

    if (!empty($fileInfo['playtime_string'])) {
        $length = $fileInfo['playtime_string'];
    }

    if (!empty($fileInfo['filesize'])) {
        $filesize = round($fileInfo['filesize'] / 1000000, 2);
    }

    if (!empty($fileInfo['comments']['title'][0])) {
        $name = $fileInfo['comments']['title'][0];
    }

    if (!empty($fileInfo['comments']['artist'][0])) {
        $artists = $fileInfo['comments']['artist'][0];
    }

    if (!empty($fileInfo['comments']['album'][0])) {
        $album = $fileInfo['comments']['album'][0];
    }

    if (!empty($fileInfo['comments']['year'][0])) {
        $year = $fileInfo['comments']['year'][0];
    }

    if (!empty($fileInfo['comments']['track'][0])) {
        $track = $fileInfo['comments']['track'][0];
    }

    if (!empty($fileInfo['comments']['genre'][0])) {
        $genre = $fileInfo['comments']['genre'][0];
    }

    if (!empty($fileInfo['audio']['sample_rate'])) {
        $frequency = round($fileInfo['audio']['sample_rate'] / 1000, 1);
    }

    if (!empty($fileInfo['comments']['comment'][0])) {
        $description = $fileInfo['comments']['comment'][0];
    }

    if (!empty($fileInfo['tags']['id3v2']['unsynchronised lyric'][0])) {
        $lyrics = $fileInfo['tags']['id3v2']['unsynchronised lyric'][0];
    } else {
        $lyrics = '';
    }

    $filename = $_GET['file'];

    $filedate = date($date_format, filemtime($file));

    // Now let's clean up the file name

    $fileNameArray = explode('/', $filename);

    $filename = $fileNameArray[count($fileNameArray) - 1];

    // Now let's see if the file is writeable so we'll know if we can change it

    $fileWritable = 'no';

    if (is_writable($_GET['file'])) {
        $fileWritable = 'yes';
    }

    $fileInfo = pathinfo(urldecode($_GET['file']));

    $fileExt = $fileInfo['extension'];

    $desc_file_name = str_replace($fileExt, '', urldecode($_GET['file'])) . 'txt';

    if (is_file($desc_file_name) and 0 != filesize($desc_file_name)) {
        $handle = fopen($desc_file_name, 'rb');

        $desc_contents = fread($handle, filesize($desc_file_name));

        fclose($handle);
    } else {
        $desc_contents = '';
    }

    echo '<form action="mp3info.php?file='
         . $_GET['file']
         . '" method="POST" name="mp3infoform" enctype="multipart/form-data">'
         . "\n"
         . '<input type="hidden" name="desc_filename" value="'
         . $desc_file_name
         . '">'
         . '<table width="100%" cellpadding="'
         . $song_cellpadding
         . '" cellspacing="0" class="jz_track_table">'
         . "\n"
         . '<tr class="jz_row1">'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . $word_track_number
         . '</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td"><input class="jz_input" type="text" name="tracknumber" size="3" maxlength="3" value="'
         . $track
         . '"></td>'
         . "\n"
         . '</tr><tr class="jz_row2">'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . $word_track_name
         . '</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td"><input class="jz_input" type="text" name="trackname" size="30" maxlength="100" value="'
         . $name
         . '"></td>'
         . "\n"
         . '</tr><tr class="jz_row1">'
         . "\n"
         . '<td class="jz_track_table_songs_td" valign="top">'
         . $word_file_name
         . '</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td"><input type="hidden" name="filename" value="'
         . $_GET['file']
         . '"><input class="jz_input" type="text" name="newfilename" size="30" value="'
         . $filename
         . '">'
         . "\n";

    // Let's see if the file WASN't writable

    if ('no' == $fileWritable) {
        echo '<br><font color=red>' . $word_not_writable . '</font>';
    }

    echo '</td>' . "\n";

    echo '</tr><tr class="jz_row2">'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . $word_artist
         . ':</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td"><input class="jz_input" type="text" name="artistname" size="30" maxlength="100" value="'
         . $artists
         . '"></td>'
         . "\n"
         . '</tr><tr class="jz_row1">'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . $word_album
         . ':</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td"><input class="jz_input" type="text" name="albumname" size="30" maxlength="100" value="'
         . $album
         . '"></td>'
         . "\n"
         . '</tr><tr class="jz_row2">'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . $word_genre
         . ':</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td"><input class="jz_input" type="text" name="genre" size="30" maxlength="100" value="'
         . $genre
         . '"></td>'
         . "\n"
         . '</tr><tr class="jz_row1">'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . $word_album_year
         . '</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td"><input class="jz_input" type="text" name="year" size="30" maxlength="100" value="'
         . $year
         . '"></td>'
         . "\n";

    // Now if this is a .RM file let's show the start stop options

    if ('rm' == $fileExt) {
        // Now let's read the file to get the values from it

        $rmtimeArray = returnRMStartStop($web_root . $root_dir . '/data/tracks/' . returnFormatedFilename(str_replace($web_root . $root_dir . $media_dir . '/', '', $file)) . '.rmdata');

        echo '</tr><tr class="jz_row2">'
             . "\n"
             . '<td class="jz_track_table_songs_td">'
             . $word_start
             . ':</td>'
             . "\n"
             . '<td class="jz_track_table_songs_td"><input class="jz_input" type="text" name="start_time" size="10" maxlength="100" value="'
             . $rmtimeArray[0]
             . '"></td>'
             . "\n"
             . '</tr><tr class="jz_row1">'
             . "\n"
             . '<td class="jz_track_table_songs_td">'
             . $word_stop
             . ':</td>'
             . "\n"
             . '<td class="jz_track_table_songs_td"><input class="jz_input" type="text" name="stop_time" size="10" maxlength="100" value="'
             . $rmtimeArray[1]
             . '"></td>'
             . "\n";
    }

    echo '</tr><tr class="jz_row2">'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . $word_track_time
         . '</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . $length
         . '</td>'
         . "\n"
         . '</tr><tr class="jz_row1">'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . $word_bit_rate
         . '</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . $bitrate
         . ' kbps</td>'
         . "\n"
         . '</tr><tr class="jz_row2">'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . $word_sample_rate
         . '</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . $frequency
         . ' Hz</td>'
         . "\n"
         . '</tr><tr class="jz_row1">'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . $word_file_size
         . '</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . $filesize
         . ' Mb </td>'
         . "\n"
         . '</tr><tr class="jz_row2">'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . $word_file_date
         . '</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . $filedate
         . '</td>'
         . "\n"
         . '</tr><tr class="jz_row1">'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . $word_id3_description
         . '</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td"><input class="jz_input" type="text" name="description" size="30" maxlength="100" value="'
         . $description
         . '"></td>'
         . "\n"
         . '</tr><tr class="jz_row2">'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . $long_short_description
         . '</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td"><textarea class="jz_input" name="long_desc" style="width: 195px" rows="5">'
         . stripslashes($desc_contents)
         . '</textarea></td>'
         . "\n"
         . '</tr><tr class="jz_row1">'
         . "\n"
         . '<td class="jz_track_table_songs_td" valign="bottom">'
         . $word_thumbnail
         . '</td><td class="jz_track_table_songs_td">'
         . "\n";

    // Now let's see if there is a thumbnail

    $thumbNail = searchThumbnail($file);

    if (false != $thumbNail) {
        echo '<br><img src="' . $thumbNail . '" border="0" width="75"> &nbsp; <input class="jz_submit" type="submit" name="deletethumb" value="' . $word_delete . '"><br><br>';

        echo '<input type="hidden" name="thumb_image" value="' . $thumbNail . '">';
    }

    echo '<input type="file" class="jz_input" name="thumbnail">';

    echo '</td>' . "\n";

    // Now let's figure out how many times this has been played

    $track_plays = returnCounter(str_replace($web_root . $root_dir . $media_dir . '/', '', $_GET['file']));

    echo '</tr><tr class="jz_row2">'
         . "\n"
         . '<td class="jz_track_table_songs_td">'
         . ucwords($word_plays)
         . ':</td>'
         . "\n"
         . '<td class="jz_track_table_songs_td"><input class="jz_input" type="text" name="trackplays" size="5" maxlength="100" value="'
         . $track_plays
         . '"></td>'
         . "\n"
         . '</tr><tr class="jz_row1">'
         . "\n"
         . '<td width="100%" colspan="2" class="jz_track_table_songs_td" align="center" valign="center">';

    // First let's look and see if the lyrics are in the ID3 tag or not

    if ('' == $lyrics and ('true' == $auto_search_lyrics or isset($_GET['autosearch']))) {
        // Now let's see if we get back the lyrics from leo's lyrics...

        flushDisplay();

        flushDisplay();

        $contents = '';

        $fp = fsockopen('api.leoslyrics.com', 80, $errno, $errstr, 5);

        $path = '/api_search.php?auth=Jinzora&artist=' . urlencode($artists) . '&songtitle=' . urlencode($name) . '&search= true';

        fwrite($fp, "GET $path HTTP/1.1\n");

        fwrite($fp, "Content-type: application/x-www-form-urlencoded\n");

        fwrite($fp, "Connection: close\n\n");

        // Now let's read all the data

        $blnHeader = true;

        while (!feof($fp)) {
            if ($blnHeader) {
                if ("\r\n" == fgets($fp, 1024)) {
                    $blnHeader = false;
                }

                //echo fgets($fp,1024). "<br>";
            } else {
                $contents .= fread($fp, 1024);
            }
        }

        fclose($fp);

        // Now let's see if we got an exact match

        if (mb_stristr($contents, 'exactMatch="true"')) {
            $lyrics = '';

            // Ok, now let's get the ID number

            $song_hid = mb_substr($contents, mb_strpos($contents, 'hid=') + 5, 50);

            $song_hid = mb_substr($song_hid, 0, mb_strpos($song_hid, '"'));

            // Now that we've got the HID let's get the lyrics

            // Now let's see if we get back the lyrics from leo's lyrics...

            $fp = fsockopen('api.leoslyrics.com', 80, $errno, $errstr, 5);

            $path = '/api_lyrics.php?auth=Jinzora&hid=' . urlencode($song_hid) . '&file= NULL';

            fwrite($fp, "GET $path HTTP/1.1\n");

            fwrite($fp, "Content-type: application/x-www-form-urlencoded\n");

            fwrite($fp, "Connection: close\n\n");

            // Now let's read all the data

            $blnHeader = true;

            while (!feof($fp)) {
                if ($blnHeader) {
                    if ("\r\n" == fgets($fp, 1024)) {
                        $blnHeader = false;
                    }

                    //echo fgets($fp,1024). "<br>";
                } else {
                    $lyrics .= fread($fp, 1024);
                }
            }

            fclose($fp);

            // Now let's make sure that was successful

            if (mb_stristr($lyrics, 'SUCCESS')) {
                // Now let's clean them up

                $lyrics = mb_substr($lyrics, mb_strpos($lyrics, '<text>') + 6, 999999);

                $lyrics = stripslashes(mb_substr($lyrics, 0, mb_strpos($lyrics, '</text>')));
            }
        }
    }

    if ('' != $lyrics) {
        // Now let's display them...

        echo '<br>Lyrics Provided by <a href="http://www.leoslyrics.com" target="_blank">Leo' . "'s Lyrics</a><br>";

        echo '<textarea name="lyrics" class="jz_input" rows="20" cols="45" class="jz_input">' . $lyrics . '</textarea><br>';
    } else {
        if ('false' == $auto_search_lyrics) {
            echo '<br><a href="' . $_SERVER['REQUEST_URI'] . '&autosearch=true">' . $word_search_lyrics . '</a><br>';
        } else {
            echo '<br><a target="_blank" href="http://www.leoslyrics.com/search.php?search=%22' . urlencode($artists) . '%22+%22' . urlencode($name) . '%22&sartist=1&ssongtitle=1">Search for Lyrics</a><br>';
        }
    }

    // Now let's make sure they are an admin and therefore can edit

    if ('admin' == $_SESSION['jz_access_level']) {
        echo '<br><input type=submit class="jz_submit" name="closeupdate" value="' . $word_update_close . '"><input type="hidden" name="filename" value="' . $file . '"> ' . '<input type=submit class="jz_submit" name="updatedata" value="' . $word_update . '">';

        // Now let's see if a lofi file exists

        $lofiFilename = str_replace('.' . $fileExt, '.lofi.', $_GET['file']) . 'mp3';

        if (is_file($lofiFilename)) {
            echo '<br><br><input type=submit class="jz_submit" name="deletelowfi" value="' . $word_delete_low_fi . '">';
        } else {
            // Now let's see if this is an MP3 that can be downsampled

            if ('mp3' == $fileExt and isset($lame_opts)) {
                echo '<br><br><input type=submit class="jz_submit" name="createlowfi" value="' . $word_create_low_fi . '"> ';
            }
        }

        // Now let's see if a .clip exists

        $clipFilename = str_replace('.' . $fileExt, '.clip.', $_GET['file']) . 'mp3';

        if (is_file($clipFilename)) {
            echo ' <input type=submit class="jz_submit" name="deleteclip" value="' . word_delete_clip . '">';
        } else {
            // Now let's see if this is an MP3 that can be downsampled

            if ('mp3' == $fileExt) {
                echo '<input type=submit class="jz_submit" name="createclip" value="' . word_create_clip . '"> ';
            }
        }

        echo '<br><br>' . '<input type=submit class="jz_submit" name="justclose" value="' . $word_close . '">';
    } else {
        echo '<br><input type=submit class="jz_submit" name="justclose" value="' . $word_close . '">';
    }

    echo '<br><br>' . '</td>' . "\n" . '</tr>' . "\n" . '</table>' . "\n" . '</form></body>' . "\n";
}

function excludeItem($excludeItem)
{
    global $web_root, $root_dir, $jinzora_temp_dir;

    $filename = $web_root . $root_dir . '/data/global-exclude.lst';

    // Now let's add a line break to the excluded item

    $excludeItem .= "\n";

    // Ok, now let's write this to the exclude file

    $handle = fopen($filename, 'ab');

    fwrite($handle, $excludeItem);

    fclose($handle);
}

?>

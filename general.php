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
* Code Purpose: This page contains all the "general" related functions
* Created: 9.24.03 by Ross Carlson
*
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

/**
 * Sets what the user is viewing so we can see the last X viewed
 *
 * @author  Ross Carlson
 * @version 05/04/04
 * @since   05/04/04
 * @param mixed $viewing
 */
function setViewing($viewing)
{
    global $web_root, $root_dir;

    if ('/' == $viewing) {
        return;
    }

    // Let's set what the file is

    $fileName = $web_root . $root_dir . '/data/viewed/viewing.lst';

    // Let's read the file first IF it exists

    if (is_file($fileName)) {
        $handle = fopen($fileName, 'rb');

        $contents = fread($handle, filesize($fileName));

        fclose($handle);

        // Now let's see how many we got back and if more than 50 we'll truncate

        $valArray = explode("\n", $contents);

        if (count($valArray) > 50) {
            $conArray = array_slice($valArray, 0, 50);

            $contents = implode("\n", $conArray);
        }
    } else {
        $contents = '';
    }

    // Now let's add to the contents

    $data = $viewing . "\n" . $contents;

    // Let's write to the viewing file

    $handle = fopen($fileName, 'wb');

    fwrite($handle, $data);

    fclose($handle);

    // Now let's set it for their session

    if (!isset($_SESSION['jz_viewed'])) {
        $_SESSION['jz_viewed'] = '';
    }

    if (!mb_stristr($_SESSION['jz_viewed'], str_replace('/', '---', $viewing)) and 'songs' == $_GET['ptype']) {
        $_SESSION['jz_viewed'] = str_replace('/', '---', $viewing) . "\n" . $_SESSION['jz_viewed'];
    }
}

/**
 * Checks to see if we are running Jinzora in Embedded mode
 *
 * @author  Ross Carlson
 * @version 05/04/04
 * @since   05/04/04
 */
function checkForEmbed()
{
    global $embedded_header;

    if ('' != $embedded_header and is_file($embedded_header)) {
        // Ok, there's a file there so let's include it

        require_once $embedded_header;
    }
}

/**
 * Sets a session variable with the URL of the current page
 *
 * @author  Ross Carlson
 * @version 05/04/04
 * @since   05/04/04
 * @returns Session variable $_SESSION['prev_page']
 */
function setPreviousPage()
{
    // Now let's set the session variable for later

    $_SESSION['prev_page'] = @$_SERVER['REQUEST_URI'];

    // Let's make sure it got set right and if not fix it

    if ('' == $_SESSION['prev_page']) {
        $_SESSION['prev_page'] = $_SERVER['URL'] . '?' . $_SERVER['QUERY_STRING'];
    }
}

/**
 * Returns how wide the columns on the genre/artist page should be
 *
 * @param int $items Number of items that are to be displayed
 * @returns int returns width
 * @return float|int
 * @return float|int
 * @since   05/03/04
 * @author  Ross Carlson
 * @version 05/03/04
 */
function returnColWidth($items)
{
    global $cols_in_genre;

    // Let's find out how wide the colums will be in percent

    $col_width = 100 / $cols_in_genre;

    // Now let's make sure we don't divide by zero (Thanks flavio!)

    if ($items < 1) {
        $items = 1;
    }

    // Let's make sure we have enough items to fill the number of colums that we wanted (say we wanted 3 cols but we only have 1 item)

    if ($items < $cols_in_genre) {
        // Ok, let's make this a better number

        $col_width = 100 / $items;
    }

    return $col_width;
}

/**
 * Convert minutes to seconds
 *
 * @param mixed $minutes
 * @returns returns the time in minutes:seconds
 * @return float|int|mixed|string
 * @return float|int|mixed|string
 * @since   04/29/04
 * @author  Ross Carlson
 * @version 04/29/04
 */
function convertMinsSecs($minutes)
{
    // Let's make sure it was mins:sec

    if (!mb_stristr($minutes, ':')) {
        $minutes .= ':';
    }

    // Now let's split it by the :

    $minArray = explode(':', $minutes);

    // Now let's create the time

    return ($minArray[0] * 60) + $minArray[1];
}

/**
 * Convert seconds to minutes
 *
 * @param int $seconds Number of seconds to convert to minutes
 * @returns returns the time in minutes:seconds
 * @return string
 * @return string
 * @since   04/29/04
 * @author  Ross Carlson
 * @version 04/29/04
 */
function convertSecMins($seconds)
{
    // First let's round it off

    $seconds = round($seconds);

    // Now let's loop through subtracking 60 each time

    $ctr = 0;

    while ($seconds >= 60) {
        $seconds -= 60;

        $ctr++;
    }

    if ($seconds < 10) {
        $seconds = '0' . $seconds;
    }

    return $ctr . ':' . $seconds;
}

/**
 * Check to see how many times the item has been "voted" on
 *
 * @param string $filename Filename of the place to get the data
 * @returns returns the number of "votes"
 * @return int|string
 * @return int|string
 * @since   04/28/04
 * @author  Ross Carlson
 * @version 04/28/04
 */
function returnVotes($filename)
{
    if (is_file($filename)) {
        // Ok, now let's get the data

        $handle = fopen($filename, 'rb');

        $contents = fread($handle, filesize($filename));

        fclose($handle);

        // Now let's count it

        $ctrArray = explode("\n", $contents);

        $votes = count($ctrArray);

        // Now let's remove one if a rating

        if (mb_stristr($filename, '.rating')) {
            $votes -= 1;
        }

        return $votes;
    }

    return 'NULL';
}

/**
 * Check to see if an item has been discussed or not
 *
 * @param string $data Information about the item to be discussed
 * @returns Return true or false saying if there were comments or not
 * @return bool
 * @return bool
 * @since   04/28/04
 * @author  Ross Carlson
 * @version 04/28/04
 */
function checkDiscuss($data)
{
    global $web_root, $root_dir;

    // Now let's see if there is a discussion file here

    $discFile = jzstripslashes($web_root . $root_dir . '/data/discussions/' . str_replace('/', '---', $data) . '.disc');

    $discFile = str_replace('/---', '/', $discFile);

    if (is_file($discFile)) {
        return true;
    }
  

    return false;
}

// This function returns the contents of a discussion file
// Added 4.6.04 by Ross Carlson
// Returns the contents of the file or nothing
function returnComments($filename)
{
    if (is_file($filename)) {
        $handle = fopen($filename, 'rb');

        $contents = fread($handle, filesize($filename));

        fclose($handle);

        return $contents;
    }
}

// This function reads a rmdata file to get the start stop times from it
// Added 4.6.04 by Ross Carlson
// Returns an array with 2 values, 1st is start, 2nd is stop
function returnRMStartStop($filename)
{
    // First let's make sure the file exists

    if (!is_file($filename)) {
        return [];
    }

    $handle = fopen($filename, 'rb');

    $contents = fread($handle, filesize($filename));

    fclose($handle);

    // Now let's split out the data

    return explode('|||', $contents);
}

// This function reads a given rating file and returns the rating for the item
// It returns an integer (of the rating, from 1 - 5) or NULL if nothing is found
// Added 3.8.04 by Ross Carlson
function readRating($rateFile)
{
    if (is_file($rateFile)) {
        // Now let's start the rating icon

        // Now let's read the ratings file and get the rating

        $handle = fopen($rateFile, 'rb');

        $contents = fread($handle, filesize($rateFile));

        fclose($handle);

        $rateArray = explode("\n", $contents);

        $rating = 0;

        for ($ctr = 0, $ctrMax = count($rateArray); $ctr < $ctrMax; $ctr++) {
            $ratingArray = explode('|', $rateArray[$ctr]);

            if (isset($ratingArray[1])) {
                $rating += $ratingArray[1];
            }
        }

        if ($ctr < 2) {
            $ctr++;
        }

        $rating /= ($ctr - 1);
    } else {
        $rating = 'NULL';
    }

    return $rating;
}

// This function will take a file name and return the amount of plays for that file
// It needs the FULL path to the file in question
// Added 4.6.04 by Ross Carlson
// It returns an integer for the number of plays, or zero if none
function returnCounter($trackName, $fileExt = 'ctr', $returnUser = 'false')
{
    global $web_root, $root_dir, $media_dir;

    // First let's strip off up to the media dir

    $ctrFile = str_replace($web_root . $root_dir . $media_dir . '/', '', $trackName);

    // Now let's figure out the XML filename

    $ctrFile = $web_root . $root_dir . '/data/counter/' . returnFormatedFilename($ctrFile) . '.' . $fileExt;

    // Ok, let's make sure it exists

    if (!is_file($ctrFile)) {
        return 0;
    }

    // Ok, now let's open that file and get the value of the counter

    $handle = fopen($ctrFile, 'rb');

    $hitData = trim(fread($handle, filesize($ctrFile)));

    fclose($handle);

    if ('false' == $returnUser) {
        if (mb_stristr($hitData, '|')) {
            return mb_substr($hitData, 0, mb_strpos($hitData, '|'));
        }
  

        return $hitData;
    }  

    if (mb_stristr($hitData, '|')) {
        return mb_substr($hitData, mb_strpos($hitData, '|') + 1, mb_strlen($hitData));
    }
  

    return '';
}

// This function will take a filename and return the formated name of the XML (or data) file
// Added 4.6.04 by Ross Carlson
// Returns the name of the file, formated, without the leading path (so just as it was sent)
function returnFormatedFilename($fileName)
{
    //Ok, let's set it

    $fileName = str_replace('/', '---', $fileName);

    // Now let's make sure we don't have any files beginning with ---

    while ('---' == mb_substr($fileName, 0, 3)) {
        $fileName = mb_substr($fileName, 3, mb_strlen($fileName));
    }

    return $fileName;
}

// This function will see if there is a thumbnail for the corresponding item
// Added 3.23.04 by Ross Carlson
// It returns false or the name of the file
function searchThumbnail($searchFile)
{
    global $ext_graphic, $web_root;

    $typeArray = explode('|', $ext_graphic);

    $thumb_file = '';

    $fileInfo = pathinfo($searchFile);

    $fileExt = $fileInfo['extension'];

    for ($e = 0, $eMax = count($typeArray); $e < $eMax; $e++) {
        $thumbFileName = str_replace('.' . $fileExt, '.thumb.' . $typeArray[$e], $searchFile);

        if (is_file($thumbFileName)) {
            $thumb_file = str_replace('%2F', '/', rawurlencode(str_replace($web_root, '', $thumbFileName)));
        }
    }

    // Now let's return it

    if ('' != $thumb_file) {
        return $thumb_file;
    }
  

    return false;
}

// This function forces the browser to display output
function flushDisplay()
{
    print str_repeat(' ', 4096);    // force a flush
}

/**
 * Read all files in all top level subdirs from where we are
 * to pass to function to write each tag
 *
 * @return void *
 * *@version 02/12/04
 * @since  02/12/04
 * @author Ross Carlson
 */
function updateAllTags()
{
    global $root_dir, $web_root, $media_dir, $css, $word_please_wait_artist, $word_updating_album;

    echo $css;

    // Let's let them know what we're doing

    echo $word_please_wait_artist . '<br>';

    // First let's read the directories where we are and go from there

    $retArray = readDirInfo($web_root . $root_dir . $media_dir . '/' . $_GET['info'], 'dir');

    for ($i = 0, $iMax = count($retArray); $i < $iMax; $i++) {
        // Now let's write all the tags for that dir

        echo '<br><strong>' . $word_updating_album . '</strong>: ' . $retArray[$i] . '<br>';

        flushDisplay();

        updateTags($_GET['info'] . '/' . $retArray[$i], 'false');
    } ?>
    <SCRIPT LANGUAGE=JAVASCRIPT TYPE="TEXT/JAVASCRIPT"><!--
        history.back();
        -->
    </SCRIPT>
    <?php
    exit();
}

// This function updates a specific set of files' ID3 tags
function updateTags($searchDir = '', $goBack = 'true')
{
    global $web_root, $root_dir, $media_dir, $track_num_seperator, $audio_types, $this_page, $url_seperator, $ext_graphic, $css, $word_updating_information, $word_updating_track;

    // First  let's fix the searchdir

    if ('' == $searchDir) {
        $searchDir = $_GET['info'];
    }

    // Now let's output the style sheet

    echo $css;

    echo '<strong>' . $word_updating_information . $searchDir . '</strong><br><br>';

    flushDisplay();

    ini_set('max_execution_time', '600');

    // Now let's include our ID3 classes

    require_once __DIR__ . '/id3classes/getid3.php';

    // Now let's figure out what directory we're supposed to update and read it's data

    $dirPath = $web_root . $root_dir . $media_dir . '/' . jzstripslashes($searchDir);

    $retArray = readDirInfo($dirPath, 'file');

    // Now let's split out the data we got so we know what the values will be

    $dataArray = explode('/', jzstripslashes($searchDir));

    $album = $dataArray[count($dataArray) - 1];

    $artist = $dataArray[count($dataArray) - 2];

    $genre = $dataArray[count($dataArray) - 3];

    // Now let's loop through the files...

    for ($i = 0, $iMax = count($retArray); $i < $iMax; $i++) {
        if (preg_match("/\.($audio_types)$/i", $retArray[$i])) {
            if (is_file($web_root . $root_dir . $media_dir . '/' . jzstripslashes($searchDir) . '/' . $retArray[$i])) {
                $trackName = $retArray[$i];

                // Now let's remove the file extension

                $fileInfo = pathinfo($trackName);

                $fileExt = $fileInfo['extension'];

                $trackName = str_replace('.' . $fileExt, '', $trackName);

                // Now let's clean up the trackName IF it's a lofi track

                if (mb_stristr($trackName, '.lofi')) {
                    $trackName = str_replace('.lofi', '', $trackName);
                }

                if (mb_stristr($trackName, '.clip')) {
                    $trackName = str_replace('.clip', '', $trackName);
                }

                // Now let's figure out the new track names...

                $trackSepArray = explode('|', $track_num_seperator);

                for ($c = 0, $cMax = count($trackSepArray); $c < $cMax; $c++) {
                    if (mb_stristr($trackName, $trackSepArray[$c])) {
                        // Now let's strip from the beginning up to and past the seperator

                        $trackName = mb_substr($trackName, mb_strpos($trackName, $trackSepArray[$c]) + mb_strlen($trackSepArray[$c]), 999999);
                    }
                }

                // Now let's figure out the tracknumber

                $trackNumber = mb_substr($retArray[$i], 0, 2);

                if (!is_numeric($trackNumber)) {
                    $trackNumber = '01';
                }

                // Ok, now we've got all the information, let's write the tags!

                $fileNamePath = $web_root . $root_dir . $media_dir . '/' . jzstripslashes($searchDir) . '/' . $retArray[$i];

                $albumArt = '';

                if (is_writable($fileNamePath)) {
                    $getID3 = new getID3();

                    getid3_lib::IncludeDependency($web_root . $root_dir . '/id3classes/write.php', __FILE__, true);

                    $tagwriter = new getid3_writetags();

                    $tagwriter->overwrite_tags = true;

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

                    $data['title'][] = $trackName;

                    $data['artist'][] = $artist;

                    $data['album'][] = $album;

                    $data['genre'][] = $genre;

                    $data['track'][] = $trackNumber;

                    $data['comment'][] = $description;

                    $data['year'][] = $year;

                    // Now let's see if there is album art to add

                    if ('' == $albumArt) {
                        $artArray = readDirInfo($dirPath, 'file');

                        for ($c = 0, $cMax = count($artArray); $c < $cMax; $c++) {
                            if (preg_match("/\.($ext_graphic)$/i", $artArray[$c])) {
                                $albumArt = $dirPath . '/' . $artArray[$c];

                                $pic_name = $artArray[$c];

                                $fileInfo = pathinfo($artArray[$c]);

                                $pic_extension = $fileInfo['extension'];
                            }
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

                    // Now let's write the tags

                    $tagwriter->tag_data = $data;

                    $tagwriter->filename = $fileNamePath;

                    $tagwriter->tagformats = ['id3v1', 'id3v2.3'];

                    $success = $tagwriter->WriteTags();

                    unset($data);

                    echo $word_updating_track . ': ' . $trackName;

                    flushDisplay();

                    // Now let's make sure it was successful

                    if (true === $success) {
                        echo ' - <font color=green>Successful</font><br>';
                    } else {
                        echo ' - <font color=red>Failed</font><br>';
                    }

                    flushDisplay();
                } else {
                    echo 'ERROR Updating track: ' . $trackName . '<br>';
                }
            }
        }
    }

    sleep(1);

    // Now let's send them back to where they belong...

    if ('true' == $goBack) {
        ?>
        <META HTTP-EQUIV="Refresh" CONTENT="1; URL=<?php echo $_SESSION['prev_page']; ?>">
        <?php
        exit();
    }
}

// This function just returns the directories for us
function readJustDirs($dirName, &$readCtr, &$mainArray)
{
    global $web_root, $root_dir, $media_dir;

    // Let's up the max_execution_time

    ini_set('max_execution_time', '600');

    // Let's look at the directory we are in

    if (is_dir($dirName)) {
        $d = dir($dirName);

        while ($entry = $d->read()) {
            // Let's make sure we are seeing real directories

            if ('.' == $entry || '..' == $entry) {
                continue;
            }

            // Now let's read this IF it's just a folder

            if (is_dir($dirName . '/' . $entry)) {
                $mainArray[$readCtr] = str_replace($web_root . $root_dir . $media_dir . '/', '', $dirName . '/' . $entry);

                $readCtr++;

                readJustDirs($dirName . '/' . $entry, $readCtr, $mainArray);
            }
        }

        // Now let's close the directory

        $d->close();

        // Now let's sort that array

        @sort($mainArray);
    }

    // Ok, let's return the data

    return $mainArray;
}

// This function takes a directory and get's all sub directories and files and puts them in an array
function readAllDirs($dirName, &$readCtr, &$mainArray, $searchExt = 'false', $displayProgress = 'false')
{
    global $audio_types, $video_types;

    // Let's up the max_execution_time

    ini_set('max_execution_time', '600');

    // Let's look at the directory we are in

    if (is_dir($dirName)) {
        $d = dir($dirName);

        while ($entry = $d->read()) {
            // Let's make sure we are seeing real directories

            if ('.' == $entry || '..' == $entry) {
                continue;
            }

            // Now let's see if we are looking at a directory or not

            if ('file' != filetype($dirName . '/' . $entry)) {
                // Ok, that was a dir, so let's move to the next directory down

                readAllDirs($dirName . '/' . $entry, $readCtr, $mainArray, $searchExt, $displayProgress);
            } else {
                // Let's see if they wanted status

                if ('true' == $displayProgress) {
                    if (0 == $readCtr % 50) {
                        echo '.';

                        flushDisplay();
                    }
                }

                // Let's see if we want to search a specfic extension or not

                if ('false' == $searchExt) {
                    // Ok, we found files, let's make sure they are audio or video files

                    if (preg_match("/\.($audio_types)$/i", $entry) or preg_match("/\.($video_types)$/i", $entry)) {
                        $mainArray[$readCtr] = $dirName . '/' . $entry;

                        $readCtr++;
                    }
                } else {
                    if (mb_stristr($entry, $searchExt)) {
                        $mainArray[$readCtr] = $dirName . '/' . $entry;

                        $readCtr++;
                    }
                }
            }
        }

        // Now let's close the directory

        $d->close();

        // Now let's sort that array

        @sort($mainArray);
    }

    // Ok, let's return the data

    return $mainArray;
}

// This function makes sure that the variable is TOTALLY clean of slashes
function jzstripslashes($variable)
{
    // Lets loop through until the variable is clean

    while ('' != mb_stristr($variable, '\\')) {
        $variable = stripslashes($variable);
    }

    while ('' != mb_stristr($variable, '//')) {
        $variable = str_replace('//', '/', ($variable));
    }

    // Now let's send the clean variable back

    return $variable;
}

// This function reads the directory specifed and returns the results into a sorted array */
function readDirInfo($dirName, $type)
{
    // Let's up the max_execution_time

    ini_set('max_execution_time', '600');

    $retArray = [];

    // let's change the directory name based on the number of directories to search */

    // First let's make sure this is really a dir...

    if (is_dir($dirName)) {
        $d = dir($dirName);

        while ($entry = $d->read()) {
            // Let's make sure this isn't the local directory we're looking at

            if ('.' == $entry || '..' == $entry) {
                continue;
            }

            // Let's see if they wanted to look for a directory or a file and add that to the array

            if ('dir' == $type and ('dir' == filetype($dirName . '/' . $entry) or 'link' == filetype($dirName . '/' . $entry))) {
                $retArray[] = $entry;
            }

            if ('file' == $type and '' != mb_stristr($entry, '.') and '' != $entry) {
                $retArray[] = $entry;
            }
        }

        $d->close();

        // Let's make sure we found something, and if we didn't let's not sort an empty array

        if (0 != count($retArray)) {
            sort($retArray);
        }
    }

    /* Now let's return the array to them */

    return $retArray;
}

function openPostNuke($authenticate_only = false)
{
    global $bgcolor1, $bgcolor2, $phpnuke, $default_access, $web_root, $root_dir, $jinzora_temp_dir, $cms_user_access, $cms_type;

    if (!defined('LOADED_AS_MODULE') and 'false' == $phpnuke) {
        die(
            "You can't access this file directly...<br><br>Generally this means that Jinzora was " . "installed as a PostNuke module and you're trying to access it outside of PostNuke"
        );
    }

    if (!pnSecAuthAction(0, 'jinzora::', '::', ACCESS_READ)) {
        require __DIR__ . '/header.php';

        die('Access Denied');

        require __DIR__ . '/footer.php';
    }

    // Let's see if the cookie has been set, but check that it shouldn't have changed

    if (isset($_COOKIE['jz_user_name'])) {
        if (pnUserGetVar('uname') != $_COOKIE['jz_user_name']) {
            if ('' == pnUserGetVar('uname') and 'anonymous' == $_COOKIE['jz_user_name']) {
            } else {
                setcookie('jz_user_name', '', '0', '/', '', 0);

                setcookie('jz_access_level', '', '0', '/', '', 0);
            }
        }
    }

    // Now let's get the users name IF we need it

    if ('' != pnUserGetVar('uname')) {
        $username = pnUserGetVar('uname');
    } else {
        $username = 'anonymous';
    }

    // Ok, now let's authenticate this user

    userAuthenticate($username);

    // Now let's see if we only wanted the user access

    if (true === $authenticate_only) {
        return;
    }

    require_once 'header.php';

    $bgc02 = ($cms_mode) ? $bgcolor4 : $bgcolor2;

    echo "$submit<style type=\"text/css\">" . ".jz_row1 { background-color:$bgcolor1; }.jz_row2 { background-color:$bgc02; }</style>";

    // Now let's open the table

    OpenTable();
}

function openPHPNuke($authenticate_only = false)
{
    global $this_site, $mp3_dir, $temp_zip_dir, $web_root, $path_to_zip, $jinzora_temp_dir, $root_dir, $media_dir, $audio_types, $video_types, $ext_graphic, $slash_vars, $cms_user_access, $default_access;

    // Let's see if the cookie has been set, but check that it shouldn't have changed

    if (isset($_COOKIE['jz_user_name'])) {
        $cookie = cookiedecode($_COOKIE['user']);

        $username = $cookie[1];

        if ('' == $username) {
            $username = 'anonymous';
        }

        if ($username != $_COOKIE['jz_user_name']) {
            setcookie('jz_user_name', '', '0', '/', '', 0);

            setcookie('jz_access_level', '', '0', '/', '', 0);
        }
    }

    // Now let's get the users name IF we need it

    $cookie = cookiedecode($_COOKIE['user']);

    $username = $cookie[1];

    if ('' == $username) {
        $username = 'anonymous';
    }

    // Ok, now let's authenticate this user

    userAuthenticate($username);

    // Now let's see if we only wanted the user access

    if (true === $authenticate_only) {
        return;
    }

    require_once 'header.php';

    $bgc02 = ($cms_mode) ? $bgcolor4 : $bgcolor2;

    echo "$submit<style type=\"text/css\">" . ".jz_row1 { background-color:$bgcolor1; }.jz_row2 { background-color:$bgc02; }</style>";

    OpenTable();
}

/* This will open the display for CMS integration */
function openCMS($authenticate_only = false)
{
    global $bgcolor1, $bgcolor2, $phpnuke, $default_access, $web_root, $root_dir, $jinzora_temp_dir, $cms_user_access, $cms_type;

    // Now let's see what CMS they are using and open the appropriate one

    switch ($cms_type) {
        case 'postnuke': # Ok, let's open Postnuke
            openPostNuke($authenticate_only);
            break;
        case 'phpnuke': # Ok, let's open PHPNuke
            openPHPNuke($authenticate_only);
            break;
        case 'nsnnuke': # Ok, let's open PHPNuke
            openPHPNuke($authenticate_only);
            break;
        case 'mambo': # Ok, let's open Mambo...
            openMambo($authenticate_only);
            break;
        case 'mdpro': # Ok, let's open Mambo...
            openMDPro($authenticate_only);
            break;
    }
}

// This function opens the MDPro CMS
// Added 2.29.04 by Ross Carlson
function openMDPro($authenticate_only = false)
{
    if (!defined('LOADED_AS_MODULE') and 'false' == $phpnuke) {
        die(
            "You can't access this file directly...<br><br>Generally this means that Jinzora was " . "installed as a PostNuke module and you're trying to access it outside of PostNuke"
        );
    }

    // Let's see if the cookie has been set, but check that it shouldn't have changed

    if (isset($_COOKIE['jz_user_name'])) {
        if (pnUserGetVar('uname') != $_COOKIE['jz_user_name']) {
            if ('' == pnUserGetVar('uname') and 'anonymous' == $_COOKIE['jz_user_name']) {
            } else {
                setcookie('jz_user_name', '', '0', '/', '', 0);

                setcookie('jz_access_level', '', '0', '/', '', 0);
            }
        }
    }

    // Now let's get the users name IF we need it

    if ('' != pnUserGetVar('uname')) {
        $username = pnUserGetVar('uname');
    } else {
        $username = 'anonymous';
    }

    // Ok, now let's authenticate this user

    userAuthenticate($username);

    // Now let's see if we only wanted the user access

    if (true === $authenticate_only) {
        return;
    }

    require_once 'header.php';

    $bgc02 = ($cms_mode) ? $bgcolor4 : $bgcolor2;

    echo "$submit<style type=\"text/css\">" . ".jz_row1 { background-color:$bgcolor1; }.jz_row2 { background-color:$bgc02; }</style>";

    // Now let's open the table

    OpenTable();
}

// This function opens Mambo for us
function openMambo()
{
    global $mainframe, $my;

    defined('_VALID_MOS') || die('Direct Access to this location is not allowed.');

    // Let's get this users username

    $username = $my->username;

    if ('' == $username) {
        $username = 'anonymous';
    }

    // Ok, now let's authenticate this user

    userAuthenticate($username);
}

function userAuthenticate($username)
{
    global $this_site, $web_root, $root_dir, $media_dir, $slash_vars, $cms_user_access, $default_access;

    // Let's set how long the cookie will last

    // TO DO: Make this a variable

    $expire = time() + 60 * 60 * 24 * 365;

    // Ok, let's set the username cookie IF it's not set or has changed

    if (!isset($_COOKIE['jz_user_name'])) {
        setcookie('jz_user_name', $username, $expire, '/', '', 0);
    } else {
        if ($_COOKIE['jz_user_name'] != $username) {
            setcookie('jz_user_name', $username, $expire, '/', '', 0);
        }
    }

    // Now let's set the default access level

    $_SESSION['jz_access_level'] = $default_access;

    if ('anonymous' != $username) {
        $_SESSION['jz_access_level'] = $cms_user_access;
    }

    // Now let's get their access level

    require_once $web_root . $root_dir . '/users.php';

    // Now let's parse the user array to find the correct user, match their password, and get their admin level

    $ctr = 0;

    while (count($user_array) > $ctr) {
        if (mb_strtolower($username) == mb_strtolower($user_array[$ctr][0])) {
            // Ok, we have a match on the username

            // First let's make sure we need to change it or not

            if (!isset($_SESSION['jz_access_level'])) {
                $_SESSION['jz_access_level'] = $user_array[$ctr][2];
            } else {
                // Ok, it was set, but is it right???

                $_SESSION['jz_access_level'] = $user_array[$ctr][2];

                //echo '<meta http-equiv="refresh" content="0">';
            }
        }

        /* Let's move to the next item in the array */

        $ctr += 1;
    }

    // Now let's make sure the cookie is set, and if not refresh

    if (!isset($_COOKIE['jz_user_name'])) {
        echo '';

        echo '<meta http-equiv="refresh" content="0">';

        exit();
    }
}

function closeMambo()
{
}

// This function will close the CMS for us
function closeCMS()
{
    global $cms_type;

    // Now let's see what CMS they are using and open the appropriate one

    switch ($cms_type) {
        case 'postnuke': # Ok, let's close Postnuke
            closePostNuke();
            break;
        case 'phpnuke': # Ok, let's close PHPNuke
            closePHPNuke();
            break;
        case 'nsnnuke': # Ok, let's close NSNNuke
            closeNSNNuke();
            break;
        case 'mambo': # Ok, let's close Mambo
            closeMambo();
            break;
        case 'mdpro': # Ok, let's close Mambo
            closeMDPro();
            break;
    }
}

// This will close PHPNuke
function closeNSNNuke()
{
    CloseTable();

    require_once 'footer.php';
}

// This will close PHPNuke
function closePHPNuke()
{
    CloseTable();

    require_once 'footer.php';
}

// This will close the display as a PostNuke module
function closePostNuke()
{
    CloseTable();

    require_once 'footer.php';
}

// This will close the MDPro CMS
// Added 2.29.04 by Ross Carlson
function closeMDPro()
{
    CloseTable();

    require_once 'footer.php';
}

function check_for_numerics($str)
{
    for ($i = 0, $iMax = mb_strlen($str); $i < $iMax; $i++) {
        if (is_numeric($str[$i])) {
            return (bool)true;
        }
    }
}

// This function will write out error messages to the log files...
function writeLogData($logName, $data)
{
    global $web_root, $root_dir, $jinzora_temp_dir;

    // Let's see what file they wanted to open and open it up!

    if ('error' == $logName) {
        $fileName = $web_root . $root_dir . $jinzora_temp_dir . '/jinzora-error.log';

        $handle = fopen($fileName, 'ab');

        $data = date('n/j/y g:i:s', time()) . ' - ' . $data . "\n";

        fwrite($handle, $data);

        fclose($handle);
    }
}

// This function returns the installed GD version
function gd_version()
{
    static $gd_version_number = null;

    if (null === $gd_version_number) {
        ob_start();

        phpinfo(INFO_MODULES);

        $module_info = ob_get_contents();

        ob_end_clean();

        if (preg_match("/\bgd\s+version\b[^\d\n\r]+?([\d\.]+)/i", $module_info, $matches)) {
            $gd_version_number = $matches[1];
        } else {
            $gd_version_number = 0;
        }
    }

    return $gd_version_number;
}

/* This function will resize the JPEG's we pass into the site for us and produce PNG's */
function resizeImage($source_image, $destination_image, $destination_width, $destination_height)
{
    global $keep_porportions;

    // First we need to see if GD is installed or not...

    if (0 == gd_version()) {
        // Ok, no GD, let's write that to the log...

        writeLogData('error', 'Sorry, GD Libraries not found while trying to resize an image...');

        return false;
    }

    /* get the picture and set the output picture */

    $image = $source_image;

    $new_image = $destination_image;

    /* Let's grab the source image that was uploaded to work with it */

    $src_img = @imagecreatefromjpeg($image);

    if ('' != $src_img) {
        /* Let's get the width and height of the source image */

        $src_width = imagesx($src_img);

        $src_height = imagesy($src_img);

        /* Let's set the width and height of the new image we'll create */

        $dest_width = $destination_width;

        $dest_height = $destination_height;

        /* Now if the picture isn't a standard resolution (like 640x480) we
           need to find out what the new image size will be by figuring
           out which of the two numbers is higher and using that as the scale */

        // First let's make sure they wanted to keep the porportions or not

        if ('true' == $keep_porportions) {
            if ($src_width > $src_height) {
                /* ok so the width is the bigger number so the width doesn't change
                   We need to figure out the percent of change by dividing the source width
                   by the dest width */

                $scale = $src_width / $destination_width;

                $dest_height = $src_height / $scale;
            } else {
                /* ok so the width is the bigger number so the width doesn't change
                   We need to figure out the percent of change by dividing the source width
                   by the dest width */

                $scale = $src_height / $destination_height;

                $dest_width = $src_width / $scale;
            }
        } else {
            $dest_height = $destination_height;

            $dest_width = $destination_width;
        }

        /* Now let's create our destination image with our new height/width */

        if (gd_version() >= 2) {
            $dest_img = imagecreatetruecolor($dest_width, $dest_height);
        } else {
            $dest_img = imagecreate($dest_width, $dest_height);
        }

        /* Now let's copy the data from the old picture to the new one witht the new settings */

        if (gd_version() >= 2) {
            imagecopyresampled($dest_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $src_width, $src_height);
        } else {
            imagecopyresized($dest_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $src_width, $src_height);
        }

        /* Now let's create our new image */

        @imagejpeg($dest_img, $new_image);

        /* Now let's clean up all our temp images */

        imagedestroy($src_img);

        imagedestroy($dest_img);

        return true;
    }
  

    return false;
}

// This function will search Google for album art
function albumArtSearch($info)
{
    global $word_search_results, $word_download, $this_page, $web_root, $root_dir, $jinzora_temp_dir, $artist_truncate, $album_name_truncate, $directory_level, $url_seperator;

    // First let's show the page header

    displayHeader($word_search_results);

    // Let's setup our contents variable for later

    $contents = '';

    // clean up info and convert it to utf8

    $info = stripslashes(urldecode($info));

    if (!seems_utf8($info)) {
        $info = iconv('ISO-8859-1', 'UTF-8', $info);
    }

    // First let's make sure there aren't any blanks in the search feild

    // That would be where there are 6 | symbols....

    $info = str_replace('||||||', '|||', $info);

    // Now let's parse out the artist and album info

    $infoArray = explode('|||', $info);

    // Now let's read the last two entries, that will be the arist and album name

    // We'll also wrap them in quotes for our search later

    $searchData1 = $infoArray[count($infoArray) - 2];

    $searchData2 = $infoArray[count($infoArray) - 1];

    $searchData3 = $infoArray[count($infoArray) - 3];

    // Let's directly open Google to get the data

    if (@fsockopen('images.google.com', 80, $errno, $errstr, 5)) {
        $fp = fsockopen('images.google.com', 80, $errno, $errstr, 5);

        // now let's make sure it opened ok

        if ($fp) {
            $path = '/images?as_q=' . urlencode('"' . $searchData1 . '" "' . $searchData2 . '"') . '&svnum=10&hl=en&ie=UTF-8&oe=UTF-8&btnG=Google+Search&as_epq=&as_oq=&as_eq=&imgsz=&as_filetype=jpg&imgc=&as_sitesearch=&safe=off';

            fwrite($fp, "GET $path HTTP/1.1\n");

            fwrite($fp, "Content-type: application/x-www-form-urlencoded\n");

            fwrite($fp, "Connection: close\n\n");

            // Now let's read all the data

            while (!feof($fp)) {
                $contents .= fgets($fp, 128);
            }

            fclose($fp);

            // Ok, now that we have all the contents we need to parse it out

            $contents = mb_substr($contents, mb_strpos($contents, ' Search took'));

            $contents = mb_substr($contents, mb_strpos($contents, '<img '));

            // Let's fix the path to the images

            $contents = str_replace('src=/image', 'src=http://images.google.com/image', $contents);

            // gets all the images at once in the out[1] array

            preg_match_all('/<img src=(http:\/\/images\.google\.com\/images\?[^>\s]+)[^>]*>/', $contents, $out);
        }
    }

    // Let's setup a form for below

    // Let's see if they wanted to return to the tools page or not

    if (isset($_GET['return'])) {
        echo '<form action="' . $this_page . $url_seperator . 'return=' . $_GET['return'] . '" method="post">';
    } else {
        echo '<form action="' . $this_page . '" method="post">';
    }

    echo '<input type="hidden" name="albumArtInfo" value="' . str_replace('|||', '/', $_GET['info']) . '">';

    // Now let's tell them what they searched for

    $infoArray = explode('|||', $_GET['info']);

    if ('3' == $directory_level) {
        echo '<center><strong>';

        if ('' != $searchData3) {
            echo $searchData3 . ' | ';
        }

        echo $searchData1 . '<br>' . $searchData2 . '</strong><br><br></center>';
    }

    if ('2' == $directory_level) {
        echo '<center><strong>' . $infoArray[1] . '<br>' . $infoArray[2] . '</strong><br><br></center>';
    }

    // Now let's setup our table for below

    echo '<table width="100%" cellspacing="0" cellpadding="0" border="0">';

    // Ok let's loop through the images we found

    $ctr = 0;

    $ctr2 = 2;

    $artFound = false;

    while (count($out[1]) > $ctr) {
        // Let's make sure it really is a .jpg or .jpeg file

        if (0 != mb_strpos($out[1][$ctr], '.jp')) {
            // Now that we've found images let's display them

            if (2 == $ctr2) {
                $ctr2 = 0;

                echo '</tr><tr>';
            } else {
                $ctr2 += 1;
            }

            echo '<td width="33%" align="center">';

            echo '<img src="'
                 . $out[1][$ctr]
                 . '?'
                 . time()
                 . '" border="0"><br>'
                 . '<input type="hidden" name="image-'
                 . $ctr
                 . '" value="'
                 . str_replace('http://images.google.com/images?', '', $out[1][$ctr])
                 . '"><br><input type="submit" name="saveimage-'
                 . $ctr
                 . '" value="'
                 . $word_download
                 . '" class="jz_submit"><br><br>';

            echo '</td>';

            $artFound = true;
        }

        // Let's increment our counter

        $ctr++;
    }

    // Let's close our table

    echo '</table>';

    // Let's increment the counter for below

    $ctr++;

    // Let's get the title for the image

    $titleArray = explode('|||', $_GET['info']);

    $artistName = $titleArray[count($titleArray) - 2];

    $albumName = $titleArray[count($titleArray) - 1];

    if (mb_strlen($artistName) > $artist_truncate) {
        $artistName = mb_substr($titleArray[count($titleArray) - 2], 0, $artist_truncate);

        $artistName .= '...';
    }

    if (mb_strlen($albumName) > $album_name_truncate) {
        $albumName = mb_substr($titleArray[count($titleArray) - 1], 0, $album_name_truncate);

        $albumName .= '...';
    }

    $title = $artistName . "\n\n" . $albumName;

    // Now let's create our blank image

    if (true === createBlankImage($web_root . $root_dir . '/style/images/default.jpg', 5, $title, '255 255 255', '0 0 0', 0, 200, 'center', 'center')) {
        // Now let's give them a blank, default one

        // Now let's setup our table for below

        echo '<table width="100%" cellspacing="0" cellpadding="0" border="0">'
             . '<tr><td width="100%" align="center">'
             . '<img src="'
             . $root_dir
             . $jinzora_temp_dir
             . '/temp-image.jpg?'
             . time()
             . '" border="0"><br>'
             . '<input type="hidden" name="defaultimage" value="DEFAULT"><br>'
             . '<input type="submit" name="savedefault" value="'
             . $word_download
             . '" class="jz_submit"><br><br><br>'
             . '</td></tr></table>'
             . '</form>';
    } else {
        echo '<table width="100%" cellspacing="0" cellpadding="0" border="0">' . '<tr><td width="100%" align="center">' . 'Sorry, there was an error getting any images...<br><br>' . '</td></tr></table>' . '</form>';
    }
}

function createBlankImage($image, $font, $text, $color, $shadow, $drop, $maxwidth, $alignment, $valign, $padding = '5')
{
    global $web_root, $root_dir, $jinzora_temp_dir;

    // First we need to see if GD is installed or not...

    if (0 == gd_version()) {
        // Ok, no GD, let's write that to the log...

        writeLogData('error', 'Sorry, GD Libraries not found while trying to grab an image from google');

        return false;
    }

    /* Now let's create our destination image with our new height/width */

    $src_img = imagecreatefromjpeg($image);

    if (gd_version() >= 2) {
        $dest_img = imagecreatetruecolor($maxwidth, $maxwidth);
    } else {
        $dest_img = imagecreate($maxwidth, $maxwidth);
    }

    // decode color arguments and allocate colors

    $color_args = explode(' ', $color);

    $color = imagecolorallocate($dest_img, $color_args[0], $color_args[1], $color_args[2]);

    $shadow_args = explode(' ', $shadow);

    $shadow = imagecolorallocate($dest_img, $shadow_args[0], $shadow_args[1], $shadow_args[2]);

    /* Let's get the width and height of the source image */

    $src_width = imagesx($src_img);

    $src_height = imagesy($src_img);

    /* Now let's copy the data from the old picture to the new one witht the new settings */

    if (gd_version() >= 2) {
        imagecopyresampled($dest_img, $src_img, 0, 0, 0, 0, $maxwidth, $maxwidth, $src_width, $src_height);
    } else {
        imagecopyresized($dest_img, $src_img, 0, 0, 0, 0, $maxwidth, $maxwidth, $src_width, $src_height);
    }

    /* Now let's clean up our temp image */

    imagedestroy($src_img);

    $fontwidth = imagefontwidth($font);

    $fontheight = imagefontheight($font);

    $margin = floor($padding + $drop) / 2; // So that shadow is not off image on right align & bottom valign

    if (null != $maxwidth) {
        $maxcharsperline = floor(($maxwidth - ($margin * 2)) / $fontwidth);

        $text = wordwrap($text, $maxcharsperline, "\n", 1);
    }

    $lines = explode("\n", $text);

    switch ($valign) {
        case 'center':
            $y = (imagesy($dest_img) - ($fontheight * count($lines))) / 2;
            break;
        case 'bottom':
            $y = imagesy($dest_img) - (($fontheight * count($lines)) + $margin);
            break;
        default:
            $y = $margin;
            break;
    }

    switch ($alignment) {
        case 'right':
            while (list($numl, $line) = each($lines)) {
                imagestring($dest_img, $font, (imagesx($dest_img) - $fontwidth * mb_strlen($line)) - $margin + $drop, ($y + $drop), $line, $shadow);

                imagestring($dest_img, $font, (imagesx($dest_img) - $fontwidth * mb_strlen($line)) - $margin, $y, $line, $color);

                $y += $fontheight;
            }
            break;
        case 'center':
            while (list($numl, $line) = each($lines)) {
                imagestring($dest_img, $font, floor((imagesx($dest_img) - $fontwidth * mb_strlen($line)) / 2) + $drop, ($y + $drop), $line, $shadow);

                imagestring($dest_img, $font, floor((imagesx($dest_img) - $fontwidth * mb_strlen($line)) / 2), $y, $line, $color);

                $y += $fontheight;
            }
            break;
        default:
            while (list($numl, $line) = each($lines)) {
                imagestring($dest_img, $font, $margin + $drop, ($y + $drop), $line, $shadow);

                imagestring($dest_img, $font, $margin, $y, $line, $color);

                $y += $fontheight;
            }
            break;
    }

    /* Now let's create our new image */

    $new_image = $web_root . $root_dir . $jinzora_temp_dir . '/temp-image.jpg';

    @touch($new_image);

    // Now let's make sure that new image is writable

    if (is_writable($new_image)) {
        imagejpeg($dest_img, $new_image);

        /* Now let's clean up our temp image */

        imagedestroy($dest_img);

        return true;
    }  

    echo "Sorry, I couldn't open the temporary image file for writing.<br>"
             . 'looks like something is wrong with the permissions on your temp directory at:<br><br>'
             . $web_root
             . $root_dir
             . $jinzora_temp_dir
             . '<br><br>'
             . 'Sorry about that, but this is a fatal error!<br><br>'
             . 'You could turn off auto art searching in settings.php by changing<br><br>'
             . '$search_album_art = "false";';

    exit();

    return false;
}

// This function actaully gets and saves the selectd album art
function grabAlbumArt()
{
    global $web_root, $root_dir, $media_dir, $this_page, $this_site, $jinzora_temp_dir, $url_seperator;

    // Let's loop through and find which one they clicked on

    $found = false;

    $ctr = 0;

    $contents = '';

    while (true != $found) {
        // Let's first see if they pressed the DEFAULT button or not

        if (isset($_POST['savedefault'])) {
            // Let's see if they wanted the default image

            // Now let's copy that image into place

            $fileInfo = explode('/', $_POST['albumArtInfo']);

            $imgName = $fileInfo[count($fileInfo) - 1];

            $finalFile = $web_root . $root_dir . $media_dir . '/' . $_POST['albumArtInfo'] . '/' . $imgName . '.jpg';

            $sourceFile = $web_root . $root_dir . $jinzora_temp_dir . '/temp-image.jpg';

            // Let's make sure the old file didn't exist

            @unlink($finalFile);

            // Now let's copy the source into place

            copy($sourceFile, $finalFile);

            $found = 'true';
        } else {
            if (isset($_POST['saveimage-' . $ctr])) {
                // Ok we found the button they pressed

                $found = true;

                // Ok, let's get the full filename and path to the new file we'll create

                $fileInfo = explode('/', $_POST['albumArtInfo']);

                $imgName = $fileInfo[count($fileInfo) - 1];

                $fileName = $web_root . $root_dir . $media_dir . '/' . $_POST['albumArtInfo'] . '/' . $imgName . '.jpg';

                // Now let's open Google and get the contents of the image

                $fp = fsockopen('images.google.com', 80, $errno, $errstr, 5);

                if ($fp) {
                    $path = '/images?' . $_POST['image-' . $ctr];

                    fwrite($fp, "GET $path HTTP/1.0\n");

                    fwrite($fp, "Connection: close\n\n");

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

                    // Let's make sure the old file didn't exist

                    @unlink($fileName);

                    // Now that we have the data, let's write it to the new file

                    if (!file_exists($fileName)) {
                        @touch($fileName);
                    }

                    if (is_writable($fileName)) {
                        $handle = fopen($fileName, 'wb');

                        fwrite($handle, $contents);

                        fclose($handle);
                    }
                }
            }
        }

        $ctr += 1;
    }

    // Ok, now that we're done let's send them back to where they started

    $locdata = explode('/', $_POST['albumArtInfo']);

    // Let's make sure we get data for each

    if ('' != $locdata[count($locdata) - 3]) {
        $genre = $locdata[count($locdata) - 3];
    } else {
        $genre = '/';
    }

    if ('' != $locdata[count($locdata) - 2]) {
        $artist = $locdata[count($locdata) - 2];
    } else {
        $artist = '/';
    }

    if ('' != $locdata[count($locdata) - 1]) {
        $album = $locdata[count($locdata) - 1];
    } else {
        $album = '/';
    }

    // Now let's figure out where to send them back to

    if (isset($_GET['return'])) {
        if ('tool' == $_GET['return']) {
            $url_location = $this_page . $url_seperator . 'ptype=tools&action=searchforart';
        }

        if ('artist' == $_GET['return']) {
            $url_location = $this_page . $url_seperator . 'ptype=artist&genre=' . urlencode($genre) . '&artist=' . urlencode($artist);
        }

        if ('songs' == $_GET['return']) {
            $url_location = $this_page . $url_seperator . 'ptype=songs&genre=' . urlencode($genre) . '&artist=' . urlencode($artist) . '&album=' . urlencode($album);
        }
    } else {
        $url_location = $this_page . $url_seperator . 'ptype=songs&genre=' . urlencode($genre) . '&artist=' . urlencode($artist) . '&album=' . urlencode($album);
    }

    // Now let's send them

    header('Location: ' . $url_location);
}

// This function will resize the album images
function jzResizeAlbum($dirToSearch, $artistImage)
{
    global $album_img_width, $album_img_height;

    // Now let's see if the artist image needs to be resized

    if ('0' != $album_img_width and '0' != $album_img_height) {
        // Now let's get the image dimensions and see if it needs resizing

        $imgFile = $dirToSearch . '/' . $artistImage;

        $imgDst = $dirToSearch . '/' . $artistImage . '.new';

        $imgDim = getimagesize($imgFile);

        $imgWidth = $imgDim[0];

        $imgHeight = $imgDim[1];

        // Now let's see if either is bigger or smaller than what we want

        if ($imgHeight != $album_img_height && $imgWidth != $album_img_width) {
            // Ok, we need to change the height of the image

            if (true === resizeImage($imgFile, $imgDst, $album_img_width, $album_img_height)) {
                // Now let's make sure there's not another old file, because we don't want to replace it

                if (!is_file($imgFile . '.old')) {
                    // Now let's backup the old file

                    @rename($imgFile, $imgFile . '.old');
                }

                // Now let's put the new file in place

                @rename($imgDst, $imgFile);
            }
        }
    }
}

// This function will resize the artist images
function jzResizeArtist($dirToSearch, $Image)
{
    global $artist_img_width, $artist_img_height;

    // Now let's see if the artist image needs to be resized

    if ('0' != $artist_img_width and '0' != $artist_img_height) {
        // Now let's get the image dimensions and see if it needs resizing

        $imgFile = $dirToSearch . '/' . $Image;

        $imgDst = $dirToSearch . '/' . $Image . '.new';

        $imgDim = getimagesize($imgFile);

        $imgWidth = $imgDim[0];

        $imgHeight = $imgDim[1];

        // Now let's see if either is bigger or smaller than what we want

        if ($imgHeight != $artist_img_height && $imgWidth != $artist_img_width) {
            // Ok, we need to change the height of the image

            if (true === resizeImage($imgFile, $imgDst, $artist_img_width, $artist_img_height)) {
                // Now let's make sure there's not another old file, because we don't want to replace it

                if (!is_file($imgFile . '.old')) {
                    // Now let's backup the old file

                    @rename($imgFile, $imgFile . '.old');
                }

                // Now let's put the new file in place

                @rename($imgDst, $imgFile);
            }
        }
    }
}

// This function looks to see if we can find any media where we are, and if we can display it
function lookForMedia($dirToLookIn, $show_word = 'true', $justReturn = false)
{
    global $audio_types, $video_types, $audio_types, $video_types, $ext_graphic, $img_play, $img_download, $get_mp3_info, $song_cellpadding, $row_colors, $main_table_width, $this_page, $word_play_album, $word_download_album, $root_dir, $media_dir, $this_site, $allow_download, $track_num_seperator, $directory_level, $web_root, $num_other_albums, $word_album, $album_name_truncate, $word_play, $img_more, $search_album_art, $word_search_for_album_art, $img_delete, $word_cancel, $word_delete, $word_are_you_sure_delete, $img_add, $img_playlist, $word_check_all, $word_check_none, $word_selected, $word_session_playlist, $word_new_playlist, $playlist_directory, $playlist_ext, $word_play_random, $img_random_play, $javascript, $get_mp3_info, $colapse_tracks, $jinzora_skin, $word_search, $amg_search, $hide_tracks, $word_hide_tracks, $word_show_tracks, $cms_mode, $download_mp3_only, $this_site, $word_change_art, $album_force_height, $album_force_width, $hide_id3_comments, $img_more_dis, $img_play_dis, $img_download_dis, $url_seperator, $enable_ratings, $img_rate, $img_star, $img_half_star, $num_top_ratings, $num_suggestions, $enable_suggestions, $enable_most_played, $num_most_played, $track_plays, $word_tracks, $slim_mode, $display_charts, $random_albums;

    // Ok, let's read that directory so we can see what's there

    $retArray = readDirInfo($dirToLookIn, 'file');

    // Let's look at what we got back

    $media_found = false;

    for ($ctr = 0, $ctrMax = count($retArray); $ctr < $ctrMax; $ctr++) {
        // Now let's make sure it's a media file

        if (preg_match("/\.($audio_types)$/i", $retArray[$ctr]) or preg_match("/\.($video_types)$/i", $retArray[$ctr]) or preg_match("/\.(fake.txt)$/i", $retArray[$ctr]) or preg_match("/\.(fake.lnk)$/i", $retArray[$ctr])) {
            // Ok, we found stuff, let's set our variable for later

            $media_found = true;
        }
    }

    if (true === $justReturn) {
        return $media_found;
    }

    // Now let's include the top tracks IF they wanted it

    if (('true' == $enable_ratings or 'true' == $track_plays) and 'true' != $slim_mode) {
        switch ($directory_level) {
            case '3': # 3 directories deep
                if ('genre' != $_GET['ptype'] and 'artist' != $_GET['ptype'] and 'songs' != $_GET['ptype']) {
                    require_once __DIR__ . '/toptracks.php';
                }
                break;
            case '2': # 2 directories deep
                if ('artist' != $_GET['ptype'] and 'songs' != $_GET['ptype']) {
                    require_once __DIR__ . '/toptracks.php';
                }
                break;
            case '1': # 1 directories deep
                if ('songs' != $_GET['ptype']) {
                    require_once __DIR__ . '/toptracks.php';
                }
                break;
        }
    }

    if ('' != $random_albums and '0' != $random_albums) {
        // Now let's figure out if we are looking at a specific level or not

        if ('songs' != $_GET['ptype'] and 'artist' != $_GET['ptype']) {
            $level = $_GET['genre'] ?? '';

            displayRandomAlbums($random_albums, $level);
        }
    }

    // Now let's include the charts IF they wanted it

    if ('true' == $display_charts and 'true' != $slim_mode) {
        if ('songs' != $_GET['ptype'] and 'artist' != $_GET['ptype']) {
            require_once __DIR__ . '/charts.php';
        }
    }

    // Now let's see if we found media above

    if (true === $media_found) {
        // Ok, we found media, so let's display it in the songs table

        if ('true' == $show_word) {
            echo '<br><strong>' . $word_tracks . '</strong>';
        }

        displaySongs(false);

        return 'true';
    }
  

    return 'false';
}

function deleteSelected()
{
    global $web_root;

    // Ok, first we need to loop through what they selected

    $numBoxes = $_POST['numboxes'];

    $ctr = 0;

    $ctr2 = 0;

    while ($numBoxes > $ctr) {
        // Now let's see what they selected

        if (isset($_POST['track-' . $ctr])) {
            // Ok, now we've got the tracks, let's create an array for them

            // First we need to make sure that there are no double slashes, so we'll loop through and kill them

            $trackPath = $_POST['track-' . $ctr];

            while (0 != mb_strpos($trackPath, '//')) {
                $trackPath = str_replace('//', '/', $trackPath);
            }

            $trackArray[$ctr2] = $web_root . $trackPath;

            $ctr2 = $ctr + 1;
        }

        $ctr += 1;
    }

    // Now let's sort the array

    if (0 != count($trackArray)) {
        sort($trackArray);
    }

    // Now let's delete what we found

    $ctr = 0;

    while (count($trackArray) > $ctr) {
        // Alright, let's do it!

        unlink($trackArray[$ctr]);

        $ctr += 1;
    }
}

function returnGenres()
{
    return [
        0 => 'Blues',
        1 => 'Classic Rock',
        2 => 'Country',
        3 => 'Dance',
        4 => 'Disco',
        5 => 'Funk',
        6 => 'Grunge',
        7 => 'Hip-Hop',
        8 => 'Jazz',
        9 => 'Metal',
        10 => 'New Age',
        11 => 'Oldies',
        12 => 'Other',
        13 => 'Pop',
        14 => 'R&B',
        15 => 'Rap',
        16 => 'Reggae',
        17 => 'Rock',
        18 => 'Techno',
        19 => 'Industrial',
        20 => 'Alternative',
        21 => 'Ska',
        22 => 'Death Metal',
        23 => 'Pranks',
        24 => 'Soundtrack',
        25 => 'Euro-Techno',
        26 => 'Ambient',
        27 => 'Trip-Hop',
        28 => 'Vocal',
        29 => 'Jazz+Funk',
        30 => 'Fusion',
        31 => 'Trance',
        32 => 'Classical',
        33 => 'Instrumental',
        34 => 'Acid',
        35 => 'House',
        36 => 'Game',
        37 => 'Sound Clip',
        38 => 'Gospel',
        39 => 'Noise',
        40 => 'Alternative Rock',
        41 => 'Bass',
        42 => 'Soul',
        43 => 'Punk',
        44 => 'Space',
        45 => 'Meditative',
        46 => 'Instrumental Pop',
        47 => 'Instrumental Rock',
        48 => 'Ethnic',
        49 => 'Gothic',
        50 => 'Darkwave',
        51 => 'Techno-Industrial',
        52 => 'Electronic',
        53 => 'Pop-Folk',
        54 => 'Eurodance',
        55 => 'Dream',
        56 => 'Southern Rock',
        57 => 'Comedy',
        58 => 'Cult',
        59 => 'Gangsta',
        60 => 'Top 40',
        61 => 'Christian Rap',
        62 => 'Pop/Funk',
        63 => 'Jungle',
        64 => 'Native US',
        65 => 'Cabaret',
        66 => 'New Wave',
        67 => 'Psychadelic',
        68 => 'Rave',
        69 => 'Showtunes',
        70 => 'Trailer',
        71 => 'Lo-Fi',
        72 => 'Tribal',
        73 => 'Acid Punk',
        74 => 'Acid Jazz',
        75 => 'Polka',
        76 => 'Retro',
        77 => 'Musical',
        78 => 'Rock & Roll',
        79 => 'Hard Rock',
        80 => 'Folk',
        81 => 'Folk-Rock',
        82 => 'National Folk',
        83 => 'Swing',
        84 => 'Fast Fusion',
        85 => 'Bebob',
        86 => 'Latin',
        87 => 'Revival',
        88 => 'Celtic',
        89 => 'Bluegrass',
        90 => 'Avantgarde',
        91 => 'Gothic Rock',
        92 => 'Progressive Rock',
        93 => 'Psychedelic Rock',
        94 => 'Symphonic Rock',
        95 => 'Slow Rock',
        96 => 'Big Band',
        97 => 'Chorus',
        98 => 'Easy Listening',
        99 => 'Acoustic',
        100 => 'Humour',
        101 => 'Speech',
        102 => 'Chanson',
        103 => 'Opera',
        104 => 'Chamber Music',
        105 => 'Sonata',
        106 => 'Symphony',
        107 => 'Booty Bass',
        108 => 'Primus',
        109 => 'Porn Groove',
        110 => 'Satire',
        111 => 'Slow Jam',
        112 => 'Club',
        113 => 'Tango',
        114 => 'Samba',
        115 => 'Folklore',
        116 => 'Ballad',
        117 => 'Power Ballad',
        118 => 'Rhytmic Soul',
        119 => 'Freestyle',
        120 => 'Duet',
        121 => 'Punk Rock',
        122 => 'Drum Solo',
        123 => 'Acapella',
        124 => 'Euro-House',
        125 => 'Dance Hall',
        126 => 'Goa',
        127 => 'Drum & Bass',
        128 => 'Club-House',
        129 => 'Hardcore',
        130 => 'Terror',
        131 => 'Indie',
        132 => 'BritPop',
        133 => 'Negerpunk',
        134 => 'Polsk Punk',
        135 => 'Beat',
        136 => 'Christian Gangsta Rap',
        137 => 'Heavy Metal',
        138 => 'Black Metal',
        139 => 'Crossover',
        140 => 'Contemporary Christian',
        141 => 'Christian Rock',
        142 => 'Merengue',
        143 => 'Salsa',
        144 => 'Trash Metal',
        145 => 'Anime',
        146 => 'Jpop',
        147 => 'Synthpop',
    ];
}

function deldir($dir)
{
    $current_dir = opendir($dir);

    while ($entryname = readdir($current_dir)) {
        if (is_dir("$dir/$entryname") and ('.' != $entryname and '..' != $entryname)) {
            deldir("${dir}/${entryname}");
        } elseif ('.' != $entryname and '..' != $entryname) {
            unlink("${dir}/${entryname}");
        }
    }

    closedir($current_dir);

    rmdir(${dir});
}

// This fucntion reads and finds any excluded content
function readExcludeFile($file)
{
    if (is_file($file)) {
        // Ok, there is a file so let's read it, ok?

        $handle = fopen($file, 'rb');

        $contents = fread($handle, filesize($file));

        fclose($handle);

        // Now let's build an array out of the file

        $excludeArray = explode("\n", $contents);

        return $excludeArray;
    }
}

// This function displays links for all the missing album art
function searchForAlbumArt()
{
    global $web_root, $root_dir, $media_dir, $this_page, $ext_graphic, $this_site, $module_name, $cms_mode, $url_seperator;

    // First let's see if the cache has been created or not

    if (!isset($_SESSION['album_list'])) {
        createFileCaches(true);
    }

    // First let's search through using the album session variable

    $searchArray = explode("\n", urldecode($_SESSION['album_list']));

    for ($ctr = 0, $ctrMax = count($searchArray); $ctr < $ctrMax; $ctr++) {
        $found = 'no';

        $pathArray = explode('--', $searchArray[$ctr]);

        // Let's make sure there is something to read

        if ('' == $pathArray[0]) {
            // Ok, we're done let's return to the tools and let them know

            header('Location: ' . $this_page . $url_seperator . 'ptype=tools');

            exit();
        }

        // Now let's search for the data

        $retArray = readDirInfo($web_root . $root_dir . $media_dir . '/' . $pathArray[1] . '/' . $pathArray[2] . '/' . $pathArray[0], 'file');

        for ($i = 0, $iMax = count($retArray); $i < $iMax; $i++) {
            if (preg_match("/\.($ext_graphic)$/i", $retArray[$i])) {
                $found = 'yes';
            }
        }

        // Now let's see if that file exists and if not we'll show a link to the search

        if ('no' == $found) {
            // Now let's send them to this one

            header('Location: ' . $this_page . $url_seperator . 'ptype=artsearch&info=' . urlencode($pathArray[1]) . '|||' . urlencode($pathArray[2]) . '|||' . urlencode($pathArray[0]) . '&return=tool');

            exit();
        }
    }
}

// This function tries to get 1 album cover automatically for the user
function autoSearchArt($info)
{
    global $web_root, $root_dir, $media_dir, $jinzora_temp_dir;

    // Ok, let's search for the 1 item

    // Let's setup our contents variable for later

    $contents = '';

    // Now let's parse out the artist and album info

    $infoArray = explode('|||', urldecode($info));

    // Now let's read the last two entries, that will be the arist and album name

    // We'll also wrap them in quotes for our search later

    $albctr = count($infoArray) - 1;

    $artctr = count($infoArray) - 2;

    // Let's directly open Google to get the data

    $fp = fsockopen('images.google.com', 80, $errno, $errstr, 5);

    // Now let's make sure it opened it ok

    if ($fp) {
        $path = '/images?as_q=' . urlencode($infoArray[$artctr] . '" "' . $infoArray[$albctr] . '"') . '&svnum=10&hl=en&ie=UTF-8&oe=UTF-8&btnG=Google+Search&as_epq=&as_oq=&as_eq=&imgsz=&as_filetype=jpg&imgc=&as_sitesearch=&safe=off';

        fwrite($fp, "GET $path HTTP/1.1\n");

        fwrite($fp, "Content-type: application/x-www-form-urlencoded\n");

        fwrite($fp, "Connection: close\n\n");

        while (!feof($fp)) {
            $contents .= fgets($fp, 128);
        }

        fclose($fp);

        // Ok, now that we have all the contents we need to parse it out

        $contents = mb_substr($contents, mb_strpos($contents, ' search button'), 1000000);

        $contents = mb_substr($contents, mb_strpos($contents, '<img '), 100000);

        // Let's fix the path to the images

        $contents = str_replace('src=/image', 'src=http://images.google.com/image', $contents);

        // Let's go into a loop until there are no more images left

        $imgTest = '1';

        $ctr = 0;

        while (0 != $imgTest) {
            // Let's strip out the image tag

            $fulImgTag = mb_substr($contents, 0, mb_strpos($contents, '</a>'));

            $fulImgTag = mb_substr($fulImgTag, 9, 100000);

            $image[$ctr] = mb_substr($fulImgTag, 0, mb_strpos($fulImgTag, ' '));

            $contents = mb_substr($contents, 10, 100000);

            $contents = mb_substr($contents, mb_strpos($contents, '<img src'), 100000);

            $imgTest = mb_strpos($contents, 'img');

            $ctr += 1;

            if (13 == $ctr) {
                $imgTest = 0;
            }
        }

        // Ok let's loop through the images we found

        $ctr = 0;

        $ctr2 = 2;

        $artFound = false;

        while (count($image) > $ctr) {
            // Let's make sure it wasn't one of the default google images and that it really is a .jpg or .jpeg file

            if (0 == mb_strpos($image[$ctr], 'res') and 0 != mb_strpos($image[$ctr], '.jp') and false === $artFound) {
                $img_src = str_replace('http://images.google.com/images?', '', $image[$ctr]);

                $artFound = true;
            }

            // Let's increment our counter

            $ctr += 1;
        }
    }

    // Now let's make sure we got something back, and if not we'll create a default one

    if (true != $artFound) {
        // Ok, let's give them the default image

        $imgNameArray = explode('|||', $info);

        $imgName = $imgNameArray[count($imgNameArray) - 1];

        // Now let's get the title

        $title = urldecode(str_replace('|||', "\n\n", $info));

        // Now let's create the default image

        createBlankImage($web_root . $root_dir . '/style/images/default.jpg', 5, $title, '255 255 255', '0 0 0', 0, 200, 'center', 'center');

        // Now let's copy the new image into place

        copy($web_root . $root_dir . $jinzora_temp_dir . '/temp-image.jpg', $web_root . $root_dir . $media_dir . '/' . urldecode($_GET['genre']) . '/' . urldecode(str_replace('|||', '/', $info)) . '/' . $imgName . '.jpg');

        // Now let's delete the image we created

        unlink($web_root . $root_dir . $jinzora_temp_dir . '/temp-image.jpg');
    } else {
        // Now let's save the one we got back

        $imgNameArray = explode('|||', $info);

        $imgName = $imgNameArray[count($imgNameArray) - 1];

        $fileName = $web_root . $root_dir . $media_dir . '/' . urldecode($_GET['genre']) . '/' . urldecode(str_replace('|||', '/', $info) . '/' . $imgName . '.jpg');

        // Now let's open Google and get the contents of the image

        $fp = fsockopen('images.google.com', 80, $errno, $errstr, 5);

        // Let's make sure we got something back

        if ($fp) {
            $path = '/images?' . $img_src;

            fwrite($fp, "GET $path HTTP/1.0\n");

            fwrite($fp, "Connection: close\n\n");

            // Let's clear out our variable

            $contents = '';

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

            // Now that we have the data, let's write it to the new file

            $handle = fopen($fileName, 'wb');

            fwrite($handle, $contents);

            fclose($handle);
        }
    }
}

// simple function that can help, if you want to know if a string could be UTF-8 or not
function seems_utf8($Str)
{
    for ($i = 0, $iMax = mb_strlen($Str); $i < $iMax; $i++) {
        if (ord($Str[$i]) < 0x80) {
            continue;
        } # 0bbbbbbb

        elseif (0xC0 == (ord($Str[$i]) & 0xE0)) {
            $n = 1;
        } # 110bbbbb

        elseif (0xE0 == (ord($Str[$i]) & 0xF0)) {
            $n = 2;
        } # 1110bbbb

        elseif (0xF0 == (ord($Str[$i]) & 0xF8)) {
            $n = 3;
        } # 11110bbb

        elseif (0xF8 == (ord($Str[$i]) & 0xFC)) {
            $n = 4;
        } # 111110bb

        elseif (0xFC == (ord($Str[$i]) & 0xFE)) {
            $n = 5;
        } # 1111110b

        else {
            return false;
        } # Does not match any model
        for ($j = 0; $j < $n; $j++) { # n bytes matching 10bbbbbb follow ?
            if ((++$i == mb_strlen($Str)) || (0x80 != (ord($Str[$i]) & 0xC0))) {
                return false;
            }
        }
    }

    return true;
}

?>

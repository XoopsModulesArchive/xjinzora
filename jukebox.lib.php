<?php
/**
 * - JINZORA | Web-based Media Streamer -
 *
 * Jinzora is a Web-based media streamer, primarily desgined to stream MP3s
 * (but can be used for any media file that can stream from HTTP).
 * Jinzora can be integrated into a CMS site, run as a standalone application,
 * or integrated into any PHP website.  It is released under the GNU GPL.
 *
 * - Ressources -
 * - Jinzora Author: Ross Carlson <ross@jinzora.org>
 * - Web: http://www.jinzora.org
 * - Documentation: http://www.jinzora.org/docs
 * - Support: http://www.jinzora.org/forum
 * - Downloads: http://www.jinzora.org/downloads
 * - License: GNU GPL <http://www.gnu.org/copyleft/gpl.html>
 *
 * - Contributors -
 * Please see http://www.jinzora.org/modules.php?op=modload&name=jz_whois&file=index
 *
 * - Code Purpose -
 * This page handles the jukebox features and controls
 * - Both Winamp and XMMS (noxmms)
 *
 * - Notes -
 * - Virtually everything is done and working for both Winamp and XMMS.  I would like to change
 * - the refresh time from seconds to minutes:seconds format so it's prettier
 *
 * @since  02/25/04
 * @author Ross Carlson <ross@jinzora.org>
 */

// Now let's see if they wanted the jukebox bar
if (isset($_GET['jbar'])) {
    // Ok, now we'll need the settings file

    require_once __DIR__ . '/settings.php';

    require_once __DIR__ . '/system.php';

    require_once __DIR__ . '/general.php';

    // Now let's start the session

    session_name('jinzora-session');

    session_start();

    echo $css;

    echo '<body bottommargin="0" topmargin="0" leftmargin="0" rightmargin="0">';
}

if (isset($_GET['clearpl'])) {
    unset($_SESSION['jukebox-filenames']);

    unset($_SESSION['jukebox-list']);
}

// Now let's see if they pressed a button for XMMS
if (isset($_POST['xmmscommand'])) {
    // Now let's pass that command

    if ('' != $_POST['xmmsvol']) {
        controlXMMS($_POST['xmmsvol']);
    } else {
        switch ($_POST['xmmscommand']) {
            case 'randomize':
                randomizeJukebox();
                break;
            default:
                controlXMMS($_POST['xmmscommand']);
                break;
        }
    }

    // Now let's set the playback type

    if ('stream' == $_POST['pbType']) {
        $_SESSION['pbtype'] = 'stream';

        $handle = fopen($web_root . $root_dir . '/temp/pbtype.status', 'wb');

        fwrite($handle, 'stream');

        fclose($handle);
    } else {
        $_SESSION['pbtype'] = 'jukebox';

        $handle = fopen($web_root . $root_dir . '/temp/pbtype.status', 'wb');

        fwrite($handle, 'jukebox');

        fclose($handle);
    }

    // Now let's set the playback type

    // Let's write it to a session variable and to disk

    if (isset($_POST['pbWhere'])) {
        if ('beginning' == $_POST['pbWhere']) {
            $handle = fopen($web_root . $root_dir . '/temp/barge.status', 'wb');

            fwrite($handle, 'beginning');

            fclose($handle);

            $_SESSION['pbWhere'] = 'beginning';
        } else {
            $handle = fopen($web_root . $root_dir . '/temp/barge.status', 'wb');

            fwrite($handle, 'end');

            fclose($handle);

            $_SESSION['pbWhere'] = 'end';
        }
    }
}

// Now let's see if they wanted the jukebox bar
if (isset($_GET['jbar'])) {
    displayJukeboxBar($_GET['jbar']);
}

// Let's see if they accessed this directly
// Added 4.10.04 By Ross Carlson
if (isset($_GET['jb'])) {
    // Ok, now we'll need the settings file

    require_once __DIR__ . '/settings.php';

    // Now let's preform the command based on what they wanted to do

    switch ($jukebox) {
        case 'xmms':
            if ('randomize' == $_GET['jb']) {
                randomizeJukebox();
            } else {
                controlXMMS($_GET['jb']);
            }
            break;
    }

    // Now let's go back to where we were

    echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=' . base64_decode($_GET['return'], true) . '">';

    exit();
}

// This function dipslays the Jukebox bar so it can be put into an iFrame
// Added 4.18.04 by Ross Carlson
function displayJukeboxBar($jukebox)
{
    ?>
    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="" style="padding:10px; margin-top:0px;">
        <tr class="jz_header_table_tr">
            <td width="100" class="jz_header_table_td" valign="top">
                <nobr>
                    <?php
                    if ('xmms' == $jukebox) {
                        displayXMMS();
                    }

    if ('winamp' == $jukebox) {
        displayWinamp();
    } ?>
                </nobr>
            </td>
            <td width="10" class="jz_header_table_td" valign="top">
                <nobr>&nbsp;&nbsp;&nbsp;</nobr>
            </td>
            <td width="100" class="jz_header_table_td" valign="top">
                <nobr>
                    <?php
                    if ('xmms' == $jukebox) {
                        displayCurrentTrackArt();
                    }

    if ('winamp' == $jukebox) {
        displayWinampCurrentTrackArt();
    } ?>
                </nobr>
            </td>
            <td width="10" class="jz_header_table_td" valign="top">
                <nobr>&nbsp;&nbsp;&nbsp;</nobr>
            </td>
            <td width="100" class="jz_header_table_td" valign="top">
                <nobr>
                    <?php
                    if ('xmms' == $jukebox) {
                        displayCurrentTrack();
                    }

    if ('winamp' == $jukebox) {
        displayCurrentWinampTrack();
    } ?>
                </nobr>
            </td>

            <td width="20" class="jz_header_table_td" valign="top">
                <nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr>
            </td>
            <td width="100" class="jz_header_table_td" valign="top">
                <nobr>
                    <?php
                    if ('xmms' == $jukebox) {
                        displayFullList();
                    }

    if ('winamp' == $jukebox) {
        //displayWinampFullList();
    } ?>
                </nobr>
            </td>
            <td width="100%" class="jz_header_table_td" valign="top">&nbsp;</td>
        </tr>
    </table>
    <?php
}

// This function dipslays the ENTIRE jukebox playlist
// Added 3.10.04 by Ross Carlson
function displayFullList($slim = false)
{
    global $num_upcoming, $word_complete_playlist;

    // Now let's get the full list, only if we need to

    if (!isset($_SESSION['jukebox-list'])) {
        $_SESSION['jukebox-list'] = controlXMMS('list');
    } else {
        if (count($_SESSION['jukebox-list']) < 2) {
            $_SESSION['jukebox-list'] = controlXMMS('list');
        }
    }

    $status = $_SESSION['jukebox-list'];

    // Now let's make sure there was something to list

    if ('1' != count($status)) {
        // Now let's setup our form

        $form_action = $_SERVER['REQUEST_URI'];

        // Now let's see if the "favtrack" is listed, and if so kill it!

        if (mb_stristr($_SERVER['REQUEST_URI'], 'favtrack')) {
            $form_action = str_replace('favtrack', 'nofav', $form_action);
        }

        // Now let's see if the "favtrack" is listed, and if so kill it!

        if (mb_stristr($_SERVER['REQUEST_URI'], 'favtrack')) {
            $form_action = str_replace('favtrack', 'nofav', $form_action);
        }

        if (false === $slim) {
            echo '<form action="' . $form_action . '" name="xmmsControlForm2" method="post">';
        }

        echo '<input type="hidden" name="xmmscommand" value="">';

        // Now let's set the width based on if this is slim or not

        if (false === $slim) {
            echo '<strong>' . $word_complete_playlist . '</strong> (' . (count($status) - 1) . ')<br>';

            $width = '200';
        } else {
            $width = '120';
        }

        echo '<select onChange="submit()" class="jz_select" size="' . $num_upcoming . '" name="xmmscommand" style="width: ' . $width . 'px">';

        for ($ctr = 0, $ctrMax = count($status); $ctr < $ctrMax; $ctr++) {
            if (!mb_stristr($status[$ctr], 'list is empty')) {
                // Now let's get the track number

                $track_num = trim(mb_substr($status[$ctr], 0, mb_strpos($status[$ctr], '.')));

                $track_name = trim(mb_substr($status[$ctr], mb_strpos($status[$ctr], '.') + 1, mb_strlen($status[$ctr])));

                // Now let's see if we are at the current track

                if ('*' == mb_substr($status[$ctr], 0, 1)) {
                    $track_num = trim(str_replace('*', '', $track_num));

                    echo '<option selected value="jump ' . $track_num . '">' . $track_name . '</option>';
                } else {
                    echo '<option value="jump ' . $track_num . '">' . $track_name . '</option>';
                }
            }
        }

        echo '</select>';

        echo '</form>';
    }
}

// This function controls XMMS using XMMS-Shell
function controlWinamp($command)
{
    global $path_to_xmms_shell, $web_root, $root_dir, $jinzora_temp_dir, $jukebox_pass, $jukebox_port;

    // Now let's send the command to httpQ

    $fp = fsockopen('localhost', $jukebox_port, $errno, $errstr, 5);

    // Now let's see if this is a 2 part command

    if (mb_stristr($command, '-')) {
        $commandArray = explode('-', $command);

        $command = $commandArray[0];

        $arg = $commandArray[1];
    }

    if ('playfile' == $command) {
        $path = '/' . $command . '?p=' . $jukebox_pass . '&a=' . str_replace('%2F', '/', str_replace('%3A', ':', rawurlencode($web_root . $root_dir . $jinzora_temp_dir))) . '/jinzora-jukbox.pls.m3u';
    } else {
        $path = '/' . $command . '?p=' . $jukebox_pass;
    }

    // Now let's see if we need to add an argument

    if (isset($arg)) {
        if ('setvolume' == $command) {
            $arg *= 2.5;
        }

        $path .= '&a=' . $arg;
    }

    // Now let's see if they were setting the volume

    if ('setvolume' == $command) {
        $_SESSION['volume'] = $commandArray[1];
    }

    fwrite($fp, "GET $path HTTP/1.1\r\nHost:localhost:" . $jukebox_port . "\r\n\r\n");

    fwrite($fp, "Content-type: application/x-www-form-urlencoded\n");

    fwrite($fp, "Connection: close\n\n");

    // Now let's read the data back

    while (!feof($fp)) {
        $results .= fgets($fp, 128);
    }

    fclose($fp);

    // Now let's clean up the results if we need to

    if (mb_stristr($results, 'text/html')) {
        $results = mb_substr($results, mb_strpos($results, 'text/html') + 9, mb_strlen($results));
    }

    return $results;
}

// This function will get the current play status
// Added 4.10.04 by Ross Carlson
function readJBStatus()
{
    global $web_root, $root_dir, $word_stopped;

    // Ok, let's write the status

    $filename = $web_root . $root_dir . '/temp/jukebox.status';

    if (!is_file($filename)) {
        $_SESSION['play_status'] = $word_stopped;

        return;
    }

    $handle = fopen($filename, 'rb');

    $status = fread($handle, filesize($filename));

    fclose($handle);

    $_SESSION['play_status'] = $status;

    return $status;
}

// This function will write the status of the jukebox to the disk
// So that it can be read from anywhere regardless of what client hits it
// Added 4.10.04 by Ross Carlson
function writeJBStatus($status)
{
    global $web_root, $root_dir;

    // Ok, let's write the status

    $filename = $web_root . $root_dir . '/temp/jukebox.status';

    // Now let's see if the file exists and if not create it

    if (!is_file($filename)) {
        touch($filename);
    }

    $handle = fopen($filename, 'wb');

    fwrite($handle, $status);

    fclose($handle);

    // Now let's write the session variable

    $_SESSION['play_status'] = $status;
}

// This function will write the volume state of the jukebox to the disk
// So that it can be read from anywhere regardless of what client hits it
// Added 4.10.04 by Ross Carlson
function writeJBVolume($volume)
{
    global $web_root, $root_dir;

    // Ok, let's write the status

    $filename = $web_root . $root_dir . '/temp/jukebox.volume';

    // Now let's see if the file exists and if not create it

    if (!is_file($filename)) {
        touch($filename);
    }

    $handle = fopen($filename, 'wb');

    fwrite($handle, $volume);

    fclose($handle);

    // Now let's write the session variable

    $_SESSION['volume'] = $status;
}

// This function controls XMMS using XMMS-Shell
function controlXMMS($command)
{
    global $path_to_xmms_shell;

    exec($path_to_xmms_shell . '/xmms-shell -e "' . mb_strtolower($command) . '"', $output, $returnvalue);

    // Now let's make sure we got output from xmms

    if ('' == $output[0]) {
        //die("Sorry there was an error communicating with XMMS<br>Since you are in Jukebox Mode this is a fatal error");
    }

    // Now let's set the playback status

    switch (mb_strtolower($command)) {
        case 'play':
            writeJBStatus('playing');
            break;
        case 'pause':
            if ('paused' == readJBStatus()) {
                writeJBStatus('playing');
            } else {
                writeJBStatus('paused');
            }
            break;
        case 'clear':
            writeJBStatus('stopped');
            unset($_SESSION['jukebox-filenames']);
            unset($_SESSION['jukebox-list']);
            break;
        case 'stop':
            writeJBStatus('stopped');
            unset($_SESSION['jukebox-filenames']);
            unset($_SESSION['jukebox-list']);
            break;
    }

    // Now let's set the volume

    if (mb_stristr(mb_strtolower($command), 'volume')) {
        writeJBVolume(str_replace('volume ', '', $command));
    }

    return $output;
}

// This function displays the play controlls for Winamp using the httpQ plugin
function displayWinamp()
{
    global $word_play, $word_jukebox_controls, $word_pause, $word_stop, $word_next, $word_previous, $word_volume, $word_mute, $word_up, $word_down, $jukebox, $word_nowplaying, $image_dir, $auto_refresh, $word_pause, $word_refresh_in, $jb_volumes;

    // Ok, let's show them all the winamp buttons and stuff

    $form_action = $_SERVER['REQUEST_URI'];

    // Now let's see if the "favtrack" is listed, and if so kill it!

    if (mb_stristr($_SERVER['REQUEST_URI'], 'favtrack')) {
        $form_action = str_replace('favtrack', 'nofav', $form_action);
    }

    echo '<form action="' . $form_action . '" name="winampControlForm" method="post">';

    echo '<input type="hidden" name="winampcommand" value="">';

    echo '<input type="image" src="' . $image_dir . '/play.gif" onClick=\'winampControlForm.winampcommand.value="play";winampControlForm.submit()\';\" name="command" value="' . $word_play . '"> ';

    echo '<input type="image" src="' . $image_dir . '/stop.gif" onClick=\'winampControlForm.winampcommand.value="stop";winampControlForm.submit()\';\" name="command" value="' . $word_pause . '"> ';

    echo '<input type="image" src="' . $image_dir . '/pause.gif" onClick=\'winampControlForm.winampcommand.value="pause";winampControlForm.submit()\';\" name="command" value="' . $word_pause . '"><br>';

    echo '<input type="image" src="' . $image_dir . '/previous.gif" onClick=\'winampControlForm.winampcommand.value="prev";winampControlForm.submit()\';\" name="command" value="' . $word_previous . '"> ';

    echo '<input type="image" src="' . $image_dir . '/next.gif" onClick=\'winampControlForm.winampcommand.value="next";winampControlForm.submit()\';\" name="command" value="' . $word_next . '"> ';

    echo '<input type="image" src="' . $image_dir . '/clear.gif" onClick=\'winampControlForm.winampcommand.value="delete";winampControlForm.submit()\';\" name="command" value="' . $word_next . '"><br>';

    echo '<select name="winampvol" onChange="submit()" class="jz_select" style="width: 68px">' . '<option value="">Volume</option>';

    $volArray = explode('|', $jb_volumes);

    for ($ctr = 0, $ctrMax = count($volArray); $ctr < $ctrMax; $ctr++) {
        echo '<option value="setvolume-' . $volArray[$ctr] . '">' . $volArray[$ctr] . '%</option>';
    }

    echo '</select>';

    echo '</form>';

    if (isset($_SESSION['volume'])) {
        echo ' (' . $_SESSION['volume'] . ')';
    }

    // Now let's show them how the change to stream

    displayPlayselector();

    // Now let's do our key mappings for the jukebox

    $play_key = '112';

    $stop_key = '115';

    $next_key = '46';

    $previous_key = '44';

    $muke_key = '109';

    $vol_0 = '48';

    $vol_10 = '49';

    $vol_20 = '50';

    $vol_30 = '51';

    $vol_40 = '52';

    $vol_50 = '53';

    $vol_60 = '54';

    $vol_70 = '55';

    $vol_80 = '56';

    $vol_90 = '57';

    $vol_100 = '58';

    // Now let's see if they have a custom key mapping file

    // And if so we'll use that as an override

    if (is_file($web_root . $root_dir . '/custom-keys.php')) {
        require_once $web_root . $root_dir . '/custom-keys.php';
    }

    // Let's make sure they're not on the login screen

    // If they are let's disable the hotkeys

    if (!mb_stristr($_SERVER['REQUEST_URI'], 'ptype=login')) {
        ?>
        <SCRIPT LANGUAGE="JavaScript1.2"><!--
            if (window.Event) {
                window.captureEvents(Event.KEYPRESS)
            }
            document.onkeypress = keyPressed;

            function keyPressed(e) {
                var n;
                var f = document.winampControlForm;

                (window.Event) ? n = e.which : n = event.keyCode
                if (n == <?php echo $play_key; ?>) {
                    f.winampcommand.value = "play";
                    f.submit();
                }
                if (n == <?php echo $stop_key; ?>) {
                    f.winampcommand.value = "stop";
                    f.submit();
                }
                if (n == <?php echo $next_key; ?>) {
                    f.winampcommand.value = "next";
                    f.submit();
                }
                if (n == <?php echo $previous_key; ?>) {
                    f.winampcommand.value = "prev";
                    f.submit();
                }
                if (n == <?php echo $muke_key; ?>) {
                    f.winampcommand.value = "volume 0";
                    f.submit();
                }
                if (n == <?php echo $vol_0; ?>) {
                    f.winampcommand.value = "setvolume-0";
                    f.submit();
                }
                if (n == <?php echo $vol_10; ?>) {
                    f.winampcommand.value = "setvolume-10";
                    f.submit();
                }
                if (n == <?php echo $vol_20; ?>) {
                    f.winampcommand.value = "setvolume-20";
                    f.submit();
                }
                if (n == <?php echo $vol_30; ?>) {
                    f.winampcommand.value = "setvolume-30";
                    f.submit();
                }
                if (n == <?php echo $vol_40; ?>) {
                    f.winampcommand.value = "setvolume-40";
                    f.submit();
                }
                if (n == <?php echo $vol_50; ?>) {
                    f.winampcommand.value = "setvolume-50";
                    f.submit();
                }
                if (n == <?php echo $vol_60; ?>) {
                    f.winampcommand.value = "setvolume-60";
                    f.submit();
                }
                if (n == <?php echo $vol_70; ?>) {
                    f.winampcommand.value = "setvolume-70";
                    f.submit();
                }
                if (n == <?php echo $vol_80; ?>) {
                    f.winampcommand.value = "setvolume-80";
                    f.submit();
                }
                if (n == <?php echo $vol_90; ?>) {
                    f.winampcommand.value = "setvolume-90";
                    f.submit();
                }
                if (n == <?php echo $vol_100; ?>) {
                    f.winampcommand.value = "setvolume-100";
                    f.submit();
                }
            }

            //--></SCRIPT>
        <?php
    }

    // Now let's set the page refresh time IF we are playing

    while ('' == $status) {
        $status = controlWinamp('isplaying');
    }

    if ('1' == $status) {
        // First let's figure out how much of the track is left

        $trk_length = '';

        while ('' == $trk_length) {
            $trk_length = controlWinamp('getoutputtime-1');
        }

        $cur_pos = '';

        while ('' == $cur_pos) {
            $cur_pos = controlWinamp('getoutputtime-0');
        }

        $cur_pos = round(($cur_pos / 1000));

        $auto_refresh = $trk_length - $cur_pos;

        // Now let's show them the count down to refresh ?>
        <SCRIPT LANGUAGE=JAVASCRIPT TYPE="TEXT/JAVASCRIPT"><!--
            var interval = "";
            var i = <?php echo $auto_refresh; ?>;

            function startInterval() {
                interval = window.setInterval("tTimer()", 1000);
            }

            function stopInterval() {
                window.clearInterval(interval);
                interval = "";
            }

            function tTimer() {
                timerCell = document.getElementById("time");
                if (i > -1) {
                    timerCell.innerHTML = i--;
                }
            }

            -->
        </SCRIPT>
        <?php echo '<br>' . $word_refresh_in; ?> <span id="time"></span>
        <script>
            startInterval();
        </script>
        <?php

        echo '<meta http-equiv="refresh" content="' . $auto_refresh . ';">';
    }
}

// This function displays the selector box for where the media should play
// Added by Ross Carlson - 2/4/2004
function displayPlayselector()
{
    global $word_playback_to, $word_jukebox, $word_stream;

    // Let's show them the box so they can choose where the playlist should go...

    echo '<br>' . $word_playback_to . '<br>' . '<select onChange="submit()" name="pbType" class="jz_select" style="width: 68px">';

    // Now let's figure out what is set

    if ('stream' == $_SESSION['pbtype']) {
        echo '<option value="stream">' . $word_stream . '</option>' . '<option value="jukebox">' . $word_jukebox . '</option>';
    } else {
        echo '<option value="jukebox">' . $word_jukebox . '</option>' . '<option value="stream">' . $word_stream . '</option>';
    }

    echo '</select>';
}

// This function will randomize the current playlist and jump to the top
// Added 3.11.04 by Ross Carlson
function randomizeJukebox()
{
    global $jukebox, $web_root, $root_dir;

    // Ok, first let's get the complete list

    switch ($jukebox) {
        case 'xmms':
            // Ok, let's read the entire list into an array
            $listArray = controlXMMS('list filenames');

            // Now let's fix the filenames and create a new array
            for ($ctr = 0, $ctrMax = count($listArray); $ctr < $ctrMax; $ctr++) {
                $dataArray[] = mb_substr($listArray[$ctr], mb_strpos($listArray[$ctr], '/'), mb_strlen($listArray[$ctr]));
            }

            // Ok, now let's randomize it
            shuffle($dataArray);

            // Now let's make our list
            $contents = '';
            for ($ctr = 0, $ctrMax = count($dataArray); $ctr < $ctrMax; $ctr++) {
                $contents .= $dataArray[$ctr] . "\n";
            }

            // Now let's write it back out
            $filename = $web_root . $root_dir . '/temp/jinzora-jukbox.pls.m3u';
            $handle = fopen($filename, 'wb');
            fwrite($handle, $contents);
            fclose($handle);

            // Now let's load that up
            controlXMMS('clear');
            controlXMMS('load ' . $filename);
            controlXMMS('play');
            writeJBStatus('playing');
            break;
    }
}

// This function displays the play controlls for XMMS
function displayXMMS()
{
    global $word_play, $word_jukebox_controls, $word_pause, $word_stop, $word_next, $word_previous, $word_volume, $word_mute, $word_up, $word_down, $jukebox, $word_nowplaying, $image_dir, $auto_refresh, $word_play, $word_refresh_in, $word_clear, $word_play_random, $img_random_play, $img_fav_track, $jb_volumes;

    // Ok, let's show them all the XMMS buttons and stuff

    $form_action = $_SERVER['REQUEST_URI'];

    // Now let's see if the "favtrack" is listed, and if so kill it!

    if (mb_stristr($_SERVER['REQUEST_URI'], 'favtrack')) {
        $form_action = str_replace('favtrack', 'nofav', $form_action);
    }

    // Now let's get the status

    readJBStatus();

    // Let's make sure they aren't a viewonly user

    if ('viewonly' != $_SESSION['jz_access_level'] and 'lofi' != $_SESSION['jz_access_level']) {
        echo '<form action="' . $form_action . '" name="xmmsControlForm" method="post">';

        echo '<input type="hidden" name="xmmscommand" value="">';

        echo '<input title="' . $word_play . '" type="image" src="' . $image_dir . '/play.gif" onClick=\'xmmsControlForm.xmmscommand.value="play";xmmsControlForm.submit()\';\" name="command" value="' . $word_play . '"> ';

        echo '<input title="' . $word_pause . '" type="image" src="' . $image_dir . '/pause.gif" onClick=\'xmmsControlForm.xmmscommand.value="pause";xmmsControlForm.submit()\';\" name="command" value="' . $word_pause . '"> ';

        echo '<input title="' . $word_stop . '" type="image" src="' . $image_dir . '/stop.gif" onClick=\'xmmsControlForm.xmmscommand.value="stop";xmmsControlForm.submit()\';\" name="command" value="' . $word_stop . '"> ';

        echo '<input title="' . $word_play_random . '" type="image" src="' . $image_dir . '/random.gif" onClick=\'xmmsControlForm.xmmscommand.value="randomize";xmmsControlForm.submit()\';\" name="command" value="' . $word_play_random . '"><br>';

        echo '<input title="' . $word_previous . '" type="image" src="' . $image_dir . '/previous.gif" onClick=\'xmmsControlForm.xmmscommand.value="previous";xmmsControlForm.submit()\';\" name="command" value="' . $word_previous . '"> ';

        echo '<input title="' . $word_next . '" type="image" src="' . $image_dir . '/next.gif" onClick=\'xmmsControlForm.xmmscommand.value="next";xmmsControlForm.submit()\';\" name="command" value="' . $word_next . '"> ';

        echo '<input type="image" src="' . $image_dir . '/clear.gif" onClick=\'xmmsControlForm.xmmscommand.value="clear";xmmsControlForm.submit()\';\" name="command" value="' . $word_clear . '"> ';

        $trackNum = controlXMMS('currenttrack');

        $trackNum = trim(str_replace('Current song: ', '', trim(mb_substr($trackNum[0], 0, mb_strpos($trackNum[0], '.'))))) - 1;

        $album_image = '';

        $track_path = mb_substr($_SESSION['jukebox-filenames'][$trackNum], mb_strpos($_SESSION['jukebox-filenames'][$trackNum], '.') + 2, mb_strlen($_SESSION['jukebox-filenames'][$trackNum]));

        $_SESSION['favTrack'] = $track_path;

        echo '<a href="' . $_SERVER['REQUEST_URI'] . '">' . $img_fav_track . '</a>&nbsp;&nbsp;&nbsp;<br>';

        echo '<select name="xmmsvol" onChange="submit()" class="jz_select" style="width: 68px">' . '<option value="">Volume</option>';

        $volArray = explode('|', $jb_volumes);

        for ($ctr = 0, $ctrMax = count($volArray); $ctr < $ctrMax; $ctr++) {
            echo '<option value="volume ' . $volArray[$ctr] . '">' . $volArray[$ctr] . '%</option>';
        }

        echo '</select>';

        if (isset($_SESSION['volume'])) {
            echo ' (' . $_SESSION['volume'] . ')';
        }

        // Now let's show them the selector for where the media is played

        displayPlayselector();

        // Now let's let them choose where this goes, the end or beginning

        displayBarge();

        //Now let's close our form

        echo '</form><br>';

        // Now let's do our key mappings for the jukebox

        $play_key = '112';

        $stop_key = '115';

        $next_key = '46';

        $previous_key = '44';

        $muke_key = '109';

        $vol_0 = '48';

        $vol_10 = '49';

        $vol_20 = '50';

        $vol_30 = '51';

        $vol_40 = '52';

        $vol_50 = '53';

        $vol_60 = '54';

        $vol_70 = '55';

        $vol_80 = '56';

        $vol_90 = '57';

        $vol_100 = '58';

        // Now let's see if they have a custom key mapping file

        // And if so we'll use that as an override

        if (is_file($web_root . $root_dir . '/custom-keys.php')) {
            require_once $web_root . $root_dir . '/custom-keys.php';
        }

        // Let's make sure they're not on the login screen

        // If they are let's disable the hotkeys

        if (!mb_stristr($_SERVER['REQUEST_URI'], 'ptype=login')) {
            ?>
            <SCRIPT LANGUAGE="JavaScript1.2"><!--
                if (window.Event) {
                    window.captureEvents(Event.KEYPRESS)
                }
                document.onkeypress = keyPressed;

                function keyPressed(e) {
                    var n;
                    var f = document.xmmsControlForm;

                    (window.Event) ? n = e.which : n = event.keyCode
                    if (n == <?php echo $play_key; ?>) {
                        f.xmmscommand.value = "play";
                        f.submit();
                    }
                    if (n == <?php echo $stop_key; ?>) {
                        f.xmmscommand.value = "stop";
                        f.submit();
                    }
                    if (n == <?php echo $next_key; ?>) {
                        f.xmmscommand.value = "next";
                        f.submit();
                    }
                    if (n == <?php echo $previous_key; ?>) {
                        f.xmmscommand.value = "previous";
                        f.submit();
                    }
                    if (n == <?php echo $muke_key; ?>) {
                        f.xmmscommand.value = "volume 0";
                        f.submit();
                    }
                    if (n == <?php echo $vol_0; ?>) {
                        f.xmmscommand.value = "volume 0";
                        f.submit();
                    }
                    if (n == <?php echo $vol_10; ?>) {
                        f.xmmscommand.value = "volume 10";
                        f.submit();
                    }
                    if (n == <?php echo $vol_20; ?>) {
                        f.xmmscommand.value = "volume 20";
                        f.submit();
                    }
                    if (n == <?php echo $vol_30; ?>) {
                        f.xmmscommand.value = "volume 30";
                        f.submit();
                    }
                    if (n == <?php echo $vol_40; ?>) {
                        f.xmmscommand.value = "volume 40";
                        f.submit();
                    }
                    if (n == <?php echo $vol_50; ?>) {
                        f.xmmscommand.value = "volume 50";
                        f.submit();
                    }
                    if (n == <?php echo $vol_60; ?>) {
                        f.xmmscommand.value = "volume 60";
                        f.submit();
                    }
                    if (n == <?php echo $vol_70; ?>) {
                        f.xmmscommand.value = "volume 70";
                        f.submit();
                    }
                    if (n == <?php echo $vol_80; ?>) {
                        f.xmmscommand.value = "volume 80";
                        f.submit();
                    }
                    if (n == <?php echo $vol_90; ?>) {
                        f.xmmscommand.value = "volume 90";
                        f.submit();
                    }
                    if (n == <?php echo $vol_100; ?>) {
                        f.xmmscommand.value = "volume 100";
                        f.submit();
                    }
                }

                //--></SCRIPT>
            <?php
        }
    }

    // Now let's set the page refresh time IF we are playing

    if (isset($_SESSION['play_status'])) {
        if ('playing' == $_SESSION['play_status']) {
            echo '<meta http-equiv="refresh" content="' . $auto_refresh . ';">';
        }
    }

    // Now let's show them the count down to refresh

    $doTimer = 'true';

    if (!isset($_SESSION['play_status'])) {
        $doTimer = 'false';
    } else {
        if ('playing' != $_SESSION['play_status']) {
            $doTimer = 'false';
        }
    }

    if ('true' == $doTimer) {
        ?>
        <SCRIPT LANGUAGE=JAVASCRIPT TYPE="TEXT/JAVASCRIPT"><!--
            var interval = "";
            var i = <?php echo $auto_refresh; ?>;

            function startInterval() {
                interval = window.setInterval("tTimer()", 1000);
            }

            function stopInterval() {
                window.clearInterval(interval);
                interval = "";
            }

            function tTimer() {
                timerCell = document.getElementById("time");
                if (i > -1) {
                    timerCell.innerHTML = i--;
                }
            }

            -->
        </SCRIPT>
        <?php echo $word_refresh_in; ?> <span id="time"></span>
        <script>
            startInterval();
        </script>
        <?php
    }
}

// This function let's the user decide where to add something, at the beginning or the end of the list
// Added 3.9.04 by Ross Carlson
function displayBarge()
{
    global $word_add_at, $word_current, $word_end;

    // Let's show them the box so they can choose where the playlist should go...

    echo '<br>' . $word_add_at . '<br>' . '<select onChange="submit()" name="pbWhere" class="jz_select" style="width: 68px">';

    // Now let's figure out what is set

    if ('beginning' == $_SESSION['pbWhere']) {
        echo '<option value="beginning">' . $word_current . '</option>' . '<option value="end">' . $word_end . '</option>';
    } else {
        echo '<option value="end">' . $word_end . '</option>' . '<option value="beginning">' . $word_current . '</option>';
    }

    echo '</select>';
}

// This function displays the next upcoming tracks
function displayUpcoming()
{
    global $word_nowplaying, $word_upcoming, $num_upcoming, $word_stopped, $album_name_truncate;

    // Now let's display the current playing track

    echo '<strong>' . $word_upcoming . '</strong><br>' . $track;

    // Let's get the current track

    $status = controlXMMS('currenttrack');

    $track = mb_substr($status[0], mb_strpos($status[0], 'song:') + 5, 9999);

    // Now let's get the full list, only if we need to

    if (!isset($_SESSION['jukebox-list'])) {
        $_SESSION['jukebox-list'] = controlXMMS('list');
    } else {
        if (count($_SESSION['jukebox-list']) < 2) {
            $_SESSION['jukebox-list'] = controlXMMS('list');
        }
    }

    $status = $_SESSION['jukebox-list'];

    $trackArray = controlXMMS('list filename');

    $found = false;

    $i = 0;

    for ($ctr = 0, $ctrMax = count($status); $ctr < $ctrMax; $ctr++) {
        if (mb_stristr($status[$ctr], $track)) {
            $found = true;
        }

        if (true === $found and $num_upcoming > $i) {
            $upcoming = trim(mb_substr($status[$ctr + 2], mb_strpos($status[$ctr + 2], '.') + 2, mb_strlen($status[$ctr + 2])));

            // Now let's truncate that if we need to

            if (mb_strlen($upcoming) > $album_name_truncate) {
                $upcoming = mb_substr($upcoming, 0, $album_name_truncate) . '...';
            }

            // Now let's get the track number so we can link to it

            for ($c = 0, $cMax = count($trackArray); $c < $cMax; $c++) {
                if ('*' == mb_substr($trackArray[$c], 0, 1)) {
                    $next_track_number = trim(mb_substr($trackArray[$c + 2 + $i], 0, mb_strpos($trackArray[$c + 2 + $i], '.'))) . '-';
                }
            }

            echo '<a href="#" class="jz_header_table_td" onClick=\'xmmsControlForm.xmmscommand.value="jump ' . $next_track_number . '";xmmsControlForm.submit()\';\>' . $upcoming . '</a><br>';

            $i++;
        }
    }
}

// This function displays the next 3 upcoming tracks
function displayWinampUpcoming()
{
    global $word_nowplaying, $word_upcoming, $num_upcoming, $word_stopped, $album_name_truncate;

    // Now let's display the current playing track

    while ('' == $status) {
        $status = controlWinamp('getplaylisttitle');
    }

    echo '<strong>' . $word_upcoming . '</strong><br>';

    $statArray = explode('<br>', $status);

    $found = 'false';

    while ('' == $current_title) {
        $current_title = controlWinamp('getcurrenttitle');
    }

    $cur_track = trim(mb_substr($current_title, mb_strpos($current_title, '. ') + 2, mb_strlen($current_title)));

    for ($ctr = 0, $ctrMax = count($statArray); $ctr < $ctrMax; $ctr++) {
        // Now let's get the currently playing track

        if ('true' == $found) {
            echo $statArray[$ctr] . '<br>';
        }

        if (mb_stristr($statArray[$ctr], $cur_track)) {
            $found = 'true';

            $ctr++;
        }
    }

    // Let's get the current track

    $status = controlXMMS('currenttrack');

    $track = mb_substr($status[0], mb_strpos($status[0], 'song:') + 5, 9999);

    // Now let's get the full list, only if we need to

    if (!isset($_SESSION['jukebox-list'])) {
        $_SESSION['jukebox-list'] = controlXMMS('list');
    }

    $status = $_SESSION['jukebox-list'];

    $found = false;

    $i = 0;

    for ($ctr = 0, $ctrMax = count($status); $ctr < $ctrMax; $ctr++) {
        if (mb_stristr($status[$ctr], $track)) {
            $found = true;
        }

        if (true === $found and $num_upcoming > $i) {
            $upcoming = trim(mb_substr($status[$ctr + 2], mb_strpos($status[$ctr + 2], '.') + 2, mb_strlen($status[$ctr + 2])));

            // Now let's see if there was an artist pulled, if not let's pretty it up

            if ('- ' == mb_substr($upcoming, 0, 2)) {
                $upcoming = mb_substr($upcoming, 2, mb_strlen($upcoming));
            }

            // Now let's truncate that if we need to

            if (mb_strlen($upcoming) > $album_name_truncate) {
                $upcoming = mb_substr($upcoming, 0, $album_name_truncate) . '...';
            }

            // Now let's get the track number so we can link to it

            // Let's get all the tracks  IF we need to

            if (!isset($_SESSION['jukebox-filenames'])) {
                $_SESSION['jukebox-filenames'] = controlXMMS('list filenames');
            }

            $trackArray = $_SESSION['jukebox-filenames'];

            for ($c = 0, $cMax = count($trackArray); $c < $cMax; $c++) {
                if ('*' == mb_substr($trackArray[$c], 0, 1)) {
                    $next_track_number = trim(mb_substr($trackArray[$c + 2 + $i], 0, mb_strpos($trackArray[$c + 2 + $i], '.'))) . '-';
                }
            }

            echo '<a href="#" class="jz_header_table_td" onClick=\'xmmsControlForm.xmmscommand.value="jump ' . $next_track_number . '";xmmsControlForm.submit()\';\>' . $upcoming . '</a><br>';

            $i++;
        }
    }
}

// This function displays the album art (if found) from the current track
// Added 2.24 by Ross Carlson
function displayCurrentWinampTrack()
{
    global $word_nowplaying, $word_next_track, $word_pause, $word_stopped, $album_name_truncate;

    // Let's display the now playing stuff

    echo '<strong>' . $word_nowplaying . '</strong> ';

    // Now let's get Winamp's status

    while ('' == $status) {
        $status = controlWinamp('isplaying');
    }

    if ('0' == $status) {
        echo ' (' . $word_stopped . ')';
    }

    if ('3' == $status) {
        echo ' (' . $word_pause . ')';
    }

    // Let's get all the tracks

    while ('' == $results) {
        $results = controlWinamp('getcurrenttitle');
    }

    echo '<br>' . mb_substr($results, mb_strpos($results, '.') + 2, mb_strlen($results));

    // Now let's display the next track

    $cur_pos = '';

    while ('' == $cur_pos) {
        $cur_pos = trim(controlWinamp('getplaylistpos'));
    }

    $cur_list = '';

    while ('' == $cur_list) {
        $cur_list = controlWinamp('getplaylisttitle');
    }

    $curArray = explode('<br>', $cur_list);

    $next_track = $curArray[$cur_pos + 1];

    if ('' != $next_track) {
        echo '<br><strong>' . $word_next_track . '</strong><br>';

        // Now let's truncate that if we need to

        if (mb_strlen($next_track) > $album_name_truncate) {
            $next_track = mb_substr($next_track, 0, $album_name_truncate) . '...';
        }

        echo $next_track;
    }
}

// This function displays the album art (if found) from the current track
// Added 2.25 by Ross Carlson
function displayWinampCurrentTrackArt()
{
    global $ext_graphic, $jukebox, $web_root, $this_page, $url_seperator;

    // Let's get the currently playing track

    $cur_track = '';

    while ('' == $cur_track) {
        $cur_track = trim(controlWinamp('getlistpos'));
    }

    // Let's get the complete playlist so we can figure out where we are

    $status = '';

    while ('' == $status) {
        $status = controlWinamp('getplaylistfile');
    }

    $fileArray = explode('<br>', $status);

    $cur_file = $fileArray[$cur_track];

    // Now let's get the current directory

    $dirArray = explode('\\', $cur_file);

    unset($dirArray[count($dirArray) - 1]);

    $filePath = implode('\\', $dirArray);

    $filePath = trim(str_replace('\\', '/', $filePath));

    $imgArray = readDirInfo($filePath, 'file');

    for ($i = 0, $iMax = count($imgArray); $i < $iMax; $i++) {
        if (preg_match("/\.($ext_graphic)$/i", $imgArray[$i])) {
            $album_image = str_replace($web_root, '', $filePath) . '/' . $imgArray[$i];

            $infoArray = explode('\\', str_replace($web_root, '', $filePath));

            $album_link = $this_page . $url_seperator . 'ptype=songs&genre=' . $infoArray[count($infoArray) - 3] . '&artist=' . $infoArray[count($infoArray) - 2] . '&album=' . $infoArray[count($infoArray) - 1];

            $artist_link = $this_page . $url_seperator . 'ptype=artist&genre=' . $infoArray[count($infoArray) - 3] . '&artist=' . $infoArray[count($infoArray) - 2];

            $album_name = $infoArray[count($infoArray) - 1];

            $artist_name = $infoArray[count($infoArray) - 2];
        }
    }

    // Now let's make sure we found an image

    if ('' != $album_image) {
        echo '<a title="' . $album_name . '" href="' . $album_link . '"><img border="0"';

        if ('' != $album_force_height and '0' != $album_force_height) {
            echo ' width="' . $album_force_height . '" ';
        }

        echo 'src="' . $album_image . '"></a>' . '<br><center>' . '<a title="' . $artist_name . '" href="' . $artist_link . '">' . $artist_name . '</a><br>' . '<a title="' . $album_name . '" href="' . $album_link . '">' . $album_name . '</a><center>';
    }
}

// This function displays the album art (if found) from the current track
// Added 2.18 by Ross Carlson
function displayCurrentTrackArt()
{
    global $ext_graphic, $jukebox, $web_root, $this_page, $url_seperator, $album_force_height;

    // Ok, let's get the track number

    $trackNum = controlXMMS('currenttrack');

    $trackNum = trim(str_replace('Current song: ', '', trim(mb_substr($trackNum[0], 0, mb_strpos($trackNum[0], '.'))))) - 1;

    $album_image = '';

    // Now let's make sure the filenames variable is set

    if (!isset($_SESSION['jukebox-filenames'])) {
        $_SESSION['jukebox-filenames'] = controlXMMS('list filenames');
    } else {
        if (count($_SESSION['jukebox-filenames']) < 2) {
            $_SESSION['jukebox-filenames'] = controlXMMS('list filenames');
        }
    }

    $fileName = mb_substr($_SESSION['jukebox-filenames'][$trackNum], mb_strpos($_SESSION['jukebox-filenames'][$trackNum], '.') + 2, mb_strlen($_SESSION['jukebox-filenames'][$trackNum]));

    // Ok, let's look for art for this album

    $filePathArray = explode('/', $fileName);

    unset($filePathArray[count($filePathArray) - 1]);

    $filePath = trim(implode('/', $filePathArray));

    $imgArray = readDirInfo($filePath, 'file');

    for ($i = 0, $iMax = count($imgArray); $i < $iMax; $i++) {
        if (preg_match("/\.($ext_graphic)$/i", $imgArray[$i])) {
            $album_image = str_replace($web_root, '', $filePath) . '/' . $imgArray[$i];

            $infoArray = explode('/', str_replace($web_root, '', $filePath));

            $album_link = $this_page . $url_seperator . 'ptype=songs&genre=' . $infoArray[count($infoArray) - 3] . '&artist=' . $infoArray[count($infoArray) - 2] . '&album=' . $infoArray[count($infoArray) - 1];

            $artist_link = $this_page . $url_seperator . 'ptype=artist&genre=' . $infoArray[count($infoArray) - 3] . '&artist=' . $infoArray[count($infoArray) - 2];

            $album_name = $infoArray[count($infoArray) - 1];

            $artist_name = $infoArray[count($infoArray) - 2];
        }
    }

    // Now let's make sure we found an image

    if ('' != $album_image) {
        echo '<a title="' . $album_name . '" href="' . $album_link . '"><img border="0"';

        if ('' != $album_force_height and '0' != $album_force_height) {
            echo ' width="' . $album_force_height . '" ';
        }

        echo 'src="' . $album_image . '"></a>' . '<br><center>' . '<a title="' . $artist_name . '" href="' . $artist_link . '">' . $artist_name . '</a><br>' . '<a title="' . $album_name . '" href="' . $album_link . '">' . $album_name . '</a><center>';
    }
}

// This function returns the current and upcoming track
function displayCurrentTrack($slim = false, $full = true)
{
    global $word_nowplaying, $word_next_track, $word_pause, $word_stopped, $album_name_truncate, $img_fav_track;

    // Now let's display the current playing track

    $status = controlXMMS('currenttrack');

    $track = mb_substr($status[0], mb_strpos($status[0], 'song:') + 5, 9999);

    $cur_track = $track;

    $track = trim(mb_substr($track, mb_strpos($track, '.') + 1, mb_strlen($track)));

    // Now let's see if there was an artist pulled, if not let's pretty it up

    if ('- ' == mb_substr($track, 0, 2)) {
        $track = mb_substr($track, 2, mb_strlen($track));
    }

    echo '<strong>' . $word_nowplaying . '</strong> ';

    // Now let's see if it's paused

    $playStatus = readJBStatus();

    if (true === $full) {
        switch ($playStatus) {
            case 'paused':
                echo '(' . $word_pause . ')';
                break;
            case 'stopped':
                echo '(' . $word_stopped . ')';
                break;
        }
    }

    // Now let's truncate that if we need to

    if (mb_strlen($track) > $album_name_truncate) {
        $track = mb_substr($track, 0, $album_name_truncate) . '...';
    }

    if (true === $full) {
        echo '<br>';
    }

    echo $track . ' ';

    if (false === $full) {
        return;
    }

    $trackNum = controlXMMS('currenttrack');

    // Now let's get the full list, only if we need to

    if (!isset($_SESSION['jukebox-list'])) {
        $_SESSION['jukebox-list'] = controlXMMS('list');
    }

    $next_track_number = trim(str_replace('Current song: ', '', trim(mb_substr($trackNum[0], 0, mb_strpos($trackNum[0], '.')))));

    $next_track = trim(mb_substr($_SESSION['jukebox-list'][$next_track_number], mb_strpos($_SESSION['jukebox-list'][$next_track_number], '.') + 1, mb_strlen($_SESSION['jukebox-list'][$next_track_number])));

    $next_track_number++;

    if ('' != $next_track) {
        // Now let's see if there was an artist pulled, if not let's pretty it up

        if ('- ' == mb_substr($next_track, 0, 2)) {
            $next_track = mb_substr($next_track, 2, mb_strlen($next_track));
        }

        echo '<br><strong>' . $word_next_track . '</strong><br>';

        // Now let's truncate that if we need to

        if (mb_strlen($next_track) > $album_name_truncate) {
            $next_track = mb_substr($next_track, 0, $album_name_truncate) . '...';
        }

        // Now let's only show the link if we are not in slim mode

        if (false === $slim) {
            echo '<a href="#" class="jz_header_table_td" onClick=\'xmmsControlForm.xmmscommand.value="jump ' . $next_track_number . '";xmmsControlForm.submit()\';\>';
        }

        echo $next_track;

        if (false === $slim) {
            echo '</a>';
        }
    }
}

?>

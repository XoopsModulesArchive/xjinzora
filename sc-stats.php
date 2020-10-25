<?php

/* MusicTicker - XML version 1.4.1                           */

/* MAD props to Tom Pepper and Tag Loomis for all their help */
/* --------------------------------------------------------- */
/* SCXML reference version 0.4.1                             */
/* June 30 2005 11:19 EST                                    */

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
* Code Purpose: This page gathers the status from Shoutcast (please see above for author credits
* Created: 9.24.03 by Ross Carlson
*
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

// Ok, now we need to include the settings file and the style sheet

error_reporting(E_ALL ^ E_NOTICE);

//manditory config items
$maxsongs = '5'; // max number of songs to display (max is 20)
$rfrshrate = '60'; // reload rate of page
$timeat = '0'; // display starttime (0) or endtime (1)

//gui config items
$bodybgcolor = '#f0f6fb';
$bodytext = '#000000';
$bodylink = '#708fbe';
$bodyvlink = '#708fbe';
$bordercolor = '#000000';
$csscolor = '#708fbe';
$font = 'Arial, Helvetica';
$align = 'center';

//master table color scheme
$mstrtext = '#000000';
$mstrbgcolor = '#f0f6fb';

//lead table color scheme
$tbl1bgcolor1 = '#708fbe';
$tbl1bgcolor2 = '#ffffff';
$tbl1text = '#ffffff';

//content table color scheme
$tbl2bgcolor1 = '#708fbe';
$tbl2bgcolor2 = '#ffffff';
$tbl2text1 = '#ffffff';
$tbl2text2 = '#000000';

//error screen color scheme
$errorbgcolor = '#f0f6fb';
$errortext = '#708fbe';

//On screen messages
$pgtitle = 'Shoutcast Status Page';
$header = 'Shoutcast Status Page';
$timezone = 'EST (-0500 GMT)';
$errormsg1 = 'Shoutcasting Off-line';
$errormsg2 = '';
$dsperror1 = '';
$dsperror2 = '';

$error1 = (string)$errormsg1;
$error2 = (string)$dsperror1;

$serv1 = new SCXML();

$serv1->set_host((string)$sc_host);
$serv1->set_port((string)$sc_port);
$serv1->set_password((string)$sc_password);

if (!$serv1->retrieveXML()) {
    echo((string)$error1);
}

$con_dsp = $serv1->fetchMatchingTag('STREAMSTATUS');
if ('1' == !$con_dsp) {
    echo((string)$error2);
}

$cur_listen = $serv1->fetchMatchingTag('CURRENTLISTENERS');
if ('' == $cur_listen) {
    $cur_listen = 0;
}
$peak_listen = $serv1->fetchMatchingTag('PEAKLISTENERS');
$max_listen = $serv1->fetchMatchingTag('MAXLISTENERS');
$title = $serv1->fetchMatchingTag('SERVERTITLE');
$song_title = $serv1->fetchMatchingTag('SONGTITLE');
$con_hostname = $serv1->fetchMatchingArray('HOSTNAME');
$con_listen = $serv1->fetchMatchingArray('CONNECTTIME');
$con_song = $serv1->fetchMatchingArray('TITLE');
$con_song_print = array_slice($con_song, 1, $maxsongs);
$con_time = $serv1->fetchMatchingArray('PLAYEDAT');
if (preg_match('/^[0-9]{10}$/', $con_time[0])) {
    for ($i = 0, $iMax = count($con_time); $i < $iMax; $i++) {
        $con_time[$i] = date('H:i:s', $con_time[$i]);
    }

    $playtime = $con_time;
} else {
    $playtime = $con_time;
}

if ('0' == $timeat) {
    $playat = array_shift($playtime);
} else {
    $playtime = $playtime;
}

// Let's not include the refresh in the block
if (!isset($pnblock)) {
    echo '<META HTTP-EQUIV="Refresh" CONTENT="' . $sc_refresh . '">';
}

// Let's make sure the server isn't down
if ('' != $song_title) {
    // Now let's open the shoutcast playlist to get the next song

    $filename = $web_root . $root_dir . $jinzora_temp_dir . '/shoutcast.lst';

    $handle = fopen($filename, 'rb');

    $contents = fread($handle, filesize($filename));

    fclose($handle);

    // Now let's create an array out of that

    $trackArray = explode("\n", $contents);

    // Now let's loop through that to find what we want

    $i = 0;

    while (count($trackArray) > $i) {
        if (mb_stristr(mb_strtolower($trackArray[$i]), mb_strtolower($song_title))) {
            // Ok, we found it now we need to get the next song

            $nextSong = $trackArray[$i + 1];

            $currentSong = $trackArray[$i];
        }

        $i++;
    }

    // Now let's get that filename

    $fileName = explode('/', $nextSong);

    $nextSong = str_replace('.mp3', '', $fileName[count($fileName) - 1]);

    if ('false' == $cms_mode) {
        echo '<br>';
    }

    echo '<center>Currently Shoutcasting<br>';

    echo "<a href=\"http://$sc_host:$sc_port/listen.pls\">";

    // Let's see if this was included with the block or not

    if (isset($pnblock)) {
        if ('' != $curtrackArtists) {
            echo $curtrackArtists . '<br>';
        }

        echo "$song_title</a>";

        echo "<br>$cur_listen/$max_listen streaming</center></body>";
    } else {
        echo "$song_title</a>";

        if ('' != $nextSong) {
            echo "<br><br>Next up: $nextSong<br>";
        }

        echo "<br>There are currently $cur_listen/$max_listen people streaming</center></body>";
    }
}

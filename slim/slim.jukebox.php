<?php

// Let's see if they are accessing this directly or not
if (isset($_GET['direct'])) {
    // Ok, we'll need to include some stuff for this to work...

    require_once dirname(__DIR__) . '/settings.php';

    require_once dirname(__DIR__) . '/system.php';

    require_once dirname(__DIR__) . '/jukebox.lib.php';

    $num_upcoming = '6';

    // Let's set the body

    echo '<body bgcolor="' . $_GET['bg'] . '" text="' . $_GET['fc'] . '" leftmargin="0" topmargin="0">';

    // Let's edit the style ?>
    <style>
        .jz_header_table_td {
            font-family: Verdana;
            font-size: 11px;
        }
    </style>
    <?php
    echo '<META HTTP-EQUIV="Refresh" CONTENT="' . $_GET['rf'] . '">';

    // Ok, right off the bat let's set the session variable of what page we're on

    // So we can go back to it easily

    $_SESSION['prev_page'] = $_SERVER['REQUEST_URI'];

    if ('' == $_SESSION['prev_page']) {
        $_SESSION['prev_page'] = $_SERVER['URL'] . '?' . $_SERVER['QUERY_STRING'];
    }
} else {
    // Now let's include the jukebox library

    require_once __DIR__ . '/jukebox.lib.php';
}

// Now let's show them the seperator bar
if (!isset($_GET['direct'])) {
    echo '<table  cellspacing="0" cellpadding="0" border="0" width="100%"><tr><td height="6" width="100%" background="' . $root_dir . '/style/images/slim-sep.gif"></td></tr></table>';
}
// Now let's setup our table
echo '<table with="100%" cellspacing="0" cellpadding="5" border="0"><tr><td valign="top" align="center" width="1%" class="jz_header_table_td">';

// Let's define the beginning for our images
$img_start = '<img src="' . $root_dir . '/style/' . $jinzora_skin;
$url_start = '<a href="' . $root_dir . '/jukebox.lib.php?return=' . base64_encode($_SESSION['prev_page']) . '&jb=';

// Ok, now are we in jukebox mode?
if ('xmms' == $jukebox) {
    // let's show the play controls

    echo $url_start
         . 'play">'
         . $img_start
         . '/play.gif" border="0"></a> '
         . $url_start
         . 'pause">'
         . $img_start
         . '/pause.gif" border="0"></a> '
         . $url_start
         . 'stop">'
         . $img_start
         . '/stop.gif" border="0"></a> '
         . $url_start
         . 'prev">'
         . $img_start
         . '/previous.gif" border="0"></a> '
         . $url_start
         . 'next">'
         . $img_start
         . '/next.gif" border="0"></a> '
         . $url_start
         . 'randomize">'
         . $img_start
         . '/random.gif" border="0"></a> '
         . $url_start
         . 'clear">'
         . $img_start
         . '/clear.gif" border="0"></a>';
}

// Did they only want the controls?
if (isset($_GET['c'])) {
    echo '<br>';

    if ('controls' == $_GET['c']) {
        exit();
    }
}

// Now let's show the current playing track
if ('current' == $_GET['c']) {
    displayCurrentTrack(true, false);
} else {
    echo '<br>';

    displayCurrentTrack(true, true);
}

if (isset($_GET['c'])) {
    if ('current' == $_GET['c']) {
        exit();
    }
}

// Now let's show them the upcoming tracks
//displayFullList(true);

// Now let's close out
echo '</td></tr></table></body>';
?>

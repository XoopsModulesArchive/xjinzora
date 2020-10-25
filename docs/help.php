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
* Code Purpose: This page contains all the help documentation related functions
* Created: 11.15.03 by Ross Carlson
*
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

// Let's modify the include path for Jinzora
ini_set('include_path', '.');

// Let's include the main, user settings file
require_once dirname(__DIR__) . '/settings.php';
require_once dirname(__DIR__) . '/system.php';

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
    <title>Jinzora Help Documentation</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<frameset rows="35,*" cols="*" frameborder="NO" border="0" framespacing="0">
    <frame src="topnav.php?language=<?php echo $_GET['language']; ?>" name="topNav" scrolling="NO" noresize>
    <frameset cols="150,*" frameborder="NO" border="0" framespacing="0">
        <frame src="leftnav.php?language=<?php echo $_GET['language']; ?>" name="leftNav" scrolling="NO" noresize>
        <frame src="body.php?language=<?php echo $_GET['language']; ?>" name="Body">
    </frameset>
</frameset>
<noframes></noframes>
</html>





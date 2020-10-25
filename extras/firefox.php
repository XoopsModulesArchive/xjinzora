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
* Purpose: Adds a search bar to mozilla firefox.
*
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

// todo: get 'name' from settings.php?
$code = '
		# Mozilla/Jinzora plugin by bdodson@seas.upenn.edu
		# www.jinzora.org
 
		<search
		   name="Jinzora"
		   description="Jinzora Media Search"
		   method="GET"
		   action="http://' . $_SERVER['HTTP_HOST'] . '/PATHTOSEARCH"
		   update="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '"
		   updateCheckDays=3
		   queryEncoding="utf-8"
		   queryCharset="utf-8"
		>
		 
		<input name="q" user>
		<input name="sourceid" value="mozilla-search">
		<inputnext name="start" factor="10">
		<inputprev name="start" factor="10">
		<input name="ie" value="utf-8">
		<input name="oe" value="utf-8">
		';
// The above 'inputs' are what get passed to jinzora.
// value="" is a literal, user is the query string.
// Those are straight from the google searchbar, so
// a lot of those can just be removed.
//
// the stuff below is for the sidebar.
// it requires changes to the search results page.
// we could just leave it out.
/*
$code .= '
<interpret
    browserResultType="result"
    charset = "UTF-8"
    resultListStart="<!--a-->"
    resultListEnd="<!--z-->"
    resultItemStart="<!--m-->"
    resultItemEnd="<!--n-->"
>
';
*/
$code .= '</search>';

<?php
/**
 * - JINZORA | Web-based Media Streamer -
 *
 * Jinzora is a Web-based media streamer, primarily desgined to stream MP3s
 * (but can be used for any media file that can stream from HTTP).
 * Jinzora can be integrated into a CMS site, run as a standalone application,
 * or integrated into any PHP website.  It is released under the GNU GPL.
 *
 * - Resources -
 * - Jinzora Author: Ross Carlson <ross@jasbone.com>
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
 * This is the header for a backend that uses an external XML file.
 *
 * @since  05.10.04
 * @author Ross Carlson <ross@jinzora.org>
 */

// include the default adaptor.
// We will inherit the classes from here.
require_once __DIR__ . '/backend/classes.php';

// A few helpers for the class..
require_once __DIR__ . '/backend/${adaptor}/helpers.php';

// Now create our adaptor from the media.php file:
require_once __DIR__ . '/backend/cache/media.php';

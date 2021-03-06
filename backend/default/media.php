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
 * This is the media backend for the default XML cache adaptor.
 *
 * @since  05.10.04
 * @author Ross Carlson <ross@jinzora.org>
 */

// include classes for extending.
require_once dirname(__DIR__) . '/classes.php';

// Both classes are fully defined in classes.php, since other adaptors
// may use the existing functionality of caching.
// NOTE: we need to make sure caches appear in backend/default/data and not backend/data.
class jzMediaNode extends jzMediaNodeClass
{
    public function __construct($arg = [])
    {
        $this->_constructor($arg);
    }
}

class jzMediaTrack extends jzMediaTrackClass
{
    public function __construct($arg = [])
    {
        $this->_constructor($arg);
    }
}

// That's it!

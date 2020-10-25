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
 * Handles all Jinzora's translations
 *
 * @since  05/01/04
 * @author Laurent Perrin <laurent@la-base.org>
 */

// First we'll include English in case the other isn't fully translated
require_once __DIR__ . '/lang/english.php';

// We then add any global var starting with 'word_' to our translation map
$lang_array = [];
foreach ($GLOBALS as $name => $content) {
    // make sure this is a string, or we would get a warning from php

    if (is_string($content)) {
        if (0 == strncasecmp($name, 'word_', 5)) {
            $lang_array[md5($content)] = $name;
        }
    }
}

// Now let's include the proper language file
if ('english' != mb_strtolower($lang_file)) {
    require __DIR__ . '/lang/' . mb_strtolower($lang_file) . '.php';
}

/*
* This function finds the translation of the given english string
* If nothing is found, the string is returned as is, and optionaly logged
*
* @access public
* @author Laurent Perrin
* @version 05/01/04
* @since 05/01/04
*/
function T($text)
{
    $result = $GLOBALS[$GLOBALS['lang_array'][md5($text)]];

    if ('' == $result) {
        if ($GLOBALS['debug_lang']) {
            $fd = fopen('lang_todo.txt', 'ab');

            fwrite($fd, "$lang_file: $text\r\n");

            fclose($fd);
        }

        return $text;
    }

    return $result;
}

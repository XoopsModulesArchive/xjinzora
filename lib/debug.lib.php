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
 * - Jinzora Author: Ross Carlson <ross@jasbone.com>
 * - Web: http://jinzora.jasbone.com
 * - Documentation: http://jinzora.jasbone.com/docs
 * - Support: http://jinzora.jasbone.com/forum
 * - Downloads: http://jinzora.jasbone.com/downloads
 * - License: GNU GPL <http://www.gnu.org/copyleft/gpl.html>
 *
 * - Contributors -
 * Please see http://jinzora.jasbone.com/modules.php?op=modload&name=jz_whois&file=index
 *
 * - Code Purpose -
 * Debug library
 *
 * @since  04.30.04
 * @author Laurent Perrin <laurent@la-base.org>
 */

/**
 * Prints out the call stack in an html table.
 *
 * @author  Laurent Perrin
 * @version 04/30/04
 * @since   04/30/04
 **/
function callstack()
{
    $callstack = debug_backtrace();

    $thiscall = array_shift($callstack);

    echo 'Trace from <b>' . $thiscall['file'] . '</b> line <b>' . $thiscall['line'] . '</b>';

    echo '<table><tr bgcolor="#ffbbaa"><th>File</th><th>Line</th><th>Function</th><th>Args</th></tr>';

    foreach ($callstack as $call) {
        echo '<tr bgcolor="#efdbcc">';

        echo '<td>' . $call['file'] . '</td>';

        echo '<td>' . $call['line'] . '</td>';

        echo '<td>' . $call['function'] . '</td>';

        echo '<td>';

        if (is_array($call['args'])) {
            foreach ($call['args'] as $arg) {
                var_dump($arg);

                echo '<br>';
            }
        }

        echo '</td>';

        echo '</tr>';
    }

    echo '</tr></table>';
}

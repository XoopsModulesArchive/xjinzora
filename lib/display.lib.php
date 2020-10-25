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
 * This page contains display functions
 *
 * @since  04/28/04
 * @author Ross Carlson <ross@jinzora.org>
 * @param mixed $width
 * @param mixed $cellpadding
 * @param mixed $class
 * @param mixed $widthType
 */

/**
 * Display the opening tag for a table
 *
 * @param string $width       Width of the table in percent
 * @param string $cellpadding cellpadding for the table
 * @param string $class       the style sheet class for the table
 * @param string $widthType
 * @author  Ross Carlson
 * @version 04/28/04
 * @since   04/28/04
 */
function jzTableOpen($width = '100', $cellpadding = '5', $class = 'jz_track_table', $widthType = '%')
{
    echo '<table class="' . $class . '" width="' . $width . $widthType . '" cellpadding="' . $cellpadding . '" cellspacing="0" border="0">' . "\n";
}

/**
 * Display the closing tag for a table
 *
 * @author  Ross Carlson
 * @version 04/28/04
 * @since   04/28/04
 */
function jzTableClose()
{
    echo '</table>' . "\n";
}

/**
 * open a Table Row
 *
 * @param string $class the style sheet class for the table
 * @version 04/28/04
 * @since   04/28/04
 * @author  Ross Carlson
 */
function jzTROpen($class = '')
{
    echo '  <tr class="' . $class . '">' . "\n";
}

/**
 * close a Table Row
 *
 * @author  Ross Carlson
 * @version 04/28/04
 * @since   04/28/04
 */
function jzTRClose()
{
    echo '  </tr>' . "\n";
}

/**
 * Display the opening tag for a table detail
 *
 * @param string $width   Width of the table in percent
 * @param string $align   alignment for the cell
 * @param string $valign  verticle alignment for the cell
 * @param string $class   the style sheet class for the table
 * @param string $colspan how many colums should this cell span
 * @param mixed  $widthType
 * @since   04/28/04
 * @author  Ross Carlson
 * @version 04/28/04
 */
function jzTDOpen($width = '100', $align = 'left', $valign = 'top', $class = '', $colspan = '', $widthType = '%')
{
    echo '    <td width="' . $width . $widthType . '" align="' . $align . '" valign="' . $valign . '" class="' . $class . '" colspan="' . $colspan . '">' . "\n";
}

/**
 * Display the opening tag for a table detail
 *
 * @author  Ross Carlson
 * @version 04/28/04
 * @since   04/28/04
 */
function jzTDClose()
{
    echo '    </td>' . "\n";
}

/**
 * Display an A HREF tag
 *
 * @author  Ross Carlson
 * @version 04/28/04
 * @since   04/28/04
 * @param mixed $href
 * @param mixed $target
 * @param mixed $class
 * @param mixed $onclick
 * @param mixed $item
 */
function jzHREF($href, $target, $class, $onclick, $item)
{
    echo '<a class="' . $class . '" href="' . $href . '" target="' . $target . '" onclick="' . $onclick . '">' . $item . '</a>';
}

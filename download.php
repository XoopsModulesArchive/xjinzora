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
 * This page handles streaming downloads, featuring :
 * - on the fly converting to tar archive
 * - speed limiting
 * - very low memory usage
 *
 * - Notes -
 * - Streaming gzipped (tgz) data is difficult, because data checksum have
 * to be sent first. One option would be to open all files, read them in, compute the crc,
 * then open them again to stream them to the user. This sounds no better than building a
 * temporary archive and sending it.
 * - Zip archives can be compressed on the fly, but: crc computation in php is really too slow,
 * as we can't use the builtin function wich doesn't accept an initilization value. The choosen
 * option is to read the file entirely first to get its crc, then read it again to compress it
 * on the fly. Aditionaliy, when used with any other level value than 0 (no compression), the
 * deflate algorithm produces non byte aligned data. Handling this is difficult, so only
 * uncompressed zip files are supported now.
 * - So users should be advised to use raw files (if only one was requested) and tar archives.
 * It's much faster and lighter on memory, cpu and disk.
 * - Speed can seem a little clunky when limited. This is due to the fact that we can't sleep
 * less than a second because usleep() isn't supported on windows palteform.
 *
 * @since  02/02/04
 * @author Laurent Perrin <laurent@la-base.org>
 */

// settings
require __DIR__ . '/settings.php';
// for the writeLogData function
require __DIR__ . '/general.php';
// compatibility functions
require __DIR__ . '/compat.lib.php';
// include compression functions
require __DIR__ . '/jzcomp.lib.php';

// if it's a full directory, get file list
if (is_dir($web_root . $root_dir . $media_dir . '/' . $_GET['info'])) {
    $what = readDirInfo($web_root . $root_dir . $media_dir . '/' . $_GET['info'], 'file');

    for ($e = 0, $eMax = count($what); $e < $eMax; $e++) {
        // Now let's track that this was downloaded

        updateCounter($_GET['info'] . '/' . $what[$e]);
    }

    foreach ($what as $key => $file) {
        $what[$key] = $web_root . $root_dir . $media_dir . '/' . $_GET['info'] . '/' . $file;
    }

    $mode = $multiple_download_mode;

// it's a single file
} elseif (is_file($web_root . $root_dir . $media_dir . '/' . $_GET['info'])) {
    $what = $web_root . $root_dir . $media_dir . '/' . $_GET['info'];

    // Now let's track that this was downloaded

    updateCounter($_GET['info']);

    $mode = $single_download_mode;
} else {    // it doesn't exist!
    echo 'Error, ' . $_GET['info'] . " doesn't exist!";

    exit;
}

// open the stream
switch ($mode) {
    case 'tar':
        $reader = new jzStreamTar($what);
        break;
    case 'raw':
        $reader = new jzStreamRaw($what);
        break;
    case 'zip':
        $reader = new jzStreamZip($what);
        break;
} // switch

// Let's set what the file name should be
$file_root_name = str_replace('/', '-', $_GET['info']);
while ('-' == mb_substr($file_root_name, 0, 1)) {
    $file_root_name = mb_substr($file_root_name, 1, mb_strlen($file_root_name));
}

// content typeheaders
switch ($mode) {
    case 'raw':
        // send content-type header, determined from file type
        header('Content-type: ' . mime_content_type($what));
        header('Content-Disposition: inline; filename="' . $file_root_name . '"');
        break;
    case 'tar':
        header('Content-type: application/x-tar');
        header('Content-Disposition: inline; filename="' . $file_root_name . '.tar"');
        break;
    case 'zip':
        header('Content-type: application/zip');
        header('Content-Disposition: inline; filename="' . $file_root_name . '.zip"');
} // switch

// content length header if supported
if (0 != $reader->FinalSize()) {
    header('Content-length: ' . (string)($reader->FinalSize()));
}

// caching headers
header('Cache-control: private');
header('Expires: ' . gmdate('D, d M Y H:i:s', mktime(date('H') + 2, date('i'), date('s'), date('m'), date('d'), date('Y'))) . ' GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Pragma: no-cache');

// Let's up the max_execution_time
ini_set('max_execution_time', '6000');

// open reader
$reader->Open();

// let's send, no speed limit
if (0 == $download_speed || '' == $download_speed) {
    while ('' != ($data = $reader->Read(4096)) and 0 == connection_status()) {
        echo $data;

        flush();
    }
} else {
    // let's send, looking at the speed

    $sent = 0;

    $begin_time = get_time();

    while ('' != ($data = $reader->Read(4096)) and 0 == connection_status()) {
        echo $data;

        flush();

        $sent += 4;

        // if current speed is too high, let's wait a bit

        while ($sent / (get_time() - $begin_time) > $download_speed) {
            sleep(1);
        }
    }
}

// close reader
$reader->Close();

//write the result in log
if (0 == connection_status()) {
    writeLogData('download', 'download of file ' . $_GET['info'] . ' sucessfull');
} else {
    writeLogData('download', 'download of file ' . $_GET['info'] . ' failed');
}

/**
 * write the counter file for the download
 *
 * *@param mixed $path
 * @return void
 * @author  Ross Carlson
 * @version 03/31/04
 * @since   03/31/04
 */
function updateCounter($path)
{
    global $web_root, $root_dir;

    $file = str_replace('/', '---', jzstripslashes(urldecode($path))) . '.dwn';

    if ('---' == mb_substr($file, 0, 3)) {
        $file = mb_substr($file, 3, mb_strlen($file));
    }

    $fileName = $web_root . $root_dir . '/data/counter/' . $file;

    $hits = 0;

    if (!is_file($fileName)) {
        touch($fileName);
    } else {
        $handle = fopen($fileName, 'rb');

        $hits = fread($handle, filesize($fileName));

        fclose($handle);
    }

    // Now let's increment the number of hits

    $hits++;

    $handle = fopen($fileName, 'wb');

    fwrite($handle, $hits);

    fclose($handle);
}

/**
 * get current time
 * @return float current time of day as seconds
 * *@author Laurent Perrin
 * @version 02/06/04
 * @since   02/06/04
 * @todo    move to a future timing library
 */
function get_time()
{
    $t = gettimeofday();

    return (float)($t['sec'] . '.' . $t['usec']);
}

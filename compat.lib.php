<?php

/**
 * for php < 4.3.0
 *
 * @param string $filename file name
 * @return string guessed mime type for thie filename
 * @since   02/06/04
 * @author  Laurent Perrin
 * @version 02/06/04
 */
if (!function_exists('mime_content_type')) {
    function mime_content_type($filename)
    {
        switch (mb_strrchr($filename, '.')) {
            case '.mp3':
            case '.mp2':
            case '.mp1':
                return 'audio/mpeg';
            case '.wav':
                return 'audio/x-wav';
            case '.avi':
                return 'video/x-msvideo';
            case '.qt':
            case '.mov':
                return 'video/quicktime';
            case '.mpe':
            case '.mpg':
            case '.mpeg':
                return 'video/mpeg';
        } // switch()

        return '';
    }
}

/**
 * for php < 4.3.0
 *
 * @param string  $filename         filename
 * @param int $use_include_path use include path
 * @return string file contents
 * @author  Laurent Perrin
 * @version 02/15/04
 * @since   02/06/04
 */
if (!function_exists('file_get_contents')) {
    function file_get_contents($filename, $use_include_path = 0)
    {
        $data = ''; // just to be safe. Dunno, if this is really needed

        $file = @fopen($filename, 'rb', $use_include_path);

        if ($file) {
            $data = fread($file, filesize($filename));

            fclose($file);
        }

        return $data;
    }
}

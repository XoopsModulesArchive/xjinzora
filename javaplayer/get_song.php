<?php

set_error_handler('myErrorHandler');
function myErrorHandler($errno, $errstr, $errfile, $errline)
{
    $fd = fopen('error.log', 'ab');

    fwrite($fd, "$errstr\r\n$errfile\r\n$errline\r\n\r\n");

    fclose($fd);
}

require dirname(__DIR__) . '/settings.php';
require dirname(__DIR__) . '/playlists.php';
require dirname(__DIR__) . '/compat.lib.php';

if (md5($_SERVER['REQUEST_URI'] . $client_key2) == $_SERVER['HTTP_USER_AGENT']) {
    // stream mp3 here

    $filename = "$web_root$root_dir$media_dir/" . $_GET['info'];

    header('Content-type: ' . mime_content_type($filename));

    header('Content-Length: ' . filesize($filename));

    readfile($filename);
} else {
    header('HTTP/1.0 404 No such file');
}

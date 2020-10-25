<?php

require_once __DIR__ . '/system.php';

function makePlugin()
{
    global $root_dir, $site_title, $_SERVER;

    $handle = fopen('extras/jinzora.src', w);

    $code = "
# Mozilla/Jinzora plugin by Ben Dodson, bdodson@seas.upenn.edu
# www.jinzora.org

<search
   name=\"$site_title\"
   description=\"Media search for $site_title\"
   method=\"GET\"
   action=\"http://${_SERVER['HTTP_HOST']}/PATHTOSEARCH\"
   queryEncoding=\"utf-8\"
   queryCharset=\"utf-8\"
>
 
<input name=\"q\" user>
<input name=\"sourceid\" value=\"mozilla-search\">
<inputnext name=\"start\" factor=\"10\">
<inputprev name=\"start\" factor=\"10\">
<input name=\"ie\" value=\"utf-8\">
<input name=\"oe\" value=\"utf-8\">
<interpret
    browserResultType=\"result\"
    charset = \"UTF-8\"
    resultListStart=\"<!--a-->\"
    resultListEnd=\"<!--z-->\"
    resultItemStart=\"<!--m-->\"
    resultItemEnd=\"<!--n-->\"
>";

    fwrite($handle, $code);

    fclose($handle);
}

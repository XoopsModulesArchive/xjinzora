<?php

// Let's modify the include path for Jinzora
ini_set('include_path', '.');
// Let's include the main, user settings file
require_once dirname(__DIR__, 2) . '/settings.php';
require_once dirname(__DIR__, 2) . '/system.php';
// Let's output the style sheets
echo "<link rel=\"stylesheet\" href=\"$root_dir/docs/default.css\" type=\"text/css\">";
?>
<body class="bodyBody">
<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td width="100%" class="bodyBody">
            <b>Embedding Slimzora</b><br>
            <br>
            You can easily embed Slimzora into an existing web page by using iFrames.
            iFrames are inline-frames and can be used to show Jinzora on a page outside of the
            Jinzora site. All you'll need to do is insert this HTML code into your:
            <br><br>
            &lt;iframe name="slimzora" src="/path/to/jinzora/slim.php" style="width: 300; border: 0px solid black;" height="400">&lt;/iframe>
            <br><br>
            You can specify the width and height to anything you like, these are just examples. You'll also need to set the "src" the the
            valid path from the root of your web server, not from the file system. You'll need to make sure that Jinzora is fully operational
            before attemping to use Slimzora in this fashion.
            <br><br>
            Example embedded Slimzora. This is being pulled from the Jinzora.org web site and should be fully functional!
            <br><br>
            <iframe name="slimzora" src="http://www.jinzora.org/modules/jinzora/slim.php" style="width: 300; border: 0px solid black;" height="200"></iframe>
        </td>
    </tr>
</table>
</body>

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
            <strong>*NIX Requirements</strong>
            <br><br>
            The requirements for *NIX users for running Jinzora are:<br><br>
            <li>PHP 4.x (5.0 beta should work but is untested)</li>
            <br>
            <li>Apache 1.x/2.x<br>
                &nbsp;&nbsp;&nbsp;(other web servers may work, but only Apache is tested)
            </li>
            <br>
            <li>the zip application (to support zipping and unzipping)</li>
            <br>
            <li>GD Library (for image resizing)</li>
            <br>
            <li>A generally organized media collection:</li>
            &nbsp;&nbsp;&nbsp;Genre/Artist/Album/Track<br>
            &nbsp;&nbsp;&nbsp;Artist/Album/Track<br>
            &nbsp;&nbsp;&nbsp;Album/Track<br><br>
            <li>The Jinzora be installed inside Apache's docroot</li>
            &nbsp;&nbsp;&nbsp;Virtual directories are not currently supported,<br>
            &nbsp;&nbsp;&nbsp;support is planned for the future<br><br>
            <li>That the webserver user can read the media files</li>
            <br>
            <li>That the webserver user can write the media files</li>
            &nbsp;&nbsp;&nbsp;<strong>NOTE:</strong> This is totally optional, but is<br>
            &nbsp;&nbsp;&nbsp;required for many of the additional tools to function
        </td>
    </tr>
</table>
</body>

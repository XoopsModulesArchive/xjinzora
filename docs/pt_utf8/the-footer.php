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
            <b>Jinzora's Footer</b>
            <br><br>
            You can change the contents of the footer in a few ways. They are:
            <br><br>
            <b>Turning off the Footer</b> - You can completely turn off the footer if you wish by
            editing "system.php" and changing the line to:
            <br><br>
            $show_jinzora_footer = false;
            <br><br>
            <b>Footer Text</b> - You can easily add text to the footer that will display on all
            pages. This is done by creating a file called "footer.txt" or "footer.php" in the root directory
            of your media. The contents of this file will be displayed on all pages (if a .php file then
            it is simply included so you can put it any code you wish).
            <br><br>
            <b>Jinzora Logo</b> - If you wish you may remove the Jinzora logo in the footer. While
            we hope you'll leave it in so users will know what's powering your site, you are welcome to remove it.
            To do so simply edit "system.php" and change the line to:
            <br><br>
            $hide_pgm_name = true;
        </td>
    </tr>
</table>
</body>

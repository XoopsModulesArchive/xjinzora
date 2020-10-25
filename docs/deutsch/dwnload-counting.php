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
            <strong>Download Counting</strong><br>
            <br>
            Just as Jinzora can track the number of times a track has been requested, it can also track the number
            of times that it has been downloaded. To enable download counting simply set:
            <br><br>
            $display_downloads = "true";
            <br><br>
            In "settings.php" that's all there is to it!
        </td>
    </tr>
</table>
</body>

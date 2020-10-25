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
            <strong>Hiding Slimzora</strong><br>
            <br>
            You can easily hide the Slimzora icon in the header. All you need to do is
            edit the file:<br><br>
            system.php<br><br>
            and set:
            <br><br>
            $show_slimzora = false;
            <br><br>
            That's all there is to it!
        </td>
    </tr>
</table>
</body>

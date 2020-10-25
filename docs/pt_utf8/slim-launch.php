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
            <b>Launching Slimzora</b><br>
            <br>
            Launching Slimzora is easy. Just click the icon just to the right of the ? icon
            in the top left hand corner of the header. Slimzora will launch in a new window
            (using a Javascript popup so make sure they are enabled). Slimzora will
            take the current active theme, or Sandstone if you are running in CMS mode.
            <br><br>
        </td>
    </tr>
</table>
</body>

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
            <b>Embedding Top Tracks in a different page</b><br>
            <br>
            If you wish you may use the "Top Tracks" page in another application. This can be done by
            referencing it (or including it) in the following way:
            <br><br>
            /path/to/jinzora/top-tracks.php?standalone=true
            <br><br>
            You will then be able to display the Top Tracks information in a standalone manner
        </td>
    </tr>
</table>
</body>

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
            <b>Video Files</b><br>
            <br>
            Jinzora can also stream video. The rules for this are rather simple, Jinzora should be able
            to stream any video format that can stream over HTTP. The following formats have been
            tested and are known to work:
            <br><br>
            <li><b>MPG|MPEG</b> (both 1 and 2)</li>
            <li><b>WMV</b> (Windows Media Video)</li>
            <li><b>AVI</b></li>
            <li><b>RM</b> (Real Media)</li>
        </td>
    </tr>
</table>
</body>

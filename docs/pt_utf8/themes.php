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
            <b>Themes</b>
            <br><br>
            Jinzora is fully themeable. Basically you can change any of the icons or
            colors anywhere in the system (layout changes are not currently possible).
            There are several themes that are included with Jinzora, gratiously donated
            by our members (thanks again Frank!).
            <br><br>
            <b>Theme Development</b>
            <br>
            If you are interested in developing Themes for Jinzora we have create a theme
            development guide as well as a forum for discussing theme development. They are:
            <br><br>
            <a href="http://www.jinzora.org/modules.php?op=modload&name=jz_docs&file=eng-theme" target="_blank">Theme Development Guide</a><br><br>
            <a href="http://www.jinzora.org/modules.php?op=modload&name=XForum&file=forumdisplay&fid=12" target="_blank">Theme Development Forum</a><br>
            <br><br>
        </td>
    </tr>
</table>
</body>

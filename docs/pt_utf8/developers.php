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
            <b>Developer Information</b><br>
            <br>
            So you'd like to help out, huh? There are many ways developers can contribute to the
            project. A few things to point out are:<br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><b>CVS Access</b></li>
                    </td>
                    <td width="70%" class="bodyBody">
                        Anonymous access is available to the Jinzora source code through CVS and through the
                        <a href="http://www.jinzora.org/modules.php?op=modload&name=jz_tools&file=webcvs" target="_blank">Jinzora Website</a>.
                        Directions for anonymous access to the CVS tree are located <a href="http://www.jinzora.org/modules.php?op=modload&name=jz_tools&file=webcvs" target="_blank">Here</a>.
                        <br><br>If you'd like to join the project and have write access to CVS please contact us at: <a href="mailto:ross@jinzora.org">ross@jinzora.org</a>
                        so we can discuss it with you.
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><b>Code Ideas</b></li>
                    </td>
                    <td width="70%" class="bodyBody">
                        Have a simple code idea you want to share with us? Join us in the <a href="http://www.jinzora.org/modules.php?op=modload&name=XForum&file=forumdisplay&fid=14" target="_blank">Developers Forum</a>
                        so we can all discuss it!
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

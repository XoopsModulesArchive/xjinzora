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
            <strong>Feature Requests</strong>:<br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#request">How do I suggest/request a new feature?</a><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#getadded">What kind of features get added?</a><br><br>
                    </td>
                </tr>
            </table>
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <strong><a name="request">How do I suggest/request a new feature?</a></strong><br><br>
                        By visiting my <a href="http://www.jinzora.org/modules.php?op=modload&name=XForum&file=forumdisplay&fid=4">Feature Request Forum</a>. Please
                        discuss and post any feature ideas you have there so that we can all discuss and extend them...
                        <br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <strong><a name="getadded">What kind of features get added?</a></strong><br><br>
                        Pretty much anything that sounds cool, is original, or useful. I've added lots of feature that I don't need at all, all in an
                        effort to make Jinzora the best web-based media streamer anywhere. Don't be shy, if you want it just ask, you may just get it!
                        <br><br><br>
                    </td>
                </tr>
            </table>
            <br><br><br><br><br><br><br><br><br><br><br><br>
            <br><br><br><br><br><br><br><br><br><br><br><br>
            <br><br><br><br><br><br><br><br><br><br><br><br>
        </td>
    </tr>
</table>
</body>

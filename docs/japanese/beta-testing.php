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
            <strong>Beta Testing</strong><br>
            <br>
            So you wanna be a beta tester? It's the beta testers that help the most in making Jinzora
            what it is. Your feedback is invaluable to make the project as good as it can be.<br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><strong>Requirements</strong></li>
                    </td>
                    <td width="70%" class="bodyBody">
                        The requirements of you are very simple, download beta releases and test them. That's it! We'll
                        ask that you fill out a quick questionaire so we know how you'll be testing, and we'll drop you an email
                        when we feel that the time is right for testing. There is NO formal testing process that we ask you to
                        follow, we simply ask you to use Jinzora in the normal way you do and report any issues you find in our
                        <a href="http://www.jinzora.org/modules.php?op=modload&name=XForum&file=forumdisplay&fid=13" target="_blank">Beta Testers Forum</a>
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><strong>Joining In</strong></li>
                    </td>
                    <td width="70%" class="bodyBody">
                        Ok, so that sounds easy enough and you'd like to join in, huh? Check out our <a href="http://www.jinzora.org/modules.php?op=modload&name=XForum&file=viewthread&tid=81" target="_blank">Beta Testers Info Forum</a>
                        for all the details that we'll need so you can join in, and thanks!!!
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

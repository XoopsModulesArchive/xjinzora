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
            <strong>Standard Technical Support</strong>
            <br><br>
            There are several options available for standard technical support, they are:
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="1%" class="bodyBody" valign="top">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="http://www.jinzora.org/modules.php?op=modload&name=jz_docs&file=index" target="_blank">Online Documentation</a><br>
                        We've spent quite a bit of time putting together this documentation and the documentation on the Jinzora web site. It should be
                        a very good reference for most things Jinzora. If you find it lacking something you're looking for please let us
                        know in the support forums so we can get it fixed!<br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" class="bodyBody" valign="top">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="http://www.jinzora.org/modules.php?op=modload&name=XForum&file=index" target="_blank">Jinzora Support Forums</a><br>
                        We pride ourselves on our exceptionally quick responses to our forum posts. If you got a question by all means ask it, we'll do
                        our best to get back to you as quickly as possible!
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" class="bodyBody" valign="top">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="http://www.jinzora.org/modules.php?op=modload&name=Changelog&file=index" target="_blank">Jinzora Changelog</a><br>
                        Curious about changes in Jinzora? Wonder what happened to your favorite feature? Check out our Changelog and keep up with
                        what we've got going on...
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" class="bodyBody" valign="top">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="http://www.jinzora.org/modules.php?op=modload&name=jz_bugs&file=index" target="_blank">Jinzora Bug list</a><br>
                        Swear you've found a bug? Wanna know if we know about it? While we do our best to test Jinzora as much as possible there are
                        unfortunately times when even we get it wrong! Check out our active Bug List to see if we know about your issue first!
                        <br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

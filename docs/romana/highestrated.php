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
            <strong>Highest Rated Newsfeed</strong>
            <br><br>
            Jinzora can generate RSS newsfeeds that can be used in many applications. One
            use of these would be to create "Blocks" in CMS systems, or to export
            data to any other type of news based application.
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <strong>Using</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Using the Highest Rated newsfeed is rather simple. Simply point your RSS client
                        (wether it is web based - CMS - or a standard client) at the full path to Jinzora
                        at:
                        <br><br>
                        jinzora/toprated-rss.php
                        <br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

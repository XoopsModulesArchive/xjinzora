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
            <b>Request Counting</b>
            <br><br>
            One of the Groupware features of Jinzora is request counting. This allows Jinzora
            to track how many times a track has been requested from Jinzora.
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <b>Enabling</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        There are a few things you'll need to do to enable request counting. You can choose the
                        "workgroup" install type during installation, which will set the proper options, or make sure
                        that:<br><br>
                        $track_plays = "true";
                        <br><br>
                        In your settings.php file.
                        <br><br>
                        You'll also need to make sure that you've created the "data" directory (under the
                        root directory of Jinzora) and that the webserver user has write access to this directory.
                        This directory stores all the data files that are needed for discussions.
                        <br><br>
                        You can also have Jinzora display the top 5 requested tracks on the home page by setting this
                        in settings.php:
                        <br><br>
                        $num_most_played = "5";
                        <br><br>
                        That would tell Jinzora to display the top 5 most requested tracks on the home page
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <b>Using<br>Counting</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        Using request counting is simple, Jinzora does it for you!
                        <br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

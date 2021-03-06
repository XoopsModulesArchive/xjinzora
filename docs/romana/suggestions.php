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
            <strong>Jinzora Suggests</strong>
            <br><br>
            One of the Groupware features of Jinzora is Jinzora Suggestions. This allows Jinzora
            to suggest tracks to users based on their common ratings.
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <strong>Enabling</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        There are a few things you'll need to do to enable Jinzora Suggestions. You can choose the
                        "workgroup" install type during installation, which will set the proper options, or make sure
                        that:<br><br>
                        $enable_suggestions = "true";
                        <br><br>
                        In your settings.php file.
                        <br><br>
                        You'll also need to make sure that you've created the "data" directory (under the
                        root directory of Jinzora) and that the webserver user has write access to this directory.
                        This directory stores all the data files that are needed for discussions.
                        <br><br>
                        You can set how many tracks Jinzora will suggest for a user by settings:
                        <br><br>
                        <strong>$num_most_played = "5";</strong>
                        <br><br>
                        That would tell Jinzora to display 5 suggestions to each user.
                        <br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

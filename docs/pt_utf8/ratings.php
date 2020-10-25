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
            <b>Ratings</b>
            <br><br>
            One of the Groupware features of Jinzora is ratings. This allows users to
            to enter their own ratings of any item in Jinzora (Genres/Artist/Albums/Tracks).
            Users can only rate once, based on either their logged in username or their
            IP Address.
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <b>Enabling</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        There are a few things you'll need to do to enable ratings. You can choose the
                        "workgroup" install type during installation, which will set the proper options, or make sure
                        that:<br><br>
                        $enable_ratings = "true";
                        <br><br>
                        In your settings.php file.
                        <br><br>
                        You'll also need to make sure that you've created the "data" directory (under the
                        root directory of Jinzora) and that the webserver user has write access to this directory.
                        This directory stores all the data files that are needed for ratings.
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <b>Using<br>Ratings</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        To use Ratings all you need to do is click the "Rate Item" icon (star) next to the item you'd
                        like to enter a rating for.
                        <br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

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
            <strong>User Manager</strong><br>
            <br>
            Jinzora can be used in a multi-user environemt, with different users having
            different rights. You create and edit users in the "User Manager" in the
            Jinzora "Tools" section. There are 5 user types, they are:
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong>No Access</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        This is really only relavant for the default level of access. When the
                        default level is set to "noaccess" Jinzora will always direct un-logged in
                        users to the login page.
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong>View Only</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        View Only users (viewonly) can only view tracks, not play or download them.
                        This is the most limited user type.
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong>Standard Users</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Standard Users (user) can view all tracks, can play tracks, and can create
                        and store playlists.
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong>Power Users</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Power Users (poweruser) can view all tracks, can play tracks, and can create
                        and store playlists. They can also download tracks (unless that is disabled globally)
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong>Admin Users</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Admin Users (admin) can view all tracks, can play tracks, and can create
                        and store playlists. They can also download tracks (even if that is disabled globally)
                        and they can access the "Tools" section. They can also auto-download album art
                        (or manually search for and save album art)
                        <br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

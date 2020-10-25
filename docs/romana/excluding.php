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
            <strong>Excluding Items</strong>
            <br><br>
            In Jinzora you can "Exclude" or "Hide" Genres or Artists from view. This does not
            delete the Genre or Artists, but rather just hides it from all view.
            This was added to help in multi-user enviornments.
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <strong>Per User</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Items can be excluded on a per-user basis. So each user that is logged in
                        need only click the info button (generally a ?) next to the item they'd
                        like to exclude and click "Exclude Genre (or Artist)".
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <strong>Global</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Items can be globally excluded so they are hidden from all users. This can be done 2 ways:
                        <br><br>
                        1. When logged in as admin (the acutal admin username)<br><br>
                        2. By creating the file global-exclude.lst (to be located within the temp/ directory relative
                        to Jinzora). Any match in this file (it is case sensitive) will be excluded from view
                        <br><br><br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

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
            <strong>Searching</strong><br>
            <br>
            It is possible to search all of the items within Jinzora. You must be logged in a something other
            than a viewonly user to use this function however. When searching there are a few things to know:
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="1%" class="bodyBody" valign="top">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        All searches are case in-sensitive<br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" class="bodyBody" valign="top">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        Searching matches on all media files and directories within Jinzora<br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" class="bodyBody" valign="top">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        Searching uses the cached information, so changes will not be searched against
                        until the cache is refreshed<br><br>
                    </td>
                </tr>
            </table>
            <br><br>
        </td>
    </tr>
</table>
</body>

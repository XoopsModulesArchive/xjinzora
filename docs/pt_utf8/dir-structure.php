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
            <b>Directory Structure</b>
            <br><br>
            There are several different directory structures that will work well with Jinzora.
            While none of these are a requirement, they are STRONGLY recommended. Let's face it,
            if your collection is terribly unorganized it will be hard for Jinzora to organize it for you,
            right? The more time you spend organizing your collection the better Jinzora will work for you.
            The 3 supported structures are:<br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <b>Genre Mode</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        In Genre mode Jinzora assumes that your media will generally follow the structure of:
                        <br><br>
                        Genre Folder/Artist Folder/Album Folder/Tracks
                        <br><br>
                        While Jinzora will display any track it finds along the way, it will expect that most
                        items will be found in this structure and will use it to display the different style pages.
                        <br><br>
                        <b>NOTE:</b> This is how the primary developer uses Jinzora, therefor it will be
                        the most tested and primarially focues on.
                        <br><br>
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <b>Artist Mode</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        In Artist mode Jinzora assumes that your media will generally follow the structure of:
                        <br><br>
                        Artist Folder/Album Folder/Tracks
                        <br><br>
                        While Jinzora will display any track it finds along the way, it will expect that most
                        items will be found in this structure and will use it to display the different style pages.
                        <br><br>
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <b>Album Mode</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        In Album mode Jinzora assumes that your media will generally follow the structure of:
                        <br><br>
                        Album Folder/Tracks
                        <br><br>
                        While Jinzora will display any track it finds along the way, it will expect that most
                        items will be found in this structure and will use it to display the different style pages.
                        <br><br>
                        <b>NOTE:</b> This is most definetly the least tested structure!
                        <br><br>
                        <br><br>
                    </td>
                </tr>
            </table>
            <br><br>
        </td>
    </tr>
</table>
</body>

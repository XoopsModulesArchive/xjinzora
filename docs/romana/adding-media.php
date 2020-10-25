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
            <strong>Adding Media to Jinzora</strong>
            <br><br>
            You have many different choices for adding media to Jinzora, a few are:
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <strong>Upload Manager</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        The "Upload Manager" on the "Tools" page can let you upload entire
                        albums through the web interface. If you wish you can upload a single ZIP
                        file (.tar.gz is not supported) and Jinzora will create the appropriate directories
                        and un-zip the file for you, creating all the tracks.<br>
                        <strong>NOTE:</strong> There are many issues that this brings up with the different
                        web servers and the amount of data that can be uploaded to them. This is not
                        a 100% reliable system and should be tested in your enviornment before general use.
                        <br><br>
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <strong>FTP/SCP<br>SFTP/SMB/etc...</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        There are many, many other ways that you could load media into Jinzora. Remember that
                        Jinzora simple reads the data within your $media_dir to find what it needs. All you need
                        to do is create files and folders within there and it will all be displayed by Jinzora. You could
                        use just about any method to do this, pick the one that's easiest for you!
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

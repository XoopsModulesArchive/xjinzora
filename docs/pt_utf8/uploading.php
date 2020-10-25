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
            <b>Upload Manager</b><br>
            <br>
            There are many ways to add media to Jinzora. One of these that we've included for you is the Jinzora
            Upload Manager. The Upload Manager is a Java based Applet that will need a client JVM to be installed
            to function properly.
            <br><br>
            We recommend using the Sun JVM which can be downloaded HERE
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <b>Uploading</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        Uploading media is simple. To access the Upload Manager you must be logged in as
                        an Admin in Jinzora. When logged in with admin privs click on "Tools" then on "Upload Manager".
                        <br><br>
                        Once in the upload manager all you need to do is:<br>
                        Click on "Select Destination" to browse a location on the server whe you'd like to put the media. If the folder you'd
                        like to put the media in doesn't exist simply put that new path in the select box.
                        <br>
                        <b>NOTE:</b> Do not put the full path of where you'd like it to go, but rather a relative path on the server
                        to the root of your media ("music" by default) directory
                        <br>
                        Click "Add files" at the bottom of the applet to browse for the files you'd like to upload. Be aware that any upload limits
                        that are in place with Apache or PHP apply to this upload. We've also experience issues with large uploads (10+ files or 100+ MB).
                        You may wish to break up your uploads.
                        <br>
                        Click "Upload" and you'll files will begin uploading. The status bars will show you percent complete and the transfer rate of the
                        uploads in real time. You will be notified with the uploads are complete.
                        <br><br>
                        Remember that you'll need to update the cache so that the media will show in Jinzora after you complete your upload.
                        <br><br><br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

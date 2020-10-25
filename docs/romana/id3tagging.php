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
            <strong>ID3 Tagging in Jinzora</strong><br>
            <br>
            We feel that one of the things that really sets Jinzora apart are it's bulk ID3 tagging tools/features.
            While they are pretty simple, there are a few things to point out. To access the ID3 tagging tools you'll
            need to be logged in with Admin level access and go to the "Tools" page. Then click on either "Update ID3v1 Tags" or
            "Strip all ID3v1 tags".
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong>Updating</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        When you use Jinzora to update ID3 tags you can specify what tags are written to the files. The tags
                        that Jinzora can write are:
                        <br><br>
                        <strong>Genre</strong><br>
                        <strong>Artist Name</strong><br>
                        <strong>Album Name</strong><br>
                        <strong>Track Name</strong><br>
                        <strong>Track Number</strong><br>
                        <br>
                        Jinzora writes this data based on the information it finds in the file system. For example if a file
                        was located at:
                        <br><br>
                        Jazz/Miles Davis/Kind of Blue/01 - So What.mp3
                        <br><br>
                        It would be written as:
                        <strong>Genre:</strong> Jazz<br>
                        <strong>Artist Name:</strong> Miles Davis<br>
                        <strong>Album Name:</strong> Kind of Blue<br>
                        <strong>Track Name:</strong> So What<br>
                        <strong>Track Number:</strong> 01<br>
                        <br><br>
                        Jinzora will go through you're collection, one by one, writing this data as it goes (so on a large
                        collection this can obviously take some time...)
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong>Stripping</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        You can also use Jinzora to strip the ID3 tags of the files if you wish. The tags
                        that Jinzora can strip are:
                        <br><br>
                        <strong>Genre</strong><br>
                        <strong>Artist Name</strong><br>
                        <strong>Album Name</strong><br>
                        <strong>Track Name</strong><br>
                        <strong>Track Number</strong><br>
                        <br>
                        When you tell Jinzora to strip the data off the files, it will only strip what you specify, nothing more.
                        Basically it just replaces the data in the tag with "" or nothing...
                        <br><br><br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

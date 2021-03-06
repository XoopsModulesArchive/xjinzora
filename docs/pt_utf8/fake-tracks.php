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
            <b>Fake Tracks</b>
            <br><br>
            Jinzora can display "Fake" tracks. The purpose of this would be if you
            wanted to list some tracks by an artists, but not all, for demo purposes.
            This would allow you to show some sample tracks, then the names of the other
            tracks, so that users would know there are other trakcs available to them
            <br><br>
            When using fake tracks, all you need to do is create a file called:<br><br>
            <b>Full Track Name.fake.txt</b><br><br>
            Jinzora will then display that track as:<br><br>
            <b>Full Track Name</b><br><br>
            And it will use the contents of the file for the description (so a seperate
            description file is not necessary). Obvisouly no play, download, or add to playlist
            icons will appear next to a .fake track
            <br><br><br><br>
        </td>
    </tr>
    <tr>
        <td width="100%" class="bodyBody">
            <b>Fake Linked Tracks</b>
            <br><br>
            Jinzora can also display "Fake" tracks that are really links to anywhere you want.
            This could be useful if you wanted to use Jinzora to catalog links to streaming
            radio stations or to media that is not on your site.
            <br><br>
            When using fake link tracks, all you need to do is create a file called:<br><br>
            <b>Full Track Name.fake.lnk</b><br><br>
            Jinzora will then display that track as:<br><br>
            <b>Full Track Name</b><br><br>
            The contents of the file MUST match the following format:<br><br>
            Description: This is the description text that will show<br>
            Link: http://www.jinzora.org
            <br><br>
            Even if you do not want a description you MUST put the line in the file.
            <br><br><br><br>
        </td>
    </tr>
</table>
</body>

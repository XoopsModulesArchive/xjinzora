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
            <strong>Lo-Fi Files</strong><br>
            <br>
            There may be times in which you'd like to present your user with "lo-fi" files. These would be smaller, much lower
            quality files that a "lofi" user could stream (more on that later). All you need to do is create a file with the lower
            encoding settings (say 32k for an MP3 vs 128k) and name it:
            <br><br>
            Track Name.lofi.mp3
            <br><br>
            And Jinzora will display the lofi icon for it. If there is a file with the EXACT same name (other than the .lofi) it will be
            displayed with the lofi file.
            <br><br>
            You can also set your default user permissions to "lofi" so that default users would only be able to stream the .lofi files.
            <br><br>
            <strong>Creating Lo-Fi Files</strong>
            <br>
            Jinzora can easily create Lo-Fi files for you. To do this you'll need to have the LAME encoder installed on your machine.
            You can get the LAME encoder at: <a href="http://lame.sourceforge.net/" target="_blank">http://lame.sourceforge.net/</a>
            <br><br>
            To use the LAME encoder to create Lo-Fi files you'll need to edit "system.php" and make sure that:
            <br><br>
            $lame_opts = "/usr/local/bin/lame -a -b 32 --mp3input --resample 22.05 ";
            <br><br>
            Is set with the options you'd like, and that the path is correct. You can find details on what options are available on the
            LAME site at <a href="http://lame.sourceforge.net/USAGE" target="_blank">http://lame.sourceforge.net/USAGE</a>
            <br><br>
            Once you have "system.php" setup properly, all you need to do is (as an Admin user) click the Info "?" button next to a track.
            In this window you'll see the "Create Lo-Fi" button (if the permissions check out correctly), and if a Lo-Fi file exists
            you'll see the "Delete Lo-Fi" button, so you can clean them up if you wish. Don't forget to rewrite the ID3 tags on the
            track after you've created it, as it will be blank at first.
        </td>
    </tr>
</table>
</body>

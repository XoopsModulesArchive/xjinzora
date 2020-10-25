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
            <strong>File Caching</strong>
            <br><br>
            Jinzora employes a file caching system to make the displaying of data significantly faster
            than conventional methods. There really are 2 options to reading the data, using a database
            or reading the filesystem. We've decided to keep things as simple as possible and to just read
            the file system to get the data, but in systems with lots of music and folders this can be slow.
            So we've create a file caching system to speed this up.
            <br><br>
            <strong>How it works:</strong>
            <br>
            This first time you load index.php Jinzora reads your media dir and create several PHP Session variables
            for later use in the system. While this initial load can be a bit slow on big sites, the subsequent
            speed improvements more than make up for it. There is one problem with caching though. If you add
            files to your collection you'll need to either restart your browser (yes, lame, we know...) or go to
            "Tools" - "Update Cache" to recreate this cache. This is the single biggest problem with live caching, but
            we feel that the ends justify the means in this case.
            <br><br>
        </td>
    </tr>
</table>
</body>

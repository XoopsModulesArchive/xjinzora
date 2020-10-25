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
            <b>Configuring Slimzora</b><br>
            <br>
            Slimzora is rather easy to configure. By default it will take many settings from your settings.php
            file, and there are several things that are set by default to make Slimzora work a little more smoothly.
            <br><br>
            If you want to over ride these settings you can either modify slim.php or you can create:
            <br><br>
            slim.prefs.php
            and put the settings in there. The file needs to be a standard PHP file so it should start with
            <br><br>
            &lt;?php
            <br><br>
            and end with
            <br><br>
            ?&gt
            <br><br>
            See "slim.php" for all the possible settings that can go in this file. Why would you want to create this file
            when you can just edit "slim.php"? Well because when you upgrade "slim.php" will be over written, but the "slim.prefs.php"
            file won't!
        </td>
    </tr>
</table>
</body>

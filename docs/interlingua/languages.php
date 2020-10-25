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
            <strong>Languages</strong>
            <br><br>
            Jinzora has been designed to be fully multi-lingual. Currently the following
            language files are included:
            <br><br>
            <li>English</li>
            <li>Arabic</li>
            <li>Chiense Traditional</li>
            <li>Dutch</li>
            <li>French</li>
            <li>German</li>
            <li>Spanish</li>
            <li>Swedish</li>
            <br><br>
            Most of these language files have been contributed by our members, but some have been done
            using www.freetranslations.com to get the ball rolling. If you find that the translation
            that you'd like to use sucks, please don't laugh at us, just please fix it up and send it to us!
            <br><br>
            For more information on translations please contact us at:<br><br>
            <a href="mailto:ross@jinzora.org">ross@jinzora.org</a>
        </td>
    </tr>
</table>
</body>

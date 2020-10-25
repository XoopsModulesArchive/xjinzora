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
            <strong>Configurations acceptées à notre connaissance</strong>
            <br><br>
            The environements suivants fonctionnent à notre connaissance:<br><br>
            <li>RedHat Linux 7.3/Apache 1.3</li>
            <br>
            <li>RedHat Linux 8.0/Apache 2.0</li>
            <br>
            <li>Windows 2005/IIS</li>
            <br>
            <li>Windows 2000/IIS</li>
            <br>
            <li>Windows 2000/Apache 2.0</li>
            <br>
            <li>Windows 98/Apache 1.3</li>
            <br>
            <li>SuSe 8.2/Apache 1.3</li>
            <br>
            <li>OS X 10.3/Apache 2.0</li>
            <br>
            <li>Windows XP/Sambar webserver</li>
            <br>
        </td>
    </tr>
</table>
</body>

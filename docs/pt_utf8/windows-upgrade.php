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
            <b>Upgrading Jinzora on Windows Systems</b><br>
            <br>
            Upgrading Jinzora on Windows systems is very simple. All you need to do is to
            download the latest version of Jinzora and go through the install guide. Jinzora is
            designed to import your old settings file and to walk you through the upgrade
            process (the exact same process as the install). So to upgrade Jinzora please
            see the appropriate Installation Guide:<br><br>
            <b>NOTE:</b><br>
            When upgrading from versions prior to 0.9.5 you'll need to migrate the data in your
            "data" directory. You'll need to move the following files into the following directories:<br><br>
            *.rating = "data/ratings"<br>
            *.disc = "data/discussions"<br>
            .ctr = "data/counter"<br>
            <br><br>
            <li><a href="standalone.php" target="Body">Standalone Install</a></li>
            <br>
            <li><a href="postnuke.php" target="Body">Postnuke Install</a></li>
            <br>
            <li><a href="phpnuke.php" target="Body">PHPNuke Install</a></li>
            <br>
            <li><a href="ftponly.php" target="Body">FTP Only Install</a></li>
            <br>
            <br><br>
        </td>
    </tr>
</table>
</body>

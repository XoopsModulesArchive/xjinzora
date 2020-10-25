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
            <strong>Fichiers Vidéo</strong><br>
            <br>
            Jinzora peut également diffuser des vidéos. Les règles pour
            cela sont plutôt simples, Jinzora devrait être capable de
            diffuser n'importe quel format vidéo diffusable par HTTP. Les
            formats suivants ont été testés et marchent à notre connaissance:
            <br><br>
            <li><strong>MPG|MPEG</strong> (1 et 2)</li>
            <li><strong>WMV</strong> (Windows Media Video)</li>
            <li><strong>AVI</strong></li>
            <li><strong>RM</strong> (Real Media)</li>
        </td>
    </tr>
</table>
</body>

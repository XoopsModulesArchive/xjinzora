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
            <strong>Thèmes</strong>
            <br><br>
            Jinzora est complètement personnalisable. Vous pouvez changer n'importe quelle icône ou couleur n'importe où dans le système (les changements de mise en page ne sont pour l'instant pas possibles). Il y a plusieurs thèmes inclus avec Jinzora, gracieusement donnés par nos membres (merci
            encore Frank!).
            <br><br>
            <strong>Développement de Thème</strong>
            <br>
            Si vous êtes intéressés par le développement de thème pour Jinzora, nous avons créé un guide de développement de thème ainsi qu'un forum pour discuter du développement de thèmes. Ils sont :
            <br><br>
            <a href="http://www.jinzora.org/modules.php?op=modload&name=jz_docs&file=eng-theme" target="_blank">Theme Development Guide (Anglais)</a><br><br>
            <a href="http://www.jinzora.org/modules.php?op=modload&name=XForum&file=forumdisplay&fid=12" target="_blank">Theme Development Forum (Anglais)</a><br>
            <br><br>
        </td>
    </tr>
</table>
</body>

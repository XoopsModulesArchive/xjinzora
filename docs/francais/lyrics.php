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
            <strong>Fichiers de paroles</strong></strong>
            <br><br>
            Si vous voulez, Jinzora peut afficher un lien vers les paroles d'une piste.
            C'est un lien très simple, qui renvois seulement au fichier .txt sur le
            serveur afin de l'afficher. Pour ajouter un liens à un fichier, vous devez
            créer un fichier .lyrics.txt avec EXACTEMENT le même nom que la piste. Par exemple:
            <br><br>
            01 - All Blues.mp3
            <br><br>
            Serait:
            <br><br>
            01 - All Blues.lyrics.txt
            <br><br>
            Un lien " - Paroles" apparaîtrait alors à coté de la piste.
        </td>
    </tr>
</table>
</body>

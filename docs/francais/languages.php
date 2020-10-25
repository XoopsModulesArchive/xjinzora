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
            <strong>Langages</strong>
            <br><br>
            Jinzora a été étudié pour être complètement multilangue. En ce moment, les fichiers
            de langue suivant sont inclus:
            <br><br>
            <li>Anglais (English)</li>
            <li>Arabe (Arabic)</li>
            <li>Chinois traditionnel (Chinese Traditional)</li>
            <li>Hollandais (Dutch)</li>
            <li>Français (French)</li>
            <li>Allemand (German)</li>
            <li>Espagnol (Spanish)</li>
            <li>Suédois (Swedish)</li>
            <br><br>
            La plupart de ces fichiers de langues ont été donnés par nos membre, mais certains ont été créés
            en utilisant www.freetranslations.com pour donner le coup d'envoi. Si vous trouvez que la traduction
            que vous voudriez utiliser est mauvaise, s'il vous plaît ne vous moquez pas, améliorez la et envoyez la nous!
            <br><br>
            Pour plus d'information sur les traductions, merci de nous contacter à:<br><br>
            <a href="mailto:jinzora@jasbone.com">Jinzora@jasbone.com</a>
        </td>
    </tr>
</table>
</body>

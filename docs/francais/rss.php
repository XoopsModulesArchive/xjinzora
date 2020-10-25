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
            <strong>Les "RSS Newsfeeds" de Jinzora</strong><br>
            <br>
            Il y a de nombreux "RSS Newsfeeds" inclus dans Jinzora. Ils sont:
            <br><br>
            <li><strong>Derniers joués</strong> (last-played)</li>
            <li><strong>Plus joués</strong> (most-played)</li>
            <li><strong>Derniers notés</strong> (last-rated)</li>
            <li><strong>Plus notés</strong> (most-rated)</li>
            <li><strong>Mieux notés</strong> (top-rated)</li>
            <li><strong>Derniers ajoutés</strong> (last-added)</li>
            <li><strong>Derniers discutés</strong> (last-discussed)</li>
            <li><strong>Plus discutés</strong> (most-discussed)</li>
            <br>
            Pour utiliser ces "newsfeed", pointer simplement votre navigateur à l'endroit où Jinzora est installé, mais au lieu d'utiliser index.php, utilisez rss.php?type=XXX (où XXX est le type de "newsfeed" que vous voulez voir, comme donné entre parenthèses). Par example, pour lire le "newsfeed"
            des morceaux les plus joués depuis le site Jinzora, vous utiliseriez:<br><br>
            <a href="http://www.jinzora.org/modules/jinzora/rss.php?type=most-played">http://www.jinzora.org/modules/jinzora/rss.php?type=most-played</a>
            <br><br><br><br><br>
        </td>
    </tr>
</table>
</body>

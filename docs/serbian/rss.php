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
            <strong>The Jinzora RSS Newsfeeds</strong><br>
            <br>
            There are several RSS Newsfeeds that are built into Jinzora. They are:
            <br><br>
            <li><strong>Last Played</strong> (last-played)</li>
            <li><strong>Most Played</strong> (most-played)</li>
            <li><strong>Last Rated</strong> (last-rated)</li>
            <li><strong>Most Rated</strong> (most-rated)</li>
            <li><strong>Top Rated</strong> (top-rated)</li>
            <li><strong>Last Added</strong> (last-added)</li>
            <li><strong>Last Discussed</strong> (last-discussed)</li>
            <li><strong>Most Discussed</strong> (most-discussed)</li>
            <li><strong>Most Downloaded</strong> (most-downloaded)</li>
            <li><strong>Last Downloaded</strong> (most-downloaded)</li>
            <br>
            To use these newsfeed simply point your reader to the location where Jinzora is installed, but
            instead of pointing to index.php point to rss.php?type=XXX (where XXX is the type of feed you'd like
            to see, as defined above in the parathenses) As an example, to read the Most Played newsfeed from the
            Jinzora website you would use:<br><br>
            <a href="http://www.jinzora.org/modules/jinzora/rss.php?type=most-played">http://www.jinzora.org/modules/jinzora/rss.php?type=most-played</a>
            <br><br><br><br><br>
        </td>
    </tr>
</table>
</body>

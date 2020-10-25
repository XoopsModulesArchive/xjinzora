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
            <b>The Jinzora RSS Newsfeeds</b><br>
            <br>
            There are several RSS Newsfeeds that are built into Jinzora. They are:
            <br><br>
            <li><b>Last Played</b> (last-played)</li>
            <li><b>Most Played</b> (most-played)</li>
            <li><b>Last Rated</b> (last-rated)</li>
            <li><b>Most Rated</b> (most-rated)</li>
            <li><b>Top Rated</b> (top-rated)</li>
            <li><b>Last Added</b> (last-added)</li>
            <li><b>Last Discussed</b> (last-discussed)</li>
            <li><b>Most Discussed</b> (most-discussed)</li>
            <li><b>Most Downloaded</b> (most-downloaded)</li>
            <li><b>Last Downloaded</b> (most-downloaded)</li>
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

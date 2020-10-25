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
            <strong>Sorting By Year</strong>
            <br><br>
            If you like, you can have Jinzora sort your albums by the year they were released, if that
            information if available in the meta tag in the files in the album folder (usually the ID3 year
            tag). Jinzora will read the first file that it finds year information for withing each album
            folder and use that data to display the year information. Jinzora will then sort the
            albums by year, with any albums that do not have year information appearing after this in
            alphabetical order, like this:
            <br><br>
            <img src="images/sort-year.gif">

            <br><br><br><br>
        </td>
    </tr>
</table>
</body>

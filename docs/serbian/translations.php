<?php

// Let's modify the include path for Jinzora
ini_set('include_path', '.');

// Let's include the main, user settings file
require_once dirname(__DIR__, 2) . '/settings.php';
require_once dirname(__DIR__, 2) . '/system.php';

// Let's output the style sheets
echo "<link rel=\"stylesheet\" href=\"$root_dir/docs/default.css?" . time() . '" type="text/css">';

?>

<body class="bodyBody">
<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td width="100%" class="bodyBody">
            <strong>Translations</strong><br>
            <br>
            Speak another language other than English? Use one of our translations that sucks? Please help us
            translate Jinzora into your native language and share that translations with others!<br><br>
            Helping us translate Jinzora should be very easy (we hope anyway). The process is very simple, you just need
            to download our reference English file and translate away. Once you've completed your translation please contact us
            at <a href="mailto:ross@jinzora.org">ross@jinzora.org</a> so we can add your translation to the project and
            credit you in the project.<br><br>
            The first place to start is with the reference language file. You can access the most current version of it
            in our Web based CVS, at the link below. Just click on the highest version number of it in the CVS, as that's the most
            current file. We'll contact you for changes in the future (if that's ok...) so we can keep them up to date.
            <br><br>
            <a href="http://www.jinzora.org/cvs/viewcvs.cgi/jinzora/lang/english.php" target="_blank">CVS of English Language File</a>
        </td>
    </tr>
</table>
</body>

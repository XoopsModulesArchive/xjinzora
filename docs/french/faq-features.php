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
            <strong>Proposer des fonctionnalit&eacute;s </strong>:<br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#request">Comment puis-je proposer/soumettre &agrave; d&eacute;bat une nouvelle fonctionnalit&eacute; que je voudrais voir int&eacute;gr&eacute; &agrave; Jinzora?</a><br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#getadded">Quelles fonctionnalit&eacute;s peuvent &ecirc;tre ajout&eacute;es?</a><br>
                        <br></td>
                </tr>
            </table>
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <strong><a name="request">Comment puis-je proposer/soumettre &agrave; d&eacute;bat une nouvelle fonctionnalit&eacute; que je voudrais voir int&eacute;gr&eacute; &agrave; Jinzora?</a></strong><br>
                        <br>
                        By visiting my <a href="http://www.jinzora.org/modules.php?op=modload&name=XForum&file=forumdisplay&fid=4">Feature Request Forum</a>. Please
                        discuss and post any feature ideas you have there so that we can all discuss and extend them...
                        <br><br><br></td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <strong><a name="getadded">Quelles fonctionnalit&eacute;s peuvent &ecirc;tre ajout&eacute;es?--What kind of features get added?</a></strong><br>
                        <br>
                        A peu pr&egrave;s tout ce qui &agrave; l'air sympa, original, ou utile. J'ai rajout&eacute; de nombreuses choses dont je ne me sers pas personnellement, un effort pour l'adapter &agrave; vos besoins, et pourquoi pas pour que Jinzora devienne le meilleur streamer de m&eacute;dias
                        jamais vu. Ne soyez pas timide, si vous voulez quelque chose demandez-le, vous risqueriez bien de voir vos voeux exauc&eacute;s!<br>
                        <br><br></td>
                </tr>
            </table>
            <br><br><br><br><br><br><br><br><br><br><br><br>
            <br><br><br><br><br><br><br><br><br><br><br><br>
            <br><br><br><br><br><br><br><br><br><br><br><br>
        </td>
    </tr>
</table>
</body>

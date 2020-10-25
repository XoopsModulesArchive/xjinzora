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

        <td width="100%" class="bodyBody"><strong> Informations sur les D&eacute;veloppeurs</strong><br>
            <br>
            Alors, vous voulez nous aider? Hmm? Il y plusieurs fa&ccedil;ons de contribuer
            au projet. Quelques trucs &agrave; noter:<br>
            <br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><strong>Acc&egrave;s au CVS</strong></li>
                    </td>

                    <td width="70%" class="bodyBody"> Le code source de Jinzora est accessible
                        via CVS et aussi via le <a href="http://www.jinzora.org/modules.php?op=modload&name=jz_tools&file=webcvs" target="_blank">Site
                            Officiel Jinzora</a>. Des instructions pour acc&eacute;der &agrave;
                        l'arborescence CVS avec un compte &quot;anonyme&quot; sont disponibles
                        <a href="http://www.jinzora.org/modules.php?op=modload&name=jz_tools&file=webcvs" target="_blank">ici</a>.
                        <br>
                        <br>
                        Si vous voulez rejoindre l'&eacute;quipe des d&eacute;veloppeurs et
                        disposer de droits en &eacute;criture sur le CVS, svp contactez nous
                        &agrave;: <a href="mailto:jinzora@jasbone.com">jinzora@jasbone.com</a>
                        , nous pourrons alors nous entretenir avec vous. <br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><strong>Une id&eacute;e de code ?</strong></li>
                    </td>

                    <td width="70%" class="bodyBody"> Vous avez simplement une id&eacute;e
                        de code que vous voulez partager avec nous? Rejoignez le <a href="http://www.jinzora.org/modules.php?op=modload&name=XForum&file=forumdisplay&fid=14" target="_blank">Forum
                            des d&eacute;veloppeurs</a> o&ugrave; nous pourrons tous en d&eacute;battre!
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

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
            <p><strong>Exclure certains &eacute;l&eacute;ments</strong>
                <br>
                <br>
                Jinzora vous permet &quot;d'exclure&quot;, ou de cacher, de la vue courante de votre navigateur certains genres ou artistes. Ceci n'efface en rien vos fichiers, mais ne fait que les rendre invisibles dans votre liste, et ce dans le but d'&ecirc;tre utilis&eacute; dans un
                environnement multi-utilisateurs.</p>
            <br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <strong>M&eacute;thode par utilisateur</strong></td>
                    <td width="70%" class="bodyBody">
                        Vous pouvez cacher des &eacute;l&eacute;ments de certaines personnes. De telle fa&ccedil;on qu'un utilisateur logu&eacute; n'aura qu'&agrave; cliquer sur le bouton &quot;info&quot; (g&eacute;n&eacute;ralement un point d'interrogation) &agrave; c&ocirc;t&eacute; de l'&eacute;l&eacute;ment
                        s&eacute;lectionn&eacute; pour s&eacute;lectionner l'option.&quot;Exclure genre&quot; (ou artiste).<br>
                        <br><br><br></td>
                </tr>
                <tr>
                    <td width="30%" valign="top" class="bodyBody">
                        <strong>M&eacute;thode globale</strong></td>
                    <td width="70%" class="bodyBody">
                        Ces &eacute;l&eacute;ments peuvent aussi bien devenir invisibles pour tous les utilisateurs. Deux solutions s'offrent &agrave; nous:<br><br>
                        1. En se loguant en tant qu'administrateur (ou le login administrateur en vigueur)<br>
                        <br>
                        2. En cr&eacute;ant le fichier global-exclude.lst (doit &ecirc;tre plac&eacute; dans le dossier temp/ de Jinzora). Tout ce qui y sera list&eacute; sera exclu (attention, sensible &agrave; la casse).<br>
                        <br><br><br></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

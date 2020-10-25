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
            <p><strong>Beta Tester</strong><br>
            </p>
            <p>Vous voulez donc devenir beta testeur? Ce sont eux qui aident le plus
                Jinzora &agrave; devenir ce qu'il est. Votre feedback (commentaires, pens&eacute;es,
                etc...) est d'une valeur inestimable pour rendre le projet aussi acceptable
                que possible.<br>
                <br>
            </p>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><strong>Conditions</strong></li>
                    </td>
                    <td width="70%" class="bodyBody">
                        <p>C'est tr&egrave;s simple, vous n'avez qu'&agrave;
                            t&eacute;l&eacute;charger les versions beta et les tester.C'est
                            tout! Nous vous demandons de remplir un questionnaire pour nous
                            permettre de conna&icirc;tre votre m&eacute;thode de test, et nous
                            vous ferons parvenir un email lorsque la phase de test commencera.
                            Il n'existe AUCUNE m&eacute;thode de test que nous vous demandons
                            de suivre, nous vous demandons simplement d'utiliser Jinzora de
                            la fa&ccedil;on dont vous vous en servez habituellement et de faire
                            conna&icirc;tre les bugs d&eacute;couverts sur notre <a href="http://www.jinzora.org/modules.php?op=modload&name=XForum&file=forumdisplay&fid=13">Forum
                                des Beta Testeurs</a>.</p>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><strong>Vous joindre &agrave; nous</strong></li>
                    </td>
                    <td width="70%" class="bodyBody">
                        <p>Ok, tout ceci vous para&icirc;t suffisamment simple
                            au regard de vos comp&eacute;tences et vous voulez toujours vous
                            joindre &agrave; nous? Visitez alors notre <a href="http://www.jinzora.org/modules.php?op=modload&name=XForum&file=forumdisplay&fid=13">Forum
                                des Beta Testeurs</a> pour conna&icirc;tre tous les d&eacute;tails
                            dont nous avons besoin pour vous accueillir parmis nous. Un grand
                            merci d'avance!!!</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

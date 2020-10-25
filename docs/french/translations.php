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
            <strong>Traductions</strong><br>
            <br>
            Vous parlez une autre lange que l'Anglais? Vous utiliser une de nos traductions qui est mauvaise? S'il vous plaît aidez-nous à traduire Jinzora dans votre langue maternelle et partagez cette traduction avec d'autre!<br><br>
            Nous aider à traduire Jinzora devrait être très facile (nous espérons). Le processus est très simple, vous avez juste besoins de télécharger notre fichier de référence Anglais et le traduire. Une fois que vous avez terminé votre traduction, merci de nous contactez à <a
                    href="mailto:jinzora@jasbone.com">jinzora@jasbone.com</a> pour que nous puissions ajouter votre traduction au projet et vous attribuer les crédits.<br><br>
            Le premier endroit où démarrer est le fichier langage de référence. Vous pouvez accéder à sa version la plus récente dans notre CVS sur le web, à l'aide du liens ci-dessous. Cliquez simplement sur le numéro de version le plus élevé dans le CVS, et c'est le fichier le plus récent. Nous
            vous contacterons pour les changements futurs (avec votre accord) pour nous permettre de les tenir à jour.<br><br>
            <a href="http://www.jinzora.org/cvs/viewcvs.cgi/jinzora/lang/english.php" target="_blank">Fichier de langue Anglais dans le CVS</a>
        </td>
    </tr>
</table>
</body>

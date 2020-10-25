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
            <strong>Support Technique Standard</strong>
            <br><br>
            Il y a plusieurs options disponibles pour le support technique, elles sont:
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="1%" class="bodyBody" valign="top">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="http://www.jinzora.org/modules.php?op=modload&name=jz_docs&file=index" target="_blank">Documentation en ligne</a><br>
                        Nous avons passé pas mal de temps à écrire cette documentation et
                        la documentation sur le site web de Jinzora. Elle devrait être une
                        très bonne référence sur la plupart de Jinzora. Si vous ne trouvez
                        pas quelque chose que vous cherchez dedans, merci de nous le
                        faire savoir dans le forum de support, afin que nous corrigions
                        ce problème!<br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" class="bodyBody" valign="top">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="http://www.jinzora.org/modules.php?op=modload&name=XForum&file=index" target="_blank">Forums de Support de Jinzora</a><br>
                        Nous sommes fier de notre temps de réponse exceptionnellement cours
                        aux messages dans notre forum. Si vous avez une quelconque
                        question posez la, nous ferons de notre mieux pour vous répondre
                        le plus rapidement possible!
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" class="bodyBody" valign="top">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="http://www.jinzora.org/modules.php?op=modload&name=Changelog&file=index" target="_blank">Changelog de Jinzora</a><br>
                        Curieux des changements dans Jinzora? Vous vous demandez ce qui
                        est arrivé à votre fonctionnalité favorite? Consultez notre Changelog
                        et suivez ce que nous avons fait...
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" class="bodyBody" valign="top">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="http://www.jinzora.org/modules.php?op=modload&name=jz_bugs&file=index" target="_blank">Liste de Bug de Jinzora</a><br>
                        Vous jurez avoir trouvé un bug? Vous voulez savoir si nous
                        avons connaissance de celui-ci? Bien que nous faisions de notre
                        mieux pour tester Jinzora le plus possible, il y a
                        malheureusement certaines fois où même nous passons à côté!
                        Consultez d'abord notre liste de bugs actifs pour voir si
                        votre problème n'y figure pas!
                        <br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

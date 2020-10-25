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
            <strong>Securiser Jinzora</strong><br>
            <br>
            Il y a bien des fa&ccedil;ons d'am&eacute;liorer la s&eacute;curit&eacute; de votre Jinzora. Elle doit &ecirc;tre pens&eacute;e comme un tout plut&ocirc;t que comme un guide sp&eacute;cifique &agrave; Jinzora.<br>
            <br>
            <strong>NOTA BENE: </strong>en aucune fa&ccedil;on l'&eacute;quipe de Jinzora ne saura &ecirc;tre tenue responsable de la s&eacute;curit&eacute; de vos donn&eacute;es !!!
            <br>
            <br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong>Utilisateurs de Jinzora</strong></td>
                    <td width="70%" class="bodyBody">
                        La fa&ccedil;on la plus simple est d'utiliser des comptes d'utilisateurs avec des droits diff&eacute;rents, et de param&eacute;trer (lors de l'installation ou dans le panel d'administration) le mode par d&eacute;faut &quot;viewonly&quot; (lecture seule). Il y a 4 types de
                        comptes utilisateurs diff&eacute;rents, ils sont:<br>
                        <br>
                        <strong>Admin:</strong> a tous les droits, a la possibilit&eacute; de tout faire.
                        <br><br>
                        <strong>Power User:</strong> similaire &agrave; l'Admin, mais ne peut acc&eacute;der &agrave; la section "Tools".<br>
                        <br>
                        <strong>User:</strong> un utilisateur normal peut lire de la musique, mais PAS la t&eacute;l&eacute;charger (seuls les Power Users le peuvent)
                        <br>
                        <br>
                        <strong>View Only:</strong> &eacute;vident n'est-ce pas?
                        <br>
                        <br><br><br></td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong>S&eacute;curiser
                            Apache</strong></td>
                    <td width="70%" class="bodyBody">
                        Le meilleur moyen de s&eacute;curiser Jinzora est certainement d'utiliser les fichiers .htaccess et .htpasswd,
                        d&eacute;di&eacute;s entres autres &agrave; l'identification des utilisateurs avec Apache. Encore une fois ce guide n'est aucunement exhaustif en ce qui concerne la s&eacute;curit&eacute;, effectuez donc des recherches compl&eacute;mentaires si vous n'&ecirc;tes familier avec
                        cet aspect la. Vous voudrez certainement param&eacute;trer:<br>
                        <br>
                        $auth_value = "user:pass";
                        <br><br>
                        dans le fichier &quot;settings.php&quot;. Cette valeur sera ajout&eacute;e au d&eacute;but de chaque playlist que Jinzora g&eacute;n&egrave;rera, de fa&ccedil;on &agrave; ne pas se soucier des probl&egrave;mes d'authentification avec le player utilis&eacute;.
                        <br>
                        <br><br><br></td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong>S&eacute;curiser IIS</strong></td>
                    <td width="70%" class="bodyBody">
                        Le meilleur moyen de s&eacute;curiser Jinzora sur IIS est certainement d'activer l'authentification (comme avec Apache ci-dessus). Encore une fois ce guide n'est aucunement exhaustif en ce qui concerne la s&eacute;curit&eacute;, effectuez donc des recherches compl&eacute;mentaires
                        si vous n'&ecirc;tes familier avec cet aspect la. Vous voudrez certainement param&eacute;trer:<br>
                        <br>
                        $auth_value = "user:pass";
                        <br>
                        <br>
                        dans le fichier &quot;settings.php&quot;. Cette valeur sera ajout&eacute;e au d&eacute;but de chaque playlist que Jinzora g&eacute;n&egrave;rera, de fa&ccedil;on &agrave; ne pas se soucier des probl&egrave;mes d'authentification avec le player utilis&eacute;.<br>
                        <br><br><br></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

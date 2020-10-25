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
            <strong>Création de liens symboliques</strong><br>
            <br>
            Il y a de nombreuses situations pour lesquelles vous devez installer Jinzora sur
            un disque ou une partition, mais vos pistes sont sur un autre. Il y a quelques
            options pour résoudre ce problème, principalement la création de liens symboliques.
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong>*NIX</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        C'est vraiment le plus facile sous système *NIX. Si vous utilisez un
                        *NIX, vous savez probablement déjà comment faire ca, mais juste au cas
                        où vous ne saviez pas (hey, nous devons tous apprendre à un moment,
                        n'est-ce pas?) voilà comment:
                        <br><br>
                        Imaginez que Jinzora est installé dans:
                        <br><br>
                        /var/www/html/jinzora
                        <br><br>
                        Mais vos pistes sont dans:
                        /home/ross/music
                        <br><br>
                        Exécutez alors (une seule commande)
                        <br><br>
                        cd /var/www/html/jinzora; ln -s /home/ross/music
                        <br><br>
                        Pour créer un lien symbolique 'music' dans Jinzora. Vérifiez ensuite
                        que vous avez définit votre $media_dir = "/music"; et vous êtes prêts!
                        <br><br>
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong>Windows</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Cela était impossible sous Windows, mais finalement Microsoft nous a
                        donné les liens symboliques sous Windows! Vous aurez besoin de
                        l'outil linkd.exe (qui fait partie du 'Windows 2005 Resource Kit',
                        <a href="http://www.jinzora.org/modules.php?op=modload&name=Downloads&file=index&req=viewdownload&cid=4">
                            disponible ici</a>)
                        Il y a quelques prérequis pour que cela marche, ils sont:
                        <br><br>
                        Windows 2005 Server ou XP Pro (pour installer le 'Resource Kit' pour avoir
                        linkd.exe)<br><br>
                        TOUS les disques qui entrent en jeux DOIVENT être formatés en NTFS<br>
                        <br>
                        Par exemple:<br>
                        <br>
                        Disons que votre site est dans:<br>
                        c:\inetpub\wwwroot<br>
                        <br>
                        Et vos pistes dans:<br>
                        d:\media<br>
                        <br>
                        La ligne de commande sera:<br>
                        linkd.exe c:\inetpub\wwwroot\media d:\media<br>
                        <br>
                        Et votre $media_dir dans Jinzora sera:<br><br>
                        $media_dir = "/media";
                        <br><br>
                        <br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

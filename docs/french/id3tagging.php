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
            <strong>De l'utilisation des tags ID3 dans Jinzora</strong><br>
            <br>
            Parmi les choses qui nous font croire que Jinzora est unique, il y a ses outils pour les tags ID3. Bien qu'ils soient relativement simples, nous devons apporter certaines pr&eacute;cisions. Pour avoir acc&egrave;s &agrave; ces outils vous devrez &ecirc;tre loggu&eacute; avec des doits
            d'administrateur pour ensuite vous diriger vers la page "Tools" (outils). Cliquez ensuite sur "Update ID3v1 Tags" (mise &agrave; jour des tags) ou "Strip all ID3v1 tags" (les effacer tous).
            <br>
            <br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong>Les mettre &agrave; jour </strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Lorsque vous utilisez Jinzora pour mettre &agrave; jour vos tags, vous pouvez sp&eacute;cifier quel champ est &eacute;crit. Vous pouvez &eacute;crire les tags suivants:
                        <br>
                        <br>
                        <strong>Genre</strong><br>
                        <strong>Nom de l'artiste</strong><br>
                        <strong>Nom de l'album </strong><br>
                        <strong>Nom de la piste</strong><br>
                        <strong>Num&eacute;ro de la piste</strong><br>
                        <br>
                        Jinzora &eacute;crit ses donn&eacute;es en fonction de ce qu'il lit dans vos fichiers. Par exemple:
                        <br>
                        <br>
                        Jazz/Miles Davis/Kind of Blue/01 - So What.mp3
                        <br><br>
                        Pourrait s'&eacute;crire:<br>
                        <strong>Genre:</strong> Jazz<br>
                        <strong><strong>Nom de l'artiste</strong>:</strong> Miles Davis<br>
                        <strong><strong>Nom de l'album</strong>:</strong> Kind of Blue<br>
                        <strong><strong>Nom de la piste</strong>:</strong> So What<br>
                        <strong><strong>Num&eacute;ro de la piste</strong>:</strong> 01<br>
                        <br><br>
                        Jinzora parcourt votre collection, fichier par fichier, et &eacute;crit ces donn&eacute;es au fur et &agrave; mesure dans un fichier cache (cela prendra donc un temps proportionnel &agrave; la taille de votre collection...)
                        <br>
                        <br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong>Les effacer</strong></td>
                    <td width="70%" class="bodyBody">
                        Vous pouvez &eacute;galement utiliser Jinzora pour effacer les tags sur les fichiers que vous voulez. Tags
                        que g&egrave;re Jinzora:
                        <br>
                        <br>
                        <strong>Genre</strong><br>
                        <strong>Nom de l'artiste</strong><br>
                        <strong>Nom de l'album </strong><br>
                        <strong>Nom de la piste</strong><br>
                        <strong>Num&eacute;ro de la piste</strong><br>
                        <br>
                        Jinzora n'effacera que ce que vous lui avez ordonn&eacute;, rien de plus. Typiquement il remplacera les champs par des vides ou des &quot;&quot;.
                        <br>
                        <br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

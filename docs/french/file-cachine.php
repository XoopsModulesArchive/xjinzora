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
            <strong>Mise en cache</strong>
            <br>
            <br>
            Jinzora utilise un syst&egrave;me de cache pour rendre l'affichage moins long qu'avec d'autres m&eacute;thodes plus conventionnelles. Il y a en fait deux options pour lire les donn&eacute;es, utiliser une base de donn&eacute;es ou lire un fichier syst&egrave;me. Nous avons d&eacute;cid&eacute;
            de garder les choses le plus simple possible en ne lisant qu'un fichier pour extraire les donn&eacute;es recherch&eacute;es, mais dans une collection fournie, ceci peut devenir assez lent. Nous avons donc cr&eacute;&eacute; un fichier dans lequel est stock&eacute; le cache pour acc&eacute;l&eacute;rer
            le processus.<br>
            <br>
            <strong>Comment &ccedil;a marche:</strong>
            <br>
            La premi&egrave;re fois que vous chargez le fichier index.php Jinzora va lire le dossier des m&eacute;dias afin de cr&eacute;er des variables de sessions PHP pour les utiliser ensuite. Alors que ce chargement initial peut &ecirc;tre un peu long sur de gros sites, il vous permettra de
            gagner un temps d'ex&eacute;cution pr&eacute;cieux par la suite. Un probl&egrave;me persiste malgr&eacute; tout avec ce syst&egrave;me de cache. Si vous ajoutez des m&eacute;dias dans votre collection vous devrez red&eacute;marrer votre navigateur (oui c'est lourdingue, on est au
            courant) ou encore allez dans la rubrique &quot;tools&quot; pour faire un &quot;update cache&quot; qui relancera ce processus. C'est le plus gros probl&egrave;me du &quot;live caching&quot;, mais la fin justifie les moyens dans ce cas l&agrave;.<br>
            <br>
        </td>
    </tr>
</table>
</body>

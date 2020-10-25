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
            <strong> Support</strong> <strong>Premium</strong><br>
            <br>
            Bon, vous avez un probl&egrave;me avec Jinzora que vous devez r&eacute;soudre MAINTENANT et vous n'avez pas de temps &agrave; perdre? Le bon fonctionnement de votre Jinzora est capital, et son ajout/changement/r&eacute;paration doit &ecirc;tre r&eacute;alis&eacute; le plus t&ocirc;t
            possible? C'est pourquoi a &eacute;t&eacute; mis en place le "Support Premium". Tandis que le script (que nous ne facturerons JAMAIS) publi&eacute; sous une license libre


            est support&eacute; par nos forums et documentations, si vous juste devez l'avoir LA solution imm&eacute;diatement nous vous aiderons.<br>
            <br>
            Nous voudrions malgr&eacute; tout souligner une chose. Tout utilisateur du Support Premium est encourag&eacute; &agrave; faire un <a href="donations.php" target="Body">don au projet</a>. Libre &agrave; vous de d&eacute;terminer le montant, mais un geste contre notre aide personnalis&eacute;e
            est un bon retour des choses.En &eacute;change on vous promet de r&eacute;gler tous vos besoins - en rapport avec Jinzora bien &eacute;videmment :-) - et faisons tout notre possible pour int&eacute;grer vos fonctions ou faire face &agrave; vos probl&egrave;mes sp&eacute;cifiques.<br>
            <br>
            Pour obtenir un support Premium, envoyez un mail &agrave; <a href="mailto:jinzora@jasbone.com">jinzora@jasbone.com</a> en pr&eacute;cisant le sujet &quot;Support Premium&quot; et la haute priorit&eacute; du message. Nous vous contacterons aussi vite que possible. Dans la plupart des cas,
            le probl&egrave;me est r&eacute;solu dans les 48 heures suivant la prise de contact.
        </td>
    </tr>
</table>
</body>

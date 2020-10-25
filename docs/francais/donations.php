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
            <strong>Donations</strong><br>
            <br>
            Ainsi vous appr&eacute;ciez suffisamment Jinzora au point de vouloir faire
            une donation??? Ca alors, vous devez &ecirc;tre tr&egrave;s tr&egrave;s
            sympa!! D&eacute;velopper un script tel que Jinzora est d&eacute;j&agrave;
            tr&egrave;s gratifiant, mais &ecirc;tre appr&eacute;ci&eacute; pour son
            travail l'est encore plus. Ok, assez pass&eacute; de pommade, voici comment
            r&eacute;compenser nos longues nuits de travail!<br>
            <br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><strong>Amazon</strong></li>
                    </td>

                    <td width="70%" class="bodyBody">Vous ne serez pas vraiment remerci&eacute;
                        (ni par les enfers, ni par rien d'autre) pour votre bonne action.
                        Mais si le coeur vous en dit jetez un coup d'oeil &agrave; ma <a href="http://www.amazon.com/exec/obidos/registry/2RW7JJ4RYKGJD/102-4301221-6637721" target="_blank">&quot;wishlist&quot;
                            sur Amazon</a> (liste de souhaits) puisque vous &ecirc;tes tellement
                        d&eacute;termin&eacute;. Un DVD tout neuf pour mon autre amour, mon
                        Home Cin&eacute;ma, avec mon v&eacute;ritable amour, ma femme, lui
                        fera passer la pilule plus facilement! (suivez mon regard...) :-)<br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><strong>Paypal</strong></li>
                    </td>

                    <td width="70%" class="bodyBody"> Bien que recevoir un CD ou DVD soit
                        g&eacute;nial, rien ne me dispense d'&ecirc;tre d&eacute;pendant de l'argent ... <br>
                        <br>
                        <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                            <input type="hidden" name="cmd" value="_xclick">
                            <input type="hidden" name="business" value="ross@jasbone.com">
                            <input type="hidden" name="item_name" value="Jinzora">
                            <input type="hidden" name="no_note" value="1">
                            <input type="hidden" name="currency_code" value="USD">
                            <input type="hidden" name="tax" value="0">
                            <input type="image" src="https://www.paypal.com/images/x-click-but04.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
                        </form>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

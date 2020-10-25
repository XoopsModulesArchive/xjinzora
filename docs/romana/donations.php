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
            So you like Jinzora enough that you'd like to make a small donation to us??? Wow, you must
            be very very cool! While we get tons of enjoyment out of developing Jinzora, it sure is
            nice to be appreciated! Ok, so enough kiss ass'ing, here's how you can help make
            all our long hours and late nights pay off!<br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><strong>Amazon</strong></li>
                    </td>
                    <td width="70%" class="bodyBody">
                        Nothing says "Thank You" like a CD, DVD, or, hell, anything for that matter.
                        Check out my <a href="http://www.amazon.com/exec/obidos/registry/2RW7JJ4RYKGJD/102-4301221-6637721" target="_blank">wish list on Amazon</a> if you feel so inclined. A shiny new DVD to watch in my other love,
                        my Home Theatre, with my true love, my wife, would make burning the midnight oil a little easier! :-)
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><strong>Paypal</strong></li>
                    </td>
                    <td width="70%" class="bodyBody">
                        While DVD's and CD's are great, nothings says thank you like some good, cold, hard cash!<br><br>
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

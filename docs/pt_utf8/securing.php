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
            <b>Securing Jinzora</b><br>
            <br>
            There are many different ways in which you can secure Jinzora. This should be thought of
            as more of a general guide rather than highly detailed specifics to securing Jinzora.<br><br>
            <b>DISCLAIMER</b> In NO WAY is the Jinzora Development Team responsible for the
            securing of your data!!!
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <b>Jinzora Users</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        The simplest way to secure Jinzora is to use different users with different access
                        levels and to set Jinzora's default mode to "viewonly" (if appropriate). There are 4
                        levels of users, they are:<br><br>
                        <b>Admin:</b> Just what you think this user type can do just about everything
                        <br><br>
                        <b>Power User:</b> Very similiar to an Admin, but they can't use the "Tools" section
                        <br><br>
                        <b>User:</b> A user can play music, but NOT download (only Power Users can)
                        <br><br>
                        <b>View Only:</b> Pretty obvious, don't you think?
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <b>Securing<br>Apache</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        Probably the best way to secure Jinzora for real is the use of .htaccess and .htpasswd files in
                        Apache (user authentication). Again this guide isn't the end all on security, so do some searching
                        if you're not familiar with this concept. One thing you'll want to do (possibly) is set:<br><br>
                        $auth_value = "user:pass";
                        <br><br>
                        In settings.php This value will be prepended to all playlist when Jinzora generates them so that
                        you (and your users) won't have to worry about authentication issues with their favorite media player.
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <b>Securing IIS</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        Probably the best way to secure Jinzora on IIS is to enable Authentication (like Apache above).
                        Again this guide isn't the end all on security, so do some searching
                        if you're not familiar with this concept. One thing you'll want to do (possibly) is set:<br><br>
                        $auth_value = "user:pass";
                        <br><br>
                        In settings.php This value will be prepended to all playlist when Jinzora generates them so that
                        you (and your users) won't have to worry about authentication issues with their favorite media player.
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <b>Preventing Right Clicks</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        One way to secure your content is to disable the right mouse button. This would make it much more difficult
                        for users to be able to download your images and tracks. It would prevent them from easily copying the HREFs
                        to your media as well.<br><br>
                        Realize that there is no 100% way to prevent a user from access this information. They could always view the source
                        HTML and get the data from there. Also realize that using this feature will actually piss off some of your users
                        as it will disable many other features of the browser (like opening links in new windows, etc).
                        <br><br>
                        To enable this feature you'll need to set:<br><br>
                        $secure_links = "true";<br><br>
                        In system.php (NOT settings.php). <br>
                        <b>NOTE:</b> This feature is NOT supported in upgrades. You'll need to set this in system.php each time you
                        upgrade Jinzora.
                        <br><br><br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

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
            <strong>Symlinking</strong><br>
            <br>
            There are many times where you need to install Jinzora on one drive or partition, but all your media
            is on another. There are a few options you have to get around this issue, mainly symlinking.
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong>*NIX</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        This is most definetly the easiest on *NIX systems. If you're running *NIX you probably already
                        know how to do this, but just in case you don't (hey, we all had to learn sometime, right?) here's how:
                        <br><br>
                        Say you have Jinzora installed in:
                        <br><br>
                        /var/www/html/jinzora
                        <br><br>
                        But your media is in
                        /home/ross/music
                        <br><br>
                        You could then do a (as one command)
                        <br><br>
                        cd /var/www/html/jinzora; ln -s /home/ross/music
                        <br><br>
                        To create a symlinked music directory inside Jinzora. Then make sure to set your $media_dir = "/music"; and you're good to go!
                        <br><br>
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong>Windows</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        This used to be basically impossible on Windows, but finally Microsoft has given us symlinking on Windows! You'll need the
                        linkd.exe tool (part of the Windows 2005 Resource Kit, <a href="http://www.jinzora.org/modules.php?op=modload&name=Downloads&file=index&req=viewdownload&cid=4">available here</a>)
                        There are a few requirements for this to work, they are:
                        <br><br>
                        Windows 2005 Server or XP Pro (to install the Resource Kit to get linkd.exe)<br><br>
                        ALL drives that are in play MUST be NTFS<br>
                        <br>
                        So as an example:<br>
                        <br>
                        Let's say your site is in:<br>
                        c:\inetpub\wwwroot<br>
                        <br>
                        And your media is in:<br>
                        d:\media<br>
                        <br>
                        Then the command would be:<br>
                        linkd.exe c:\inetpub\wwwroot\media d:\media <br>
                        <br>
                        Then you're $media_dir in Jinzora would be:<br><br>
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

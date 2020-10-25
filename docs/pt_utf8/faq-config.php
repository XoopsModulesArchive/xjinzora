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
            <b>Configuration FAQ</b>:<br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#readtracks">Can Jinzora read tracks that are in another folder that is NOT under the Jinzora directory?</a>
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#readotherserver">Can Jinzora read tracks that are on a different server entirely?</a><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#iisotherdrive">When using IIS can files be on a different drive from where Jinzora is installed?</a><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#permissions">Jinzora can play music, but I can't upload/create genres/delete genres/download, what gives?</a><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#ftp">How can the tracks also be accessable through FTP?</a><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#tooshort">The artists/album names are too short</a><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#wording">How can I change the wording (terms) used in Jinzora?</a><br>
                        (like changing the word Genre to something else)<br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#video">Can Jinzora stream video?</a><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#users">How do I create new users for Jinzora?</a><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#imagesize">What dimensions should my album art be?</a><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#resolution">What screen resolution is Jinzora designed for?</a><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#ssl">Can Jinzora run through SSL?</a><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#uploads">Why don't uploads work all the time?</a><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#imageslooklikecrap">Why do the album art images look like crap sometimes?</a><br><br>
                    </td>
                </tr>
            </table>
            <br><br><br><br><br><br><br><br><br><br>
            <br><br><br><br><br><br><br><br><br><br>
            <br><br><br><br><br><br><br><br><br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <b><a name="readtracks">Can Jinzora read tracks that are in another folder that is NOT under the Jinzora directory?</a></b><br><br>
                        Yes. Basically the files just need to be in the path
                        of the webserver, so the browser can read them, that's it. A common thing
                        to do would be to create a symlinked subdirectory under the jinzora install
                        directory. This can be done by executing the
                        following command (while in the jinzora directory)<br>
                        <br>
                        <b>*NIX</b><br>
                        ln -s /full/path/to/the/media/files
                        <br><br>
                        <b>Windows</b><br>
                        Thanks to a new tool in the Windows 2005 resource kit you can now do this on Windows as well
                        (many thanks to James Borris for pointing this out!). To do symlinking on Windows you'll
                        need to install the Windows 2005 resource kit (only installs on 2005 or XP, but the tool will run
                        on Windows 2000). Once installed use the tool linkd.exe (or copy it to a Windows 2000 server). and run
                        the following:<br><br>
                        linkd drive:\path\to\files drive:\name\of\linked\dir<br><br>
                        So as an example:<br><br>
                        Let's say your site is in:<br>
                        c:\inetpub\wwwroot<br><br>
                        And your media is in:<br>
                        d:\media<br><br>
                        Then the command would be:<br>
                        linkd.exe d:\media c:\inetpub\wwwroot\media<br><br>
                        Then you're $media_dir in Jinzora would be:<br>
                        $media_dir = "/media";
                        <br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <b><a name="readotherserver">Can Jinzora read tracks that are on a different server entirely?</a></b><br><br>
                        Yes, it does take some work though. Here's 2 examples:<br><br>
                        <b>Windows:</b> On Windows you'd need to use NFS. NFS (Network File System) is pretty easy to setup and configure,
                        and there is lots of help for it on the net. I've only used it once, many years ago but it was very simple to do. One note is
                        that NFS only runs on the server line, not on 2000 Pro or XP, sorry...<br><br>
                        <b>*NIX</b> On *NIX you have several different options. The one I use is Samba. I share my MP3's from a remote server
                        (a RedHat 8.0 box) using Samba, then mount that remote share in /etc/fstab again using Samba. I do this because it's simple
                        and I got it to work :-) The main key here is that the user that mounts to remote share be the same user that the webserver runs as
                        Here's an example of the line in my /etc/fstab:<br><br>
                        //dens800/music /var/www/ross/modules/jinzora/my-music smbfs auto,users,username=apache,password=XXXXXXXXX,gid=48,uid=48 0 0<br><br>
                        The really important items here are the gid and uid. These tell samba to mount the share as the user/group with those id's, in this
                        case apache. This isn't required, unless you want to be able to delete, download, upload, modify ID3 tags, etc (basically anything
                        that writes to the files). There are probably many ways to accomplish all this, and if anyone has a better suggestion please
                        let me know and I'll add it here.
                        <br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <b><a name="iisotherdrive">When using IIS can files be on a different drive from where Jinzora is installed?</a></b><br><br>
                        No and Yes. By default, no, there is no way to link files from another directory into the real filesystem directory structure
                        in Windows link using symlinking in *NIX. The issue is the actual files MUST exist somewhere in the path of the webserver,
                        and using viritual directories in IIS won't cut it.<br><br>
                        Ok, on to the yes part. The only way to do this (we think, but have never tested - someone please let us know if we are wrong)
                        is to use NFS (Network File System). NFS is a Windows service (Sorry, only NT 4.0 Server, Windows 2000/2005 Server, NOT XP or 2000 pro)
                        that lets you mount remote (or local) filesystem inside other filesystem. Theoritically NFS should do the job.<br><br>
                        The only other option you have is, in IIS, to change the root directory of the webserver to a new drive that has all your free space
                        and media tracks. This may not be possible in all cases, but it's really the only other alternative until Windows introduces symlinking :-)
                        <br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <b><a name="permissions">Jinzora can play music, but I can't upload/create genres/delete genres/download, what gives?</a></b><br><br>
                        Generally this is a problem on *nix/Apache and it is
                        generally a permissions issue. Basically the user that your webserver runs
                        as (sometimes apache, sometimes nobody, sometimes a million different possibilities..)
                        doesn't have write permissions to the /music or /temp directories (or
                        to whatever you changed their names to). Granting the
                        webserver user write permissions to these directories should solve this
                        issue
                        <br>
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <b><a name="ftp">How can the tracks also be accessible through FTP?</a></b><br>
                        <br>
                        Yes. See the example just above this one, you'd basically do the same thing. Just make sure the files are in the
                        path of your FTP server (assuming both are on the same box). Then do the above.
                        <br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <b><a name="tooshort">The artists/album names are too short</a></b><br><br>
                        You can set the Artist and Album truncate lengths either
                        at install/upgrade time (the options are on page 2) or you can edit settings.php
                        and change the following lines:<br>
                        <br>
                        $artist_truncate<br>
                        $album_name_truncate<br><br>
                        These two values control how the data is displayed by Jinzora.
                        <br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <b><a name="wording">How can I change the wording (terms) used in Jinzora?</a></b><br><br>
                        By creating a "custom" language file. Basically just copy the file lang/english.php (or any of the others)
                        and rename it to custom.php Once you've created the new file edit the entries in it as you wish. Once edited
                        change the language either in setup (on page two) or edit the line in settings.php to:
                        <br><br>
                        $lang_file = "custom";
                        <br><br>
                        That will tell Jinzora to use your custom language file.
                        <br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <b><a name="video">Can Jinzora stream video?</a></b><br><br>
                        Yes. Jinzora <i>should</i> be able to stream any file that can stream over HTTP. All you need to do
                        is to make sure that the file extension you'd like to stream is listed in the variable:<br><br>
                        $video_type = "ext|ext|ext|ext";<br><br>
                        Where ext is the extension of the file type you'd like
                        to stream (separated by |).
                        <br>
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <b><a name="users">How do I create new users for Jinzora?</a></b><br><br>
                        By editing the file users.php There is documentation
                        in this file for the format that the entire's need to be in, please reference
                        it.
                        <br>
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <b><a name="imagesize">What dimensions should my album art be?</a></b><br><br>
                        It doesn't really matter, but all mine are about 134x134 pixels. That's the reference size that I use
                        when developing Jinzora. While technically it doesn't matter, something around this size should be best.
                        <br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <b><a name="resolution">What screen resolution is Jinzora designed for?</a></b><br><br>
                        While it technically doesn't matter, Jinzora is best view at at least 1024x768 or higher. I test it
                        (and run it personally) at 1280x1024, but I do make sure it will look ok at 1024x768. Anything lower
                        and there is just too much stuff to show for it to look good. Remember there are many things you can
                        change visually about Jinzora, like turning off the drop down boxes in the header, specify how many
                        columns to display on the Genre/Artist page, how many columns for album art, etc, etc. Please pay
                        close attention to the second page of the installer, as this is where these options are.
                        <br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <b><a name="ssl">Can Jinzora run through SSL?</a></b><br><br>
                        Yep, totally. If you access Jinzora with a URL that is SSL (HTTPS) then it will stay in SSL as you
                        browse through Jinzora. If you generate a playlist while in SSL the playlist will be generated
                        as SSL, so you should be good to go! :-)
                        <br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <b><a name="uploads">Why don't uploads work all the time?</a></b><br><br>
                        Basically because doing file uploads through PHP sucks. There isn't much that can be done about it,
                        that's just how it is. We are constantly trying to find ways around this but nothing yet... :-(
                        <br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <b><a name="imageslooklikecrap">Why do the album art images look like crap sometimes?</a></b><br><br>
                        There are a few possible reasons for this, they could be:<br>
                        1. That you are resizing the images in Jinzora. This is a cool feature (I think anyway) but GD doesn't
                        do the best job at resizing jpeg's. I've played with it a lot in other projects and it never does a great job.
                        Unfortunately I can't do anything about that :-) You can try setting all the resizing to 0 and see if that helps
                        with the quality (a setting of 0 turns off image resizing)<br><br>
                        2. That you're not resizing and the images are just small. When Jinzora auto grabs images it does it
                        from imgaes.google.com During that auto grab process it takes the first image it finds a match on
                        and saves that as the album art (and they optionally resizes it). You can click "Change" under the
                        image to try to find a bigger, better one. Again I'm at the mercy of google to give me good images...
                        <br><br><br>
                    </td>
                </tr>
            </table>
            <br><br><br><br><br><br><br><br><br><br>
            <br><br><br><br><br><br><br><br><br><br>
            <br><br><br><br><br><br><br><br><br><br>
        </td>
    </tr>
</table>
</body>

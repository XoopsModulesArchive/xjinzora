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
            <strong><strong>FAQ</strong> g&eacute;n&eacute;rale</strong>:<br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#whatis">Qu'est ce que Jinzora?</a><br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#whydevelop">Pourquoi d&eacute;velopper Jinzora?</a><br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#requirements">Qu'est ce qui est requis pour faire fonctionner Jinzora?</a><br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#shoutcast">Ai-je bsoin de Shoutcast ou d'un autre serveur de streaming pour utiliser Jinzora?</a><br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#bandwidth">Quelle bande passante utilise Jinzora?</a><br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#howhelp">Comment puis-je aider Jinzora?</a><br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#filesharing">Est-ce que Jinzora est similaire &agrave; KaZaA ou &agrave; d'autres applications de partage?</a><br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <a href="#winampwma">Pourquoi Winamp ne joue pas mes fichiers WMA?</a><br>
                        <br>
                    </td>
                </tr>
            </table>
            <br><br><br><br><br><br>
            <br><br><br><br><br><br>
            <br><br><br><br><br><br>
            <br><br><br><br><br><br>
            <br><br><br><br><br><br>
            <br><br><br><br><br><br>
            <br><br><br><br><br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <strong><a name="whatis">What is Jinzora?</a></strong><br><br>
                        Jinzora is a Web-based media streamer, primarily desgined to stream MP3s (but can be used for any media file
                        that can stream from HTTP). Jinzora can be integrated into a PostNuke site, run as a standalone application,
                        or integrated into any PHP website.
                        <br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <strong><a name="whydevelop">Why Develop Jinzora?</a></strong><br><br>
                        Because I'm a dork. No, seriously because I wanted a very flexible, easy to use, way to stream my music
                        collection from my personal webserver to anywhere I was at any time. I also wanted it's interface to be
                        very nice, with an emphasis on features and interface design. Once I finished my first version I figured
                        I'd share my labors with the world, and here they are, enjoy!
                        <br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <strong><a name="requirements">What are Jinzora's Requirements?</a></strong><br><br>
                        Jinzora's requirements are actually quite simple. You need a webserver (it's been tested with Apache 1.3/2.0 and
                        Windows 2000/IIS), PHP installed (at least 4.0), and a bunch of media files. I have over 400 albums, with
                        a total of more than 6,000 tracks in my library, and it works great. Please see the
                        <a href="http://www.jinzora.org/modules.php?op=modload&name=jz_docs&file=eng-requirements">Requirements</a> page for full details.
                        <br><br><br>
                    </td>
                </tr>


                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <strong><a name="shoutcast">Do I need Shoutcast or some other streaming server setup to use Jinzora?</a></strong><br><br>
                        Not at all. Jinzora is designed primarily to stream individual tracks to individual users via HTTP. It is very simple in this
                        nature, not needing anything other than a webserver to operate. Shoutcast can be used to provide a constant streaming
                        radio station type setup where Jinzora becomes the front end to it.
                        <br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <strong><a name="bandwidth">How much bandwidth does Jinzora use?</a></strong><br><br>
                        That depends on the files that are being streamed. For example if you are streaming a 128Kbps MP3 file (pretty standard encoding rate)
                        that takes 128Kbps of bandwidth. If you're streaming files like that to 10 users (these are rough guidelines) then it would take
                        1.28 MB, or near a T1 of bandwidth. It all depends on the users, file types, etc. Generally Jinzora is best used as a
                        personal jukebox, for a very small number of users on the internet, or for a large number of users for a local network.
                        It is all just a matter of how much bandwidth you can use. We have some users serve Jinzora on a cablemodem, while others
                        run it on T3's
                        <br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <strong><a name="howhelp">How can I help Jinzora?</a></strong><br><br>
                        There are many ways in which you can help the development of Jinzora. First and foremost download it, install it,
                        and enjoy your music, that's what it's for! If you want to be an active part of Jinzora register with me here at this
                        site, or visit my <A href="http://www.jinzora.org/modules.php?op=modload&name=jz_help&file=index">How can I Help?</A> page
                        for more details.
                        <br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <strong><a name="filesharing">Is Jinzora similar to KaZaA and other file sharing apps?</a></strong><br><br>
                        Not at all. While you can "share" music through Jinzora, it is in no way meant to be used to illegally share
                        music. It is designed to help individuals better use their MP3/media collections, or for groups to demo
                        or showcase thier music.
                        <br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li>&nbsp;</li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <strong><a name="winampwma">Why won't Winamp play WMA files?</a></strong><br><br>
                        Probably because you don't have that option installed :-) Make sure that you download and install the
                        full version of Winamp, that includes the WMA stuff. After install you should be good to go!
                        <br><br><br>
                    </td>
                </tr>
            </table>
            <br><br><br><br><br><br>
            <br><br><br><br><br><br>
            <br><br><br><br><br><br>
            <br><br><br><br><br><br>
            <br><br><br><br><br><br>
            <br><br><br><br><br><br>
            <br><br><br><br><br><br>
            <br><br><br><br><br><br>
            <br><br><br><br><br><br></td>
    </tr>
</table>
</body>

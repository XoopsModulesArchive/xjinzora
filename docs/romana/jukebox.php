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
            <strong>Jukebox Install</strong><br>
            <br><br>
            Jukebox mode is only supported in 2 ways:<br>
            <li>XMMS (or noxmms) on *NIX platforms</li>
            <li>Winamp (with the httpQ plugin) on Windows platforms</li>
            <br><br>
            Also, let's cover what this guide is NOT. This is not a guide to:
            <li>Installing Linux/Apache/PHP/Windows/IIS/etc</li>
            <li>Getting Audio working on your server</li>
            <li>Making really <a href="http://www.ncausa.org/public/pages/index.cfm?pageid=71" target="_blank">good coffee</a></li>
            <br><br>
            It is assumed that your server can play media through its sound card succesfully BEFORE proceeding with this guide.
            <br><br>
            <strong>NOTE:</strong> (for *NIX users) Remember when testing the mpg123 (or whatever you test with)
            needs to be able to run and play audio AS the webserver user, since that's how Jinzora will interact with
            your audio hardware.
            <br><br><br><br>
            <strong>Setting up on *NIX</strong><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><strong>No-XMMS</strong></li>
                    </td>
                    <td width="70%" class="bodyBody">
                        There are 2 possible ways to run Jukebox mode, with either XMMS or noxmms.
                        We STRONGLY recommend noxmms, as you will not need X running to use it (and therefore can
                        kind of get it to run as a daemon - well sort of anyway). So first we have to get noxmms downloaded and installed.
                        <br><br>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Getting and Installing noxmms
                                    <br><br>
                                    The first thing you'll need to do is get and install noxmms. Now you're
                                    perfectly welcome to use XMMS, but I figure if you're using that you know how and
                                    can skip this step. Even if you plan on using XMMS, you really should think about
                                    using noxmms instead, as it really is much easier since your box doesn't have to be
                                    up and running X. Ok, enough of that, now just download noxmms from:
                                    <br><br>
                                    <a href="http://www.jinzora.org/modules.php?op=modload&name=Downloads&file=index&req=viewdownload&cid=5" target="_blank">Download No-XMMS</a>
                                    <br><br>
                                    Once you've got it downloaded you'll need to extract and compile it. While this guide is not intended
                                    to be an end all be all of compiling by any means, generally you'll be doing:
                                    <br><br>
                                    <li>tar -zxvf noxmms-1.2.7.tar.gz</li>
                                    <li>cd noxmms-1.2.7</li>
                                    <li>sh configure --prefix=/usr/local (this can be any directory you want)</li>
                                    <li>make (may take a while, remember that coffee link???)</li>
                                    <li>make install (remember to do this with an account with proper permissions - like root)</li>
                                    <br><br>
                                    Once you've got it compiled and installed successfully as a quick test just type:
                                    <li>noxmms</li>
                                    And make sure you don't get any errors (it should just sit there and do nothing). After a few
                                    seconds just do a control-C to break out of it and proceed to the next step below.
                                    <br>
                                    <strong>NOTE:</strong> You WILL NOT be able to install XMMS-Shell if you haven't completed this!
                                    <br><br>
                                </td>
                            </tr>
                        </table>
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><strong>XMMS-Shell</strong></li>
                    </td>
                    <td width="70%" class="bodyBody">
                        Now that you've got XMMS (or hopefully noxmms) installed and working we need to get XMMS-Shell going so
                        that Jinzora can control XMMS.
                        <br><br>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                    <li>&nbsp;</li>
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Getting and Installing XMMS-Shell
                                    <br><br>
                                    First you'll need to download XMMS-Shell:
                                    <br><br>
                                    <a href="http://sourceforge.net/project/showfiles.php?group_id=5632&package_id=5689&release_id=117891" target="_blank">Download XMMS-Shell</a><br>
                                    (we test with and use xmms-shell-0.99.3)
                                    <br><br>
                                    Once you've got it downloaded you'll need to extract and compile it:
                                    <li>tar -zxvf xmms-shell-0.99.3.tar.gz</li>
                                    <li>cd xmms-shell-0.99.3</li>
                                    <li>ln -s /usr/local/bin/noxmms-config /usr/bin/xmms-config (since we don't have XMMS installed)</li>
                                    <li>Make sure and check permissions on that file to make sure it can be read</li>
                                    <li>sh configure</li>
                                    <li>make</li>
                                    <li>make install (remember to do this with an account with proper permissions - like root)</li>
                                </td>
                            </tr>
                        </table>
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><strong>Permissions</strong></li>
                    </td>
                    <td width="70%" class="bodyBody">
                        Ok, now that you've got that all complied (fun, huh?) you need to setup all the permissions so that
                        the webserver will be able to control XMMS.
                        <br><br>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    Ok, so let's set some permissions!
                                    <br><br>
                                    <li>chmod a+s /usr/local/bin/xmms-shell (or wherever you installed it)</li>
                                    <br>
                                    Now we'll need to do a symlink to the pipe that XMMS and XMMS-Shell use so that
                                    XMMS-Shell can communicate to it as root (don't worry it's not really root, we have to
                                    trick it into that)
                                    <br><br>
                                    <li>ln -s /tmp/xmms_XXXXX.0 /tmp/xmms_root.0 (where XXXXX is the user that your webserver is running as)</li>
                                </td>
                            </tr>
                        </table>
                        <br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><strong>Setting noxmms to run at boot</strong></li>
                    </td>
                    <td width="70%" class="bodyBody">
                        Ok, next we need to get noxmms to run at boot time as the user that the webserver runs as. We've written a little
                        init script that we use to start that for us. We use this script on Slackware 9.1 and are not sure it will
                        work on all Linux distrubutions.
                        <br><br>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="1%" class="bodyBody" valign="top">
                                </td>
                                <td width="99%" class="bodyBody" valign="top">
                                    <a href="" target="_blank">Download Init Script</a>
                                    <br><br>
                                    Once you've got the script downloaded (or do it on your own) you'll need to
                                    get noxmms running (remember it MUST run as the webserver user). Once you've got it
                                    running you should be able to log into Jinzora (you MUST be a Jinzora admin to see
                                    the jukebox controls) and start playing music (ensuring that when you installed Jinzora
                                    you choose "Jukebox Mode" as the install type. Click play on something and you should be jammin'!!!
                                </td>
                            </tr>
                        </table>
                        <br><br><br><br>
                    </td>
                </tr>
            </table>
            <br><br><br><br>
            <strong>Setting up on Windows</strong>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><strong>Winamp</strong></li>
                    </td>
                    <td width="70%" class="bodyBody">
                        This is pretty simple, you just need to get Winamp installed and working. Please note that right now
                        we only support Winamp 2.x, as the httpQ plugin seems unstable on Winamp 5.x You can get the older version
                        of Winamp from our website at www.jinzora.org. If we shouldn't be providing this download we are sorry, just
                        let us know...
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><strong>httpQ Plugin</strong></li>
                    </td>
                    <td width="70%" class="bodyBody">
                        Now that Winamp is installed you'll need to install the httpQ plugin for Winamp. This can also be downloaded
                        from our servers at www.jinzora.org. Once you download the plugin just install it. Once installed you'll need
                        to configure it:<br>
                        <li>Open Winamp</li>
                        <li>Type a "Ctrl - P" to bring up "Preferences"</li>
                        <li>Click on "Plug-ins" "General Purpose"</li>
                        <li>Highlight "Winamp httpQ Plugin Version 2.1" and click "Configure"</li>
                        <li>Set a password, IP Address (we recommend 0.0.0.0), and TCP Port (we recommend 4800)</li>
                        <li>Check "Start Service Automatically"</li>
                        <li>Click "Start"</li>
                        <br><br>
                        Be sure to leave your server logged in and Winamp running so that Jinzora can control it :-)
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <li><strong>Jinzora Settings</strong></li>
                    </td>
                    <td width="70%" class="bodyBody">
                        Now that Winamp is going (and httpQ is installed) all you'll need to do is make sure that Jinzora is setup
                        properly to communicate with it. In settings.php verify that the following settings are correct:<br><br>
                        $jukebox = "winamp";<br>
                        $jukebox_pass = "jinzora"; (or the password that you configured httpQ with)<br>
                        $jukebox_port = "4800"; (or the port that you configured httpQ with)<br>
                        <br><br>
                        That should do it! Enjoy Jukebox support on Windows!!!
                        <br><br><br><br>
                    </td>
                </tr>
                <br><br><br><br>
            </table>
        </td>
    </tr>
</table>
</body>

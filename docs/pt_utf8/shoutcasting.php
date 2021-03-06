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
            <b>Shoutcasting</b><br>
            <br>
            Jinzora currently has support for Shoutcasting, it is however very early and limited.
            Basically you can use any Jinzora playlist as a Shoutcast playlist (and stop and
            start the Shoutcast server from the "Tools" Page.
            <br><br>
            <b>Getting Shoutcasting Going</b>
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        First install and configure Jinzora. Make sure you have it working WITHOUT Shoutcasting support first,
                        so you don't over complicate things...
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        Ok, now that you have Jinzora working without Shoutcasting (you do, don't you?) let's set it up.
                        You'll find a directory in the Jinzora install called shoutcast. This directory has all the files
                        we need to edit to get Shoutcast going. In the future it is planned that this install will be
                        automated.
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <b>sc_trans.conf</b>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="1%" valign="top" class="bodyBody">
                                    <li></li>
                                </td>
                                <td width="99%" class="bodyBody">
                                    Playlistfile = /full/path/to/jinzora/shoutcast/shoutcast.lst
                                    <br>
                                    This MUST be the full path to the file
                                    <br><br>
                                    ServerIP = IP Address or DNS Name
                                    <br>
                                    If streaming public this must be internet accessable
                                    <br><br>
                                    ServerPort = XXXX (something like 8100)
                                    <br>
                                    Again for public streaming this must be open in your firewall
                                    <br><br>
                                    Password = XXXX
                                    <br>
                                    This is the password that is used for the transcoder to connect to the Shoutcast server
                                    <br><br>
                                    StreamTitle = XXXX
                                    <br>
                                    Whatever you want to name your stream...
                                    <br><br>
                                    StreamURL = XXXX
                                    <br>
                                    Generally the name of your site (http://www.jinzora.org)
                                    <br><br>
                                    Genre = XXXX
                                    <br>
                                    Whatever you want....
                                    <br><br>
                                    Bitrate = 128000
                                    <br>
                                    The rate at which you want the files to be streamed (see the file for examples)
                                    <br><br>
                                    SampleRate = 44100
                                    <br>
                                    The sample rate for the stream (see the file for examples)
                                    <br><br>
                                    Channels = 2
                                    <br>
                                    2 for stereo, 1 for mono
                                    <br><br>
                                    Quality = 1
                                    <br>
                                    The encoding quality of the stream
                                    <br><br>
                                    CrossfadeMode = 0 / CrossfadeLength = 8000
                                    <br>
                                    The cross fading options (see the file for examples)
                                    <br><br>
                                    Public=0
                                    <br>
                                    If you want to publish this stream to yp.shoutcast.net set this to 1
                                    <br><br><br><br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <b>start.sh</b>
                        <br><br>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="1%" valign="top" class="bodyBody">
                                    <li></li>
                                </td>
                                <td width="99%" class="bodyBody">
                                    make sure that the path in this file is the full path to the shoutcast directory
                                    <br>
                                    NOTE: This is planned to be automated in the future
                                    <br><br><br><br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" class="bodyBody">
                        <b>sc_serv.conf</b>
                        <br><br>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="1%" valign="top" class="bodyBody">
                                    <li></li>
                                </td>
                                <td width="99%" class="bodyBody">
                                    MaxUser = 4
                                    <br>
                                    The maximum number of uses that can stream from this server
                                    <br><br>
                                    Password = XXXX
                                    <br>
                                    The same password you specified above - VERY IMPORTANT
                                    <br><br>
                                    PortBase = XXXX
                                    <br>
                                    The same IP Port you chose above - VERY IMPORTANT
                                    <br><br>
                                    SrcIP = X.X.X.X
                                    <br>
                                    Only important if you want Shoutcast to stream on a specific IP Address
                                    <br><br><br><br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="1%" valign="top" class="bodyBody">
                        <li></li>
                    </td>
                    <td width="99%" valign="top" class="bodyBody">
                        That should be it, enjoy your stream!!!
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

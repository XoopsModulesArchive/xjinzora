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
            <b>Using Jukebox</b><br>
            <br><br>
            Using the Jukebox mode is rather simple. Everything you generate will be sent to the
            local player on the server rather than being streamed to the client. You can do both,
            by using the selector box that is included in the Jukebox bar in Jinzora. There are a few things
            to know about Jukebox mode, they are:
            <br><br>
            <b>Playing Media</b><br>
            When you "play" media while in Jukebox mode it will be sent to the server (locally) rather than
            streamed. You can, however, also stream while in Jukebox mode by changing the "Playback to:"
            selector to "Stream". This will let you use Jukebox mode and streaming at the same time.
            <br><br>
            There are a few things to know about playing media. Whenever you "play" something, it will be
            added to the currently playing list of media. If you would like to clear the current list
            to start fresh, simply click the "X" or "clear" icon in the Jukebox bar. This will clear the
            currently playing playlist so you may add a new one. You can also click on the name of the
            upcoming tracks to jump directly to one of those tracks if you wish.
            <br><br>
            <b>Using Custome Keyboard Keys</b>
            <br>
            Jinzora does support mapping keys on your keyboard to control the Jukebox through the browser.
            Jinzora does this by capturing the keys you press when your browser has focus. This can be
            rather cool, letting you control functions (volume, play, stop, next, previous) quickly
            from the keyboard. The default keys are listed below:<br><br>
            Play = "p"<br>
            Stop = "s"<br>
            Next = "."<br>
            Previous = ","<br>
            Mute = "0" or "m"<br>
            Volume = (the number key) where "1" = 10%<br>
            <br>
            There is one big downside to this. If you try to do other things Jinzora, namely search, you will NOT
            be able to use those keys.
            <br><br>
            <b>Custom Keyboard Map</b>
            <br>
            You can create a custom keyboard map to override the Jinzora defaults. This is done by creating the file:<br><br>
            custom-keys.php<br><br>
            and placing it in the same directory as the Jinzora index.php script. Jinzora will use the mappings in this file.
            Remember the codes for these need to be the ASCII value of the key that is being pressed. A file that would match
            the Jinzora defaults would look like:<br><br>
            &lt;?php<br>
            $play_key = "112"; <br>
            $stop_key = "115"; <br>
            $next_key = "46"; <br>
            $previous_key = "44";<br>
            $muke_key = "109"; <br>
            $vol_0 = "48"; <br>
            $vol_10 = "49"; <br>
            $vol_20 = "50"; <br>
            $vol_30 = "51";<br>
            $vol_40 = "52"; <br>
            $vol_50 = "53"; <br>
            $vol_60 = "54"; <br>
            $vol_70 = "55"; <br>
            $vol_80 = "56"; <br>
            $vol_90 = "57"; <br>
            $vol_100 = "58";<br>
            ?&gt;<br>
            <br>
            You do not need to specify all keys in this file, only the ones that you'd like to override
        </td>
    </tr>
</table>
</body>

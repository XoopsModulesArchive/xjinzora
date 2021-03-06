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
            <b>Embedded Controls</b><br>
            <br><br>
            When using the Jukebox features of Jinzora you may wish to embed the Jinzora Jukebox
            controls within another web based application. We do this by embedding the Jukebox
            controls within a page that displays a slideshow of picutres on a small laptop in our
            kitchen. In this way we can view the pictures and control Jinzora for one single page.
            This is done by using an iFrame as described below.
            <br><br>
            All that you need to do is reference the following file:
            <br><br>
            http://urltojinzora/path/to/jinzora/slim/slim.jukebox.php?direct=yes&c=current&bg=gray&fc=black&rf=30
            <br><br>
            <b>Options</b>
            <br><br>
            c = "current" or "control"
            <br>
            "current" will also show the currently playing track and the playback controls<br>
            "control" will only show the playback controls
            <br><br>
            bg = "background color" (either HEX or word)
            <br><br>
            fc = "font color" (either HEX or word)
            <br><br>
            rf = "refresh" - this sets the refresh time (in seconds) of the page
            <br><br>
            <b>Using in an iFrame</b>
            <br>
            To use these controls in an iFrame (which will seemlessly integrate into a page) use the following
            in your HTML
            <br><br>
            &lt;iframe name="slimzora" src="http://10.10.0.100/jinzora/slim/slim.jukebox.php?direct=yes&c=current&bg=gray&fc=black&rf=30" style="width: 500; border: 0px solid black;" height="45" frameborder="0">&lt;/iframe>
            <br><br>
            This is the code that the Jinzora author uses in his personal setup. Copy, paste, and modify this as you wish!
        </td>
    </tr>
</table>
</body>

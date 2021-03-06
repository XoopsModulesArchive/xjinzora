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
            <b>Playlists</b><br>
            <br>
            Jinzora supports playlists in a number of different ways. You can create your own
            custom playlists and store them on the server, or there are many different ways in which
            Jinzora can create playlists on the fly for you.
            <br><br>
            <b>Creating Custom Playlists</b>
            <br><br>
            To add items to a custom playlist simply check the box next to the item you'd like to add,
            and click the "Add" button (generally a +) next to the name of the playlist.
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <b>Session Playlist</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        If you'd like you can add items to a "Session Playlist" that is only good for the current
                        session. This can be handy if you want to throw a few things in a temp playlist to listen
                        to right now but you don't really care about it long term. Session playlists expire when you
                        close your browser or the session times out.
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <b>New Playlists</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        Ok, so you want to actually save this playlist, huh? After you've selected all the things you'd like
                        to add, simply choose " - New Playlist - " from the drop down playlist list. You'll then be prompted for
                        a name for the playlist (please only use alpha numeric here, spaces are ok...). Once you create your playlist
                        you'll be free to add to it later...
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <b>Existing Playlists</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        So you've created your new playlist and named it, now all you have to do is add to it, just as you did
                        above when you created it, just make sure to select it when you click "Add"
                        <br><br>
                    </td>
                </tr>
            </table>
            <br><br>
            <b>Viewing Playlists</b>
            <br><br>
            Ok, so you've created some playlists, now you want to view them, huh? All you have to do is select the playlist from the
            drop down list and click on the "View Playlist" icon (just to the right of the playlist drop down).
            <br><br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <b>Deleting an item</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        If you'd like to delete a single item from a playlist all you have to do is select it in the list by checking
                        its checkbox and clicking "Delete" at the bottom of the page. This won't delete the track, just its listing in this
                        playlist.
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <b>Deleting an Playlist</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        If you want, you can also delete an entire playlist. Just click on "Delete Playlist", pretty easy, huh?
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <b>Sending an Playlist</b>
                    </td>
                    <td width="70%" class="bodyBody">
                        We think this is cool, and use it a lot. Let's say you've create a super cool playlist and you want a friend to hear it. All
                        you have to do is click the "Send Playlist" link and it will generate an email (using a mailto HREF tag) with the subject
                        and body all filled out for you. In the body will be a link to the playlist, that upon clicking with have Jinzora just generate
                        the playlist for the user. They do not need any access to Jinzora to hear it, and it will not give them any web output, it
                        will simply launch their player of choice and start streaming the tracks. This can be a great way to share music with friend
                        without giving them access to Jinzora!
                        <br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

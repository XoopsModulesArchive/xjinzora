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
            <strong>Les Playlists</strong><br>
            <br>
            Jinzora supporte les playlists de diff&eacute;rentes fa&ccedil;ons. Vous avez la possibilit&eacute; de cr&eacute;er vos propres playlists et de les enregistrer sur le serveur, ou encore &agrave; la vol&eacute;e.
            <br>
            <br>
            <strong>Cr&eacute;er ses propres Playlists</strong>
            <br>
            <br>
            Pour ajouter des &eacute;l&eacute;ments &agrave; sa playlist, cochez simplement les box situ&eacute;es &agrave; c&ocirc;t&eacute; des &eacute;l&eacute;ments d&eacute;sir&eacute;s, puis cliquez sur le bouton "Add" (g&eacute;n&eacute;rallement un +) &agrave; c&ocirc;t&eacute; du nom de la
            playlist (nouvelle ou le nom donn&eacute; si d&eacute;j&agrave; existante).
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong> Playlist de la <strong>Session</strong></strong></td>
                    <td width="70%" class="bodyBody">
                        Vous pouvez ajouter des morceaux &agrave; la playlist de la session. Ceci peut &ecirc;tre utile si vous voulez une playlist sans foc&eacute;ment vouloir la garder pour plus tard. La playlist de la session expire lorsque vous fermez votre navigateur ou que le timeout est
                        atteint (dur&eacute;e de vie maximum de la session d&eacute;finie par le serveur).
                        <br>
                        <br></td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong>Nouvelles Playlists</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Ok, vous voulez en fait sauvegarder votre playlist, hmm? Apr&egrave;s l'avoir remplie de ce que vous vouliez, cliquez simplement sur &quot;New Playlist" dans le menu d&eacute;roulant des playlists. Un popup vous demandera le nom de cette playlist (veuillez utiliser uniquement
                        des caract&egrave;res alphanumeriques, les espaces sont admis...). Vous &ecirc;tes libres de revenir &eacute;diter cette playlist quand bon vous semblera ...
                        <br>
                        <br></td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong><strong>Playlists</strong> Existantes</strong></td>
                    <td width="70%" class="bodyBody">
                        Vous avez donc cr&eacute;&eacute; votre playlist, l'avez nomm&eacute;, tout ce que vous aurez &agrave; faire pou ajouter d'autres morceaux est de recommencer la manipulation d&eacute;crite ci-dessus (&eacute;tape de cr&eacute;ation d'une nouvelle playlist) et de s&eacute;lectionner
                        la liste ad&eacute;quate au lieu de &quot;New Playlist".<br>
                        <br></td>
                </tr>
            </table>
            <br><br>
            <strong>Visualiser ses Playlists</strong>
            <br>
            <br>
            On a cr&eacute;&eacute; quelques playlists, et vous voulez maintenant voir leur contenu, hmm? Tout ce que vous aurez &agrave; faire est de s&eacute;lectionner celle que vous voulez dans le menu d&eacute;roulant des playlists, et d'ensuite cliquer sur l'ic&ocirc;ne "View Playlist" (&agrave;
            doite du menu d&eacute;roulant).
            <br>
            <br>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong>Effacer un &eacute;l&eacute;ment </strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Pour effacer un unique &eacute;l&eacute;ment d'une liste, s&eacute;lectionnez-le en cliquant dans la checkbox &agrave; ses c&ocirc;t&eacute;s, puis &quot;Delete" au bas de la page. Ceci n'effacera pas v&eacute;ritablement la piste, mais l'enverra de la liste de lecture.
                        <br>
                        <br></td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong>Effacer une Playlist</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Vous pouvez aussi effacer tout une playlist. Cliquez sur "Delete Playlist", fastoche, hmm?
                        <br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="bodyBody" valign="top">
                        <strong>Envoyer une Playlist</strong>
                    </td>
                    <td width="70%" class="bodyBody">
                        Ca nous a sembl&eacute; sympa, et depuis on l'utilise pas mal. Consid&eacute;rons que vous venez de cr&eacute;er une liste vraiment cool et que vous voulez la faire &eacute;couter &agrave; un de vos amis. Vous n'aurez qu'&agrave; cliquer sur "Send Playlist", et un email sera
                        g&eacute;n&eacute;r&eacute; (utilisant une balise mailto HREF) avec un sujet et une body d&eacute;j&agrave; pr&eacute;-remplis. Le body contiendra un lien vers cette playlist, qui ordonnera &agrave; Jinzora de la g&eacute;n&eacute;rer si l'on clique dessus. Vos amis n'auront
                        pas besoin de login pour l'&eacute;couter, et ne seront pas non plus redirig&eacute;s vers une page web, leur player lira uniquement les morceaux. Ce peut &ecirc;tre un bon moyen de faire d&eacute;couvrir votre musique sans donner des acc&egrave;s &agrave; votre Jinzora
                        &agrave; tout le monde!
                        <br>
                        <br></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

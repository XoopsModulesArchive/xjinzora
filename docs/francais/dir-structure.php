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

        <td width="100%" class="bodyBody"><p><strong>Structure des r&eacute;pertoires</strong><br>
                <br>
                Plusieurs diff&eacute;rentes structures de r&eacute;pertoires marcheront
                correctement avec Jinzora. Aucune d'entres elles n'est impos&eacute;e,
                mais celles qui sont propos&eacute;es sont FORTEMENT recommand&eacute;es.
                Reconnaissez-le, si votre collection est terriblement mal organis&eacute;e,
                on imagine difficilement Jinzora le faire pour vous n'est-ce pas? Plus
                vous passerez du temps &agrave; organiser votre collection, plus Jinzora
                fonctionnera normalement. Les trois structures conseill&eacute;es sont:<br>
                <br>
            </p>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>

                    <td width="30%" valign="top" class="bodyBody"><strong>Par Genres</strong></td>

                    <td width="70%" class="bodyBody"> Dans cette organisation par styles
                        musicaux Jinzora consid&egrave;re que vous suivrez une structure de
                        dossiers telle que:<br>
                        <br>
                        Genres/Artistes/Albums/Pistes<br>
                        <br>
                        Bien que Jinzora affichera tous les fichiers mp3 disc&eacute;min&eacute;s
                        dans l'arborescence, il s'attend tout de m&ecirc;me &agrave; les trouver
                        organis&eacute;s selon cette structure qu'il utilisera pour naviguer
                        dans votre collection.<br>
                        <br>
                        <strong>NOTE:</strong> C'est de cette mani&egrave;re que le principal
                        d&eacute;veloppeur de Jinzora l'utilise, c'est notre organigramme
                        de pr&eacute;dilection, par cons&eacute;quent le plus test&eacute;.<br>
                        <br>
                    </td>
                </tr>
                <tr>

                    <td width="30%" valign="top" class="bodyBody"><strong>Par Artistes</strong></td>

                    <td width="70%" class="bodyBody"> Dans l'organisation par artistes Jinzora
                        consid&egrave;re que vous suivrez une structure de dossiers telle
                        que:<br>
                        <br>
                        Artistes/Albums/Pistes<br>
                        <br>
                        Bien que Jinzora affichera tous les fichiers mp3 disc&eacute;min&eacute;s
                        dans l'arborescence, il s'attend tout de m&ecirc;me &agrave; les trouver
                        organis&eacute;s selon cette structure qu'il utilisera pour naviguer
                        dans votre collection.<br>
                        <br>
                    </td>
                </tr>
                <tr>

                    <td width="30%" valign="top" class="bodyBody"><strong> Par Albums</strong>
                    </td>

                    <td width="70%" class="bodyBody"><p>Dans l'organisation par albums
                            Jinzora consid&egrave;re que vous suivrez une structure de dossiers
                            telle que:</p>
                        <p><br>
                            Albums/Pistes <br>
                            <br>
                            Bien que Jinzora affichera tous les fichiers mp3 disc&eacute;min&eacute;s
                            dans l'arborescence, il s'attend tout de m&ecirc;me &agrave; les
                            trouver organis&eacute;s selon cette structure qu'il utilisera pour
                            naviguer dans votre collection.<br>
                            <br>
                            <strong>NOTE:</strong> C'est la structure la moins test&eacute;e!<br>
                            <br>
                            <br>
                            <br>
                        </p></td>
                </tr>
            </table>
            <br><br>
        </td>
    </tr>
</table>
</body>

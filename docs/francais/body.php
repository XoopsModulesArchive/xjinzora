<?php

// Let's see if they submitted the search button
if (isset($_POST['searchButton'])) {
    // Ok, they want to search, so let's do it...

    // We'll go through each file, one by one building an array with their name and contents

    $d = dir('./' . $lang_file);

    $c = 0;

    $resultArray = '';

    while ($entry = $d->read()) {
        // Let's make sure we are seeing real directories

        if ('.' == $entry || '..' == $entry) {
            continue;
        }

        if (mb_stristr($entry, '.php') and '' != $_POST['searchData']) {
            $filename = './' . $lang_file . '/' . $entry;

            $handle = fopen($filename, 'rb');

            $contents = fread($handle, filesize($filename));

            fclose($handle);

            // Now let's test for the data

            if (mb_stristr(mb_strtolower($contents), mb_strtolower($_POST['searchData']))) {
                $resultArray[$c] = $entry;

                $c++;
            }
        }
    }

    // Now let's close the directory

    $d->close();

    // Now let's see if we got data back

    // Added stripping of the .php on the file names for pretter displaying - hey, thanks Joel!!!

    if (0 != $c) {
        echo '<strong>Search Results</strong><br><br>';

        for ($ctr = 0, $ctrMax = count($resultArray); $ctr < $ctrMax; $ctr++) {
            if ('' != $resultArray[$ctr] and 'leftnav.php' != $resultArray[$ctr] and 'body.php' != $resultArray[$ctr] and 'topnav.php' != $resultArray[$ctr]) {
                echo '<li><a href="' . $lang_file . '/' . $resultArray[$ctr] . '">' . str_replace('.php', '', $resultArray[$ctr]) . '</a></li><br>';
            }
        }

        exit();
    }  

    echo "<br><strong>Sorry, but we didn't find anything...</strong>";

    exit();
}
?>
<p><strong>Bienvenue sur l'aide de Jinzora!</strong><br>
    <br>
    Merci d'essayer Jinzora, nous esp&eacute;rons que vous l'aimerez autant que
    nous! Jinzora est un script c&ocirc;t&eacute; serveur destin&eacute; &agrave;
    faire du streaming, initialement destin&eacute; au format MP3 (peut aussi &ecirc;tre
    utilis&eacute; pour streamer tout m&eacute;dia depuis un serveur HTTP). Jinzora
    peut &ecirc;tre utilis&eacute; en module sur un site PostNuke ou PHPNuke, s'ex&eacute;cuter
    seul, ou encore &ecirc;tre int&eacute;gr&eacute; dans un site &eacute;crit en
    PHP.<br>
</p>
<p>Veuillez choisir une cat&eacute;gorie dans la colonne de gauche<br>
    <br>
    ...ou...<br>
</p>
<p>Utilisez le champ de recherche pour une reponse rapide!<br>
    <br>
    ...ou...<br>
    <br>
    <strong>Choisissez parmi:</strong><br>
</p>
<li>Rapide description de l'installation</li>
<br>
<li>Ajouter sa musique dans Jinzora</li>
<br>
<li>Securiser Jinzora</li>
<br>
<li>Devenir membre du projet</li>
<br>
<li>Faire un don au projet</li>

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
<strong>Welcome to the Jinzora Help System!</strong><br><br>
Thanks for trying out Jinzora, we hope that you'll love it as much as we do!
Jinzora is a Web-based media streamer, primarily desgined to stream MP3s
(but can be used for any media file that can stream from HTTP).
Jinzora can be integrated into a PostNuke site, a PHPNuke site,
run as a standalone application, or integrated into any PHP website.<br><br>
Please select from the topic you'd like to view from the left<br><br>
...or...<br><br>
Use the search tool above to find what you're looking for fast!<br><br>
...or...<br><br>
<strong>Select one of the following:</strong><br><br>
<li>Quick Install Guide</li><br>
<li>Adding Music to Jinzora</li><br>
<li>Securing Jinzora</li><br>
<li>Becoming a Project Member</li><br>
<li>Donating to the Project</li>

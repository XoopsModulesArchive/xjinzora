<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* JINZORA | Web-based Media Streamer
*
* Jinzora is a Web-based media streamer, primarily desgined to stream MP3s
* (but can be used for any media file that can stream from HTTP).
* Jinzora can be integrated into a CMS site, run as a standalone application,
* or integrated into any PHP website.  It is released under the GNU GPL.
*
* Jinzora Author:
* Ross Carlson: ross@jasbone.com
* http://www.jinzora.org
* Documentation: http://www.jinzora.org/docs
* Support: http://www.jinzora.org/forum
* Downloads: http://www.jinzora.org/downloads
* License: GNU GPL <http://www.gnu.org/copyleft/gpl.html>
*
* Contributors:
* Please see http://www.jinzora.org/modules.php?op=modload&name=jz_whois&file=index
*
* Code Purpose: This page contains the display functions for the Top track rating system
* Created: 9.24.03 by Ross Carlson
*
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

function cmp2($a, $b)
{
    $cmp = strcmp($a[3], $b[3]);

    return $cmp ?: -1;
}

// Let's make sure they wanted suggestions
if ('true' == $enable_suggestions) {
    // Ok, let's index the ratings directory and get all the ratings from each file into one variable

    $retArray = readDirInfo($web_root . $root_dir . '/data', 'file');

    $contents = '';

    for ($ctr = 0, $ctrMax = count($retArray); $ctr < $ctrMax; $ctr++) {
        if ('' != $retArray[$ctr]) {
            $filename = $web_root . $root_dir . '/data/' . $retArray[$ctr];

            $handle = fopen($filename, 'rb');

            $contents .= fread($handle, filesize($filename));

            fclose($handle);
        }
    }

    // Now let's make sure we got ratings back

    if ('' != $contents) {
        // Now let's create an array out of this, breaking at each line

        $conArray = explode("\n", $contents);

        // Now we need to sort that array by the file name so we can compare on it

        usort($conArray, 'cmp2');

        $c = 0;

        // Let's make sure we are looking at 5 rated tracks

        for ($ctr = 0, $ctrMax = count($conArray); $ctr < $ctrMax; $ctr++) {
            if (mb_stristr($conArray[$ctr], '|5|')) {
                $finalArray[$c] = $conArray[$ctr];

                $c++;
            }
        }

        // Now let's read that final array

        for ($ctr = 0, $ctrMax = count($finalArray); $ctr < $ctrMax; $ctr++) {
            // Now let's make sure this isn't the first entry

            if (0 != $ctr) {
                // Now let's get arrays so we can comapre the filenames

                $dataArray = explode('|', $finalArray[$ctr]);

                $compArray = explode('|', $finalArray[$ctr - 1]);

                // Now let's compare and get a user that also likes what we like

                if ($dataArray[3] == $compArray[3]) {
                    // Let's make sure it isn't us we're looking at

                    if ($compArray[2] != $_COOKIE['jz_user_name']) {
                        // Ok, we found a similar user, so let's keep them for later

                        $similarUser = $compArray[2];

                        // Let's exit this loop

                        $ctr = count($finalArray) + 1;
                    }
                }
            }
        }

        // Now let's see if we got a user that is like us

        if ('' != $similarUser) {
            $c = 0;

            for ($ctr = 0, $ctrMax = count($finalArray); $ctr < $ctrMax; $ctr++) {
                // Now let's see if we got one by the same user

                if (mb_stristr($finalArray[$ctr], '|' . $similarUser)) {
                    // Now we need to make sure that the current uesr didn't rate any of these songs

                    $fileArray = explode('|', $finalArray[$ctr]);

                    $filename = $web_root . $root_dir . '/data/ratings/' . $fileArray[3] . '.rating';

                    $handle = fopen($filename, 'rb');

                    $contents = fread($handle, filesize($filename));

                    fclose($handle);

                    if (!mb_stristr($contents, $_COOKIE['jz_user_name'])) {
                        $suggestionArray[$c][0] = '-5';

                        $suggestionArray[$c][1] = str_replace('---', '/', $fileArray[3]);

                        $c++;
                    }
                }
            }
        }

        // Let's make sure they wanted to see top tracks

        if ('0' != $num_suggestions and 0 != count($suggestionArray) and 'anonymous' != $_COOKIE['jz_user_name']) {
            echo '<strong>Jinzora Suggestions</strong><br>';

            // Now let's shuffle the results before we send them back

            shuffle($suggestionArray);

            displayRatedTracks($suggestionArray, 'false', $num_suggestions);
        }
    }
}

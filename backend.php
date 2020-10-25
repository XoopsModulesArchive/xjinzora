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
* Code Purpose: This page generates all the data needed by the front end to create the interface
* Created: 9.24.03 by Ross Carlson
*
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

createXML();

require __DIR__ . '/settings.php';
require __DIR__ . '/system.php';
require __DIR__ . '/general.php';
require __DIR__ . '/display.php';
require __DIR__ . '/playlists.php';
require __DIR__ . '/classes.php';

// This function creates the XML data needed by the front end interface
function createXML($search = '')
{
    // TO DO: FIX THIS!!!

    $media_dir_array = [
        '0' => ['/var/www/ross/modules/jinzora/desktop-music', 'music'],
    ];

    $audio_types = 'mp3|ogg|wma|wav';

    $video_types = 'avi|mpg|wmv|mpeg';

    $ext_graphic = 'jpg|gif|png|jpeg';

    $ctr = 0;

    $mediaArray = '';

    // Ok, let's read the directories here to get all the data

    for ($i = 0, $iMax = count($media_dir_array); $i < $iMax; $i++) {
        readData($media_dir_array[$i][0], $media_dir_array[$i][1], $ctr, $mediaArray);
    }

    // Let's set some default values for later

    $oldGenre = 'NULL_DATA';

    $oldArtist = 'NULL_DATA';

    $oldAlbum = 'NULL_DATA';

    $fGenre = 'yes';

    $fArtist = 'yes';

    $fAlbum = 'yes';

    // Ok, now that we got the data back let's build the XML

    for ($i = 0, $iMax = count($mediaArray); $i < $iMax; $i++) {
        // Now we need to look at the data we got back to extract from it

        $dataArray = explode('-||-', $mediaArray[$i]);

        $pathArray = explode('/', $dataArray[0]);

        $fileName = $pathArray[count($pathArray) - 1];

        $albumName = $pathArray[count($pathArray) - 2];

        $artistName = $pathArray[count($pathArray) - 3];

        $genreName = $pathArray[count($pathArray) - 4];

        // Now let's make sure we didn't really see the root path!

        for ($c = 0, $cMax = count($media_dir_array); $c < $cMax; $c++) {
            if (mb_stristr($media_dir_array[$c][0], $genreName)) {
                $genreName = '';
            }

            if (mb_stristr($media_dir_array[$c][0], $artistName)) {
                $artistName = '';
            }

            if (mb_stristr($media_dir_array[$c][0], $albumName)) {
                $albumName = '';
            }
        }

        // Ok, now we need to group all this stuff

        if ($genreName != $oldGenre) {
            $oldGenre = $genreName;

            if ('yes' == $fGenre) {
                echo '<genre name="' . $genreName . '">' . "\n";

                $fGenre = 'no';
            } else {
                echo '      </album>' . "\n";

                echo '   </artist>' . "\n";

                echo '</genre>' . "\n";

                echo '<genre name="' . $genreName . '">' . "\n";

                $fAlbum = 'yes';

                $fArtist = 'yes';
            }
        }

        if ($artistName != $oldArtist) {
            $oldArtist = $artistName;

            $fAlbum = 'yes';

            if ('yes' == $fArtist) {
                $fArtist = 'no';

                if ('yes' != $fAlbum) {
                    echo '</album>' . "\n";

                    echo '</artist>' . "\n";
                }

                echo '   <artist name="' . $artistName . '">' . "\n";
            } else {
                echo '      </album>' . "\n";

                echo '   </artist>' . "\n" . '   <artist name="' . $artistName . '">' . "\n";
            }
        }

        if ($albumName != $oldAlbum) {
            $oldAlbum = $albumName;

            if ('yes' == $fAlbum) {
                $fAlbum = 'no';

                echo '      <album name="' . $albumName . '">' . "\n";
            } else {
                echo '      </album>' . "\n";

                echo '      <album name="' . $albumName . '">' . "\n";
            }

            // Now let's see if this is a track or image

            if (preg_match("/\.($audio_types)$/i", $fileName) || preg_match("/\.($video_types)$/i", $fileName)) {
                echo '         <track_data name="' . $fileName . '"></track_data>' . "\n";
            }

            if (preg_match("/\.($ext_graphic)$/i", $fileName)) {
                echo '         <img_data name="' . $fileName . '"></img_data>' . "\n";
            }
        } else {
            // Now let's see if this is a track or image

            if (preg_match("/\.($audio_types)$/i", $fileName) || preg_match("/\.($video_types)$/i", $fileName)) {
                echo '         <track_data name="' . $fileName . '"></track_data>' . "\n";
            }

            if (preg_match("/\.($ext_graphic)$/i", $fileName)) {
                echo '         <img_data name="' . $fileName . '"></img_data>' . "\n";
            }
        }
    }

    echo "      </album>\n   </artist>\n</genre>";
}

// This function returns all the information from the disk(s)
function readData($dirName, $virtDir, &$ctr, &$mediaArray)
{
    global $audio_types, $video_types;

    // TO DO: FIX THIS!!!

    $audio_types = 'mp3|ogg|wma|wav';

    $video_types = 'avi|mpg|wmv|mpeg';

    $ext_graphic = 'jpg|gif|png|jpeg';

    $d = dir($dirName);

    while ($entry = $d->read()) {
        // Let's make sure we are seeing real directories

        if ('.' == $entry || '..' == $entry) {
            continue;
        }

        // Now let's see if we are looking at a directory or not

        if ('dir' == filetype($dirName . '/' . $entry) or 'link' == filetype($dirName . '/' . $entry)) {
            readData($dirName . '/' . $entry, $virtDir, $ctr, $mediaArray);
        }

        // Now let's see if we are looking at a file

        if ('file' == filetype($dirName . '/' . $entry)) {
            // Now let's see if this is a known file type

            if (preg_match("/\.($audio_types)$/i", $entry) || preg_match("/\.($video_types)$/i", $entry) || preg_match("/\.($ext_graphic)$/i", $entry)) {
                $mediaArray[$ctr] = $dirName . '/' . $entry . '-||-' . $virtDir;

                $ctr++;
            }
        }
    }

    // Now let's close the directory

    $d->close();
}

<?php

/**
 * - JINZORA | Web-based Media Streamer -
 *
 * Jinzora is a Web-based media streamer, primarily desgined to stream MP3s
 * (but can be used for any media file that can stream from HTTP).
 * Jinzora can be integrated into a CMS site, run as a standalone application,
 * or integrated into any PHP website.  It is released under the GNU GPL.
 *
 * - Ressources -
 * - Jinzora Author: Ross Carlson <ross@jasbone.com>
 * - Web: http://www.jinzora.org
 * - Documentation: http://www.jinzora.org/docs
 * - Support: http://www.jinzora.org/forum
 * - Downloads: http://www.jinzora.org/downloads
 * - License: GNU GPL <http://www.gnu.org/copyleft/gpl.html>
 *
 * - Contributors -
 * Please see http://www.jinzora.org/modules.php?op=modload&name=jz_whois&file=index
 *
 * - Code Purpose -
 * - This page generate all RSS feeds
 * - It need the 'type' GET paramter
 *
 * @since  02.02.04
 * @author Laurent Perrin <laurent@la-base.org>
 */
require __DIR__ . '/id3classes/getid3.php';
require __DIR__ . '/general.php';
require __DIR__ . '/settings.php';
require __DIR__ . '/system.php';
require __DIR__ . '/files.lib.php';

// Now let's include the functions we need to access the media
require_once __DIR__ . '/adaptors/' . $adaptor_type . '/required.php';

// let's send the beginning of the XML file
header('Content-type: text/xml');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>'
     . "\n"
     . '<rdf:RDF'
     . "\n"
     . 'xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"'
     . "\n"
     . 'xmlns="http://purl.org/rss/1.0/"'
     . "\n"
     . 'xmlns:dc="http://purl.org/dc/elements/1.1/"'
     . "\n"
     . 'xmlns:slash="http://purl.org/rss/1.0/modules/slash/"'
     . "\n"
     . 'xmlns:taxo="http://purl.org/rss/1.0/modules/taxonomy/"'
     . "\n"
     . 'xmlns:admin="http://webns.net/mvcb/"'
     . "\n"
     . 'xmlns:syn="http://purl.org/rss/1.0/modules/syndication/"'
     . "\n"
     . '>'
     . "\n"
     . '<channel>'
     . "\n"
     . '<title>Jinzora RSS</title>'
     . "\n"
     . '<link>http://www.jinzora.org</link>'
     . "\n"
     . "<description>Jinzora top tracks</description>\n"
     . '</channel>'
     . "\n";

// let's get every top list they want
$types = explode(':', $_GET['type']);
foreach ($types as $type) {
    switch ($type) {
        case 'last-played':
            // Now let's see if they wanted to filter this by a single user
            if (isset($_GET['user'])) {
                // Ok, we want a specific user so let's read thier last played file

                $fileName = $web_root . $root_dir . '/data/users/' . $_GET['user'] . '.last';

                if (is_file($fileName)) {
                    $handle = fopen($fileName, 'rb');

                    $contents = fread($handle, filesize($fileName));

                    fclose($handle);

                    // Now let's figure out the album that was so we can get it's art

                    $dataArray = explode('---', $contents);

                    unset($dataArray[count($dataArray) - 1]);

                    $readDir = '';

                    for ($e = 0, $eMax = count($dataArray); $e < $eMax; $e++) {
                        $readDir .= '/' . $dataArray[$e];
                    }

                    // Now let's set the artist/album info

                    $genre = $dataArray[0];

                    $artist = $dataArray[1];

                    $album = $dataArray[2];

                    // Now let's read that directory and get the album art

                    $retArray = readDirInfo($web_root . $root_dir . $media_dir . $readDir, 'file');

                    for ($e = 0, $eMax = count($retArray); $e < $eMax; $e++) {
                        if (preg_match("/\.($ext_graphic)$/i", $retArray[$e])) {
                            $image = $root_dir . $media_dir . str_replace('%2F', '/', rawurlencode($readDir)) . '/' . rawurlencode($retArray[$e]);
                        }
                    }

                    // Now let's creat the XML

                    echo '<image rdf:about="' . $this_site . $image . '">' . "\n" . '<title>Last Played by ' . ucwords($_GET['user']) . '</title>' . "\n" . '<url>' . $this_site . $image . '</url>' . "\n" . '<link>http://www.jinzora.org/</link>' . "\n" . '</image>';

                    echo "<item>\n"
                         . '<title>Last Played by '
                         . ucwords($_GET['user'])
                         . "</title>\n"
                         . '<link>http://'
                         . $_SERVER['SERVER_NAME']
                         . "$root_dir/playlists.php?d=1&amp;style=normal&amp;info="
                         . urlencode($genre)
                         . '/'
                         . urlencode($artist)
                         . '/'
                         . urlencode($album)
                         . '/'
                         . "</link>\n"
                         . "<description><![CDATA[]]></description>\n"
                         . "</item>\n";

                    echo '</rdf:RDF>';
                }

                exit();
            }  
                $topTracks = processDataFiles('counter', 'getMTime', $last_played_nb);
                break;
            // no break
        case 'most-played':
            $topTracks = processDataFiles('counter', 'getNbPlay', $most_played_nb);
            break;
        case 'last-rated':
            $topTracks = processDataFiles('ratings', 'getMTime', $last_rated_nb);
            break;
        case 'most-rated':
            $topTracks = processDataFiles('ratings', 'getRateNb', $most_rated_nb);
            break;
        case 'top-rated':
            $topTracks = processDataFiles('ratings', 'getRate', $top_rated_nb);
            break;
        case 'last-added':
            $topFolders = array_keys(processDataFiles('tracks', 'getMTime', $last_added_nb));
            $topTracks = [];
            foreach ($topFolders as $folder) {
                $topTracks = array_merge($topTracks, processMediaFiles(str_replace('/NULL', '', $folder), 'getMTime', $last_added_nb));
            }
            arsort($topTracks);
            array_slice($topTracks, 0, $last_added_nb);
            break;
        case 'last-discussed':
            $topTracks = processDataFiles('discussions', 'getMTime', $last_discussed_nb);
            break;
        case 'most-discussed':
            $topTracks = processDataFiles('discussions', 'getDiscussNb', $most_discussed_nb);
            break;
        case 'last-downloaded':
            $topTracks = processDataFiles('download', 'getMTime', $last_rated_nb);
            break;
        case 'most-downloaded':
            $topTracks = processDataFiles('download', 'getNbPlay', $most_rated_nb);
            break;
        default:
            echo 'Usage : rss.php?type=last-played:most-played:last-rated:most-rated:top-rated:last-added:last-discussed:most-discussed';
            exit;
    } // switch

    // display the results

    if (false !== $topTracks && 0 != count($topTracks)) {
        displayRatedTracksXML($topTracks, $type);
    }
}

// Now let's close out...
echo '</rdf:RDF>';

/**
 * Displays XML compliant RSS for the given tracks (only the part between <item> tags)
 *
 * @param array  $tracks array of tracks to be displayed. keys are filenames and values are ranks.
 * @param string $type   type of ranks to be displayed
 * @since   02/02/04
 * @author  Laurent Perrin
 * @version 02/02/04
 */
function displayRatedTracksXML($tracks, $type)
{
    global $this_site, $root_dir, $top_rated_nb;

    // reads track XML files to get tracks name and description

    $tracks_info = getTracksInfos(array_keys($tracks));

    foreach ($tracks as $track => $top_rated_nb) {
        // Let's make sure the title isn't blank

        // We'll only show tracks here

        if ('' != $tracks_info[$track]['name']) {
            echo "<item>\n" . '<title>' . str_replace('&', '&amp;', $tracks_info[$track]['name']);

            // Now let's see if there was a count or rating

            if ((0 != $tracks_info[$track]['counter'] and '' != $tracks_info[$track]['counter']) and ('last-played' == $_GET['type'] or 'most-played' == $_GET['type'])) {
                echo ' (' . $tracks_info[$track]['counter'] . ')';
            }

            if ((0 != $tracks_info[$track]['downloads'] and '' != $tracks_info[$track]['downloads']) and ('last-downloaded' == $_GET['type'] or 'most-downloaded' == $_GET['type'])) {
                echo ' (' . $tracks_info[$track]['downloads'] . ')';
            }

            if ((0 != $tracks_info[$track]['rating'] and '' != $tracks_info[$track]['rating']) and ('last-rated' == $_GET['type'] or 'most-rated' == $_GET['type'] or 'top-rated' == $_GET['type'])) {
                echo ' (' . $tracks_info[$track]['rating'] . ')';
            }

            echo "</title>\n"
                 . '<link>http://'
                 . $_SERVER['SERVER_NAME']
                 . "$root_dir/playlists.php?d=1&amp;style=normal&amp;qptype=song&amp;info="
                 . str_replace('&', '&amp;', $track)
                 . "</link>\n"
                 . '<description><![CDATA['
                 . formatDescription($tracks_info[$track])
                 . "]]></description>\n"
                 . "</item>\n";
        }
    }
}

/**
 * Formats description from track informations
 *
 * @param array $track_info track informations
 * @return string description
 *                          *@since 02/04/04
 * @author  Laurent Perrin
 * @version 02/04/04
 */
function formatDescription($track_info)
{
    if ('' != $track_info['genre']) {
        $lines[] = $track_info['genre'];
    }

    if ('' != $track_info['artist']) {
        $lines[] = $track_info['artist'];
    }

    if ('' != $track_info['album']) {
        $lines[] = $track_info['album'];
    }

    if ('NULL' != $track_info['mp3_comment']) {
        $lines[] = str_replace('&', '&amp;', $track_info['mp3_comment']);
    }

    return implode(' - ', $lines);
}

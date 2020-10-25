<?php
/////////////////////////////////////////////////////////////////
/// getID3() by James Heinrich <info@getid3.org>               //
//  available at http://getid3.sourceforge.net                 //
//            or http://www.getid3.org                         //
/////////////////////////////////////////////////////////////////
// See readme.txt for more details                             //
/////////////////////////////////////////////////////////////////
///                                                            //
// module.tag.lyrics3.php                                      //
// module for analyzing Lyrics3 tags                           //
// dependencies: module.tag.apetag.php (optional)              //
//                                                            ///
/////////////////////////////////////////////////////////////////

class getid3_lyrics3
{
    public function __construct($fd, &$ThisFileInfo)
    {
        // http://www.volweb.cz/str/tags.htm

        fseek($fd, (0 - 128 - 9 - 6), SEEK_END); // end - ID3v1 - LYRICSEND - [Lyrics3size]

        $lyrics3_id3v1 = fread($fd, (128 + 9 + 6));

        $lyrics3lsz = mb_substr($lyrics3_id3v1, 0, 6); // Lyrics3size
        $lyrics3end = mb_substr($lyrics3_id3v1, 6, 9); // LYRICSEND or LYRICS200
        $id3v1tag = mb_substr($lyrics3_id3v1, 15, 128); // ID3v1

        if ('LYRICSEND' == $lyrics3end) {
            // Lyrics3v1, ID3v1, no APE

            $lyrics3size = 5100;

            $lyrics3offset = $ThisFileInfo['filesize'] - 128 - $lyrics3size;

            $lyrics3version = 1;
        } elseif ('LYRICS200' == $lyrics3end) {
            // Lyrics3v2, ID3v1, no APE

            // LSZ = lyrics + 'LYRICSBEGIN'; add 6-byte size field; add 'LYRICS200'

            $lyrics3size = $lyrics3lsz + 6 + mb_strlen('LYRICS200');

            $lyrics3offset = $ThisFileInfo['filesize'] - 128 - $lyrics3size;

            $lyrics3version = 2;
        } elseif (mb_substr(strrev($lyrics3_id3v1), 0, 9) == strrev('LYRICSEND')) {
            // Lyrics3v1, no ID3v1, no APE

            $lyrics3size = 5100;

            $lyrics3offset = $ThisFileInfo['filesize'] - $lyrics3size;

            $lyrics3version = 1;

            $lyrics3offset = $ThisFileInfo['filesize'] - $lyrics3size;
        } elseif (mb_substr(strrev($lyrics3_id3v1), 0, 9) == strrev('LYRICS200')) {
            // Lyrics3v2, no ID3v1, no APE

            $lyrics3size = strrev(mb_substr(strrev($lyrics3_id3v1), 9, 6)) + 6 + mb_strlen('LYRICS200'); // LSZ = lyrics + 'LYRICSBEGIN'; add 6-byte size field; add 'LYRICS200'

            $lyrics3offset = $ThisFileInfo['filesize'] - $lyrics3size;

            $lyrics3version = 2;
        } else {
            if (isset($ThisFileInfo['ape']['tag_offset_start']) && ($ThisFileInfo['ape']['tag_offset_start'] > 15)) {
                fseek($fd, $ThisFileInfo['ape']['tag_offset_start'] - 15, SEEK_SET);

                $lyrics3lsz = fread($fd, 6);

                $lyrics3end = fread($fd, 9);

                if ('LYRICSEND' == $lyrics3end) {
                    // Lyrics3v1, APE, maybe ID3v1

                    $lyrics3size = 5100;

                    $lyrics3offset = $ThisFileInfo['ape']['tag_offset_start'] - $lyrics3size;

                    $ThisFileInfo['avdataend'] = $lyrics3offset;

                    $lyrics3version = 1;

                    $ThisFileInfo['warning'][] = 'APE tag located after Lyrics3, will probably break Lyrics3 compatability';
                } elseif ('LYRICS200' == $lyrics3end) {
                    // Lyrics3v2, APE, maybe ID3v1

                    $lyrics3size = $lyrics3lsz + 6 + mb_strlen('LYRICS200'); // LSZ = lyrics + 'LYRICSBEGIN'; add 6-byte size field; add 'LYRICS200'

                    $lyrics3offset = $ThisFileInfo['ape']['tag_offset_start'] - $lyrics3size;

                    $lyrics3version = 2;

                    $ThisFileInfo['warning'][] = 'APE tag located after Lyrics3, will probably break Lyrics3 compatability';
                }
            }
        }

        if (isset($lyrics3offset)) {
            $ThisFileInfo['avdataend'] = $lyrics3offset;

            $this->getLyrics3Data($ThisFileInfo, $fd, $lyrics3offset, $lyrics3version, $lyrics3size);

            if (!isset($ThisFileInfo['ape'])) {
                $GETID3_ERRORARRAY = &$ThisFileInfo['warning'];

                if (getid3_lib::IncludeDependency(GETID3_INCLUDEPATH . 'module.tag.apetag.php', __FILE__, false)) {
                    $tag = new getid3_apetag($fd, $ThisFileInfo, $ThisFileInfo['lyrics3']['tag_offset_start']);
                }
            }
        }

        return true;
    }

    public function getLyrics3Data(&$ThisFileInfo, $fd, $endoffset, $version, $length)
    {
        // http://www.volweb.cz/str/tags.htm

        fseek($fd, $endoffset, SEEK_SET);

        $rawdata = fread($fd, $length);

        if ('LYRICSBEGIN' != mb_substr($rawdata, 0, 11)) {
            if (false !== mb_strpos($rawdata, 'LYRICSBEGIN')) {
                $ThisFileInfo['warning'][] = '"LYRICSBEGIN" expected at ' . $endoffset . ' but actually found at ' . ($endoffset + mb_strpos($rawdata, 'LYRICSBEGIN')) . ' - this is invalid for Lyrics3 v' . $version;

                $ThisFileInfo['avdataend'] = $endoffset + mb_strpos($rawdata, 'LYRICSBEGIN');

                $ParsedLyrics3['tag_offset_start'] = $ThisFileInfo['avdataend'];

                $rawdata = mb_substr($rawdata, mb_strpos($rawdata, 'LYRICSBEGIN'));

                $length = mb_strlen($rawdata);
            } else {
                $ThisFileInfo['error'][] = '"LYRICSBEGIN" expected at ' . $endoffset . ' but found "' . mb_substr($rawdata, 0, 11) . '" instead';

                return false;
            }
        }

        $ParsedLyrics3['raw']['lyrics3version'] = $version;

        $ParsedLyrics3['raw']['lyrics3tagsize'] = $length;

        $ParsedLyrics3['tag_offset_start'] = $endoffset;

        $ParsedLyrics3['tag_offset_end'] = $endoffset + $length;

        switch ($version) {
            case 1:
                if ('LYRICSEND' == mb_substr($rawdata, mb_strlen($rawdata) - 9, 9)) {
                    $ParsedLyrics3['raw']['LYR'] = trim(mb_substr($rawdata, 11, mb_strlen($rawdata) - 11 - 9));

                    $this->Lyrics3LyricsTimestampParse($ParsedLyrics3);
                } else {
                    $ThisFileInfo['error'][] = '"LYRICSEND" expected at ' . (ftell($fd) - 11 + $length - 9) . ' but found "' . mb_substr($rawdata, mb_strlen($rawdata) - 9, 9) . '" instead';

                    return false;
                }
                break;
            case 2:
                if ('LYRICS200' == mb_substr($rawdata, mb_strlen($rawdata) - 9, 9)) {
                    $ParsedLyrics3['raw']['unparsed'] = mb_substr($rawdata, 11, mb_strlen($rawdata) - 11 - 9 - 6); // LYRICSBEGIN + LYRICS200 + LSZ

                    $rawdata = $ParsedLyrics3['raw']['unparsed'];

                    while (mb_strlen($rawdata) > 0) {
                        $fieldname = mb_substr($rawdata, 0, 3);

                        $fieldsize = (int)mb_substr($rawdata, 3, 5);

                        $ParsedLyrics3['raw'][(string)$fieldname] = mb_substr($rawdata, 8, $fieldsize);

                        $rawdata = mb_substr($rawdata, 3 + 5 + $fieldsize);
                    }

                    if (isset($ParsedLyrics3['raw']['IND'])) {
                        $i = 0;

                        $flagnames = ['lyrics', 'timestamps', 'inhibitrandom'];

                        foreach ($flagnames as $flagname) {
                            if (mb_strlen($ParsedLyrics3['raw']['IND']) > ++$i) {
                                $ParsedLyrics3['flags'][(string)$flagname] = $this->IntString2Bool(mb_substr($ParsedLyrics3['raw']['IND'], $i, 1));
                            }
                        }
                    }

                    $fieldnametranslation = ['ETT' => 'title', 'EAR' => 'artist', 'EAL' => 'album', 'INF' => 'comment', 'AUT' => 'author'];

                    foreach ($fieldnametranslation as $key => $value) {
                        if (isset($ParsedLyrics3['raw'][(string)$key])) {
                            $ParsedLyrics3['comments'][(string)$value][] = trim($ParsedLyrics3['raw'][(string)$key]);
                        }
                    }

                    if (isset($ParsedLyrics3['raw']['IMG'])) {
                        $imagestrings = explode("\r\n", $ParsedLyrics3['raw']['IMG']);

                        foreach ($imagestrings as $key => $imagestring) {
                            if (false !== mb_strpos($imagestring, '||')) {
                                $imagearray = explode('||', $imagestring);

                                $ParsedLyrics3['images'][(string)$key]['filename'] = $imagearray[0];

                                $ParsedLyrics3['images'][(string)$key]['description'] = $imagearray[1];

                                $ParsedLyrics3['images'][(string)$key]['timestamp'] = $this->Lyrics3Timestamp2Seconds($imagearray[2]);
                            }
                        }
                    }

                    if (isset($ParsedLyrics3['raw']['LYR'])) {
                        $this->Lyrics3LyricsTimestampParse($ParsedLyrics3);
                    }
                } else {
                    $ThisFileInfo['error'][] = '"LYRICS200" expected at ' . (ftell($fd) - 11 + $length - 9) . ' but found "' . mb_substr($rawdata, mb_strlen($rawdata) - 9, 9) . '" instead';

                    return false;
                }
                break;
            default:
                $ThisFileInfo['error'][] = 'Cannot process Lyrics3 version ' . $version . ' (only v1 and v2)';

                return false;
                break;
        }

        if (isset($ThisFileInfo['id3v1']['tag_offset_start']) && ($ThisFileInfo['id3v1']['tag_offset_start'] < $ParsedLyrics3['tag_offset_end'])) {
            $ThisFileInfo['warning'][] = 'ID3v1 tag information ignored since it appears to be a false synch in Lyrics3 tag data';

            unset($ThisFileInfo['id3v1']);

            foreach ($ThisFileInfo['warning'] as $key => $value) {
                if ('Some ID3v1 fields do not use NULL characters for padding' == $value) {
                    unset($ThisFileInfo['warning'][$key]);

                    sort($ThisFileInfo['warning']);

                    break;
                }
            }
        }

        $ThisFileInfo['lyrics3'] = $ParsedLyrics3;

        return true;
    }

    public function Lyrics3Timestamp2Seconds($rawtimestamp)
    {
        if (preg_match('^\\[([0-9]{2}):([0-9]{2})\\]$', $rawtimestamp, $regs)) {
            return (int)(($regs[1] * 60) + $regs[2]);
        }

        return false;
    }

    public function Lyrics3LyricsTimestampParse(&$Lyrics3data)
    {
        $lyricsarray = explode("\r\n", $Lyrics3data['raw']['LYR']);

        foreach ($lyricsarray as $key => $lyricline) {
            $regs = [];

            unset($thislinetimestamps);

            while (preg_match('^(\\[[0-9]{2}:[0-9]{2}\\])', $lyricline, $regs)) {
                $thislinetimestamps[] = $this->Lyrics3Timestamp2Seconds($regs[0]);

                $lyricline = str_replace($regs[0], '', $lyricline);
            }

            $notimestamplyricsarray[(string)$key] = $lyricline;

            if (isset($thislinetimestamps) && is_array($thislinetimestamps)) {
                sort($thislinetimestamps);

                foreach ($thislinetimestamps as $timestampkey => $timestamp) {
                    if (isset($Lyrics3data['synchedlyrics'][$timestamp])) {
                        // timestamps only have a 1-second resolution, it's possible that multiple lines

                        // could have the same timestamp, if so, append

                        $Lyrics3data['synchedlyrics'][$timestamp] .= "\r\n" . $lyricline;
                    } else {
                        $Lyrics3data['synchedlyrics'][$timestamp] = $lyricline;
                    }
                }
            }
        }

        $Lyrics3data['unsynchedlyrics'] = implode("\r\n", $notimestamplyricsarray);

        if (isset($Lyrics3data['synchedlyrics']) && is_array($Lyrics3data['synchedlyrics'])) {
            ksort($Lyrics3data['synchedlyrics']);
        }

        return true;
    }

    public function IntString2Bool($char)
    {
        if ('1' == $char) {
            return true;
        } elseif ('0' == $char) {
            return false;
        }

        return null;
    }
}

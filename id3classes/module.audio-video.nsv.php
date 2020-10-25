<?php
/////////////////////////////////////////////////////////////////
/// getID3() by James Heinrich <info@getid3.org>               //
//  available at http://getid3.sourceforge.net                 //
//            or http://www.getid3.org                         //
/////////////////////////////////////////////////////////////////
// See readme.txt for more details                             //
/////////////////////////////////////////////////////////////////
//                                                             //
// module.audio.nsv.php                                        //
// module for analyzing Nullsoft NSV files                     //
// dependencies: NONE                                          //
//                                                            ///
/////////////////////////////////////////////////////////////////

class getid3_nsv
{
    public function __construct($fd, &$ThisFileInfo)
    {
        fseek($fd, $ThisFileInfo['avdataoffset'], SEEK_SET);

        $NSVheader = fread($fd, 4);

        switch ($NSVheader) {
            case 'NSVs':
                if ($this->getNSVsHeaderFilepointer($fd, $ThisFileInfo, 0)) {
                    $ThisFileInfo['fileformat'] = 'nsv';

                    $ThisFileInfo['audio']['dataformat'] = 'nsv';

                    $ThisFileInfo['video']['dataformat'] = 'nsv';

                    $ThisFileInfo['audio']['lossless'] = false;

                    $ThisFileInfo['video']['lossless'] = false;
                }
                break;
            case 'NSVf':
                if ($this->getNSVfHeaderFilepointer($fd, $ThisFileInfo, 0)) {
                    $ThisFileInfo['fileformat'] = 'nsv';

                    $ThisFileInfo['audio']['dataformat'] = 'nsv';

                    $ThisFileInfo['video']['dataformat'] = 'nsv';

                    $ThisFileInfo['audio']['lossless'] = false;

                    $ThisFileInfo['video']['lossless'] = false;

                    $this->getNSVsHeaderFilepointer($fd, $ThisFileInfo, $ThisFileInfo['nsv']['NSVf']['header_length']);
                }
                break;
            default:
                $ThisFileInfo['error'][] = 'Expecting "NSVs" or "NSVf" at offset ' . $ThisFileInfo['avdataoffset'] . ', found "' . $NSVheader . '"';

                return false;
                break;
        }

        if (!isset($ThisFileInfo['nsv']['NSVf'])) {
            $ThisFileInfo['warning'][] = 'NSVf header not present - cannot calculate playtime or bitrate';
        }

        return true;
    }

    public function getNSVsHeaderFilepointer($fd, &$ThisFileInfo, $fileoffset)
    {
        fseek($fd, $fileoffset, SEEK_SET);

        $NSVsheader = fread($fd, 28);

        $offset = 0;

        $ThisFileInfo['nsv']['NSVs']['identifier'] = mb_substr($NSVsheader, $offset, 4);

        $offset += 4;

        if ('NSVs' != $ThisFileInfo['nsv']['NSVs']['identifier']) {
            $ThisFileInfo['error'][] = 'expected "NSVs" at offset (' . $fileoffset . '), found "' . $ThisFileInfo['nsv']['NSVs']['identifier'] . '" instead';

            unset($ThisFileInfo['nsv']['NSVs']);

            return false;
        }

        $ThisFileInfo['nsv']['NSVs']['offset'] = $fileoffset;

        $ThisFileInfo['nsv']['NSVs']['video_codec'] = mb_substr($NSVsheader, $offset, 4);

        $offset += 4;

        $ThisFileInfo['nsv']['NSVs']['audio_codec'] = mb_substr($NSVsheader, $offset, 4);

        $offset += 4;

        $ThisFileInfo['nsv']['NSVs']['resolution_x'] = getid3_lib::LittleEndian2Int(mb_substr($NSVsheader, $offset, 2));

        $offset += 2;

        $ThisFileInfo['nsv']['NSVs']['resolution_y'] = getid3_lib::LittleEndian2Int(mb_substr($NSVsheader, $offset, 2));

        $offset += 2;

        $ThisFileInfo['nsv']['NSVs']['framerate_index'] = getid3_lib::LittleEndian2Int(mb_substr($NSVsheader, $offset, 2));

        $offset += 1;

        $ThisFileInfo['nsv']['NSVs']['unknown1b'] = getid3_lib::LittleEndian2Int(mb_substr($NSVsheader, $offset, 1));

        $offset += 1;

        $ThisFileInfo['nsv']['NSVs']['unknown1c'] = getid3_lib::LittleEndian2Int(mb_substr($NSVsheader, $offset, 1));

        $offset += 1;

        $ThisFileInfo['nsv']['NSVs']['unknown1d'] = getid3_lib::LittleEndian2Int(mb_substr($NSVsheader, $offset, 1));

        $offset += 1;

        $ThisFileInfo['nsv']['NSVs']['unknown2a'] = getid3_lib::LittleEndian2Int(mb_substr($NSVsheader, $offset, 1));

        $offset += 1;

        $ThisFileInfo['nsv']['NSVs']['unknown2b'] = getid3_lib::LittleEndian2Int(mb_substr($NSVsheader, $offset, 1));

        $offset += 1;

        $ThisFileInfo['nsv']['NSVs']['unknown2c'] = getid3_lib::LittleEndian2Int(mb_substr($NSVsheader, $offset, 1));

        $offset += 1;

        $ThisFileInfo['nsv']['NSVs']['unknown2d'] = getid3_lib::LittleEndian2Int(mb_substr($NSVsheader, $offset, 1));

        $offset += 1;

        switch ($ThisFileInfo['nsv']['NSVs']['audio_codec']) {
            case 'PCM ':
                $ThisFileInfo['nsv']['NSVs']['bits_channel'] = getid3_lib::LittleEndian2Int(mb_substr($NSVsheader, $offset, 1));
                $offset += 1;
                $ThisFileInfo['nsv']['NSVs']['channels'] = getid3_lib::LittleEndian2Int(mb_substr($NSVsheader, $offset, 1));
                $offset += 1;
                $ThisFileInfo['nsv']['NSVs']['sample_rate'] = getid3_lib::LittleEndian2Int(mb_substr($NSVsheader, $offset, 2));
                $offset += 2;

                $ThisFileInfo['audio']['sample_rate'] = $ThisFileInfo['nsv']['NSVs']['sample_rate'];
                break;
            case 'MP3 ':
            case 'NONE':
            default:
                $ThisFileInfo['nsv']['NSVs']['unknown3a'] = getid3_lib::LittleEndian2Int(mb_substr($NSVsheader, $offset, 1));
                $offset += 1;
                $ThisFileInfo['nsv']['NSVs']['unknown3b'] = getid3_lib::LittleEndian2Int(mb_substr($NSVsheader, $offset, 1));
                $offset += 1;
                $ThisFileInfo['nsv']['NSVs']['unknown3c'] = getid3_lib::LittleEndian2Int(mb_substr($NSVsheader, $offset, 1));
                $offset += 1;
                $ThisFileInfo['nsv']['NSVs']['unknown3d'] = getid3_lib::LittleEndian2Int(mb_substr($NSVsheader, $offset, 1));
                $offset += 1;
                break;
        }

        $ThisFileInfo['video']['resolution_x'] = $ThisFileInfo['nsv']['NSVs']['resolution_x'];

        $ThisFileInfo['video']['resolution_y'] = $ThisFileInfo['nsv']['NSVs']['resolution_y'];

        $ThisFileInfo['nsv']['NSVs']['frame_rate'] = $this->NSVframerateLookup($ThisFileInfo['nsv']['NSVs']['framerate_index']);

        $ThisFileInfo['video']['frame_rate'] = $ThisFileInfo['nsv']['NSVs']['frame_rate'];

        $ThisFileInfo['video']['bits_per_sample'] = 24;

        $ThisFileInfo['video']['pixel_aspect_ratio'] = (float)1;

        return true;
    }

    public function getNSVfHeaderFilepointer($fd, &$ThisFileInfo, $fileoffset, $getTOCoffsets = false)
    {
        fseek($fd, $fileoffset, SEEK_SET);

        $NSVfheader = fread($fd, 28);

        $offset = 0;

        $ThisFileInfo['nsv']['NSVf']['identifier'] = mb_substr($NSVfheader, $offset, 4);

        $offset += 4;

        if ('NSVf' != $ThisFileInfo['nsv']['NSVf']['identifier']) {
            $ThisFileInfo['error'][] = 'expected "NSVf" at offset (' . $fileoffset . '), found "' . $ThisFileInfo['nsv']['NSVf']['identifier'] . '" instead';

            unset($ThisFileInfo['nsv']['NSVf']);

            return false;
        }

        $ThisFileInfo['nsv']['NSVs']['offset'] = $fileoffset;

        $ThisFileInfo['nsv']['NSVf']['header_length'] = getid3_lib::LittleEndian2Int(mb_substr($NSVfheader, $offset, 4));

        $offset += 4;

        $ThisFileInfo['nsv']['NSVf']['file_size'] = getid3_lib::LittleEndian2Int(mb_substr($NSVfheader, $offset, 4));

        $offset += 4;

        if ($ThisFileInfo['nsv']['NSVf']['file_size'] > $ThisFileInfo['avdataend']) {
            $ThisFileInfo['warning'][] = 'truncated file - NSVf header indicates ' . $ThisFileInfo['nsv']['NSVf']['file_size'] . ' bytes, file actually ' . $ThisFileInfo['avdataend'] . ' bytes';
        }

        $ThisFileInfo['nsv']['NSVf']['playtime_ms'] = getid3_lib::LittleEndian2Int(mb_substr($NSVfheader, $offset, 4));

        $offset += 4;

        $ThisFileInfo['nsv']['NSVf']['meta_size'] = getid3_lib::LittleEndian2Int(mb_substr($NSVfheader, $offset, 4));

        $offset += 4;

        $ThisFileInfo['nsv']['NSVf']['TOC_entries_1'] = getid3_lib::LittleEndian2Int(mb_substr($NSVfheader, $offset, 4));

        $offset += 4;

        $ThisFileInfo['nsv']['NSVf']['TOC_entries_2'] = getid3_lib::LittleEndian2Int(mb_substr($NSVfheader, $offset, 4));

        $offset += 4;

        if (0 == $ThisFileInfo['nsv']['NSVf']['playtime_ms']) {
            $ThisFileInfo['error'][] = 'Corrupt NSV file: NSVf.playtime_ms == zero';

            return false;
        }

        $NSVfheader .= fread($fd, $ThisFileInfo['nsv']['NSVf']['meta_size'] + (4 * $ThisFileInfo['nsv']['NSVf']['TOC_entries_1']) + (4 * $ThisFileInfo['nsv']['NSVf']['TOC_entries_2']));

        $NSVfheaderlength = mb_strlen($NSVfheader);

        $ThisFileInfo['nsv']['NSVf']['metadata'] = mb_substr($NSVfheader, $offset, $ThisFileInfo['nsv']['NSVf']['meta_size']);

        $offset += $ThisFileInfo['nsv']['NSVf']['meta_size'];

        if ($getTOCoffsets) {
            $TOCcounter = 0;

            while ($TOCcounter < $ThisFileInfo['nsv']['NSVf']['TOC_entries_1']) {
                if ($TOCcounter < $ThisFileInfo['nsv']['NSVf']['TOC_entries_1']) {
                    $ThisFileInfo['nsv']['NSVf']['TOC_1'][$TOCcounter] = getid3_lib::LittleEndian2Int(mb_substr($NSVfheader, $offset, 4));

                    $offset += 4;

                    $TOCcounter++;
                }
            }
        }

        if ('' != trim($ThisFileInfo['nsv']['NSVf']['metadata'])) {
            $ThisFileInfo['nsv']['NSVf']['metadata'] = str_replace('`', "\x01", $ThisFileInfo['nsv']['NSVf']['metadata']);

            $CommentPairArray = explode("\x01" . ' ', $ThisFileInfo['nsv']['NSVf']['metadata']);

            foreach ($CommentPairArray as $CommentPair) {
                if (mb_strstr($CommentPair, '=' . "\x01")) {
                    [$key, $value] = explode('=' . "\x01", $CommentPair, 2);

                    $ThisFileInfo['nsv']['comments'][mb_strtolower($key)][] = trim(str_replace("\x01", '', $value));
                }
            }
        }

        $ThisFileInfo['playtime_seconds'] = $ThisFileInfo['nsv']['NSVf']['playtime_ms'] / 1000;

        $ThisFileInfo['bitrate'] = ($ThisFileInfo['nsv']['NSVf']['file_size'] * 8) / $ThisFileInfo['playtime_seconds'];

        return true;
    }

    public function NSVframerateLookup($framerateindex)
    {
        if ($framerateindex <= 127) {
            return (float)$framerateindex;
        }

        static $NSVframerateLookup = [];

        if (empty($NSVframerateLookup)) {
            $NSVframerateLookup[129] = (float)29.970;

            $NSVframerateLookup[131] = (float)23.976;

            $NSVframerateLookup[133] = (float)14.985;

            $NSVframerateLookup[197] = (float)59.940;

            $NSVframerateLookup[199] = (float)47.952;
        }

        return ($NSVframerateLookup[$framerateindex] ?? false);
    }
}

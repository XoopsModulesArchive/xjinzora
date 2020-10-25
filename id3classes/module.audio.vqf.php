<?php
/////////////////////////////////////////////////////////////////
/// getID3() by James Heinrich <info@getid3.org>               //
//  available at http://getid3.sourceforge.net                 //
//            or http://www.getid3.org                         //
/////////////////////////////////////////////////////////////////
// See readme.txt for more details                             //
/////////////////////////////////////////////////////////////////
//                                                             //
// module.audio.vqf.php                                        //
// module for analyzing VQF audio files                        //
// dependencies: NONE                                          //
//                                                            ///
/////////////////////////////////////////////////////////////////

class getid3_vqf
{
    public function __construct($fd, &$ThisFileInfo)
    {
        // based loosely on code from TTwinVQ by Jurgen Faul <jfaulØgmx*de>

        // http://jfaul.de/atl  or  http://j-faul.virtualave.net/atl/atl.html

        $ThisFileInfo['fileformat'] = 'vqf';

        $ThisFileInfo['audio']['dataformat'] = 'vqf';

        $ThisFileInfo['audio']['bitrate_mode'] = 'cbr';

        $ThisFileInfo['audio']['lossless'] = false;

        // shortcut

        $ThisFileInfo['vqf']['raw'] = [];

        $thisfile_vqf = &$ThisFileInfo['vqf'];

        $thisfile_vqf_raw = &$thisfile_vqf['raw'];

        fseek($fd, $ThisFileInfo['avdataoffset'], SEEK_SET);

        $VQFheaderData = fread($fd, 16);

        $offset = 0;

        $thisfile_vqf_raw['header_tag'] = mb_substr($VQFheaderData, $offset, 4);

        if ('TWIN' != $thisfile_vqf_raw['header_tag']) {
            $ThisFileInfo['error'][] = 'Expecting "TWIN" at offset ' . $ThisFileInfo['avdataoffset'] . ', found "' . $thisfile_vqf_raw['header_tag'] . '"';

            unset($ThisFileInfo['vqf']);

            unset($ThisFileInfo['fileformat']);

            return false;
        }

        $offset += 4;

        $thisfile_vqf_raw['version'] = mb_substr($VQFheaderData, $offset, 8);

        $offset += 8;

        $thisfile_vqf_raw['size'] = getid3_lib::BigEndian2Int(mb_substr($VQFheaderData, $offset, 4));

        $offset += 4;

        while (ftell($fd) < $ThisFileInfo['avdataend']) {
            $ChunkBaseOffset = ftell($fd);

            $chunkoffset = 0;

            $ChunkData = fread($fd, 8);

            $ChunkName = mb_substr($ChunkData, $chunkoffset, 4);

            if ('DATA' == $ChunkName) {
                $ThisFileInfo['avdataoffset'] = $ChunkBaseOffset;

                break;
            }

            $chunkoffset += 4;

            $ChunkSize = getid3_lib::BigEndian2Int(mb_substr($ChunkData, $chunkoffset, 4));

            $chunkoffset += 4;

            if ($ChunkSize > ($ThisFileInfo['avdataend'] - ftell($fd))) {
                $ThisFileInfo['error'][] = 'Invalid chunk size (' . $ChunkSize . ') for chunk "' . $ChunkName . '" at offset ' . $ChunkBaseOffset;

                break;
            }

            $ChunkData .= fread($fd, $ChunkSize);

            switch ($ChunkName) {
                case 'COMM':
                    // shortcut
                    $thisfile_vqf['COMM'] = [];
                    $thisfile_vqf_COMM = $thisfile_vqf['COMM'];

                    $thisfile_vqf_COMM['channel_mode'] = getid3_lib::BigEndian2Int(mb_substr($ChunkData, $chunkoffset, 4));
                    $chunkoffset += 4;
                    $thisfile_vqf_COMM['bitrate'] = getid3_lib::BigEndian2Int(mb_substr($ChunkData, $chunkoffset, 4));
                    $chunkoffset += 4;
                    $thisfile_vqf_COMM['sample_rate'] = getid3_lib::BigEndian2Int(mb_substr($ChunkData, $chunkoffset, 4));
                    $chunkoffset += 4;
                    $thisfile_vqf_COMM['security_level'] = getid3_lib::BigEndian2Int(mb_substr($ChunkData, $chunkoffset, 4));
                    $chunkoffset += 4;

                    $ThisFileInfo['audio']['channels'] = $thisfile_vqf_COMM['channel_mode'] + 1;
                    $ThisFileInfo['audio']['sample_rate'] = $this->VQFchannelFrequencyLookup($thisfile_vqf_COMM['sample_rate']);
                    $ThisFileInfo['audio']['bitrate'] = $thisfile_vqf_COMM['bitrate'] * 1000;
                    $ThisFileInfo['audio']['encoder_options'] = 'CBR' . ceil($ThisFileInfo['audio']['bitrate'] / 1000);

                    if (0 == $ThisFileInfo['audio']['bitrate']) {
                        $ThisFileInfo['error'][] = 'Corrupt VQF file: bitrate_audio == zero';

                        return false;
                    }
                    break;
                case 'NAME':
                case 'AUTH':
                case '(c) ':
                case 'FILE':
                case 'COMT':
                case 'ALBM':
                    $thisfile_vqf['comments'][$this->VQFcommentNiceNameLookup($ChunkName)][] = trim(mb_substr($ChunkData, 8));
                    break;
                case 'DSIZ':
                    $thisfile_vqf['DSIZ'] = getid3_lib::BigEndian2Int(mb_substr($ChunkData, 8, 4));
                    break;
                default:
                    $ThisFileInfo['warning'][] = 'Unhandled chunk type "' . $ChunkName . '" at offset ' . $ChunkBaseOffset;
                    break;
            }
        }

        $ThisFileInfo['playtime_seconds'] = (($ThisFileInfo['avdataend'] - $ThisFileInfo['avdataoffset']) * 8) / $ThisFileInfo['audio']['bitrate'];

        if (isset($thisfile_vqf['DSIZ']) && ((($ThisFileInfo['avdataend'] - $ThisFileInfo['avdataoffset'] - mb_strlen('DATA')) != $thisfile_vqf['DSIZ']))) {
            switch ($thisfile_vqf['DSIZ']) {
                case 0:
                case 1:
                    $ThisFileInfo['warning'][] = 'Invalid DSIZ value "' . $thisfile_vqf['DSIZ'] . '". This is known to happen with VQF files encoded by Ahead Nero, and seems to be its way of saying this is TwinVQF v' . ($thisfile_vqf['DSIZ'] + 1) . '.0';
                    $ThisFileInfo['audio']['encoder'] = 'Ahead Nero';
                    break;
                default:
                    $ThisFileInfo['warning'][] = 'Probable corrupted file - should be ' . $thisfile_vqf['DSIZ'] . ' bytes, actually ' . ($ThisFileInfo['avdataend'] - $ThisFileInfo['avdataoffset'] - mb_strlen('DATA'));
                    break;
            }
        }

        return true;
    }

    public function VQFchannelFrequencyLookup($frequencyid)
    {
        static $VQFchannelFrequencyLookup = [
            11 => 11025,
            22 => 22050,
            44 => 44100,
        ];

        return ($VQFchannelFrequencyLookup[$frequencyid] ?? $frequencyid * 1000);
    }

    public function VQFcommentNiceNameLookup($shortname)
    {
        static $VQFcommentNiceNameLookup = [
            'NAME' => 'title',
            'AUTH' => 'artist',
            '(c) ' => 'copyright',
            'FILE' => 'filename',
            'COMT' => 'comment',
            'ALBM' => 'album',
        ];

        return ($VQFcommentNiceNameLookup[(string)$shortname] ?? $shortname);
    }
}

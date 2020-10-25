<?php
/////////////////////////////////////////////////////////////////
/// getID3() by James Heinrich <info@getid3.org>               //
//  available at http://getid3.sourceforge.net                 //
//            or http://www.getid3.org                         //
/////////////////////////////////////////////////////////////////
// See readme.txt for more details                             //
/////////////////////////////////////////////////////////////////
//                                                             //
// module.audio.au.php                                         //
// module for analyzing AU files                               //
// dependencies: NONE                                          //
//                                                            ///
/////////////////////////////////////////////////////////////////

class getid3_au
{
    public function __construct($fd, &$ThisFileInfo)
    {
        fseek($fd, $ThisFileInfo['avdataoffset'], SEEK_SET);

        $AUheader = fread($fd, 8);

        if ('.snd' != mb_substr($AUheader, 0, 4)) {
            $ThisFileInfo['error'][] = 'Expecting ".snd" at offset ' . $ThisFileInfo['avdataoffset'] . ', found "' . mb_substr($AUheader, 0, 4) . '"';

            return false;
        }

        // shortcut

        $ThisFileInfo['au'] = [];

        $thisfile_au = &$ThisFileInfo['au'];

        $ThisFileInfo['fileformat'] = 'au';

        $ThisFileInfo['audio']['dataformat'] = 'au';

        $ThisFileInfo['audio']['bitrate_mode'] = 'cbr';

        $thisfile_au['encoding'] = 'ISO-8859-1';

        $thisfile_au['header_length'] = getid3_lib::BigEndian2Int(mb_substr($AUheader, 4, 4));

        $AUheader .= fread($fd, $thisfile_au['header_length'] - 8);

        $ThisFileInfo['avdataoffset'] += $thisfile_au['header_length'];

        $thisfile_au['data_size'] = getid3_lib::BigEndian2Int(mb_substr($AUheader, 8, 4));

        $thisfile_au['data_format_id'] = getid3_lib::BigEndian2Int(mb_substr($AUheader, 12, 4));

        $thisfile_au['sample_rate'] = getid3_lib::BigEndian2Int(mb_substr($AUheader, 16, 4));

        $thisfile_au['channels'] = getid3_lib::BigEndian2Int(mb_substr($AUheader, 20, 4));

        $thisfile_au['comments']['comment'][] = trim(mb_substr($AUheader, 24));

        $thisfile_au['data_format'] = $this->AUdataFormatNameLookup($thisfile_au['data_format_id']);

        $thisfile_au['used_bits_per_sample'] = $this->AUdataFormatUsedBitsPerSampleLookup($thisfile_au['data_format_id']);

        if ($thisfile_au['bits_per_sample'] = $this->AUdataFormatBitsPerSampleLookup($thisfile_au['data_format_id'])) {
            $ThisFileInfo['audio']['bits_per_sample'] = $thisfile_au['bits_per_sample'];
        } else {
            unset($thisfile_au['bits_per_sample']);
        }

        $ThisFileInfo['audio']['sample_rate'] = $thisfile_au['sample_rate'];

        $ThisFileInfo['audio']['channels'] = $thisfile_au['channels'];

        if ($ThisFileInfo['avdataend'] < ($ThisFileInfo['avdataoffset'] + $thisfile_au['data_size'])) {
            $ThisFileInfo['warning'][] = 'Possible truncated file - expecting "' . $thisfile_au['data_size'] . '" bytes of audio data, only found ' . ($ThisFileInfo['avdataend'] - $ThisFileInfo['avdataoffset']) . ' bytes"';
        }

        $ThisFileInfo['playtime_seconds'] = $thisfile_au['data_size'] / ($thisfile_au['sample_rate'] * $thisfile_au['channels'] * ($thisfile_au['used_bits_per_sample'] / 8));

        $ThisFileInfo['audio']['bitrate'] = ($thisfile_au['data_size'] * 8) / $ThisFileInfo['playtime_seconds'];

        return true;
    }

    public function AUdataFormatNameLookup($id)
    {
        static $AUdataFormatNameLookup = [
            0 => 'unspecified format',
            1 => '8-bit mu-law',
            2 => '8-bit linear',
            3 => '16-bit linear',
            4 => '24-bit linear',
            5 => '32-bit linear',
            6 => 'floating-point',
            7 => 'double-precision float',
            8 => 'fragmented sampled data',
            9 => 'SUN_FORMAT_NESTED',
            10 => 'DSP program',
            11 => '8-bit fixed-point',
            12 => '16-bit fixed-point',
            13 => '24-bit fixed-point',
            14 => '32-bit fixed-point',

            16 => 'non-audio display data',
            17 => 'SND_FORMAT_MULAW_SQUELCH',
            18 => '16-bit linear with emphasis',
            19 => '16-bit linear with compression',
            20 => '16-bit linear with emphasis + compression',
            21 => 'Music Kit DSP commands',
            22 => 'SND_FORMAT_DSP_COMMANDS_SAMPLES',
            23 => 'CCITT g.721 4-bit ADPCM',
            24 => 'CCITT g.722 ADPCM',
            25 => 'CCITT g.723 3-bit ADPCM',
            26 => 'CCITT g.723 5-bit ADPCM',
            27 => 'A-Law 8-bit',
        ];

        return ($AUdataFormatNameLookup[$id] ?? false);
    }

    public function AUdataFormatBitsPerSampleLookup($id)
    {
        static $AUdataFormatBitsPerSampleLookup = [
            1 => 8,
            2 => 8,
            3 => 16,
            4 => 24,
            5 => 32,
            6 => 32,
            7 => 64,

            11 => 8,
            12 => 16,
            13 => 24,
            14 => 32,

            18 => 16,
            19 => 16,
            20 => 16,

            23 => 16,

            25 => 16,
            26 => 16,
            27 => 8,
        ];

        return ($AUdataFormatBitsPerSampleLookup[$id] ?? false);
    }

    public function AUdataFormatUsedBitsPerSampleLookup($id)
    {
        static $AUdataFormatUsedBitsPerSampleLookup = [
            1 => 8,
            2 => 8,
            3 => 16,
            4 => 24,
            5 => 32,
            6 => 32,
            7 => 64,

            11 => 8,
            12 => 16,
            13 => 24,
            14 => 32,

            18 => 16,
            19 => 16,
            20 => 16,

            23 => 4,

            25 => 3,
            26 => 5,
            27 => 8,
        ];

        return ($AUdataFormatUsedBitsPerSampleLookup[$id] ?? false);
    }
}

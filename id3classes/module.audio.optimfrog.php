<?php
/////////////////////////////////////////////////////////////////
/// getID3() by James Heinrich <info@getid3.org>               //
//  available at http://getid3.sourceforge.net                 //
//            or http://www.getid3.org                         //
/////////////////////////////////////////////////////////////////
// See readme.txt for more details                             //
/////////////////////////////////////////////////////////////////
//                                                             //
// module.audio.optimfrog.php                                  //
// module for analyzing OptimFROG audio files                  //
// dependencies: module.audio.riff.php                         //
//                                                            ///
/////////////////////////////////////////////////////////////////

getid3_lib::IncludeDependency(GETID3_INCLUDEPATH . 'module.audio-video.riff.php', __FILE__, true);

class getid3_optimfrog
{
    public function __construct($fd, &$ThisFileInfo)
    {
        $ThisFileInfo['fileformat'] = 'ofr';

        $ThisFileInfo['audio']['dataformat'] = 'ofr';

        $ThisFileInfo['audio']['bitrate_mode'] = 'vbr';

        $ThisFileInfo['audio']['lossless'] = true;

        fseek($fd, $ThisFileInfo['avdataoffset'], SEEK_SET);

        $OFRheader = fread($fd, 8);

        if ('*RIFF' == mb_substr($OFRheader, 0, 5)) {
            return $this->ParseOptimFROGheader42($fd, $ThisFileInfo);
        } elseif ('OFR' == mb_substr($OFRheader, 0, 3)) {
            return $this->ParseOptimFROGheader45($fd, $ThisFileInfo);
        }

        $ThisFileInfo['error'][] = 'Expecting "*RIFF" or "OFR " at offset ' . $ThisFileInfo['avdataoffset'] . ', found "' . $OFRheader . '"';

        unset($ThisFileInfo['fileformat']);

        return false;
    }

    public function ParseOptimFROGheader42($fd, &$ThisFileInfo)
    {
        // for fileformat of v4.21 and older

        fseek($fd, $ThisFileInfo['avdataoffset'], SEEK_SET);

        $OptimFROGheaderData = fread($fd, 45);

        $ThisFileInfo['avdataoffset'] = 45;

        $OptimFROGencoderVersion = getid3_lib::LittleEndian2Int(mb_substr($OptimFROGheaderData, 0, 1)) / 10;

        $RIFFdata = mb_substr($OptimFROGheaderData, 1, 44);

        $OrignalRIFFheaderSize = getid3_lib::LittleEndian2Int(mb_substr($RIFFdata, 4, 4)) + 8;

        $OrignalRIFFdataSize = getid3_lib::LittleEndian2Int(mb_substr($RIFFdata, 40, 4)) + 44;

        if ($OrignalRIFFheaderSize > $OrignalRIFFdataSize) {
            $ThisFileInfo['avdataend'] -= ($OrignalRIFFheaderSize - $OrignalRIFFdataSize);

            fseek($fd, $ThisFileInfo['avdataend'], SEEK_SET);

            $RIFFdata .= fread($fd, $OrignalRIFFheaderSize - $OrignalRIFFdataSize);
        }

        // move the data chunk after all other chunks (if any)

        // so that the RIFF parser doesn't see EOF when trying

        // to skip over the data chunk

        $RIFFdata = mb_substr($RIFFdata, 0, 36) . mb_substr($RIFFdata, 44) . mb_substr($RIFFdata, 36, 8);

        getid3_riff::ParseRIFFdata($RIFFdata, $ThisFileInfo);

        $ThisFileInfo['audio']['encoder'] = 'OptimFROG ' . round($OptimFROGencoderVersion, 1);

        $ThisFileInfo['audio']['channels'] = $ThisFileInfo['riff']['audio'][0]['channels'];

        $ThisFileInfo['audio']['sample_rate'] = $ThisFileInfo['riff']['audio'][0]['sample_rate'];

        $ThisFileInfo['audio']['bits_per_sample'] = $ThisFileInfo['riff']['audio'][0]['bits_per_sample'];

        $ThisFileInfo['playtime_seconds'] = $OrignalRIFFdataSize / ($ThisFileInfo['audio']['channels'] * $ThisFileInfo['audio']['sample_rate'] * ($ThisFileInfo['audio']['bits_per_sample'] / 8));

        $ThisFileInfo['audio']['bitrate'] = (($ThisFileInfo['avdataend'] - $ThisFileInfo['avdataoffset']) * 8) / $ThisFileInfo['playtime_seconds'];

        return true;
    }

    public function ParseOptimFROGheader45($fd, &$ThisFileInfo)
    {
        // for fileformat of v4.50a and higher

        $RIFFdata = '';

        fseek($fd, $ThisFileInfo['avdataoffset'], SEEK_SET);

        while (!feof($fd) && (ftell($fd) < $ThisFileInfo['avdataend'])) {
            $BlockOffset = ftell($fd);

            $BlockData = fread($fd, 8);

            $offset = 8;

            $BlockName = mb_substr($BlockData, 0, 4);

            $BlockSize = getid3_lib::LittleEndian2Int(mb_substr($BlockData, 4, 4));

            if ('OFRX' == $BlockName) {
                $BlockName = 'OFR ';
            }

            if (!isset($ThisFileInfo['ofr'][$BlockName])) {
                $ThisFileInfo['ofr'][$BlockName] = [];
            }

            $thisfile_ofr_thisblock = &$ThisFileInfo['ofr'][$BlockName];

            switch ($BlockName) {
                case 'OFR ':

                    // shortcut
                    $thisfile_ofr_thisblock['offset'] = $BlockOffset;
                    $thisfile_ofr_thisblock['size'] = $BlockSize;

                    $ThisFileInfo['audio']['encoder'] = 'OptimFROG 4.50 alpha';
                    switch ($BlockSize) {
                        case 12:
                        case 15:
                            // good
                            break;
                        default:
                            $ThisFileInfo['warning'][] = '"' . $BlockName . '" contains more data than expected (expected 12 or 15 bytes, found ' . $BlockSize . ' bytes)';
                            break;
                    }
                    $BlockData .= fread($fd, $BlockSize);

                    $thisfile_ofr_thisblock['total_samples'] = getid3_lib::LittleEndian2Int(mb_substr($BlockData, $offset, 6));
                    $offset += 6;
                    $thisfile_ofr_thisblock['raw']['sample_type'] = getid3_lib::LittleEndian2Int(mb_substr($BlockData, $offset, 1));
                    $thisfile_ofr_thisblock['sample_type'] = $this->OptimFROGsampleTypeLookup($thisfile_ofr_thisblock['raw']['sample_type']);
                    $offset += 1;
                    $thisfile_ofr_thisblock['channel_config'] = getid3_lib::LittleEndian2Int(mb_substr($BlockData, $offset, 1));
                    $thisfile_ofr_thisblock['channels'] = $thisfile_ofr_thisblock['channel_config'];
                    $offset += 1;
                    $thisfile_ofr_thisblock['sample_rate'] = getid3_lib::LittleEndian2Int(mb_substr($BlockData, $offset, 4));
                    $offset += 4;

                    if ($BlockSize > 12) {
                        // OFR 4.504b or higher

                        $thisfile_ofr_thisblock['channels'] = $this->OptimFROGchannelConfigNumChannelsLookup($thisfile_ofr_thisblock['channel_config']);

                        $thisfile_ofr_thisblock['raw']['encoder_id'] = getid3_lib::LittleEndian2Int(mb_substr($BlockData, $offset, 2));

                        $thisfile_ofr_thisblock['encoder'] = $this->OptimFROGencoderNameLookup($thisfile_ofr_thisblock['raw']['encoder_id']);

                        $offset += 2;

                        $thisfile_ofr_thisblock['raw']['compression'] = getid3_lib::LittleEndian2Int(mb_substr($BlockData, $offset, 1));

                        $thisfile_ofr_thisblock['compression'] = $this->OptimFROGcompressionLookup($thisfile_ofr_thisblock['raw']['compression']);

                        $thisfile_ofr_thisblock['speedup'] = $this->OptimFROGspeedupLookup($thisfile_ofr_thisblock['raw']['compression']);

                        $offset += 1;

                        $ThisFileInfo['audio']['encoder'] = 'OptimFROG ' . $thisfile_ofr_thisblock['encoder'];

                        $ThisFileInfo['audio']['encoder_options'] = '--mode ' . $thisfile_ofr_thisblock['compression'];

                        if (7 == (($thisfile_ofr_thisblock['raw']['encoder_id'] & 0xF0) >> 4)) { // v4.507
                            if ('ofs' == mb_strtolower(getid3_lib::fileextension($ThisFileInfo['filename']))) {
                                // OptimFROG DualStream format is lossy, but as of v4.507 there is no way to tell the difference

                                // between lossless and lossy other than the file extension.

                                $ThisFileInfo['audio']['dataformat'] = 'ofs';

                                $ThisFileInfo['audio']['lossless'] = true;
                            }
                        }
                    }

                    $ThisFileInfo['audio']['channels'] = $thisfile_ofr_thisblock['channels'];
                    $ThisFileInfo['audio']['sample_rate'] = $thisfile_ofr_thisblock['sample_rate'];
                    $ThisFileInfo['audio']['bits_per_sample'] = $this->OptimFROGbitsPerSampleTypeLookup($thisfile_ofr_thisblock['raw']['sample_type']);
                    break;
                case 'COMP':
                    // unlike other block types, there CAN be multiple COMP blocks

                    $COMPdata['offset'] = $BlockOffset;
                    $COMPdata['size'] = $BlockSize;

                    if (0 == $ThisFileInfo['avdataoffset']) {
                        $ThisFileInfo['avdataoffset'] = $BlockOffset;
                    }

                    // Only interested in first 14 bytes (only first 12 needed for v4.50 alpha), not actual audio data
                    $BlockData .= fread($fd, 14);
                    fseek($fd, $BlockSize - 14, SEEK_CUR);

                    $COMPdata['crc_32'] = getid3_lib::LittleEndian2Int(mb_substr($BlockData, $offset, 4));
                    $offset += 4;
                    $COMPdata['sample_count'] = getid3_lib::LittleEndian2Int(mb_substr($BlockData, $offset, 4));
                    $offset += 4;
                    $COMPdata['raw']['sample_type'] = getid3_lib::LittleEndian2Int(mb_substr($BlockData, $offset, 1));
                    $COMPdata['sample_type'] = $this->OptimFROGsampleTypeLookup($COMPdata['raw']['sample_type']);
                    $offset += 1;
                    $COMPdata['raw']['channel_configuration'] = getid3_lib::LittleEndian2Int(mb_substr($BlockData, $offset, 1));
                    $COMPdata['channel_configuration'] = $this->OptimFROGchannelConfigurationLookup($COMPdata['raw']['channel_configuration']);
                    $offset += 1;
                    $COMPdata['raw']['algorithm_id'] = getid3_lib::LittleEndian2Int(mb_substr($BlockData, $offset, 2));
                    //$COMPdata['algorithm']                    = OptimFROGalgorithmNameLookup($COMPdata['raw']['algorithm_id']);
                    $offset += 2;

                    if ($ThisFileInfo['ofr']['OFR ']['size'] > 12) {
                        // OFR 4.504b or higher

                        $COMPdata['raw']['encoder_id'] = getid3_lib::LittleEndian2Int(mb_substr($BlockData, $offset, 2));

                        $COMPdata['encoder'] = $this->OptimFROGencoderNameLookup($COMPdata['raw']['encoder_id']);

                        $offset += 2;
                    }

                    if (0x454E4F4E == $COMPdata['crc_32']) {
                        // ASCII value of 'NONE' - placeholder value in v4.50a

                        $COMPdata['crc_32'] = false;
                    }

                    $thisfile_ofr_thisblock[] = $COMPdata;
                    break;
                case 'HEAD':
                    $thisfile_ofr_thisblock['offset'] = $BlockOffset;
                    $thisfile_ofr_thisblock['size'] = $BlockSize;

                    $RIFFdata .= fread($fd, $BlockSize);
                    break;
                case 'TAIL':
                    $thisfile_ofr_thisblock['offset'] = $BlockOffset;
                    $thisfile_ofr_thisblock['size'] = $BlockSize;

                    $RIFFdata .= fread($fd, $BlockSize);
                    break;
                case 'RECV':
                    // block contains no useful meta data - simply note and skip

                    $thisfile_ofr_thisblock['offset'] = $BlockOffset;
                    $thisfile_ofr_thisblock['size'] = $BlockSize;

                    fseek($fd, $BlockSize, SEEK_CUR);
                    break;
                case 'APET':
                    // APEtag v2

                    $thisfile_ofr_thisblock['offset'] = $BlockOffset;
                    $thisfile_ofr_thisblock['size'] = $BlockSize;
                    $ThisFileInfo['warning'][] = 'APEtag processing inside OptimFROG not supported in this version (' . GETID3_VERSION . ') of getID3()';

                    fseek($fd, $BlockSize, SEEK_CUR);
                    break;
                case 'MD5 ':
                    // APEtag v2

                    $thisfile_ofr_thisblock['offset'] = $BlockOffset;
                    $thisfile_ofr_thisblock['size'] = $BlockSize;

                    if (16 == $BlockSize) {
                        $thisfile_ofr_thisblock['md5_binary'] = fread($fd, $BlockSize);

                        $thisfile_ofr_thisblock['md5_string'] = getid3_lib::PrintHexBytes($thisfile_ofr_thisblock['md5_binary'], true, false, false);

                        $ThisFileInfo['md5_data_source'] = $thisfile_ofr_thisblock['md5_string'];
                    } else {
                        $ThisFileInfo['warning'][] = 'Expecting block size of 16 in "MD5 " chunk, found ' . $BlockSize . ' instead';

                        fseek($fd, $BlockSize, SEEK_CUR);
                    }
                    break;
                default:
                    $thisfile_ofr_thisblock['offset'] = $BlockOffset;
                    $thisfile_ofr_thisblock['size'] = $BlockSize;

                    $ThisFileInfo['warning'][] = 'Unhandled OptimFROG block type "' . $BlockName . '" at offset ' . $thisfile_ofr_thisblock['offset'];
                    fseek($fd, $BlockSize, SEEK_CUR);
                    break;
            }
        }

        if (isset($ThisFileInfo['ofr']['TAIL']['offset'])) {
            $ThisFileInfo['avdataend'] = $ThisFileInfo['ofr']['TAIL']['offset'];
        }

        $ThisFileInfo['playtime_seconds'] = (float)$ThisFileInfo['ofr']['OFR ']['total_samples'] / ($ThisFileInfo['audio']['channels'] * $ThisFileInfo['audio']['sample_rate']);

        $ThisFileInfo['audio']['bitrate'] = (($ThisFileInfo['avdataend'] - $ThisFileInfo['avdataoffset']) * 8) / $ThisFileInfo['playtime_seconds'];

        // move the data chunk after all other chunks (if any)

        // so that the RIFF parser doesn't see EOF when trying

        // to skip over the data chunk

        $RIFFdata = mb_substr($RIFFdata, 0, 36) . mb_substr($RIFFdata, 44) . mb_substr($RIFFdata, 36, 8);

        getid3_riff::ParseRIFFdata($RIFFdata, $ThisFileInfo);

        return true;
    }

    public function OptimFROGsampleTypeLookup($SampleType)
    {
        static $OptimFROGsampleTypeLookup = [
            0 => 'unsigned int (8-bit)',
            1 => 'signed int (8-bit)',
            2 => 'unsigned int (16-bit)',
            3 => 'signed int (16-bit)',
            4 => 'unsigned int (24-bit)',
            5 => 'signed int (24-bit)',
            6 => 'unsigned int (32-bit)',
            7 => 'signed int (32-bit)',
            8 => 'float 0.24 (32-bit)',
            9 => 'float 16.8 (32-bit)',
            10 => 'float 24.0 (32-bit)',
        ];

        return ($OptimFROGsampleTypeLookup[$SampleType] ?? false);
    }

    public function OptimFROGbitsPerSampleTypeLookup($SampleType)
    {
        static $OptimFROGbitsPerSampleTypeLookup = [
            0 => 8,
            1 => 8,
            2 => 16,
            3 => 16,
            4 => 24,
            5 => 24,
            6 => 32,
            7 => 32,
            8 => 32,
            9 => 32,
            10 => 32,
        ];

        return ($OptimFROGbitsPerSampleTypeLookup[$SampleType] ?? false);
    }

    public function OptimFROGchannelConfigurationLookup($ChannelConfiguration)
    {
        static $OptimFROGchannelConfigurationLookup = [
            0 => 'mono',
            1 => 'stereo',
        ];

        return ($OptimFROGchannelConfigurationLookup[$ChannelConfiguration] ?? false);
    }

    public function OptimFROGchannelConfigNumChannelsLookup($ChannelConfiguration)
    {
        static $OptimFROGchannelConfigNumChannelsLookup = [
            0 => 1,
            1 => 2,
        ];

        return ($OptimFROGchannelConfigNumChannelsLookup[$ChannelConfiguration] ?? false);
    }

    // function OptimFROGalgorithmNameLookup($AlgorithID) {

    //     static $OptimFROGalgorithmNameLookup = array();

    //     return (isset($OptimFROGalgorithmNameLookup[$AlgorithID]) ? $OptimFROGalgorithmNameLookup[$AlgorithID] : false);

    // }

    public function OptimFROGencoderNameLookup($EncoderID)
    {
        // version = (encoderID >> 4) + 4500

        // system  =  encoderID & 0xF

        $EncoderVersion = number_format(((($EncoderID & 0xF0) >> 4) + 4500) / 1000, 3);

        $EncoderSystemID = ($EncoderID & 0x0F);

        static $OptimFROGencoderSystemLookup = [
            0x00 => 'Windows console',
            0x01 => 'Linux console',
            0x0F => 'unknown',
        ];

        return $EncoderVersion . ' (' . ($OptimFROGencoderSystemLookup[$EncoderSystemID] ?? 'undefined encoder type (0x' . dechex($EncoderSystemID) . ')') . ')';
    }

    public function OptimFROGcompressionLookup($CompressionID)
    {
        // mode    = compression >> 3

        // speedup = compression & 0x07

        $CompressionModeID = ($CompressionID & 0xF8) >> 3;

        //$CompressionSpeedupID = ($CompressionID & 0x07);

        static $OptimFROGencoderModeLookup = [
            0x00 => 'fast',
            0x01 => 'normal',
            0x02 => 'high',
            0x03 => 'extra', // extranew (some versions)
            0x04 => 'best',  // bestnew (some versions)
            0x05 => 'ultra',
            0x06 => 'insane',
            0x07 => 'highnew',
            0x08 => 'extranew',
            0x09 => 'bestnew',
        ];

        return ($OptimFROGencoderModeLookup[$CompressionModeID] ?? 'undefined mode (0x' . str_pad(dechex($CompressionModeID), 2, '0', STR_PAD_LEFT) . ')');
    }

    public function OptimFROGspeedupLookup($CompressionID)
    {
        // mode    = compression >> 3

        // speedup = compression & 0x07

        //$CompressionModeID    = ($CompressionID & 0xF8) >> 3;

        $CompressionSpeedupID = ($CompressionID & 0x07);

        static $OptimFROGencoderSpeedupLookup = [
            0x00 => '1x',
            0x01 => '2x',
            0x02 => '4x',
        ];

        return ($OptimFROGencoderSpeedupLookup[$CompressionSpeedupID] ?? 'undefined mode (0x' . dechex($CompressionSpeedupID));
    }
}

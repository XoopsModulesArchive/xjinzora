<?php
/////////////////////////////////////////////////////////////////
/// getID3() by James Heinrich <info@getid3.org>               //
//  available at http://getid3.sourceforge.net                 //
//            or http://www.getid3.org                         //
/////////////////////////////////////////////////////////////////
// See readme.txt for more details                             //
/////////////////////////////////////////////////////////////////
//                                                             //
// module.audio.flac.php                                       //
// module for analyzing FLAC and OggFLAC audio files           //
// dependencies: module.audio.ogg.php                          //
//                                                            ///
/////////////////////////////////////////////////////////////////

getid3_lib::IncludeDependency(GETID3_INCLUDEPATH . 'module.audio.ogg.php', __FILE__, true);

class getid3_flac
{
    public function __construct(&$fd, &$ThisFileInfo)
    {
        // http://flac.sourceforge.net/format.html

        fseek($fd, $ThisFileInfo['avdataoffset'], SEEK_SET);

        $StreamMarker = fread($fd, 4);

        if ('fLaC' != $StreamMarker) {
            $ThisFileInfo['error'][] = 'Expecting "fLaC" at offset ' . $ThisFileInfo['avdataoffset'] . ', found "' . $StreamMarker . '"';

            return false;
        }

        $ThisFileInfo['fileformat'] = 'flac';

        $ThisFileInfo['audio']['dataformat'] = 'flac';

        $ThisFileInfo['audio']['bitrate_mode'] = 'vbr';

        $ThisFileInfo['audio']['lossless'] = false;

        return self::FLACparseMETAdata($fd, $ThisFileInfo);
    }

    public function FLACparseMETAdata($fd, &$ThisFileInfo)
    {
        do {
            $METAdataBlockOffset = ftell($fd);

            $METAdataBlockHeader = fread($fd, 4);

            $METAdataLastBlockFlag = (bool)(getid3_lib::BigEndian2Int(mb_substr($METAdataBlockHeader, 0, 1)) & 0x80);

            $METAdataBlockType = getid3_lib::BigEndian2Int(mb_substr($METAdataBlockHeader, 0, 1)) & 0x7F;

            $METAdataBlockLength = getid3_lib::BigEndian2Int(mb_substr($METAdataBlockHeader, 1, 3));

            $METAdataBlockTypeText = self::FLACmetaBlockTypeLookup($METAdataBlockType);

            $ThisFileInfo['flac'][(string)$METAdataBlockTypeText]['raw']['offset'] = $METAdataBlockOffset;

            $ThisFileInfo['flac'][(string)$METAdataBlockTypeText]['raw']['last_meta_block'] = $METAdataLastBlockFlag;

            $ThisFileInfo['flac'][(string)$METAdataBlockTypeText]['raw']['block_type'] = $METAdataBlockType;

            $ThisFileInfo['flac'][(string)$METAdataBlockTypeText]['raw']['block_type_text'] = $METAdataBlockTypeText;

            $ThisFileInfo['flac'][(string)$METAdataBlockTypeText]['raw']['block_length'] = $METAdataBlockLength;

            $ThisFileInfo['flac'][(string)$METAdataBlockTypeText]['raw']['block_data'] = fread($fd, $METAdataBlockLength);

            $ThisFileInfo['avdataoffset'] = ftell($fd);

            switch ($METAdataBlockTypeText) {
                case 'STREAMINFO':
                    if (!self::FLACparseSTREAMINFO($ThisFileInfo['flac'][(string)$METAdataBlockTypeText]['raw']['block_data'], $ThisFileInfo)) {
                        return false;
                    }
                    break;
                case 'PADDING':
                    // ignore
                    break;
                case 'APPLICATION':
                    if (!self::FLACparseAPPLICATION($ThisFileInfo['flac'][(string)$METAdataBlockTypeText]['raw']['block_data'], $ThisFileInfo)) {
                        return false;
                    }
                    break;
                case 'SEEKTABLE':
                    if (!self::FLACparseSEEKTABLE($ThisFileInfo['flac'][(string)$METAdataBlockTypeText]['raw']['block_data'], $ThisFileInfo)) {
                        return false;
                    }
                    break;
                case 'VORBIS_COMMENT':
                    $OldOffset = ftell($fd);
                    fseek($fd, 0 - $METAdataBlockLength, SEEK_CUR);
                    getid3_ogg::ParseVorbisCommentsFilepointer($fd, $ThisFileInfo);
                    fseek($fd, $OldOffset, SEEK_SET);
                    break;
                case 'CUESHEET':
                    if (!self::FLACparseCUESHEET($ThisFileInfo['flac'][(string)$METAdataBlockTypeText]['raw']['block_data'], $ThisFileInfo)) {
                        return false;
                    }
                    break;
                default:
                    $ThisFileInfo['warning'][] = 'Unhandled METADATA_BLOCK_HEADER.BLOCK_TYPE (' . $METAdataBlockType . ') at offset ' . $METAdataBlockOffset;
                    break;
            }
        } while (false === $METAdataLastBlockFlag);

        if (isset($ThisFileInfo['flac']['STREAMINFO'])) {
            $ThisFileInfo['flac']['compressed_audio_bytes'] = $ThisFileInfo['avdataend'] - $ThisFileInfo['avdataoffset'];

            $ThisFileInfo['flac']['uncompressed_audio_bytes'] = $ThisFileInfo['flac']['STREAMINFO']['samples_stream'] * $ThisFileInfo['flac']['STREAMINFO']['channels'] * ($ThisFileInfo['flac']['STREAMINFO']['bits_per_sample'] / 8);

            if (0 == $ThisFileInfo['flac']['uncompressed_audio_bytes']) {
                $ThisFileInfo['error'][] = 'Corrupt FLAC file: uncompressed_audio_bytes == zero';

                return false;
            }

            $ThisFileInfo['flac']['compression_ratio'] = $ThisFileInfo['flac']['compressed_audio_bytes'] / $ThisFileInfo['flac']['uncompressed_audio_bytes'];
        }

        // set md5_data_source - built into flac 0.5+

        if (isset($ThisFileInfo['flac']['STREAMINFO']['audio_signature'])) {
            if ($ThisFileInfo['flac']['STREAMINFO']['audio_signature'] === str_repeat("\x00", 16)) {
                $ThisFileInfo['warning'][] = 'FLAC STREAMINFO.audio_signature is null (known issue with libOggFLAC)';
            } else {
                $ThisFileInfo['md5_data_source'] = '';

                $md5 = $ThisFileInfo['flac']['STREAMINFO']['audio_signature'];

                for ($i = 0, $iMax = mb_strlen($md5); $i < $iMax; $i++) {
                    $ThisFileInfo['md5_data_source'] .= str_pad(dechex(ord($md5[$i])), 2, '00', STR_PAD_LEFT);
                }

                if (!preg_match('/^[0-9a-f]{32}$/', $ThisFileInfo['md5_data_source'])) {
                    unset($ThisFileInfo['md5_data_source']);
                }
            }
        }

        $ThisFileInfo['audio']['bits_per_sample'] = $ThisFileInfo['flac']['STREAMINFO']['bits_per_sample'];

        if (8 == $ThisFileInfo['audio']['bits_per_sample']) {
            // special case

            // must invert sign bit on all data bytes before MD5'ing to match FLAC's calculated value

            // MD5sum calculates on unsigned bytes, but FLAC calculated MD5 on 8-bit audio data as signed

            $ThisFileInfo['warning'][] = 'FLAC calculates MD5 data strangely on 8-bit audio, so the stored md5_data_source value will not match the decoded WAV file';
        }

        if (!empty($ThisFileInfo['ogg']['vendor'])) {
            $ThisFileInfo['audio']['encoder'] = $ThisFileInfo['ogg']['vendor'];
        }

        return true;
    }

    public function FLACmetaBlockTypeLookup($blocktype)
    {
        static $FLACmetaBlockTypeLookup = [];

        if (empty($FLACmetaBlockTypeLookup)) {
            $FLACmetaBlockTypeLookup[0] = 'STREAMINFO';

            $FLACmetaBlockTypeLookup[1] = 'PADDING';

            $FLACmetaBlockTypeLookup[2] = 'APPLICATION';

            $FLACmetaBlockTypeLookup[3] = 'SEEKTABLE';

            $FLACmetaBlockTypeLookup[4] = 'VORBIS_COMMENT';

            $FLACmetaBlockTypeLookup[5] = 'CUESHEET';
        }

        return ($FLACmetaBlockTypeLookup[$blocktype] ?? 'reserved');
    }

    public function FLACapplicationIDLookup($applicationid)
    {
        static $FLACapplicationIDLookup = [];

        if (empty($FLACapplicationIDLookup)) {
            // http://flac.sourceforge.net/id.html
            $FLACapplicationIDLookup[0x46746F6C] = 'flac-tools';      // 'Ftol'
            $FLACapplicationIDLookup[0x46746F6C] = 'Sound Font FLAC'; // 'SFFL'
        }

        return ($FLACapplicationIDLookup[$applicationid] ?? 'reserved');
    }

    public function FLACparseSTREAMINFO($METAdataBlockData, &$ThisFileInfo)
    {
        $offset = 0;

        $ThisFileInfo['flac']['STREAMINFO']['min_block_size'] = getid3_lib::BigEndian2Int(mb_substr($METAdataBlockData, $offset, 2));

        $offset += 2;

        $ThisFileInfo['flac']['STREAMINFO']['max_block_size'] = getid3_lib::BigEndian2Int(mb_substr($METAdataBlockData, $offset, 2));

        $offset += 2;

        $ThisFileInfo['flac']['STREAMINFO']['min_frame_size'] = getid3_lib::BigEndian2Int(mb_substr($METAdataBlockData, $offset, 3));

        $offset += 3;

        $ThisFileInfo['flac']['STREAMINFO']['max_frame_size'] = getid3_lib::BigEndian2Int(mb_substr($METAdataBlockData, $offset, 3));

        $offset += 3;

        $SampleRateChannelsSampleBitsStreamSamples = getid3_lib::BigEndian2Bin(mb_substr($METAdataBlockData, $offset, 8));

        $ThisFileInfo['flac']['STREAMINFO']['sample_rate'] = getid3_lib::Bin2Dec(mb_substr($SampleRateChannelsSampleBitsStreamSamples, 0, 20));

        $ThisFileInfo['flac']['STREAMINFO']['channels'] = getid3_lib::Bin2Dec(mb_substr($SampleRateChannelsSampleBitsStreamSamples, 20, 3)) + 1;

        $ThisFileInfo['flac']['STREAMINFO']['bits_per_sample'] = getid3_lib::Bin2Dec(mb_substr($SampleRateChannelsSampleBitsStreamSamples, 23, 5)) + 1;

        $ThisFileInfo['flac']['STREAMINFO']['samples_stream'] = getid3_lib::Bin2Dec(mb_substr($SampleRateChannelsSampleBitsStreamSamples, 28, 36));

        $offset += 8;

        $ThisFileInfo['flac']['STREAMINFO']['audio_signature'] = mb_substr($METAdataBlockData, $offset, 16);

        $offset += 16;

        if (!empty($ThisFileInfo['flac']['STREAMINFO']['sample_rate'])) {
            $ThisFileInfo['audio']['bitrate_mode'] = 'vbr';

            $ThisFileInfo['audio']['sample_rate'] = $ThisFileInfo['flac']['STREAMINFO']['sample_rate'];

            $ThisFileInfo['audio']['channels'] = $ThisFileInfo['flac']['STREAMINFO']['channels'];

            $ThisFileInfo['audio']['bits_per_sample'] = $ThisFileInfo['flac']['STREAMINFO']['bits_per_sample'];

            $ThisFileInfo['playtime_seconds'] = $ThisFileInfo['flac']['STREAMINFO']['samples_stream'] / $ThisFileInfo['flac']['STREAMINFO']['sample_rate'];

            $ThisFileInfo['audio']['bitrate'] = (($ThisFileInfo['avdataend'] - $ThisFileInfo['avdataoffset']) * 8) / $ThisFileInfo['playtime_seconds'];
        } else {
            $ThisFileInfo['error'][] = 'Corrupt METAdata block: STREAMINFO';

            return false;
        }

        return true;
    }

    public function FLACparseAPPLICATION($METAdataBlockData, &$ThisFileInfo)
    {
        $offset = 0;

        $ApplicationID = getid3_lib::BigEndian2Int(mb_substr($METAdataBlockData, $offset, 4));

        $offset += 4;

        $ThisFileInfo['flac']['APPLICATION'][$ApplicationID]['name'] = self::FLACapplicationIDLookup($ApplicationID);

        $ThisFileInfo['flac']['APPLICATION'][$ApplicationID]['data'] = mb_substr($METAdataBlockData, $offset);

        $offset = $METAdataBlockLength;

        return true;
    }

    public function FLACparseSEEKTABLE($METAdataBlockData, &$ThisFileInfo)
    {
        $offset = 0;

        $METAdataBlockLength = mb_strlen($METAdataBlockData);

        $placeholderpattern = str_repeat("\xFF", 8);

        while ($offset < $METAdataBlockLength) {
            $SampleNumberString = mb_substr($METAdataBlockData, $offset, 8);

            $offset += 8;

            if ($SampleNumberString == $placeholderpattern) {
                // placeholder point

                @$ThisFileInfo['flac']['SEEKTABLE']['placeholders']++;

                $offset += 10;
            } else {
                $SampleNumber = getid3_lib::BigEndian2Int($SampleNumberString);

                $ThisFileInfo['flac']['SEEKTABLE'][$SampleNumber]['offset'] = getid3_lib::BigEndian2Int(mb_substr($METAdataBlockData, $offset, 8));

                $offset += 8;

                $ThisFileInfo['flac']['SEEKTABLE'][$SampleNumber]['samples'] = getid3_lib::BigEndian2Int(mb_substr($METAdataBlockData, $offset, 2));

                $offset += 2;
            }
        }

        return true;
    }

    public function FLACparseCUESHEET($METAdataBlockData, &$ThisFileInfo)
    {
        $offset = 0;

        $ThisFileInfo['flac']['CUESHEET']['media_catalog_number'] = trim(mb_substr($METAdataBlockData, $offset, 128), "\0");

        $offset += 128;

        $ThisFileInfo['flac']['CUESHEET']['lead_in_samples'] = getid3_lib::BigEndian2Int(mb_substr($METAdataBlockData, $offset, 8));

        $offset += 8;

        $ThisFileInfo['flac']['CUESHEET']['flags']['is_cd'] = (bool)(getid3_lib::BigEndian2Int(mb_substr($METAdataBlockData, $offset, 1)) & 0x80);

        $offset += 1;

        $offset += 258; // reserved

        $ThisFileInfo['flac']['CUESHEET']['number_tracks'] = getid3_lib::BigEndian2Int(mb_substr($METAdataBlockData, $offset, 1));

        $offset += 1;

        for ($track = 0; $track < $ThisFileInfo['flac']['CUESHEET']['number_tracks']; $track++) {
            $TrackSampleOffset = getid3_lib::BigEndian2Int(mb_substr($METAdataBlockData, $offset, 8));

            $offset += 8;

            $TrackNumber = getid3_lib::BigEndian2Int(mb_substr($METAdataBlockData, $offset, 1));

            $offset += 1;

            $ThisFileInfo['flac']['CUESHEET']['tracks'][$TrackNumber]['sample_offset'] = $TrackSampleOffset;

            $ThisFileInfo['flac']['CUESHEET']['tracks'][$TrackNumber]['isrc'] = mb_substr($METAdataBlockData, $offset, 12);

            $offset += 12;

            $TrackFlagsRaw = getid3_lib::BigEndian2Int(mb_substr($METAdataBlockData, $offset, 1));

            $offset += 1;

            $ThisFileInfo['flac']['CUESHEET']['tracks'][$TrackNumber]['flags']['is_audio'] = (bool)($TrackFlagsRaw & 0x80);

            $ThisFileInfo['flac']['CUESHEET']['tracks'][$TrackNumber]['flags']['pre_emphasis'] = (bool)($TrackFlagsRaw & 0x40);

            $offset += 13; // reserved

            $ThisFileInfo['flac']['CUESHEET']['tracks'][$TrackNumber]['index_points'] = getid3_lib::BigEndian2Int(mb_substr($METAdataBlockData, $offset, 1));

            $offset += 1;

            for ($index = 0; $index < $ThisFileInfo['flac']['CUESHEET']['tracks'][$TrackNumber]['index_points']; $index++) {
                $IndexSampleOffset = getid3_lib::BigEndian2Int(mb_substr($METAdataBlockData, $offset, 8));

                $offset += 8;

                $IndexNumber = getid3_lib::BigEndian2Int(mb_substr($METAdataBlockData, $offset, 8));

                $offset += 1;

                $offset += 3; // reserved

                $ThisFileInfo['flac']['CUESHEET']['tracks'][$TrackNumber]['indexes'][$IndexNumber] = $IndexSampleOffset;
            }
        }

        return true;
    }
}

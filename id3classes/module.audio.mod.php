<?php
/////////////////////////////////////////////////////////////////
/// getID3() by James Heinrich <info@getid3.org>               //
//  available at http://getid3.sourceforge.net                 //
//            or http://www.getid3.org                         //
/////////////////////////////////////////////////////////////////
// See readme.txt for more details                             //
/////////////////////////////////////////////////////////////////
//                                                             //
// module.audio.mod.php                                        //
// module for analyzing MOD Audio files                        //
// dependencies: NONE                                          //
//                                                            ///
/////////////////////////////////////////////////////////////////

class getid3_mod
{
    // new combined constructor

    public function __construct($fd, &$ThisFileInfo, $option)
    {
        if ('mod' === $option) {
            $this->getMODheaderFilepointer($fd, $ThisFileInfo);
        } elseif ('xm' === $option) {
            $this->getXMheaderFilepointer($fd, $ThisFileInfo);
        } elseif ('it' === $option) {
            $this->getITheaderFilepointer($fd, $ThisFileInfo);
        } elseif ('s3m' === $option) {
            $this->getS3MheaderFilepointer($fd, $ThisFileInfo);
        }
    }

    public function getMODheaderFilepointer($fd, &$ThisFileInfo)
    {
        fseek($fd, $ThisFileInfo['avdataoffset'] + 1080);

        $FormatID = fread($fd, 4);

        if (!preg_match('^(M.K.|[5-9]CHN|[1-3][0-9]CH)$', $FormatID)) {
            $ThisFileInfo['error'][] = 'This is not a known type of MOD file';

            return false;
        }

        $ThisFileInfo['fileformat'] = 'mod';

        $ThisFileInfo['error'][] = 'MOD parsing not enabled in this version of getID3()';

        return false;
    }

    public function getXMheaderFilepointer($fd, &$ThisFileInfo)
    {
        fseek($fd, $ThisFileInfo['avdataoffset']);

        $FormatID = fread($fd, 15);

        if (!preg_match('^Extended Module$', $FormatID)) {
            $ThisFileInfo['error'][] = 'This is not a known type of XM-MOD file';

            return false;
        }

        $ThisFileInfo['fileformat'] = 'xm';

        $ThisFileInfo['error'][] = 'XM-MOD parsing not enabled in this version of getID3()';

        return false;
    }

    public function getS3MheaderFilepointer($fd, &$ThisFileInfo)
    {
        fseek($fd, $ThisFileInfo['avdataoffset'] + 44);

        $FormatID = fread($fd, 4);

        if (!preg_match('^SCRM$', $FormatID)) {
            $ThisFileInfo['error'][] = 'This is not a ScreamTracker MOD file';

            return false;
        }

        $ThisFileInfo['fileformat'] = 's3m';

        $ThisFileInfo['error'][] = 'ScreamTracker parsing not enabled in this version of getID3()';

        return false;
    }

    public function getITheaderFilepointer($fd, &$ThisFileInfo)
    {
        fseek($fd, $ThisFileInfo['avdataoffset']);

        $FormatID = fread($fd, 4);

        if (!preg_match('^IMPM$', $FormatID)) {
            $ThisFileInfo['error'][] = 'This is not an ImpulseTracker MOD file';

            return false;
        }

        $ThisFileInfo['fileformat'] = 'it';

        $ThisFileInfo['error'][] = 'ImpulseTracker parsing not enabled in this version of getID3()';

        return false;
    }
}

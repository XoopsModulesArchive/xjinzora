<?php
/////////////////////////////////////////////////////////////////
/// getID3() by James Heinrich <info@getid3.org>               //
//  available at http://getid3.sourceforge.net                 //
//            or http://www.getid3.org                         //
/////////////////////////////////////////////////////////////////
// See readme.txt for more details                             //
/////////////////////////////////////////////////////////////////
//                                                             //
// write.lyrics3.php                                           //
// module for writing Lyrics3 tags                             //
// dependencies: module.tag.lyrics3.php                        //
//                                                            ///
/////////////////////////////////////////////////////////////////

class getid3_write_lyrics3
{
    public $filename;

    public $tag_data;

    //var $lyrics3_version = 2;       // 1 or 2
    public $warnings = []; // any non-critical errors will be stored here
    public $errors = []; // any critical errors will be stored here

    public function __construct()
    {
        return true;
    }

    public function WriteLyrics3()
    {
        $this->errors[] = 'WriteLyrics3() not yet functional - cannot write Lyrics3';

        return false;
    }

    public function DeleteLyrics3()
    {
        // Initialize getID3 engine

        $getID3 = new getID3();

        $ThisFileInfo = $getID3->analyze($this->filename);

        if (isset($ThisFileInfo['lyrics3']['tag_offset_start']) && isset($ThisFileInfo['lyrics3']['tag_offset_end'])) {
            if ($fp = @fopen($this->filename, 'a+b')) {
                flock($fp, LOCK_EX);

                $oldignoreuserabort = ignore_user_abort(true);

                fseek($fp, $ThisFileInfo['lyrics3']['tag_offset_end'], SEEK_SET);

                $DataAfterLyrics3 = fread($fp, $ThisFileInfo['filesize'] - $ThisFileInfo['lyrics3']['tag_offset_end']);

                ftruncate($fp, $ThisFileInfo['lyrics3']['tag_offset_start']);

                fseek($fp, $ThisFileInfo['lyrics3']['tag_offset_start'], SEEK_SET);

                fwrite($fp, $DataAfterLyrics3, mb_strlen($DataAfterLyrics3));

                flock($fp, LOCK_UN);

                fclose($fp);

                ignore_user_abort($oldignoreuserabort);

                return true;
            }  

            $this->errors[] = 'Cannot open "' . $this->filename . '" in "a+b" mode';

            return false;
        }

        // no Lyrics3 present

        return true;
    }
}

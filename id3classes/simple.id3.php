<?php

class id3
{
    public function __construct($file, $info = true, $tag = true, $faster = false)
    {
        $this->file = $file;

        $this->tag = 0;

        $this->info = 0;

        $this->faster = $faster;

        #TODO: get fh once???

        if (mb_stristr(mb_substr($file, -3), 'mp3')) {
            if ($info) {
                $this->getMP3Info();
            }

            if ($tag) {
                $this->getID3Tag();
            }
        } elseif (mb_stristr(mb_substr($file, -3), 'ogg')) {
            if ($info || $tag) {
                $this->getOgg($info, $tag);
            }
        } else {
            $this->getBadInfo();
        }
    }

    public function getID3Tag()
    {
        $this->tag = 0;

        $v2h = null;

        if (!($fh = fopen($this->file, 'rb'))) {
            return 0;
        }

        $v2h = $this->getV2Header($fh);

        if (!empty($v2h) && !($v2h->major_ver < 2)) {
            $hlen = 10;

            $num = 4;

            if (2 == $v2h->major_ver) {
                $hlen = 6;

                $num = 3;
            }

            $off = 10; #TODO ext_header?

            $size = null;

            $map = [
                '2' => ['TT2' => 'title', 'TP1' => 'artist'],
                '3' => ['TIT2' => 'title', 'TPE1' => 'artist'],
            ];

            $this->title = $this->artist = null;

            while ($off < $v2h->tag_size) {
                $arr = $id = null;

                $found = 0;

                fseek($fh, $off);

                $bytes = fread($fh, $hlen);

                if (preg_match('/^([A-Z0-9]{' . $num . '})/', $bytes, $arr)) {
                    $id = $arr[0];

                    $size = $hlen;

                    $bytes = array_reverse(unpack("C$num", mb_substr($bytes, $num, $num)));

                    for ($i = 0; $i < ($num - 1); $i++) {
                        $size += $bytes[$i] * pow(256, $i);
                    }
                } else {
                    break;
                }

                fseek($fh, $off + $hlen);

                $bytes = fread($fh, $size - $hlen);

                if (isset($map[$v2h->major_ver][$id])) {
                    $this->$map[$v2h->major_ver][$id] = trim($bytes);

                    $this->tag = 1;

                    $this->tag_version = 'ID3v2.' . $v2h->major_ver;

                    if (2 == ++$found) {
                        break;
                    }
                }

                $off += $size;
            }
        }

        #if v2 not found look for v1

        if (!$this->tag) {
            if (-1 == fseek($fh, -128, SEEK_END)) {
                return 0;
            }

            $tag = fread($fh, 128);

            if ('TAG' == mb_substr($tag, 0, 3)) {
                if ($tag[125] == chr(0) and $tag[126] != chr(0)) {
                    $format = 'a3TAG/a30title/a30artist/a30album/a4year/a28comment/x1/C1track/C1genre';

                    $this->tag_version = 'ID3v1.1';
                } else {
                    $format = 'a3TAG/a30title/a30artist/a30album/a4year/a30comment/C1genre';

                    $this->tag_version = 'ID3v1';
                }

                $id3tag = unpack($format, $tag);

                foreach ($id3tag as $key => $value) {
                    $this->$key = trim($value);
                }

                unset($this->TAG);

                $this->tag = 1;
            }
        }

        fclose($fh);

        return $this->tag;
    }

    public function getMP3Info()
    {
        $file = $this->file;

        if (!($f = fopen($file, 'rb'))) {
            return false;
        }

        $this->filesize = filesize($file);

        $frameoffset = 0;

        $total = 4096;

        if (0 == $frameoffset) {
            if ($v2h = $this->getV2Header($f)) {
                $total += $frameoffset += $v2h->tag_size;

                fseek($f, $frameoffset);
            } else {
                fseek($f, 0);
            }
        }

        if ($this->faster) {
            do {
                while (fread($f, 1) != chr(255)) { // Find the first frame
                    if (feof($f)) {
                        return false;
                    }
                }

                fseek($f, ftell($f) - 1); // back up one byte

                $frameoffset = ftell($f);

                $r = fread($f, 4);

                $bits = decbin($this->unpackHeader($r));

                if ($frameoffset > $total) {
                    return $this->getBadInfo();
                }
            } while (!$this->isValidMP3Header($bits));
        } else { #more accurate with some VBRs
            $r = fread($f, 4);

            $bits = decbin($this->unpackHeader($r));

            while (!$this->isValidMP3Header($bits)) {
                if ($frameoffset > $total) {
                    return $this->getBadInfo();
                }

                fseek($f, ++$frameoffset);

                $r = fread($f, 4);

                $bits = decbin($this->unpackHeader($r));
            }
        }

        #$this->bits = $bits;

        $this->header_found = $frameoffset;

        $this->vbr = 0;

        $vbr = $this->getVBR($f, $bits[12], $bits[24] + $bits[25], $frameoffset);

        fclose($f);

        #TODO: vbr file size

        if (0 == $bits[11]) {
            $mpeg_ver = '2.5';

            $bitrates = [
                '1' => [0, 32, 48, 56, 64, 80, 96, 112, 128, 144, 160, 176, 192, 224, 256, 0],
                '2' => [0, 8, 16, 24, 32, 40, 48, 56, 64, 80, 96, 112, 128, 144, 160, 0],
                '3' => [0, 8, 16, 24, 32, 40, 48, 56, 64, 80, 96, 112, 128, 144, 160, 0],
            ];
        } elseif (0 == $bits[12]) {
            $mpeg_ver = '2';

            $bitrates = [
                '1' => [0, 32, 48, 56, 64, 80, 96, 112, 128, 144, 160, 176, 192, 224, 256, 0],
                '2' => [0, 8, 16, 24, 32, 40, 48, 56, 64, 80, 96, 112, 128, 144, 160, 0],
                '3' => [0, 8, 16, 24, 32, 40, 48, 56, 64, 80, 96, 112, 128, 144, 160, 0],
            ];
        } else {
            $mpeg_ver = '1';

            $bitrates = [
                '1' => [0, 32, 64, 96, 128, 160, 192, 224, 256, 288, 320, 352, 384, 416, 448, 0],
                '2' => [0, 32, 48, 56, 64, 80, 96, 112, 128, 160, 192, 224, 256, 320, 384, 0],
                '3' => [0, 32, 40, 48, 56, 64, 80, 96, 112, 128, 160, 192, 224, 256, 320, 0],
            ];
        }

        $layers = [[0, 3], [2, 1]];

        $layer = $layers[$bits[13]][$bits[14]];

        if (0 == $layer) {
            return $this->getBadInfo();
        }

        $bitrate = 0;

        if (1 == $bits[16]) {
            $bitrate += 8;
        }

        if (1 == $bits[17]) {
            $bitrate += 4;
        }

        if (1 == $bits[18]) {
            $bitrate += 2;
        }

        if (1 == $bits[19]) {
            $bitrate += 1;
        }

        if (0 == $bitrate) {
            return $this->getBadInfo();
        }

        $this->bitrate = $bitrates[$layer][$bitrate];

        $frequency = [
            '1' => [
                '0' => [44100, 48000],
                '1' => [32000, 0],
            ],
            '2' => [
                '0' => [22050, 24000],
                '1' => [16000, 0],
            ],
            '2.5' => [
                '0' => [11025, 12000],
                '1' => [8000, 0],
            ],
        ];

        $this->frequency = $frequency[$mpeg_ver][$bits[20]][$bits[21]];

        $mfs = $this->frequency / ($bits[12] ? 144000 : 72000);

        if (0 == $mfs) {
            return $this->getBadInfo();
        }

        $frames = (int)($vbr && $vbr['frames'] ? $vbr['frames'] : $this->filesize / $this->bitrate / $mfs);

        if ($vbr) {
            $this->vbr = 1;

            if ($vbr['scale']) {
                $this->vbr_scale = $vbr['scale'];
            }

            $this->bitrate = (int)($this->filesize / $frames * $mfs);

            if (!$this->bitrate) {
                return $this->getBadInfo();
            }
        }

        $s = -1;

        if (0 != $this->bitrate) {
            $s = ((8 * ($this->filesize)) / 1000) / $this->bitrate;
        }

        $this->time = sprintf('%.2d:%02d', floor($s / 60), floor($s - (floor($s / 60) * 60)));

        $this->lengths = (int)$s;

        $this->info = 1;
    }

    public function getV2Header($fh)
    {
        fseek($fh, 0);

        $bytes = fread($fh, 3);

        if ('ID3' != $bytes) {
            return false;
        }

        #$bytes = fread($fh, 3);

        #get version

        $bytes = fread($fh, 2);

        $ver = unpack('C2', $bytes);

        $h->major_ver = $ver[1];

        $h->minor_ver = $ver[2];

        #get flags

        $bytes = fread($fh, 1);

        #get ID3v2 tag length from bytes 7-10

        $tag_size = 10;

        $bytes = fread($fh, 4);

        $temp = array_reverse(unpack('C4', $bytes));

        for ($i = 0; $i <= 3; $i++) {
            $tag_size += $temp[$i] * pow(128, $i);
        }

        $h->tag_size = $tag_size;

        return $h;
    }

    public function getVBR($fh, $id, $mode, &$offset)
    {
        $offset += 4;

        if ($id) {
            $offset += 2 == $mode ? 17 : 32;
        } else {
            $offset += 2 == $mode ? 9 : 17;
        }

        $bytes = $this->Seek($fh, $offset);

        if ('Xing' != $bytes) {
            return 0;
        }

        $bytes = $this->Seek($fh, $offset);

        $vbr['flags'] = $this->unpackHeader($bytes);

        if ($vbr['flags'] & 1) {
            $bytes = $this->Seek($fh, $offset);

            $vbr['frames'] = $this->unpackHeader($bytes);
        }

        if ($vbr['flags'] & 2) {
            $bytes = $this->Seek($fh, $offset);

            $vbr['bytes'] = $this->unpackHeader($bytes);
        }

        if ($vbr['flags'] & 4) {
            $bytes = $this->Seek($fh, $offset, 100);
        }

        if ($vbr['flags'] & 8) {
            $bytes = $this->Seek($fh, $offset);

            $vbr['scale'] = $this->unpackHeader($bytes);
        } else {
            $vbr['scale'] = -1;
        }

        return $vbr;
    }

    public function isValidMP3Header($bits)
    {
        if (32 != mb_strlen($bits)) {
            return false;
        }

        if (0 != mb_substr_count(mb_substr($bits, 0, 11), '0')) {
            return false;
        }

        if ($bits[16] + $bits[17] + $bits[18] + $bits[19] == 4) {
            return false;
        }

        return true;
    }

    public function getOgg($info, $tag)
    {
        $fh = fopen($this->file, 'rb');

        // Page 1 - Stream Header

        $h = null;

        if (!$this->getOggHeader($fh, $h)) {
            return $this->getBadInfo();
        }

        if ($info) {
            $this->filesize = filesize($this->file);

            $data = fread($fh, 23);

            $offset = 0;

            $this->frequency = implode('', unpack('V1', mb_substr($data, 5, 4)));

            $bitrate_average = 0;

            if (mb_substr($data, 9, 4) !== chr(0xFF) . chr(0xFF) . chr(0xFF) . chr(0xFF)) {
                $bitrate_max = implode('', unpack('V1', mb_substr($data, 9, 4)));
            }

            if (mb_substr($data, 13, 4) !== chr(0xFF) . chr(0xFF) . chr(0xFF) . chr(0xFF)) {
                $bitrate_nominal = implode('', unpack('V1', mb_substr($data, 13, 4)));
            }

            if (mb_substr($data, 17, 4) !== chr(0xFF) . chr(0xFF) . chr(0xFF) . chr(0xFF)) {
                $bitrate_min = implode('', unpack('V1', mb_substr($data, 17, 4)));
            }
        }

        if ($tag) {
            // Page 2 - Comment Header

            if (!$this->getOggHeader($fh, $h)) {
                return $this->getBadInfo();
            }

            $data = fread($fh, 16384);

            $offset = 0;

            $vendorsize = implode('', unpack('V1', mb_substr($data, $offset, 4)));

            $offset += (4 + $vendorsize);

            $totalcomments = implode('', unpack('V1', mb_substr($data, $offset, 4)));

            $offset += 4;

            for ($i = 0; $i < $totalcomments; $i++) {
                $commentsize = implode('', unpack('V1', mb_substr($data, $offset, 4)));

                $offset += 4;

                $commentstring = mb_substr($data, $offset, $commentsize);

                $offset += $commentsize;

                $comment = explode('=', $commentstring, 2);

                $comment[0] = mb_strtolower($comment[0]);

                $this->$comment[0] = $comment[1];
            }

            $this->tag_version = 'ogg';

            $this->tag = 1;
        }

        if ($info) {
            // Last Page - Number of Samples

            fseek($fh, max($this->filesize - 16384, 0), SEEK_SET);

            $LastChunkOfOgg = strrev(fread($fh, 16384));

            if ($LastOggSpostion = mb_strpos($LastChunkOfOgg, 'SggO')) {
                fseek($fh, 0 - ($LastOggSpostion + mb_strlen('SggO')), SEEK_END);

                if (!$this->getOggHeader($fh, $h)) {
                    return $this->getBadInfo();
                }

                $samples = $h->pcm;

                $bitrate_average = ($this->filesize * 8) / ($samples / $this->frequency);
            }

            if ($bitrate_average > 0) {
                $this->bitrate = $bitrate_average;
            } elseif (isset($bitrate_nominal) && ($bitrate_nominal > 0)) {
                $this->bitrate = $bitrate_nominal;
            } elseif (isset($bitrate_min) && isset($bitrate_max)) {
                $this->bitrate = ($bitrate_min + $bitrate_max) / 2;
            }

            $this->bitrate = (int)($this->bitrate / 1000);

            $s = -1;

            if (isset($this->bitrate)) {
                $s = (float)(($this->filesize * 8) / $this->bitrate / 1000);
            }

            $this->time = sprintf('%.2d:%02d', floor($s / 60), floor($s - (floor($s / 60) * 60)));

            $this->info = 1;
        }

        return true;
    }

    public function getOggHeader($fh, $h)
    {
        $baseoffset = ftell($fh);

        $data = fread($fh, 16384);

        $offset = 0;

        while (('OggS' != mb_substr($data, $offset++, 4))) {
            if ($offset >= 10000) {
                return false;
            }
        }

        $offset += 5;

        $h->pcm = implode('', unpack('V1', mb_substr($data, $offset)));

        $offset += 20;

        $segments = implode('', unpack('C1', mb_substr($data, $offset)));

        $offset += ($segments + 8);

        fseek($fh, $offset + $baseoffset, SEEK_SET);

        return true;
    }

    public function getBadInfo()
    {
        $this->time = $this->bitrate = $this->frequency = 0;

        $this->filesize = filesize($this->file);

        return false;
    }

    public function Seek($fh, &$offset, $n = 4)
    {
        fseek($fh, $offset);

        $bytes = fread($fh, $n);

        $offset += $n;

        return $bytes;
    }

    public function unpackHeader($byte)
    {
        return implode('', unpack('N', $byte));
    }
} // end of id3

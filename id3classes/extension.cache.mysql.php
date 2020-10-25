<?php
/////////////////////////////////////////////////////////////////
/// getID3() by James Heinrich <info@getid3.org>               //
//  available at http://getid3.sourceforge.net                 //
//            or http://www.getid3.org                         //
/////////////////////////////////////////////////////////////////
//                                                             //
// extension.cache.mysql.php - part of getID3()                //
// Please see readme.txt for more information                  //
//                                                            ///
/////////////////////////////////////////////////////////////////
//                                                             //
// This extension written by Allan Hansen <ahØartemis*dk>      //
//                                                            ///
/////////////////////////////////////////////////////////////////

/**
 * This is a caching extension for getID3(). It works the exact same
 * way as the getID3 class, but return cached information very fast
 *
 * Example:  (see also demo.cache.mysql.php in /demo/)
 *
 *    Normal getID3 usage (example):
 *
 *       require_once __DIR__ . '/getid3/getid3.php';
 *       $getID3 = new getID3;
 *       $getID3->encoding = 'UTF-8';
 *       $info1 = $getID3->analyse('file1.flac');
 *       $info2 = $getID3->analyse('file2.wv');
 *
 *    getID3_cached usage:
 *
 *       require_once __DIR__ . '/getid3/getid3.php';
 *       require_once __DIR__ . '/getid3/getid3/extension.cache.mysql.php';
 *       $getID3 = new getID3_cached_mysql('localhost', 'database',
 *                                         'username', 'password');
 *       $getID3->encoding = 'UTF-8';
 *       $info1 = $getID3->analyse('file1.flac');
 *       $info2 = $getID3->analyse('file2.wv');
 *
 *
 * Supported Cache Types    (this extension)
 *
 *   SQL Databases:
 *
 *   cache_type          cache_options
 *   -------------------------------------------------------------------
 *   mysql               host, database, username, password
 *
 *
 *   DBM-Style Databases:    (use extension.cache.dbm)
 *
 *   cache_type          cache_options
 *   -------------------------------------------------------------------
 *   gdbm                dbm_filename, lock_filename
 *   ndbm                dbm_filename, lock_filename
 *   db2                 dbm_filename, lock_filename
 *   db3                 dbm_filename, lock_filename
 *   db4                 dbm_filename, lock_filename  (PHP5 required)
 *
 *   PHP must have write access to both dbm_filename and lock_filename.
 *
 *
 * Recommended Cache Types
 *
 *   Infrequent updates, many reads      any DBM
 *   Frequent updates                    mysql
 */
class getID3_cached_mysql extends getID3
{
    // private vars

    public $cursor;

    public $connection;

    // public: constructor - see top of this file for cache type and cache_options

    public function __construct($host, $database, $username, $password)
    {
        // Check for mysql support

        if (!function_exists('mysql_pconnect')) {
            die('PHP not compiled with mysql support.');
        }

        // Connect to database

        $this->connection = mysql_pconnect($host, $username, $password);

        if (!$this->connection) {
            return $this->halt('mysql_pconnect() failed - check permissions and spelling.');
        }

        // Select database

        if (!mysqli_select_db($GLOBALS['xoopsDB']->conn, $database, $this->connection)) {
            return $this->halt('Cannot use database ' . $database);
        }

        // Create cache table if not exists

        $this->create_table();

        // Check version number and clear cache if changed

        $this->cursor = $GLOBALS['xoopsDB']->queryF("SELECT `value` FROM `getid3_cache` WHERE (`filename` = '" . GETID3_VERSION . "') AND (`filesize` = '-1') AND (`filetime` = '-1') AND (`analyzetime` = '-1')", $this->connection);

        [$version] = @$GLOBALS['xoopsDB']->fetchBoth($this->cursor);

        if (GETID3_VERSION != $version) {
            echo 'NEW V.';

            $this->clear_cache();
        }

        parent::__construct();
    }

    // public: clear cache

    public function clear_cache()
    {
        $this->cursor = $GLOBALS['xoopsDB']->queryF('DELETE FROM `getid3_cache`', $this->connection);

        $this->cursor = $GLOBALS['xoopsDB']->queryF("INSERT INTO `getid3_cache` VALUES ('" . GETID3_VERSION . "', -1, -1, -1, '" . GETID3_VERSION . "')", $this->connection);
    }

    // public: analyze file

    public function analyze($filename)
    {
        if (file_exists($filename)) {
            // Short-hands

            $filetime = filemtime($filename);

            $filesize = filesize($filename);

            $filenam2 = $GLOBALS['xoopsDB']->escape($filename);

            // Loopup file

            $this->cursor = $GLOBALS['xoopsDB']->queryF("SELECT `value` FROM `getid3_cache` WHERE (`filename`='" . $filenam2 . "') AND (`filesize`='" . $filesize . "') AND (`filetime`='" . $filetime . "')", $this->connection);

            [$result] = @$GLOBALS['xoopsDB']->fetchBoth($this->cursor);

            // Hit

            if ($result) {
                echo 'HIT ';

                return unserialize($result);
            }
        }

        // Miss

        $result = parent::analyze($filename);

        // Save result

        if (file_exists($filename)) {
            $res2 = $GLOBALS['xoopsDB']->escape(serialize($result));

            $this->cursor = $GLOBALS['xoopsDB']->queryF("INSERT INTO `getid3_cache` (`filename`, `filesize`, `filetime`, `analyzetime`, `value`) VALUES ('" . $filenam2 . "', '" . $filesize . "', '" . $filetime . "', '" . time() . "', '" . $res2 . "')", $this->connection);
        }

        echo 'MISS ';

        return $result;
    }

    // private: (re)create sql table

    public function create_table($drop = false)
    {
        $this->cursor = $GLOBALS['xoopsDB']->queryF(
            "CREATE TABLE IF NOT EXISTS `getid3_cache` (
			`filename` VARCHAR(255) NOT NULL DEFAULT '',
			`filesize` INT(11) NOT NULL DEFAULT '0',
			`filetime` INT(11) NOT NULL DEFAULT '0',
			`analyzetime` INT(11) NOT NULL DEFAULT '0',
			`value` TEXT NOT NULL,
			PRIMARY KEY (`filename`,`filesize`,`filetime`)) ENGINE = ISAM",
            $this->connection
        );

        echo $GLOBALS['xoopsDB']->error($this->connection);
    }
}

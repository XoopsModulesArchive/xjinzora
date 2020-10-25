<?php

$step = $_GET['action'] ?? 'init';

switch ($step) {
case 'init':
?>
<html>
<head><title>Jinzora Database Installer</title></head>
Please set your constants in backend/database/constants.php
before continuing.<br>Also, you must have your database created before continuing.
<form method=GET action="install.php">
    <input name="action" value="db" type=hidden>
    <input type="submit" value="Continue">
</form>
<?php
break;
case 'db':

require_once __DIR__ . '/constants.php';

if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw)) {
    die('could not connect to database.');
}

dbx_query(
    $link,
    "CREATE TABLE `nodes` (
  `name` VARCHAR(255) DEFAULT NULL,
  `leaf` VARCHAR(5) DEFAULT 'false',
  `playcount` INT DEFAULT 0,
  `rating` INT DEFAULT 0,
  `rating_count` INT DEFAULT 0,
  `main_art` VARCHAR(255) DEFAULT NULL,
  `valid` VARCHAR(5) DEFAULT 'true',
  `path` VARCHAR(255) DEFAULT '/' NOT NULL PRIMARY KEY,
  `filepath` VARCHAR(255) DEFAULT '/' NOT NULL UNIQUE,
  `level` INT DEFAULT 0,
  `descr` VARCHAR(255) DEFAULT NULL,
  `longdesc` TEXT DEFAULT NULL,
  `date_added` DATE DEFAULT NULL,
  `leafcount` INT DEFAULT 0,
  `nodecount` INT DEFAULT 0
)"
);

dbx_query(
    $link,
    "CREATE TABLE `tracks` (
  `path` VARCHAR(255) DEFAULT '/' NOT NULL PRIMARY KEY,
  `trackname` VARCHAR(255) DEFAULT NULL,
  `number` VARCHAR(3) DEFAULT '-',
  `valid` VARCHAR(5) DEFAULT 'true',
  `bitrate` VARCHAR(10) DEFAULT '-',
  `frequency` VARCHAR(10) DEFAULT '-',
  `filesize` VARCHAR(10) DEFAULT '-',
  `length` VARCHAR(10) DEFAULT '-',
  `genre` VARCHAR(20) DEFAULT '-',
  `artist` VARCHAR(100) DEFAULT '-',
  `album` VARCHAR(150) DEFAULT '-',
  `year` VARCHAR(5) DEFAULT '-',
  `extension` VARCHAR(5) DEFAULT NULL,
  `lyrics` TEXT DEFAULT NULL
  )"
);

dbx_query(
    $link,
    'CREATE TABLE `discussions` (
  `my_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `user` VARCHAR(32) DEFAULT NULL,
  `comment` TEXT DEFAULT NULL,
  `path` VARCHAR(255) DEFAULT NULL,
  )'
);

/* After the database has been released, if you want to add a column,
 * alter the table. These functions will just not do anything
 * if the table already exists, so you cannot just add fields above.
 */

?>
<html>
<head><title>Gina Installer: Database created.</title></head>
The database has been created. Click continue to populate it.<br>
<form method=GET action="install.php">
    <input name="action" value="pop" type=hidden>
    <input type="submit" value="Continue">
</form>
<?php
break;
case 'pop':
    ?>
    <html>
    <head>
        <meta http-equiv="refresh" content="0; index.php?l=10"
    </head>
    </html>
    <?php
    break;
}

?>

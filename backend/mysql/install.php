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
require_once __DIR__ . '/database.php';

$link = jz_db_connect();

jz_db_query(
    "CREATE TABLE `nodes` (
  `my_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(150) DEFAULT NULL,
  `leaf` VARCHAR(5) DEFAULT 'false',
  `playcount` INT DEFAULT 0,
  `rating` INT DEFAULT 0,
  `rating_count` INT DEFAULT 0,
  `main_art` VARCHAR(255) DEFAULT NULL,
  `valid` VARCHAR(5) DEFAULT 'true',
  `path` VARCHAR(255) DEFAULT '/',
  `level` INT DEFAULT 0,
  `date_added` DATE DEFAULT NULL
)",
    $link
);
// is it better to link these by key or path?
jz_db_query(
    "CREATE TABLE `leaves` (
  `path` VARCHAR(255) DEFAULT NULL,
  `thumbnail` VARCHAR(255) DEFAULT NULL,
  `desc` VARCHAR(255) DEFAULT NULL,
  `longdesc` TEXT DEFAULT NULL,
  `number` INT(3) DEFAULT 0,
  `rate` VARCHAR(10) DEFAULT '-',
  `freq` VARCHAR(10) DEFAULT '-',
  `size` VARCHAR(10) DEFAULT '-',
  `length` VARCHAR(10) DEFAULT '-',
  `year` VARCHAR(5) DEFAULT '-',
  `lyrics` TEXT DEFAULT NULL
  )",
    $link
);

jz_db_query(
    'CREATE TABLE `discussions` (
  `my_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `user` VARCHAR(32) DEFAULT NULL,
  `comment` TEXT DEFAULT NULL,
  `path` VARCHAR(255) DEFAULT NULL,
  )',
    $link
);

/* To add columns, you should 'alter table' so that upgraders
 * can run this installer.
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

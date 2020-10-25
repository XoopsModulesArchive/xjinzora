<?php
// This functions take a directory and returns how many sub items there are
// Added 4.5.04 by Ross Carlson
// Returns the number of sub directories found
function readSubItems($dirToLookIn)
{
    // Now let's read that dir for directories first

    $retArray = readDirInfo($dirToLookIn, 'dir');

    $count = count($retArray);

    // Now let's return the data

    return $count;
}

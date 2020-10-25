/* * * * * * * * * * * * * * * * * * *
*            Overrides              *
* * * * * * * * * * * * * * * * * * */

/**
* Returns the date the node was added.
*
* @author Ben Dodson
<bdodson@seas.upenn.edu>
* @version 5/14/2004
* @since 5/14/2004
*/
function getDateAdded() {
global $sql_type,$sql_pw,$sql_usr,$sql_socket,$sql_db;

if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw))
die ("could not connect to database.");

$path = addSlashes($this->getPathString());
$results = dbx_query($link, "SELECT date_added FROM nodes WHERE path = '$path'");
return $results->data[0][date_added];
}

/**
* Returns the number of times the node has been played.
*
* @author Ben Dodson
<bdodson@seas.upenn.edu>
* @version 5/14/2004
* @since 5/14/2004
*/
function getPlayCount() {
global $sql_type,$sql_pw,$sql_usr,$sql_socket,$sql_db;

if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw))
die ("could not connect to database.");

$path = addSlashes($this->getPathString());
$results = dbx_query($link, "SELECT playcount FROM nodes WHERE path = '$path'");
return $results->data[0][playcount];
}


/**
* Increments the node's playcount, as well
* as the playcount of its parents.
*
* @author Ben Dodson
<bdodson@seas.upenn.edu>
* @version 5/14/2004
* @since 5/14/2004
*/
function increasePlayCount() {
global $sql_type,$sql_pw,$sql_usr,$sql_socket,$sql_db;

if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw))
die ("could not connect to database.");

$path = addSlashes($this->getPathString());
dbx_query($link, "UPDATE nodes SET playcount = playcount+1 WHERE path = '$path'");

if (sizeof($ar = $this->getPath()) > 0) {
array_pop($ar);
$next = new jzMediaNode($ar);
$next->increasePlayCount();
}
}


/**
* Returns the main art for the node.
*
* @author Ben Dodson
<bdodson@seas.upenn.edu>
* @version 5/14/04
* @since 5/14/04
*/
function getMainArt() {
global $sql_type,$sql_pw,$sql_usr,$sql_socket,$sql_db;

if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw))
die ("could not connect to database.");

$path = addSlashes($this->getPathString());
$results = dbx_query($link, "SELECT main_art FROM nodes WHERE path = '$path'");
return stripSlashes($results->data[0][main_art]);
}


/**
* Sets the node's main art
*
* @author
* @version
* @since
*/
function addMainArt($image) {}


/**
* Returns the miscellaneous artwork attached to the node.
*
* @author
* @version
* @since
*/
function getRandomArt() {}


/**
* Adds misc. artwork to the node.
*
* @author
* @version
* @since
*/
function addRandomArt($image) {}


/**
* Returns a brief description for the node.
*
* @author
* @version
* @since
*/
function getShortDescripiton() {}


/**
* Adds a brief description.
*
* @author
* @version
* @since
*/
function addShortDescription($text) {}


/**
* Returns the description of the node.
*
* @author
* @version
* @since
*/
function getDescription() {}


/**
* Adds a description.
*
* @author
* @version
* @since
*/
function addDescription($text) {}


/**
* Gets the overall rating for the node.
*
* @author
* @version
* @since
*/
function getRating() {}


/**
* Add a rating for the node.
*
* @author
* @version
* @since
*/
function addRating($rating) {
global $sql_type,$sql_pw,$sql_usr,$sql_socket,$sql_db;

if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw))
die ("could not connect to database.");

$path = addSlashes($this->getPathString());
$results = dbx_query($link, "UPDATE nodes SET rating=rating+$rating,
rating_count=rating_count+1 WHERE path = '$path'");

// should this update parents too?
}


/**
* Returns the node's discussion
*
* @author
* @version
* @since
*/
function getDiscussion() {}


/**
* Adds a blurb to the node's discussion
*
* @author Ben Dodson
<bdodson@seas.upenn.edu>
* @version 5/15/04
* @since 5/15/04
*/
function addDiscussion($text,$username) {
global $sql_type,$sql_pw,$sql_usr,$sql_socket,$sql_db;

if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw))
die ("could not connect to database.");

$path = addSlashes($this->getPathString());
$text = addSlashes($text);
$username = addSlashes($username);

dbx_query($link, "INSERT INTO discussions(path,user,comment)
VALUES('$path','$username','$text')") || die(dbx_error($link));
}
/**
* Returns the stringized version of the path in the form:
* genre/artist/album
*
* @author Ben Dodson
* @version 5/13/04
* @since 5/13/04
*/
function getPathString() {
return implode("/",$this->getPath());
}

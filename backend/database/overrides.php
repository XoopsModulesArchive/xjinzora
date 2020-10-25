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

$path = addSlashes($this->getPath("String"));
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

$path = addSlashes($this->getPath("String"));
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

$path = addSlashes($this->getPath("String"));
dbx_query($link, "UPDATE nodes SET playcount = playcount+1 WHERE path = '$path'");

if (sizeof($ar = $this->getPath()) > 0) {
array_pop($ar);
$next = new jzMediaNode($ar);
$next->increasePlayCount();
}
}

/**
* Sets the elements playcount.
*
* @author Ben Dodson
<bdodson@seas.upenn.edu>
* @version 5/14/2004
* @since 5/14/2004
*/
function setPlayCount($n) {
global $sql_type,$sql_pw,$sql_usr,$sql_socket,$sql_db;

if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw))
die ("could not connect to database.");

$path = addSlashes($this->getPath("String"));
dbx_query($link, "UPDATE nodes SET playcount = $n WHERE path = '$path'");
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

$path = addSlashes($this->getPath("String"));
$results = dbx_query($link, "SELECT main_art FROM nodes WHERE path = '$path'");
return stripSlashes($results->data[0][main_art]);
}


/**
* Sets the node's main art
*
* @author Ben Dodson
* @version 6/7/04
* @since 6/7/04
*/
function addMainArt($image) {
global $sql_type,$sql_pw,$sql_usr,$sql_socket,$sql_db;

$image = addslashes($image);
if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw))
die ("could not connect to database.");

$path = addSlashes($this->getPath("String"));
$results = dbx_query($link, "UPDATE nodes SET main_art = '$image' WHERE path = '$path'");
}


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
* @author Ben Dodson
* @version 5/21/04
* @since 5/21/04
*/
function getShortDescripiton() {
global $sql_type,$sql_pw,$sql_usr,$sql_socket,$sql_db;

if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw))
die ("could not connect to database.");

$path = addSlashes($this->getPath("String"));
$results = dbx_query($link, "SELECT descr FROM nodes WHERE path = '$path'");
return stripSlashes($results->data[0][descr]);
}


/**
* Adds a brief description.
*
* @author Ben Dodson
* @version 5/21/04
* @since 5/21/04
*/
function addShortDescription($text) {
global $sql_type,$sql_pw,$sql_usr,$sql_socket,$sql_db;

$text = addSlashes($text);
if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw))
die ("could not connect to database.");

$path = addSlashes($this->getPath("String"));
$results = dbx_query($link, "UPDATE nodes SET descr = '$text'
WHERE path = '$path'");
}


/**
* Returns the description of the node.
*
* @author Ben Dodson
* @version 5/21/04
* @since 5/21/04
*/
function getDescription() {
global $sql_type,$sql_pw,$sql_usr,$sql_socket,$sql_db;

if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw))
die ("could not connect to database.");

$path = addSlashes($this->getPath("String"));
$results = dbx_query($link, "SELECT longdesc FROM nodes WHERE path = '$path'");
return stripSlashes($results->data[0][longdesc]);
}


/**
* Adds a description.
*
* @author Ben Dodson
* @version 5/21/04
* @since 5/21/04
*/
function addDescription($text) {
global $sql_type,$sql_pw,$sql_usr,$sql_socket,$sql_db;

$text = addSlashes($text);
if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw))
die ("could not connect to database.");

$path = addSlashes($this->getPath("String"));
$results = dbx_query($link, "UPDATE nodes SET longdesc = '$text'
WHERE path = '$path'");

}


/**
* Gets the overall rating for the node.
*
* @author Ben Dodson
* @version 6/7/04
* @since 6//704
*/
function getRating() {
global $sql_type,$sql_pw,$sql_usr,$sql_socket,$sql_db;

if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw))
die ("could not connect to database.");

$path = addSlashes($this->getPath("String"));
$results = dbx_query($link, "SELECT rating,rating_count FROM nodes WHERE path = '$path'");

return ($results->data[0]['rating_count'] == 0) ? 0 : $results->data[0]['rating'] / $results->data[0]['rating_count'];
}


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

$path = addSlashes($this->getPath("String"));
$results = dbx_query($link, "UPDATE nodes SET rating=rating+$rating,
rating_count=rating_count+1 WHERE path = '$path'");

// should this update parents too?
}


/**
* Returns the node's discussion
*
* @author Ben Dodson
* @version 6/7/04
* @since 6/7/04
*/
function getDiscussion() {
global $sql_type,$sql_pw,$sql_usr,$sql_socket,$sql_db;

if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw))
die ("could not connect to database.");

$path = addSlashes($this->getPath("String"));

$results = dbx_query($link, "SELECT * FROM discussions WHERE path LIKE '$path' ORDER BY my_id");

$discussion = array();
$i = 0;
foreach ($results->data as $key => $data) {
$discussion[$i]['user'] = stripslashes($data['user']);
$discussion[$i]['comment'] = stripslashes($data['comment']);

$i++;
}

return $discussion;
}


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

$path = addSlashes($this->getPath("String"));
$text = addSlashes($text);
$username = addSlashes($username);

dbx_query($link, "INSERT INTO discussions(path,user,comment)
VALUES('$path','$username','$text')") || die(dbx_error($link));
}


/**
* Returns the year of the element;
* if it is a leaf, returns the info from getMeta[year]
* else, returns the average of the result from its children.
* Entry is '-' for no year.
*
* @author Ben Dodson
* @version 5/21/04
* @since 5/21/04
*/
function getYear() {
global $sql_type,$sql_pw,$sql_usr,$sql_socket,$sql_db;

if (!$link = dbx_connect($sql_type, $sql_socket, $sql_db, $sql_usr, $sql_pw))
die ("could not connect to database.");

$path = addSlashes($this->getPath("String"));
if ($this->isLeaf()) {
$results = dbx_query($link, "SELECT year FROM tracks WHERE path = '$path'");
return $results->data[0][year];
}
else {
$results = dbx_query($link, "SELECT year FROM tracks WHERE path LIKE '${path}%' AND year != '-'");
$sum = 0;
$total = 0;
foreach ($results->data as $row) {
if (is_numeric($row[year])) {
$sum += $row[year];
$total++;
}
}
if ($total == 0) return '-';
return round($sum / $total);
}
}

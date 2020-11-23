<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'osuarchive');
define('DB_PASSWORD', 'password');
define('DB_NAME', 'osuarchive');
 
// Create connection
$db     =   new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>
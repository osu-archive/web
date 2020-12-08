<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'c0osuarchive');
define('DB_PASSWORD', 'kOm16g_8');
define('DB_NAME', 'c0osuarchive');
 
// Create connection
$db     =   new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>
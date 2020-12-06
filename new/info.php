<?php 
include_once('generic.php'); 
include("includes.php");
include_once('config.php'); 
include_once('parsedown.php'); 

$sql = "SELECT * FROM versions ORDER BY ReleaseDate DESC";

?>

<?php
include("navbar.php");

?>
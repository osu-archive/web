<?php include("../config.php");

$sql = "SELECT * FROM versions ORDER BY DateAdded DESC LIMIT 1";

$sql = $db->query($sql);
while($val = $sql->fetch_assoc()) {
    $a = $val;
}

$api = true;
include("../generic.php");

$a['OldThumbnail'] = grabshots($a); 



$b = trim(preg_replace('/\s+/', ' ', json_encode($a)));
header('Content-Type: application/json');
echo $b;
<?php include("../config.php");

$search = $_GET['search'];

if($search == ""){
    $sql = "SELECT * FROM versions ORDER BY ReleaseDate DESC";
}else{
    $queryinput = "%" . htmlspecialchars(addslashes($search)) . "%";
    $sql = "SELECT * FROM versions WHERE Name LIKE '" . $queryinput . "' OR Archiver LIKE '" . $queryinput . "' OR VersionInfo LIKE '" . $queryinput . "' OR Version LIKE '" . $queryinput . "' ORDER BY ReleaseDate DESC";
}

$count;

$sql = $db->query($sql);
while($val = $sql->fetch_assoc()) {
    $a[$count] = $val;
    $count += 1;
}

$b = trim(preg_replace('/\s+/', ' ', json_encode($a)));
header('Content-Type: application/json');
echo $b;
<?php
include("admin_generic.php");
include("../config.php");
include("../generic.php");

session_start();

if(!isset($_SESSION['role'])){
    header("Location: https://archive.osu.hubza.co.uk/error?error=You were logged out.");
    die();
    exit;
}


$sql = "SELECT * FROM versions WHERE `ID` = '" . htmlspecialchars(addslashes($_POST['id'])) . "'";

$sqlfinal = $db->query($sql);
while($val = $sqlfinal->fetch_assoc()) {
    $version = $val;
}

$orig_version = $version['Version'];
$orig_releasedate = $version['ReleaseDate'];
$orig_desc = $version['VersionInfo'];
$orig_descshort = $version['VersionInfoShort'];
$orig_screenshots = $version['Screenshots'];
$orig_changelog = $version['Changelog'];
$orig_category = $version['category'];
$orig_oadlurl = $version['OADL-URL'];
$orig_archiver = $version['Archiver'];
$orig_hidden = $version['hidden'];
$orig_updates = $version['autoupdate'];
$orig_supporter = $version['needssupporter'];


if(isset($_POST['version'])){  
    $version = $_POST['version'];
}else{
    $version = $orig_version;
}

if(isset($_POST['releasedate'])){  
    $releasedate = $_POST['releasedate'];
}else{
    $releasedate = $orig_releasedate;
}

if(isset($_POST['desc'])){  
    $desc = $_POST['desc'];
}else{
    $desc = $orig_desc;
}

if(isset($_POST['descshort'])){  
    $descshort = $_POST['descshort'];
}else{
    $descshort = $orig_descshort;
}

if(isset($_POST['screenshots'])){  
    $screenshots = $_POST['screenshots'];
}else{
    $screenshots = $orig_screenshots;
}

if(isset($_POST['changelog'])){  
    $changelog = $_POST['changelog'];
}else{
    $changelog = $orig_changelog;
}

if(isset($_POST['category'])){  
    $category = $_POST['category'];
}else{
    $category = $orig_category;
}

if(isset($_POST['screenshots'])){  
    $oadlurl = $_POST['screenshots'];
}else{
    $oadlurl = $orig_oadlurl;
}

if(isset($_POST['archiver'])){  
    $archiver = $_POST['archiver'];
}else{
    $archiver = $orig_archiver;
}

if(isset($_POST['hidden'])){  
    $hidden = $_POST['hidden'];
}else{
    $hidden = $orig_hidden;
}

if(isset($_POST['updates'])){  
    $updates = $_POST['updates'];
}else{
    $updates = $orig_updates;
}

if(isset($_POST['supporter'])){  
    $supporter = $_POST['supporter'];
}else{
    $supporter = $orig_supporter;
}


if($_SESSION['role'] == "111"){
	echo "is admin";
}else{
	if($version['Archiver'] == $_SESSION['username']){
		echo "is their version";
	}else{
		header("Location: https://archive.osu.hubza.co.uk/error?error=You shouldn't be there.");
    die();
    exit;
    }
    $hidden = $orig_hidden;
    $category = $orig_category;
    $odalurl = $orig_odalurl;
    $archiver = $orig_archiver;
}

if($hidden == false){
    $hidden = 0;
}else{
    $hidden = 1;
}

if($updates == false){
    $updates = 0;
}else{
    $updates = 1;
}

if($supporter == false){
    $supporter = 0;
}else{
    $supporter = 1;
}

if(!isset($version)){
    if(isset($orig_version)){
        $version = $orig_version;
    }
}

if(!isset($releasedate)){
    if(isset($orig_releasedate)){
        $releasedate = $orig_releasedate;
    }
}

if(!isset($desc)){
    if(isset($orig_desc)){
        $desc = $orig_desc;
    }
}


if(!isset($descshort)){
    if(isset($orig_descshort)){
        $descshort = $orig_descshort;
    }
}

if(!isset($screenshots)){
    if(isset($orig_screenshots)){
        $screenshots = $orig_screenshots;
    }
}

if(!isset($changelog)){
    if(isset($orig_changelog)){
        $changelog = $orig_changelog;
    }
}

if(!isset($category)){
    if(isset($orig_category)){
        $category = $orig_category;
    }
}

if(!isset($oadlurl)){
    if(isset($orig_oadlurl)){
        $oadlurl = $orig_oadlurl;
    }
}

if(!isset($archiver)){
    if(isset($orig_archiver)){
        $archiver = $orig_archiver;
    }
}

if(!isset($hidden)){
    $hidden = $orig_hidden;
}

if(!isset($updates)){
    $updates = $orig_updates;
}

if(!isset($supporter)){
    $supporter = $orig_supporter;
}

if(!isset($hidden)){
    $hidden = 0;
}

if(!isset($updates)){
    $updates = 0;
}

if(!isset($supporter)){
    $supporter = 0;
}

echo "<br>version : " . $version;
echo "<br>releasedate : " . $releasedate;
echo "<br>desc : " . $desc;
echo "<br>descshort : " . $descshort;
echo "<br>screenshots : " . $screenshots;
echo "<br>changelog : " . $changelog;
echo "<br>category : " . $category;
echo "<br>oadlurl : " . $oadlurl;
echo "<br>archiver : " . $archiver;
echo "<br>hidden : " . $hidden;
echo "<br>updates : " . $updates;
echo "<br>supporter : " . $supporter;   

$id = htmlspecialchars(addslashes($_POST['id']));
$stmt = $db->prepare("UPDATE versions SET 'Version' = ?, 'ReleaseDate' = ?, 'VersionInfo' = ?, 'VersionInfoShort' = ?, 'Screenshots' = ?, 'Changelog' = ?, 'category' = ?, 'OADL-URL' = ?, 'Archiver' = ?, 'hidden' = ?, 'autoupdate' = ?, 'needssupporter' = ? WHERE 'ID' = ?");
$a = intval($hidden);
$b = intval($updates);
$c = intval($supporter);
$d = intval($id);
$stmt->bind_param("sssssssssiiii", $version, $releasedate, $desc, $descshort, $screenshots, $changelog, $category, $oadlurl, $archiver, $a, $b, $c, $d);
$stmt->execute();
$stmt->close();

echo "test";
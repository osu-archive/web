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

$version = $_POST['version'];
$releasedate = $_POST['releasedate'];
$desc = $_POST['desc'];
$descshort = $_POST['descshort'];
$screenshots = $_POST['desc'];
$changelog = $_POST['changelog'];
$category = $_POST['category'];
$oadlurl = $_POST['oadlurl'];
$archiver = $_POST['archiver'];
$hidden = $_POST['hidden'];
$updates = $_POST['updates'];
$supporter = $_POST['supporter'];


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
    if(isset($orig_hidden)){
        $hidden = $orig_hidden;
    }
}

if(!isset($updates)){
    if(isset($orig_updates)){
        $updates = $orig_updates;
    }
}

if(!isset($supporter)){
    if(isset($orig_supporter)){
        $supporter = $orig_supporter;
    }
}

echo "version : " . $version;
echo "releasedate : " . $releasedate;
echo "desc : " . $desc;
echo "descshort : " . $descshort;
echo "screenshots : " . $screenshots;
echo "changelog : " . $changelog;
echo "category : " . $category;
echo "oadlurl : " . $oadlurl;
echo "archiver : " . $archiver;
echo "hidden : " . $hidden;
echo "updates : " . $updates;
echo "supporter : " . $supporter;   

$id = htmlspecialchars(addslashes($_POST['id']));
$stmt = $db->prepare("UPDATE `versions` SET 'Version' = ?, 'ReleaseDate' = ?, 'VersionInfo' = ?, 'VersionInfoShort' = ?, 'Screenshots' = ?, 'Changelog' = ?, 'category' = ?, 'OADL-URL' = ?, 'Archiver' = ?, 'hidden' = ?, 'autoupdate' = ?, 'needssupporter' = ? WHERE 'ID' = ?");
$a = intval($hidden);
$b = intval($updates);
$c = intval($supporter);
$d = intval($id);
$stmt->bind_param("sssssssssiiii", $version, $releasedate, $desc, $descshort, $screenshots, $changelog, $category, $oadlurl, $archiver, $a, $b, $c, $d);
$stmt->execute();
$stmt->close();

echo "test";
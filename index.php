<?php
// Initialize the session
session_start();

// Include config file
include_once('config.php'); 

$random = 0;
$bglink;
$sql = $db->query("SELECT Count(ID) As nCount FROM versions ORDER BY ReleaseDate Desc");
while($val = $sql->fetch_assoc()) {
	$random = random_int(0, $val['nCount'] - 1);
}
$sql2 = $db->query("SELECT * FROM versions ORDER BY ReleaseDate Desc");
while($val2 = $sql2->fetch_assoc()) {
	if (intval($val2['ID']) == intval($random)) {
		$bglink = $val2['Screenshot1'];
	}
}
?>

<!doctype html>
<head>
    <meta charset="utf-8">
    <title>osu!archive</title>
    <meta name="keywords" content="osu,game,archive,old,versions,osu!">
    <meta name="description" content="archiving all the osu!game versions for the future">
    <meta name="author" content="Hubz & mulraf">
    <link rel="canonical" href="https://archive.osu.hubza.co.uk"/>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="listing.css">
    <link rel="stylesheet" href="listingobject.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" media="screen" />
</head>
<style>
.background-image {
    position: absolute;
    left: 0;
    top: 0;
    background-image: linear-gradient(#fffd, #fffe), url(<?php echo $bglink; ?>);
    background: no-repeat center center cover;
    background-repeat: no-repeat;
    width: 100%;

    -webkit-filter: blur(15px);
    -moz-filter: blur(15px);
    -o-filter: blur(15px);
    -ms-filter: blur(15px);
    filter: blur(15px);
    z-index: -51;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    background-repeat: no-repeat;
  background-attachment: fixed;
  height: 100%;
background-repeat: no-repeat;
background-attachment: fixed;
background-position: center;
background-size: cover;

background-attachment: fixed;
-webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;

  position: fixed;

}
</style>
<body>
    <div class="background-image"></div>
    <?php
		include 'header.html';
	?>
    <?php
		include 'listing.php';
	?>
    <?php
		include 'footer.html';
	?>
</body>
</html>


<?php 
include('config.php'); 
include('generic.php'); 
include("includes.php");
include_once('parsedown.php'); 


if(isset($_GET['search'])){
    $search = $_GET['search'];
}else{
    $search = "";
}

if($search == ""){
    
    $sql = "SELECT * FROM versions ORDER BY ReleaseDate DESC"; // default sql for getting versions
}else{
    $queryinput = "%" . htmlspecialchars(addslashes($search)) . "%";
    $sql = "SELECT * FROM versions WHERE Name LIKE '" . $queryinput . "' OR Archiver LIKE '" . $queryinput . "' OR VersionInfo LIKE '" . $queryinput . "' OR Version LIKE '" . $queryinput . "'";
    // sql for searching, we search the name, archiver, versioninfo, and version
    
    $sql .= "ORDER BY ReleaseDate DESC";
    // seperate ordering, in the future we'll have a dropdown for how to order
}

$sqlnews = "SELECT * FROM news ORDER BY date DESC"; // grab the news
$news = $db->query($sqlnews); // gonna run that

$t3sql = "SELECT COUNT(ID) AS SubmittedVersions, Archiver, ArchiverID, ArchiverURL
FROM versions
GROUP BY Archiver, ArchiverID
ORDER BY COUNT(ID) DESC
LIMIT 3"; // sql by mulraf to get the top 3

$t3 = $db->query($t3sql); // gonna run that too

$sqllatest = "SELECT * FROM versions ORDER BY DateAdded DESC LIMIT 1"; // get the newest version for meta thumbnail
$sqllateste = $db->query($sqllatest); // run that
while($val = $sqllateste->fetch_assoc()) {
    $screenshots = grabshots($val); // get the screenshots
    $screenshot = $screenshots[0]; // get the first one
}


$versionarray;

$versions = 0; // version counter
$downloads = 0;
$views = 0;
$sqle = $db->query($sql); // run the version sql
while($val = $sqle->fetch_assoc()) { 
    $versions += 1; // count up
    $versionarray[$versions] = $val;
    $downloads += $val['Downloads'];
    $views += $val['Views'];
}

        
?>

<script src="https://getinsights.io/js/insights.js"></script>
<script>
insights.init('QfrddlUerPUZBohw'); // this is analytics, don't touch
insights.trackPages();
</script>

<?php
include("navbar.php");

?>

<head>
    <!-- Primary Meta Tags -->
    <title>osu!archive - archiving all the osu! versions from 2007 to now! </title>
    <meta name="title" content="osu!archive - archiving all the osu! versions from 2007 to now! ">
    <meta name="description"
        content="your #1 place to get old & rare osu! versions, with an awesome Discord community and over 50 versions! ">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="osu!archive - archiving all the osu! versions from 2007 to now! ">
    <meta property="og:description"
        content="your #1 place to get old & rare osu! versions, with an awesome Discord community and over 50 versions! ">
    <meta property="og:image" content="<?php echo $screenshot; ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="osu!archive - archiving all the osu! versions from 2007 to now! ">
    <meta property="twitter:description"
        content="your #1 place to get old & rare osu! versions, with an awesome Discord community and over 50 versions! ">
    <meta property="twitter:image" content="<?php echo $screenshot; ?>">

    <meta name="viewport" content="width=device-width, initial-scale=0.6 ">
</head>

<div class="page home">
    There has been a total of <?php echo $views; ?> views across all versions, with <?php echo $downloads; ?> downloads across all.

   <br>
   <br>
    <?php
    include("footer.php");
    ?>
</div>
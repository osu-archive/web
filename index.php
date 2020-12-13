<?php 
include_once('generic.php'); 
include("includes.php");
include_once('config.php'); 
include_once('parsedown.php'); 


$search = $_GET['search'];

if($search == ""){
    $sql = "SELECT * FROM versions ORDER BY ReleaseDate DESC";
}else{
    $queryinput = "%" . htmlspecialchars(addslashes($search)) . "%";
    $sql = "SELECT * FROM versions WHERE Name LIKE '" . $queryinput . "' OR Archiver LIKE '" . $queryinput . "' OR VersionInfo LIKE '" . $queryinput . "' OR Version LIKE '" . $queryinput . "'";
    
    $sql .= "ORDER BY ReleaseDate DESC";
}

$sqlnews = "SELECT * FROM news ORDER BY date DESC";
$news = $db->query($sqlnews);

$t3sql = "SELECT COUNT(ID) AS SubmittedVersions, Archiver, ArchiverID, ArchiverURL
FROM versions
GROUP BY Archiver, ArchiverID
ORDER BY COUNT(ID) DESC
LIMIT 3"; // sql by mulraf

$t3 = $db->query($t3sql);

$sqllatest = "SELECT * FROM versions ORDER BY DateAdded DESC LIMIT 1";
$sqllateste = $db->query($sqllatest);
while($val = $sqllateste->fetch_assoc()) {
    $screenshots = grabshots($val); 
    $screenshot = $screenshots[0];
}

$versions = 0;
$sqle = $db->query($sql);
while($val = $sqle->fetch_assoc()) {
    $versions += 1;
    
}

        
?>

<script src="https://getinsights.io/js/insights.js"></script>
<script>
insights.init('QfrddlUerPUZBohw');
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
    <meta property="og:url" content="https://archive.osu.hubza.co.uk/">
    <meta property="og:title" content="osu!archive - archiving all the osu! versions from 2007 to now! ">
    <meta property="og:description"
        content="your #1 place to get old & rare osu! versions, with an awesome Discord community and over 50 versions! ">
    <meta property="og:image" content="<?php echo $screenshot; ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://archive.osu.hubza.co.uk/">
    <meta property="twitter:title" content="osu!archive - archiving all the osu! versions from 2007 to now! ">
    <meta property="twitter:description"
        content="your #1 place to get old & rare osu! versions, with an awesome Discord community and over 50 versions! ">
    <meta property="twitter:image" content="<?php echo $screenshot; ?>">

    <meta name="viewport" content="width=device-width, initial-scale=0.6 ">
</head>

<div class="page home">
    <div class="versions">

        <div class="v-header">
            <div class="vh-top">
                <p class="vh-text">Versions <span style="font-weight: 200; "><?php echo $versions?></span></p>
            </div>
            <div class="vh-bottom">
                <form action="./" method="get">
                    <div class="search-bar">
                        <i class="fas fa-search"></i>
                        <input name="search" class="real-search-bar" value="<?php echo $search; ?>"
                            placeholder="search for a version..."></input>
                    </div>
                </form>
            </div>
        </div>

        <div class="v-content">
            <?php
            $found = false;
            $sqle = $db->query($sql);
        while($val = $sqle->fetch_assoc()) {

            if(strtotime($val['DateAdded']) < strtotime("-2 days")){
                $new = false;
            }else{
                $new = true;
            }

            if($val['hidden'] == 0){
            $found = true;
            
            $screenshots = grabshots($val); 
            $desc = $val['VersionInfoShort'];
            if($desc == ""){
                $desc = Parsedown::instance()->text(grabfirstsentence($val['VersionInfo']));
            }else{
                $desc = Parsedown::instance()->text($desc); 
            }
            if($desc == ""){
                $desc = "<p>No description found.</p>";
            }
        ?>
            <div class="version">
                <div class="image-container">
                    <img class="version-image" src="<?php echo $screenshots[0]; ?>">
                </div>
                <div class="texts">
                    <div class="ver-header">
                        <div class="name">
                            <p class="verh-name"><?php echo $val['Version']; ?> </p>
                            <?php if($new == true){
                            ?>

                            <div class="new-container">
                                New!
                            </div>

                            <?php
                            }
                            ?>
                        </div>
                        <div class="ver-arch">
                            <p class="verh-version"><?php echo date("F j, Y", strtotime($val['ReleaseDate'])); ?></p>
                            <p class="verh-archiver">archived by <strong><?php echo $val['Archiver']; ?></strong></p>
                        </div>
                    </div>
                    <div class="ver-description">
                        <?php echo $desc; ?>

                    </div>
                    <div class="ver-viewdown">
                        <div class="vevd-views">
                            <i class="fas fa-eye"></i>
                            <p class="vevd-view-count"><?php echo $val['Views']; ?></p>
                        </div>
                        <div class="vevd-downloads">
                            <i class="fas fa-download"></i>
                            <p class="vevd-download-count"><?php echo $val['Downloads']; ?></p>
                        </div>
                    </div>
                    <div class="download-button">
                        <a class="db-download" href="info?v=<?php echo $val['Version']; ?>">View more & Download!</a>
                    </div>
                </div>
            </div>
            <?php
        }
    }

    if($found == false){
        echo "No results found. Try a different search query.";
    }
        ?>
        </div>
    </div>
    <div class="page-divider">

    </div>
    <div class="news">
        <div class="v-header">
            <div class="vh-top">
                <p class="vh-text">Top 3 uploaders</p>
            </div>
            <div class="vh-botton">
                <p class="vh-text-small">The top archivers from the osu!archive community!</p>
            </div>
        </div>
        <div class="top3up-content">
            <?php 
            $count = 0;
        while($val = $t3->fetch_assoc()) {
            $count += 1;

            $pfpurl = "";
            $afa = "SELECT * FROM t3users WHERE username = '" . $val['Archiver'] . "'";
            $t3u = $db->query($afa);
            while($val2 = $t3u->fetch_assoc()){
                $pfpurl = $val2['pfp'];
            }


            ?>


            <div class="tu-user">
                <img src="<?php echo $pfpurl; ?>" class="tuu-pfp">
                <p class="tuu-username"><?php echo $val['Archiver']; ?></p>
                <p class="tuu-rank">#<?php echo $count; ?> with <?php echo $val['SubmittedVersions'] ?> versions.</p>
            </div>
            <?php

        }
        ?>
        </div>
        <div class="v-header">
            <div class="vh-top">
                <p class="vh-text">News</p>
            </div>
            <div class="vh-botton">
                <p class="vh-text-small">The latest updates from the osu!archive team</p>
            </div>
        </div>
        <div class="n-content">
            <?php 
        while($val = $news->fetch_assoc()) {

            ?>
            <div class="n-panel"
                style="background-image: url(https://upload.hubza.co.uk/i/osu%21_vkXaXvBqzB_2020-November-20.png);">
                <div class="np-content">
                    <p class="np-by">by <?php echo $val['author']; ?></p>
                    <p class="np-title"><?php echo $val['postname']; ?></p>
                    <p class="np-desc"><?php echo $val['short-desc']; ?></p>
                    <a class="np-but" href="news?post=<?php echo $val['bname']; ?>">read more</a>
                </div>
            </div>
            <?php

        }

        ?>
        </div>
    </div>
</div>
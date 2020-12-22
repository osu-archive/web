<?php 
include_once('config.php'); 
include_once('generic.php'); 
include("includes.php");
include_once('parsedown.php'); 

$version = htmlspecialchars(addslashes($_GET['v']));
if(!isset($_GET['v'])){
    $version = htmlspecialchars(addslashes($_GET['Version']));
}

$sql = "SELECT * FROM versions WHERE `Version` = '" . $version . "'";

$sqlfinal = $db->query($sql);
while($val = $sqlfinal->fetch_assoc()) {
    $screenshots = grabshots($val); 
    $screenshot = $screenshots[0];
    $en = $val;
    $viewCount = $val['Views'];
    $desc = grabfirstsentence($val['VersionInfo']);
}


?>

<script src="https://getinsights.io/js/insights.js"></script>
<script>
insights.init('QfrddlUerPUZBohw');
insights.trackPages();
</script>

<?php
$viewCount = $viewCount + 1;
 
$updateSql = $db->query("UPDATE versions SET `Views` = " . $viewCount . " WHERE `Version` = '" . $version . "'");
?>

<?php
include("navbar.php");

?>

<head>
    <!-- Primary Meta Tags -->
    <title>osu!archive • version - <?php echo $en['Name']; ?> (<?php echo $en['Version']; ?>)</title>
    <meta name="title" content="osu!archive • version - <?php echo $en['Name']; ?> (<?php echo $en['Version']; ?>)">
    <meta name="description"
        content="<?php echo $desc; ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://archive.osu.hubza.co.uk/">
    <meta property="og:title" content="osu!archive • version - <?php echo $en['Name']; ?> (<?php echo $en['Version']; ?>)">
    <meta property="og:description"
        content="<?php echo $desc; ?>">
    <meta property="og:image" content="<?php echo $screenshot; ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://archive.osu.hubza.co.uk/">
    <meta property="twitter:title" content="osu!archive • version - <?php echo $en['Name']; ?> (<?php echo $en['Version']; ?>)">
    <meta property="twitter:description"
        content="<?php echo $desc; ?>">
    <meta property="twitter:image" content="<?php echo $screenshot; ?>">

    <meta name="viewport" content="width=device-width, initial-scale=0.6 ">
</head>

<div class="page panel">
    <div class="ver-cont">
        <div class="v-header">
            <div class="vh-top">
                <p class="vh-text"><span style="font-weight: 200; ">Versions / </span> <?php echo htmlspecialchars(addslashes($_GET['v'])); ?></p>
            </div>
        </div>
        <?php
$sqlfinal = $db->query($sql);

while($val = $sqlfinal->fetch_assoc()) {

    ?>
        <div class="ver-panel">
            <div class="ver-panel-header" style="background-image: url(<?php echo $screenshot; ?>)">
                <div class="blur-cont">
                    <div class="bc-left">
                        <p class="versionname"><?php echo $val['Name']; ?> <span class="vn-thin"><?php echo $val['Version']; ?></span></p>
                        <p class="bc-date"><?php echo date("F jS, Y", strtotime($val['ReleaseDate'])); ?></p>
                        <p class="bc-archiver">archived by <a class="bca-name"><?php echo $val['Archiver']; ?></a></p>
                    </div>
                    <div class="bc-right">
                        <div class="bc-views">
                            <i class="fas fa-eye"></i>
                            <p class="bcv-view-count"><?php echo $val['Views']; ?></p>
                        </div>
                        <div class="bc-downloads">
                            <i class="fas fa-download dlb"></i>
                            <p class="bcd-download-count"><?php echo $val['Downloads']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ver-panel-content">
                <?php
$usewarning = false;
                if(0 == 1){ 
                    $usewarning = true;

                    ?>
                <div class="warning">
                    <i class="fas fa-exclamation-circle"></i>
                    <p class="warning-text">This version automatically updates when starting. Learn how to disable auto-update</p>
                </div>
                <div class="warning">
                    <i class="fas fa-exclamation-circle"></i>
                    <p class="warning-text">This version requires supporter. Learn how to enable supporter here.</p>
                </div>
                <?php
                }
                ?>  
                <?php if($val['VersionInfo'] != ""){ ?>
                <p class="vpc-description <?php if($usewarning == true) { echo "vpcd-paddingtop"; } ?>"><?php echo $val['VersionInfo']; ?></p>
                <?php
                }
                ?>
                <a class="vpc-download-button" href="https://archive.osu.hubza.co.uk/download?v=<?php echo $val["Version"]; ?>"><i class="fas fa-download"></i><p class="db">Download</p></a>
            </div>
        </div>
        <div class="screenshots">
            <?php
            $screenshots = grabshots($val);
                foreach ($screenshots as $value) {
                    ?>
                    <img src="
                    <?php
                    echo $value;
                    ?>
                    " class="ss-screenshot">
                    <?php
                }
            ?>
        </div>
        <?php
}
?>
    </div>
</div>


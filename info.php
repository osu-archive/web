<?php 
// this is also hell, good luck

include('config.php'); // include config and stuff
include('generic.php');  // generic, includes functions that'll help
include("includes.php"); // css includes and stuff
include_once('addons/parsedown.php'); // to parse the markdown


// backwards compatability for old system
if(isset($_GET['Version'])){
    $version = htmlspecialchars(addslashes($_GET['Version']));
}

if(isset($_GET['v'])){
    $version = htmlspecialchars(addslashes($_GET['v']));
}

if(!isset($version)){
    include("navbar.php");
    e404("Could not find this version...");
    exit;
}

$version_exists = false;

$sql = "SELECT * FROM versions WHERE `Version` = '" . $version . "'";

$sqlfinal = $db->query($sql);
while($val = $sqlfinal->fetch_assoc()) {
    $version_exists = true;
    $screenshots = grabshots($val); 
    $screenshot = $screenshots[0];
    if(!checkOnline($screenshot)){
        $screenshot = "https://archive.osu.hubza.co.uk/img/screenshot_error.png";
    }
    $en = $val;
    $viewCount = $val['Views'];
    $desc = grabfirstsentence($val['VersionInfo']);

    
    $file = $val['OADL-URL'];
    
    if($file == ""){
        $file = $val['GDDL-URL'];
    }
    $ver_val = $val;
}


if($version_exists == false){
    include("navbar.php");
    e404("Could not find this version...");
    exit;
}


$viewCount = $viewCount + 1;
 
$updateSql = $db->query("UPDATE versions SET `Views` = " . $viewCount . " WHERE `Version` = '" . $version . "'");

include("obj_navbar.php");

?>

<head>
    <!-- Primary Meta Tags -->
    <title>osu!archive • version - <?php echo $en['Name']; ?> (<?php echo $en['Version']; ?>)</title>
    <meta name="title" content="osu!archive • version - <?php echo $en['Name']; ?> (<?php echo $en['Version']; ?>)">
    <meta name="description" content="<?php echo $desc; ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://archive.osu.hubza.co.uk/">
    <meta property="og:title"
        content="osu!archive • version - <?php echo $en['Name']; ?> (<?php echo $en['Version']; ?>)">
    <meta property="og:description" content="<?php echo $desc; ?>">
    <meta property="og:image" content="<?php echo $screenshot; ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://archive.osu.hubza.co.uk/">
    <meta property="twitter:title"
        content="osu!archive • version - <?php echo $en['Name']; ?> (<?php echo $en['Version']; ?>)">
    <meta property="twitter:description" content="<?php echo $desc; ?>">
    <meta property="twitter:image" content="<?php echo $screenshot; ?>">

    <meta name="viewport" content="width=device-width, initial-scale=0.6 ">
    <meta name="keywords"
        content="osu, old, version, osugame, archive, archival, hubz, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020">
</head>

<div class="page panel">
    <div class="ver-cont">
        <div class="v-header">
            <div class="vh-top">
                <p class="vh-text"><span style="font-weight: 200; ">Versions / </span>
                    <?php echo $ver_val["Version"]; ?></p>
            </div>
        </div>
        <div class="ver-panel">
            <div class="ver-panel-header" style="background-image: url(<?php echo $screenshot; ?>)">
                <div class="blur-cont">
                    <div class="bc-left">
                        <p class="versionname"><?php echo $ver_val['Name']; ?> <span
                                class="vn-thin"><?php echo $ver_val['Version']; ?></span></p>
                        <p class="bc-date"><?php echo date("F jS, Y", strtotime($ver_val['ReleaseDate'])); ?></p>
                        <p class="bc-archiver">archived by <a class="bca-name"><?php echo $ver_val['Archiver']; ?></a></p>
                    </div>
                    <div class="bc-right">
                        <div class="bc-views">
                            <i class="fas fa-eye"></i>
                            <p class="bcv-view-count"><?php echo $ver_val['Views']; ?></p>
                        </div>
                        <div class="bc-downloads">
                            <i class="fas fa-download dlb"></i>
                            <p class="bcd-download-count"><?php echo $ver_val['Downloads']; ?></p>
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
                    <p class="warning-text">This version automatically updates when starting. Learn how to disable
                        auto-update</p>
                </div>
                <div class="warning">
                    <i class="fas fa-exclamation-circle"></i>
                    <p class="warning-text">This version requires supporter. Learn how to enable supporter here.</p>
                </div>
                <?php
                }
                ?>
                <?php if($ver_val['VersionInfo'] != ""){ ?>
                <p class="vpc-description <?php if($usewarning == true) { echo "vpcd-paddingtop"; } ?>">
                    <?php echo $ver_val['VersionInfo']; ?>
                </p>
                <?php }
    
                if(checkOnline($file) == true){ ?>
                <a class="vpc-download-button" href="https://archive.osu.hubza.co.uk/download?v=<?php echo $ver_val["Version"]; ?>">
                    <i class="fas fa-download"></i>
                    <p class="db">Download</p>
                </a>
                <?php } else { ?>
                <div class="warning" style="filter: hue-rotate(-46deg) saturate(2);">
                    <i class="fas fa-exclamation-circle"></i>
                    <p class="warning-text">The download for this version is currently unavailable, please check back later.</p>
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="screenshots">
            <?php
            $screenshots = grabshots($ver_val);
            foreach ($screenshots as $value) { ?>
            <img src="<?php echo $value; ?>" class="ss-screenshot" onerror="this.src='https://archive.osu.hubza.co.uk/img/screenshot_error.png'">
            <?php } ?>
        </div>
    </div>
    <?php
    include("obj_footer.php"); // footer
    ?>
</div>
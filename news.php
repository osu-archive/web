<?php
// Initialize the session
session_start();

// Include config file
include_once('config.php'); 

$bglink;
$sql = $db->query("SELECT * FROM versions WHERE Version = '" . addslashes(htmlspecialchars($_GET['Version'])) . "' ORDER BY ReleaseDate Desc");
$random = random_int(1, 4);
$downloadCount;
while($val = $sql->fetch_assoc()) {
    $screen = "Screenshot" . $random;
    $bglink = $val[$screen];
    $downloadCount = $val['Views'];
    $arrDescription = explode("<br>", $val['VersionInfo']);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>osu!archive | <?php echo $val['Name'] . " · " . $val['Version']; ?></title>
    <meta name="description" content="<?php echo $arrDescription[0]; ?>">
    <meta name="author" content="Hubz">
    <meta property="og:image" content="<?php echo $val['Screenshot1']; ?>">
    <meta name="keywords" content="osu,game,archive,old,versions,osu!">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="infolisting.css">
    <script src="https://kit.fontawesome.com/91ad005f46.js" crossorigin="anonymous"></script>

</head>

<body>
    <div class="background-image"></div>
    <?php
		include 'header.html';
	?>
    <div class="listing">
        <div class="listingheader">
            <h1 class="listingheadertext"><span class='mini'>Version Listing > </span><?php echo $val['Name']; ?><span
                    class='mini'> >
                    <?php echo $val['Version']; ?></span></h1>
        </div>
        <div class="listingcontent">
            <div class="infocover">

                <div class="textcontainer">
                    <h1 class="ic-header"><?php echo $val['Name']; ?></h1>
                    <h1 class="ic-version">
                        <?php echo $val['Version'] . " · " . date("F", strtotime($val['ReleaseDate'])) . " " . date('j', strtotime($val['ReleaseDate'])) . date('S', strtotime($val['ReleaseDate'])) . " " . date('Y', strtotime($val['ReleaseDate'])); ?>
                    </h1>
                    <h1 class="archiver">archived by <a href="<?php echo $val['ArchiverURL']; ?>"><?php echo $val['Archiver'] ?></a></h1>
                    <div class="c-vadinfo">
                        <div class="c-views"><i class="fas fa-eye"></i> <?php echo $val['Views'] + 1; ?></div>
                        
                    </div>
                </div>
                <div class="bgimg"></div>
            </div>
            <div class="vl-desc">
                <h1 class="vl-desctext">
                    <?php echo $val['VersionInfo']; ?>
                </h1>
                <div class="dlcont">
                <a href="<?php echo $val['OADL-URL']; ?>"><button class="new-button listing-button">Download from osu!archive servers</button></a> 
                <?php if(strlen($val['GDDL-URL']) > 10) { echo "<a target=\"_blank\" rel=\"noopener noreferrer\" href=\"" . $val['GDDL-URL'] . "\"><button class=\"new-button listing-button\">Download from Google Drive</button></a>"; } ?>
</div>
            </div>
            <div class="screenshots">
            <div class="screenshotsheader">
                <h1 class="ssh-text">Screenshots</h1>
            </div>

            <div class="ss-container">
                <div class="ss-image">
                    <img src="<?php echo $val['Screenshot1']; ?>" />
                </div>
                <div class="ss-image">
                    <img src="<?php echo $val['Screenshot2']; ?>" />
                </div>
                <div class="ss-image">
                    <img src="<?php echo $val['Screenshot3']; ?>" />
                </div>
                <div class="ss-image">
                    <img src="<?php echo $val['Screenshot4']; ?>" />
                </div>
            </div>
        </div>
        </div>
        
    </div>
    </div>
    <?php
		include 'footer.html';
	?>

</body>
<style>
.background-image {
    position: absolute;
    left: 0;
    top: 0;
    background-image: linear-gradient(#fffd, #fffe), url(<?php echo $bglink; ?>);
    background: no-repeat center center cover;
    background-repeat: no-repeat;
    width: 100%;
    height: 100%;
    -webkit-filter: blur(5px);
    -moz-filter: blur(5px);
    -o-filter: blur(5px);
    -ms-filter: blur(5px);
    filter: blur(5px);
    z-index: -51;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    background-repeat: no-repeat;
  background-attachment: fixed;
height: 120%;
}

.infocover {
    background-image: linear-gradient(#fffe, #fffd), url(<?php echo $bglink; ?>);
}

<?php
}
$downloadCount += 1;
$updateSql = $db->query("UPDATE versions SET Views='" . $downloadCount . "' WHERE Version = '" . $_GET['Version'] . "'");
?>
</style>

</html>
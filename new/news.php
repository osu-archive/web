<?php 
include_once('generic.php'); 
include("includes.php");
include_once('config.php'); 
include_once('parsedown.php'); 

$sql = "SELECT * FROM news WHERE `bname` = '" . htmlspecialchars(addslashes($_GET['post'])) . "'";

$sqlfinal = $db->query($sql);
while($val = $sqlfinal->fetch_assoc()) {
    $screenshot = $val['thumbnail'];
    $name = $val['postname'];
    $desc = grabfirstsentence(file_get_contents("https://raw.githubusercontent.com/osu-archive/news/main/" . $val['bname'] . ".md"));
}


?>

<?php
include("navbar.php");

?>

<head>
    <!-- Primary Meta Tags -->
    <title>osu!archive • news - <?php echo $name; ?></title>
    <meta name="title" content="osu!archive • news - <?php echo $name; ?>">
    <meta name="description"
        content="<?php echo $desc; ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://archive.osu.hubza.co.uk/">
    <meta property="og:title" content="osu!archive • news - <?php echo $name; ?>">
    <meta property="og:description"
        content="<?php echo $desc; ?>">
    <meta property="og:image" content="<?php echo $screenshot; ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://archive.osu.hubza.co.uk/">
    <meta property="twitter:title" content="osu!archive • news - <?php echo $name; ?>">
    <meta property="twitter:description"
        content="<?php echo $desc; ?>">
    <meta property="twitter:image" content="<?php echo $screenshot; ?>">

    <meta name="viewport" content="width=device-width, initial-scale=0.6 ">
</head>

<div class="page panel">
    <div class="ver-cont">
        <div class="v-header">
            <div class="vh-top">
                <p class="vh-text"><span style="font-weight: 200; ">News / </span>
                    <?php echo htmlspecialchars(addslashes($_GET['post'])); ?></p>
            </div>
        </div>
        <?php
$sqlfinal = $db->query($sql);

while($val = $sqlfinal->fetch_assoc()) {
    $text = file_get_contents("https://raw.githubusercontent.com/osu-archive/news/main/" . $val['bname'] . ".md")


    ?>
        <div class="ver-panel">
            <div class="ver-panel-header" style="background-image: url(<?php echo $screenshot; ?>)">
                <div class="blur-cont">
                    <div class="bc-left">
                        <p class="versionname"><?php echo $val['postname']; ?></p>
                        <p class="bc-date"><?php echo date("F jS, Y", strtotime($val['date'])); ?></p>
                        <p class="bc-archiver">by <a class="bca-name"><?php echo $val['author']; ?></a></p>
                    </div>
                    <div class="bc-right">

                    </div>
                </div>
            </div>
            <div class="ver-panel-content newspost">
                <div class="vpc-description"><?php echo Parsedown::instance()->text($text) ?></v>
            </div>
        </div>
        <?php
}
?>
    </div>
</div>
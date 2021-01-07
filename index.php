<?php 
// this is hell, good luck

include('config.php'); // include config and stuff
include('generic.php');  // generic, includes functions that'll help
include("includes.php"); // css includes and stuff
include_once('addons/parsedown.php'); // to parse the markdown

// set the $search variable

if(isset($_GET['group'])){
    $group = $_GET['group'];
}else{
    $group = "";
}
$group = htmlspecialchars(addslashes($group));



if(isset($_GET['search'])){
    $search = $_GET['search'];
}else{
    $search = "";
}

// {SECTION} : Version SQL

if($group != "" || $search != ""){
    if($search == ""){
        $sql = "SELECT * FROM versions"; // default sql for getting versions
        if($group != ""){
            $sql .= " WHERE `group` = " . $group;
        }
        $sql .= " ORDER BY ReleaseDate DESC";
    }else{
        $queryinput = "%" . htmlspecialchars(addslashes($search)) . "%";
        $sql = "SELECT * FROM versions WHERE";
        
        $sql .= "(Name LIKE '" . $queryinput . "' OR Archiver LIKE '" . $queryinput . "' OR VersionInfo LIKE '" . $queryinput . "' OR Version LIKE '" . $queryinput . "')";
        
        if($group != ""){
            $sql .= "AND `group` = " . $group . " ";
        }
        
        // sql for searching, we search the name, archiver, versioninfo, and version

        $sql .= "ORDER BY ReleaseDate DESC";
        // seperate ordering, in the future we'll have a dropdown for how to order
    }
}else{
    $sql = "SELECT * FROM groups";
}

//echo $sql;

// {SECTION} : news

$sqlnews = "SELECT * FROM news ORDER BY date DESC"; // grab the news
$news = $db->query($sqlnews); // gonna run that

// {SECTION} : top 3

$t3sql = "SELECT COUNT(ID) AS SubmittedVersions, Archiver, ArchiverID, ArchiverURL
FROM versions
GROUP BY Archiver, ArchiverID
ORDER BY COUNT(ID) DESC
LIMIT 3"; // sql by mulraf to get the top 3

$t3 = $db->query($t3sql); // gonna run that too



$versions = 0; // version counter

if($group != ""){
    $sqle = $db->query($sql); // run the version sql
}else{
    $sqle = $db->query("SELECT * FROM versions");
}

while($val = $sqle->fetch_assoc()) { 
    $versions += 1; // count up
    // if its the first version
    if(!isset($screenshot)){
        $screenshots = grabshots($val); // get the screenshots
        $screenshot = $screenshots[0]; // get the first one
    }
}


if($group != ""){
    $groupname = "SELECT * FROM `groups` WHERE `id` = " . $group; // sql by mulraf to get the top 3

    $groupsql = $db->query($groupname); // gonna run that too

    while($val = $groupsql->fetch_assoc()) { 
        $gname = $val['name'];
    }
}

include("obj_navbar.php"); // include navbar

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
    <div class="versions">
        <div class="v-header">
            <div class="vh-top">
                <p class="vh-text"><?php if($group != ""){
                    echo $gname;
                } else{
                    echo "Groups";
                } ?> <span style="font-weight: 200; "><?php echo $versions?>
                <?php if($group == ""){
                    echo " Versions";
                }?>
                </span></p>
            </div>
            <div class="vh-bottom">
                <form action="./" method="get">
                <input type="hidden" id="group" name="group" value="<?php echo $group; ?>"> 
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
            if($group != "" || $search != ""){
            $found = false; // variable to see if a version was found

            $sqle = $db->query($sql);
            while($val = $sqle->fetch_assoc()) {

                if(strtotime($val['DateAdded']) < strtotime("-2 days")){
                    $new = false;
                }else{
                    $new = true;
                }
                // if the version was added in the last 2 days we're going to make it display a "New" box

                // gonna make sure the version is approved and isn't hidden
                if($val['hidden'] == 0 and $val['Approved'] == 1){
                $found = true; // setting this to true, if this stays false we know the search query doesnt have results
                
                $screenshots = grabshots($val); // get screnenshots
                $desc = $val['VersionInfoShort']; // get short description
                if($desc == ""){
                    // if short description doesn't exist we're gonna get the first sentence of VersionInfo
                    // then we'll run it through Parsedown so we can use italics n' stuff
                    $desc = Parsedown::instance()->text(grabfirstsentence($val['VersionInfo']));
                }else{
                    // else just run the short description through parsedown
                    $desc = Parsedown::instance()->text($desc); 
                }
                if($desc == ""){
                    $desc = "<p>No description found.</p>"; // fill description if there is none
                }
                ?>
            <div class="version">
                <div class="image-container">
                    <img class="version-image" src="<?php echo $screenshots[0]; ?>"
                        onerror="this.src='https://archive.osu.hubza.co.uk/img/screenshot_error.png'">
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
                        <a class="db-download" href="version/<?php echo $val['Version']; ?>">View more & Download!</a>
                    </div>
                </div>
            </div>
            <?php
            }
        }

        if($found == false){
            echo "No results found. Try a different search query."; // the search query didnt work or the sql went horribly wrong
        }
    }else{

        $sqle = $db->query("SELECT * FROM groups");
        while($val = $sqle->fetch_assoc()) {
            $vcount = $db->query("SELECT * FROM versions WHERE `group` = " . $val['id']);
            $vecount = 0;
            while($v = $vcount->fetch_assoc()) {
                $vecount += 1;
            }
        ?>
            <div class="group" style="background-image: url('<?php echo $val['image']; ?>')">
                <a class="group-a" href="<?php echo geturl(); ?>?group=<?php echo $val['id']; ?>">
                    <div class="group-overlay">

                    </div>
                    <div class="group-inner">
                        <div class="group-title-container">
                            <p class="group-title"><?php echo $val['name']; ?></p>
                            <p class="group-v-amount"><?php echo $vecount; ?> versions</p>
                        </div>
                        <p class="group-desc"><?php echo $val['description']; ?></p>
                    </div>
                </a>
            </div>
            <?php
        }
    }
    ?>
        </div>
    </div>
    <div class="page-divider">

    </div>
    <div class="news">
        <div class="sticky">
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
                // top 3 users
                $count += 1;

                $pfpurl = "";

                // get user pfp
                $afa = "SELECT * FROM t3users WHERE username = '" . $val['Archiver'] . "'";
                $t3u = $db->query($afa);
                while($val2 = $t3u->fetch_assoc()){
                    $pfpurl = $val2['pfp'];
                }
                ?>

                <div class="tu-user">
                    <img src="img/usr/<?php echo $val['Archiver']; ?>.jpg" class="tuu-pfp">
                    <p class="tuu-username"><?php echo $val['Archiver']; ?></p>
                    <p class="tuu-rank">#<?php echo $count; ?> with <?php echo $val['SubmittedVersions'] ?> versions.
                    </p>
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
                <?php while($val = $news->fetch_assoc()) { ?>
                <div class="n-panel" style="background-image: url(<?php echo $val['thumbnail']; ?>);">
                    <div class="np-content">
                        <p class="np-by">by <?php echo $val['author']; ?></p>
                        <p class="np-title"><?php echo $val['postname']; ?></p>
                        <p class="np-desc"><?php echo $val['short-desc']; ?></p>
                        <a class="np-but" href="news?post=<?php echo $val['bname']; ?>">read more</a>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php
    include("obj_footer.php"); // footer
    ?>
</div>
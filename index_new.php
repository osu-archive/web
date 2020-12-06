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
    $sql = "SELECT * FROM versions WHERE Name LIKE '" . $queryinput . "' OR Archiver LIKE '" . $queryinput . "' OR VersionInfo LIKE '" . $queryinput . "' OR Version LIKE '" . $queryinput . "' ORDER BY ReleaseDate DESC";
}

?>

<?php
include("navbar.php");

?>

<head>
    <meta charset="utf-8">
    <title>osu!archive - archiving all the osu!game versions for the future</title>
    <meta name="keywords" content="osu,game,archive,old,versions,osu!">
    <meta name="description" content="we have loads of versions, from the oldest known version, to triangles, to an interesting benchmark version, and more!">
    <meta name="author" content="Hubz">
    <link rel="canonical" href="https://archive.osu.hubza.co.uk"/>
</head>


<div class="page home">
    <div class="versions">

        <div class="v-header">
            <div class="vh-top">
                <p class="vh-text">Versions</p>
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
        $sql = $db->query($sql);
        while($val = $sql->fetch_assoc()) {

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
                            <p class="verh-name"><?php echo $val['Name']; ?></p>
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
                            <p class="verh-version"><?php echo $val['Version']; ?> (<?php echo $val['category']; ?>)</p>
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
                        <a class="db-download" href="info.php?Version=<?php echo $val['Version']; ?>">View more & Download!</a>
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
                <p class="vh-text">News</p>
            </div>
            <div class="vh-botton">
                <p class="vh-text-small">The latest updates from the osu!archive team</p>
            </div>
        </div>
        <div class="n-content">
            Coming Soon
        </div>
    </div>
</div>
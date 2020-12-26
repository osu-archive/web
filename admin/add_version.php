<?php
include("includes.php");
include("admin_generic.php");
include("../config.php");
include("../generic.php");

session_start();

if(!isset($_SESSION['role'])){
    header("Location: https://archive.osu.hubza.co.uk/admin/index");
    die();
    exit;
}



$version;


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
}

?>

<body>
    <div class="content">
        <?php
        function callback($buffer)
        {
          return (str_replace("nt-yourver", "nt-active", $buffer));
        }
        ob_start("callback");
        include 'navbar.php';
        ob_end_flush();
        ?>
        <div class="panel-containerv2">
            <h1 class="welcome">add a version</h1>
            if a field is left empty, nothing will be affected in that field.
            <div class="addversion">

                <form action="api_edit_version.php" method="post" class="addversion-form" enctype="multipart/form-data">
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <p class="av-title">Version:</p>
                    <input type="text" id="version" name="version" value=>
                    <p class="av-title">Release date:</p>
                    <input type="date" id="releasedate" name="releasedate"
                        value="" min="2007-01-01">
                    <p class="av-title">Description (supports Markdown):</p>
                    <input type="text" id="desc" name="desc" value="">
                    <p class="av-title">Description (Short):</p>
                    <input type="text" id="descshort" name="descshort"
                        value="">
                    <p class="av-title">Screenshots (seperated by spaces):</p>
                    <input type="text" id="screenshots" name="screenshots"
                        value="">
                    <p class="av-title">Changelog (optional):</p>
                    <input type="text" id="changelog" name="changelog" value="">

                    <?php
					if($_SESSION['role'] == "111"){

					?>
                    <p class="av-title av-admin">category:</p>
                    <input type="text" id="category" name="category" value="">
                    <p class="av-title av-admin">OADL url:</p>
                    <input type="text" id="oadlurl" name="oadlurl" value="">
                    <p class="av-title av-admin">Archiver:</p>
                    <input type="text" id="archiver" name="archiver" value="<?php echo $_SESSION['username'];?>">

                    <div class="checkboxbox">
                        <p class="av-title av-admin">Hidden:</p>
                        <input class="checkbox" type="checkbox" id="hidden" name="hidden"
                            value="<?php echo $version['hidden']; ?>">
                    </div>

                    <?php
					}
					?>

                    <div class="checkboxbox">
                        <p class="av-title">Auto updates:</p>
                        <input class="checkbox" type="checkbox" id="updates" name="updates"
                            value="<?php echo $version['autoupdate']; ?>">
                    </div>
                    <div class="checkboxbox">
                        <p class="av-title">Requires supporter:</p>
                        <input class="checkbox" type="checkbox" id="supporter" name="supporter"
                            value="<?php echo $version['needssupporter']; ?>">
                    </div>
                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>
</body>
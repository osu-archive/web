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
            <h1 class="welcome">your versions</h1>
            <a class="panelv2 panelv2-button" href="test">
                <div class="pv2button">
                    <div class="pv2b-line">
                    </div>
                    <div class="pv2b-text">
                        add new version
                    </div>
                </div>
            </a>
            <?php
            $sqllatest = "SELECT * FROM versions WHERE Archiver = '" . $_SESSION['username'] . "' ORDER BY DateAdded ";
            $sqllateste = $db->query($sqllatest);
            while($val = $sqllateste->fetch_assoc()) {
                verpan($val);
            }

                ?>
        </div>
</body>
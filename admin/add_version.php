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
        </div>
</body>
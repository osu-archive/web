<?php
include("includes.php");

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
          return (str_replace("nt-home", "nt-active", $buffer));
        }
        ob_start("callback");
        include 'navbar.php';
        ob_end_flush();
        ?>
        <div class="panel-containerv2">
            <h1 class="welcome">welcome back, <strong
                    style="font-weight: 800;"><?php echo $_SESSION['username']; ?></strong></h1>
            <a class="panelv2 panelv2-button" href="test">
                <div class="pv2button">
                    <div class="pv2b-line">
                    </div>
                    <div class="pv2b-text">
                        view your versions
                    </div>
                </div>
            </a>
            <?php if($_SESSION['role'] == 111){ ?>
                <a class="panelv2 panelv2-button" href="test">
                <div class="pv2button">
                    <div class="pv2b-line adminline">
                    </div>
                    <div class="pv2b-text">
                        view all versions
                    </div>
                </div>
            </a>
            <a class="panelv2 panelv2-button" href="test">
                <div class="pv2button">
                    <div class="pv2b-line adminline">
                    </div>
                    <div class="pv2b-text">
                        add a new version
                    </div>
                </div>
            </a>
            
            <?php } else { ?>
                <a class="panelv2 panelv2-button" href="test">
                <div class="pv2button">
                    <div class="pv2b-line">
                    </div>
                    <div class="pv2b-text">
                        submit a new version
                    </div>
                </div>
            </a>
                <?php } ?>
        </div>
    </div>
</body>
<div class="header">
    <div class="logo">
        <a class="header-top" href="./">
            <img src="https://upload.hubza.co.uk/i/osuarchivelogo.svg" class="ht-logo">
        </a>
        <div class="header-bottom">
            <p class="hb-text">administrator panel</hb>
        </div>
    </div>
    <div class="hb-right">
        <div class="user">
            <img src="<?php echo $_SESSION['avatar_url']; ?>" class="user-pfp">
            <p class="hb-text usertext">logged in as <strong><?php echo $_SESSION['username']; ?>
                    <?php if($_SESSION['role'] == 111){ echo ' (Admin)'; } ?></strong></hb>
        </div>
    </div>
</div>
<div class="nav">
    <a class="navtext nt-home">home</a>
    <a class="navtext nt-yourver">your versions</a>
    <?php if($_SESSION['role'] == 111)
    {
       ?>
    <a class="navtext nt-allver">all versions</a>
    <?php
    }
    ?>
</div>
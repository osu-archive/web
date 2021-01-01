<?php
$f_contents = file("splash.txt"); 
$line = $f_contents[rand(0, count($f_contents) - 1)];
//$line = "Happy new year!";
?>
<!-- <div class="notice" style="background-color: #ee1111; padding:10px;">
    <p class="notice-text" style="color: white;">Work is being performed on the server, expect some blips in uptime.</p>
</div>
-->
<div class="header">
    <a class="header-top" href="https://<?php echo $_SERVER['SERVER_NAME']; ?>">
        <img src="https://<?php echo $_SERVER['SERVER_NAME']; ?>/img/logo.svg" class="ht-logo">
</a>
    <div class="header-bottom">
        <p class="hb-text"><?php echo $line; ?></hb>
        <div class="hb-right">
        <a style="text-decoration: none !important; color: white; font-size: 20px;" href="https://forms.gle/EByj5M6xvKy7WuSAA">Submit a version!</a>
        <a style="text-decoration: none !important; color: white; font-size: 20px; margin-left: 10px;" href="https://discord.gg/vXXunaGPHP">Join the Discord!</a>
        </div>
    </div>
</div>
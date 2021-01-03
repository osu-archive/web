<link id="favi" rel="icon" href="/favicon.svg">
<link rel="apple-touch-icon" sizes="180x180" href="/favicon-touch.svg">
<link rel="apple-touch-icon" sizes="256x256" href="/favicon-touch.svg">
<link rel="icon" type='image/png' sizes='256x256' href="/favicon-touch.svg"/>
<link rel="mask-icon" href="/favicon.svg" color="#0090DE">
<meta name="msapplication-TileColor" content="#0090DE">
<meta name="theme-color" content="#0090DE"> 
<link rel="shortcut icon" type="image/png" sizes="256x256" href="favicon-touch.png">

<?php
$f_contents = file("splash.txt"); 
$line = $f_contents[rand(0, count($f_contents) - 1)];
//$line = "Happy new year!";
?>
<!--
<div class="notice" style="background-color: #ee1111; padding:10px;">
    <p class="notice-text" style="color: white;"><i class="fas fa-exclamation-triangle"></i> Work is being performed on one of the servers we depend on, some screenshots and downloads could be non-functional.</p>
</div>
-->
<div class="header">
    <a class="header-top" href="https://<?php echo $_SERVER['SERVER_NAME']; ?>">
        <img src="https://<?php echo $_SERVER['SERVER_NAME']; ?>/img/logo.svg" class="ht-logo">
    </a>
    <div class="header-bottom">
        <p class="hb-text"><?php echo $line; ?></hb>
        <div class="hb-right">
            <a style="text-decoration: none !important; color: white; font-size: 20px;"
                href="https://forms.gle/EByj5M6xvKy7WuSAA">Submit a version!</a>
            <a style="text-decoration: none !important; color: white; font-size: 20px; margin-left: 10px;"
                href="https://discord.gg/vXXunaGPHP">Join the Discord!</a>
        </div>
    </div>
</div>
<?php 
include("config.php");


if(!empty($_GET['v'])){
    $version = htmlspecialchars(addslashes($_GET['v']));
    $sql = "SELECT * FROM versions WHERE `Version` = '" . $version . "'";
    
    $sqlfinal = $db->query($sql);
    while($val = $sqlfinal->fetch_assoc()) {
        $file = $val['OADL-URL'];
        if($file == ""){
            $file = $val['GDDL-URL'];
        }
        $downloads = $val['Downloads'];
    }

    $downloads = $downloads + 1;
    $sqldownloads = "UPDATE `versions` SET `Downloads` = '" . $downloads . "' WHERE `Version` =  '" . $version . "'";
    //echo $sqldownloads;
    $sql2 = $db->query($sqldownloads);
    
    exit(header("Location: " . $file));
}else{
    exit(header("Location: ./index.php"));
}

?>
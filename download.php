<?php 
include("config.php");

function checkOnline($domain) {
    $curlInit = curl_init($domain);
    curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
    curl_setopt($curlInit,CURLOPT_HEADER,true);
    curl_setopt($curlInit,CURLOPT_NOBODY,true);
    curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);
 
    //get answer
    $response = curl_exec($curlInit);
 
    curl_close($curlInit);
    if ($response) return true;
    return false;
 }

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

    if(!checkOnline($file)){
        
        exit(header("Location: https://" . $_SERVER['SERVER_NAME'] . "/error?error=Could not contact the download server. Please try again later."));
    }

    $downloads = $downloads + 1;
    $sqldownloads = "UPDATE `versions` SET `Downloads` = '" . $downloads . "' WHERE `Version` =  '" . $version . "'";
    //echo $sqldownloads;
    $sql2 = $db->query($sqldownloads);
    
    exit(header("Location: " . $file));
    echo "Could not redirect. Please go to " . $file;
}else{
    exit(header("Location: ./index.php"));
}

?>
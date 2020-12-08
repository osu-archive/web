<?php
function grabshots($val){
    $a;
    if($val['Screenshots'] == ""){
        $a[0] = $val['Screenshot1'];
        $a[1] = $val['Screenshot2'];
        $a[2] = $val['Screenshot3'];
        $a[3] = $val['Screenshot4'];
    }else{
        $texts = $val['Screenshots'];
        $a = explode(";", $texts);
    }
    return $a;
}

function grabfirstsentence($text){
    $pos = strpos($text, '.');
       
    if($pos === false) {
        return preg_replace("/\r|\n/", "", $text);
    }
    else {
        return substr($text, 0, $pos+1);
    }
}
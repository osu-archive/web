<?php

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

function geturl(){
    // https://stackoverflow.com/a/6768831 - slightly edited
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    return $actual_link;
}

function checkOnline($domain) {
    if(strpos($domain, "mega")){
        return true;
    }
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

 function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
  
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
  
    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }
  
    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}


function exceptions_error_handler($severity, $message, $filename, $lineno) {
    echo "<div style='padding: 10px;";
    if($severity == 16 || $severity== 32 || $severity == 64){
        echo "background-color: red;'";
    }else{
        echo "background-color: #ffee22;'";
    }
    echo "><p><i class='fas fa-exclamation-triangle'></i>  " . $message . "</p></div>";
}

set_error_handler('exceptions_error_handler');

//include("error.php");
//exit;

function grabshots($val){
    if($val['Screenshots'] == ""){
        // check if the old screenshot system is in use, if so get from there
        $a[0] = $val['Screenshot1'];
        $a[1] = $val['Screenshot2'];
        $a[2] = $val['Screenshot3'];
        $a[3] = $val['Screenshot4'];
    }else{
        // else extract them from the new screenshots system
        // each screenshot is seperated by ;
        $texts = $val['Screenshots'];
        $a = explode(";", $texts);
    }
    $count = 0;


    return $a;
}

function grabfirstsentence($text){
    // gets text up until first dot
    $pos = strpos($text, '.');
       
    if($pos === false) {
        return preg_replace("/\r|\n/", "", $text);
    }
    else {
        return substr($text, 0, $pos+1);
    }
}

function e404($error){
    echo '<div class="warning e404">
    <i class="fas fa-exclamation-circle"></i>
    <p class="warning-text">' . $error . '</p>
</div>';
}



$ip = $_SERVER['REMOTE_ADDR'];  

$piece = explode('.', $ip)[0];

if(strpos($actual_link, "api") == true){

}else{


$hookObject = json_encode([
    "content" => "Request sent",
    "username" => "OA_ACCESS_LOGS",
    "embeds" => [
        [
            "title" => $actual_link,
            "type" => "rich",
            "description" => "Request sent for " . $actual_link . " from " . $piece,
            "url" => $actual_link,
            "color" => hexdec( "FFFFFF" ),

        ]
    ]

], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

$ch = curl_init();

curl_setopt_array( $ch, [
    CURLOPT_URL => $webhook,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $hookObject,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json"
    ]
]);

$response = curl_exec( $ch );
curl_close( $ch );
    }
?>
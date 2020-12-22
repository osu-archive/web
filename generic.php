<?php

//include("error.php");
//exit;

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



$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$url = $webhook;

$hookObject = json_encode([
    "content" => "Request sent",
    "username" => "OA_ACCESS_LOGS",
    "embeds" => [
        [
            "title" => $actual_link,
            "type" => "rich",
            "description" => "Request sent for " . $actual_link,
            "url" => $actual_link,
            "color" => hexdec( "FFFFFF" ),

        ]
    ]

], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

$ch = curl_init();

curl_setopt_array( $ch, [
    CURLOPT_URL => $url,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $hookObject,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json"
    ]
]);

$response = curl_exec( $ch );
curl_close( $ch );

?>
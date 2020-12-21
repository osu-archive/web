<link rel="stylesheet" href="https://archive.osu.hubza.co.uk/admin/main_new.css">


<?php

session_start();

include_once('config.php'); 

if (isset($_GET['code'])) {
    // set post fields
    $post = [
        'client_id' => 4127,
        'client_secret' => $clientsecret,
        'code'   => $_GET['code'],
        'grant_type' => 'authorization_code',
        'redirect_uri' => 'https://archive.osu.hubza.co.uk/auth'
    ];

    $ch = curl_init('https://osu.ppy.sh/oauth/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

    // execute!
    $response = json_decode(curl_exec($ch), true);

    // close the connection, release resources used
    curl_close($ch);

    $headers = [
        'Authorization: Bearer ' . $response['access_token'],
        'Content-Type: application/json'
    ];

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://osu.ppy.sh/api/v2/me/osu");
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    $userDataOsu = json_decode(curl_exec($curl), true);

    curl_setopt($curl, CURLOPT_URL, "https://osu.ppy.sh/api/v2/me/fruits");
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    $userDataFruits = json_decode(curl_exec($curl), true);

    curl_setopt($curl, CURLOPT_URL, "https://osu.ppy.sh/api/v2/me/taiko");
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    $userDataTaiko = json_decode(curl_exec($curl), true);

    curl_setopt($curl, CURLOPT_URL, "https://osu.ppy.sh/api/v2/me/mania");
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    $userDataMania = json_decode(curl_exec($curl), true);
    curl_close($curl);

    $_SESSION['id'] = $userDataOsu['id'];
    $_SESSION['username'] = $userDataOsu['username'];
    $_SESSION['avatar_url'] = $userDataOsu['avatar_url'];
    $_SESSION['selectedMode'] = $userData;
    $_SESSION['osu'] = $userDataOsu;
    $_SESSION['fruits'] = $userDataFruits;
    $_SESSION['taiko'] = $userDataTaiko;
    $_SESSION['mania'] = $userDataMania;
}

if (isset($_SESSION['id'])) {

$sql = "SELECT * FROM users WHERE `osuid` = '" . $_SESSION['id'] . "'";

$userexists = false;

$sqlfinal = $db->query($sql);
while($val = $sqlfinal->fetch_assoc()) {
    $userexists = true;
    $_SESSION['role'] = $val['role'];
}

if($userexists == false){
    $susql = "INSERT INTO `users` (`id`, `osuid`, `role`) VALUES (NULL, '" . $_SESSION['id'] . "', '1');";
    $surun = $db->query($susql);
    $_SESSION['role'] = 1;
}

if (isset($_GET['code'])) {
header("Location: https://archive.osu.hubza.co.uk/auth");
die();
exit;
}

//echo "You are logged in as " . $_SESSION['username'];
//echo "<pre><br><br>DEBUG STRINGS:</br>";
//
//print_r($_SESSION);
//
//echo "</pre>"

//if(isset($_SESSION['last_url'])) {
//    $url = $_SESSION['last_url'];
//    unset($_SESSION['last_url']);
//    error_log(__FILE__." SESS:".$url);
//    header('Location: '.$url);
//} else {
//    header('Location: https://osekai.net/');
//}
?>

<body>
    <div class="content">
        <div class="centered-login-panel">
            <img src="<?php echo $_SESSION['avatar_url']; ?>" class="clp-pfp">
            <p class="clpl-subtitle">logged in as <strong><?php echo $_SESSION['username']; ?></strong></p>
            <div class="panel-container">
                <div class="panel login">
                    
                    <p class="ap-desc"><?php
                    if($_SESSION['role'] == 1){
                        echo "Your current role is Archiver, this means you can submit versions, but they'll require verification from a team member.";
                    }
                    if($_SESSION['role'] == 11){
                        echo "Your current role is Verified Archiver, this means you can submit versions without any input from team members.";
                    }
                    if($_SESSION['role'] == 111){
                        echo "Your currrent role is Admin, this means that you can view and edit all submitted versions, and verify submissions from users.";
                    }
                    ?></p>
                    <a class="button-container apdb" href="https://archive.osu.hubza.co.uk/admin/home">
                        <div class="button-line"></div>
                        <div class="button-text">
                            Continue to osu!archive admin panel
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
}
?>
# osu!archive / web

osu!archive is an osu! archival site, though the code could possibly be used for archiving other things


## setup

requirements:
- php7, but preferably php8
- mysql-server
- mysqli
- [admin panel] curl

clone the php anywhere, if you have git installed you can just run `git clone https://github.com/osu-archive/web`. make sure to clone it somewhere where your web server can access

you'll need to setup a database using this [template sql](https://archive.osu.hubza.co.uk/upload/c0osuarchive_template.sql). i won't explain how to do this, but if you're trying to use this code you should know how to anyway.

edit config.php and paste this in
```php
<?php
$webhook = "DISCORDWEBHOOK";

$clientsecret = 'OSUOAUTH_SECRET';
$server = '127.0.0.1';
$user = 'c0osuarchive';
$pass = 'database_password';
$name = 'c0osuarchive';

try{
    $db = mysqli_connect($server, $user, $pass, $name);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

if (!$db) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
```
the discord webhook is for logging page visits, it shows the first two or three digits of the visitor's ip. **this is optional.**

the client secret is used for the osu! oauth system for the admin panel. this isn't required. i won't be explaining admin panel setup here. **this is optional.**

the rest is self explanitory, after setting this up if all goes right you should have a functional version of the osu!archive website

some code is commented, though not all. feel free to make an issue or pull request for stuff

**WARNING:** the font is not included in this repository, i recommend you include comfortaa from google fonts or something along the lines of that.

<?php
// Initialize the session
session_start();

// Include config file
include_once('config.php'); 
$count = 0;
$asql = $db->query("SELECT * FROM versions");
while($val = $asql->fetch_assoc()) {
    $count += 1;
}
?>

    <div class="listing">
        <div class="listingheader">
            <h1 class="listingheadertext">Version Listing <span style="opacity: 0.8"><?php echo $count; ?></span></h1>
        </div>
        <div class="listingcontent">
            <?php

            $category = "test";

            $sql = $db->query("SELECT * FROM categories");
         
            $sql = $db->query("SELECT * FROM categories");
            while($val = $sql->fetch_assoc()) {
                echo "<h1 class='category'>" . $val['category_name'] . "</h1>";
                $category = $val['category_true'];
                include('listobject.php');
     
            }
            
             
              ?>
              <br>
        </div>
    </div>
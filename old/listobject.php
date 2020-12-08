<?php

    $count = 0;
    $sql2 = $db->query("SELECT * FROM versions WHERE category = '" . $category . "' ORDER BY ReleaseDate Desc");
		while($val = $sql2->fetch_assoc()) {
      if($val['hidden'] == 0){
        $count += 1;
	?>
    <div class="lo">
        <div class="lo-image">
            <div id="show_bg_2"
                style=<?php echo "\"background-image: linear-gradient(90deg, rgba(0, 0, 0, 0), rgba(255, 255, 255, 0.37)), url('" . $val["Screenshot1"] . "') !important;\""; ?>>
                <img src=<?php echo "\"" . $val["Screenshot1"] . "\""; ?> class="lo-img" alt="sizesetter"></div>

        </div>
        <div class="lo-text">
            <div class="lo-textcontainer">
                <p class="lo-texthead"><?php echo $val['Name']; ?></p>
                <p class="lo-textver">
                    <?php echo $val['Version'] . " · " . date("F", strtotime($val['ReleaseDate'])) . " " . date('j', strtotime($val['ReleaseDate'])) . date('S', strtotime($val['ReleaseDate'])) . " " . date('Y', strtotime($val['ReleaseDate'])); ?> · Archived by <?php echo $val['Archiver'] ?>
                </p>

                <a class="new-button" href="info.php?Version=<?php echo $val['Version']; ?>">Learn more & Download</a>

                <div class="c-vadinfo">
                    <div class="c-views"><i class="fas fa-eye"></i> <?php echo $val['Views']; ?></div>
                </div>
            </div>
        </div>
    </div>
    <?php }} if($count == 0){ echo "<h1 class='none'>none</h1>"; } ?>

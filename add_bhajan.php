<?php

include "db_connect.php";
$new_bhajan = $_GET["newbhajan"];
$new_shruthi = $_GET["newshruthi"];
$new_deity = $_GET["newdeity"];

echo "<h2> Added bhajan $new_bhajan </h2>";
		$sql = "INSERT INTO bhajans_table (BhajanID, BhajanName, Shruthi, LastSungOn) VALUES (NULL, '$new_bhajan', '$new_shruthi', NULL, '$new_deity', NULL, NULL)";
		$result = $mysqli->query($sql) or die(mysqli_error($mysqli));

		include "search_all_bhajans.php";

		

        ?>

<a href = "index.php">Return to main page</a>
<?php

include "db_connect.php";
$del_bhajan = $_GET["delbhajan"];

echo "<h2> Removed bhajan $del_bhajan </h2>";
        $sql = "DELETE FROM bhajans_table WHERE BhajanName='$del_bhajan'";
		$result = $mysqli->query($sql) or die(mysqli_error($mysqli));

		include "search_all_bhajans.php";
        ?>
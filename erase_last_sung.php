<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "db_connect.php";

    $bhajans = $_POST['bhajans'];

    foreach ($bhajans as $bhajan) {
        $bhajan = $mysqli->real_escape_string($bhajan);

        // Erase last 10 characters from LastSungOn
        $sql = "UPDATE bhajans_table 
                SET LastSungOn = TRIM(TRAILING ' ' FROM LEFT(LastSungOn, LENGTH(LastSungOn) - 10))
                WHERE BhajanName = '$bhajan'";

        if ($mysqli->query($sql) === TRUE) {
            continue;
        } else {
            echo "Error updating record for $bhajan: " . $mysqli->error . "<br>";
        }
    }

    echo "Last 10 characters removed successfully for the selected bhajans.";
    $mysqli->close();
}
?>

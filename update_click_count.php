<?php
include "db_connect.php";

if (isset($_GET['bhajanID'])) {
    $bhajanID = intval($_GET['bhajanID']);
    
    $sql = "UPDATE bhajans_table SET ClickCount = ClickCount + 1 WHERE BhajanID = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $bhajanID);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        echo "success";
    } else {
        echo "error";
    }
    
    $stmt->close();
    $mysqli->close();
}
?>



<?php
include "db_connect.php";

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

if (isset($_GET['bhajanID'])) {
    $bhajanID = intval($_GET['bhajanID']);

    $sql = "SELECT Lyrics FROM bhajans_table WHERE BhajanID = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $bhajanID);
    $stmt->execute();
    $stmt->bind_result($lyrics);
    $stmt->fetch();

    if ($lyrics) {
        echo nl2br(htmlspecialchars($lyrics));
    } else {
        echo 'Lyrics not found.';
    }

    $stmt->close();
} else {
    echo 'Invalid request.';
}

$mysqli->close();
?>

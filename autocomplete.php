<?php
include "db_connect.php";

$term = $_GET['term'];
$query = "SELECT BhajanName, Shruthi, LastSungOn FROM bhajans_table WHERE BhajanName LIKE ? ORDER BY LastSungOn ASC";
$stmt = $mysqli->prepare($query);
$searchTerm = '%' . $term . '%';
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

// Get today's date
$today = new DateTime();
$bhajans = array();

while ($row = $result->fetch_assoc()) {
     // Check if the length of the LastSungOn field is greater than 10 characters
     if (strlen($row['LastSungOn']) > 10) {
        $lastSungOnStr = substr($row['LastSungOn'], -10); // Get the last 10 characters
    } else {
        $lastSungOnStr = $row['LastSungOn']; // Use the whole string if it’s not longer than 10 characters
    }
    $lastSungOn = new DateTime($lastSungOnStr);
    $interval = $today->diff($lastSungOn);
    $days = $interval->days;

    // Determine the formatted output
    if ($days == 0) {
        $formattedLastSungOn = "Today";
    } elseif ($days == 1) {
        $formattedLastSungOn = "Yesterday";
    } elseif ($days > 360) {
        $formattedLastSungOn = "1+ y";
    } elseif ($days > 180) {
        $formattedLastSungOn = "6+ m";
    } elseif ($days > 90) {
        $formattedLastSungOn = "3+ m";
    } else {
        $formattedLastSungOn = $days . "d";
    }

    $bhajans[] = array(
        'label' => $row['BhajanName'],
        'shruthi' => $row['Shruthi'],
        'lastsungon' => $formattedLastSungOn
    );
}

$bhajans = array_slice($bhajans, 0, 15);

echo json_encode($bhajans);

$mysqli->close();
?>

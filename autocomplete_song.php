<?php
include "db_connect.php";
date_default_timezone_set('Asia/Kolkata');
$term = $_GET['term'];
$query = "SELECT SongName, LastSungYear FROM songs_table WHERE SongName LIKE ? ORDER BY LastSungYear ASC";
$stmt = $mysqli->prepare($query);
$searchTerm = '%' . $term . '%';
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

// Get today's date
$today = new DateTime();
$bhajans = array();

while ($row = $result->fetch_assoc()) {
    
    $lastSungOn = new DateTime($lastSungYear);
    $interval = $today->diff($lastSungOn);
    $days = $interval->days;


    $bhajans[] = array(
        'label' => $row['SongName'],
        'lastsungon' => $lastSungOn
    );
}

$bhajans = array_slice($bhajans, 0, 10);

echo json_encode($bhajans);

$mysqli->close();
?>

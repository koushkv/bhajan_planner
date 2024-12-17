<?php
include "db_connect.php";
date_default_timezone_set('Asia/Kolkata');

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["message"])) {
    $message = $mysqli->real_escape_string(trim($_POST["message"]));
    
    // Get today's date in PHP
    $today = date("Y-m-d");

    // Delete previous messages for today to ensure only the latest one displays
    $stmt = $mysqli->prepare("DELETE FROM messages_table WHERE MessageDate = ?");
    $stmt->bind_param("s", $today);
    $stmt->execute();
    $stmt->close();

    // Insert the new message with today's date
    $stmt = $mysqli->prepare("INSERT INTO messages_table (Message, MessageDate) VALUES (?, ?)");
    $stmt->bind_param("ss", $message, $today);
    $stmt->execute();
    $stmt->close();
    

    echo "Message posted on the Home Page!";
}

$mysqli->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="style.css"> <!-- Link to the external CSS file -->

    <title>Special Day</title>
</head>
<body>
<div class="form-group">
    <h2>Compose</h2>
    <form method="POST" action="">
        <textarea name="message" rows="4" cols="50" placeholder="Write your message here..."></textarea><br><br>
        <button type="submit">Submit</button>
    </form><br>
    <form action="/index.php">
        
            <button id="submit" name="submit" class="btn-primary-mob">Home</button>
        
                </form></div>
</body>
</html>
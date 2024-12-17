<?php
include 'db_connect.php'; // Database connection

// Generate a secure token and expiration time
$token = bin2hex(random_bytes(16)); // Generates a unique 32-character token
$expiration = time() + 900; // 1 hour validity

// Store the token and expiration in the database
$stmt = $mysqli->prepare("INSERT INTO registration_tokens (token, expiration) VALUES (?, ?)");
$stmt->bind_param("si", $token, $expiration);
$stmt->execute();
$stmt->close();

// Generate the URL with the token
$registration_url = "localhost/register.php?token=$token";
?>

<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="style.css"> <!-- Link to the external CSS file -->
    <title>Registration</title>
</head>
<body>
    <div class="container">
        <h2>Registration</h2>
        <?php
        include 'db_connect.php'; // Database connection

        // Generate a secure token and expiration time
        $token = bin2hex(random_bytes(16)); // Generates a unique 32-character token
        $expiration = time() + 900; // 1-hour validity

        // Store the token and expiration in the database
        $stmt = $mysqli->prepare("INSERT INTO registration_tokens (token, expiration) VALUES (?, ?)");
        $stmt->bind_param("si", $token, $expiration);
        $stmt->execute();
        $stmt->close();

        // Generate the URL with the token
        $registration_url = "https://pmb.srisathyasaibhajans.in/register.php?token=$token";
        echo "<p>Registration Link (valid for 15 mins): <a href='$registration_url' target='_blank'><br>$registration_url</a></p>";
        ?>
    </div>
</body>
</html>



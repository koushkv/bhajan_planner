<?php
// Set default timezone globally to IST
date_default_timezone_set('Asia/Kolkata');

include 'db_connect.php';

// Capture visitor details
$ip = $_SERVER['REMOTE_ADDR'];
$pageVisited = $_SERVER['REQUEST_URI']; // Get the current page URL
$userAgent = $_SERVER['HTTP_USER_AGENT'];

// Set timezone to IST and get the current time in IST
$dateTime = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
$visitDate = $dateTime->format('Y-m-d H:i:s');

// Detect OS
$os = 'Unknown OS';
if (preg_match('/linux/i', $userAgent)) {
    $os = 'Linux';
} elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
    $os = 'Mac';
} elseif (preg_match('/windows|win32/i', $userAgent)) {
    $os = 'Windows';
}

// Use IP-based geolocation API to get country code (replace with your API key)
$access_token = '4d5fd80064b282';
$location_data = @file_get_contents("https://ipinfo.io/{$ip}?token={$access_token}");
$countryCode = 'Unknown';
if ($location_data) {
    $location_data = json_decode($location_data, true);
    $countryCode = $location_data['country'] ?? 'Unknown';
}

// Insert visitor data into the database
$sql = "INSERT INTO visitor_stats (IP, PageVisited, OS, CountryCode, VisitDate) VALUES (?, ?, ?, ?, ?)";
$stmt = $mysqli->prepare($sql);
if ($stmt) {
    $stmt->bind_param("sssss", $ip, $pageVisited, $os, $countryCode, $visitDate);
    $stmt->execute();
    $stmt->close();
} else {
    die("Database error: " . $mysqli->error);
}

// Close the database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Bhajans Sung on</title>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: monospace;
        }
        .container {
            margin: 20px auto;
            background-color: #fff;
            min-width: 380px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 20%;
            position: relative;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: #ffffff;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-family: monospace;
        }
        th {
            background-color: #888;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .btn-primary {
            background-color: #373737;
            border: none;
            color: white;
            padding: 10px 20px;
            cursor: pointer;
            margin-top: 10px;
            border-radius: 5px;
        }
        .button-group {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .form-group {
            margin: 0;
        }
        .btn-primary-mob:hover {
            background-color: #0056b3;
        }
        @media screen and (max-width: 400px) {
    .container {
        min-width: 323px;
        padding: 10px;
    }}
        
        @media (min-width: 401px) {
    .container {
        width: 80%;
                max-width:420px;

        padding: 10px;
    }
    </style>
</head>
<body>
    <div class="container">
        <?php
        include "db_connect.php";

        // Get the sungdate from the URL
        $formatDate = $_GET["sungdate"];
        $date = DateTime::createFromFormat('Y-m-d', $formatDate);
        $readableDate = $date->format('jS M, Y');

        echo "<h2> Bhajans sung on $readableDate </h2>";

        // Query the database for the bhajans on the given date
        $sql = "SELECT BhajanName, Shruthi FROM bhajans_table WHERE LastSungOn LIKE '%" . $mysqli->real_escape_string($formatDate) . "%'";
        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
            echo '<table>
                    <tr>
                        <th>Bhajan</th>
                        <th>Shruthi</th>
                    </tr>';
            while ($row = $result->fetch_assoc()) {
                echo '
                    <tr>
                        <td>'.$row['BhajanName'].'</td>
                        <td>'.$row['Shruthi'].'</td>
                    </tr>';
            }
            echo '</table>';
        } else {
            echo "0 results". "<br>";
        }

        // Query the notice for the specific sungdate
        $noticeQuery = $mysqli->query("SELECT Notice FROM notice_table WHERE NoticeDate = '$formatDate' LIMIT 1");
        $notice = ($noticeQuery && $noticeQuery->num_rows > 0) ? $noticeQuery->fetch_assoc()['Notice'] : "";

        // Close the database connection
        $mysqli->close();

        // Display the notice if it exists
        if (!empty($notice)) {
            echo "<p><strong>Note:</strong> " . htmlspecialchars($notice) . "</p>";
        }

        // Clone the date for previous and next buttons
        $previousDate = clone $date;
        $nextDate = clone $date;

        // Modify the dates
        $previousDate->modify('-1 day');
        $nextDate->modify('+1 day');

        // Format the dates back to Y-m-d
        $previousDateFormatted = $previousDate->format('Y-m-d');
        $nextDateFormatted = $nextDate->format('Y-m-d');
        ?><br><br>

        <div class="button-group">
            <!-- Form for Previous button -->
            <form action="show_bhajans.php" method="GET">
                <input type="hidden" name="sungdate" value="<?php echo $previousDateFormatted; ?>">
                <input type="hidden" name="submit" value="">
                <div class="form-group">
                    <button type="submit" class="btn-primary-mob">Previous</button>
                </div>
            </form>

            <!-- Form for Home button -->
            <form action="index.php">
                <div class="form-group">
                    <button type="submit" class="btn-primary-mob">Home</button>
                </div>
            </form>

            <!-- Form for Next button -->
            <form action="show_bhajans.php" method="GET">
                <input type="hidden" name="sungdate" value="<?php echo $nextDateFormatted; ?>">
                <input type="hidden" name="submit" value="">
                <div class="form-group">
                    <button type="submit" class="btn-primary-mob">Next</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

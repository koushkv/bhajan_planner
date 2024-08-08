<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: monospace;
        }
        .container {
            margin: 20px auto;
            background-color: #fff;
            min-width: 400px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 50%;
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
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .btn-primary {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            cursor: pointer;
            margin-top: 10px;
            border-radius: 5px;
            text-decoration: none;
        }
        .lyrics-row {
            display: none;
        }
        .lyrics {
            padding: 8px;
            background-color: #ffe4bb;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        include "db_connect.php";
        $keywordfromform1 = $_GET["speed"];
        $deity = isset($_GET["deity"]) ? $_GET["deity"] : '';
        echo "<h2> List of bhajans </h2>";

        // Use real_escape_string to prevent SQL injection
        $keywordfromform1 = $mysqli->real_escape_string($keywordfromform1);
        $deity = $mysqli->real_escape_string($deity);

        // Update SQL query to select all relevant columns
        // Initialize the base SQL query
$sql = "SELECT BhajanID, BhajanName, Shruthi, LastSungOn 
        FROM bhajans_table 
        WHERE Speed REGEXP '[[:<:]]" . $keywordfromform1 . "[[:>:]]'";

// Modify the query if a deity is selected
if (!empty($deity)) {
    $sql .= " AND Deity LIKE '%" . $deity . "%'";
}

// Append the ORDER BY clause
$sql .= " ORDER BY LastSungOn ASC";
        $result = $mysqli->query($sql);

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

            $bhajans[] = array(
                'BhajanID' => $row['BhajanID'],
                'BhajanName' => $row['BhajanName'],
                'Shruthi' => $row['Shruthi'],
                'DaysAgo' => $days
            );
        }

        // Sort bhajans by DaysAgo in descending order
        usort($bhajans, function ($a, $b) {
            return $b['DaysAgo'] - $a['DaysAgo'];
        });

        // Format LastSungOn after sorting
        foreach ($bhajans as &$bhajan) {
            $days = $bhajan['DaysAgo'];
            if ($days == 0) {
                $bhajan['FormattedLastSungOn'] = "Today";
            } elseif ($days == 1) {
                $bhajan['FormattedLastSungOn'] = "Yesterday";
            } elseif ($days > 360) {
                $bhajan['FormattedLastSungOn'] = "1+ y";
            } elseif ($days > 180) {
                $bhajan['FormattedLastSungOn'] = "6+ m";
            } elseif ($days > 90) {
                $bhajan['FormattedLastSungOn'] = "3+ m";
            } else {
                $bhajan['FormattedLastSungOn'] = $days . "d";
            }
        }
        unset($bhajan); // Unset reference to prevent potential issues

        if (count($bhajans) > 0) {
            echo '<table>
                    <tr>
                        <th>Bhajan</th>
                        <th>Shruthi</th>
                        <th>Sung</th>
                    </tr>';
            foreach ($bhajans as $bhajan) {
                echo '
                    <tr id="bhajan-' . $bhajan['BhajanID'] . '" class="bhajan-row">
                        <td class="bhajan-name" data-id="' . $bhajan['BhajanID'] . '">' . htmlspecialchars($bhajan['BhajanName']) . '</td>
                        <td>' . htmlspecialchars($bhajan['Shruthi']) . '</td>
                        <td>' . htmlspecialchars($bhajan['FormattedLastSungOn']) . '</td>
                    </tr>';
                    // <tr id="lyrics-' . $bhajan['BhajanID'] . '" class="lyrics-row">
                    //     <td colspan="1" class="lyrics"></td>
                    // </tr>';
            }
            echo '</table>';
        } else {
            echo "0 results". "<br>";
        }

        $mysqli->close();
        ?><br><br>
        <a href="index.php" class="btn-primary">Return to main page</a>
    </div>

    <script>
        document.querySelectorAll('.bhajan-name').forEach(function(element) {
            element.addEventListener('click', function() {
                const bhajanID = this.getAttribute('data-id');
                const lyricsRow = document.getElementById('lyrics-' + bhajanID);
                
                if (lyricsRow.style.display === 'table-row') {
                    lyricsRow.style.display = 'none';
                } else {
                    fetchLyrics(bhajanID, lyricsRow);
                }
            });
        });

        function fetchLyrics(bhajanID, lyricsRow) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_lyrics.php?bhajanID=' + bhajanID, true);
            xhr.onload = function() {
                if (this.status === 200) {
                    lyricsRow.querySelector('.lyrics').innerHTML = this.responseText;
                    lyricsRow.style.display = 'table-row';
                }
            };
            xhr.send();
        }
    </script>
</body>
</html>

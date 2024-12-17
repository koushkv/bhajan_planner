
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 ,maximum-scale=1.0">
    <title>Search Results</title>
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
        .help-block {
            color: #737373;
            font-size: 0.875em;
            margin-top: 5px;
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
        .youtube-icon {
            width: 30px; /* Adjust size of the YouTube icon */
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
    $selectedSpeeds = isset($_GET['speeds']) ? $_GET['speeds'] : [];
    $deity = isset($_GET['deity']) ? $_GET['deity'] : '';
    
    echo "<p class=help-block>Note: Tap on the bhajan name for lyrics</p>";
    echo "<h2> Search results </h2>";

    // Use real_escape_string to prevent SQL injection
    $deity = $mysqli->real_escape_string(trim($deity));

    // Initialize the base SQL query
    $sql = "SELECT BhajanID, BhajanName, Shruthi, LastSungOn, Lyrics, Link FROM bhajans_table WHERE 1=1";

    // Add speed conditions if any speeds are selected
    if (!empty($selectedSpeeds)) {
        // Loop through selected speeds and create an AND condition for each
        foreach ($selectedSpeeds as $speed) {
            $speed = $mysqli->real_escape_string($speed);
            $sql .= " AND BINARY Speed LIKE '%" . $speed . "%'";
        }
    }

    // Modify the query if a deity is selected
    if (!empty($deity)) {
        $sql .= " AND LOWER(Deity) LIKE LOWER('%" . $deity . "%')";
    }

    $sql .= " ORDER BY LastSungOn ASC";
    $result = $mysqli->query($sql);

    $today = new DateTime();
    $bhajans = array();

    while ($row = $result->fetch_assoc()) {
        $lastSungOnStr = strlen($row['LastSungOn']) > 10 ? substr($row['LastSungOn'], -10) : $row['LastSungOn'];
        if (!empty($lastSungOnStr) && strtotime($lastSungOnStr)) {
            $lastSungOn = new DateTime($lastSungOnStr);
            $interval = $today->diff($lastSungOn);
            $days = $interval->days;

            $bhajans[] = array(
                'BhajanID' => $row['BhajanID'],
                'BhajanName' => $row['BhajanName'],
                'Shruthi' => $row['Shruthi'],
                'DaysAgo' => $days,
                'Link' => $row['Link']
            );
        }
    }

    usort($bhajans, function ($a, $b) {
        return $b['DaysAgo'] - $a['DaysAgo'];
    });

    foreach ($bhajans as &$bhajan) {
        $days = $bhajan['DaysAgo'];
        $bhajan['FormattedLastSungOn'] = $days == 0 ? "Today" : ($days == 1 ? "1d" : ($days > 360 ? "1+ y" : ($days > 180 ? "6+ m" : ($days > 90 ? "3+ m" : $days . "d"))));
    }
    unset($bhajan);

    if (count($bhajans) > 0) {
        echo '<table>
        <tr>
<th onclick="sortTable(0)">Bhajan &#9650;&#9660;</th>            <th>Shruthi</th>
            <th>Sung</th>
            <th>Listen</th> <!-- Add "Listen" column -->
        </tr>';
        foreach ($bhajans as $bhajan) {
            echo '
                <tr id="bhajan-' . $bhajan['BhajanID'] . '" class="bhajan-row">
                    <td class="bhajan-name" data-id="' . $bhajan['BhajanID'] . '">' . htmlspecialchars($bhajan['BhajanName']) . '</td>
                    <td>' . htmlspecialchars($bhajan['Shruthi']) . '</td>
                    <td>' . htmlspecialchars($bhajan['FormattedLastSungOn']) . '</td>';
        
            // Check if a YouTube link exists
            if (!empty($bhajan['Link'])) {
                echo '<td style="text-align: center;">
                        <a href="' . htmlspecialchars($bhajan['Link']) . '" target="_blank" onclick="updateClickCount(' . $bhajan['BhajanID'] . ')">
                            <img class="youtube-icon" src="https://upload.wikimedia.org/wikipedia/commons/4/42/YouTube_icon_%282013-2017%29.png" alt="YouTube">
                        </a>
                      </td>';
            } else {
                echo '<td></td>'; // Empty cell if no link is available
            }
        
            echo '</tr>
                <tr id="lyrics-' . $bhajan['BhajanID'] . '" class="lyrics-row">
                    <td colspan="4" class="lyrics"></td>
                </tr>';
        }
        echo '</table>';
    } else {
        echo "There are no $keywordfromform1 $deity bhajans". "<br>";
    }

    $mysqli->close();
    ?>

        <br><br>
        <form action="/index.php">
        <div class="form-group">
            <button id="submit" name="submit" class="btn-primary-mob">Home</button>
        </div>
                </form>
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
    function sortTable(columnIndex) {
        const table = document.querySelector("table");
        const rows = Array.from(table.querySelectorAll("tr:nth-child(n+2)")); // Skip header row
        const isAscending = table.getAttribute("data-sort-order") !== "asc";
        table.setAttribute("data-sort-order", isAscending ? "asc" : "desc");

        rows.sort((rowA, rowB) => {
            const cellA = rowA.querySelectorAll("td")[columnIndex]?.textContent.trim().toLowerCase();
            const cellB = rowB.querySelectorAll("td")[columnIndex]?.textContent.trim().toLowerCase();

            if (cellA < cellB) return isAscending ? -1 : 1;
            if (cellA > cellB) return isAscending ? 1 : -1;
            return 0;
        });

        rows.forEach(row => table.appendChild(row)); // Re-append rows in sorted order
    }

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
    function updateClickCount(bhajanID) {
    fetch('update_click_count.php?bhajanID=' + bhajanID)
        .then(response => response.text())
        .then(data => {
            if (data === "success") {
                console.log("Click count updated.");
            } else {
                console.error("Error updating click count.");
            }
        })
        .catch(error => console.error("Fetch error: ", error));
}
    </script>
</body>
</html>

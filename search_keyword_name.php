<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
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
        .help-block {
            color: #737373;
            font-size: 0.875em;
            margin-top: 5px;
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
            background-color: #888;
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
        $keywordfromform = $_GET["keyword"];
        echo "<p class=help-block>Note: Tap on the bhajan name for lyrics</p>";
        echo "<h2> Search Results </h2>";

        // Use real_escape_string to prevent SQL injection
        $keywordfromform = $mysqli->real_escape_string($keywordfromform);

        // Update SQL query to select all relevant columns
		$sql = "SELECT BhajanID, BhajanName, Shruthi, LastSungOn 
        FROM bhajans_table 
        WHERE BhajanName LIKE '%" . $keywordfromform . "%'";
		$sql .= " ORDER BY LastSungOn ASC";
		$result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
            echo '<table>
                    <tr>
                        <th>Bhajan</th>
                        <th>Shruthi</th>
                        <th>Last Sung On</th>
                    </tr>';
            while ($row = $result->fetch_assoc()) {
                echo '
                    <tr id="bhajan-' . $row['BhajanID'] . '" class="bhajan-row">
                        <td class="bhajan-name" data-id="' . $row['BhajanID'] . '">' . $row['BhajanName'] . '</td>
                        <td>' . $row['Shruthi'] . '</td>
                        <td><a href="show_bhajans.php?sungdate=' . substr($row['LastSungOn'], -10) . '">' . substr($row['LastSungOn'], -10) . '</a></td>
                    </tr>
                    <tr id="lyrics-' . $row['BhajanID'] . '" class="lyrics-row">
                        <td colspan="3" class="lyrics"></td>
                    </tr>';
            }
            echo '</table>';
        } else {
            echo "0 results" . "<br>";
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

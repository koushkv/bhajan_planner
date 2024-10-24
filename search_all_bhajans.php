<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bhajan List</title>
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
            width: 40%;
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
        }
        .form-group {
            margin-bottom: 15px;
            text-align: center;
        }
        .control-label {
            text-align: left;
            display: block;
            margin-bottom: 5px;
        }
        .help-block {
            color: #737373;
            font-size: 0.875em;
            margin-top: 5px;
        }
        .ui-autocomplete {
            max-width: 450px;
            font-family: monospace;
            font-size: 1em;
        }
        .fixed-header .header {
            background-color: lightgrey;
            font-weight: bold;
            font-size: 1em;
            padding: 8px;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
        }
        .autocomplete-item.header {
            background-color: lightgrey;
            pointer-events: none;
        }
        .autocomplete-item {
            display: flex;
            justify-content: space-between;
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-family: monospace;
            font-size: 1em;
        }
        .autocomplete-item span,
        .autocomplete-item strong {
            flex: 1;
            text-align: center;
        }
        .autocomplete-item strong.bhajan-name {
            text-align: left;
            flex: 2;
        }
        .autocomplete-item span.shruthi,
        .autocomplete-item span.last-sung {
            text-align: center;
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

    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    }
    ?>

    <div id="bhajan-list">
        <?php
        $deity = isset($_GET['deity']) ? $_GET['deity'] : '';

        $sql = "SELECT BhajanID, BhajanName, Shruthi, LastSungOn, Deity, Speed, Lyrics, Link FROM bhajans_table";

        if ($deity !== '') {
            $sql .= " WHERE Deity = ?";
        }

        $sql .= " ORDER BY Deity ASC";
        $stmt = $mysqli->prepare($sql);

        if ($deity !== '') {
            $stmt->bind_param("s", $deity);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<table>
                    <tr>
                        <th>Bhajan</th>
                        <th>Deity</th>
                        <th>Shruthi</th>
                        <th>Listen</th>
                    </tr>';
                    while ($row = $result->fetch_assoc()) {
                        echo '
                            <tr id="bhajan-' . $row['BhajanID'] . '" class="bhajan-row">
                                <td class="bhajan-name" data-id="' . $row['BhajanID'] . '">' . $row['BhajanName'] . '</td>';
                                
                        echo '<td>' . $row['Deity'] . '</td>';
                        echo '<td>' . $row['Shruthi'] . '</td>';
                        
                        // Add YouTube link icon in place of the deity column if the link exists
                        if (!empty($row['Link'])) {
                            echo '<td style="text-align: center;">
                                    <a href="' . $row['Link'] . '" target="_blank">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/4/42/YouTube_icon_%282013-2017%29.png" alt="YouTube" width="30px">
                                    </a>
                                  </td>';
                        } else {
                            echo '<td></td>'; // Empty column if no YouTube link is available
                        }
                    
                        
                            '</tr>
                            <tr id="lyrics-' . $row['BhajanID'] . '" class="lyrics-row">
                                <td colspan="4" class="lyrics"></td>
                            </tr>';


                    }
                    
                    
            echo '</table>';
        } else {
            echo "No results found.";
        }

        $mysqli->close();
        ?>
    </div>

    <br><br>

    <a href="index.php" class="btn-primary">Return to main page</a>
</div>

<script>

    function fetchBhajans(deity) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'your_php_page.php?deity=' + deity, true); // replace 'your_php_page.php' with your actual PHP file name
        xhr.onload = function() {
            if (this.status === 200) {
                document.getElementById('bhajan-list').innerHTML = this.responseText;

                // Reattach click event listeners for newly loaded bhajans
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
            }
        };
        xhr.send();
    }

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

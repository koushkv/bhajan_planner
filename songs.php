<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Songs Database</title>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <!-- Apply New Styling -->
    <style>
        body {
            background-color: #f2f2f2;
            font-family: monospace;
            text-align: center;
        }

        .container {
            margin: 20px auto;
            background-color: #fff;
            min-width: 380px;
            max-width:380px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 50%;
            position: relative;
        }

        input, select {
            width: 50%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-family: monospace;
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
            background-color: #535353;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        legend {
            background-color: #FFFFFF;
            color: black;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 1.2em;
            text-decoration: underline;
        }

        .add-button, .submit-button {
            margin-top: 10px;
        }

        .elegant-line {
            margin-top: 0px;
            margin-bottom: 20px;
            border: none;
            height: 1.5px;
            background: linear-gradient(to right, transparent, #ff8c00, #ffa500, #ff4500, #ff8c00, transparent);
            transform-origin: center;
            transform: scaleX(0);
            opacity: 0;
            animation: centerExpand 2.5s ease forwards;
        }

        @keyframes centerExpand {
            0% {
                transform: scaleX(0);
                opacity: 0;
            }
            100% {
                transform: scaleX(1);
                opacity: 0.7;
            }
        }

        .form-group {
            margin-bottom: 15px;
        }

        @media (max-width: 400px) {
            .container {
                min-width: 323px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Songs Database</h1>
        <hr class="elegant-line">

        <!-- Form to select festival and year -->
        <form method="GET" id="viewSongsForm">
            <select name="festival" required>
                <option value="">Select Festival</option>
                <option value="Eshwaramma Day">Eshwaramma Day</option>
                <option value="Guru Poornima">Guru Poornima</option>
                <option value="Krishnashtami">Krishnashtami</option>
                <option value="Ganesh Chaturthi">Ganesh Chaturthi</option>
                <option value="CT Day">CT Day</option>
                <option value="Swami's Birthday">Swami's Birthday</option>
                <option value="Christmas">Christmas</option>
                <option value="New Year">New Year</option>
                <option value="Shivarathri">Shivarathri</option>
                <option value="Aaradhana Mahotsavam">Aaradhana Mahotsavam</option>
            </select>
            <select name="year" required>
    <option value="">Select Year</option>
    <?php
    $currentYear = date("Y"); // Get the current year
    for ($year = $currentYear; $year >= 2011; $year--) { // Reverse loop
        echo "<option value='$year'>$year</option>";
    }
    ?>
</select> <br>    <button type="submit">View Songs</button><br>
        </form>

        <!-- PHP Section for Song List -->
        <?php
        include 'db_connect.php';

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['festival'], $_GET['year'])) {
            $festival = $mysqli->real_escape_string($_GET['festival']);
            $year = $mysqli->real_escape_string($_GET['year']);

            $query = "SELECT SongName, LastSungYear FROM songs_table WHERE Festival='$festival' AND LastSungYear LIKE '%$year%'";
            $result = $mysqli->query($query);

            if ($result && $result->num_rows > 0) {
                $festival=stripslashes($festival);
                echo "<h3>List of Songs for $festival $year.</h3>";
                echo "<table><tr><th>Song Name</th><th>Year</th></tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>{$row['SongName']}</td><td>{$row['LastSungYear']}</td></tr>";
                }

                echo "</table>";
            } else {
                $festival=stripslashes($festival);
                echo "<p>No songs found for $festival in $year.</p>";
            }
        }
        ?>

        <hr>

    </div>

    <script>
        function addNewSongField() {
            const newInput = document.createElement('input');
            newInput.type = 'text';
            newInput.name = 'bhajan[]';
            newInput.placeholder = 'Enter Song Name';
            newInput.classList.add('song-input');
            newInput.required = true;
            document.getElementById('songsContainer').appendChild(newInput);
        }
    </script>
</body>
</html>

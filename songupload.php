
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
    <style>
        body {
            background-color: #f2f2f2;
            font-family: monospace;
            text-align: center;
        }
        .container {
            margin: 20px auto;
            background-color: #fff;
            max-width: 380px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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

        input, select {
            width: 50%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #535353;
            color: white;
        }
        .add-button {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Songs Database</h1>
<hr class="elegant-line">
        <!-- Form to view songs -->
        <form action="songs.php">
                <div class="form-group">
                    <button type="submit" name="submit" class="btn-primary">View Songs</button>
                </div>
        </form>
<br>
        <hr>

        <!-- Form to upload songs -->
        <h2>Upload Song</h2>
        <form method="POST">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
<select name="last_sung_year" required>
    <option value="">Select Year</option>
    <script>
        const currentYear = new Date().getFullYear();
        for (let year = currentYear; year >= 2000; year--) {
            document.write(`<option value="${year}">${year}</option>`);
        }
    </script>
</select>    <select name="festival" required>
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

    <div id="songsContainer">
        <input type="text" name="bhajan[]" placeholder="Song Name" required>
    </div>

    <button type="button" class="add-button" onclick="addNewSongField()">Add Another Song</button>
    <button type="submit" name="submit">Upload Songs</button>
</form>
<br>
        <hr>
        <br>
        <form action="/logout.php">
                <div class="form-group" action="/logout.php">
                    <button id="submit" name="submit" class="btn-primary-mob">Logout</button>
                </div><br>
        </form>

        <!-- PHP Section for Uploading Songs -->
        <?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Validate the CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid form submission. Please try again.");
    }

    // Invalidate the CSRF token to prevent duplicate submissions
    unset($_SESSION['csrf_token']);

    include 'db_connect.php';
    $festival = $mysqli->real_escape_string($_POST['festival']);
    $last_sung_year = $mysqli->real_escape_string($_POST['last_sung_year']);
    $bhajan_names = $_POST['bhajan'];

    foreach ($bhajan_names as $bhajan) {
        $song_name = $mysqli->real_escape_string($bhajan);
        $insert_query = "INSERT INTO songs_table (Festival, SongName, LastSungYear) VALUES ('$festival', '$song_name', '$last_sung_year')";

        if ($mysqli->query($insert_query)) {
            echo "<p>Songs successfully uploaded.</p>";
        } else {
            echo "<p>Error uploading song '$song_name': " . $mysqli->error . "</p>";
        }
    }
}
?>


    </div>
    

    <script>
        function addNewSongField() {
            const newInput = document.createElement('input');
            newInput.type = 'text';
            newInput.name = 'bhajan[]';
            newInput.placeholder = 'Enter Song Name';
            newInput.required = true;
            document.getElementById('songsContainer').appendChild(newInput);
        }
    </script>
</body>
</html>

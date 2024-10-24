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
        gap: 10px; /* Adjust this value to control the spacing between buttons */
    }

    .form-group {
        margin: 0;
    }


    .btn-primary-mob:hover {
        background-color: #0056b3;
    }
        @media (max-width: 450px) {
    .container {
        width: 80%;
        padding: 10px;
    }
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

        // Close the database connection
        $mysqli->close();

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
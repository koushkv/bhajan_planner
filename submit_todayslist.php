<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Bhajans</title>
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
    </style>
</head>
<body>
    <div class="container">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            include "db_connect.php";

            $appendDate = $_POST["appendDate"];
            $bhajans = $_POST["bhajan"];

            // Sanitize inputs to prevent SQL injection
            $appendDate = $mysqli->real_escape_string($appendDate);

            foreach ($bhajans as $bhajan) {
                $bhajan = $mysqli->real_escape_string($bhajan);

                // Update the LastSungOn column by appending the new date
                $sql = "UPDATE bhajans_table 
                        SET LastSungOn = CONCAT(IFNULL(LastSungOn, ''),' $appendDate')
                        WHERE BhajanName = '$bhajan'";

                // if ($mysqli->query($sql) === TRUE) {
                //     echo "Record for $bhajan updated successfully<br>";
                // } else {
                //     echo "Error updating record for $bhajan: " . $mysqli->error . "<br>";
                // }
            }

            echo "<h2> Bhajans sung on the date $appendDate </h2>";
            $sql = "SELECT BhajanName, Shruthi FROM bhajans_table WHERE LastSungOn LIKE '%" . $mysqli->real_escape_string($appendDate) . "%'";
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

            $mysqli->close();
        }
        ?>

    </div>
</body>
</html>

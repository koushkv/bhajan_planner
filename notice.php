<?php
include "db_connect.php";
date_default_timezone_set('Asia/Kolkata');

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["notice"]) && !empty($_POST["noticedate"])) {
    $notice = $mysqli->real_escape_string(trim($_POST["notice"]));
    $noticeDate = $_POST["noticedate"];  // Use the selected date

    // Delete previous notices for the selected date to ensure only the latest one displays
    $stmt = $mysqli->prepare("DELETE FROM notice_table WHERE NoticeDate = ?");
    $stmt->bind_param("s", $noticeDate);
    $stmt->execute();
    $stmt->close();

    // Insert the new notice with the selected date
    $stmt = $mysqli->prepare("INSERT INTO notice_table (Notice, NoticeDate) VALUES (?, ?)");
    $stmt->bind_param("ss", $notice, $noticeDate);
    $stmt->execute();
    $stmt->close();

    echo "Notice posted!";
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="style.css"> <!-- Link to the external CSS file -->
    <title>Notice</title>
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
        .btn-primary {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            cursor: pointer;
            margin-top: 10px;
            border-radius: 5px;
            font-family: monospace;
            font-size: 1em;
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
        .error-message {
            color: red;
            font-weight: bold;
            margin-top: 10px;
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
        .ui-autocomplete {
        max-width: 100%;

        left: 41.25% !important; /* Ensure it's positioned in the center */
        transform: translateX(0%); /* Center the dropdown */
    }

        .autocomplete-item.header {
            background-color: lightgrey;
            pointer-events: none;
            width: 315px;
            text-align: right;
        }

        .autocomplete-item {
            display: flex;
            justify-content: space-between;
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-family: monospace;
            font-size: 1em;
            width: 315px; /* Set a fixed width */
            margin: 10 auto; /* Center the autocomplete box */
        }

        .autocomplete-item strong.bhajan-name {
            flex: 2;
            text-align: left; /* Center the text */
        }

        .autocomplete-item span.shruthi,
        .autocomplete-item span.last-sung {
            text-align: right;
            width: 50px; /* Set fixed width for other columns */
        }
        .ui-datepicker {
    left: 50% !important; 
    transform: translateX(-50%);
}

.special-text{
    padding: 9px;
    margin: 0px auto; /* Centers the box horizontally */
    border-radius: 8px;
    border: 1px #ccc;
    background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 60%, #fad0c4 100%);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    color: #333;
    font-family: monospace;
    font-size: 1em;
    font-weight: bold;
    text-align: center;
    display: inline-block; /* Width adjusts to the text */
}
.form-check {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
    margin-left:120px;
    gap: 15px; /* Optional: Adjust spacing between radio and label */
}

.form-check-inline {
    margin-right: 10px; /* Space between each radio input group */
}
        fieldset {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        h1 {
            font-family: 'Palatino Linotype', 'Book Antiqua', Palatino, serif; 
            font-size: 2em; /* You can adjust the size */
            margin-bottom: 10px;
        }
        .elegant-line {
    margin-top: 10px;
    margin-bottom: 20px;
    border: none;
    height: 1px;
    background: #999; /* Subtle grey line */
    position: relative;
}

.elegant-line::before {
    position: absolute;
    top: -15px; /* Position the symbol above the line */
    left: 50%;
    transform: translateX(-50%);
    font-size: 18px;
    color: #666; /* Soft grey for the "ॐ" symbol */
    font-family: 'serif'; /* Optional: To give it a more traditional feel */
}

        @media (max-width: 450px) {
    .container {
        width: 80%;
        padding: 10px;
    }
    .btn-primary {
        width: 50%;
        padding: 8px;
    }
    legend {
            background-color: #FFFFFF;
            color: black;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 1.2em;
            text-decoration: underline; 
            font-weight: bold;
        }
    input, select {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
    }
    .ui-autocomplete {
        max-width: 80%;

        left: -5% !important; /* Ensure it's positioned in the center */
        transform: translateX(20%); /* Center the dropdown */
    }
    .form-check {
        display: grid;
        grid-template-columns: auto 1fr;
        align-items: center;
        margin-left: 30px;
    }

    .form-check-fast {
        display: grid;
        grid-template-columns: auto 1fr;
        align-items: center;
        margin-left: 20px;
    }
    .form-check-slow {
        display: grid;
        grid-template-columns: auto 1fr;
        align-items: center;
        margin-left: 20px;
    }
    .form-check-med {
        display: grid;
        grid-template-columns: auto 1fr;
        align-items: center;
        margin-left: 20px;
    }
    .form-check input[type="radio"] {
        margin-right: 0;
        width:15px;
        margin-left: 80px;
    }
    .form-check-fast input[type="radio"] {
        margin-left: 64px;
        width:80px;
        
    }
    .form-check-slow input[type="radio"] {
        margin-left: 64px;
        width:30px;

    }
    .form-check-med input[type="radio"] {
        margin-left: 48px;
        width:60px;

    }
    .form-check label {
        margin-left: -80px;
        align-items: left;
    }
    .form-check-fast label {
        margin-left: 0px;
    }
    .form-check-slow label {
        margin-left: 0px;
    }
    .form-check-med label {
        margin-left: 0px;
    }
}



    </style>
</head>
<body>
    <div class="container">
<div class="form-group">
    <h2>Compose Notice</h2>
    <form method="POST" action="">
        <textarea name="notice" rows="4" cols="50" placeholder="Write your notice here..."></textarea><br><br>
        <label for="noticedate">Select Date:</label>
        <input type="date" id="noticedate" name="noticedate" value="<?php echo date('Y-m-d'); ?>" required><br><br>
        <button type="submit">Submit</button>
    </form><br>
    <form action="/index.php">
        <button id="submit" name="submit" class="btn-primary-mob">Home</button>
    </form>
</div>
</div>

<script>
    // Set the date picker to today’s date by default if not manually set in PHP
    document.getElementById("noticedate").value = document.getElementById("noticedate").value || new Date().toISOString().split('T')[0];
</script>
</body>
</html>

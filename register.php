<?php
session_start();
include 'db_connect.php'; // Database connection file

// Check if the token is provided
if (!isset($_GET['token'])) {
    die("Access denied: Token is required.");
}

$token = $_GET['token'];

// Retrieve the token and expiration from the database
$stmt = $mysqli->prepare("SELECT expiration FROM registration_tokens WHERE token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

// Check if the token exists and is valid
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Check if the token is expired
    if (time() > $row['expiration']) {
        die("Access denied: Token has expired.");
    }
} else {
    die("Access denied: Invalid token.");
}

// Process registration if token is valid and form is submitted
if (isset($_POST['register'])) {
    $uname = $_POST['uname'];
    $passwd = $_POST['passwd'];
    $role = 'normal'; // Default role for new users

    // Check if the username already exists
    $stmt = $mysqli->prepare("SELECT * FROM login_table WHERE Username = ?");
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<script>alert("Username already exists. Please choose a different one.");</script>';
    } else {
        // Insert new user
        $stmt = $mysqli->prepare("INSERT INTO login_table (Username, Passwd, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $uname, $passwd, $role);
        
        if ($stmt->execute()) {
            echo '<script>alert("Registration successful. Please Login with your new credentials."); window.location.href = "index.php";</script>';
            exit();
        } else {
            echo '<script>alert("Registration failed. Please try again.");</script>';
        }
    }

    // Close the statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
 
    <title>User Registration</title>
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
        @media (max-width: 450px) {
    .container {
        width: 80%;
        padding: 10px;
    }

    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form action="register.php?token=<?php echo htmlspecialchars($_GET['token']); ?>" method="POST">
            <div class="form-group">
                <label class="control-label" for="uname">Username:</label>
                <input type="text" id="uname" name="uname" required>
            </div><br>
            
            <div class="form-group">
                <label class="control-label" for="passwd">Password:</label>
                <input type="password" id="passwd" name="passwd" required>
            </div><br>
            
            <button type="submit" name="register">Register</button>
        </form>
    </div>
</body>
</html>

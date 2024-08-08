<?php
session_start();
// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Include database connection file
    include 'db_connect.php';

    // Capture the form data
    $uname = $_POST['uname'];
    $passwd = $_POST['passwd'];

    // Prepare the SQL statement
    $stmt = $mysqli->prepare("SELECT * FROM login_table WHERE Username = ? AND Passwd = ?");
    // Bind the parameters
    $stmt->bind_param("ss", $uname, $passwd);
    // Execute the statement
    $stmt->execute();
    // Get the result
    $result = $stmt->get_result();

    // Check if there are any matching records
    if ($result->num_rows > 0) {
        // User found, set session variables and redirect to admin page
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $uname;
        header("Location: admin.php");
        exit();
    } else {
        // User not found
        echo '<div class="error-message">Invalid username or password</div>';
    }

    // Close the statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="UTF-8">
    <title>Login</title>
</head>

<style>
    .error-message {
    color: #D8000C; /* Red color */
    background-color: #FFBABA; /* Light red background */
    padding: 15px; /* Some padding */
    border-radius: 5px; /* Rounded corners */
    border: 1px solid #D8000C; /* Border matching the text color */
    font-family: monospace; /* Font family */
    font-size: 16px; /* Font size */
    margin: 20px 0; /* Margin for spacing */
    text-align: center; /* Centered text */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
}
</style>
<body>
    <form method="POST" action="login.php">
        <!-- <input type="text" name="uname" placeholder="Username" required>
        <input type="password" name="passwd" placeholder="Password" required>
        <button type="submit" name="submit">Login</button> -->
    </form>
</body>
</html>

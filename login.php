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
        // Fetch the user data
        $user = $result->fetch_assoc();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user['Username'];
        $_SESSION['role'] = $user['role'];

        // Check user role and redirect accordingly
        if ($user['role'] == 'superadmin') {
            header("Location: superadmin.php");
        } elseif ($user['role'] == 'admin') {
            header("Location: admin.php");
        } elseif ($user['role'] == 'user') {
            header("Location: submit_list.php");
        } elseif ($user['role'] == 'normal') {
            header("Location: users.php");
        }
        exit();
    } else {
        // User not found or invalid credentials
        echo '<div class="error-message">Invalid username or password</div>';
    }

    // Close the statement
    $stmt->close();
}
?>

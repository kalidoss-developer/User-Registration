<?php
// config file
include 'config.php';
session_start(); // Start the session

// Form Values
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form values
    $user_name = $_POST['user_name'];
    $password = $_POST['pass'];
    $csrf_token = $_POST['csrf_token'];

    // Validate CSRF token
    if (!hash_equals($_SESSION['csrf_token'], $csrf_token)) {
        echo "2"; // CSRF token is invalid
        exit; // Stop further execution
    }

    // Check if the username or email exists
    $sql_check = "SELECT * FROM Login_details WHERE (username='$user_name' OR email='$user_name') AND status='active'";
    $result_check = $conn->query($sql_check);

    if ($result_check && $result_check->num_rows > 0) {
        // Fetch user data
        $user = $result_check->fetch_assoc();
        
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id']; // Store user ID in session
            $_SESSION['name'] = $user['full_name']; // Store username in session
            echo "1"; // Indicate successful login
        } else {
            echo "0"; // Invalid password
        }
    } else {
        echo "0"; // User does not exist
    }
}

// Close the connection
$conn->close();
?>

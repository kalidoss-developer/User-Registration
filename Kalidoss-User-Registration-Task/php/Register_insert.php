<?php
session_start(); // Start the session
// config file
include 'config.php';

// form Values
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form values
    $full_name = $_POST['name'];
    $username = $_POST['user_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone'];
    $password = $_POST['pass'];

    $csrf_token = $_POST['csrf_token'];

    // Validate CSRF token
    if (!hash_equals($_SESSION['csrf_token'], $csrf_token)) {
        echo "2"; // CSRF token is invalid
        exit; // Stop further execution
    }


    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $status = 'active';

    // Check if the email or username already exists
    $sql_check = "SELECT * FROM Login_details WHERE username='$username' AND status='active'";
    $result_check = $conn->query($sql_check);

    if ($result_check && $result_check->num_rows > 0) {
        echo "0";
    } else {
        // Prepare the SQL insert statement
        $sql_insert = "INSERT INTO Login_details (full_name, username, email, phone_number, password, status)
                       VALUES ('$full_name', '$username', '$email', '$phone_number', '$hashed_password', '$status')";

        // Execute the query and check for success
        if ($conn->query($sql_insert) === TRUE) {
            echo "1";
        } else {
            echo "Error: " . $sql_insert . "<br>" . $conn->error;
        }
    }
}

// Close the connection
$conn->close();
?>

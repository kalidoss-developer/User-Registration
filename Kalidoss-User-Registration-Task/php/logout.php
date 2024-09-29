<?php
session_start(); // Start the session

// Destroy the session
session_destroy();

// Redirect to index.php
header("Location: ../index.php");
exit();
?>

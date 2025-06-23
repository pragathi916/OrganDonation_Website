<?php
// Start the session (if not already started)
session_start();
include 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Please log in first to delete your profile.'); window.location.href = 'login.php';</script>";
    exit(); // Stop further execution
}


// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Fetch username from session
$username = $_SESSION['username'];

// Prepare and execute the SQL statement to delete the profile
$sql = "DELETE FROM registration WHERE username = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $username);

if ($stmt->execute()) {
    unset($_SESSION['username']);
    echo "<script>alert('Profile deleted successfully.'); window.location.href = 'index.html';</script>";
} else {
    echo "<script>alert('Profile deletion failed.');</script>"; // Display error message
}

$stmt->close();
$con->close();
?>

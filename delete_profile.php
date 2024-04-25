<?php
// Start the session (if not already started)
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Please log in first to delete your profile.'); window.location.href = 'login.php';</script>";
    exit(); // Stop further execution
}

// Include database configuration or any required files here
// Replace placeholders with actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "organ"; // Replace 'your_database_name' with the actual name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch username from session
$username = $_SESSION['username'];

// Prepare and execute the SQL statement to delete the profile
$sql = "DELETE FROM registration WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);

if ($stmt->execute()) {
    unset($_SESSION['username']);
    echo "<script>alert('Profile deleted successfully.'); window.location.href = 'logo.php';</script>";
} else {
    echo "<script>alert('Profile deletion failed.');</script>"; // Display error message
}

$stmt->close();
$conn->close();
?>

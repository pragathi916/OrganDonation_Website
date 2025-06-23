<?php
// Start session
session_start();
include 'connection.php';

// Check if user is logged in
if(isset($_SESSION['username'])) {
    // Get username of logged-in user
    $username = $_SESSION['username'];

    // Check if username exists
    $check_query = "SELECT username FROM login_details WHERE username = ?";
    $stmt_check = mysqli_prepare($con, $check_query);
    mysqli_stmt_bind_param($stmt_check, "s", $username);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);
    $num_rows = mysqli_stmt_num_rows($stmt_check);

    // Close prepared statement
    mysqli_stmt_close($stmt_check);

    if ($num_rows > 0) {
        // Delete user's account from login_details table
        $delete_query = "DELETE FROM login_details WHERE username = ?";
        $stmt = mysqli_prepare($con, $delete_query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        // Close prepared statement
        mysqli_stmt_close($stmt);

        // Close database connection
        mysqli_close($con);

        // Destroy session
        session_unset();
        session_destroy();
        echo "<script>alert('Logged out.. Redirecting to homepage.');</script>";
        echo '<meta http-equiv="refresh" content="2;url=index.html">';
        exit();
    } else {
        echo "<script>alert('Session username exists, but no record found in database.');</script>";
        echo '<meta http-equiv="refresh" content="0;url=login.php">';
        exit();
    }
} else {
    // If user is not logged in, redirect to login page
    echo "<script>alert('Please login');</script>";
    echo '<meta http-equiv="refresh" content="0;url=login.php">';
    exit();
}
?>

<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Please log in first to view your profile.'); window.location.href = 'login.php';</script>";
    exit();
}

// Database connection
$con = mysqli_connect("localhost", "root", "", "organ");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get username from session
$username = $_SESSION['username'];

// Query to fetch user details from registration table
$query_user = "SELECT * FROM registration WHERE username = '$username'";
$result_user = mysqli_query($con, $query_user);

// Query to fetch user details from donor table
$query_donor = "SELECT * FROM donor WHERE username = '$username'";
$result_donor = mysqli_query($con, $query_donor);

// Query to fetch user details from patient table
$query_patient = "SELECT * FROM patients WHERE username = '$username'";
$result_patient = mysqli_query($con, $query_patient);

// Check if user exists in the registration table
if (mysqli_num_rows($result_user) > 0) {
    $row_user = mysqli_fetch_assoc($result_user);
    // Display user details
    echo "<div class='container'>";
    echo "<h1>User Profile</h1>";
    echo "<table>";
    echo "<tr><td>Username:</td><td>" . $row_user['username'] . "</td></tr>";
    echo "<tr><td>Email:</td><td>" . $row_user['email'] . "</td></tr>";
    echo "<tr><td>Password:</td><td>" . $row_user['password'] . "</td></tr>";
    echo "</table>";

    // Check if user exists in the donor table
    if (mysqli_num_rows($result_donor) > 0) {
        $row_donor = mysqli_fetch_assoc($result_donor);
        // Display donor details
        echo "<h1>Donor Details</h1>";
        echo "<table>";
        echo "<tr><td>Place:</td><td>" . $row_donor['place'] . "</td></tr>";
        echo "<tr><td>Blood Group:</td><td>" . $row_donor['blood_group'] . "</td></tr>";
        echo "<tr><td>Contact:</td><td>" . $row_donor['contact'] . "</td></tr>";
        echo "<tr><td>Organ:</td><td>" . $row_donor['organ'] . "</td></tr>";
        echo "<tr><td>Age:</td><td>" . $row_donor['age'] . "</td></tr>";
        echo "<tr><td>UserType:</td><td>" . $row_donor['usertype'] . "</td></tr>";
        echo "</table>";

    } elseif (mysqli_num_rows($result_patient) > 0) {
        // Check if user exists in the patient table
        $row_patient = mysqli_fetch_assoc($result_patient);
        // Display patient details
        echo "<h1>Patient Details</h1>";
        echo "<table>";
        echo "<tr><td>Place:</td><td>" . $row_patient['place'] . "</td></tr>";
        echo "<tr><td>Blood Group:</td><td>" . $row_patient['blood_group'] . "</td></tr>";
        echo "<tr><td>Contact:</td><td>" . $row_patient['contact'] . "</td></tr>";
        echo "<tr><td>Organ:</td><td>" . $row_patient['organ'] . "</td></tr>";
        echo "<tr><td>Age:</td><td>" . $row_patient['age'] . "</td></tr>";
        echo "<tr><td>UserType:</td><td>" . $row_patient['usertype'] . "</td></tr>";
        echo "</table>";

    } else {
        echo "<p>User not registered as donor/patient</p>";
    }

    echo "</div>"; // Close container
} else {
    echo "<p>User not found</p>";
}

// Close database connection
mysqli_close($con);
?>
<html>
<head>
  <title>view profile</title>
  <style>
      body {
        background-image: url('bg.jpg'); /* Set background image */
        background-size: cover; /* Cover the entire viewport */
        background-repeat: no-repeat; /* Prevent the background image from repeating */
        background-attachment: fixed; /* Fix the background image so it doesn't scroll with the content */
        font-family: Arial, sans-serif; /* Use Arial font */
        color: #333; /* Set text color */
      }

      .container {
        max-width: 800px;
        margin: 20px auto; /* Center the container */
        background-color: white; /* Set background color */
        padding: 20px;
        border-radius: 10px; /* Add rounded corners */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Add shadow */
      }

      h1 {
        color: #990011; /* Set heading color */
        margin-bottom: 20px; /* Add spacing below heading */
      }

      h2 {
        color: #333; /* Set heading color */
        margin-top: 20px; /* Add spacing above heading */
      }

      table {
        width: 100%;
        border-collapse: collapse; /* Collapse table borders */
        margin-bottom: 20px; /* Add spacing below table */
      }

      table, th, td {
        border: 1px solid #ddd; /* Add border to table cells */
        padding: 8px; /* Add padding to table cells */
        text-align: left; /* Align text to the left */
      }

      th {
        background-color: #f2f2f2; /* Set background color for table header */
        color: #333; /* Set text color for table header */
      }

      tr:nth-child(even) {
        background-color: #f2f2f2; /* Set background color for even rows */
      }

      tr:hover {
        background-color: #ddd; /* Change background color on hover */
      }

      button {
        background-color: #990011; /* Set button background color */
        color: #fff; /* Set button text color */
        padding: 10px 20px; /* Add padding */
        border: none; /* Remove border */
        border-radius: 5px; /* Add rounded corners */
        cursor: pointer; /* Change cursor to pointer on hover */
        transition: background-color 0.3s; /* Smooth transition */
      }

      button:hover {
        background-color: #7A001D; /* Darken button color on hover */
      }

      button:focus {
        outline: none; /* Remove focus outline */
      }
</style></head>
<body>
<center>
<button onclick="window.location.href='logo.php';">Return Home</button>
</center>
</body>
</html>

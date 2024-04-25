<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Please log in first to view patients.'); window.location.href = 'login.php';</script>";
    exit();
}

// Database connection
$con = mysqli_connect("localhost", "root", "", "organ");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$select_query = "SELECT * FROM patients";
$result = mysqli_query($con, $select_query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style media="screen">
      table,tr,td,th {
        border: 1px solid black;
        border-collapse: collapse;
        padding: 8px;
      }

      table {
        width: 100%;
      }

      th {
        background-color: #990011;
        color: white;
      }

      h1 {
        text-align: center;
        color: #990011;
      }

      body {
        background-image: url('bg.jpg'); /* Change the background image URL here */
        background-size: cover; /* Cover the entire viewport */
        background-repeat: no-repeat; /* Prevent the background image from repeating */
        background-attachment: fixed;
        font-family: Arial, sans-serif;
        background-color: #FCF6F5;
      }

      button {
        background-color: #990011;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
      }

      button:hover {
        background-color: #80080E;
      }
      </style>
</head>
<body>
  <h1>Patient Details</h1>
  <table>
    <th> h-Heart</th><th> e-Eyes</th><th> l-Liver </th><th> k-Kidney </th><th> s-Spleen</td>
  </table>
<br><br><br>
  <table>
    <tr>
      <th>Username</th>
      <th>Place</th>
      <th>Blood Group</th>
      <th>Contact</th>
      <th>Organ</th>
      <th>Age</th>
      <th>User Type</th>
    </tr>
    <?php
    // Display patient details in table rows
    while ($row = mysqli_fetch_assoc($result)) {
      echo "<tr>";
      echo "<td>" . $row['username'] . "</td>";
      echo "<td>" . $row['place'] . "</td>";
      echo "<td>" . $row['blood_group'] . "</td>";
      echo "<td>" . $row['contact'] . "</td>";
      echo "<td>" . $row['organ'] . "</td>";
      echo "<td>" . $row['age'] . "</td>";
      echo "<td>" . $row['usertype'] . "</td>";
      echo "</tr>";
    }

    // Close database connection
    mysqli_close($con);
    ?>
  </table>
  <br><br>
  <center>
  <button onclick="window.location.href='logo.php';">Return Home</button>
</center>
</body>
</html>

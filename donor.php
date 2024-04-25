<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register As Donor Page</title>
  <style>
  body {
    background-image: url('bg.jpg'); /* Change the background image URL here */
    background-size: cover; /* Cover the entire viewport */
    background-repeat: no-repeat; /* Prevent the background image from repeating */
    background-attachment: fixed; /* Fix the background image so it doesn't scroll with the content */
  }
    body {
      background-color: #FCF6F5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 20px;
    }

    .registerd-container {
      width: 450px;
      margin: 50px auto;
      padding-top: 10px;
      padding-left: 50px;
      padding-bottom: 50px;
      padding-right: 80px;
      background-color: bisque;
      border: 1px solid #ebebeb;
      border-radius: 2px;
      font-size: 20px;
    }

    table {
      width: 110%;
    }

    td {
      padding: 8px;
    }

    input[type="text"],
    input[type="text"],
    input[type="select"],
    input[type="file"],
    select {
      width: 94%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    input[type="submit"] {
      width: 100%;
      padding: 10px;
      border: none;
      background-color: #990011;
      color: #FCF6F5;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #80080E;
    }

    h2 {
      text-align: center;
      color: #990011;
    }

    .return-home {
      width: 270%;
      padding: 10px;
      margin-top: 10px;
      border: none;
      background-color:#990011;
      color:white;
      cursor: pointer;
    }

    .return-home:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="registerd-container">
    <h2>Register As Donor</h2>
    <form action="" method="post" onsubmit="return validateForm();" enctype="multipart/form-data">
      <table>
        <tr>
          <td><input type="radio" name="usertype" value="medical" id="medical"><label for="medical">Medical Institute</label></td>
          <td><input type="radio" name="usertype" value="individual" id="individual"><label for="individual">Individual</label></td>
        </tr>
        <tr>
          <td>UserName:</td>
          <td><input type="text" name="name" id="name" required></td>
        </tr>
        <tr>
          <td>Place:</td>
          <td><input type="text" name="place" id="place" required></td>
        </tr>
        <tr>
          <td><label for="bgrp">Blood Group:</label></td>
          <td>
            <select id="bgrp" name="bgrp" required>
              <option value="">Choose your blood group</option>
              <option value="a+">A+ve</option>
              <option value="a-">A-ve</option>
              <option value="b+">B+ve</option>
              <option value="b-">B-ve</option>
              <option value="o+">o+ve</option>
              <option value="o-">O-ve</option>
              <option value="ab+">AB+ve</option>
              <option value="ab-">AB-ve</option>
            </select>
          </td>
        </tr>
        <tr>
          <td>Contact:</td>
          <td><input type="text" name="contact" id="contact" required></td>
        </tr>
        <tr>
          <td><label for="org">Select Organ:</label></td>
          <td>
            <select id="org" name="org" required>
              <option value="">Choose an organ</option>
              <option value="h">Heart</option>
              <option value="e">Eyes</option>
              <option value="k">Kidney</option>
              <option value="l">Liver</option>
              <option value="s">Spleen</option>
            </select>
          </td>
        </tr>
        <tr>
          <td>Age:</td>
          <td><input type="number" name="age" id="age" min="1" max="88" required></td>
        </tr>
        <tr>
          <td colspan="2"><input type="submit" value="Submit" name="submit"></td>
        </tr>
      </table>
    </form>
  </div>

  <script>
    function validateForm() {
      var medicalChecked = document.getElementById("medical").checked;
      var individualChecked = document.getElementById("individual").checked;
      var age = document.getElementById("age").value;
      var contact = document.getElementById("contact").value;

      if (!medicalChecked && !individualChecked) {
        alert("Please select a user type.");
        return false; // Prevent form submission
      }

      if (age < 1 || age > 88) {
        alert("Please enter a valid age between 1 and 88.");
        return false; // Prevent form submission
      }

      if (contact.length !== 10 || isNaN(contact)) {
        alert("Please enter a valid 10-digit contact number.");
        return false; // Prevent form submission
      }

      // Validation passed, allow form submission
      return true;
    }
  </script>


  <?php
  // Database connection
  $con = mysqli_connect("localhost", "root", "", "organ");
  if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Create patients table if it doesn't exist
  $create_table_query = "CREATE TABLE IF NOT EXISTS donor (
    username VARCHAR(50) PRIMARY KEY,
    place VARCHAR(100) NOT NULL,
    blood_group VARCHAR(10) NOT NULL,
    contact VARCHAR(20) NOT NULL,
    organ VARCHAR(10) NOT NULL,
    age INT(3) NOT NULL,
    usertype VARCHAR(20) NOT NULL
  )";
  if (!mysqli_query($con, $create_table_query)) {
    echo "<script>alert('Error creating table: " . mysqli_error($con) . "');</script>";
  }

  if(isset($_POST['submit'])) {
    $username = $_POST['name'];
    $place = $_POST['place'];
    $blood_group = $_POST['bgrp'];
    $contact = $_POST['contact'];
    $organ = $_POST['org'];
    $age = $_POST['age'];
    $usertype = $_POST['usertype'];

    // Check if username exists in login_details table
    $check_username_query = "SELECT * FROM login_details WHERE username = ?";
    $stmt = mysqli_prepare($con, $check_username_query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $check_username_result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($check_username_result) > 0) {
      // Username exists in the login_details table, proceed with form submission
      // Insert patient details into the patients table
      $insert_query = "INSERT INTO donor (username, place, blood_group, contact, organ, age, usertype) VALUES (?, ?, ?, ?, ?, ?, ?)";
      $stmt = mysqli_prepare($con, $insert_query);
      mysqli_stmt_bind_param($stmt, "sssssis", $username, $place, $blood_group, $contact, $organ, $age, $usertype);
      if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Donor details successfully inserted.');</script>";
        echo '<meta http-equiv="refresh" content="2;url=donor_details.php">';
        exit();
      } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
      }
    } else {
      echo "<script>alert('Username does not exist. Please register or log in first.');</script>";
      echo '<meta http-equiv="refresh" content="2;url=login.php">';
      exit();

    }
  }

  // Close database connection
  mysqli_close($con);
  ?>

</body>
</html>

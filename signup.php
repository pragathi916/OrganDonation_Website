<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <style>
        body {
          background-image: url('bg.jpg'); /* Change the background image URL here */
          background-size: cover; /* Cover the entire viewport */
          background-repeat: no-repeat; /* Prevent the background image from repeating */
          background-attachment: fixed; /* Fix the background image so it doesn't scroll with the content */
        }
    </style>
  <link rel="stylesheet" href="style.css"/>
</head>
<body>
<div class="signup-container">
    <h2>Sign up</h2>

    <?php
    include 'connection.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usertype = $_POST['med'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        } else {
            // Check if username already exists
            $stmt_check_username = $con->prepare("SELECT username FROM registration WHERE username = ?");
            $stmt_check_username->bind_param("s", $username);
            $stmt_check_username->execute();
            $result_check_username = $stmt_check_username->get_result();
            if ($result_check_username->num_rows > 0) {
                echo "<script>alert('Username already exists. Please choose a different username.');</script>";
            } else {
                // Proceed with the registration if username is unique
                $stmt_insert = $con->prepare("INSERT INTO registration (username, password, email, usertype) VALUES (?, ?, ?, ?)");
                $stmt_insert->bind_param("ssss", $username, $password,  $email,$usertype);
                $execval = $stmt_insert->execute();
                if ($execval) {
                    echo "<script>alert('Registration successful...');</script>";
                    echo '<meta http-equiv="refresh" content="2;url=login.php">';
                    exit;
                } else {
                    echo "<script>alert('Error: " . $stmt_insert->error . "');</script>";
                }
                $stmt_insert->close();
            }
            $stmt_check_username->close();
            $con->close();
        }
    }
    ?>

    <form action="" method="post" onsubmit="return validateForm();">
        <table>
            <tr>
                <td><input type="radio" name="med" id="medical" value="medical"><label for="medical">Medical Institute</label></td>
                <td><input type="radio" name="med" id="individual" value="individual"><label for="individual">Individual</label></td>
            </tr>
            <tr>
                <td>UserName:</td>
                <td><input type="text" name="username" id="username" required></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="email" name="email" id="email" required></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="password" id="password" required></td>
            </tr>
            <tr>
                <td>Confirm Password:</td>
                <td><input type="password" name="confirmpassword" id="confirmpassword" required></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Register"></td>
            </tr>
        </table>
    </form>
</div>

<script>
    function validateForm() {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirm_password").value;
        var medicalChecked = document.getElementById("medical").checked;
        var individualChecked = document.getElementById("individual").checked;

        if (!medicalChecked && !individualChecked) {
            alert("Please select a user type.");
            return false; // Prevent form submission
        }

        if (password !== confirmPassword) {
            alert("Password did not match. Please check and try again.");
            return false;
        }

        return true;
    }

    function returnHome() {
        window.location.href = "index.html";
    }
</script>
</body>
</html>

<?php
session_start();
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $type = isset($_POST['med']) ? $_POST['med'] : '';

    if (!empty($username) && !empty($password) && !empty($type) && !is_numeric($username)) {
        $query = "SELECT * FROM registration WHERE username = ? LIMIT 1";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);

            if ($user_data['password'] === $password) {
                $_SESSION['username'] = $user_data['username'];

                // Add user type to login_details table
                $login_time = date('Y-m-d H:i:s');
                $insert_query = "INSERT INTO login_details (username, password, usertype, login_time) VALUES (?, ?, ?, ?)";
                $insert_stmt = mysqli_prepare($con, $insert_query);
                mysqli_stmt_bind_param($insert_stmt, 'ssss', $username, $password, $type, $login_time);
                mysqli_stmt_execute($insert_stmt);

                echo '<script>alert("Login successful! Redirecting to homepage..");</script>';
                // Redirect to another page after a delay
                echo '<meta http-equiv="refresh" content="2;url=logo.php">';
                exit; // Use exit instead of die
            } else {
                // Display incorrect password message as an alert
                echo '<script>alert("Wrong password/type!");</script>';
            }
        } else {
            // Display username not found message as an alert
            echo '<script>alert("Username not found! Please register before you login");</script>';
            echo '<meta http-equiv="refresh" content="2;url=signup.php">';
            exit;
        }
    } else {
        // Display fill in all fields correctly message as an alert
        echo '<script>alert("Please fill in all the fields correctly!");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>LOG IN PAGE</title>
    <style>
    body {
      background-image: url('bg.jpg'); /* Change the background image URL here */
      background-size: cover; /* Cover the entire viewport */
      background-repeat: no-repeat; /* Prevent the background image from repeating */
      background-attachment: fixed;
        justify-content: center;
        align-items: center;
        display: flex;
        height: 100vh;

    }

        .login-container {
            width: 400px;
            margin: 6px auto;
            padding: 50px;
            background-color: bisque;
            border: 1px solid #ebebeb;
            border-radius: 3px;
            font-size: 22px;
        }

        table {
            width: 100%;
        }

        td {
            padding: 20px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        input[type="submit"],
        .return-home {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #990011;
            color: #FCF6F5;
            cursor: pointer;
        }

        input[type="submit"]:hover,
        .return-home:hover {
            background-color: #80080E;
        }

        h2 {
            text-align: center;
            color: #990011;
        }

        .return-home {
            margin-top: 10px;
        }

        .signup-link {
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>LOG IN</h2>
        <form method="post">
            <table>
                <tr>
                    <td><input type="radio" name="med" id="medical" value="medical"><label for="medical">Medical Institute</label></td>
                    <td><input type="radio" name="med" id="individual" value="individual"><label for="individual">Individual</label></td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" id="username" required></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" id="password" required></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="Submit"></td>
                </tr>
            </table>
        </form>
        <div class="signup-link">Not an existing user? <a href="signup.php">Sign-up</a></div>
    </div>
</body>

</html>

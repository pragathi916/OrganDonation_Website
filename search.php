
<?php
include 'connection.php';

$searchResult = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['searchType'])) {
    $searchType = $_POST['searchType'];
    $searchOption = $_POST['searchOption'];
    $searchQuery = mysqli_real_escape_string($con, $_POST['searchQuery']);
    $sql = "";

    switch ($searchType) {
        case "donor":
            switch ($searchOption) {
                case "username":
                    $sql = "SELECT * FROM donor WHERE username LIKE '%$searchQuery%'";
                    break;
                case "organ":
                    $sql = "SELECT * FROM donor WHERE organ LIKE '%$searchQuery%'";
                    break;
                case "place":
                    $sql = "SELECT * FROM donor WHERE place LIKE '%$searchQuery%'";
                    break;
            }
            break;
        case "patient":
            switch ($searchOption) {
                case "username":
                    $sql = "SELECT * FROM patients WHERE username LIKE '%$searchQuery%'";
                    break;
                case "organ":
                    $sql = "SELECT * FROM patients WHERE organ LIKE '%$searchQuery%'";
                    break;
                case "place":
                    $sql = "SELECT * FROM patients WHERE place LIKE '%$searchQuery%'";
                    break;
            }
            break;
    }

    if(!empty($sql)) {
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            $searchResult .= "<table align='center' border='1'>";
            $searchResult .= "<tr><th>Name</th><th>Age</th><th>Organ</th><th>Place</th><th>Contact</th><th>Blood_group</th><th>usertype</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                $searchResult .= "<tr>";
                $searchResult .= "<td>" . $row["username"] . "</td>";
                $searchResult .= "<td>" . $row["age"] . "</td>";
                $searchResult .= "<td>" . $row["organ"] . "</td>";
                $searchResult .= "<td>" . $row["place"] . "</td>";
                $searchResult .= "<td>" . $row["contact"] . "</td>";
                $searchResult .= "<td>" . $row["blood_group"] . "</td>";
                $searchResult .= "<td>" . $row["usertype"] . "</td>";
                $searchResult .= "</tr>";
            }
            $searchResult .= "</table>";
        } else {
            $searchResult = "<b>No results found.</b>";
        }
    } else {
        $searchResult = "<b>No results found.</b>";
    }

    // Close the database connection
    mysqli_close($con);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <style>
        body {
            background-image: url('bg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-size: 16px; /* Increase font size */
        }

        .search-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 97%;
            background-color: maroon;
            padding: 20px;
        }

        .search-form {
            margin-right: auto;
        }

        .search-button {
            padding: 18px;
            background-image: url('search.png');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            border: none;
        }

        input[type="text"],
        select {
            padding: 10px; 
            font-size: 16px; 
            margin-right: 10px; 
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: auto;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            color:black;
            font-weight:bold;

        }

        th {
            background-color: maroon;
            color: white; 
        }

        .search-label {
            font-size: 22px; 
            font-weight: bold;
            color:white; 
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
    <div class="search-container">
        <form method="post" action="#">
            <label for="searchType" class="search-label">Search Type:</label>
            <select name="searchType" id="searchType">
                <option value="donor">Donor</option>
                <option value="patient">Patient</option>
            </select>
            <label for="searchOption" class="search-label">Search Option:</label>
            <select name="searchOption" id="searchOption">
                <option value="username">Username</option>
                <option value="organ">Organ</option>
                <option value="place">Place</option>
            </select>
            <label for="searchOption" class="search-label">Search:  </label>
            <input type="text" placeholder="Enter to search" name="searchQuery" id="searchQuery">
            <button type="submit" class="search-button">
                <i class="fa fa-search"></i> 
            </button>
        </form>
    </div>
    <br><br>
    <div>
        <table>
            <tr>
                <th> h-Heart</th>
                <th> e-Eyes</th>
                <th> l-Liver </th>
                <th> k-Kidney </th>
                <th> s-Spleen</th>
            </tr>
        </table>
    </div>
    <br><br>
    <?php echo $searchResult; ?>
    <center>
        <button onclick="window.location.href='index.html';">Return Home</button>
    </center>
</body>

</html>

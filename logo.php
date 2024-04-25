<?php
// Database connection
$con = mysqli_connect("localhost", "root", "", "organ");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Count donors
$countDonorsQuery = "SELECT COUNT(*) AS num_donors FROM donor";
$resultDonors = mysqli_query($con, $countDonorsQuery);
$rowDonors = mysqli_fetch_assoc($resultDonors);
$numDonors = $rowDonors['num_donors'];

// Count patients
$countPatientsQuery = "SELECT COUNT(*) AS num_patients FROM patients";
$resultPatients = mysqli_query($con, $countPatientsQuery);
$rowPatients = mysqli_fetch_assoc($resultPatients);
$numPatients = $rowPatients['num_patients'];

mysqli_close($con);
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OrgPulse website</title>
    <style>
    body {
      background-image: url('bg.jpg'); /* Change the background image URL here */
      background-size: cover; /* Cover the entire viewport */
      background-repeat: no-repeat; /* Prevent the background image from repeating */
      background-attachment: fixed; /* Fix the background image so it doesn't scroll with the content */
    }

    .count {
height: 150px;
width: 45%;
padding: 20px;
margin-right: auto;
margin-left: auto;
border: 2px dashed #990011; /* Use the same color as the buttons */
border-radius: 5px;
background-color: #FCF6F5; /* Use a light shade of the header background color */
color: #990011; /* Use the same color as the buttons for text */
}

      header {
        width: 97%;
        background-color: #C0C0C0;
        padding: 20px;
        color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
      }

      .logo {
        max-width: 150px;
        border-radius: 50%;
        margin-right: 20px;
      }

      .org-name {
        color: #990011;
        font-family: Verdana;
        font-size: 58px;
        margin-bottom: 0;
      }

      .slogan {
        color: black;
        font-family: Times New Roman;
        font-size: 16px;
        font-style: italic;
        text-align: center;
        margin-top: 0;
      }

      .login-link {
        color: #fff;
        text-decoration: none;
        font-size: 22px;
        padding: 5px 10px;
        background-color: #990011;
        border-radius: 5px;
      }

      .search-button {
    padding: 12px; /* Increase padding for larger button size */
    background-image: url('search.png');
    background-size: contain; /* Ensure the background image fits within the button */
    background-repeat: no-repeat; /* Prevent the background image from repeating */
    background-position: center; /* Center the background image within the button */
    border: none; /* Remove border */
  }


      .search-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 97%;
        background-color: #990011;
        padding: 20px;
      }

      .search-form {
        margin-right: auto;
      }

      .login-link {
        margin-left: auto;
      }

      .box1 {
        height: 250px;
        width: 45%;
        padding: 20px;
        margin-right: auto;
        margin-left: auto;
        border: 2px dashed black;
        border-radius: 5px;
        background-color: #990011;
        color: white;
      }

      .box {
        height: 150px;
        width: 45%;
        padding: 20px;
        margin-right: auto;
        margin-left: auto;
        border: 2px dashed black;
        border-radius: 5px;
        background-color: #990011;
      }

      .button {
        display: block;
        width: 50%;
        margin: 0 auto;
        padding: 10px;
        text-align: center;
        background-color: #FCF6F5;
        color: #fff;
        text-decoration: none;
        border: none;
        border-radius: 5px;
        margin-top: 10px;
        color: #990011;
      }

      .flex-container {
        display: flex;
        flex-wrap: nowrap;
        justify-content: space-around;
        background-color: white;
        padding: 20px;
      }

      .flex-container .box {
        background-color: #f2f2f2;
        flex: 0 1 calc(33.33% - 20px);
        margin: 0 10px;
        text-align: center;
        font-size: 18px;
        border: 1px solid #ccc;
        border-radius: 8px;
        overflow: visible;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        position: relative;
        padding: 80px 20px 20px;
      }

      .flex-container .box img {
        width: 140px;
        height: auto;
        border-radius: 50%;
        position: absolute;
        top: -70px;
        left: 50%;
        transform: translateX(-50%);
      }

      .container {
        background-color: #C0C0C0;
        padding: 20px;
        overflow: hidden;
      }

      .left-content,
      .right-content {
        width: 50%;
        float: left;
        padding: 10px;
        box-sizing: border-box;
      }

      .line {
        width: 2px;
        background-color: #000;
        height: 100%;
        float: left;
      }

      /* Sidebar styles */
      .sidebar {
        height: 100%;
        width: 0;
        position: fixed;
        top: 0;
        right: 0;
        background-color: #707070;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;
      }

      .sidebar a {
    text-decoration: none;
    font-size: 20px;
    color: #818181;
    display: block;
    transition: 0.3s;
    margin-bottom: 10px; /* Added spacing between links */
    padding-left: 10px; /* Added left padding */
  }

      .sidebar a:hover {
        color: #f1f1f1;
      }

      .sidebar .closebtn {
    position: absolute;
    top: 0;
    left: 25px;
    font-size: 36px;
    margin-right: 50px;
    color: white; /* Set color to white */
  }


      #main {
        transition: margin-right .5s;
        padding: 16px;
        text-align: right;
      }

      .openbtn {
        float: right;
        font-size: 30px; /* Increase the font size */
        color: #990011; /* Set the color to #990011 */
        background-color: transparent; /* Set background color to transparent */
        border: none; /* Remove border */
        cursor: pointer;
        padding: 10px; /* Add padding for better clickability */
      }

      /* Updated profile pic styles */
      .profile-pic-container {
        position: relative;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin: 20px auto;
        border: 2px solid white;
        overflow: hidden;
        display: flex; /* Use flexbox */
        justify-content: center; /* Center horizontally */
        align-items: center; /* Center vertically */
      }

      .profile-pic {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }


  .alt-message {
    position: absolute;
    bottom: 0; /* Adjust as needed */
    left: 0; /* Adjust as needed */
    right: 0; /* Adjust as needed */
    text-align: center;
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    color: white;
    padding: 4px 0; /* Adjust as needed */
    font-size: 12px; /* Adjust as needed */
  }

      /* File upload button styles */
      .file-upload {
        display: none;
      }

      .upload-btn {
        background-color: #990011;
        color: #fff;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
      }

      /* Profile picture preview */
      .profile-preview {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin: 10px auto;
        display: block;
      }
    </style>
  </head>

  <body>
    <header>
      <div>
        <img src="logo.jpg" alt="Logo" class="logo">
      </div>
      <div class="text-container">
        <h1 class="org-name">ORG PULSE</h1>
        <p class="slogan"><b>Be a symbol of hope for those who are waiting</b></p>
      </div>

      <div id="mySidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
        <div class="profile-pic-container">
          <img src="profile.webp" class="profile-pic" id="userImage">
          <span class="alt-message">Profile</span>
        </div>

        <input type="file" class="file-upload" id="profileUpload" accept="image/*" onchange="previewProfile()">

               <label for="profileUpload" class="upload-btn">Upload Picture</label>
               <br><br><br>
               <button class="upload-btn" id="viewprofile" onclick="viewProfile()">View Profile</button>
               <br><br><br>
               <button class="upload-btn" onclick="window.location.href='donor_details.php';">View Donors</button>
               <br><br><br>
               <button class="upload-btn" onclick="window.location.href='patient_details.php';">View Patients</button>
               <br><br><br>
               <button class="upload-btn" onclick="window.location.href='search.php';">Search Donors/ Patients</button>
               <br><br><br>
               <button class="upload-btn" id="deleteBtn">Delete Profile</button>
               <br><br><br>
               <button class="upload-btn" id="logoutBtn">Logout</button>
               <br><br><br>

      </div>

      <div id="main">
        <button class="openbtn" onclick="openNav()">☰</button>
      </div>

    </header>
    <div class="search-container">
        <form class="search-form" action="#">
          <input type="text" placeholder="Search" name="search" id="searchInput">
          <button type="button" class="search-button" onclick="searchWebsite()">
      <i class="fa fa-search"></i> <!-- Search icon inside the button -->
    </button>

    </form>
    <a href="login.php" class="login-link">Login/Sign-up</a>
  </div>
    <br>
  <BR>
    <br>

    <div style="display: flex; justify-content: space-between;">
      <div class="count">
          <h2 style="text-align:center"><b>Registered Donors</b></h2><br>
          <h3 style="text-align:center"><?php echo $numDonors; ?></h3>
      </div>

        <div class="count">
            <h2 style="text-align:center"><b>Registered Patients</b></h2><br>
          <h3 style="text-align:center"> <?php echo $numPatients; ?></h3>
        </div>
    </div>
    <br><br><br>
    <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
        <div class="box1">
            <h2 style="text-align:center"><b>Register as Donor</b></h2><br>
            <p style="text-align:center"><b>Fill out your details below</b></p><br>
            <a href="donor.php" class="button">Register</a>
        </div>
        <br><br><br>
        <div class="box1">
            <h2 style="text-align:center"><b>Register as Patient</b></h2><br>
            <p style="text-align:center"><b>Fill out your details below</b></p><br>
            <a href="patient.php" class="button">Register</a>
        </div>

    </div>


    <br><br><br>
    <br>
    <br>
    <br>

    <div class="flex-container">
      <div class="box">
        <img src="org.jpg" alt="Organ Donation" width="140">
        <b>WHAT IS ORGAN AND TISSUE DONATION?</b><br>
        Organ Donation is the gift of an organ to a person with end-stage organ disease and who needs a transplant. The donated organ may be from a deceased donor or a living donor.
      </div>

      <div class="box">
        <img src="org1.jpg" alt="Transplantation" width="140">
        <b>WHAT IS TRANSPLANTATION?</b><br>
        Surgical operation in which a failing or damaged organ in the human body is removed and replaced with a functioning one.
      </div>

      <div class="box">
        <img src="org2.jpg" alt="Why Donate" width="140">
        <b>WHY SHOULD WE DONATE?</b><br>
        Donating organs is a profoundly altruistic act with far-reaching implications, not only for those directly involved but also for society as a whole. At its core, the decision to donate organs can save and enhance lives.
      </div>
    </div>
  <br>
  <br>
    <br>

    <div class="container">
      <div class="left-content">
        <br>
        <br>
        <br>
        <b>Address </b><br>
        NMAM Institute Of Technology, Nitte <br>
        Karkala, Karnataka <br>
        Toll-Free Number: 1800-11-4770<br>
      </div>
      <div class="line"></div>
      <div class="right-content">
        <br>
        <br>
        <br>
        <b> Policies </b><br>
        <a href="terms.html" target="_blank">Terms and Conditions</a><br>
        <a href="website.html" target="_blank">Website Policies</a><br>
        <a href="privacy.html" target="_blank"> Privacy Policies</a><br>
      </div>
    </div>
    <script>
        // JavaScript function for searching the website
         function searchWebsite() {
           // Get the search query from the input field
           const searchQuery = document.getElementById('searchInput').value.trim().toLowerCase();

           // Get all elements containing text content on the page
           const elements = document.querySelectorAll('body *');

           let found = false; // Flag to track if match is found

           // Iterate through the elements to find matches
           elements.forEach(element => {
             const text = element.textContent.toLowerCase();
             if (text.includes(searchQuery)) {
               // Scroll to the matched element
               element.scrollIntoView({ behavior: 'smooth', block: 'start' });
               found = true; // Set found flag to true
               return; // Exit the loop after finding the first match
             }
           })

      if (!found) {
        alert('No match found!');
      }
    }
    </script>
    <script>
    // JavaScript for opening and closing the sidebar
  function openNav() {
      document.getElementById("mySidebar").style.width = "250px";
      document.getElementById("main").style.marginRight = "250px";
  }

  function closeNav() {
      document.getElementById("mySidebar").style.width = "0";
      document.getElementById("main").style.marginRight = "0";
  }


   // JavaScript for previewing profile picture
   function previewProfile() {
     const fileInput = document.getElementById('profileUpload');
     const profilePic = document.getElementById('userImage');
     const file = fileInput.files[0];
     const reader = new FileReader();

     reader.onloadend = function () {
       profilePic.src = reader.result;
     }

     if (file) {
       reader.readAsDataURL(file);
     } else {
       profilePic.src = 'profile.png'; // Default profile picture
     }
   }

     // JavaScript to handle logout button click event
     document.addEventListener('DOMContentLoaded', function () {
       // Get the logout button
       const logoutButton = document.getElementById('logoutBtn');

       // Add click event listener to the logout button
       logoutButton.addEventListener('click', function () {
         // Redirect to logout.php when the button is clicked
         window.location.href = 'logout.php';
       });
     });

document.getElementById('deleteBtn').addEventListener('click', function() {
    var confirmation = confirm('Are you sure you want to delete your profile?');
    if (confirmation) {
        // Redirect to delete_profile.php after confirmation
        window.location.href = 'delete_profile.php';
    } else {
        // Optionally, show a message if the user cancels the deletion
        alert('Profile deletion canceled.');
    }
});
function viewProfile() {
    // Redirect to profile.php
    window.location.href = 'profile.php';
  }




    </script>
    </script>
  </body>

  </html>

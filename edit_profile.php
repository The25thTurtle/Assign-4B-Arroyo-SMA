<?php
// Start the session so the user's login information can be accessed
session_start();

// Include the database connection file
require_once 'mysql.php';

// Connect to database
$resid = MySQLi_Connect('localhost','aarroy10','25thTurtle@1203','aarroy10_db');

// Check database connection
if(MySQLi_Connect_Errno()) {
    die("Failed to connect to MySQL");
}

// Check whether the user is logged in
if(!isset($_SESSION["user_id"])) {
    // Redirect unauthenticated users to the login page
    header("Location: login.php");
    exit();
}

// Store the logged-in user's ID for later use
$user_id = $_SESSION["user_id"];


// Update profile information when the form is submitted
if($_SERVER["REQUEST_METHOD"]=="POST") {

    // Secure user input
    $name = htmlspecialchars(trim($_POST["name"]));
    $major = htmlspecialchars(trim($_POST["major"]));
    $bio = htmlspecialchars(trim($_POST["bio"]));


    // Update profile information in database
    $query = "UPDATE students 
              SET name='$name', major='$major', bio='$bio'
              WHERE id=$user_id";


    $result = MySQLi_Query($resid,$query);


    if($result) {
        echo "<tr align='center'><td colspan='5'><font color='green'>Profile Updated Successfully!</font></td></tr>";
    }
    else {
        echo "<tr align='center'><td colspan='5'><font color='red'>Profile Update Failed!</font></td></tr>";
    }

}


// Retrieve current profile information
$query = "SELECT name, major, bio FROM students WHERE id=$user_id";

$result = MySQLi_Query($resid,$query);


if($result) {

    $profile = MySQLi_Fetch_Assoc($result);

    $name = $profile["name"];
    $major = $profile["major"];
    $bio = $profile["bio"];

}

?>


<!doctype html>
<html>
<head>

    <link rel="stylesheet" href="page_css.css">

    <title>Student's Hangout - Edit Profile</title>

</head>


<body>


<table cellpadding="3" cellspacing="3" class="tab_main">


<!--Logo-->
<tr>
    <td colspan="5">
        <img src="images/logo.png" height="65%" width="100%">
    </td>
</tr>



<!--Nav_Tabs-->
<tr align="center" bgcolor="lightgrey" class="td_bor">

    <td width="5%"> <a href="user_page.php">Home</a></td>

    <td width="5%"> <a href="send_message.php">Send Message</a></td>

    <td width="5%"> <a href="inbox.php">Inbox</a></td>

    <td width="5%"> <a href="view_profile.php">View Profile</a></td>

    <td width="5%"> <a href="signout.php">Signout</a></td>

</tr>



<tr>
    <td><hr></td>
    <td><hr></td>
    <td><hr></td>
    <td><hr></td>
    <td><hr></td>
</tr>



<!--Edit Profile Form-->

<tr align="center">

<td colspan="5">


<h2>Edit Profile</h2>



<form method="POST" action="edit_profile.php">


<table align="center">


<tr>

<td>Name:</td>

<td>
<input type="text" name="name" maxlength="50" value="<?php echo $name; ?>">
</td>

</tr>



<tr>

<td>Major:</td>

<td>
<input type="text" name="major" maxlength="100" value="<?php echo $major; ?>">
</td>

</tr>



<tr>

<td>About Me:</td>

<td>
<textarea name="bio" rows="5" cols="40" maxlength="300"><?php echo $bio; ?></textarea>
</td>

</tr>



<tr>

<td colspan="2" align="center">

<input type="submit" value="Update Profile">

</td>

</tr>


</table>


</form>


</td>

</tr>



</table>



<?php

// Include the shared website footer
include 'footer.php';


// Close database connection
MySQLi_Close($resid);

?>


</body>
</html>
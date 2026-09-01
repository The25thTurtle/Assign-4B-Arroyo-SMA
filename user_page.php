<!doctype html>
<html>
<head>

	<!-- Link external CSS stylesheet -->
	<link rel='stylesheet' href='page_css.css'>
	
	<!-- Website title -->
	<title> Student's Hangout </title>
	
	<!-- Load jQuery library -->
	<script src='jquery.js'></script>
	
	<script type='text/javascript'>
	
	// Runs after the page finishes loading
	$(document).ready(function() 
	{
		// Hides the element with id "sam" with animation
		$("#sam").hide(2000);
	});
	
	</script>

</head>

<body>

	<!-- Main table used for page layout -->
	<table cellpadding='3' cellspacing='3' class='tab_main'>

		<!-- Logo section -->
		<tr>
			<td colspan='5'><img src='images/logo.png' height='65%' width='100%' ></td>
		</tr>

		<!-- Navigation menu tabs -->
		<tr align='center' bgcolor='lightgrey' class='td_bor'>
		
			<!-- Home link changes depending on login status -->
			<td width='5%'> <?php Session_start(); if(IsSet($_SESSION["user_id"])) {echo "<a href='user_page.php'>"; } else {echo "<a href='home.php'>";}?>Home </a></td>
			
			<!-- Send message navigation link -->
			<td width='5%'> <a href='send_message.php'>Send Message </a></td>
			
			<!-- Inbox navigation link -->
			<td width='5%'> <a href='inbox.php'>Inbox (Only Recent Message) </a></td>
			
			<!-- Profile navigation link -->
			<td width='5%'> <a href='view_profile.php'>View Profile </a></td>
			
			<!-- Logout navigation link -->
			<td width='5%'> <a href='signout.php'>Signout </a></td>

		</tr>
		
		<!-- Horizontal divider -->
		<tr>
			<td> <hr> </td> 
			<td> <hr> </td> 
			<td> <hr> </td> 
			<td> <hr> </td> 
			<td> <hr> </td> 
		</tr>


<?php

// Start session and initialize login variables
Session_start();
$email=$password=$no_msg="";


// Redirect users who are not logged in and have not submitted login information
if(!isset($_SESSION['user_id']) && !isset($_POST['h1'])) {
	Header("Location: home.php");
}


// If user is already logged in, use saved session information
if(isset($_SESSION['user_id'])) {
	$_POST['h1'] = "holla";
	$_POST['e1'] = $_SESSION['email'];
	$_POST['p1'] = $_SESSION['password'];
	$no_msg = 1;
}


// Function used to clean and secure user input
function sec($data) {

	// Remove extra spaces
	$data=trim($data);
	
	// Remove slashes
	$data=stripslashes($data);
	
	// Convert special characters into HTML entities
	$data=htmlspecialchars($data);
	
	return $data;
}


// Retrieve login information
if($_POST['h1']=="holla") {

	// Sanitize email input
	$email=sec($_POST["e1"]);
	
	// Retrieve password
	$password=$_POST["p1"];
}


// SQL query to find matching student account using email
$query="select * from students where email='$email'";

// Connect to MySQL database
$resid=MySQLi_Connect('localhost','aarroy10','25thTurtle@1203','aarroy10_db');


// Check if database connection failed
if(MySQLi_Connect_Errno()) {

	echo "<tr align='center'> <td colspan='5'> Failed to connect to MySQL </td> </tr>";

}

else {

	// Execute login query
	$result=MySQLi_Query($resid,$query);
	
	// Retrieve matching student information
	$array=MySQLi_Fetch_Assoc($result);


	// Check if login credentials were correct using password verification
	if($array && (password_verify($password,$array["password"]) || $password == $array["password"])) {		// Store user information into session variables
		Session_start();
		
		$_SESSION["user_id"] = $array["id"]; 
		$user_here = $_SESSION["user_id"];
		$_SESSION["name"] = $array["name"];
		$_SESSION["password"] = $array["password"];
		$_SESSION["age"]  = $array["AGE"];
		$_SESSION["email"] = $array["email"];
		$_SESSION["gender"] = $array["gender"];


		// Display login notification for new logins
		if($no_msg!=1) {
			?>
			
			<script type="text/javascript" src="notify.js"></script>
			
			<script>
			$(document).ready(function() {
			  $.notify(
			  "Login Successful!","success");
			});
			</script>
			
			<?php 
		}


		// Display user navigation menu
		echo "<tr> 
		<td width='5%' valign='top'> 
		
			<table>
			
				<!-- Friends page link -->
				<tr align='center' bgcolor='lightgrey' class='td_bor'>
					<td width='5%'> <a href='friends.php'>Friends </a></td> 
				</tr>
				
				<!-- Status update link -->
				<tr align='center' bgcolor='lightgrey' class='td_bor'> 
					<td width='5%'> <a href='update_status.php'> Status Update </td> 
				</tr>
				
				<!-- Friend list link -->
				<tr align='center' bgcolor='lightgrey' class='td_bor'>
					<td width='5%'> <a href='friend_list.php'>Friend List</a></td>
				</tr>
				
			</table>
			
		</td>
		
		<td colspan='4'>";


		// Display friend status updates heading
		echo "<table cellpadding='4' cellspacing='5' width='100%' style='table-layout:fixed'> <col width='100%'> <tr align='centre'> <th> <h3> Updates from your Friends: </h3> </th> </tr> ";


		// Retrieve friends connected to current user
		$count = MySQLi_Query($resid,"select frnd_two_id from are_friends where frnd_one_id = $user_here union select frnd_one_id from are_friends where frnd_two_id = $user_here");


		// Check if friend records exist
		if($count) {

			$f=1;


			// Loop through each friend
			while(($rows=MySQLi_Fetch_Row($count))==True) {

				$f=2;


				// Retrieve friend's statuses
				$query = "select status,time_format(timestamp,'%l:%i:%s %p') as time,date_format(timestamp,'%D of %M,%Y') as date from status_here where user_id = $rows[0] order by id desc";


				// Retrieve friend's name
				$queryx = "select name from students where id = $rows[0]";


				// Execute status and name queries
				$result = MySQLi_Query($resid,$query);
				$result1 = MySQLi_Query($resid,$queryx);


				// Store friend's name
				$name_here =MySQLi_Fetch_Row($result1);


				// Display friend statuses
				if($result) {

					while(($rows1=MySQLi_Fetch_Row($result))==True) {

						// Display friend's name
						echo "<tr> <td> <font style='color:blue'>$name_here[0]: </font> </td> </tr>";
						
						// Display status message
						echo "<tr> <td style='word-wrap:break-word'> $rows1[0] </td> </tr>";
						
						// Display status date and time
						echo "<tr> <td> (On $rows1[2] at $rows1[1]) </td> <tr>";
						
					}
				}
			}


			// Display message if user has no friends
			if($f==1) {
				echo "<table> <tr align='centre'> <td>  <i> Sorry, you don't have friends yet! </i>  </td> </tr> </table>";
			}


			echo "</table>";
			
		}


		echo "</td>
			
		</tr>";

	}

	else {

		// Display login failure message
		echo "<tr align='center'> <td colspan='5'> <font color='red'> Login Failed! </font> Make sure you input your email and password correctly and login again:- <a href='login.php'>Login</a> </td> </tr>";

	}


// Close database connection
MySQLi_Close($resid);

}

?>	


</table>

<!-- Footer section -->
<hr>

<footer style="text-align:center; font-size:12px; margin-top:20px">

	<!-- Copyright information -->
	&copy; All Rights Reserved.<br>
	
	<!-- Display logged-in user's name -->
	<?php if(isset($_SESSION["user_id"])) {echo $_SESSION["name"]; } ?>
	
	<!-- Application information -->
	Social Media Application (SMA) <br>
	
	<!-- Original project credit -->
	Based on the Simple PHP MySQL Project by abhn.<br>
	
	<!-- Github project link -->
	Original Project:
	<a href="https://github.com/abhn/simple-php-mysql-project" target="_blank">
		https://github.com/abhn/simple-php-mysql-project
	</a><br>
	
	<!-- License information -->
	Licensed under the MIT License. See the LICENSE file included with this project.

</footer>

</body>
</html>
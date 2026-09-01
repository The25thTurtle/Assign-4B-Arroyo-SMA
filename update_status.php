<?php
// Start the user session to access session variables such as user_id
session_start();

// Connect to the MySQL database using the database connection file
require_once 'mysql.php';
?>
<!doctype html>
<html>
<head>
	<!-- Link external CSS stylesheet for page styling -->
	<link rel='stylesheet' href='page_css.css'>
	
	<!-- Page title displayed in browser tab -->
	<title> Student's Hangout </title>
	
	<!-- Load jQuery library -->
	<script src='jquery.js'></script>
	
	<script type='text/javascript'>
	
		// Function used to validate and submit the status update form
		function sec() {
			// Get the status value entered by the user
			var stat=document.f1.status.value;
			
			// Remove extra spaces from beginning and end
			stat = stat.trim();

			// Check if status field is empty
			if(stat.length==0) {
				check.innerHTML="<font color='red'> Field is Required </font>";
			}
			
			// Check if status exceeds the maximum character limit
			else if(stat.length>300) {
				check.innerHTML="<font color='red'> Maximum 300 Characters!</font>";
			
			}
			
			// Submit the form if validation passes
			else {
				document.f1.submit();
			}
		}
	
	// Runs when the webpage finishes loading
	$(document).ready(function() 
	{
		// Hide the element with id "sam" using jQuery animation
		$("#sam").hide(2000);
	});
	</script>

</head>

<body>

	<!-- Main table used for organizing page layout -->
	<table cellpadding='3' cellspacing='3' class='tab_main'>
	
		<!-- Website logo section -->
		<tr>
			<td colspan='5'><img src='images/logo.png' height='65%' width='100%' ></td>
		</tr>
		
		<!-- Navigation menu section -->
		<tr align='center' bgcolor='lightgrey' class='td_bor'>
		
			<!-- Display Home link based on login status -->
			<td width='5%'> <?php if(IsSet($_SESSION["user_id"])) {echo "<a href='user_page.php'>"; } else {echo "<a href='home.php'>";}?>Home </a></td>
			
			<!-- Link to send messages page -->
			<td width='5%'> <a href='send_message.php'>Send Message </a></td>
			
			<!-- Link to inbox page -->
			<td width='5%'> <a href='inbox.php'>Inbox (Only Recent Message) </a></td>
			
			<!-- Link to profile page -->
			<td width='5%'> <a href='view_profile.php'>View Profile </a></td>
			
			<!-- Link to logout page -->
			<td width='5%'> <a href='signout.php'>Signout </a></td>

		</tr>
		
		<!-- Horizontal line separator -->
		<tr>
			<td> <hr> </td> 
			<td> <hr> </td> 
			<td> <hr> </td> 
			<td> <hr> </td> 
			<td> <hr> </td> 
		</tr>
		
		<?php
		
		// Check if a user is currently logged in
		if(IsSet($_SESSION["user_id"])) {
		?>

<!-- Status update form section -->
<tr align='center'> 
	<td colspan='5'> 
	
		<!-- Form used for submitting user status updates -->
		<form name='f1' method='POST' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>'>
		
			<table align="center">
				<tr>
					<!-- Status text input area -->
					<td> Update your Status:- </td>
					<td> <textarea rows='20' cols='45' maxlength='300' name='status'> </textarea> </td>
					<td> (MAX 300 Characters) </td>
				</tr>
				
				<!-- Update button and validation message area -->
				<tr class="buttonUP">
					<td colspan='2' style="text-align:center;">  
						<input type='button' value='Update' onclick='sec()' > 
					</td> 
					
					<!-- Displays validation messages -->
					<td> <span id='check'> </span> </td>
				</tr>
			</table>  
			
		</form>
	</td> 
</tr>


<!-- Process status update submission -->
<?php

// Check if the form was submitted using POST method
if($_SERVER["REQUEST_METHOD"]=="POST") {

	// Retrieve and clean the submitted status
	$status = trim($_POST["status"]);
	$status = stripslashes($status);
	$status = htmlspecialchars($status);		

	// Verify database connection exists
	if($resid) {
		
		// Get current logged-in user's ID
		$user_id = $_SESSION['user_id'];
		
		// Insert new status into database
		$query = "insert into status_here (status,user_id,timestamp,future_use) values ('$status',$user_id,NOW(),NULL)";
		
		// Execute database query
		$qwer = MySQLi_Query($resid,$query);
		
		// Display success notification if insert worked
		if($qwer) {
			?>
			<script type="text/javascript" src="notify.js"></script>
			<script>
			$(document).ready(function() {
			  $.notify(
			  "Status Updated!","success");
			});
			</script>
			<?php
		}
		
		// Display error message if database insert failed
		else {
			echo "<tr align='center'> <td colspan='5'> <font color='green'> Sorry, Something went wrong! Refresh the page and try again! </font> </td> </tr>";
		}
		
		// Close database connection
		MySQLi_Close($resid);
	}
}

?>

<?php

// Check logged-in user before displaying previous statuses
if($_SESSION['user_id']) {

	// Store current user's ID
	$user_id = $_SESSION['user_id'];
	
	// Display previous user statuses
	if($resid) {
		
		// Retrieve statuses from database ordered by newest first
		$query1 = "select status,time_format(timestamp,'%l:%i:%s %p') as time,date_format(timestamp,'%D of %M,%Y') as date from status_here where user_id = $user_id order by id desc";
		
		// Run database query
		$result = MySQLi_Query($resid,$query1);
		
		// Counter used to create table header after first result
		$f=1;
		
		// Loop through all stored statuses
		while(($rows=MySQLi_Fetch_Row($result))==True) {
			
			$f++;
			
			// Create table heading before displaying statuses
			if($f==2) {
				echo "<tr align='center'> <td colspan='5'>Your statuses till now:-</td> </tr> <tr align='center'> <td colspan='5'><table align='center' align='center' cellspacing='5' cellpadding='5' width='100%' style='table-layout:fixed'> <col style='width:25%'> <col style='width:25%'>  <col style='width:25%'>";
				
				echo "<thead> <tr> <th> Status: </th> <th> Updated on: </th> <th> Time: </th> </tr> </thead>";
			}
			
			// Display each status record
			echo " <tbody> <tr align='center' style='border-bottom:1pt solid black'>";
			echo "<td style='word-wrap:break-word'> $rows[0] </td> <td> $rows[2] </td> <td> $rows[1] </td>";
			echo "</tr> </tbody>";
		}
		
		// Close status table
		echo "</table>";
	}
	
	// Close database connection
	MySQLi_Close($resid);
}

?>

<?php 
}
else {
	// Display message when user is not logged in
	echo "<tr align='center'> <td colspan='5'> <font color='red'> Sorry, You not Logged in! </font> Login again:- <a href='login.php'>Login</a> </td> </tr>";
}
?>

</table>

<!-- Footer section containing copyright and project information -->
<hr>
<footer style="text-align:center; font-size:12px; margin-top:20px">

	<!-- Copyright information -->
	&copy; All Rights Reserved.<br>
	
	<!-- Application name -->
	Social Media Application (SMA) <br>
	
	<!-- Original project credit -->
	Based on the Simple PHP MySQL Project by abhn.<br>
	
	<!-- Github source link -->
	Original Project:
	<a href="https://github.com/abhn/simple-php-mysql-project" target="_blank">
		https://github.com/abhn/simple-php-mysql-project
	</a><br>
	
	<!-- License information -->
	Licensed under the MIT License. See the LICENSE file included with this project.

</footer>

</body>
</html>		





<?php
// Include the database connection file
require_once 'mysql.php';
?>
<!doctype html>
<html>
<head>
	<!-- Link to the external stylesheet -->
	<link rel='stylesheet' href='page_css.css'>

	<!-- Title displayed in the browser tab -->
	<title> Student's Hangout </title>
</head>
<body>
		<!-- Main table used for the page layout -->
		<table cellpadding='3' cellspacing='3' class='tab_main'>
			<!--Logo-->
			<tr>
				<td  colspan='5'><img src='images/logo.png' height='65%' width='100%' ></td> <!--1350x160-->
			</tr>

			<!-- Navigation tabs -->
			<!--Nav_Tabs-->
			<tr align='center' bgcolor='lightgrey' class='td_bor'>
				<!-- Start the session and display the correct Home link depending on login status -->
				<td width='5%'> <?php Session_start(); if(IsSet($_SESSION["user_id"])) {echo "<a href='user_page.php'>"; } else {echo "<a href='home.php'>";}?>Home </a></td>

				<!-- Navigation links -->
				<td width='5%'> <a href='send_message.php'>Send Message </a></td>
				<td width='5%'> <a href='inbox.php'>Inbox (Only Recent Message) </a></td>
				<td width='5%'> <a href='view_profile.php'>View Profile </a></td>
				<td width='5%'> <a href='signout.php'>Signout </a></td>

			</tr>

			<!-- Horizontal divider below the navigation bar -->
			<tr>
				<td> <hr> </td> 
				<td> <hr> </td> 
				<td> <hr> </td> 
				<td> <hr> </td> 
				<td> <hr> </td> 
			</tr>
<?php

	// Retrieve the logged-in user's ID from the session
	$user_id = $_SESSION["user_id"];

	// Continue only if the database connection was successful
	if($resid) {
	
	// Retrieve all friends associated with the current user
	$count = MySQLi_Query($resid,"select frnd_two_id from are_friends where frnd_one_id = $user_id union select frnd_one_id from are_friends where frnd_two_id = $user_id");

	// Display the heading for the friends list
	echo "<tr align='center'> <td colspan='5'>Your Friends:- </td> </tr> <tr align='center'> <td colspan='5'><table align='center' >";

	// Display table headers
	echo " <table align='center' cellspacing='5' cellpadding='5'> 
				<tr> <th> Name: </th> <th> Email: </th> <th> Gender: </th> </tr>";

	// Loop through each friend ID returned by the query
	while(($rows=MySQLi_Fetch_Row($count))==True) {

	// Retrieve the friend's information from the students table
	$query = "select name,email,gender from students where id = $rows[0] ";
	$result = MySQLi_Query($resid,$query);

	// Display the friend's information if the query succeeds
	if($result) {

				while(($rows=MySQLi_Fetch_Row($result))==True) {

				// Output one row for each friend
				echo "<tr align='center'>";
				echo "<td> $rows[0] </td> <td> $rows[1] </td> <td> $rows[2] </td>";
				echo "</tr>";
				}

		}
	}

	// Close the friends table
	echo "</table> ";
}

?>
		</table>

			<!-- Divider between the page content and footer -->
			<hr>

			<!-- Website footer -->
			<footer style="text-align:center; font-size:12px; margin-top:20px">
				&copy; All Rights Reserved.<br>
				Social Media Application (SMA) <br>
				Based on the Simple PHP MySQL Project by abhn.<br>

				<!-- Link to the original project -->
				Original Project:
				<a href="https://github.com/abhn/simple-php-mysql-project" target="_blank">
					https://github.com/abhn/simple-php-mysql-project
				</a><br>

				<!-- License information -->
				Licensed under the MIT License. See the LICENSE file included with this project.
			</footer>
</body>
</html>
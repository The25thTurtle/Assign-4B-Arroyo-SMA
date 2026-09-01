<?php
// Start the session to access logged-in user information
session_start();
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
		<!-- Main table used for page layout -->
		<table cellpadding='3' cellspacing='3' class='tab_main'>

			<!--Logo-->
			<tr>
				<td  colspan='5'><img src='images/logo.png' height='65%' width='100%' ></td> <!--1350x160-->
			</tr>

			<!-- Navigation menu -->
			<!--Nav_Tabs-->
			<tr align='center' bgcolor='lightgrey' class='td_bor'>
				<!-- Display different Home link depending on login status -->
				<td width='5%'> <?php if(IsSet($_SESSION["user_id"])) {echo "<a href='user_page.php'>"; } else {echo "<a href='home.php'>";}?>Home </a></td>
				<td width='5%'> <a href='send_message.php'>Send Message </a></td>
				<td width='5%'> <a href='inbox.php'>Inbox (Only Recent Message)</a></td>
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
			// Check if a user is currently logged in
			if(IsSet($_SESSION["user_id"])) {

				// Store the current user's ID
				$id=$_SESSION["user_id"];

				// Query to retrieve the latest message received by the user
				$query="select * from messages where receiver_id=".$id." order by id desc";

				// Connect to the MySQL database
				$resid=MySQLi_Connect('localhost','aarroy10','25thTurtle@1203','aarroy10_db');

				// Display an error if database connection fails
				if(MySQLi_Connect_Errno()) {
					echo "<tr align='center'> <td colspan='5'> Failed to connect to MySQL </td> </tr>";
				}
				else {

				// Execute the message query
				$result=MySQLi_Query($resid,$query);

				// Retrieve the message data
				$data=MySQLi_Fetch_Row($result);

				// Retrieve the sender's information
				$query="select name,email from students where id=".$data[1]."";
				$sender=MySQLi_Query($resid,$query);
				$sender=MySQLi_Fetch_Row($sender);

				// Check if a message exists
				if($data) {

				// Display the message information
				echo "<tr align='center'> <td colspan='5'> <table cellpadding='4' cellspacing='5' width='100%' style='table-layout:fixed'> <col width='100%'> ";

				// Display sender information
				echo "<td>From:- <font color='blue'>".$sender[0]." </font> [".$sender[1]."] </td> </tr>";

				// Display message content
				echo "<tr> <td style='word-wrap:break-word'>Message:-".$data[3]."</td> </tr>";

				echo "</table> </td> </tr>";
				
			}
				else {

				// Display message when inbox is empty
				echo "<tr align='center'> <td colspan='5'> <font color='lightblue'> No Messages! </font> </td> </tr>";

				}

				// Close database connection
				MySQLi_Close($resid);

				}
			}
			else {

				// Display login message for users who are not authenticated
				echo "<tr align='center'> <td colspan='5'> <font color='red'> Sorry, You not Logged in! </font> Login again:- <a href='login.php'>Login</a> </td> </tr>";

			}

			?>

		</table>

			<!-- Divider between content and footer -->
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
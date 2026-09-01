<!doctype html>
<html>
<head>

	<!-- Link external CSS stylesheet -->
	<link rel='stylesheet' href='page_css.css'>

	<!-- Browser page title -->
	<title> Student's Hangout </title>

</head>

<body>

		<!-- Main page layout table -->
		<table cellpadding='3' cellspacing='3' class='tab_main'>


			<!-- Logo section -->
			<tr>

				<td  colspan='5'>

					<!-- Display website logo image -->
					<img src='images/logo.png' height='65%' width='100%' >

				</td>

			</tr>


			<!-- Navigation menu tabs -->
			<tr align='center' bgcolor='lightgrey' class='td_bor'>


				<!-- Home page link -->
				<td width='5%'> 
					<a href='home.php'>Home </a>
				</td>


				<!-- Send message page link -->
				<td width='5%'> 
					<a href='send_message.php'>Send Message </a>
				</td>


				<!-- Inbox page link -->
				<td width='5%'> 
					<a href='inbox.php'>Inbox (Only Recent Message)</a>
				</td>


				<!-- Profile page link -->
				<td width='5%'> 
					<a href='view_profile.php'>View Profile </a>
				</td>


				<!-- Logout page link -->
				<td width='5%'> 
					<a href='signout.php'>Signout </a>
				</td>


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

			// Start session to access current user information
			Session_start();


			// Check if user is currently logged in
			if(IsSet($_SESSION["user_id"])) {


					// Remove all session variables
					session_unset();


					// Destroy the current session
					session_destroy();
					
					
					// Display successful logout message
					echo "<tr align='center'> <td colspan='5'> <font color='green'> Logged out Successfully! </font> Login again:- <a href='login.php'>Login</a> </td> </tr>";


					// Check if session still exists
					if(IsSet($_SESSION['user_id'])) {


						// Empty block if session still exists

					}


					else {


						// Redirect user back to home page after logout
						Header("Location: home.php");

					}


				}


				// If no user session exists
				else {


					// Display message that user is not logged in
					echo "<tr align='center'> <td colspan='5'> <font color='red'> Sorry, You not Logged in! </font> Login again:- <a href='login.php'>Login</a> </td> </tr>";


				}

			?>


		</table>


			<!-- Footer section -->
			<hr>


			<footer style="text-align:center; font-size:12px; margin-top:20px">


				<!-- Copyright information -->
				&copy; All Rights Reserved.<br>


				<!-- Application name -->
				Social Media Application (SMA) <br>


				<!-- Original project reference -->
				Based on the Simple PHP MySQL Project by abhn.<br>


				<!-- Original GitHub project link -->
				Original Project:

				<a href="https://github.com/abhn/simple-php-mysql-project" target="_blank">

					https://github.com/abhn/simple-php-mysql-project

				</a><br>


				<!-- License information -->
				Licensed under the MIT License. See the LICENSE file included with this project.


			</footer>


</body>
</html>
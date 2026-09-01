<?php
// Enable PHP error reporting for debugging purposes
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

	<script type='text/javascript'>
		// Validate the search form before submitting
		function sec() {
			var f_search=document.f1.search.value;

			// Check if the search field is empty
			if(f_search==0) {
				s1.innerHTML="<font color='red'>Field is Required</font>";
			}

			// Check if the search text exceeds the maximum length
			else if(f_search.length>50) {
				s2.innerHTML="<font color='red'>Characters should be less than 50 </font>";
			}

			// Submit the form if validation passes
			else {
				document.f1.submit();
			}

		}
		</script>
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
				<td width='5%'>
				<?php
				// Display the appropriate Home link based on login status
				if (isset($_SESSION["user_id"])) {
    					echo "<a href='user_page.php'>Home</a>";
				} 
				else {
   					 echo "<a href='home.php'>Home</a>";
				}
				?>
				</td>				
				<td width='5%'> <a href='send_message.php'>Send Message </a></td>
				<td width='5%'> <a href='inbox.php'>Inbox (Only Recent Message) </a></td>
				<td width='5%'> <a href='view_profile.php'>View Profile </a></td>
				<td width='5%'> <a href='signout.php'>Signout </a></td>

			</tr>

			<!-- Horizontal divider below the navigation menu -->
			<tr>
				<td> <hr> </td> 
				<td> <hr> </td> 
				<td> <hr> </td> 
				<td> <hr> </td> 
				<td> <hr> </td> 
			</tr>

				<!-- Friend search form -->
				<tr align='center'> 
				<td colspan='5'>
					<form method='POST' name='f1' action='search_friends.php'>
						<table>
							<tr>
								<!-- Search input field -->
								<td> Search Friend:- </td> <td> <input type='text' name='search' maxlength='50'> </td> <td> <span id='s1'> </span> </td> <td> <span id='s2'> </span> </td>
							</tr>
							<tr>
								<!-- Search button -->
								<td colspan='4' align='center'> <br> <input type='button' value='Search' onclick='sec()'> </td>
							</tr>
						</table>
					</form>
						</td>
				</tr>

			<?php
			// Check if the user is logged in
			if(IsSet($_SESSION["user_id"])) {

					// Get the current user's ID
					$id=$_SESSION["user_id"];

					// Retrieve pending friend requests for the user
					$query="select friend_name,friend_id from friends where receiver_id=".$id." and status=0 and comp=0";

					// Connect to the database
					$resid=MySQLi_Connect('localhost','aarroy10','25thTurtle@1203','aarroy10_db');

					// Display an error if the database connection fails
					if(MySQLi_Connect_Errno()) {
						echo "<tr align='center'> <td colspan='5'> Failed to connect to MySQL </td> </tr>";
					}
					else {

						// Execute the friend request query
						$result=MySQLi_Query($resid,$query);

						if($result==true) {
							$f=1;

							// Display each pending friend request
							while(($rows=MySQLi_Fetch_Row($result))==True) {
							$f++;

							// Display the Friend Requests heading only once
							if($f==2) {
							echo "<tr align='center'> <td colspan='5'>Friend Requests:-</td> </tr>";
							}

							// Display Accept and Decline buttons for each request
							echo "<tr align='center'> <td colspan='5'>".$rows[0].", wants to be your friend! <form method='POST' action='access.php'>
							<input type='hidden' name='header1' value='".$rows[1]."'>
							<input type='submit' name='accp' value='Accept'> &nbsp;&nbsp;&nbsp; <input type='submit' name='decl' value='Decline'>
							</form></td> </tr>";

							}

						}

						// Display a message if there are no pending friend requests
						if($f<2)
						{
							echo "<tr align='center'> <td colspan='5'><font color='lightblue'> No Friend Requests!</font> </td> </tr>";
						}

						// Close the database connection
						MySQLi_Close($resid);	
					}

			}
			else {

				// Display a message if the user is not logged in
				echo "<tr align='center'> <td colspan='5'> <font color='red'> Sorry, You not Logged in! </font> Login again:- <a href='login.php'>Login</a> </td> </tr>";
			}
			?>

		</table>

			<!-- Divider between page content and footer -->
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
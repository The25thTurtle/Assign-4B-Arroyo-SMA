<?php

// Start the user session to access logged-in user information
session_start();

?>

<!doctype html>
<html>
<head>
	<!-- Link external CSS stylesheet -->
	<link rel='stylesheet' href='page_css.css'>

	<!-- Page title shown in browser tab -->
	<title> Student's Hangout </title>
</head>

<body>

		<!-- Main page table layout -->
		<table cellpadding='3' cellspacing='3' class='tab_main'>

			<!-- Logo section -->
			<tr>
				<td colspan='5'>
					<img src='images/logo.png' height='65%' width='100%' >
				</td>
			</tr>


			<!-- Navigation tabs -->
			<tr align='center' bgcolor='lightgrey' class='td_bor'>

				<!-- Changes Home link depending on login status -->
				<td width='5%'> 
					<?php 
					if(IsSet($_SESSION["user_id"])) {
						echo "<a href='user_page.php'>";
					} 
					else {
						echo "<a href='home.php'>";
					}
					?>
					Home </a>
				</td>

				<!-- Navigation links -->
				<td width='5%'> <a href='send_message.php'>Send Message </a></td>
				<td width='5%'> <a href='inbox.php'>Inbox (Only Recent Message) </a></td>
				<td width='5%'> <a href='view_profile.php'>View Profile </a></td>
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

			// Restart session before checking user information
			Session_start(); 

			// Check if a user is currently logged in
			if(IsSet($_SESSION["user_id"])) {

				// Check if the search form submitted a value
				if(IsSet($_POST["search"])) {

					// Store the search input entered by the user
					$name=$_POST["search"];

					// Search students by matching name or email
					$query="select * from students where name like '%".$name."%' or email like '%".$name."%'";


					// Connect to database
					$resid=MySQLi_Connect('localhost','aarroy10','25thTurtle@1203','aarroy10_db');


					// Variables used for tracking friend request status
					$flo = 0;
					$flori =0;


					// Check database connection
					if(MySQLi_Connect_Errno()) {

						// Display connection error message
						echo "<tr align='center'> <td colspan='5'> Failed to connect to MySQL </td> </tr>";

					}

					else {

						// Execute student search query
						$result=MySQLi_Query($resid,$query);


						// Check if search returned results
						if($result==true) {

							// Counter used to determine if results exist
							$f=1;


							// Loop through all matching students
							while(($rows=MySQLi_Fetch_Row($result))==True) {

							$f++;


							// Display search results header after first result
							if($f==2) {

							echo "<tr align='center'> 
							<td colspan='5'>Search Results:-</td> 
							</tr> 
							<tr align='center'> 
							<td colspan='5'>
							<table align='center' >";

							}


							// Check if a previous friend request exists
							$query4="select status, comp from friends where id=(select max(id) from friends where receiver_id=".$rows[0]." and friend_id=".$_SESSION["user_id"].")";


							$result4=MySQLi_Query($resid,$query4);


							if($result4==true) {

								// Store friend request information
								$res4=MySQLi_Fetch_Row($result4);

							}


							// Determine friend request status
							if (!isset($res4) || ($res4[0]==NULL && $res4[1]==NULL)) {

								$flo=0;

							}
							else if($res4[0]==0 && $res4[1]==0){  

								$flo=1;

							}
							else {

								$flo=2;

							}


							// Check if users are already friends
							$query2="select status from are_friends where frnd_one_id=".$_SESSION["user_id"]." and frnd_two_id=".$rows[0]."";

							$query3="select status from are_friends where frnd_one_id=".$rows[0]." and frnd_two_id=".$_SESSION["user_id"]."";


							// Execute friendship checks
							$result2=MySQLi_Query($resid,$query2);
							$result3=MySQLi_Query($resid,$query3);


							// Store friendship results
							if($result2==true) {
								$res2=MySQLi_Fetch_Row($result2);
							} 

							if($result3==true) {
								$res3=MySQLi_Fetch_Row($result3);
							}


							// Prevent sending request to yourself
							if($rows[0]==$_SESSION["user_id"]) {
								$flori=1;
							} 
							else {
								$flori=2;
							}


							// Only display Send Request button when allowed
							if($res2[0]==1 || $res3[0]==1 || $flo==1 || $flori==1) {

							}

							else {

							// Display user and send friend request option
							echo "<tr align='center'> <td align='left'>".$rows[1]."</td> <td align='left'> <form method='POST' action='sendfr.php'>
							<input type='hidden' name='h1' value='".$rows[0]."'>
							<input type='hidden' name='h2' value='".$rows[1]."'>
							<input type='submit' name='sfr' value='Send Request'>
							</form></td> </tr>";

							}

							}

						}


						// Close results table
						echo "</table></td></tr>";


						// Display message if no users were found
						if($f<2)
						{
							echo "<tr align='center'> <td colspan='5'><font color='lightblue'> No such Friends!</font> </td> </tr>";
						}


						// Close database connection
						MySQLi_Close($resid);

					}

				}

			}

			else {

				// Display login warning when user is not logged in
				echo "<tr align='center'> 
				<td colspan='5'> 
				<font color='red'> Sorry, You not Logged in! </font> 
				Login again:- <a href='login.php'>Login</a> 
				</td> 
				</tr>";

			}

			?>

		</table>


		<hr>


		<!-- Footer section -->
		<footer style="text-align:center; font-size:12px; margin-top:20px">
			&copy; All Rights Reserved.<br>
			Social Media Application (SMA) <br>
			Based on the Simple PHP MySQL Project by abhn.<br>
			Original Project:
			<a href="https://github.com/abhn/simple-php-mysql-project" target="_blank">
				https://github.com/abhn/simple-php-mysql-project
			</a><br>
			Licensed under the MIT License. See the LICENSE file included with this project.
		</footer>


</body>
</html>
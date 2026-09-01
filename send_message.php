<!doctype html>
<html>
<head>

	<!-- Link to external CSS stylesheet -->
	<link rel='stylesheet' href='page_css.css'>

	<!-- Page title shown in browser tab -->
	<title> Student's Hangout </title>
	
	<!-- Load jQuery library for JavaScript functions -->
	<script src='jquery.js'></script>

	<script type='text/javascript'>

		// Function used to validate the send message form before submitting
		function sec() {

			// Get friend's email entered by user
			var f_email=document.f1.n1.value;

			// Get message entered by user
			var f_message=document.f1.t1.value;

			// Remove extra spaces from beginning and end of message
			f_message = f_message.trim();
			
			// Check if email field is empty
			if(f_email.length==0) {

				// Display required field message
				s1.innerHTML="<font color='red'>Field is Required</font>";

			}

			// Check if message field is empty
			else if(f_message.length==0) {

				// Display message required warning
				s1.innerHTML="<font color='red'>Please add some message</font>";

			}
			
			// Check maximum character limits
			else if(f_email.length>50||f_message.length>500) {

				// Check email length
				if(f_email.length>50) {

					// Display email length warning
					s2.innerHTML="<font color='red'>Characters should be less than 50 </font>";

				}
			
				// Check message length
				if(f_message.length>500) {

					// Display message length warning
					s3.innerHTML="<font color='red'>Characters should be less than 500 </font>";

				}
			
			}
			
			// If all validation checks pass, submit the form
			else {

				document.f1.submit();

			}
		}
		
		// jQuery function runs after page loads
		$(document).ready(function() 
		{

			// Hide element with id "sam" after 2 seconds
			$("#sam").hide(2000);

		});
		
	</script>
	
</head>

<body>

	<!-- Main table used for page layout -->
	<table cellpadding='3' cellspacing='3' class='tab_main'>

		<!-- Website logo section -->
		<tr>

			<td colspan='5'>

				<!-- Display application logo -->
				<img src='images/logo.png' height='65%' width='100%' >

			</td>

		</tr>

		<!-- Navigation menu -->
		<tr align='center' bgcolor='lightgrey' class='td_bor'>

			<!-- Home link changes depending on login status -->
			<td width='5%'> 
				<?php 

				// Start session to check logged-in user
				Session_start(); 

				// If user is logged in, go to user page, otherwise home page
				if(IsSet($_SESSION["user_id"])) {

					echo "<a href='user_page.php'>"; 

				} else {

					echo "<a href='home.php'>";

				}

				?>

				Home </a>

			</td>

			<!-- Link to send message page -->
			<td width='5%'> 
				<a href='send_message.php'>Send Message </a>
			</td>

			<!-- Link to inbox page -->
			<td width='5%'> 
				<a href='inbox.php'>Inbox (Only Recent Message)</a>
			</td>

			<!-- Link to profile page -->
			<td width='5%'> 
				<a href='view_profile.php'>View Profile </a>
			</td>

			<!-- Link to logout page -->
			<td width='5%'> 
				<a href='signout.php'>Signout </a>
			</td>

		</tr>			
			<!-- Horizontal line separator below navigation -->
			<tr>

				<td> <hr> </td> 
				<td> <hr> </td> 
				<td> <hr> </td> 
				<td> <hr> </td> 
				<td> <hr> </td> 

			</tr>


			<?php

			// Start session to check if user is logged in
			Session_start();

			// Check if a user session exists
			if(IsSet($_SESSION["user_id"])) {

			
			
			?>

			<!-- Message sending form section -->
			<tr align='center'> 

				<td colspan='5'>

					<!-- Form submits message information using POST method -->
					<form method='POST' name='f1' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>

						<table>

							<!-- Friend email input -->
							<tr>

								<td> Friend's Email:- </td> 

								<td> 
									<input type='email' name='n1' maxlength='50'> 
								</td> 

								<!-- Displays required field errors -->
								<td> 
									<span id='s1'> </span> 
								</td> 

								<!-- Displays character limit errors -->
								<td> 
									<span id='s2'> </span> 
								</td>

							</tr>


							<!-- Message text area input -->
							<tr>

								<td> Message:- </td> 

								<td> 
									<textarea rows='5' cols='22' maxlength='500' name='t1'> </textarea> 
								</td> 

								<!-- Displays message length errors -->
								<td> 
									<span id='s3'> </span> 
								</td> 

								<td> 
									<span id='s4'> </span> 
								</td>

							</tr>
							
							
							<!-- Submit button -->
							<tr>

								<td> 
									<br> 
									<input type='button' value='Send' onclick='sec()'> 
								</td>

							</tr>

						</table>

					</form>

				</td>

			</tr>
			
			
			<?php
			
				// Check if the form was submitted
				if($_SERVER["REQUEST_METHOD"]=="POST") {


				// Variables used to store email and message
				$email=$text="";


				// Security function to clean user input
				function sec($data) {

					// Remove spaces
					$data=trim($data);

					// Remove escape characters
					$data=stripslashes($data);

					// Convert special characters to HTML entities
					$data=htmlspecialchars($data);

					return $data;

				}


				// Sanitize submitted email
				$email=sec($_POST["n1"]);

				// Sanitize submitted message
				$text=sec($_POST["t1"]);


				// Connect to MySQL database
				$resid=MySQLi_Connect('localhost','aarroy10','25thTurtle@1203','aarroy10_db');


					// Check if database connection failed
					if(MySQLi_Connect_Errno()) {

						echo "<tr align='center'> <td colspan='5'> Failed to connect to MySQL </td> </tr>";

					}

					else {


						// Find the receiver's user ID using their email
						$count=MySQLi_Query($resid,"select id from students where email='".$email."'");


						// Store returned user information
						$count_id=MySQLi_Fetch_Assoc($count);


						// Check if receiver exists
						if($count_id) {


						// Store receiver ID
						$receiver=$count_id["id"];


						// Store sender ID from current session
						$sender=$_SESSION["user_id"];


						// Find next available message ID
						$count=MySQLi_Query($resid,"select (max(id)+1) as count  from messages");


						// Store next message ID
						$count_id=MySQLi_Fetch_Assoc($count);


						// Create insert query with generated ID
						if($count_id["count"]) {

						$query="insert into messages values (".$count_id["count"].",".$sender.",".$receiver.",'$text')";

						}

						// If table is empty, start ID at 1
						else {

						$query="insert into messages values (1,".$sender.",".$receiver.",'$text')";

						}


						// Execute message insertion query
						$res=MySQLi_Query($resid,$query);
						
						// Check if message was successfully inserted into database
						if($res) {

							?>

						<!-- Load Notify.js library for popup notifications -->
						<script type="text/javascript" src="notify.js"></script>

						<script>

						// Run notification after page loads
						$(document).ready(function() {


						  // Display success notification when message is sent
						  $.notify(

						  "Message Sent!","success");


						});

						</script>

							<?php

						}


						// If database insertion failed, display error message
						else {

							echo "<tr align='center'> <td colspan='5'> <font color='red'> Message Sending Failed! </font> </td> </tr>";

						}


						}

						// If receiver email does not exist in database
						else {

							echo "<tr align='center'> <td colspan='5'> <font color='red'> Sorry, User does not exists! </font> </td> </tr>";

						}


						// Close database connection
						MySQLi_Close($resid);


					}


			
			}

			?>


			
			<?php 

			}

			// If user is not logged in, display login message
			else {

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


			<!-- Original project information -->
			Based on the Simple PHP MySQL Project by abhn.<br>


			<!-- Link to original GitHub repository -->
			Original Project:

			<a href="https://github.com/abhn/simple-php-mysql-project" target="_blank">

				https://github.com/abhn/simple-php-mysql-project

			</a><br>


			<!-- License information -->
			Licensed under the MIT License. See the LICENSE file included with this project.

		</footer>


</body>

</html>
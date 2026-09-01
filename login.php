<!doctype html>
<html>
<head>
	<!-- Link to the external stylesheet -->
	<link rel='stylesheet' href='page_css.css'>

	<!-- Title displayed in the browser tab -->
	<title> Student's Hangout </title>

	<script type='text/javascript'>

		// Function used to validate the login form before submission
		function sec() {

			// Retrieve email and password values from the form
			var email=document.f1.e1.value;
			var password=document.f1.p1.value;
			
			// Check if either email or password fields are empty
			if(email.length==0||password.length==0) {

				// Display error message if email field is empty
				if(email.length==0) {
				s1.innerHTML="<font color='red'>Field is Required</font>";
				
				}

				// Display error message if password field is empty
				if(password.length==0) {
				s2.innerHTML="<font color='red'>Field is Required</font>";
				
				}
			}

			// Check if email or password exceeds the maximum character limit
			else if (email.length>50||password.length>50) {

				// Display error message if email is too long
				if(email.length>50) {
				s3.innerHTML="<font color='red'>Characters should be less than 50 </font>";
				
				}

				// Display error message if password is too long
				if(password.length>50) {
				s4.innerHTML="<font color='red'>Characters should be less than 50 </font>";
				
				}
			}

			// Submit the form when all validation checks pass
			else {
				document.f1.submit();
			}
			
			
			
						
			
		}
	</script>
</head>
<body>
		<!-- Main table used for page layout -->
		<table cellpadding='3' cellspacing='3' class='tab_main'>

			<!-- Website logo -->
			<!--Logo-->
			<tr>
				<td  colspan='5'><img src='images/logo.png' height='65%' width='100%' ></td> <!--1350x160-->
			</tr>

			<!-- Navigation menu -->
			<!--Nav_Tabs-->
			<tr align='center' bgcolor='lightgrey' class='td_bor'>
				<td width='5%'> <a href='home.php'> Home </a></td>
				<td width='5%'> <a href='login.php'>Login </a></td>
				<td width='5%'> <a href='secure_signup.php'>Sign-up </a></td> 
				<td width='5%'> <a href='contact-us.html'>Contact-Us </a></td>
				<td width='5%'> <a href='about-us.html'>About-us </a></td>
			</tr>

			<!-- Divider below the navigation menu -->
			<tr>
				<td> <hr> </td> 
				<td> <hr> </td> 
				<td> <hr> </td> 
				<td> <hr> </td> 
				<td> <hr> </td> 
			</tr>

			<!-- Login form section -->
			<tr align='center'> 
				<td colspan='5'>

					<!-- Form sends login information to user_page.php -->
					<form method='POST' name='f1' action='user_page.php'>

						<table>

							<!-- Email input field -->
							<tr>
								<td> Email:- </td> <td> <input type='email' name='e1' maxlength='50'> </td> <td> <span id='s1'> </span> </td>  <td> <span id='s3'> </span> </td>
							</tr>

							<!-- Password input field -->
							<tr>
								<td> Password:- </td> <td> <input type='password' name='p1' maxlength='50'> </td> <td> <span id='s2'> </span> </td> <td> <span id='s4'> </span> </td>
							</tr>

							<!-- Hidden field used to pass additional form information -->
							<tr>
								<td> </td> <td> <input type='hidden' name='h1' value='holla'>  </td>
							</tr>

							<!-- Login button and sign-up link -->
							<tr>
								<td> <br> <input type='button' value='Login' name='s1' onclick='sec()'> </td> <td> <br> OR <a href='secure_signup.php'>Sign-up</a></td> 
							</tr>

						</table>

					</form>

				</td>
			</tr>

		</table>
</body>
</html>

<?php
// Include the shared footer for the website
include 'footer.php';
?>
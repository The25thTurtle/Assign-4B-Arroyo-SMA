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

			<!-- Navigation menu -->
			<!--Nav_Tabs-->
			<tr align='center' bgcolor='lightgrey' class='td_bor'>
				<td width='5%'> <a href='home.php'> Home </a></td>
				<td width='5%'> <a href='login.php'>Login </a></td>
				<td width='5%'> <a href='secure_signup.php'>Sign-up </a></td> 
				<td width='5%'> <a href='contact-us.html'>Contact-Us </a></td>
				<td width='5%'> <a href='about-us.html'>About-us </a></td>
			</tr>

			<!-- Horizontal divider below the navigation bar -->
			<tr>
				<td> <hr> </td> 
				<td> <hr> </td> 
				<td> <hr> </td> 
				<td> <hr> </td> 
				<td> <hr> </td> 
			</tr>

			<!-- Welcome section displayed on the home page -->
			<tr>

				<td colspan='5'> 
					<div class="Welcome">
					  	<h3>Welcome to Socioexplore</h3>
					</div>	
				</td>

			</tr>

		</table>
</body>
</html>

<?php
// Include the shared footer for the website
include 'footer.php';
?>
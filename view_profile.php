<?php

// Start session to access stored user information
session_start();

require_once 'mysql.php';


// Get major and bio from database
if(IsSet($_SESSION["user_id"])) {

	$user_id = $_SESSION["user_id"];

	$query = "SELECT major, bio FROM students WHERE id=$user_id";

	$result = MySQLi_Query($resid,$query);

	if($result) {

		$profile = MySQLi_Fetch_Assoc($result);

		$major = $profile["major"];
		$bio = $profile["bio"];

	}

}

?>

<!doctype html>
<html>

<head>

	<!-- Link external CSS stylesheet -->
	<link rel='stylesheet' href='page_css.css'>
	
	<!-- Browser page title -->
	<title> Student's Hangout </title>

</head>


<body>


<table cellpadding='3' cellspacing='3' class='tab_main'>


	<tr>
		<td colspan='5'>
			<img src='images/logo.png' height='65%' width='100%'>
		</td>
	</tr>



	<tr align='center' bgcolor='lightgrey' class='td_bor'>


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


		<td width='5%'> 
			<a href='send_message.php'>Send Message</a>
		</td>


		<td width='5%'> 
			<a href='inbox.php'>Inbox (Only Recent Message)</a>
		</td>


		<td width='5%'> 
			<a href='view_profile.php'>View Profile</a>
		</td>


		<td width='5%'> 
			<a href='signout.php'>Signout</a>
		</td>


	</tr>



	<tr>
		<td><hr></td>
		<td><hr></td>
		<td><hr></td>
		<td><hr></td>
		<td><hr></td>
	</tr>




<?php


if(IsSet($_SESSION["user_id"])) {


	echo "

<tr>
<td colspan='5' align='center'>


<table align='center'>


<tr align='center'>
	<td align='right'>Name:- </td>
	<td align='left'>".$_SESSION["name"]."</td>
</tr>



<tr align='center'>
	<td align='right'>Email:- </td>
	<td align='left'>".$_SESSION["email"]."</td>
</tr>



<tr align='center'>
	<td align='right'>Gender:- </td>
	<td align='left'>".$_SESSION["gender"]."</td>
</tr>



<tr align='center'>
	<td align='right'>Age:- </td>
	<td align='left'>".$_SESSION["age"]."</td>
</tr>


<tr align='center'>
	<td align='right'>Major:- </td>
	<td align='left'>".$major."</td>
</tr>



<tr align='center'>
	<td align='right'>About Me:- </td>
	<td align='left'>".$bio."</td>
</tr>



<tr align='center'>
	<td align='right'>Password:- </td>
	<td align='left'>".$_SESSION["password"]."</td>
</tr>



<tr align='center'>
	<td colspan='2'>
	
		<form action='edit_profile.php' method='POST'>
		
			<input type='submit' value='Edit Profile'>
			
		</form>
		
	</td>
</tr>



</table>


</td>
</tr>


";


}

else {


	echo "

<tr align='center'>

<td colspan='5'>


<font color='red'> 
Sorry, You are not logged in!
</font>


Login again:
<a href='login.php'>Login</a>


</td>

</tr>";

}


?>


</table>



<hr>



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
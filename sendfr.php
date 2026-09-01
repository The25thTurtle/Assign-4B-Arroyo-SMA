<?php

// Start user session to access logged-in user information
Session_Start();


// Check if user is currently logged in
if(IsSet($_SESSION["user_id"])) {


	// Get receiver ID from hidden form input
	$recv_id=$_POST["h1"];

	// Get receiver name from hidden form input
	$recv_name=$_POST["h2"];

	// Get current logged-in user's ID
	$frnd_id=$_SESSION["user_id"];

	// Get current logged-in user's name
	$frnd_name=$_SESSION["name"];



			// Connect to MySQL database
			$resid=MySQLi_Connect('localhost','aarroy10','25thTurtle@1203','aarroy10_db');


			// Check if database connection failed
			if(MySQLi_Connect_Errno()) {

				// Display connection error message
				echo "<tr align='center'> <td colspan='5'> Failed to connect to MySQL </td> </tr>";

			}

			else {


				// Find the next available ID for the friends table
				$count=MySQLi_Query($resid,"select (max(id)+1) as count from friends");


				// Store the generated ID value
				$count_id=MySQLi_Fetch_Assoc($count);


				// If records already exist, use next available ID
				if($count_id["count"]) {


				// Insert new friend request into friends table
				$query="insert into friends values (".$count_id["count"].",'$recv_id','$recv_name',$frnd_id,'$frnd_name',0,0)";


				}


				// If table is empty, start ID at 1
				else {


				// Insert first friend request record
				$query="insert into friends values (1,'$recv_id','$recv_name',$frnd_id,'$frnd_name',0,0)";


				}


				// Execute database insert query
				$res=MySQLi_Query($resid,$query);
				
				
				// Check if friend request was added successfully
				if($res) {

			     // Display success message
			     echo "Successful!";

				}


			// If insert failed, display failure message
			else {

				 echo "Failed!";

			}


				// Close database connection
				MySQLi_Close($resid);

			}

}


// Redirect user based on login status
if(IsSet($_SESSION['user_id'])) {


	// Redirect logged-in users back to friends page
	Header("Location: friends.php");

}

else {


	// Redirect non-logged-in users to home page
	Header("Location: home.php");

}

?>
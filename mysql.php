<?php

// Establish a connection to the MySQL database
$resid=MySQLi_Connect('localhost','aarroy10','25thTurtle@1203','aarroy10_db');

// Check if there was an error while connecting to the database
					if(MySQLi_Connect_Errno()) {

						// Display an error message if the database connection fails
						echo "<tr align='center'> <td colspan='5'> Failed to connect to MySQL </td> </tr>";
					}
					else {

						// Continue execution if the database connection is successful
					}

?>
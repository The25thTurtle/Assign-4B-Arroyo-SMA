<?php

// Start the current session to access logged-in user information
Session_Start();

// Variable to track the user's action
// 0 = No action
// 1 = Accept friend request
// 2 = Decline friend request
$f = 0;

// Retrieve the friend's ID from the submitted form
$frnd_id = $_POST["header1"];

// Check whether the user clicked Accept or Decline
if (IsSet($_POST["accp"]) || IsSet($_POST["decl"])) {

    // Determine which button was pressed
    if (IsSet($_POST["accp"])) {
        $f = 1;
    }
    else {
        $f = 2;
    }

    // Continue only if the user is logged in
    if (IsSet($_SESSION["user_id"])) {

        // Connect to the MySQL database
        $resid = MySQLi_Connect('localhost','aarroy10','25thTurtle@1203','aarroy10_db');

        // Display an error if the database connection fails
        if (MySQLi_Connect_Errno()) {
            echo "<tr align='center'> <td colspan='5'> Failed to connect to MySQL </td> </tr>";
        }
        else {

            // Accept the friend request
            if ($f == 1) {

                // Update the pending request as accepted and completed
                $query = "update friends set status=1,comp=1 where receiver_id=".$_SESSION["user_id"]." and friend_id=".$frnd_id."";
                $walla1 = MySQLi_Query($resid, $query);

                // Find the next available ID for the are_friends table
                $count = MySQLi_Query($resid, "select (max(id)+1) as count from are_friends");
                $count_id = MySQLi_Fetch_Assoc($count);

                // If records already exist, continue incrementing IDs
                if ($count_id["count"]) {

                    // Create friendship entry for both users
                    $query1 = "insert into are_friends values (".$count_id["count"].",".$_SESSION["user_id"].",".$frnd_id.",1,0)";
                    $c = $count_id["count"] + 1;
                    $query2 = "insert into are_friends values (".$c.",".$frnd_id.",".$_SESSION["user_id"].",1,0)";

                    $walla = MySQLi_Query($resid, $query1);
                    $walla = MySQLi_Query($resid, $query2);
                }
                else {

                    // If this is the first friendship record, start IDs at 1
                    $query1 = "insert into are_friends values (1,".$_SESSION["user_id"].",".$frnd_id.",1,0)";
                    $query2 = "insert into are_friends values (2,".$frnd_id.",".$_SESSION["user_id"].",1,0)";

                    $walla = MySQLi_Query($resid, $query1);
                    $walla = MySQLi_Query($resid, $query2);
                }
            }

            // Decline the friend request
            else if ($f == 2) {

                // Update the request as declined and completed
                $query = "update friends set status=0,comp=1 where receiver_id=".$_SESSION["user_id"]." and friend_id=".$frnd_id."";
                MySQLi_Query($resid, $query);
            }

            // No valid action selected
            else {
            }
        }

        // Close the database connection
        MySQLi_Close($resid);
    }
}

// Redirect the user after processing
if (IsSet($_SESSION['user_id'])) {

    // Logged-in users return to the friends page
    Header("Location: friends.php");
}
else {

    // Guests are redirected to the home page
    Header("Location: home.php");
}

?>
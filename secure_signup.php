<!doctype html>
<html>
<head>

    <!-- Connect external CSS file for page styling -->
    <link rel='stylesheet' href='page_css.css'>

    <!-- Browser page title -->
    <title> Student's Hangout </title>


    <script type='text/javascript'>

        // Function used to validate signup form fields before submission
        function sec() {

            // Get values entered by the user
            var name=document.f1.n1.value;
            var email=document.f1.e1.value;
            var age=document.f1.a1.value;
            var password=document.f1.p1.value;


            // Check if any required fields are empty
            if(name.length==0||email.length==0||age.length==0||password.length==0) {


                // Display required field messages
                if(name.length==0) s1.innerHTML="<font color='red'>Field is Required</font>";
                if(email.length==0) s2.innerHTML="<font color='red'>Field is Required</font>";
                if(age.length==0) s3.innerHTML="<font color='red'>Field is Required</font>";
                if(password.length==0) s4.innerHTML="<font color='red'>Field is Required</font>";


            // Check maximum character limits
            } else if (name.length>50||email.length>50||password.length>50) {


                // Display character limit warnings
                if(name.length>50) s5.innerHTML="<font color='red'>Max 50 chars</font>";
                if(email.length>50) s6.innerHTML="<font color='red'>Max 50 chars</font>";
                if(password.length>50) s7.innerHTML="<font color='red'>Max 50 chars</font>";


            } else {

                // Submit form when validation passes
                document.f1.submit();

            }
        }

    </script>

</head>


<body>

<!-- Main page table container -->
<table cellpadding='3' cellspacing='3' class='tab_main'>


<tr>

    <td colspan="5">


        <!-- Signup form container -->
        <div class="signup-container">


            <!-- Signup page heading -->
            <h2>Create Your Account</h2>

            <!-- Signup description -->
            <p>Join SocioExplore and start connecting today.</p>


            <!-- User registration form -->
            <form method="POST" name="f1" action="">


                <table class="signup-table">


                    <!-- Name input field -->
                    <tr>
                        <td>Name</td>
                        <td><input type="text" name="n1" maxlength="50"></td>
                    </tr>


                    <!-- Email input field -->
                    <tr>
                        <td>Email</td>
                        <td><input type="email" name="e1" maxlength="50"></td>
                    </tr>


                    <!-- Age input field -->
                    <tr>
                        <td>Age</td>
                        <td><input type="number" name="a1" min="18" max="27"></td>
                    </tr>


                    <!-- Gender selection dropdown -->
                    <tr>
                        <td>Gender</td>
                        <td>
                            <select name="g1">

                                <option value="M">Male</option>
                                <option value="F">Female</option>

                            </select>
                        </td>
                    </tr>


                    <!-- Password input field -->
                    <tr>
                        <td>Password</td>
                        <td><input type="password" name="p1" maxlength="50"></td>
                    </tr>


                    <!-- Submit registration button -->
                    <tr>
                        <td colspan="2">
                            <input type="button" value="Create Account" onclick="sec()">
                        </td>
                    </tr>


                    <!-- Link to login page -->
                    <tr>
                        <td colspan="2" class="login-link">

                            Already have an account?
                            <a href="login.php">Login</a>

                        </td>
                    </tr>


                </table>


            </form>


        </div>


    </td>

</tr>


<?php


// Check if registration form was submitted
if($_SERVER["REQUEST_METHOD"]=="POST") {


    // Function used to clean user input
    function sec($data) {

        return htmlspecialchars(trim(stripslashes($data)));

    }


    // Store and sanitize submitted form values
    $name = sec($_POST["n1"]);
    $email = sec($_POST["e1"]);
    $age = sec($_POST["a1"]);
    $gender = sec($_POST["g1"]);
    $password = password_hash($_POST["p1"], PASSWORD_DEFAULT);



    // Connect to MySQL database
    $resid = MySQLi_Connect('localhost','aarroy10','25thTurtle@1203','aarroy10_db');


    // Check database connection
    if (MySQLi_Connect_Errno()) {


        // Display database connection error
        echo "<tr><td colspan='5'>Failed to connect to MySQL</td></tr>";


    }

    else {


        // Check if email already exists in database
        $check_email = MySQLi_Query($resid,
            "SELECT name FROM students WHERE email='".$email."'"
        );


        // Retrieve matching email record
        $r_email = MySQLi_Fetch_Row($check_email);



        // Prevent duplicate account registration
        if ($r_email) {


            echo "<tr><td colspan='5'><font color='red'>Email already registered</font></td></tr>";


        } else {


            // Find next available student ID
            $count = MySQLi_Query($resid,
                "SELECT (MAX(id)+1) AS count FROM students"
            );


            // Store generated ID value
            $count_id = MySQLi_Fetch_Assoc($count);



            // Insert new student record with generated ID
            if ($count_id["count"]) {

                $query = "INSERT INTO students (id,name,email,age,gender,password) VALUES (".$count_id["count"].",'$name','$email',$age,'$gender','$password')";

            } else {

                // Insert first student record if table is empty
                $query = "INSERT INTO students VALUES (1,'$name','$email',$age,'$gender','$password')";

            }



            // Execute registration query
            $res = MySQLi_Query($resid, $query);



            // Display registration result
            if ($res) {

                echo "<tr><td colspan='5'><font color='green'>Registration Successful!</font> <a href='login.php'>Login</a></td></tr>";

            } else {

                echo "<tr><td colspan='5'><font color='red'>Registration Failed!</font></td></tr>";

            }

        }


        // Close database connection
        MySQLi_Close($resid);

    }

}

?>


</table>


</body>
</html>


<!-- Load reusable footer file -->
<?php include 'footer.php'; ?>
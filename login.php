<!-- Login -->

<!-- This is a php program where a user can log in to WITSocial. -->

<!-- Mads Degn, Daniel Pedersen, Liva Plougmann Sørensen, Magnus Østergaard -->
<!-- 08/05-25 -->

<!DOCTYPE html>
<html>
<head>
    <style>

        /* Applies styles to input type "text". */
        input[type='text'] { 
            font-size: 20px;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        /* Applies styles to input type "password". */
        input[type='password'] { 
            font-size: 20px;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        /* Applies styles to input type "submit". */
        input[type='submit'] { 
            font-size: 20px;
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            position: absolute;
            left: 50%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }

        /* Applies styles to the <div> with id "title-container". */
        .title-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
            max-width: 900px;
            padding: 10px;
        }

        /* Applies styles to the <div> with id "title". */
        .title {
            font-family: Arial, sans-serif;
            background-color: lightgrey;
            width: 300px;
            border: 7px solid black;
            padding: 2px;
            font-size: 45px;
            text-align: center;
            margin: auto;
            cursor: pointer;
        }

        /* Applies styles to the <div> with id "login". */
        #login {
            font-family: Arial, sans-serif;
            text-align: left;
            background-color: lightgrey;
            width: 400px;
            border: 7px solid black;
            padding: 50px;
            margin: auto;
            font-size: 20px;
        }

        /* Applies styles to the <div> with id "message". */
        #message {
            font-family: Arial, sans-serif;
            text-align: center;
            font-size: 20px;
            color: red;
        }

        /* Applies styles to the <div> with id "left-box". */
        .left-box {
            font-family: Arial, sans-serif;
            background-color: lightgrey;
            border: 5px solid black;
            width: 150px;
            padding: 2px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
            position: absolute;
            top: 35px;
            left: 20px;
            font-weight: bold;
        }

    </style>
</head>
<body>

    <br>

    <!-- Form to return to main "feed page" -->
    <div class="title-container">

        <?php
        echo "<form action='feed.php' method='get'>";
        echo "<button class='title' type='submit'><b>WITS</b>ocial</button>";
        echo "</form>";
        ?>

    </div>

    <!-- Division for clock top left. -->
    <div class="left-box" id="clock">00:00:00
    </div>

    <br><br>

    <?php
        require_once '/var/www/wits.ruc.dk/db.php'; // Access to WITS course API.

        session_start(); // Starts session for future use of user id and password.

        $message = ""; // Creates message variable and sets it as empty.

        // Check if post form is submitted.
        // Retrieve uid and password from submitted data. Set value as null if uid or password is not set.
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $uid = $_POST['uid'] ?? '';
            $password = $_POST['password'] ?? '';

            $_SESSION["uid"]=$uid; // Sets uid for future use.
            $_SESSION["password"]=$password; //Sets password for future use.

            // If login function returns true, redirect user to feed.php file and prevent further code execution.
            // If login function returns false, set message variable to Credentials Incorrect.
            if(login($uid, $password)) {
                header("Location: feed.php");
                exit();
            } else {
                $message = "<br><br>Credentials Incorrect";                
            }
        }
    ?>

    <!-- Creates form that is secure and submits data to current URL (same page). -->
    <div id="login">
        <form method="POST" action="">
        
            <!-- Label for user id field. -->
            <label for="uid">User ID</label>
        
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <!-- Spaces. -->
        
            <!-- Input field for user id. -->
            <input type="text" id="uid" name="uid" value="Example">
        
            <br><br>
        
            <!-- Label for password field. -->
            <label for="password">Password</label>
        
            &nbsp;&nbsp;&nbsp;&nbsp; <!-- Spaces. -->
        
            <!-- Input field for password. -->
            <input type="password" id="password" name="password" value="Example">
        
            <br>

            <div style='text-align: center;'>
            
            <!-- An element to toggle between password visibility -->
            <br>
            
            <input type="checkbox" onclick="myFunction()"> Show Password
            
            </div>

            <script>
                function myFunction() {
                    var x = document.getElementById("password");
                    if (x.type === "password") {
                        x.type = "text";
                    } else {
                        x.type = "password";
                    }
                }
            </script>

            <br><br><br>
            
            <!-- Submit button for form. -->
            <input type="submit" value="Log In">
            
        </form>
        
        <!-- Creates division with id message, creates php section and displays content of message variable. -->
        <div id="message">
            <?php 
                echo $message; 
            ?>
        </div>

        <br><br>
        
        <!-- Creates division for link to sign up. -->
        <div style="text-align: center; font-size: 18px;">
            
            Don't have an account?
            
            <a href="createUser.php">Sign up</a>
        </div>
    </div>

    <script> // JavaScript for the live-updating clock.

        // Function that updates the clock.
        function updateClock() {
            const now = new Date(); // Gets the computer's current date and time.

            // Extracts hours, minutes, and seconds, and ensures two digits ('09' instead of '9').
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            // Updates the text content of the HTML element with id="clock".
            document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds}`;
        }

        // Runs updateClock every 1000 milliseconds (1 second).
        setInterval(updateClock, 1000);

        // Runs the function once immediately so the clock doesn't start empty.
        updateClock();

    </script>

</body>
</html>
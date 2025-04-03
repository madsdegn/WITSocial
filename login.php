<!-- Login -->

<!-- Mads Degn, Daniel Pedersen, Liva Plougmann Sørensen, Magnus Østergaard -->
<!-- 13/03-25 -->

<!DOCTYPE html>
<html>
    <head>
    <style>

        /* CSS attribute selector for username field.*/
        /* Applies styles to input elements with attribute input='text'. */
        input[type='text'] { 
            font-size: 20px;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        /* CSS attribute selector for password field. */
        /* Applies styles to input elements with attribute input='password'. */
        input[type='password'] { 
            font-size: 20px;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        /* CSS attribute selector for submit button. */
        /* Applies styles to input elements with attribute input='submit'. */
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

        /* CSS selector for WITSocial logo at top of webpage. */
        /* Applies styles to the <div> with id "Title". */
        #title {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: white;
            width: 300px;
            border: 7px solid black;
            padding: 2px;
            margin: auto;
            font-size: 45px;
        }

        /* CSS selector for main login part of webpage. */
        /* Applies styles to the <div> with id "Login". */
        #login {
            font-family: Arial, sans-serif;
            text-align: left;
            background-color: white;
            width: 400px;
            border: 7px solid black;
            padding: 50px;
            margin: auto;
            font-size: 20px;
        }

        /* CSS selector for credentials incorrect message. */
        /* Applies styles to the <div> with id "message". */
        #message {
            font-family: Arial, sans-serif;
            text-align: center;
            font-size: 20px;
            color: red;
        }

    </style>
    </head>
    <body>
        
        <br>
        
        <!-- Creates division with id title and writes WITS in capital lettes followed by ocial in non-capital letters. -->
        <div id="title">
            <b>WITS</b>ocial
        </div>

        <br><br>

        <!-- php section. -->
        <?php
            require_once '/var/www/wits.ruc.dk/db.php'; // Access to WITS course API.

            session_start(); // Starts session for future use of user id and password.

            $message = ""; // Creates message variable and sets it as empty.

            // Check if form is submitted.
            // Retrieve uid and password from submitted data. Set value as null if uid or password is not set.
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $uid = $_POST['uid'] ?? '';
                $password = $_POST['password'] ?? '';

                $_SESSION["uid"]=$uid; // Sets uid for future use.
                $_SESSION["password"]=$password; //Sets password for future use.

                // If login function returns true, redirect user to secrets.php file and prevent further code execution.
                // If login function returns false, set message variable to Credentials Incorrect.
                if(login($uid, $password)) {
                    header("Location: createPost.php");
                    exit();
                } else {
                    $message = "<br><br>Credentials Incorrect";                }
            }
        ?>

        <!-- Creates division with id login. -->
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
            <input type="password" id="password" name="password" value="••••••••••">
            
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
        </div>

    </body>
</html>
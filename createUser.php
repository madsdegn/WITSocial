<!-- Create User -->

<!-- Mads Degn, Daniel Pedersen, Liva Plougmann Sørensen, Magnus Østergaard -->
<!-- 04/05-25 -->

<!DOCTYPE html>
<html>
    <head>
    <style>

        /* CSS selector for WITSocial logo at top of webpage. */
        /* Applies styles to the <div> with id "Title". */
        #title {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: lightgrey;
            width: 300px;
            border: 7px solid black;
            padding: 2px;
            margin: auto;
            font-size: 45px;
        }

        /* CSS selector for main user creation part of webpage. */
        /* Applies styles to the <div> with id "createPost". */
        #createUser {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: lightgrey;
            width: 400px;
            border: 7px solid black;
            padding: 50px;
            margin: auto;
            font-size: 20px;
        }

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

            // Check if form is submitted.
            // Retrieve title and content from submitted data. Set value as null if title or content is not set.
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $uid = $_POST['uid'] ?? '';
                $firstname = $_POST['firstname'] ?? '';
                $lastname = $_POST['lastname'] ?? '';
                $password = $_POST['password'] ?? '';

                add_user($uid, $firstname, $lastname, $password);
                header("Location: login.php"); // Sends user to login.php to log in.
                    exit();
            }
        ?>

        <!-- Creates division with id createPost. -->
        <div id="createUser">
            To sign up as a user on <b>WITS</b>ocial, please enter a <b>User ID</b>, your <b>First Name</b>, <b>Last Name</b> and a <b>Password</b>.

            <br><br><br>
            
            <!-- Creates form that is secure and submits data to current URL (same page). -->
            <form method="POST" action="">
            
            <b>User ID</b>

            <br><br>

            <!-- Creates field for title -->
            <input type="text" id="uid" name="uid" value="Example">

            <br><br><br>

            <b>First Name</b>

            <br><br>

            <!-- Creates field for content -->
            <input type="text" id="firstname" name="firstname" value="Example">

            <br><br><br>

            <b>Last Name</b>

            <br><br>

            <!-- Creates field for content -->
            <input type="text" id="lastname" name="lastname" value="Example">

            <br><br><br>

            <b>Password</b>

            <br><br>

            <!-- Creates field for content -->
            <input type="password" id="password" name="password" value="Example">

            <br><br><br>

            <!-- Submit button for form. -->
            <input type="submit" value="Sign Up">
            </form>

        </div>

        <br><br>

        <script>
            document.querySelector("form").addEventListener("submit", function(event) {
            const password = document.getElementById("password").value;

            if (password.length < 8) {
            alert("Password must be at least 8 characters long.");
            event.preventDefault(); // Prevent form from submitting
            }
            });
        </script>
    </body>
</html>
<!-- Create User -->

<!-- This is a php program for creating a new user in the WITS database. -->

<!-- Mads Degn, Daniel Pedersen, Liva Plougmann Sørensen, Magnus Østergaard -->
<!-- 08/05-25 -->

<!DOCTYPE html>
<html>
<head>
    <style>

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

        /* Applies styles to the <div> with id "createUser". */
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

        /* Applies styles to the input type text. */
        input[type='text'] { 
            font-size: 20px;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        /* Applies styles to the input type password. */
        input[type='password'] { 
            font-size: 20px;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        /* Applies styles to the input type submit. */
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

        /* Applies styles to the <div> with id "title-container". */
        .title-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
            max-width: 900px;
            padding: 10px;
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

        // Check if form is submitted.
        // Retrieve uid, firstname, lastname and password from submitted data. Set value as empty string if title or content is not set.
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

    <!-- Division for main part of page. -->
    <div id="createUser">
        To sign up as a user on <b>WITS</b>ocial, please enter a <b>User ID</b>, your <b>First Name</b>, <b>Last Name</b> and a <b>Password</b>.

        <br><br><br>
            
        <form id="signup-form" method="POST" action="">
            
            <b>User ID</b>

            <br><br>

            <!-- Uid Input. -->
            <input type="text" id="uid" name="uid" value="Example">

            <br><br><br>

            <b>First Name</b>

            <br><br>

            <!-- First name input. -->
            <input type="text" id="firstname" name="firstname" value="Example">

            <br><br><br>

            <b>Last Name</b>

            <br><br>

            <!-- Last name input. -->
            <input type="text" id="lastname" name="lastname" value="Example">

            <br><br><br>

            <b>Password</b>

            <br><br>

            <!-- Password input. -->
            <input type="password" id="password" name="password" value="Example">

            <br>

            <!-- Element to toggle between password visibility -->
            <div style='text-align: center;'>
        
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

            <!-- Submit button. -->
            <input type="submit" value="Sign Up">

        </form>

    </div>

    <br><br>

    <!-- Element to prevent passwords under 8 characters. -->
    <script>

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
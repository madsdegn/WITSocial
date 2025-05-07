<!-- User list -->

<!-- This is a php program which can show users a list of all users in WITS database. -->

<!-- Mads Degn, Daniel Pedersen, Liva Plougmann Sørensen, Magnus Østergaard -->
<!-- 08/05-25 -->

<!DOCTYPE html>
<html>
<head>
    <style>
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

        /* Applies styles to the <div> with id "right-boxes". */
        .right-boxes {
            position: absolute;
            top: 35px;
            right: 20px;
            display: flex;
            gap: 10px;
        }

        /* Applies styles to the <div> with id "box". */
        .box {
            font-family: Arial, sans-serif;
            background-color: lightgrey;
            border: 5px solid black;
            width: 150px;
            padding: 2px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
            cursor: pointer;
        }

        /* Applies styles to the <div> with id "userList". */
        #userList {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: lightgrey;
            width: 400px;
            border: 7px solid black;
            padding: 50px;
            margin: auto;
            font-size: 20px;
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

    <!-- Division for buttons top right. -->
    <div class="right-boxes">
                
        <?php
            session_start();

            // Buttons to userList, createPost, and logout. Only shown if sessions uid and session password are not empty.
            if (!empty($_SESSION['uid']) && !empty($_SESSION['password'])) {
                echo "<form action='userList.php' method='get'>";
                echo "<button class='box' type='submit'><b>User List</b></button>";
                echo "</form>";
                
                echo "<form action='createPost.php' method='get'>";
                echo "<button class='box' type='submit'><b>Create Post</b></button>";
                echo "</form>";

                echo "<form action='logout.php' method='get'>";
                echo "<button class='box'><b>Sign Out</b></button>";
                echo "</form>";
            
            // Buttons for userList and login. Only shown if sessions uid and sessions password are empty.
            } else {
                echo "<form action='userList.php' method='get'>";
                echo "<button class='box' type='submit'><b>User List</b></button>";
                echo "</form>";
                
                echo "<form action='login.php' method='get'>";
                echo "<button class='box'><b>Sign In</b></button>";
                echo "</form>";
            }
        ?>
    </div>

    <?php
        require_once '/var/www/wits.ruc.dk/db.php'; // Access to WITS course API.

        $users = get_uids(); // Receives array with all uid in WITS database.
        echo "<div id='userList'>"; // Creates division for userList.
        echo "<b>Users</b><br><br>";
        echo "<div style='text-align: left;'>";

        foreach ($users as $uid){ // Takes users array and makes a new variable uid for every iteration in the loop.
            $user = get_user($uid); // Receives an array with information regarding current user.
            echo "- ";
            echo "<a href='https://wits.ruc.dk/~stud-madd/WITSocial/userFeed.php?uid=$uid'>"; // Makes the following text links.
            echo $user ['firstname']; // Displays current users first name.
            echo " ";
            echo $user ['lastname']; // Displays current users last name.
            echo "</a><br><br>"; // Ends link.
        }
        
        echo "</div>";
        echo "</div>";

    ?>

    <br><br>

    <script> // JavaScript for the live-updating clock

        // Function that updates the clock
        function updateClock() {
            const now = new Date(); // Gets the computer's current date and time

            // Extracts hours, minutes, and seconds, and ensures two digits ('09' instead of '9')
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            // Updates the text content of the HTML element with id="clock"
            document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds}`;
        }

        // Runs updateClock every 1000 milliseconds (1 second)
        setInterval(updateClock, 1000);

        // Runs the function once immediately so the clock doesn't start empty
        updateClock();

    </script>

</body>
</html>

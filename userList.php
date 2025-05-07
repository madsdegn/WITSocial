<!-- userList.php -->

<!-- Mads Degn, Daniel Pedersen, Liva Plougmann Sørensen, Magnus Østergaard -->
<!-- 27/03-25 -->

<!DOCTYPE html>
<html>
<head>
    <style>
        /* Styles the main title box */
        .title-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
            max-width: 900px;
            padding: 10px;
        }

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

        .right-boxes {
            position: absolute;
            top: 35px;
            right: 20px;
            display: flex;
            gap: 10px;
        }

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

        /* Styles the post creation container */
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

        /* Styles a left-aligned box (e.g. for a clock) */
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

<div class="title-container">
           
            <?php
            echo "<form action='feed.php' method='get'>";
            echo "<button class='title' type='submit'><b>WITS</b>ocial</button>";
            echo "</form>";
            ?>
    </div>
 <div class="left-box" id="clock">00:00:00</div> 
<br><br>

<div class="right-boxes">
                <?php
                session_start();

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
    // Retrieve title and content from submitted data. Set value as null if title or content is not set.

    $users = get_uids(); // Modtager et array med alle uid's i databasen.
echo "<div id='userList'>";
echo "<b>Users</b><br><br>";
echo "<div style='text-align: left;'>";


// Loop der gennemgår og viser alle brugere i databasen
foreach ($users as $uid){ // Tager users array og laver ny variable uid for hver iteration af array.
    $user = get_user($uid); // Modtager et array med information om nuværende iterations user.
    echo "- ";
    echo "<a href='https://wits.ruc.dk/~stud-madd/WITSocial/userFeed.php?uid=$uid'>"; // Gør efterfølgende tekst til link til postList.
    echo $user ['firstname']; // Viser firstname fra user array.
    echo " ";
    echo $user ['lastname']; // Viser lastname fra user array.
    echo "</a><br><br>"; // Slutter link.
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

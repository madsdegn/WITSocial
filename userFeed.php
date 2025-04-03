<!-- Create Post -->

<!-- Mads Degn, Daniel Pedersen, Liva Plougmann Sørensen, Magnus Østergaard -->
<!-- 27/03-25 -->

<!DOCTYPE html>
<html>
    <head>
    <style>

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
        
        /* CSS selector for main welcome message to user. */
        /* Applies styles to the <div> with id "welcome". */
        #welcome {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: white;
            width: 400px;
            border: 7px solid black;
            padding: 50px;
            margin: auto;
            font-size: 20px;
        }

        /* CSS selector for posts. */
        /* Applies styles to the <div> with id "posts". */
        #posts {
            font-family: Arial, sans-serif;
            text-align: left;
            background-color: white;
            width: 400px;
            border: 7px solid black;
            padding: 50px;
            margin: auto;
            font-size: 20px;
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

        <div id="welcome">
            Welcome to your feed<b>

            <?php
                require_once '/var/www/wits.ruc.dk/db.php'; // Access to WITS course API.

                session_start(); // Starts session to get uid from user.

                $uid = $_SESSION["uid"]; // Defines uid as uid from session.

                $user = get_user($uid); // Receives array containing info regarding user.

                echo $user ['firstname']; // Shows firstname from user array.
                echo " ";
                echo $user ['lastname']; // Shows lastname from user array.
                echo "!";
            ?>

            <br><br>

            </b>Here you can see all posts made by you.

        </div>

        <br><br>

        <?php
            $posts = get_pids_by_uid($uid); // Receives array with all post id's made by user from current session.

            foreach ($posts as $pid){ // Takes posts array and makes a new variable pid for every iteration in the loop.
                $post = get_post($pid); // Receives an array with information regarding the current iterations post.
                echo "<div id='posts'>"; // Creates division with id posts and makes each post each own CSS Box. -->
                echo "<b>Title</b><br><br>";
                echo $post ['title']; // Displays title from post array.
                echo "<br><br><br>";
                echo "<b>Content</b><br><br>";
                echo $post ['content']; // Displays content from post array.
                echo "<br>";
                echo "</div>";
                echo "<br><br>";
            }
        ?>

    </body>
</html>
<!-- Create Post -->

<!-- Mads Degn, Daniel Pedersen, Liva Plougmann Sørensen, Magnus Østergaard -->
<!-- 27/03-25 -->

<!DOCTYPE html>
<html>
    <head>
    <style>

        /* CSS selector for WITSocial logo at top of webpage. */
        /* Applies styles to the <div> with id "Title". */
        /* Styles include a CSS Box Model with a thick black border, white background and the name WITSocial largely displayed in the middel. */
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

                session_start();

                $uid = $_SESSION["uid"];

                $user = get_user($uid);

                echo $user ['firstname']; // Viser firstname fra user array.
                echo " ";
                echo $user ['lastname']; // Viser lastname fra user array.
                echo "!";
            ?>

            <br><br>

            </b>Here you can see all posts made by you.

        </div>

        <br><br>


        <?php

            $posts = get_pids_by_uid($uid);

            foreach ($posts as $pid){ // Tager comments array og laver ny variable cid for hver iteration.
                $post = get_post($pid); // Modtager et array med information om nuværende iterations kommentar.
                echo "<div id='posts'>";
                echo "<b>Title</b><br><br>";
                echo $post ['title']; // Viser date fra comment array.
                echo "<br><br><br>";
                echo "<b>Content</b><br><br>";
                echo $post ['content']; // Viser content fra comment array.
                echo "<br>";
                echo "</div>";
                echo "<br><br>";
}

        ?>

    </body>
</html>
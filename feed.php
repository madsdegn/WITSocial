<!-- Feed -->

<!-- Mads Degn, Daniel Pedersen, Liva Plougmann Sørensen, Magnus Østergaard -->
<!-- 02/05-25 -->

<!DOCTYPE html>
<html>
    <head>
    <style>

        .title-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 0 auto;
            max-width: 900px;
            padding: 10px;
        }

        #title {
            font-family: Arial, sans-serif;
            background-color: lightgrey;
            width: 300px;
            border: 7px solid black;
            padding: 2px;
            font-size: 45px;
            text-align: center;
            margin: auto;
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
            border: 7px solid black;
            width: 150px;
            padding: 2px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            cursor: pointer;
        }

        /* CSS selector for posts. */
        /* Applies styles to the <div> with id "posts". */
        #posts {
            font-family: Arial, sans-serif;
            background-color: lightgrey;
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
        <div class="title-container">
            <div id="title">
                <b>WITS</b>ocial
            </div>
        <div class="right-boxes">
                <button class="box"><b>Create Post</button>

                <?php
                if (session_status() === PHP_SESSION_ACTIVE) {
                    echo "<button class='box'>Sign In</b></button>";
                } else {
                    echo "<button class='box'>Sign Out</b></button>";
                }
                ?>
        </div>
    </div>

        <br><br>

        <?php
            require_once '/var/www/wits.ruc.dk/db.php'; // Access to WITS course API.

            $postsNormal = get_pids(); // Receives array with all post id's made by all users.
            $posts = array_reverse($postsNormal, true);

            foreach ($posts as $pid){ // Takes posts array and makes a new variable pid for every iteration in the loop.
                $post = get_post($pid); // Receives an array with information regarding the current iterations post.

                $postUser = get_user($post['uid']);
                echo "<div id='posts'>"; // Creates division with id posts and makes each post each own CSS Box. -->
                echo "<b>";
                echo "<div style='text-align: center;'>";
                echo $postUser ['firstname'];
                echo " ";
                echo $postUser ['lastname'];
                echo "</b></div><br><br><b>";
                echo "<div style='text-align: left;'>";
                echo $post ['title']; // Displays title from post array.
                echo "</b><br><br><br>";
                echo $post ['content']; // Displays content from post array.
                echo "</div>";

                $images = get_iids_by_pid($pid);
                foreach ($images as $iid){ // Tager images array og laver ny variable iid for hver iteration.
                    $image = get_image($iid); // Modtager et array med information om nuværende iterations billede.
                    echo "<br><br>";
                    echo "<div style='text-align: center;'>";
                    echo "<img src=".$image ['path']." width='200' height='200'>"; // Viser nuværende iterations billede og ændre størrelse til 200x200 pixels.
                    echo "<br></div>";
                }

                $comments = get_cids_by_pid($pid);

                if (empty($comments)) {} else {

                echo "<br><br><br>";
                echo "<div style='text-align: center;'>";
                echo "<b>Comments</b><br></div>";
                echo "<div style='text-align: left;'>";
                
                            foreach ($comments as $cid){ // Tager comments array og laver ny variable cid for hver iteration.
                                $comment = get_comment($cid); // Modtager et array med information om nuværende iterations kommentar.
                                $commentUser = get_user($comment['uid']); // Modtager et array med information om nuværende iterations user.
                                $commentUid = $commentUser['uid']; // Sætter variablen commentUid til kommentarens users uid.
                                echo "<br><b>";
                                echo $commentUser ['firstname']; // Viser firstname fra commentUser array.
                                echo " ";
                                echo $commentUser ['lastname']; // Viser lastname fra commentUser array.
                                echo "</b> - "; // Slutter link samt fed skrift.
                                echo $comment ['date']; // Viser date fra comment array.
                                echo "<br>";
                                echo $comment ['content']; // Viser content fra comment array.
                                echo "<br>";
                            }
                        }
                echo "</div>";
                echo "</div>";
                echo "<br><br>";
            }
        ?>

    </body>
</html>
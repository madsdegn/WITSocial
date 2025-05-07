<!-- Feed -->

<!-- Mads Degn, Daniel Pedersen, Liva Plougmann Sørensen, Magnus Østergaard -->
<!-- 02/05-25 -->

<!DOCTYPE html>
<html>
    <head>
    <style>

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

        /* CSS attribute selector for text fields.*/
        /* Applies styles to input elements with attribute 'textarea'. */
        textarea { 
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
        
        <!-- Creates division with id title and writes WITS in capital lettes followed by ocial in non-capital letters. -->
        <div class="title-container">
           
            <?php
            echo "<form action='feed.php' method='get'>";
            echo "<button class='title' type='submit'><b>WITS</b>ocial</button>";
            echo "</form>";
            ?>
    </div>
            <div class="left-box" id="clock"><b>00:00:00</b></div> 
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

            if (
                $_SERVER["REQUEST_METHOD"] === "POST" &&
                isset($_POST['delete_comment']) &&
                isset($_POST['cid']) &&
                !empty($_POST['cid']) &&
                !empty($_SESSION['uid'])
            ) {
                $cid = $_POST['cid'];
            
                delete_comment($cid);
                header("Location: feed.php");
                exit();
            }

            $uidMain = $_GET['uid'] ?? null;
            $postsNormal = get_pids_by_uid($uidMain);
            // Receives array with all post id's made by all users.
            $posts = array_reverse($postsNormal, true);

            foreach ($posts as $pid){ // Takes posts array and makes a new variable pid for every iteration in the loop.
                $post = get_post($pid); // Receives an array with information regarding the current iterations post.

                $postUser = get_user($post['uid']);
                echo "<div id='posts'>"; // Creates division with id posts and makes each post each own CSS Box. -->
                echo "<b>";

                echo "<div style='text-align: center;'>";
                if (empty($postUser['firstname'])) {
                } else {
                echo $postUser['firstname'];
                echo " ";
                }
                if (empty($postUser['lastname'])) {
                } else {
                echo $postUser['lastname'];
                echo "<br><br><br>";
                }
                echo "</b></div><b>";
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

                if (!isset($_SESSION['uid'])) {
                    $_SESSION['uid'] = "NA";
                }

                if ($post['uid'] == $_SESSION['uid']) {
                    echo "<br><br>";
                    echo "<form action='editPost.php' method='POST'>";
                    echo "<input type='hidden' name='pid' value='" . htmlspecialchars($pid) . "'>";
                    echo "<input type='hidden' name='title' value='" . htmlspecialchars($post['title'], ENT_QUOTES) . "'>";
                    echo "<input type='hidden' name='content' value='" . htmlspecialchars($post['content'], ENT_QUOTES) . "'>";
                    echo "<input type='submit' value='Edit'>";
                    echo "</form>";
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

                                    if($_SERVER["REQUEST_METHOD"] == "POST"){
                                        $content = $_POST['content'] ?? '';
                                        $pid = $_POST['pid'] ?? null;

                                        $uid = $_SESSION["uid"]; // Takes uid from sessions and sets it as variable.
                                        add_comment($uid, $pid, $content); // Uses API function to create post with inserted content and uid from session.
                                        header("Location: feed.php"); // Sends user to userFeed.php to see post just created.
                                            exit();
                                    }

                                if ($commentUser['uid'] == $_SESSION['uid'] || $post['uid'] == $_SESSION['uid']){
                                    echo "<br>";
                                    echo "<form method='POST' action=''>";
                                    echo "<input type='hidden' name='cid' value='" . $cid . "'>";
                                    echo "<input type='submit' name='delete_comment' value='Delete'>";
                                    echo "<br>";
                                    echo "</form>";     
                                }

                            }
                        }
                        
                            if (!empty($_SESSION['uid']) && !empty($_SESSION['password'])) {
                                if($_SERVER["REQUEST_METHOD"] == "POST"){
                                    $content = $_POST['content'] ?? '';
                                    $pid = $_POST['pid'] ?? null;
                    
                                    $uid = $_SESSION["uid"]; // Takes uid from sessions and sets it as variable.
                                    add_comment($uid, $pid, $content); // Uses API function to create post with inserted content and uid from session.
                                    header("Location: feed.php"); // Sends user to userFeed.php to see post just created.
                                        exit();
                                }

                                echo "<form method='POST' action=''>";
                                echo "<input type='hidden' name='pid' value='$pid'>";
                                echo "<div style='text-align: center;'>";
                                echo "<b><br><br>Add comment</b>";
                                echo "</div>";
                                echo "<br>";
                                echo "<textarea name='content' rows='1' cols='44'></textarea>";
                                echo "<br><br>";
                                echo "<input type='submit' value='Submit'>";
                                echo "</form>";

                            }
                echo "</div>";
                echo "</div>";
                echo "<br><br>";
            }
        ?>

        <script>
            function updateClock() {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds}`;
            }

            setInterval(updateClock, 1000);
            updateClock();
        </script>

    </body>
</html>
<!-- User feed -->

<!-- This is a php program which allows users to see posts made by specific users. -->

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

        /* Applies styles to input type "textarea". */
        textarea { 
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
            
        // Check if the form was submitted via POST and if the delete comment action is requested.
        if ($_SERVER["REQUEST_METHOD"] === "POST" &&
            isset($_POST['delete_comment']) &&
            isset($_POST['cid']) &&
            !empty($_POST['cid']) &&
            !empty($_SESSION['uid'])
            ) {
                $cid = $_POST['cid']; // Get comment id from form submission.
                delete_comment($cid); // Delete comment.
                header("Location: feed.php"); // Send user to feed.php
                exit();
        }

        $uidMain = $_GET['uid'] ?? null; // Receives uid from userList.php.
        $postsNormal = get_pids_by_uid($uidMain); // Receives array with pid from uid from userlist.php.
        $posts = array_reverse($postsNormal, true); // Reserves array so newest post is shown first.

        foreach ($posts as $pid){ // Takes posts array and makes a new variable pid for every iteration in the loop.
            $post = get_post($pid); // Receives an array with information regarding the current iterations post.
            $postUser = get_user($post['uid']); // Recevies an array with information regarding the user who made current post.
            
            echo "<div id='posts'>"; // Creates division with id posts and makes each post each own CSS Box. -->
            echo "<b>";
            echo "<div style='text-align: center;'>";
            
            // Makes sure post have firstname or not. Only displays if it does.
            if (empty($postUser['firstname'])) {
                } else {
                echo $postUser['firstname'];
                echo " ";
            }

            // Makes sure post have lastname or not. Only displays if it does.
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
            
            foreach ($images as $iid){ // Takes images array and makes a new variable iid for every iteration in the loop.
                $image = get_image($iid); // Receives an array with information regarding the current iterations image.
                echo "<br><br>";
                echo "<div style='text-align: center;'>";
                echo "<img src=".$image ['path']." width='200' height='200'>"; // Shows current iterations image and resizes image to 200x200.
                echo "<br></div>";
            }

            // Sets session uid to NA if no session/uid is currently ongoing.
            if (!isset($_SESSION['uid'])) {
                $_SESSION['uid'] = "NA";
            }

            // Form to send user and post data to editPost. Htmlspecialchars for functionality safety.
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

            // If there are any comments, display a comment section.
            if (empty($comments)) {} else {
                echo "<br><br><br>";
                echo "<div style='text-align: center;'>";
                echo "<b>Comments</b><br></div>";
                echo "<div style='text-align: left;'>";
                
                foreach ($comments as $cid){ // // Takes comments array and makes a new variable cid for every iteration in the loop.
                    $comment = get_comment($cid); // Receives an array with information regarding current comment.
                    $commentUser = get_user($comment['uid']); // Receives an array with information regarding current comment user.
                    $commentUid = $commentUser['uid']; // Sets commentUid as commentUses uid.
                    echo "<br><b>";
                    echo $commentUser ['firstname']; // Displays comment users first name.
                    echo " ";
                    echo $commentUser ['lastname']; // Displays comment users last name.
                    echo "</b> - ";
                    echo $comment ['date']; // Shows date from comment array.
                    echo "<br>";
                    echo $comment ['content']; // Shows content from comment array.
                    echo "<br>";

                    // If comment user and session user are the same, or if post user and session user are the same, show delete option.
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
            
            // Check if session uid and password are empty.
            // Check if the form was submitted via POST. Set content and pid as data from post, empty string or null if not set.
            if (!empty($_SESSION['uid']) && !empty($_SESSION['password'])) {
                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    $content = $_POST['content'] ?? '';
                    $pid = $_POST['pid'] ?? null;
    
                    $uid = $_SESSION["uid"]; // Takes uid from sessions and sets it as variable.
                    add_comment($uid, $pid, $content); // Uses API function to add comment to current post.
                    header("Location: feed.php"); // Sends user to feed.php.
                    exit();
                }

                // Form for adding comment.
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
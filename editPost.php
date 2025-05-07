<!-- Edit Post -->

<!-- This is a php program that allows users to edit their own posts. -->

<!-- Mads Degn, Daniel Pedersen, Liva Plougmann Sørensen, Magnus Østergaard -->
<!-- 08/05-25 -->

<!DOCTYPE html>
<html>
<head>
    <style>

        /* Applies styles to the <div> with id "title". */
        .title {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: lightgrey;
            width: 300px;
            border: 7px solid black;
            padding: 2px;
            margin: auto;
            font-size: 45px;
            cursor: pointer;
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

        /* Applies styles to the <div> with id "editPost". */
        #editPost {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: lightgrey;
            width: 400px;
            border: 7px solid black;
            padding: 50px;
            margin: auto;
            font-size: 20px;
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

        /* Applies styles to the input type textarea. */
        textarea { 
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
        
        // Retrieve title, content and pid from post from feed. Set value as null or empty string if title or content is not set.
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            $pid = $_POST['pid'] ?? null;
            $uid = $_SESSION["uid"];// Takes uid from sessions and sets it as variable.    

            // Check again that the form was submitted via POST and that the submit button named 'submit_edit' was clicked
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_edit'])) {
                
                // Redefine the post data to ensure it's fresh from post from feed.
                $pid = $_POST['pid'] ?? null;
                $newTitle = $_POST['title'] ?? '';
                $newContent = $_POST['content'] ?? '';
                $uid = $_SESSION['uid'] ?? null;

                // If all required values are present, update the post using the modify_post() function
                if ($pid && $uid && $newTitle && $newContent) {
                    modify_post($pid, $newTitle, $newContent);
                    header("Location: feed.php");
                    exit();
                }
            }
        }
    ?>

    <!-- Division for main part of page. -->
    <div id="editPost">
        To modify your post, please edit your <b>Title</b> and/or <b>Content</b>.

        <br><br><br>

        <!-- Form for editing the post. -->
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="pid" value="<?= htmlspecialchars($pid ?? '') ?>">
            
            <!-- Title input. -->
            <label><b>Title</b></label><br><br>
            <textarea name="title" rows="1" cols="40"><?= htmlspecialchars($title ?? '', ENT_QUOTES) ?></textarea><br><br><br>

            <!-- Content input. -->
            <label><b>Content</b></label><br><br>
            <textarea name="content" rows="10" cols="40"><?= htmlspecialchars($content ?? '') ?></textarea><br><br>

            <!-- Submit button. -->
            <input type="submit" name="submit_edit" value="Save">
        </form>
    </div>

    <br><br>
        
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

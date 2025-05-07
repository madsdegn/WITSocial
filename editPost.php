<!-- createPost.php -->

<!-- Mads Degn, Daniel Pedersen, Liva Plougmann Sørensen, Magnus Østergaard -->
<!-- 27/03-25 -->

<!DOCTYPE html>
<html>
<head>
    <style>
        /* Styles the main title box */
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

        .title-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
            max-width: 900px;
            padding: 10px;
        }

        /* Styles the post creation container */
        #createPost {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: lightgrey;
            width: 400px;
            border: 7px solid black;
            padding: 50px;
            margin: auto;
            font-size: 20px;
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

        /* Styles text areas for title and content */
        textarea { 
            font-size: 20px;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        /* Styles the submit button and centers it */
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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $pid = $_POST['pid'] ?? null;
        $uid = $_SESSION["uid"];// Takes uid from sessions and sets it as variable.    

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_edit'])) {
            $pid = $_POST['pid'] ?? null;
            $newTitle = $_POST['title'] ?? '';
            $newContent = $_POST['content'] ?? '';
            $uid = $_SESSION['uid'] ?? null;

            if ($pid && $uid && $newTitle && $newContent) {
                modify_post($pid, $newTitle, $newContent); // Your update function
                header("Location: feed.php");
                exit();
    exit();
            }
    }
}
?>

<!-- Container for creating a new post -->
<div id="createPost">
    To modify your post, please edit your <b>Title</b> and/or <b>Content</b>.

    <br><br><br>

    <!-- Form for submitting a post with optional image upload -->
    <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" name="pid" value="<?= htmlspecialchars($pid ?? '') ?>">
        
        <label><b>Title</b></label><br><br>
        <textarea name="title" rows="1" cols="40"><?= htmlspecialchars($title ?? '', ENT_QUOTES) ?></textarea><br><br><br>

        <label><b>Content</b></label><br><br>
        <textarea name="content" rows="10" cols="40"><?= htmlspecialchars($content ?? '') ?></textarea><br><br>

        <!-- Submit button -->
        <input type="submit" name="submit_edit" value="Save">
    </form>
</div>

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

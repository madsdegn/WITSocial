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

        /* CSS selector for main post creation part of webpage. */
        /* Applies styles to the <div> with id "createPost". */
        #createPost {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: white;
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

    </style>
    </head>
    <body>

        <br>
        
        <!-- Creates division with id title and writes WITS in capital lettes followed by ocial in non-capital letters. -->
        <div id="title">
            <b>WITS</b>ocial
        </div>

        <br><br>

        <!-- php section. -->
        <?php
            require_once '/var/www/wits.ruc.dk/db.php'; // Access to WITS course API.

            session_start(); // Starts session to use user id and password from login.php.

            // Check if form is submitted.
            // Retrieve title and content from submitted data. Set value as null if title or content is not set.
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $title = $_POST['title'] ?? '';
                $content = $_POST['content'] ?? '';

                $uid = $_SESSION["uid"]; // Takes uid from sessions and sets it as variable.
                add_post($uid, $title, $content); // Uses API function to create post with inserted content and uid from session.
                header("Location: userFeed.php"); // Sends user to userFeed.php to see post just created.
                    exit();
            }
        ?>

        <!-- Creates division with id createPost. -->
        <div id="createPost">
            To create a new post, please enter a <b>Title</b> and <b>Content</b> for the post.

            <br><br><br>
            
            <!-- Creates form that is secure and submits data to current URL (same page). -->
            <form method="POST" action="">
            
            <b>Title</b>

            <br><br>

            <!-- Creates field for title -->
            <textarea name="title" rows="1" cols="40"></textarea>
            
            <br><br><br>

            <b>Content</b>

            <br><br>

            <!-- Creates field for content -->
            <textarea name="content" rows="10" cols="40"></textarea>

            <br><br><br>

            <!-- Submit button for form. -->
            <input type="submit" value="Upload Post">
            </form>

        </div>

        <br><br>



    </body>
</html>
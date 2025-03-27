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

        /* CSS selector for main login part of webpage. */
        /* Applies styles to the <div> with id "createPost". */
        /* Styles include a CSS Box Model with a thick black border, white background and user id and password displayed left side of the box. */
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
        /* Applies styles to input elements with attribute input='text'. */
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

            // Check if form is submitted.
            // Retrieve uid and password from submitted data. Set value as null if uid or password is not set.
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $postTitle = $_POST['postTitle'] ?? '';
                $postContent = $_POST['postContent'] ?? '';

                // If login function returns true, redirect user to secrets.php file and prevent further code execution.
                // If login function returns false, set message variable to Credentials Incorrect.
                if(login($uid, $password)) {
                    header("Location: secrets.php");
                    exit();
                } else {
                    $message = "<br><br>Credentials Incorrect";                }
            }
        ?>

        <!-- Creates division with id createPost. -->
        <div id="createPost">
            To create a new post, please enter a <b>Title</b> and <b>Content</b> for the post.

            <br><br><br>

            <form method="POST" action="">
            
            <b>Title</b>

            <br><br>

            <textarea name="title" rows="1" cols="40"></textarea>
            
            <br><br><br>

            <b>Content</b>

            <br><br>

            <textarea name="content" rows="10" cols="40"></textarea>

            <br><br><br>

            <!-- Submit button for form. -->
            <input type="submit" value="Upload Post">
            </form>

        </div>

        <br><br>



    </body>
</html>
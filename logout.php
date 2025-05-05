<!-- Log Out -->

<!-- Mads Degn, Daniel Pedersen, Liva Plougmann Sørensen, Magnus Østergaard -->
<!-- 04/05-25 -->

<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>

    <?php
        session_start();
        session_unset();     // Clears session variables
        session_destroy();   // Destroys the session
        
        // Redirect to login or home page
        header("Location: feed.php");
        exit();
    ?>

    </body>
</html>
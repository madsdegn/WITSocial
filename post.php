<!-- post -->

<!-- Mads Degn, Daniel Pedersen, Liva Plougmann Sørensen, Magnus Østergaard -->
<!-- 06/03-25 -->

<?php
require_once '/var/www/wits.ruc.dk/db.php'; // Adgang til kursets API-funktioner.

$input = $_GET['pid']; // Definerer input variablen som brugerens input fra URL baren.

$post = get_post($input); // Modtager et array med information om den post brugeren har efterspurgt i URL baren og definerer det til post variablen.
$images = get_iids_by_pid($input); // Modtager et array af id'ere for de billeder vedhæftet til den post brugerens har efterspurgt i URL baren og definerer det til images variablen.
$comments = get_cids_by_pid($input); // Modtager et array af id'ere for de kommentarer skrevet til den post brugerens har efterspurgt i URL baren og definerer det til comments variablen.
$user = get_user($post['uid']); // Modtager et array med information om brugeren der har skrevet den post som er efterspurgt i URL baren og definerer det til user variablen.
$uid = $user['uid']; // Sætter variablen uid til postens users uid.

echo "<b>";
echo "<a href='https://wits.ruc.dk/~stud-madd/Afleveringer/Aflevering02/postList.php?uid=$uid'>"; // Gør efterfølgende tekst til link til postList.
echo $user ['firstname']; // Viser firstname fra user array.
echo " ";
echo $user ['lastname']; // Viser lastname fra user array.
echo "</a></b> - "; // Slutter link samt fed skrift.
echo $post ['date']; // Viser date fra post array.
echo "<br><br><b>Title</b><br>";
echo $post ['title']; // Viser title fra post array.
echo "<br><br><b>Content</b><br>"; 
echo $post ['content']; //Viser content fra user array.
echo "<br><br>";

// Loop der gennemgår og viser alle billeder fra en bestemt post.
foreach ($images as $iid){ // Tager images array og laver ny variable iid for hver iteration.
    $image = get_image($iid); // Modtager et array med information om nuværende iterations billede.
    echo "<img src=".$image ['path']." width='200' height='200'>"; // Viser nuværende iterations billede og ændre størrelse til 200x200 pixels.
    echo "<br><br>";
}

echo "<br><br><br><b>Comments</b><br>";

// Loop der gennemgår og viser alle kommentarer fra en bestemt post.
foreach ($comments as $cid){ // Tager comments array og laver ny variable cid for hver iteration.
    $comment = get_comment($cid); // Modtager et array med information om nuværende iterations kommentar.
    $commentUser = get_user($comment['uid']); // Modtager et array med information om nuværende iterations user.
    $commentUid = $commentUser['uid']; // Sætter variablen commentUid til kommentarens users uid.
    echo "<br><b>";
    echo "<a href='https://wits.ruc.dk/~stud-madd/Afleveringer/Aflevering02/postList.php?uid=$commentUid'>"; // Gør efterfølgende tekst til link til postList.
    echo $commentUser ['firstname']; // Viser firstname fra commentUser array.
    echo " ";
    echo $commentUser ['lastname']; // Viser lastname fra commentUser array.
    echo "</a></b> - "; // Slutter link samt fed skrift.
    echo $comment ['date']; // Viser date fra comment array.
    echo "<br>";
    echo $comment ['content']; // Viser content fra comment array.
    echo "<br>";
}

?>
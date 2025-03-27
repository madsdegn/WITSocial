<!-- userList -->

<!-- Mads Degn, Daniel Pedersen, Liva Plougmann Sørensen, Magnus Østergaard -->
<!-- 06/03-25 -->

<?php
require_once '/var/www/wits.ruc.dk/db.php'; // Adgang til kursets API-funktioner.

$users = get_uids(); // Modtager et array med alle uid's i databasen.

echo "<b>Users</b><br><br>";

// Loop der gennemgår og viser alle brugere i databasen
foreach ($users as $uid){ // Tager users array og laver ny variable uid for hver iteration af array.
    $user = get_user($uid); // Modtager et array med information om nuværende iterations user.
    echo "- ";
    echo "<a href='https://wits.ruc.dk/~stud-madd/WITSocial/postList.php?uid=$uid'>"; // Gør efterfølgende tekst til link til postList.
    echo $user ['firstname']; // Viser firstname fra user array.
    echo " ";
    echo $user ['lastname']; // Viser lastname fra user array.
    echo "</a><br><br>"; // Slutter link.
}
?>
<!-- postList -->

<!-- Mads Degn, Daniel Pedersen, Liva Plougmann Sørensen, Magnus Østergaard -->
<!-- 06/03-25 -->

<?php
require_once '/var/www/wits.ruc.dk/db.php'; // Adgang til kursets API-funktioner.

$input = $_GET['uid']; // Definerer input variablen som brugerens input fra URL baren.
$posts = get_pids_by_uid($input); // Modtager et array med post id's der er lavet af brugeren indtastet i url baren ($input).
$user = get_user($input); // Modtaer et array med information om brugeren hvis uid er skrevet ind i URL baren ($input).

echo "<b>Bruger</b> - ";
echo "<a href='https://wits.ruc.dk/~stud-madd/Afleveringer/Aflevering02/postList.php?uid=$input'>"; // Gør efterfølgende tekst til link til postList.
echo $user ['firstname']; // Viser firstname fra user array.
echo " ";
echo $user ['lastname']; // Viser lastname fra user array.
echo "</a><br><br><b>Posts</b><br><br>"; // Slutter link og skriver Posts i fed skrift.

// Loop der gennemgår og viser alle posts lavet af brugeren fra URL baren.
foreach ($posts as $pid){ // Tager posts array og laver ny variable pid for hver iteration.
    $post = get_post($pid); // Modtager et array med information om nuværende iterations post.
    echo "- ";
    echo "<a href='https://wits.ruc.dk/~stud-madd/Afleveringer/Aflevering01/post.php?pid=$pid'>"; // Gør efterfølgende tekst til link til post.
    echo $post ['title']; // Viser title fra post array.
    echo "</a><br><br>"; // Slutter link.
}
?>
<!-- Attach -->

<!-- Mads Degn, Daniel Pedersen, Liva Plougmann Sørensen, Magnus Østergaard -->
<!-- 07/05-25 -->

<?php
  require_once '/var/www/wits.ruc.dk/db.php'; // Access to WITS course API.


$PostsArray = get_pids();  //$PostsArray is set to array of all post id's

$ImagesArray = get_iids(); //$ImagesArray is set to array of all image id's

$alt = end($PostsArray); //$alt is set to last index of $PostsArray
$iid = end($ImagesArray); //$iid is set to last index of $ImagesArray

add_attachment($alt, $iid); //Function to attach $alt and $iid 

header("Location: feed.php"); //Sends user to the feed. 

?>

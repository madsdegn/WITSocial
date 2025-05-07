<!-- Attach -->

<!-- This is a php program which attaches an image to a post. -->

<!-- Mads Degn, Daniel Pedersen, Liva Plougmann Sørensen, Magnus Østergaard -->
<!-- 08/05-25 -->

<?php

  require_once '/var/www/wits.ruc.dk/db.php'; // Access to WITS course API.

  $postsArray = get_pids();  // Receiving an array containing all post ID's.

  $imagesArray = get_iids(); // Receiving an array containing all image ID's.

  $alt = end($postsArray); // Sets variable to last index of postsArray.
  $iid = end($imagesArray); // Sets variable to last index of imageArray.

  add_attachment($alt, $iid); // Function to attach $alt and $iid in WITS database.

  header("Location: feed.php"); // Sends user to feed.php.

?>
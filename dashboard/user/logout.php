<?php
session_start();

// Check if the user is logged in.
if (isset($_SESSION['user_id'])) {
  // Log the user out.
  session_destroy();
  unset($_SESSION['user_id']);

  // Redirect the user to the login page.
  header("Location: ../../login.php");
}


echo "<script>window.history.forward();</script>";
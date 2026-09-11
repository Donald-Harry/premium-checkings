<?php
session_start();

// Check if the user is logged in.
if (isset($_SESSION['admin_login'])) {
  // Log the user out.
  session_destroy();
  unset($_SESSION['admin_login']);

  // Redirect the user to the login page.
  header("Location: ../../account");
}


echo "<script>window.history.forward();</script>";
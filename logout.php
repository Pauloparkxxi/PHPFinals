<?php
session_start();

unset($_SESSION['loggedin']);

 if(session_destroy()) {
session_write_close();
header("location: loginPage.php");
die;
 }
?>
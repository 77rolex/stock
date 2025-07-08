<?php
session_start();
unset($_SESSION["user_name"]);
unset($_SESSION["role"]);
unset($_SESSION["cart"]);
session_destroy();
header("location:connection.php");
?>
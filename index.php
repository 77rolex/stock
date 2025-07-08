<?php
session_start();
if (isset($_SESSION["user_name"])) {
require_once("header.php");

require_once("main.php");

require_once("footer.php"); 
} else {
    header("location:connection.php");
}
?>
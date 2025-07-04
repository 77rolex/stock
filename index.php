<?php



require_once("DAO.php");
$dao=new DAOStock();
$dao->connection(); 

require_once("header.php");

require_once("main.php");

require_once("footer.php"); 

?>
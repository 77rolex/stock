
<?php
session_start(); //debut de session

require_once("dao.php"); //se connecte au DB
$dao=new DAOStock();
$dao->connection(); 

$login=$_POST['identifiant']?? ''; //recouperation des donnees du "form"
$password=$_POST['motdepasse']?? '';

$user=$dao->checkLogin($login,$password);


if($user && password_verify($password, $user['password_hash'])){
  //sauvegarde des donnees d'user dans la session
  $_SESSION['username']=$user['username'];
  $_SESSION['role']=$user['role'] ?? 'user';

  //redirection de vers "index.php"
  header("Location: index.php");
  exit;
}else{
  print "Nom d'utilisateur ou mot de passe incorrect.";
}
?>

<?php require_once("header.php"); ?>

<form action="connection.php" method="post">
  <label for="identifiant">Nom d'utilisateur :</label>
  <input type="text" id="identifiant" name="identifiant" required>

  <label for="motdepasse">Mot de passe :</label>
  <input type="password" id="motdepasse" name="motdepasse" required>

  <button type="submit">Se connecter</button>
</form>

<?php require_once("footer.php"); ?>
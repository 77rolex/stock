<?php

if ($_POST) {
  require_once("dao.php"); //se connecte au DB
  $dao=new DAOStock();
  $dao->connection(); 

  $login=$_POST['exampleInputEmail1']?? ''; //recouperation des donnees du "form"
  $password=$_POST['exampleInputPassword1']?? '';

  $user=$dao->checkLogin($login,$password);
  
  if($user){
      //sauvegarde des donnees d'user dans la session
      $_SESSION['username']=$user['username'];
      $_SESSION['role']=$user['role'] ?? 'user';

      //redirection de vers "index.php"
      header("Location: index.php");
      exit;
    }else{?>
        <script>
          alert("Nom d'utilisateur ou mot de passe incorrect.");
        </script>
    <?php } 
}
?>

<?php require_once("header.php"); ?>

<main id="mainConnexion">

  <form action="connection.php" method="post" id="formConnexion">
    <div class="form-group">
      <label for="exampleInputEmail1">Nom d'utilisateur :</label>
      <input type="text" class="form-control" id="exampleInputEmail1" name="exampleInputEmail1" aria-describedby="emailHelp" required>
      <small class="form-text text-muted">Mettez votre nom d'utilisateur</small>
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Mot de passe :</label>
      <input type="password" class="form-control" id="exampleInputPassword1" name="exampleInputPassword1">
      <small class="form-text text-muted">Mettez votre mot de passe</small>
    </div>
    <br>
    <button type="submit" class="btn btn-primary">Se connecter</button>
  </form>

</main>

<?php require_once("footer.php"); ?>
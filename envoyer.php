<?php
session_start();
require_once("DAO.php");
$dao = new DAOStock();
$dao->connection();
unset($_SESSION['cart']);
?>
<?php require_once("header.php");?>
<main id="mainEnvoyer">
    <p id="pEnv">Votre commande a été envoyée!</p>
    <form action="index.php" method="post">
        <button class = "btn btn-info" id="btnRetourS">
            Retour vers le stock
        </button>
    </form>
</main>

<?php require_once("footer.php") ?>
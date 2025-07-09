<?php
require_once ("DAO.php");
$dao = new DAOStock();


$dao->connection();

$id = $_GET['id_produit'] ?? null; // recupere l'id product from stock_update.php or null

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // verification form sent by POST method
    $quantity = $_POST['qt'] ?? null; // recupere la qty depuis 
    $stmt =$dao-> dbh -> prepare("UPDATE produits SET qt = ? WHERE id_produit =? ");
    $stmt -> execute ([$quantity, $id]);
    print "Qty mis à jour";
}
 $stmt = $dao-> dbh -> prepare ("SELECT nom_produit, qt FROM produits WHERE id_produit = ?");
    $stmt->execute([$id]);
    $produit = $stmt->fetch;





?>
<!-- header -->
require_once("header.php");

<form method = "post">

    <label for="nom_produit">Nom de produit:</label><br>
    <input type="text" name="nom_produit" value="<?php $produit['nom_produit']; ?>"><br>
    <label for="qt">Qty:</label><br>
    <input type="number" name="qt" value="<?php $produit['qt']; ?>"><br><br>
    <button type="submit">Mettre à jour</button>
</form>
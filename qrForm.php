<?php
require_once ("DAO.php");


$dao = new DAOStock();
$dao->connection();
var_dump($_GET);


$id = $_GET['id_produit'] ?? null; // recupere l'id product from stock_update.php or null
if (!$id) {
    die("Product not exit.");
}

// Récupération du produit
$stmt = $dao->dbh->prepare("SELECT nom_produit, qt FROM produits WHERE id_produit = ?");
$stmt->execute([$id]);
$produit = $stmt->fetch();

if (!$produit) {
    die("Product unavailable.");
}

// Traitement de la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantity = $_POST['qt'] ?? null;

    if (is_numeric($quantity)) {
        $stmt = $dao->dbh->prepare("UPDATE produits SET qt = ? WHERE id_produit = ?");
        $stmt->execute([$quantity, $id]);
        $produit['qt'] = $quantity; // Mise à jour de la valeur affichée
        echo ">Quantité mise à jour avec succès.";
    } else {
        echo "Quantité invalide.";
    }
}
?>
<?php require_once("header.php");?>


<form method = "post">

    <label for="nom_produit">Nom de produit:</label><br>
    <input type="text" name="nom_produit" value="<?php print $produit['nom_produit']; ?>"><br>
    <label for="qt">Qty:</label><br>
    <input type="number" name="qt" value="<?php print $produit['qt']; ?>"><br><br>
    <button type="submit">Mettre à jour</button>
</form>
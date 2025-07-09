<?php
require_once("DAO.php");
$dao = new DAOStock();
$dao->connection();

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    die("ID invalide.");
}

$product = $dao->getProductById($id);
if (!$product) {
    die("Produit introuvable.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_quantity'])) {
    $newQty = intval($_POST['new_quantity']);
    $dao->updateProductQuantity($id, $newQty);
    $product['qt'] = $newQty;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Modifier Quantité</title>
</head>
<body style="font-family:sans-serif; max-width:600px; margin:40px auto;">
  <h2>Modifier la quantité: <?php echo htmlspecialchars($product['nom_produit']); ?></h2>
  <p>Quantité actuelle: <strong><?php echo $product['qt']; ?></strong></p>
  <form method="post">
    <label for="new_quantity">Nouvelle quantité:</label>
    <input type="number" id="new_quantity" name="new_quantity" value="<?php echo $product['qt']; ?>" min="0" required />
    <br><br>
    <button type="submit">Enregistrer</button>
    <a href="dashboard.php">Retour</a>
  </form>
</body>
</html>
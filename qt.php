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
<?php require_once("header.php"); ?>
<body style="font-family:sans-serif; max-width:600px; margin:40px auto;">
  <main id="mainQt">
    <h5 id="hQt"><p id="p1">Modifier la quantité:</p><hr><p id="p3"> <?php echo htmlspecialchars($product['nom_produit']); ?></p></h5>
    <p id="p2">Quantité actuelle: <strong><?php echo $product['qt']; ?></strong></p>
    <form method="post">
      <label for="new_quantity" id="labelQt">Nouvelle quantité:</label>
      <input type="number" id="new_quantity" name="new_quantity" value="<?php echo $product['qt']; ?>" min="0" required />
      <br><br>
      <hr>
      <button type="submit" class = "btn btn-info" id="btnSave">Enregistrer</button>
    </form>
  </main>
</body>
</html>
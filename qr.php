<?php
require_once __DIR__.'/vendor/autoload.php';
require_once("DAO.php");
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

$options = new QROptions([
    'version'    => 10,
    'outputType' => QRCode::OUTPUT_IMAGE_PNG,
    'eccLevel'   => QRCode::ECC_L,
]);

$dao = new DAOStock();
$dao->connection();

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    die("ID produit invalide.");
}

$product = $dao->getProductById($id);
if (!$product) {
    die("Produit introuvable.");
}

$url = "http://localhost/stock/qt.php?id=" . $product['id_produit'];

header("Content-Type: text/html; charset=UTF-8");
?>

<!DOCTYPE html>
<html>
<head>
  <title>QR Code - <?php echo htmlspecialchars($product['nom_produit']); ?></title>
</head>
<body style="text-align:center; font-family:sans-serif; margin-top:30px;">
  <h2>QR Code: <?php echo htmlspecialchars($product['nom_produit']); ?></h2>
  <p>Scannez pour modifier la quantité</p>
  <img src="<?php echo (new QRCode($options))->render($url); ?>" alt="QR Code" />
  <br><br>
  <a href="dashboard.php">⬅ Retour</a>
</body>
</html>
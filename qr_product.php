<?php
require_once(__DIR__."/qrlib.php"); // library PHP QR Code permet de générer des imgs de QR)
require_once(__DIR__."/fpdf.php"); // library fpdf permet de créer un fichier PDF)
require_once(__DIR__."/../DAO.php");

$dao = new DAOStock();
$dao ->connection();
$produits = $dao ->getAllProducts();

// create new pdf for QR code
$pdf = new FPDF();
$pdf->AddPage(); // add a empty page
$pdf->SetFont('Arial', '', 9); // Définit une police par défaut

// Coordonnées de départ et initialisation des colonnes
$x = 10;
$y = 10;
$col = 0;

foreach ($produits as $produit) {
    $id = $produit['id_produit'];
    $nom = $produit['nom_produit'];

    // Génération du QR code dans un fichier temporaire
    $dir = "temp_qr"; // create local directory to save QR codes
    if (!file_exists($dir)) mkdir($dir, 0777, true);
    $qrPath = $dir . "/qr_" . $id . ".png"; // "$dir/qr_$id.png"; 

    $url = "http://localhost/stock/stock/phpqrcode/temp_qr/stock_update.php?id_produit=" . urlencode($id);
    QRcode::png($url, $qrPath, QR_ECLEVEL_L, 4);

    // Affichage dans le PDF
    $pdf->Image($qrPath, $x, $y, 20, 20); // fille path + col $x , col $y , size 30mm
    $pdf-> SetXY($x, $y +18); // add a space after img
    $pdf->MultiCell(20, 5, utf8_decode($nom), 0, 'L');

    // Avancer la colonne
    $x += 50;
    $col++;

    // Passer à la ligne après 3 colonnes
    if ($col == 4) {
        $col = 0;
        $x = 10;
        $y += 50;
    }
}

$pdf->Output("I", "qr_planche.pdf");
$dao->deconnection();
    
?>
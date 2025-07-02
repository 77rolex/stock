<?php
// Connexion a la base de donnees avec gestion des erreurs
// username = userPays, pwd = Sivan_1625!
try {
    $dbh = new PDO('mysql:host=localhost;dbname=Stocks', "root", "");
	// print "Connexion reussie";
} catch (PDOException $e) {
	print $e -> getMessage();
    // tenter de reessayer la connexion apres un certain delai, exemple
	print "Oups ! connexion échouée.";
}
// Le formateur de son stock par un tableau de bord.
// Ce tbord contiendra tous les matériels (nom, unité, quantité), la localisation (la réserve) identifiable par couleur.

$produits = $dbh -> prepare("SELECT nom_produit, unite, qt, r.color
                            FROM produits p
                            JOIN category c ON c.id_category = p.category_id
                            JOIN reserves r ON r.id_reserve = p.reserve_id
                            ");
$produits->execute();


foreach ($produits as $produit) {
    echo "Nom du produit : " . ($produit['nom_produit']) . " Unité : " . ($produit['unite']) . " Qty : " . ($produit['qt']) ." Couleur : " . ($produit['color']) . "<br>";
}


?>



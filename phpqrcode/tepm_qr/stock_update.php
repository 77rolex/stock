<?php
if (isset($_GET['id_produit'])) {
    $id = intval($_GET['id_produit']);
    echo "Mise à jour du stock pour le produit ID : " . $id;

    // Ici tu peux ajouter la logique de mise à jour, par exemple :
    /*
    $pdo = new PDO(...);
    $sql = "UPDATE produits SET stock = stock - 1 WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    echo "Stock mis à jour.";
    */
} else {
    echo "ID produit manquant.";
}
?>

<?php 
require_once("header.php");
require_once("DAO.php");
$dao=new DAOStock();
$dao->connection();

$cart=$_SESSION['cart'] ?? [];

if(empty($cart)){
    print "<p>Votre panier est vide.</p>";
}else{
    print "Produits dans le panier: <ul>";
    foreach($cart as $product_id=>$qt){
        $product=$dao->getProductById($product_id);
        print "<li>".$product['nom_produit']." - $qt piece(s)</li>";
    }
    print "</ul>";
    print '<form action="" method="post">
            <button type="submit">Envoyer la commande</button>
        </form>';
}

?>



<?php require_once("footer.php") ?>
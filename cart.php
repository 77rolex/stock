<?php 
require_once("header.php");
require_once("DAO.php");
$dao=new DAOStock();
$dao->connection();

$cart=$_SESSION['cart'] ?? [];

if ($_POST) {
    $product_id = $_POST['listOfProducts'] ?? null;
    $quantity = $_POST['quantity'] ?? 0;

    if ($product_id && $quantity > 0) {
        $_SESSION['cart'][$product_id] = ($_SESSION['cart'][$product_id] ?? 0) + $quantity;
    }

    $delete_id = $_POST['delete_id'] ?? null;
    if ($delete_id) {
        unset($_SESSION['cart'][$delete_id]);
    }
}

if(empty($cart)){
    print "<p>Votre panier est vide.</p>";
}else{
    print "Produits dans le panier: <ul>";
    foreach($cart as $product_id=>$qt){
        $product=$dao->getProductById($product_id);
        print "<li>".$product['nom_produit']." - $qt pièce(s)</li>";
        print '<form action="cart.php" method="post" style="display:inline;">
                    <input type="hidden" name="delete_id" value="'.$product_id.'">
                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                </form>';
    }
    print "</ul>";
    print '<form action="" method="post">
            <button type="submit" class="btn btn-primary">Envoyer la commande</button>
        </form>';
}

?>

<?php require_once("footer.php") ?>
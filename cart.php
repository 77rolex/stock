<?php 
session_start();
require_once("header.php");

$cart = $_SESSION['cart'] ?? [];

if ($_POST) {
    $selected = $_POST['selected_products'] ?? [];
    $quantities = $_POST['quantities'] ?? [];

    foreach ($selected as $product_id) {
        $qt = isset($quantities[$product_id]) ? intval($quantities[$product_id]) : 0;
        if ($qt > 0) {
            $_SESSION['cart'][$product_id] = ($_SESSION['cart'][$product_id] ?? 0) + $qt;
        }
    }

    $delete_id = $_POST['delete_id'] ?? null;
    if ($delete_id) {
        unset($_SESSION['cart'][$delete_id]);
    }

    $cart = $_SESSION['cart'];
}

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

function renderCartHTML($dao, $cart) {
    if (empty($cart)) {
        echo "<p>Votre panier est vide.</p>";
    } else {
        echo "Produits dans le panier: <ul>";
        foreach ($cart as $product_id => $qt) {
            $product = $dao->getProductById($product_id);
            echo "<li>" . htmlspecialchars($product['nom_produit']) . " - $qt pièce(s)</li>";
            echo '<form action="cart.php" method="post" style="display:inline;">
                    <input type="hidden" name="delete_id" value="'.$product_id.'">
                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                </form>';
        }
        echo "</ul>";
        echo '<form action="" method="post">
                <button type="submit" class="btn btn-primary">Envoyer la commande</button>
              </form>';
    }
}

if ($isAjax) {
    renderCartHTML($dao, $cart);
    exit;
}

?>

<main class="container mt-3">
    <?php renderCartHTML($dao, $cart); ?>
</main>

<form action="index.php" method="post">
    <button class = "btn btn-info">
        Retour vers le stock
    </button>
</form>

<?php require_once("footer.php") ?>
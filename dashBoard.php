<?php
session_start();
// Connexion a la base de donnees avec gestion des erreurs
// username = formateur, pwd = formation
require_once("DAO.php");

// Le formateur de son stock par un tableau de bord.
// Ce tbord contiendra tous les matériels (nom, unité, quantité), la localisation (la réserve) identifiable par couleur.


// à inclure dans DAO remplacer par $produits = $dao -> getProduits()
public function getProduits() {
	$produits = $dbh -> prepare("SELECT nom_produit, unite, qt, r.color
                            FROM produits p
                            JOIN category c ON c.id_category = p.category_id
                            JOIN reserves r ON r.id_reserve = p.reserve_id
                            ");
$produits->execute();
}

    /* test
foreach ($produits as $produit) {
    echo "Nom du produit : " . ($produit['nom_produit']) . " Unité : " . ($produit['unite']) . " Qty : " . ($produit['qt']) ." Couleur : " . ($produit['color']) . "<br>";
}
    */

// à inclure dans DAO remplacer par $Searchbar = $dao -> getSearchbar()
// recupere la valeur saisie dans searchbar ou affiche vide
public function getSearchbar() {
    $search = $_GET['search'] ? "";

// affiche seulement depuis searchbar
$search_query = ("SELECT nom_produit, unite, qt, r.color
                            FROM produits p
                            JOIN category c ON c.id_category = p.category_id
                            JOIN reserves r ON r.id_reserve = p.reserve_id
                            WHERE p.nom_produit LIKE :search OR p.id_produit LIKE :search
                            ");
$stmt = $dbh -> prepare($search_query);
$stmt -> execute(["search" => "%$search"]); // %$search% qui contient le mot dans search

}


?>


<!-- header -->
<?php require_once("header.php");?>

<!-- main -->
<?php require_once("main.php");?>

<!-- search bar -->
<form action="" method="get">
    <input type="text" name="search" placeholder="Des recherches par matériel (saisie texte) ou par référence seront possibles." value="<?php $search ?>">
    <button type="submit">Search</button>
</form>

<!-- display d_board -->
<table>
<thead>
    <tr>
        <th>Nom du produit</th>
        <th>Unité</th>
        <th>Qty</th>
        <th>Couleur</th>

    </tr>
</thead>

</table>

<!-- footer -->
<?php require_once("footer.php");?>
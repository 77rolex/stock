// Connexion a la base de donnees avec gestion des erreurs
// username = formateur, pwd = formation
require_once("DAO.php");
$dao=new DAOStock();
$dao->connection();

// Le formateur de son stock par un tableau de bord.
// Ce tbord contiendra tous les matériels (nom, unité, quantité), la localisation (la réserve) identifiable par couleur.
$produits = $dao->getProduits();
 
// recupere la valeur saisie dans searchbar ou affiche vide
$produits = $dao->getSearchbar();

?>


<!-- header -->
<?php require_once("header.php");?>

<!-- main -->
<?php require_once("main.php");?>

<style>
    tr, td
    .reserve_color {
        display: inline-block;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        margin-right: 6px;
    }

    .alerte {
        background-color: #ff6347;
    }
</style>
<!-- search bar -->
<form method="get">
    <input type="text" name="search" placeholder="Des recherches par matériel (saisie texte) ou par référence seront possibles." value="">
    <button type="submit">Search</button>
    <input type="number" name="seuil" placeholder="fixer le seuil d’alerte (quantité minimale) pour déclencher une commande" value="">
    <button type="submit">Fixer le seuil</button>
</form>

<!-- display d_board -->
<table>
<thead>
    <tr>
        <th>Nom du produit</th>
        <th>Unité</th>
        <th>Qty</th>
        <th>Reserve</th>
        <th>Category</th>
        <th>Alerte</th>
    </tr>
    </thead>
    <tbody>
        <?php $seuil = $_GET["seuil"] ?? null; ?>
        <?php foreach($produits as $row){ ?>
            <?php $alerte = ($seuil !== null && is_numeric($seuil) && $row["qt"] <= $seuil); ?> <!-- seuil defini && est un number && qt trop bas si conditions is true = $alerte -->
        <tr class="<?php $alerte ? "alerte" : "" ; ?>"> <!-- $alerte = true = class .alerte = color or non -->
        <td><?php print $row["nom_produit"];?></td>
        <td><?php print $row["unite"];?></td>
        <td><?php print $row["qt"];?></td>
        <td><div class = "reserve_color" style="background-color:<?php print $row["color"];?>;"></div>
        <?php print $row["reserve_name"];?>
        </td>
        <td><?php print $row["nom_category"];?></td>
        <td><div class = "alerte" style = "background-color:<?php ($row["qt"] <= $seuil) ;?>"></div></td>
    </tr>
    <?php } ?>

    </tbody>

</table>

<!-- footer -->
<?php require_once("footer.php");?>
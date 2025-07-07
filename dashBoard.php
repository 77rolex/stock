<?php
// Connexion a la base de donnees avec gestion des erreurs
// username = formateur, pwd = formation
require_once("DAO.php");
$dao=new DAOStock();
$dao->connection();

// Le formateur de son stock par un tableau de bord.
// Ce tbord contiendra tous les matériels (nom, unité, quantité), la localisation (la réserve) identifiable par couleur.
// $produits = $dao->getProduits();
// recupere la valeur du form
//$search = $_GET['search'] ?? "";
 
// recupere la valeur saisie dans searchbar ou affiche vide
$produits = $dao->getSearchbar();

// $alerte = $dao->getBelowSeuil();
$seuil = $_GET["seuil"] ?? null;
if (!is_numeric($seuil)){
    $seuil = null;
}

?>


<!-- header -->
<?php require_once("header.php");?>

<!-- css for reserve color and seuil   -->
<style>
   
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

<!-- main -->
<?php require_once("main.php");?>

<!-- search bar -->
<form method="get">
    <input type="text" name="search" placeholder="Des recherches par matériel (saisie texte) ou par référence seront possibles." value="">
    <button type="submit" class="btn btn-primary">Search</button>
    
    <?php if($_SESSION['role']==='formateur'): ?>
        <input type="number" name="seuil" placeholder="fixer le seuil d’alerte (quantité minimale) pour déclencher une commande" value="">
        <button type="submit" class="btn btn-primary">Fixer le seuil</button>
    <?php endif ?> 
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
    </tr>
    </thead>
    <tbody>
        <!--?php $seuil = $_GET["seuil"] ?? null; ?-->
        <?php foreach($produits as $row){ ?>
            <?php $alerte = ($seuil !== null && $row["qt"] <= $seuil); ?> <!-- seuil defini && est un number && qt trop bas si conditions is true = $alerte -->
        <!--?php $alerte = $dao->getBelowSeuil($row["qt"] <= $seuil) ; ?-->
        <tr class="<?php print $alerte ? "alerte" : "" ; ?>"> <!-- $alerte = true = class .alerte = color or non -->
        <td><?php print ($row["nom_produit"]);?></td>
        <td><?php print ($row["unite"]);?></td>
        <td><?php print ($row["qt"]);?></td>
        <td><div class = "reserve_color" style="background-color:<?php print ($row["color"]);?>;"></div>
        <?php print ($row["reserve_name"]);?>
        </td>
        <td><?php print ($row["nom_category"]);?></td>
        <td><?php print $alerte ? '<div class = "reserve_color" class = "alerte";"></div>' : "" ;?>
            
        </td>
    </tr>
    <?php } ?>

    </tbody>

</table>

<!-- footer -->
<?php require_once("footer.php");?>
<?php
require_once("DAO.php");
$dao=new DAOStock();
$dao->connection();

$produits = $dao->getSearchbar();

//$seuil = $dao->getBelowSeuil();
$seuil = $_GET["seuil"] ?? null;
if (!is_numeric($seuil)){
    $seuil = null;
}

$dao->deconnection();
?>

<!-- css for reserve color and seuil   -->
<style>
   
    .reserve_color {
        display: inline-block;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        margin-right: 6px;
    }

    tr.alerte td{
        background-color: #ff6347;
    }
</style>

<!-- search bar -->
<form method="get">
    <div class="input-group mb-3" style="width:80%">
    <input class="form-control" type="text" name="search" placeholder="Des recherches par matériel (saisie texte) ou par référence seront possibles." value="<?php print ($_GET["search"])?? "" ;?>">
    <button type="submit" class="btn btn-info">Search</button>
    </div>
    <?php if($_SESSION['role']==='formateur'): ?>
        <div class="input-group mb-3" style="width:80%">
        <input class="form-control" type = "number" name = "seuil" placeholder = "fixer le seuil d’alerte (quantité minimale) pour déclencher une commande" value = "<?php print ($_GET["seuil"])?? "" ;?>">
        <button type = "submit" name = "fixed" class = "btn btn-info">Fixer le seuil</button>
        </div>
    <?php endif ?> 
</form>

<nav id="navPopUp">
    <?php if($_SESSION['role']==='formateur'): ?>
        <form action="cart.php">
        <?php if($_SESSION['role']==='formateur'): ?>
            <button type="submit" class="btn btn-info" class="w3-display-right">
                Panier
            </button>
        <?php endif ?>   
        </form>
    <br>
        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Commander
        </button>
        <?php endif ?>
        <br><br>     
</nav>
    <?php if($_SESSION['role']==='formateur'):?>       
        <h1 style= "text-align:center";>Dashboard Formateur</h1>
        <?php endif ?>
        <?php if($_SESSION['role']==='stagiare'):?>  
        <h1 style= "text-align:center";>Dashboard Stagiaire</h1>
        <?php endif ?>
<!-- display d_board -->
<table class="table table-dark table-hover">
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
        <td><?php print ($row["nom_category"]);?>
        <?php print $alerte ? '<div class = "reserve_color alerte";"></div>' : "" ;?> </td>
        
    </tr>
    <?php } ?>

    </tbody>

</table>


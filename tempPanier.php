<?php 
require_once("header.php");
require_once("DAO.php");
$dao=new DAOStock();
$dao->connection();

$produits = $dao->getSearchbar();

//$seuil = $dao->getBelowSeuil();
$seuil = $_GET["seuil"] ?? null;
if (!is_numeric($seuil)){
    $seuil = null;
}
?>

<!-- search bar -->
<form method="get">
    <div class="input-group mb-3" style="width:80%">
    <input class="form-control" type="text" name="search" placeholder="Des recherches par matériel (saisie texte) ou par référence seront possibles." value="<?php print ($_GET["search"])?? "" ;?>">
    <button type="submit" class="btn btn-info">Search</button>
    </div>
    <!--?php if($_SESSION['role']==='formateur'): ?-->
        <div class="input-group mb-3" style="width:80%">
        <input class="form-control" type = "number" name = "seuil" placeholder = "fixer le seuil d’alerte (quantité minimale) pour déclencher une commande" value = "<?php print ($_GET["seuil"])?? "" ;?>">
        <button type = "submit" name = "fixed" class = "btn btn-info">Fixer le seuil</button>
        </div>
    <!--?php endif ?--> 
</form>

<h1 style= "text-align:center";>Dashboard Panier temporaire</h1>
<table id="myTable" class="table table-dark table-hover display">
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
        
        <?php foreach($produits as $row){ ?>
         <?php $alerte = ($seuil !== null && $row["qt"] <= $seuil); ?>
          
        <tr class="alerte"> 
        <td><?php print ($row["nom_produit"]);?></td>
        <td><?php print ($row["unite"]);?></td>
        <td><?php print ($row["qt"]);?></td>
        <td><div class = "reserve_color" style="background-color:<?php print ($row["color"]);?>;"></div>
            <?php print ($row["reserve_name"]);?>
        </td>
        <td><?php print ($row["nom_category"]);?></td>
        
    </tr>
    <?php } ?>

    </tbody>

</table>
<!--
<script>
    $(document).ready(function () {
        $('#myTble').DataTable({
            "order": [[3, "asc"]] // Default sorting on the 4th column (Age) in ascending order
        });
    });
</script>-->
<?php require_once("deconnection.php"); ?>


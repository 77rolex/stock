<?php 
require_once("header.php");
require_once("DAO.php");
$dao=new DAOStock();
$dao->connection();

// recuperation seuil depuis URL
$seuil = $_GET["seuil"] ?? null ;
$produits = $dao->getBelowSeuil($seuil);
?>


<!-- main -->
<?php require_once("main.php");?>

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
           
        <tr class="alerte">
        <td><?php print ($row["nom_produit"]);?></td>
        <td><?php print ($row["unite"]);?></td>
        <td><?php print ($row["qt"]);?></td>
        <td><div class = "reserve_color" style="background-color:<?php print ($row["color"]);?>;"></div>
        <?php print ($row["reserve_name"]);?>
        </td>
        <td><?php print ($row["nom_category"]);?>
        <div class = "reserve_color alerte"></div>
        </td>
        
    </tr>
    <?php } ?>

    </tbody>

</table>
<script>
    $(document).ready(function () {
        $('#myTable').DataTable({
            "order": [[3, "asc"]] // Default sorting on the 4th column (Age) in ascending order
        });
    });
</script>

<!-- footer -->
<?php require_once("footer.php");?>
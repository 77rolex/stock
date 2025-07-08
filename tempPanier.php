<?php 
require_once("header.php");
require_once("DAO.php");
$dao=new DAOStock();
$dao->connection();

$seuil = $dao->getBelowSeuil();

?>


<!-- main -->
<?php require_once("main.php");?>

<br>
        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Se deconnecter
            <!--redirection de vers "connection.php"-->
            <?php $dao -> deconnection() ;?>
         <br><br>

<table id="myTble" class="table table-dark table-hover display">
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
<script>
    $(document).ready(function () {
        $('#myTable').DataTable({
            "order": [[3, "asc"]] // Default sorting on the 4th column (Age) in ascending order
        });
    });
</script>

<!-- footer -->
<?php require_once("footer.php");?>
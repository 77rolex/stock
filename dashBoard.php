<?php
$produits = $dao->getSearchbar();

//$seuil = $dao->getBelowSeuil();
$seuil = $_GET["seuil"] ?? null;
if (!is_numeric($seuil)){
    $seuil = null;
}
?>

<!-- search bar -->
 <section id="sectionNav">

    <form method="get" id="formChercher">
        <div class="input-group mb-3" style="width:100%">
            <input class="form-control" type="text" name="search" placeholder="Des recherches par matériel (saisie texte) ou par référence seront possibles." value="<?php print ($_GET["search"])?? "" ;?>">
            <button type="submit" class="btn btn-info" id="btnChercher">
                Chercher
            </button>
        </div>
        <?php if($_SESSION['role']==='formateur'): ?>
            <div class="input-group mb-3" style="width:100%">
                <input class="form-control" type = "number" name = "seuil" placeholder = "fixer le seuil d’alerte (quantité minimale) pour déclencher une commande" value = "<?php print ($_GET["seuil"])?? "" ;?>">
                <button type = "submit" name = "fixed" class = "btn btn-info" id="btnFixer">
                    Fixer le seuil
                </button>
            </div>
        <?php endif ?> 
    </form>

    <section id="sectionNavForm">
        <nav id="navPopUp">
            <?php if($_SESSION['role']==='formateur'): ?>
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Commander
                </button>
                <form action="cart.php">
                    <button type="submit" class="btn btn-info" class="w3-display-right">
                        Panier
                    </button>
                </form>
            <?php endif ?>
        </nav>
        <form action="deconnection.php" method="post">
            <button type="submit" name="logout" class="btn btn-info">
                Se déconnecter
            </button>
        </form>
    </section>

</section>
<!-- <a href="deconnection.php">Se deconnecter</a> -->
    <?php if($_SESSION['role']==='formateur'):?>       
            <h1 class="text-center mb-4" style= "text-align:center";>Dashboard Formateur</h1>
    <?php endif ?>
    <?php if($_SESSION['role']==='stagiare'):?>  
            <h1 class="text-center mb-4" style= "text-align:center";>Dashboard Stagiaire</h1>
    <?php endif ?>
<!-- display d_board -->
<table id = "myTable" class="table table-dark table-hover">
<thead>
    <tr>
        <th>Nom du produit</th>
        <th>Unité</th>
        <th>Qty</th>
        <th>Reserve</th>
        <th>Category</th>
        <?php if($_SESSION['role']==='formateur'): ?>
            <th>QR</th>
        <?php endif ?> 
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
        <td>
            <div class = "reserve_color" style="background-color:<?php print ($row["color"]);?>;"></div>
            <?php print ($row["reserve_name"]);?>
        </td>
        <td><?php print ($row["nom_category"]);?></td>
        <?php if($_SESSION['role']==='formateur'): ?>
            <td>
                <a href="qr.php?id=<?php echo $row['id_produit']; ?>" class="btn btn-sm btn-primary" target="_blank">
                    Voir QR Code  
                </a><?php print $alerte ? '<div class = "reserve_color alerte"></div>' : "" ;?>
            </td>
        <?php endif ?> 
    </tr>
    <?php } ?>

    </tbody>

</table>

<script>
    $(document).ready(function () {
        $('#myTable').DataTable({
            "order": [[3, "asc"]], // Tri par défaut sur la 4e colonne
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
            }
        });
    });
</script>
<?php $dao->deconnection(); ?>


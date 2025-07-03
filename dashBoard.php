<?php
session_start();
// Connexion a la base de donnees avec gestion des erreurs
// username = formateur, pwd = formation
require_once("DAO.php");
$dao=new DAOStock();
$dao->connection();

// Le formateur de son stock par un tableau de bord.
// Ce tbord contiendra tous les matériels (nom, unité, quantité), la localisation (la réserve) identifiable par couleur.
$produits=$dao->getProduits();
 
// recupere la valeur saisie dans searchbar ou affiche vide
$produit=$dao->getSearchbar()

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
        <th>Reserve</th>
        <th>Category</th>
        <th>Alerte</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach($produits as $row){ ?>
         <tr>
        <td><?php print $row["nom_produit"];?></td>
        <td><?php print $row["unite"];?></td>
        <td><?php print $row["qt"];?></td>
        <td><div style="background-color:<?php print $row["color"];?>;"></div></td>
        <td><?php print $row["reserve_name"];?></td>
        <td><?php print $row["nom_category"];?></td>
        <td><div style="background-color:<?php ("qy" <= "10") ? 'orange' : 'vert';?>"></div></td>
    </tr>
    <?php } ?>
       
    </tbody>

</table>

<!-- footer -->
<?php require_once("footer.php");?>
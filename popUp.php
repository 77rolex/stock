<?php 
require_once("header.php"); 
require_once("DAO.php");
$dao=new DAOStock();
$dao->connection(); 
?>

<?php 
    $products=$dao->getListOfProducts();
?>

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Commander
</button>
<!-- <?php if($_SESSION['role']==='formateur'): ?>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Commander</button>
<?php endif ?> -->
<main id="mainPopUp">
    <form action="">
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    
          <div class="modal-dialog" id="divCentrePopUp">
            <div class="modal-content" id="divPopUp">
              <div class="modal-header">
                <h5 class="modal-title">Commandes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">

                  <select name="listOfProducts" id="listOfProducts">

                    <?php foreach($products as $product){ ?>
                      <option value="<?php print $product['id_produit']; ?>">
                        <?php print $product['nom_produit']; ?>
                      </option>
                    <?php } ?>

                  </select>

                  <input type="number" id="inputCommand">
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary">Envoyer la commande</button>
              </div>
            </div>
          </div>
        </div>
    </form>
</main>
<?php require_once("footer.php"); ?>  
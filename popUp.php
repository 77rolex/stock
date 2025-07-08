<?php 
require_once("header.php"); 
require_once("DAO.php");
$dao=new DAOStock();
$dao->connection(); 
?>

<?php 
    // $products=$dao->getListOfProducts();
    $seuil = $_GET["seuil"] ?? null;
    if (is_numeric($seuil)) {
      $products = $dao->getProductsBelowSeuil($seuil);  
    } else {
      $products = [];  
    }
?>

<main id="mainPopUp">
    <form id="addToCartForm">
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" id="divCentrePopUp">
      <div class="modal-content" id="divPopUp">
        <div class="modal-header">
          <h5 class="modal-title">Commandes</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <select name="listOfProducts" id="listOfProducts" class="form-select">
            <?php foreach($products as $product){ ?>
              <option value="<?php print $product['id_produit']; ?>">
                <?php print $product['nom_produit']; ?>
              </option>
            <?php } ?>
          </select>

          <label for="inputCommand" class="form-label mt-3">Quantité:</label>
          <input type="number" name="quantity" id="inputCommand" class="form-control" required>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
          <button type="submit" class="btn btn-primary">Ajouter au panier</button>
        </div>
      </div>
    </div>
  </div>
</form>

</main>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055">
  <div id="toastSuccess" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        Produit ajouté au panier !
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>


<script>
document.getElementById("addToCartForm").addEventListener("submit", function(e) {
  e.preventDefault();

  const formData = new FormData(this);

  fetch("cart.php", {
    method: "POST",
    body: formData
  })
  .then(response => response.text())
  .then(data => {
    const toast = new bootstrap.Toast(document.getElementById("toastSuccess"));
    toast.show();

    // Закрыть модалку после добавления
    const modal = bootstrap.Modal.getInstance(document.getElementById("exampleModal"));
    modal.hide();
  })
  .catch(error => {
    console.error("Erreur :", error);
  });
});
</script>
<?php require_once("footer.php"); ?>  
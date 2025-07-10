<?php 
  $search = $_GET['search'] ?? "";
  $seuil = $_GET['seuil'] ?? null;
  $products = $dao->getFilteredProducts($search, $seuil);
?>
<section id="mainPopUp">
    <form id="addToCartForm">
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" id="divCentrePopUp">
                <div class="modal-content" id="divPopUp">
                            <div class="modal-header">
                                <h5 class="modal-title">Commandes</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <div class="list-group">
                                <?php foreach ($products as $product): ?>
                                    <label class="list-group-item">
                                      <input class="form-check-input me-1" type="checkbox" name="selected_products[]" value="<?php print $product['id_produit']; ?>">
                                      <?php print $product['nom_produit']; ?>
                                      <input type="number" name="quantities[<?php print $product['id_produit']; ?>]" class="form-control mt-2" min="1" placeholder="Quantité">
                                    </label>
                                  <?php endforeach; ?>
                              </div>
                            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnFermer">Fermer</button>
                    <button type="submit" class="btn btn-info" id="btnAjouter">Ajouter au panier</button>
                </div>  
                </div>
            </div>
        </div>
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
    </form>
</section>
<script>
document.getElementById("addToCartForm").addEventListener("submit", function(e) {
  e.preventDefault();
  const formData = new FormData(this);
  const selectedProducts = formData.getAll("selected_products[]");
  
  if (selectedProducts.length === 0) {
    alert("Veuillez sélectionner au moins un produit.");
    return;
  }

  let missingQuantity = false;

  selectedProducts.forEach(productId => {
    const quantityInput = this.querySelector(`[name="quantities[${productId}]"]`);
    const quantity = quantityInput?.value;
    if (!quantity || parseInt(quantity) <= 0) {
      missingQuantity = true;
    }
  });
  if (missingQuantity) {
    alert("Veuillez saisir une quantité valide (minimum 1) pour chaque produit sélectionné.");
    return;
  }
  fetch("cart.php", {
    method: "POST",
    body: formData
  })
  .then(response => response.text())
  .then(data => {
    const toast = new bootstrap.Toast(document.getElementById("toastSuccess"));
    toast.show();

    const modal = bootstrap.Modal.getInstance(document.getElementById("exampleModal"));
    modal.hide();

    updateCartUI();
  })
  .catch(error => {
    console.error("Erreur :", error);
  });
});
</script>
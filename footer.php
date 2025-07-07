<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
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
</body>
</html>
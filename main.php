<main>
    stockage
    <?php if($_SESSION['role']==='formateur'): ?>
        <button>Commander</button>
    <?php endif ?>

    <?php require_once("dashBoard.php"); ?>
</main>
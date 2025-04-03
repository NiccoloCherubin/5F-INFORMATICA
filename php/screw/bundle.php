<?php
include 'php/Database.php';
$pdo = Database::connect();
$bundles = $pdo->query("SELECT * FROM bundle")->fetchAll();
include 'php/header.php';
?>
<div class="container my-4">
    <h1>Bundles</h1>
    <div class="row">
        <?php foreach ($bundles as $bundle): ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img src="<?php echo $bundle->immagine; ?>" class="card-img-top" alt="<?php echo $bundle->nome; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $bundle->nome; ?></h5>
                        <p class="card-text"><?php echo $bundle->prezzo; ?>€</p>
                        <a href="bundleDetails.php?id=<?php echo $bundle->id; ?>" class="btn btn-primary">Dettagli</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include 'php/footer.php'; ?>

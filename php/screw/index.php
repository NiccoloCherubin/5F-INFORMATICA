<?php
include 'php/Database.php';
$pdo = Database::connect();
$prodotti = $pdo->query("SELECT * FROM prodotti LIMIT 2")->fetchAll();
include 'php/header.php';
?>
<div class="container my-4">
    <h1>Benvenuto nel nostro e-commerce</h1>
    <div class="row">
        <?php foreach ($prodotti as $prodotto): ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img src="<?php echo $prodotto->immagine; ?>" class="card-img-top" alt="<?php echo $prodotto->nome; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $prodotto->nome; ?></h5>
                        <p class="card-text"><?php echo $prodotto->prezzo; ?>€</p>
                        <a href="prodotto.php?id=<?php echo $prodotto->id; ?>" class="btn btn-primary">Dettagli</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include 'php/footer.php'; ?>

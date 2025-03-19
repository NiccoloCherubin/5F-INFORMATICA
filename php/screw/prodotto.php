<?php
include 'php/Database.php';
$pdo = Database::connect();
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM prodotti WHERE id = ?");
$stmt->execute([$id]);
$prodotto = $stmt->fetch();
if (!$prodotto) die("Prodotto non trovato");
include 'php/header.php';
?>
<div class="container my-4">
    <div class="row">
        <div class="col-md-6">
            <img src="<?php echo $prodotto->immagine; ?>" class="img-fluid" alt="<?php echo $prodotto->nome; ?>">
        </div>
        <div class="col-md-6">
            <h1><?php echo $prodotto->nome; ?></h1>
            <p><?php echo $prodotto->descrizione; ?></p>
            <p>Prezzo: <?php echo $prodotto->prezzo; ?>€</p>
            <a href="carrello.php?add=<?php echo $prodotto->id; ?>" class="btn btn-success">Aggiungi al carrello</a>
        </div>
    </div>
</div>
<?php include 'php/footer.php'; ?>

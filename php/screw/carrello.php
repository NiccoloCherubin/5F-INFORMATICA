<?php
session_start();
include 'php/Database.php';
$pdo = Database::connect();
if (!isset($_SESSION['carrello'])) {
    $_SESSION['carrello'] = [];
}
if (isset($_GET['add'])) {
    $id = $_GET['add'];
    $_SESSION['carrello'][$id] = ($_SESSION['carrello'][$id] ?? 0) + 1;
}
if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    if (isset($_SESSION['carrello'][$id])) {
        unset($_SESSION['carrello'][$id]);
    }
}
$prodotti = [];
foreach ($_SESSION['carrello'] as $id => $quantita) {
    $stmt = $pdo->prepare("SELECT * FROM prodotti WHERE id = ?");
    $stmt->execute([$id]);
    $prodotto = $stmt->fetch();
    if ($prodotto) {
        $prodotto->quantita = $quantita;
        $prodotti[] = $prodotto;
    }
}
include 'php/header.php';
?>
<div class="container my-4">
    <h1>Il tuo carrello</h1>
    <?php if (empty($prodotti)): ?>
        <p>Il carrello è vuoto.</p>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($prodotti as $prodotto): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php echo $prodotto->nome; ?> - <?php echo $prodotto->quantita; ?> x <?php echo $prodotto->prezzo; ?>€
                    <a href="carrello.php?remove=<?php echo $prodotto->id; ?>" class="btn btn-danger btn-sm">Rimuovi</a>
                </li>
            <?php endforeach; ?>
        </ul>
        <a href="checkout.php" class="btn btn-primary mt-3">Procedi al checkout</a>
    <?php endif; ?>
</div>
<?php include 'php/footer.php'; ?>

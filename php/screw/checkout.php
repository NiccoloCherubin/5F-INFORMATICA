<?php
session_start();
include 'php/Database.php';
$pdo = Database::connect();

// Assicurati che l'utente sia loggato e che il suo id sia memorizzato in $_SESSION['user_id']
if (!isset($_SESSION['user_id'])) {
    die("Devi essere loggato per effettuare un ordine.");
}

if (empty($_SESSION['carrello'])) {
    die("Il carrello è vuoto.");
}

$totale = 0;
foreach ($_SESSION['carrello'] as $id => $quantita) {
    $stmt = $pdo->prepare("SELECT * FROM prodotti WHERE id = ?");
    $stmt->execute([$id]);
    $prodotto = $stmt->fetch();
    $totale += $prodotto->prezzo * $quantita;
}

// Usa l'id dell'utente loggato
$utente_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("INSERT INTO ordini (utente_id, totale) VALUES (?, ?)");
$stmt->execute([$utente_id, $totale]);

$_SESSION['carrello'] = [];

include 'php/header.php';
?>
<div class="container my-4">
    <h1>Grazie per il tuo ordine!</h1>
    <p>Il totale dell'ordine è <?php echo $totale; ?>€.</p>
    <a href="index.php" class="btn btn-primary">Torna alla home</a>
</div>
<?php include 'php/footer.php'; ?>

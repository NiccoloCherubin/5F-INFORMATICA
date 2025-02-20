<?php
include "php/db.php";

// Ottieni tutti i sovrani
$query = "SELECT * FROM sovrani ORDER BY data_inizio ASC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$sovrani = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Aggiorna i riferimenti ai sovrani precedenti e successivi
foreach ($sovrani as $sovrano) {
    // Trova il sovrano precedente
    $query_precendente = "SELECT nome FROM sovrani WHERE data_fine < :data_inizio ORDER BY data_fine DESC LIMIT 1";
    $stmt_precendente = $pdo->prepare($query_precendente);
    $stmt_precendente->bindParam(':data_inizio', $sovrano['data_inizio']);
    $stmt_precendente->execute();
    $sovrano_precendente = $stmt_precendente->fetchColumn();

    // Trova il sovrano successivo
    $query_successivo = "SELECT nome FROM sovrani WHERE data_inizio > :data_inizio ORDER BY data_inizio ASC LIMIT 1";
    $stmt_successivo = $pdo->prepare($query_successivo);
    $stmt_successivo->bindParam(':data_inizio', $sovrano['data_inizio']);
    $stmt_successivo->execute();
    $sovrano_successivo = $stmt_successivo->fetchColumn();

    // Imposta null se non esistono sovrani precedenti o successivi
    $sovrano_precendente = $sovrano_precendente ?: NULL;
    $sovrano_successivo = $sovrano_successivo ?: NULL;

    // Se è stato trovato un sovrano successivo, aggiorna il campo sovrano_precendente del sovrano successivo
    if ($sovrano_successivo) {
        $query_update = "UPDATE sovrani SET sovrano_precendente = ? WHERE nome = ?";
        $stmt_update = $pdo->prepare($query_update);
        $stmt_update->execute([$sovrano['nome'], $sovrano_successivo]);
    }

    // Se è stato trovato un sovrano precedente, aggiorna il campo sovrano_successivo del sovrano precedente
    if ($sovrano_precendente) {
        $query_update = "UPDATE sovrani SET sovrano_successivo = ? WHERE nome = ?";
        $stmt_update = $pdo->prepare($query_update);
        $stmt_update->execute([$sovrano['nome'], $sovrano_precendente]);
    }
}

?>

<!-- HTML per visualizzare la lista dei sovrani -->
<div class="container my-5">
    <h2 class="mb-4">Lista dei Sovrani</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Data Inizio</th>
            <th>Data Fine</th>
            <th>Immagine</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($sovrani as $sovrano): ?>
            <tr>
                <td><?= htmlspecialchars($sovrano['nome']) ?></td>
                <td><?= htmlspecialchars($sovrano['data_inizio']) ?></td>
                <td><?= htmlspecialchars($sovrano['data_fine']) ?></td>
                <td><img src="../images/<?= htmlspecialchars($sovrano['immagine']) . '.' . htmlspecialchars($sovrano['estensione']) ?>" alt="Immagine di <?= htmlspecialchars($sovrano['nome']) ?>" width="50"></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
include "php/header.php";
include "php/db.php";

// Ottieni tutti i sovrani
$query = "SELECT * FROM sovrani ORDER BY data_inizio ASC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$sovrani = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ciclo per aggiornare i sovrani
for ($i = 0; $i < count($sovrani); $i++) {
    $sovrano = $sovrani[$i];

    // Il sovrano precedente è quello immediatamente precedente nell'array
    $sovrano_precedente = $i > 0 ? $sovrani[$i - 1]['nome'] : NULL;

    // Il sovrano successivo è quello immediatamente successivo nell'array
    $sovrano_successivo = $i < count($sovrani) - 1 ? $sovrani[$i + 1]['nome'] : NULL;

    echo "Sovrano: " . $sovrano['nome'] . "<br>";
    echo "Precedente: " . ($sovrano_precedente ?: 'Nessuno') . "<br>";
    echo "Successivo: " . ($sovrano_successivo ?: 'Nessuno') . "<br>";

    // Aggiornamento nel database
    $query_update = "UPDATE sovrani SET sovrano_precedente = ?, sovrano_successivo = ? WHERE nome = ?";
    $stmt_update = $pdo->prepare($query_update);
    $stmt_update->execute([$sovrano_precedente, $sovrano_successivo, $sovrano['nome']]);
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
            <th>Sovrano Precedente</th>
            <th>Sovrano Successivo</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($sovrani as $sovrano): ?>
            <tr>
                <td><?= htmlspecialchars($sovrano['nome']) ?></td>
                <td><?= htmlspecialchars($sovrano['data_inizio']) ?></td>
                <td><?= htmlspecialchars($sovrano['data_fine']) ?></td>
                <td>
                    <?php if (!empty($sovrano['immagine']) && !empty($sovrano['estensione'])): ?>
                        <img src="images/<?= htmlspecialchars($sovrano['immagine']) . '.' . htmlspecialchars($sovrano['estensione']) ?>"
                             alt="Immagine di <?= htmlspecialchars($sovrano['nome']) ?>" width="50">
                    <?php else: ?>
                        Nessuna immagine
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($sovrano['sovrano_precedente'] ?? 'Nessuno') ?></td>
                <td><?= htmlspecialchars($sovrano['sovrano_successivo'] ?? 'Nessuno') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'php/footer.php'; ?>

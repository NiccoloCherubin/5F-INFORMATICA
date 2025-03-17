<?php
// Includiamo la classe Database
include_once 'php/Database.php';

session_start(); // Gestione della sessione per il login

// Verifica se l'utente è autenticato come personale
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Se non è autenticato, redirige alla pagina di login
    exit();
}

$messaggio = '';
$plichi = []; // Array per memorizzare i plichi disponibili per il ritiro

// Recupera tutti i plichi in stato "In attesa" o "In transito" (stato 1 o 2)
try {
    $plichi = Database::select("
        SELECT 
            p.id AS plico_id, 
            c.nome AS mittente_nome, 
            c.cognome AS mittente_cognome, 
            d.nome AS destinatario_nome,  
            d.cognome AS destinatario_cognome, 
            s.descrizione AS stato_plico,
            p.data_ritiro
        FROM Plichi p
        JOIN Spedire sp ON sp.Plichi_id = p.id
        JOIN Clienti c ON c.id = sp.Clienti_id
        JOIN Ritirare r ON r.Plichi_id = p.id
        JOIN Destinatari d ON d.id = r.Destinatari_id
        JOIN Stati s ON s.id = p.Stati_id
        WHERE p.Stati_id IN (1, 2)
        ORDER BY p.id DESC
    ");
} catch (Exception $e) {
    $errore = "Errore nel recupero dei plichi: " . $e->getMessage();
}

// Gestione del form di ritiro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = Database::connect();
        $pdo->beginTransaction();

        $plico_id = $_POST['plico_id'];

        // Aggiorna lo stato del plico a "Consegnato" (stato 3)
        $stmt = $pdo->prepare("UPDATE Plichi SET Stati_id = 3 WHERE id = :plico_id");
        $stmt->execute(['plico_id' => $plico_id]);

        // Aggiorna la data_conferma nella tabella Ritirare
        $stmt = $pdo->prepare("UPDATE Ritirare SET data_conferma = NOW() WHERE Plichi_id = :plico_id");
        $stmt->execute(['plico_id' => $plico_id]);

        $pdo->commit();
        $messaggio = "Ritiro registrato con successo!";

        // Aggiorna la lista dei plichi disponibili
        $plichi = Database::select("
            SELECT 
                p.id AS plico_id, 
                c.nome AS mittente_nome, 
                c.cognome AS mittente_cognome, 
                d.nome AS destinatario_nome,  
                d.cognome AS destinatario_cognome, 
                s.descrizione AS stato_plico,
                p.data_ritiro
            FROM Plichi p
            JOIN Spedire sp ON sp.Plichi_id = p.id
            JOIN Clienti c ON c.id = sp.Clienti_id
            JOIN Ritirare r ON r.Plichi_id = p.id
            JOIN Destinatari d ON d.id = r.Destinatari_id
            JOIN Stati s ON s.id = p.Stati_id
            WHERE p.Stati_id IN (1, 2)
            ORDER BY p.id DESC
        ");
    } catch (Exception $e) {
        $pdo->rollBack();
        $messaggio = "Errore durante la registrazione del ritiro: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registra Ritiro - FastRoute</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'php/header.php'; ?>

<div class="container my-5">
    <h2>Registra Ritiro Plico</h2>
    <p class="lead">Completa il ritiro di un plico da parte del destinatario.</p>

    <?php if (!empty($messaggio)): ?>
        <div class="alert <?php echo strpos($messaggio, 'Errore') !== false ? 'alert-danger' : 'alert-success'; ?>">
            <?php echo htmlspecialchars($messaggio); ?>
        </div>
    <?php endif; ?>

    <?php if (empty($plichi)): ?>
        <div class="alert alert-info">Non ci sono plichi disponibili per il ritiro.</div>
    <?php else: ?>
        <form method="post" class="mb-4">
            <div class="mb-3">
                <label for="plico_id" class="form-label">Seleziona Plico</label>
                <select name="plico_id" id="plico_id" class="form-select" required>
                    <option value="">-- Seleziona un plico --</option>
                    <?php foreach ($plichi as $plico): ?>
                        <option value="<?php echo htmlspecialchars($plico->plico_id); ?>">
                            ID: <?php echo htmlspecialchars($plico->plico_id); ?> -
                            Destinatario: <?php echo htmlspecialchars($plico->destinatario_nome . ' ' . $plico->destinatario_cognome); ?> -
                            Mittente: <?php echo htmlspecialchars($plico->mittente_nome . ' ' . $plico->mittente_cognome); ?> -
                            Stato: <?php echo htmlspecialchars($plico->stato_plico); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="note" class="form-label">Note (opzionale)</label>
                <textarea name="note" id="note" class="form-control" rows="3"></textarea>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="conferma" name="conferma" required>
                <label class="form-check-label" for="conferma">
                    Confermo che il destinatario ha ricevuto il plico
                </label>
            </div>

            <button type="submit" class="btn btn-primary">Registra Ritiro</button>
        </form>

        <h3 class="mt-5">Plichi in attesa di ritiro</h3>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>ID Plico</th>
                    <th>Destinatario</th>
                    <th>Mittente</th>
                    <th>Stato</th>
                    <th>Data Ritiro</th>
                    <th>Azioni</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($plichi as $plico): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($plico->plico_id); ?></td>
                        <td><?php echo htmlspecialchars($plico->destinatario_nome . ' ' . $plico->destinatario_cognome); ?></td>
                        <td><?php echo htmlspecialchars($plico->mittente_nome . ' ' . $plico->mittente_cognome); ?></td>
                        <td><?php echo htmlspecialchars($plico->stato_plico); ?></td>
                        <td><?php echo htmlspecialchars($plico->data_ritiro); ?></td>
                        <td>
                            <form method="post" style="display: inline;">
                                <input type="hidden" name="plico_id" value="<?php echo htmlspecialchars($plico->plico_id); ?>">
                                <button type="submit" class="btn btn-sm btn-success">Conferma Ritiro</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include 'php/footer.php'; ?>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
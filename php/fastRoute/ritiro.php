<?php
include_once 'php/Database.php';
include_once 'mail.php';
session_start();

// Verifica se l'utente è autenticato; in caso contrario, redirige al login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$message = '';
$error   = '';

// Funzione per recuperare i plichi in stato "In attesa" o "In transito"
// In questo caso la query mantiene anche le informazioni del cliente per eventuali necessità
function loadPlichi() {
    return Database::select("
        SELECT 
            p.id AS plico_id, 
            c.nome AS cliente_nome, 
            c.cognome AS cliente_cognome,
            c.mail AS client_mail,
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
}

try {
    $plichi = loadPlichi();
} catch (Exception $ex) {
    $error = "Errore nel recupero dei plichi: " . $ex->getMessage();
}

// Gestione del form di ritiro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = Database::connect();
        $pdo->beginTransaction();

        $plico_id = $_POST['plico_id'];

        // Recupera l'indirizzo email del cliente associato al plico
        $stmt = $pdo->prepare("
            SELECT c.mail AS client_mail
            FROM Spedire sp
            JOIN Clienti c ON c.id = sp.Clienti_id
            WHERE sp.Plichi_id = :plico_id
        ");
        $stmt->execute(['plico_id' => $plico_id]);
        $client = $stmt->fetch();
        if (!$client) {
            throw new Exception("Cliente non trovato per il plico $plico_id");
        }
        $clientEmail = $client->client_mail;

        // Aggiorna lo stato del plico a "Consegnato" (stato 3)
        $stmt = $pdo->prepare("UPDATE Plichi SET Stati_id = 3 WHERE id = :plico_id");
        $stmt->execute(['plico_id' => $plico_id]);

        // Aggiorna la data_conferma nella tabella Ritirare
        $stmt = $pdo->prepare("UPDATE Ritirare SET data_conferma = NOW() WHERE Plichi_id = :plico_id");
        $stmt->execute(['plico_id' => $plico_id]);

        $pdo->commit();
        $message = "Ritiro registrato con successo!";

        // Invia l'email al cliente per confermare la consegna del plico
        $subject = "Conferma Consegna Plico - FastRoute";
        $body = "Gentile cliente, il suo plico con ID $plico_id è stato registrato come consegnato. Grazie per aver scelto FastRoute.";
        if (!sendMail($clientEmail, $subject, $body)) {
            error_log("Errore invio email a $clientEmail per il plico $plico_id");
        }

        // Ricarica la lista dei plichi dopo l'aggiornamento
        $plichi = loadPlichi();
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = "Errore durante la registrazione del ritiro: " . $e->getMessage();
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

    <?php if ($message): ?>
        <div class="alert alert-success">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
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
                        <option value="<?php echo $plico->plico_id; ?>">
                            ID: <?php echo $plico->plico_id; ?> -
                            Cliente: <?php echo $plico->cliente_nome . ' ' . $plico->cliente_cognome; ?> -
                            Stato: <?php echo $plico->stato_plico; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Campo Note (opzionale); non viene salvato nel database -->
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
                    <th>Cliente</th>
                    <th>Destinatario</th>
                    <th>Stato</th>
                    <th>Data Ritiro</th>
                    <th>Azioni</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($plichi as $plico): ?>
                    <tr>
                        <td><?php echo $plico->plico_id; ?></td>
                        <td><?php echo $plico->cliente_nome . ' ' . $plico->cliente_cognome; ?></td>
                        <td><?php echo $plico->destinatario_nome . ' ' . $plico->destinatario_cognome; ?></td>
                        <td><?php echo $plico->stato_plico; ?></td>
                        <td><?php echo $plico->data_ritiro; ?></td>
                        <td>
                            <form method="post" style="display: inline;">
                                <input type="hidden" name="plico_id" value="<?php echo $plico->plico_id; ?>">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

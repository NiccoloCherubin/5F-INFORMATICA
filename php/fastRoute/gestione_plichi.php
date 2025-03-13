<?php
include 'php/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = Database::connect();
        $pdo->beginTransaction();

        // Inserisci il destinatario nella tabella "destinatari"
        $stmt = $pdo->prepare("INSERT INTO destinatari (nome, cognome, indirizzo) VALUES (:nome, :cognome, :indirizzo)");
        $stmt->execute([
            'nome' => $_POST['dest_nome'],
            'cognome' => $_POST['dest_cognome'],
            'indirizzo' => $_POST['dest_indirizzo']
        ]);
        $destinatario_id = $pdo->lastInsertId();

        // Inserisci il plico nella tabella "plichi"
        $stmt = $pdo->prepare("INSERT INTO Plichi (data_ritiro, Stati_id) VALUES (NOW(), :stato_id)");
        $stmt->execute([
            'stato_id' => 1 // Imposta un valore predefinito per "In attesa" o usa una variabile
        ]);
        $plico_id = $pdo->lastInsertId();

        // Associa il cliente al plico nella tabella "Spedire"
        $stmt = $pdo->prepare("INSERT INTO Spedire (Clienti_id, Plichi_id, data) VALUES (:cliente_id, :plico_id, NOW())");
        $stmt->execute([
            'cliente_id' => $_POST['cliente_id'],
            'plico_id' => $plico_id
        ]);

        // AGGIUNGI QUESTA PARTE - Associa il destinatario al plico nella tabella "Ritirare"
        $stmt = $pdo->prepare("INSERT INTO Ritirare (Plichi_id, Destinatari_id, data) VALUES (:plico_id, :destinatario_id, NOW())");
        $stmt->execute([
            'plico_id' => $plico_id,
            'destinatario_id' => $destinatario_id
        ]);

        $pdo->commit();
        $success = "Spedizione registrata con successo.";
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = "Errore nella registrazione: " . $e->getMessage();
    }
}

// Recupero clienti per il menu a tendina
$clienti = Database::select("SELECT id, nome, cognome FROM clienti");
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Plichi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'php/header.php'; ?>
<div class="container mt-4">
    <h2>Gestione Plichi</h2>
    <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="post">
        <div class="mb-3">
            <label>Cliente</label>
            <select name="cliente_id" class="form-control" required>
                <option value="">Seleziona un cliente</option>
                <?php foreach ($clienti as $cliente) {
                    echo "<option value='{$cliente->id}'>{$cliente->nome} {$cliente->cognome}</option>";
                } ?>
            </select>
        </div>

        <h4>Destinatario</h4>
        <div class="mb-3"><label>Nome</label><input type="text" name="dest_nome" class="form-control" required></div>
        <div class="mb-3"><label>Cognome</label><input type="text" name="dest_cognome" class="form-control" required></div>
        <div class="mb-3"><label>Indirizzo</label><input type="text" name="dest_indirizzo" class="form-control" required></div>

        <button type="submit" class="btn btn-primary">Registra Spedizione</button>
    </form>
</div>
<?php include 'php/footer.php'; ?>
</body>
</html>
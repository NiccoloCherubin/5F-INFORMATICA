<?php
include 'php/header.php';
include 'php/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_casa'])) {
        $nome_casa = trim($_POST['nome_casa']);

        // Controllo se la casa automobilistica esiste già
        $query = "SELECT COUNT(*) FROM Case_Automobilistiche WHERE nome = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$nome_casa]);
        $count = $stmt->fetchColumn(); // conta righe dato criterio di ricerca

        if ($count > 0) {
            $error_message = "Errore: la casa automobilistica esiste già.";
        } else {
            // Inserimento della casa automobilistica
            $query = "INSERT INTO Case_Automobilistiche (nome) VALUES (?)";
            $stmt = $pdo->prepare($query);
            if ($stmt->execute([$nome_casa])) {
                header("Location: read.php");
                exit();
            } else {
                $error_message = "Errore nell'inserimento della casa automobilistica.";
            }
        }
    }

    if (isset($_POST['submit_pilota'])) {
        $nome = trim($_POST['nome']);
        $cognome = trim($_POST['cognome']);
        $numero = intval($_POST['numero']);
        $nazionalita_id = intval($_POST['nazionalita_id']);

        // Controllo se il numero del pilota esiste già
        $query = "SELECT COUNT(*) FROM Piloti WHERE numero = ?"; // il punto di domanda è un placeholder per prevenire SQL injections
        $stmt = $pdo->prepare($query);
        $stmt->execute([$numero]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $error_message = "Errore: il numero del pilota è già stato utilizzato.";
        } else {
            // Inserimento del pilota
            $query = "INSERT INTO Piloti (nome, cognome, numero, nazionalita_id) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($query);
            if ($stmt->execute([$nome, $cognome, $numero, $nazionalita_id])) {
                header("Location: read.php");
                exit();
            } else {
                $error_message = "Errore nell'inserimento del pilota.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Pilota e Casa Automobilistica</title>
</head>
<body>
<div class="container mt-4">
    <h2>Aggiungi Casa Automobilistica e Pilota</h2>
    <!-- Form per Aggiungere una Casa Automobilistica -->
    <form method="POST" action="create.php" class="mb-4">
        <h3>Aggiungi Casa Automobilistica</h3>
        <div class="mb-3">
            <label for="nome_casa" class="form-label">Nome Casa</label>
            <input type="text" name="nome_casa" class="form-control" required>
        </div>
        <button type="submit" name="submit_casa" class="btn btn-primary">Aggiungi Casa</button>
    </form>

    <hr> <!-- Separazione visiva -->

    <!-- Form per Aggiungere un Pilota -->
    <form method="POST" action="create.php">
        <h3>Aggiungi Pilota</h3>
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="cognome" class="form-label">Cognome</label>
            <input type="text" name="cognome" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="numero" class="form-label">Numero</label>
            <input type="number" name="numero" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="nazionalita_id" class="form-label">Nazionalità</label>
            <select name="nazionalita_id" class="form-control" required>
                <option value="">Seleziona una nazionalità</option>
                <?php
                // Preleva correttamente le nazionalità dal database
                $query = "SELECT id, descrizione FROM Nazionalita";
                $stmt = $pdo->query($query);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . $row['id'] . "'>" . $row['descrizione'] . "</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" name="submit_pilota" class="btn btn-primary">Aggiungi Pilota</button>
    </form>
</div>

<?php include 'php/footer.php'; ?>
</body>
</html>

<?php
include 'php/header.php';
include 'php/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Inserimento della Casa Automobilistica
    if (isset($_POST['submit_casa'])) {
        $nome_casa = $_POST['nome_casa'];

        // Controllo se la casa automobilistica esiste già
        $query = "SELECT COUNT(*) FROM Case_Automobilistiche WHERE nome = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$nome_casa]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $error_message = "Errore: la casa automobilistica esiste già.";
        } else {
            // Inserimento della casa automobilistica
            $query = "INSERT INTO Case_Automobilistiche (nome) VALUES (?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$nome_casa]);

            header("Location: read.php"); // Ricarica la pagina dopo l'inserimento
            exit();
        }
    }

    // Inserimento del Pilota
    if (isset($_POST['submit_pilota'])) {
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $numero = $_POST['numero'];
        $nazionalita_id = $_POST['nazionalita_id'];
        $casa_id = $_POST['casa_id']; // Aggiunto per la casa automobilistica

        // Controllo se il numero del pilota esiste già
        $query = "SELECT COUNT(*) FROM Piloti WHERE numero = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$numero]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $error_message = "Errore: il numero del pilota è già stato utilizzato.";
        } else {
            // Inserimento del pilota
            $query = "INSERT INTO Piloti (nome, cognome, numero, nazionalita_id, casa_id) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$nome, $cognome, $numero, $nazionalita_id, $casa_id]);

            header("Location: read.php"); // Ricarica la pagina dopo l'inserimento
            exit();
        }
    }

    // Associazione del Pilota alla Gara
    if (isset($_POST['submit_associazione'])) {
        $pilota_id = $_POST['pilota_id'];
        $gara_id = $_POST['gara_id'];

        // Controllo se il pilota è già associato alla gara
        $query = "SELECT COUNT(*) FROM Partecipare WHERE pilota_id = ? AND gara_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$pilota_id, $gara_id]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $error_message = "Errore: il pilota è già associato a questa gara.";
        } else {
            // Associazione del pilota alla gara
            $query = "INSERT INTO Partecipare (pilota_id, gara_id) VALUES (?, ?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$pilota_id, $gara_id]);

            header("Location: read.php"); // Ricarica la pagina dopo l'inserimento
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Casa Automobilistica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <?php
    if (isset($error_message)) {
        echo '<div class="alert alert-danger">' . $error_message . '</div>';
    }
    ?>

    <!-- FORM PER LA CASA AUTOMOBILISTICA -->
    <form action="create.php" method="POST" class="mb-4">
        <h3>Aggiungi Casa Automobilistica</h3>
        <div class="mb-3">
            <label for="nome_casa" class="form-label">Nome Casa</label>
            <input type="text" name="nome_casa" class="form-control" required>
        </div>
        <button type="submit" name="submit_casa" class="btn btn-primary">Aggiungi Casa</button>
    </form>

    <hr> <!-- Separatore tra i form -->

    <!-- FORM PER IL PILOTA -->
    <form action="create.php" method="POST" class="mb-4">
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
                // Ottiene le nazionalità dal database
                $query = "SELECT id, descrizione FROM Nazionalita";
                $stmt = $pdo->query($query);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . $row['id'] . "'>" . $row['descrizione'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="casa_id" class="form-label">Casa Automobilistica</label>
            <select name="casa_id" class="form-control" required>
                <option value="">Seleziona una casa automobilistica</option>
                <?php
                // Ottiene le case automobilistiche dal database
                $query = "SELECT id, nome FROM Case_Automobilistiche";
                $stmt = $pdo->query($query);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" name="submit_pilota" class="btn btn-primary">Aggiungi Pilota</button>
    </form>

    <hr> <!-- Separatore tra i form -->

    <!-- FORM PER L'ASSOCIAZIONE DEL PILOTA A UNA GARA -->
    <form action="create.php" method="POST">
        <h3>Associa Pilota a Gara</h3>
        <div class="mb-3">
            <label for="pilota_id" class="form-label">Pilota</label>
            <select name="pilota_id" class="form-control" required>
                <option value="">Seleziona un pilota</option>
                <?php
                // Ottiene i piloti dal database
                $query = "SELECT id, nome, cognome FROM Piloti";
                $stmt = $pdo->query($query);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nome'] . " " . $row['cognome'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="gara_id" class="form-label">Gara</label>
            <select name="gara_id" class="form-control" required>
                <option value="">Seleziona una gara</option>
                <?php
                // Ottiene le gare dal database
                $query = "SELECT id, nome FROM Gare";
                $stmt = $pdo->query($query);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" name="submit_associazione" class="btn btn-primary">Associa Pilota</button>
    </form>
</div>

<?php include 'php/footer.php'; ?>
</body>
</html>

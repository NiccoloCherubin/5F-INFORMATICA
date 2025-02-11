<?php
include 'php/db.php';
include 'php/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se l'azione è l'inserimento di un pilota
    if (isset($_POST['submit_pilota'])) {
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $numero = $_POST['numero'];
        $nazionalita_id = $_POST['nazionalita_id'];

        // Verifica se il numero del pilota esiste già
        $query = "SELECT COUNT(*) FROM Piloti WHERE numero = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $numero);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            $error_message = "Errore: il numero del pilota è già stato utilizzato.";
        } else {
            // Inserimento del pilota
            $query = "INSERT INTO Piloti (nome, cognome, numero, nazionalita_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssii", $nome, $cognome, $numero, $nazionalita_id);
            $stmt->execute();
            $stmt->close();

            header("Location: read.php");
            exit();
        }
    }

    // Verifica se l'azione è l'inserimento di una casa automobilistica
    if (isset($_POST['submit_casa'])) {
        $nome_casa = $_POST['nome_casa'];

        // Verifica se la casa automobilistica esiste già
        $query = "SELECT COUNT(*) FROM Case_Automobilistiche WHERE nome = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $nome_casa);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            $error_message = "Errore: la casa automobilistica esiste già.";
        } else {
            // Inserimento della casa automobilistica
            $query = "INSERT INTO Case_Automobilistiche (nome) VALUES (?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $nome_casa);
            $stmt->execute();
            $stmt->close();

            header("Location: read.php");
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
    <title>Aggiungi Pilota e Casa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Aggiungi Pilota o Casa</h2>

    <?php
    if (isset($error_message)) {
        echo '<div class="alert alert-danger">' . $error_message . '</div>';
    }
    ?>

    <!-- Aggiungi Pilota -->
    <form method="POST" class="mb-4">
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
                <?php
                // Ottieni tutte le nazionalità per la selezione
                $query = "SELECT * FROM Nazionalita";
                $result = $conn->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['descrizione'] . "</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" name="submit_pilota" class="btn btn-primary">Aggiungi Pilota</button>
    </form>

    <!-- Aggiungi Casa Automobilistica -->
    <form method="POST">
        <h3>Aggiungi Casa Automobilistica</h3>
        <div class="mb-3">
            <label for="nome_casa" class="form-label">Nome Casa</label>
            <input type="text" name="nome_casa" class="form-control" required>
        </div>
        <button type="submit" name="submit_casa" class="btn btn-primary">Aggiungi Casa</button>
    </form>
</div>

<?php include 'php/footer.php'; ?>
</body>
</html>

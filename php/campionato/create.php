<?php
include "php/header.php";
include 'php/db.php';
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Dati</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">

    <!-- Form per aggiungere una casa automobilistica -->
    <form action="php/creata_casa.php" method="POST" class="mb-4">
        <h3>Aggiungi Casa Automobilistica</h3>
        <div class="mb-3">
            <label for="nome_casa" class="form-label">Nome Casa</label>
            <input type="text" name="nome_casa" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="colore_livrea" class="form-label">Colore Livrea</label>
            <select name="colore_livrea" class="form-control" required>
                <option value="">Seleziona un colore</option>
                <?php
                $query = "SELECT id, descrizione FROM Colore_Livree";
                $stmt = $pdo->query($query);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . $row['id'] . "'>" . $row['descrizione'] . "</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" name="submit_casa" class="btn btn-primary">Aggiungi Casa</button>
    </form>

    <hr>

    <!-- Form per aggiungere un pilota -->
    <form action="php/create_pilota.php" method="POST" class="mb-4">
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

    <hr>

    <!-- Form per associare un pilota a una gara con tempo e posizione -->
    <form action="php/aggiungi_pilota_gara.php" method="POST">
        <h3>Associa Pilota a Gara</h3>
        <div class="mb-3">
            <label for="pilota_id" class="form-label">Pilota</label>
            <select name="pilota_id" class="form-control" required>
                <option value="">Seleziona un pilota</option>
                <?php
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
                $query = "SELECT id, nome FROM Gare";
                $stmt = $pdo->query($query);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="posizione_finale" class="form-label">Posizione Finale</label>
            <input type="number" name="posizione_finale" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="tempo_veloce" class="form-label">Tempo Veloce (HH:MM:SS)</label>
            <input type="time" step="1" name="tempo_veloce" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="punti_assegnati" class="form-label">Punti Assegnati</label>
            <input type="number" name="punti_assegnati" class="form-control" required>
        </div>
        <button type="submit" name="submit_associazione" class="btn btn-primary">Associa Pilota</button>
    </form>
</div>

<?php include 'php/footer.php'; ?>
</body>
</html>

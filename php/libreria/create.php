<?php include "php/header.php"; ?>
<?php include "php/db.php"; ?>

<?php
// Connection to the database
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data
        $titolo = $_POST['titolo'];
        $autore_ID = $_POST['autore_ID'];
        $genere_ID = $_POST['genere_ID'];
        $prezzo = $_POST['prezzo'];
        $anno_pubblicazione = $_POST['anno_pubblicazione'];

        // Insert query
        $sql = "INSERT INTO libri (titolo, autore_ID, genere_ID, prezzo, anno_pubblicazione) 
                VALUES (:titolo, :autore_ID, :genere_ID, :prezzo, :anno_pubblicazione)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titolo' => $titolo,
            ':autore_ID' => $autore_ID,
            ':genere_ID' => $genere_ID,
            ':prezzo' => $prezzo,
            ':anno_pubblicazione' => $anno_pubblicazione
        ]);

        header("Location: read.php");
        exit();

    }
} catch (PDOException $e) {
    echo "<div class='alert alert-danger mt-3'>Errore: " . $e->getMessage() . "</div>";
}
?>

<div class="container mt-5">
    <h2>Inserisci un Nuovo Libro</h2>
    <form method="post" action="create.php">
        <div class="mb-3">
            <label for="titolo" class="form-label">Titolo</label>
            <input type="text" class="form-control" id="titolo" name="titolo" required>
        </div>
        <div class="mb-3">
            <label for="autore_ID" class="form-label">Autore</label>
            <select class="form-select" id="autore_ID" name="autore_ID" required>
                <?php
                // per fare il menù a tendina dalla tabella degli autori
                $stmt = $pdo->query("SELECT * FROM autori");
                while ($row = $stmt->fetch()) {
                    echo "<option value='{$row['ID']}'>{$row['nome']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="genere_ID" class="form-label">Genere</label>
            <select class="form-select" id="genere_ID" name="genere_ID" required>
                <?php
                // per fare il menù a tendina dalla tabella dei generi
                $stmt = $pdo->query("SELECT * FROM generi");
                while ($row = $stmt->fetch()) {
                    echo "<option value='{$row['ID']}'>{$row['nome']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="prezzo" class="form-label">Prezzo</label>
            <input type="number" class="form-control" id="prezzo" name="prezzo" step="0.01" min="0" required>
        </div>
        <div class="mb-3">
            <label for="anno_pubblicazione" class="form-label">Anno di Pubblicazione</label>
            <input type="date" class="form-control" id="anno_pubblicazione" name="anno_pubblicazione" required>
        </div>
        <button type="submit" class="btn btn-primary">Aggiungi Libro</button>
    </form>
</div>
<?php include "php/footer.php"; ?>

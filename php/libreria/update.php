<?php include "php/header.php"; ?>

<?php
// Verifica se l'ID è presente e valido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die("ID non valido.");
}

try {
    $pdo = new PDO("mysql:host=localhost;dbname=libreria", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Recupero dati del libro
    $stmt = $pdo->prepare("SELECT * FROM libri WHERE ID = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $libro = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$libro) {
        die("Libro non trovato.");
    }

    // Se il form è stato inviato, aggiornare il libro
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $titolo = $_POST['titolo'];
        $autore_ID = $_POST['autore_ID'];
        $genere_ID = $_POST['genere_ID'];
        $prezzo = $_POST['prezzo'];
        $anno_pubblicazione = $_POST['anno_pubblicazione'];

        $query = "UPDATE libri SET titolo = :titolo, autore_ID = :autore_ID, 
                genere_ID = :genere_ID, prezzo = :prezzo, anno_pubblicazione = :anno_pubblicazione 
                WHERE ID = :id";

        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':titolo' => $titolo,
            ':autore_ID' => $autore_ID,
            ':genere_ID' => $genere_ID,
            ':prezzo' => $prezzo,
            ':anno_pubblicazione' => $anno_pubblicazione,
            ':id' => $id
        ]);

        header("Location: read.php");
        exit();
    }
} catch (PDOException $e) {
    echo "<div class='alert alert-danger mt-3'>Errore: " . $e->getMessage() . "</div>";
}
?>

<div class="container mt-5">
    <h2>Modifica Libro</h2>
    <form method="post" action="update.php?id=<?php echo $id; ?>">
        <div class="mb-3">
            <label for="titolo" class="form-label">Titolo</label>
            <input type="text" class="form-control" id="titolo" name="titolo" value="<?php echo htmlspecialchars($libro['titolo']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="autore_ID" class="form-label">Autore</label>
            <select class="form-select" id="autore_ID" name="autore_ID" required>
                <?php
                // Menu a tendina per gli autori
                $stmt = $pdo->query("SELECT * FROM autori");
                while ($row = $stmt->fetch()) {
                    $selected = ($row['ID'] == $libro['autore_ID']) ? "selected" : "";
                    echo "<option value='{$row['ID']}' $selected>{$row['nome']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="genere_ID" class="form-label">Genere</label>
            <select class="form-select" id="genere_ID" name="genere_ID" required>
                <?php
                // Menu a tendina per i generi
                $stmt = $pdo->query("SELECT * FROM generi");
                while ($row = $stmt->fetch()) {
                    $selected = ($row['ID'] == $libro['genere_ID']) ? "selected" : "";
                    echo "<option value='{$row['ID']}' $selected>{$row['nome']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="prezzo" class="form-label">Prezzo</label>
            <input type="number" class="form-control" id="prezzo" name="prezzo" step="0.01" min="0" value="<?php echo $libro['prezzo']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="anno_pubblicazione" class="form-label">Anno di Pubblicazione</label>
            <input type="date" class="form-control" id="anno_pubblicazione" name="anno_pubblicazione" value="<?php echo $libro['anno_pubblicazione']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Salva Modifiche</button>
    </form>
</div>

<?php include "php/footer.php"; ?>

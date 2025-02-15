<?php
include 'php/db.php';
include 'php/header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Recupera i dettagli del pilota
    $query = "SELECT * FROM campionato_automobilistico.piloti WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $id]);
    $pilota = $stmt->fetch(PDO::FETCH_ASSOC);

    // Recupera tutte le nazionalità
    $nazionalitaQuery = "SELECT id, descrizione FROM campionato_automobilistico.nazionalita";
    $nazionalita = $pdo->query($nazionalitaQuery)->fetchAll(PDO::FETCH_ASSOC);

    // Recupera tutte le case automobilistiche
    $caseQuery = "SELECT id, nome FROM campionato_automobilistico.case_automobilistiche";
    $case = $pdo->query($caseQuery)->fetchAll(PDO::FETCH_ASSOC);

    // Se viene inviato il modulo
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $numero = $_POST['numero'];
        $nazionalita_id = $_POST['nazionalita_id'];
        $casa_id = $_POST['casa_id'];

        // Aggiorna il pilota
        $updateQuery = "UPDATE campionato_automobilistico.piloti 
                        SET nome = :nome, cognome = :cognome, numero = :numero, nazionalita_id = :nazionalita_id, casa_id = :casa_id 
                        WHERE id = :id";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->execute([
            'nome' => $nome,
            'cognome' => $cognome,
            'numero' => $numero,
            'nazionalita_id' => $nazionalita_id,
            'casa_id' => $casa_id,
            'id' => $id
        ]);

        header('Location: read.php');
        exit;
    }
}
?>

<div class="container mt-5">
    <h2>Modifica Pilota</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?= $pilota['nome']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="cognome" class="form-label">Cognome</label>
            <input type="text" class="form-control" id="cognome" name="cognome" value="<?= $pilota['cognome']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="numero" class="form-label">Numero</label>
            <input type="number" class="form-control" id="numero" name="numero" value="<?= $pilota['numero']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="nazionalita_id" class="form-label">Nazionalità</label>
            <select class="form-control" id="nazionalita_id" name="nazionalita_id" required>
                <?php
                foreach ($nazionalita as $n) {
                    $selected = $n['id'] == $pilota['nazionalita_id'] ? 'selected' : '';
                    echo "<option value='{$n['id']}' $selected>{$n['descrizione']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="casa_id" class="form-label">Casa Automobilistica</label>
            <select class="form-control" id="casa_id" name="casa_id" required>
                <?php
                foreach ($case as $c) {
                    $selected = $c['id'] == $pilota['casa_id'] ? 'selected' : '';
                    echo "<option value='{$c['id']}' $selected>{$c['nome']}</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Salva modifiche</button>
    </form>
</div>

<?php include 'php/footer.php'; ?>

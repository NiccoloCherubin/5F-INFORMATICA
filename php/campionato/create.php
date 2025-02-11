<?php
include 'php/db.php';
include 'php/header.php';

// Aggiungi Casa Automobilistica
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_casa'])) {
    $nome_casa = $_POST['nome_casa'];

    // Inserisci la casa automobilistica
    $query_casa = "INSERT INTO Case_Automobilistiche (nome) VALUES (:nome_casa)";
    $stmt_casa = $pdo->prepare($query_casa);
    $stmt_casa->execute(['nome_casa' => $nome_casa]);

    echo "<p>Casa automobilistica aggiunta con successo!</p>";

    header("read.php");
    exit();
}

// Aggiungi Pilota
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_pilota'])) {
    $nome_pilota = $_POST['nome_pilota'];
    $cognome_pilota = $_POST['cognome_pilota'];
    $numero_pilota = $_POST['numero_pilota'];
    $nazionalita_pilota = $_POST['nazionalita_pilota'];
    $casa_id = $_POST['casa_id'];

    // Verifica se il numero del pilota è già presente
    $query_verifica_numero = "SELECT COUNT(*) FROM Piloti WHERE numero = :numero_pilota";
    $stmt_verifica = $pdo->prepare($query_verifica_numero);
    $stmt_verifica->execute(['numero_pilota' => $numero_pilota]);
    $esiste = $stmt_verifica->fetchColumn();

    if ($esiste > 0) {
        // Messaggio di errore con alert di Bootstrap
        echo "<div class='alert alert-danger' role='alert'>
                <strong>Errore!</strong> Il numero del pilota è già presente. Scegli un numero diverso.
              </div>";
    } else {
        // Inserisci il pilota
        $query_pilota = "INSERT INTO Piloti (nome, cognome, numero, nazionalita_id) 
                         VALUES (:nome_pilota, :cognome_pilota, :numero_pilota, :nazionalita_pilota)";
        $stmt_pilota = $pdo->prepare($query_pilota);
        $stmt_pilota->execute([
            'nome_pilota' => $nome_pilota,
            'cognome_pilota' => $cognome_pilota,
            'numero_pilota' => $numero_pilota,
            'nazionalita_pilota' => $nazionalita_pilota
        ]);

        $pilota_id = $pdo->lastInsertId();

        // Associa il pilota alla casa automobilistica
        $query_appartenere = "INSERT INTO Appartenere (Piloti_id, casa_id) VALUES (:pilota_id, :casa_id)";
        $stmt_appartenere = $pdo->prepare($query_appartenere);
        $stmt_appartenere->execute([
            'pilota_id' => $pilota_id,
            'casa_id' => $casa_id
        ]);

        echo "<p>Pilota aggiunto con successo!</p>";

        header("read.php");
        exit();
    }
}
?>

<div class="container mt-5">
    <h2>Aggiungi Casa Automobilistica</h2>
    <form action="create.php" method="POST">
        <div class="mb-3">
            <label for="nome_casa" class="form-label">Nome Casa Automobilistica</label>
            <input type="text" class="form-control" id="nome_casa" name="nome_casa" required>
        </div>
        <button type="submit" class="btn btn-primary" name="add_casa">Aggiungi Casa Automobilistica</button>
    </form>

    <hr>

    <h2>Aggiungi Pilota</h2>
    <form action="create.php" method="POST">
        <div class="mb-3">
            <label for="nome_pilota" class="form-label">Nome Pilota</label>
            <input type="text" class="form-control" id="nome_pilota" name="nome_pilota" required>
        </div>
        <div class="mb-3">
            <label for="cognome_pilota" class="form-label">Cognome Pilota</label>
            <input type="text" class="form-control" id="cognome_pilota" name="cognome_pilota" required>
        </div>
        <div class="mb-3">
            <label for="numero_pilota" class="form-label">Numero Pilota</label>
            <input type="number" class="form-control" id="numero_pilota" name="numero_pilota" required>
        </div>
        <div class="mb-3">
            <label for="nazionalita_pilota" class="form-label">Nazionalità</label>
            <select class="form-select" id="nazionalita_pilota" name="nazionalita_pilota" required>
                <?php
                $query_nazionalita = "SELECT * FROM Nazionalita";
                $stmt_nazionalita = $pdo->query($query_nazionalita);
                while ($nazionalita = $stmt_nazionalita->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . $nazionalita['id'] . "'>" . $nazionalita['descrizione'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="casa_id" class="form-label">Casa Automobilistica</label>
            <select class="form-select" id="casa_id" name="casa_id" required>
                <?php
                $query_case = "SELECT * FROM Case_Automobilistiche";
                $stmt_case = $pdo->query($query_case);
                while ($casa = $stmt_case->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . $casa['id'] . "'>" . $casa['nome'] . "</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" name="add_pilota">Aggiungi Pilota</button>
    </form>
</div>

<?php include 'php/footer.php'; ?>

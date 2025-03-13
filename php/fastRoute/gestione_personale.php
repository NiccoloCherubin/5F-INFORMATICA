<?php
// Includiamo la classe Database
include_once 'php/Database.php';

session_start(); // Gestione della sessione per il login

// Verifica se l'utente è autenticato e se è un responsabile (ruolo_id = 1)
if (!isset($_SESSION['user_id']) || $_SESSION['ruolo_id'] != 1) {
    // Se non è autenticato o non è un responsabile, redirige alla pagina di login
    header('Location: login.php?error=unauthorized');
    exit();
}

$messaggio = '';
$personale = [];
$ruoli = [];
$sedi = [];
$edit_mode = false;
$dipendente_modificato = null;

// Carica i ruoli disponibili
try {
    $ruoli = Database::select("SELECT id, descrizione FROM Ruoli ORDER BY descrizione");
} catch (Exception $e) {
    $messaggio = "Errore nel caricamento dei ruoli: " . $e->getMessage();
}

// Carica le sedi disponibili
try {
    $sedi = Database::select("SELECT id, descrizione, citta FROM Sedi ORDER BY descrizione");
} catch (Exception $e) {
    $messaggio = "Errore nel caricamento delle sedi: " . $e->getMessage();
}

// Gestione dell'eliminazione del personale
if (isset($_POST['delete'])) {
    try {
        $pdo = Database::connect();
        $pdo->beginTransaction();

        $personale_id = $_POST['personale_id'];

        // Elimina le relazioni nella tabella Lavorare
        $stmt = $pdo->prepare("DELETE FROM Lavorare WHERE personale_id = :personale_id");
        $stmt->execute(['personale_id' => $personale_id]);

        // Elimina il personale
        $stmt = $pdo->prepare("DELETE FROM Personale WHERE id = :personale_id");
        $stmt->execute(['personale_id' => $personale_id]);

        $pdo->commit();
        $messaggio = "Dipendente eliminato con successo!";
    } catch (Exception $e) {
        $pdo->rollBack();
        $messaggio = "Errore durante l'eliminazione del dipendente: " . $e->getMessage();
    }
}

// Gestione della modifica (recupero dati per il form)
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $personale_id = $_GET['edit'];

    try {
        $dipendente_modificato = Database::select("
            SELECT 
                p.id, 
                p.nome, 
                p.mail, 
                p.Ruoli_id,
                l.Sedi_id
            FROM Personale p
            LEFT JOIN Lavorare l ON l.personale_id = p.id
            WHERE p.id = :id
            LIMIT 1
        ", [':id' => $personale_id])[0];
    } catch (Exception $e) {
        $messaggio = "Errore nel recupero dei dati del dipendente: " . $e->getMessage();
        $edit_mode = false;
    }
}

// Gestione dell'aggiunta/modifica del personale
if (isset($_POST['submit'])) {
    try {
        $pdo = Database::connect();
        $pdo->beginTransaction();

        $nome = $_POST['nome'];
        $mail = $_POST['mail'];
        $ruolo_id = $_POST['ruolo_id'];
        $sede_id = $_POST['sede_id'];

        // Se viene fornita una password, la codifichiamo
        $password_hash = '';
        if (!empty($_POST['password'])) {
            $password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
        }

        // Se è un aggiornamento (id esistente)
        if (!empty($_POST['id'])) {
            $id = $_POST['id'];

            if (!empty($password_hash)) {
                // Aggiorna con password
                $stmt = $pdo->prepare("UPDATE Personale SET nome = :nome, mail = :mail, password = :password, Ruoli_id = :ruolo_id WHERE id = :id");
                $stmt->execute([
                    'nome' => $nome,
                    'mail' => $mail,
                    'password' => $password_hash,
                    'ruolo_id' => $ruolo_id,
                    'id' => $id
                ]);
            } else {
                // Aggiorna senza password
                $stmt = $pdo->prepare("UPDATE Personale SET nome = :nome, mail = :mail, Ruoli_id = :ruolo_id WHERE id = :id");
                $stmt->execute([
                    'nome' => $nome,
                    'mail' => $mail,
                    'ruolo_id' => $ruolo_id,
                    'id' => $id
                ]);
            }

            // Aggiorna la sede (elimina le vecchie relazioni e crea una nuova)
            $stmt = $pdo->prepare("DELETE FROM Lavorare WHERE personale_id = :personale_id");
            $stmt->execute(['personale_id' => $id]);

            $stmt = $pdo->prepare("INSERT INTO Lavorare (personale_id, Sedi_id) VALUES (:personale_id, :sede_id)");
            $stmt->execute([
                'personale_id' => $id,
                'sede_id' => $sede_id
            ]);

            $messaggio = "Dipendente aggiornato con successo!";
            $edit_mode = false; // Esci dalla modalità di modifica
        } else {
            // È un nuovo inserimento, la password è obbligatoria
            if (empty($password_hash)) {
                throw new Exception("La password è obbligatoria per un nuovo dipendente");
            }

            // Inserisci il nuovo personale
            $stmt = $pdo->prepare("INSERT INTO Personale (nome, mail, password, Ruoli_id) VALUES (:nome, :mail, :password, :ruolo_id)");
            $stmt->execute([
                'nome' => $nome,
                'mail' => $mail,
                'password' => $password_hash,
                'ruolo_id' => $ruolo_id
            ]);

            $personale_id = $pdo->lastInsertId();

            // Associa alla sede selezionata
            $stmt = $pdo->prepare("INSERT INTO Lavorare (personale_id, Sedi_id) VALUES (:personale_id, :sede_id)");
            $stmt->execute([
                'personale_id' => $personale_id,
                'sede_id' => $sede_id
            ]);

            $messaggio = "Nuovo dipendente aggiunto con successo!";
        }

        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        $messaggio = "Errore durante il salvataggio: " . $e->getMessage();
    }
}

// Carica l'elenco del personale con le relative sedi e ruoli
try {
    $personale = Database::select("
        SELECT 
            p.id, 
            p.nome, 
            p.mail, 
            r.descrizione AS ruolo, 
            r.id AS ruolo_id,
            s.descrizione AS sede, 
            s.citta AS citta_sede,
            s.id AS sede_id
        FROM Personale p
        JOIN Ruoli r ON r.id = p.Ruoli_id
        LEFT JOIN Lavorare l ON l.personale_id = p.id
        LEFT JOIN Sedi s ON s.id = l.Sedi_id
        ORDER BY p.nome
    ");
} catch (Exception $e) {
    $messaggio = "Errore nel caricamento del personale: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Personale - FastRoute</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'php/header.php'; ?>

<div class="container my-5">
    <h2>Gestione Personale</h2>
    <p class="lead">Questa pagina è riservata ai responsabili per gestire il personale aziendale.</p>

    <?php if (!empty($messaggio)): ?>
        <div class="alert <?php echo strpos($messaggio, 'Errore') !== false ? 'alert-danger' : 'alert-success'; ?>">
            <?php echo htmlspecialchars($messaggio); ?>
        </div>
    <?php endif; ?>

    <!-- Modulo per aggiungere/modificare personale -->
    <div class="card mb-4">
        <div class="card-header">
            <h4><?php echo $edit_mode ? 'Modifica Dipendente' : 'Aggiungi Nuovo Dipendente'; ?></h4>
        </div>
        <div class="card-body">
            <form method="post">
                <?php if ($edit_mode && $dipendente_modificato): ?>
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($dipendente_modificato->id); ?>">
                <?php endif; ?>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" name="nome" id="nome" class="form-control" required
                               value="<?php echo $edit_mode && $dipendente_modificato ? htmlspecialchars($dipendente_modificato->nome) : ''; ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="mail" class="form-label">Email</label>
                        <input type="email" name="mail" id="mail" class="form-control" required
                               value="<?php echo $edit_mode && $dipendente_modificato ? htmlspecialchars($dipendente_modificato->mail) : ''; ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" <?php echo !$edit_mode ? 'required' : ''; ?>>
                        <?php if ($edit_mode): ?>
                            <small class="form-text text-muted">Lasciare vuoto per mantenere la password esistente</small>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <label for="ruolo_id" class="form-label">Ruolo</label>
                        <select name="ruolo_id" id="ruolo_id" class="form-select" required>
                            <option value="">Seleziona un ruolo</option>
                            <?php foreach ($ruoli as $ruolo): ?>
                                <option value="<?php echo htmlspecialchars($ruolo->id); ?>"
                                    <?php echo ($edit_mode && $dipendente_modificato && $dipendente_modificato->Ruoli_id == $ruolo->id) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($ruolo->descrizione); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="sede_id" class="form-label">Sede di Lavoro</label>
                    <select name="sede_id" id="sede_id" class="form-select" required>
                        <option value="">Seleziona una sede</option>
                        <?php foreach ($sedi as $sede): ?>
                            <option value="<?php echo htmlspecialchars($sede->id); ?>"
                                <?php echo ($edit_mode && $dipendente_modificato && $dipendente_modificato->Sedi_id == $sede->id) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($sede->descrizione . ' - ' . $sede->citta); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" name="submit" class="btn btn-primary">Salva</button>
                    <a href="gestione_personale.php" class="btn btn-secondary">Annulla</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabella del personale -->
    <h3>Elenco Personale</h3>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Ruolo</th>
                <th>Sede</th>
                <th>Azioni</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($personale)): ?>
                <tr>
                    <td colspan="6" class="text-center">Nessun dipendente trovato</td>
                </tr>
            <?php else: ?>
                <?php foreach ($personale as $dipendente): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($dipendente->id); ?></td>
                        <td><?php echo htmlspecialchars($dipendente->nome); ?></td>
                        <td><?php echo htmlspecialchars($dipendente->mail); ?></td>
                        <td><?php echo htmlspecialchars($dipendente->ruolo); ?></td>
                        <td><?php echo htmlspecialchars($dipendente->sede ?? 'Non assegnata'); ?>
                            <?php echo $dipendente->citta_sede ? '(' . htmlspecialchars($dipendente->citta_sede) . ')' : ''; ?></td>
                        <td>
                            <a href="gestione_personale.php?edit=<?php echo htmlspecialchars($dipendente->id); ?>" class="btn btn-sm btn-warning">Modifica</a>

                            <form method="post" style="display:inline;" onsubmit="return confirm('Sei sicuro di voler eliminare questo dipendente?');">
                                <input type="hidden" name="personale_id" value="<?php echo htmlspecialchars($dipendente->id); ?>">
                                <button type="submit" name="delete" class="btn btn-sm btn-danger">Elimina</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'php/footer.php'; ?>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
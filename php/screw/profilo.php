<?php
include_once 'php/Database.php';
session_start();

// Verifica se l'utente ha effettuato il login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

Database::connect();

$user_id = $_SESSION['user_id'];
$message = '';
$error = '';

// Recupera i dati dell'utente dalla tabella 'utenti'
$userResult = Database::select("SELECT * FROM utenti WHERE id = :id", ['id' => $user_id]);
if (!$userResult) {
    $error = "Errore nel recupero dei dati utente.";
} else {
    $user = $userResult[0];
}

// Gestione dell'aggiornamento del profilo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $nuova_password = $_POST['nuova_password'] ?? '';
    $conferma_password = $_POST['conferma_password'] ?? '';

    if (empty($nome) || empty($email)) {
        $error = "Nome e email sono campi obbligatori.";
    } else {
        try {
            // Verifica se l'email è già in uso da un altro utente
            $esistente = Database::select("SELECT * FROM utenti WHERE email = :email AND id != :id",
                ['email' => $email, 'id' => $user_id]);

            if ($esistente) {
                $error = "L'email inserita è già in uso.";
            } else {
                // Aggiorna i dati dell'utente
                if (!empty($nuova_password)) {
                    // Verifica che le password coincidano
                    if ($nuova_password !== $conferma_password) {
                        $error = "Le password non coincidono.";
                    } else {
                        // Aggiorna anche la password
                        $password_hash = password_hash($nuova_password, PASSWORD_DEFAULT);
                        Database::connect()->prepare("UPDATE utenti SET nome = :nome, email = :email, password_hash = :password_hash WHERE id = :id")
                            ->execute([
                                'nome' => $nome,
                                'email' => $email,
                                'password_hash' => $password_hash,
                                'id' => $user_id
                            ]);
                        $message = "Profilo e password aggiornati con successo!";
                    }
                } else {
                    // Aggiorna solo nome e email
                    Database::connect()->prepare("UPDATE utenti SET nome = :nome, email = :email WHERE id = :id")
                        ->execute([
                            'nome' => $nome,
                            'email' => $email,
                            'id' => $user_id
                        ]);
                    $message = "Profilo aggiornato con successo!";
                }

                // Aggiorna la sessione con il nuovo nome
                $_SESSION['user_name'] = $nome;

                // Ricarica i dati dell'utente dopo l'aggiornamento
                $user = Database::select("SELECT * FROM utenti WHERE id = :id", ['id' => $user_id])[0];
            }
        } catch (Exception $e) {
            $error = "Errore durante l'aggiornamento del profilo: " . $e->getMessage();
        }
    }
}
?>

<?php include 'php/header.php'; ?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Profilo Utente</h3>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <?php if ($message): ?>
                        <div class="alert alert-success"><?php echo $message; ?></div>
                    <?php endif; ?>

                    <?php if (isset($user)): ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($user->nome); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user->email); ?>" required>
                            </div>

                            <hr>
                            <h4>Cambio Password</h4>
                            <div class="mb-3">
                                <label for="nuova_password" class="form-label">Nuova Password</label>
                                <input type="password" class="form-control" id="nuova_password" name="nuova_password">
                                <small class="form-text text-muted">Lascia vuoto se non vuoi cambiare la password.</small>
                            </div>

                            <div class="mb-3">
                                <label for="conferma_password" class="form-label">Conferma Password</label>
                                <input type="password" class="form-control" id="conferma_password" name="conferma_password">
                            </div>

                            <button type="submit" class="btn btn-primary">Aggiorna Profilo</button>
                        </form>
                    <?php endif; ?>
                </div>
                <div class="card-footer">
                    <a href="index.php" class="btn btn-secondary">Torna alla Home</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'php/footer.php'; ?>

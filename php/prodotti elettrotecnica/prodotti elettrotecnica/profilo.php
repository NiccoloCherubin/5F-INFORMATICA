<?php
include_once 'php/Database.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

Database::connect();

$user_id = $_SESSION['user_id'];
$message = '';
$error = '';

// Retrieve user data
$user = Database::select("SELECT u.*, r.descrizione as ruolo FROM elettrotecnica.utenti u 
                         JOIN elettrotecnica.ruoli r ON u.ruolo_id = r.id 
                         WHERE u.id = :id", ['id' => $user_id]);

if (!$user) {
    $error = "Errore nel recupero dei dati utente.";
} else {
    $user = $user[0];
}

// Handling profile update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'] ?? '';
    $cognome = $_POST['cognome'] ?? '';
    $email = $_POST['email'] ?? '';
    $nuova_password = $_POST['nuova_password'] ?? '';
    $conferma_password = $_POST['conferma_password'] ?? '';

    if (empty($nome) || empty($cognome) || empty($email)) {
        $error = "Nome, cognome e email sono campi obbligatori.";
    } else {
        try {
            // Check if email is already in use by another user
            $esistente = Database::select("SELECT * FROM elettrotecnica.utenti WHERE email = :email AND id != :id",
                ['email' => $email, 'id' => $user_id]);

            if ($esistente) {
                $error = "L'email inserita è già in uso.";
            } else {
                // Update user data
                if (!empty($nuova_password)) {
                    // Verify password match
                    if ($nuova_password !== $conferma_password) {
                        $error = "Le password non coincidono.";
                    } else {
                        // Update with new password
                        Database::connect()->prepare("UPDATE elettrotecnica.utenti 
                            SET nome = :nome, cognome = :cognome, email = :email, password = :password 
                            WHERE id = :id")
                            ->execute([
                                'nome' => $nome,
                                'cognome' => $cognome,
                                'email' => $email,
                                'password' => $nuova_password, // Note: Replace with proper hashing
                                'id' => $user_id
                            ]);
                        $message = "Profilo e password aggiornati con successo!";
                    }
                } else {
                    // Update only name and email
                    Database::connect()->prepare("UPDATE elettrotecnica.utenti 
                        SET nome = :nome, cognome = :cognome, email = :email 
                        WHERE id = :id")
                        ->execute([
                            'nome' => $nome,
                            'cognome' => $cognome,
                            'email' => $email,
                            'id' => $user_id
                        ]);
                    $message = "Profilo aggiornato con successo!";
                }

                // Update session with new name
                $_SESSION['user_name'] = $nome . ' ' . $cognome;

                // Reload user data after update
                $user = Database::select("SELECT u.*, r.descrizione as ruolo FROM elettrotecnica.utenti u 
                                         JOIN elettrotecnica.ruoli r ON u.ruolo_id = r.id 
                                         WHERE u.id = :id", ['id' => $user_id])[0];
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
                        <h3 class="mb-0">Profilo Utente Elettrotecnica</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <?php if ($message): ?>
                            <div class="alert alert-success"><?php echo $message; ?></div>
                        <?php endif; ?>

                        <?php if ($user): ?>
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="nome" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="nome" name="nome"
                                           value="<?php echo htmlspecialchars($user->nome); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="cognome" class="form-label">Cognome</label>
                                    <input type="text" class="form-control" id="cognome" name="cognome"
                                           value="<?php echo htmlspecialchars($user->cognome); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           value="<?php echo htmlspecialchars($user->email); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="ruolo" class="form-label">Ruolo</label>
                                    <input type="text" class="form-control" id="ruolo"
                                           value="<?php echo htmlspecialchars($user->ruolo); ?>" readonly>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="index.php" class="btn btn-secondary">Torna alla Home</a>
                        <a href="logout.php" class="btn btn-danger">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include 'php/footer.php'; ?>
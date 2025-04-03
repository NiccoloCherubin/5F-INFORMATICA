<?php
include_once 'php/Database.php';
session_start();

Database::connect();

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['name'] ?? '';
    $cognome = $_POST['surname'] ?? '';
    $email = $_POST['mail'] ?? '';
    $password = $_POST['password'] ?? '';

    // Input validation
    if (empty($nome) || empty($cognome) || empty($email) || empty($password)) {
        $error = "Tutti i campi sono obbligatori.";
    } else {
        try {
            // Check if email already exists
            $existing_user = Database::select("SELECT * FROM elettrotecnica.utenti WHERE email = :email", ['email' => $email]);

            if ($existing_user) {
                $error = "Questo indirizzo email è già registrato.";
            } else {
                // Validate email format
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error = "Formato email non valido.";
                } else {
                    // Hash the password
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Insert new user (default role is 2 - regular user)
                    $stmt = Database::connect()->prepare("INSERT INTO elettrotecnica.utenti (nome, cognome, email, password, ruolo_id) VALUES (:nome, :cognome, :email, :password, :ruolo_id)");
                    $stmt->execute([
                        'nome' => $nome,
                        'cognome' => $cognome,
                        'email' => $email,
                        'password' => $hashed_password,
                        'ruolo_id' => 2 // utente normale
                    ]);

                    // messaggio di riuscita
                    $success = "Registrazione completata con successo! Ora puoi effettuare il login.";
                }
            }
        }
catch
    (Exception $e) {
        $error = "Errore durante la registrazione: " . $e->getMessage();
    }
    }
}
?>

<?php include 'php/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="text-center mb-4">Registrazione Elettrotecnica</h2>

                    <?php if ($error): ?>
                    <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>

                        <?php if ($success): ?>
                    <div class="alert alert-success text-center"><?php echo htmlspecialchars($success); ?></div>
                    <?php endif; ?>

                        <?php if (!$success): ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="<?php echo htmlspecialchars($nome ?? ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="surname" class="form-label">Cognome</label>
                            <input type="text" class="form-control" id="surname" name="surname"
                                   value="<?php echo htmlspecialchars($cognome ?? ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="mail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="mail" name="mail"
                                   value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <small class="form-text text-muted">Minimo 8 caratteri</small>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Registrati</button>
                    </form>
                    <?php endif; ?>

                    <div class="text-center mt-3">
                        <p>Hai già un account? <a href="login.php">Accedi</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'php/footer.php'; ?>
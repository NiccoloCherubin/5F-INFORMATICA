<?php
include_once 'php/Database.php';
session_start();

Database::connect(); // Avvia la connessione al database

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {
        // Recupera l'utente dal database usando la tabella 'utenti'
        $user = Database::select("SELECT * FROM utenti WHERE email = :email", ['email' => $email]);

        if ($user) {
            $user = $user[0]; // Prendi il primo record trovato
            // Confronta la password inserita con l'hash salvato nel database
            if (password_verify($password, $user->password_hash)) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_name'] = $user->nome;
                header("Location: profilo.php");
                exit();
            } else {
                $error = "Credenziali non valide.";
            }
        } else {
            $error = "Credenziali non valide.";
        }
    } else {
        $error = "Inserisci email e password.";
    }
}
?>
<?php include 'php/header.php'; ?>

<div class="container my-5">
    <h2 class="text-center">Login Utente</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" class="mx-auto" style="max-width: 400px;">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Accedi</button>
    </form>
</div>

<?php include 'php/footer.php'; ?>

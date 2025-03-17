<?php
include_once 'php/Database.php';
session_start();

Database::connect(); // Assicuriamoci che la connessione sia avviata

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = $_POST['mail'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($mail) && !empty($password)) {
        // Recupera l'utente dal database
        $user = Database::select("SELECT * FROM Personale WHERE mail = :mail", ['mail' => $mail]);

        if ($user) {
            $user = $user[0]; // Estraggo il primo elemento dall'array
            //  Confronto la password inserita con l'hash salvato nel database
            if (password_verify($password, $user->password)) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_name'] = $user->nome;
                $_SESSION['ruolo_id'] = $user->ruolo_id;
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
    <h2 class="text-center">Login Personale</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" class="mx-auto" style="max-width: 400px;">
        <div class="mb-3">
            <label for="mail" class="form-label">Email</label>
            <input type="email" class="form-control" id="mail" name="mail" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Accedi</button>
    </form>
</div>

<?php include 'php/footer.php'; ?>

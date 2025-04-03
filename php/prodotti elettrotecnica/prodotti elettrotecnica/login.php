<?php
include_once 'php/Database.php';
session_start();

Database::connect();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['mail'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {
        // Retrieve user from the elettrotecnica.utenti table
        $user = Database::select("SELECT * FROM elettrotecnica.utenti WHERE email = :email", ['email' => $email]);

        if ($user) {
            $user = $user[0]; // Extract the first element from the array

            // Compare the entered password with the stored hash

            if (password_verify($password, $user->password)) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_name'] = $user->nome . ' ' . $user->cognome;
                $_SESSION['user_email'] = $user->email;
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
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Login Elettrotecnica</h2>
                        <?php if ($error): ?>
                            <div class="alert alert-danger text-center"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <form method="POST">
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
                        <div class="text-center mt-3">
                            <p>Non hai un account? <a href="register.php" class="link-primary">Registrati qui</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include 'php/footer.php'; ?>
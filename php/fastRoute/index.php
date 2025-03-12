<?php include 'php/header.php'; ?>

<!-- Main Content -->
<main class="container text-center my-5 flex-grow-1">
    <h2 class="mb-4">Benvenuto in FastRoute!</h2>
    <p>Gestisci facilmente le spedizioni e le consegne dei pacchi.</p>
    <img src="immagini/corriere.png" alt="Immagine di un corriere" class="img-fluid rounded shadow mt-4">
</main>
<?php
echo password_hash('Password123!', PASSWORD_DEFAULT) . "<br>";
echo password_hash('Sicura2024!', PASSWORD_DEFAULT) . "<br>";
echo password_hash('Corriere#77', PASSWORD_DEFAULT) . "<br>";
echo password_hash('Clienti123!', PASSWORD_DEFAULT) . "<br>";
echo password_hash('Milano2024!', PASSWORD_DEFAULT) . "<br>";
echo password_hash('Stefano@99', PASSWORD_DEFAULT) . "<br>";
?>

<?php include 'php/footer.php'; ?>

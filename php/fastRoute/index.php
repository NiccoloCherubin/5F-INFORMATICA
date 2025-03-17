<?php include 'php/header.php'; ?>

<!-- Main Content -->
<main class="container text-center my-5 flex-grow-1">
    <h2 class="mb-4">Benvenuto in FastRoute!</h2>
    <p>Gestisci facilmente le spedizioni e le consegne dei pacchi.</p>
    <img src="immagini/corriere.png" alt="Immagine di un corriere" class="img-fluid rounded shadow mt-4">
</main>
<?php
echo password_hash('prova2', PASSWORD_DEFAULT) . "<br>";
?>

<?php include 'php/footer.php'; ?>

<?php
include "php/header.php";
include "php/db.php";
?>

<div class="container my-5">
    <h2 class="mb-4">Aggiungi un Sovrano</h2>
    <form action="php/create.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" required>
            <div class="invalid-feedback">Inserisci il nome del sovrano.</div>
        </div>
        <div class="mb-3">
            <label for="data_inizio" class="form-label">Data Inizio</label>
            <input type="date" name="data_inizio" id="data_inizio" class="form-control" required>
            <div class="invalid-feedback">Inserisci la data di inizio regno.</div>
        </div>
        <div class="mb-3">
            <label for="data_fine" class="form-label">Data Fine</label>
            <input type="date" name="data_fine" id="data_fine" class="form-control" required>
            <div class="invalid-feedback">Inserisci la data di fine regno.</div>
        </div>
        <div class="mb-3">
            <label for="immagine" class="form-label">Immagine</label>
            <input type="file" name="immagine" id="immagine" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Aggiungi Sovrano</button>
    </form>
</div>

<?php include "php/footer.php"; ?>

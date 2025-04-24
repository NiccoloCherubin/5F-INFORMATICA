<?php require 'header.php'; ?>

    <div class="container my-5">
        <h2 class="text-center">Profilo Utente</h2>
        <div class="card p-4 shadow">
            <p><strong>Nome:</strong> <?= $utente->getNome() ?></p>
            <p><strong>Email:</strong> <?= $utente->getMail() ?></p>
            <p><strong>Telefono:</strong> <?= $utente->getTelefono() ?></p>
            <p><strong>Nazionalità:</strong> <?= $utente->getNazionalita() ?></p>
            <p><strong>Lingua preferita:</strong> <?= $utente->getLingua() ?></p>

            <div class="mt-4">
                <div class="d-flex flex-wrap gap-2">
                    <?php $prjName = '/artifex';?>
                    <a href="<?= $prjName ?>/profilo/edit-email" class="btn btn-primary">Modifica Email</a>
                    <a href="<?= $prjName ?>/profilo/edit-password" class="btn btn-primary">Modifica Password</a>
                </div>
            </div>
        </div>
    </div>

<?php require 'footer.php'; ?>
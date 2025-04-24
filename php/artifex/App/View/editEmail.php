<?php require 'header.php'; ?>

    <div class="container my-5">
        <h2 class="text-center">Modifica Email</h2>

        <?php if (isset($error) && !empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($message) && !empty($message)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="card p-4 shadow mx-auto" style="max-width: 500px;">
            <?php $prjName = '/artifex';?>
            <form method="POST" action="<?= $prjName ?>/profile/updateEmail">
                <div class="mb-3">
                    <label for="current_email" class="form-label">Email attuale</label>
                    <input type="email" class="form-control" id="current_email" value="<?= $utente->getMail() ?>" disabled>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Nuova Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Conferma Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                           placeholder="Inserisci la password per confermare la modifica" required>
                    <small class="form-text text-muted">È necessario inserire la password attuale per confermare la modifica.</small>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="<?= $prjName ?>/home/profilo" class="btn btn-secondary">Annulla</a>
                    <button type="submit" class="btn btn-primary">Aggiorna Email</button>
                </div>
            </form>
        </div>
    </div>

<?php include 'footer.php'; ?>
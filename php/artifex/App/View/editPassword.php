<?php require 'header.php'; ?>

    <div class="container my-5">
        <h2 class="text-center">Modifica Password</h2>

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
        <?php $prjName = '/artifex';?>
        <div class="card p-4 shadow mx-auto" style="max-width: 500px;">
            <form method="POST" action="<?= $prjName ?>/profile/updatePassword">
                <div class="mb-3">
                    <label for="current_password" class="form-label">Password attuale</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                </div>

                <div class="mb-3">
                    <label for="new_password" class="form-label">Nuova Password</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                    <small class="form-text text-muted">La password deve contenere almeno 8 caratteri.</small>
                </div>

                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Conferma Nuova Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="<?= $prjName ?>/home/profilo" class="btn btn-secondary">Annulla</a>
                    <button type="submit" class="btn btn-primary">Aggiorna Password</button>
                </div>
            </form>
        </div>
    </div>

<?php include 'footer.php'; ?>
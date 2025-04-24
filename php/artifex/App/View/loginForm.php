<?php require 'header.php'; ?>

    <div class="container my-5">
        <h2 class="text-center">Login</h2>
        <?php if (isset($error) && !empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php $prjName = '/artifex';?>
        <form method="POST" action="<?= $prjName ?>/home/login" class="mx-auto" style="max-width: 400px;">
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

<?php include 'footer.php'; ?>
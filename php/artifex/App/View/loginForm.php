<?php
require 'header.php'; ?>

<div class="container my-5">
    <h2 class="text-center">Login</h2>
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

<?php include 'footer.php'; ?>
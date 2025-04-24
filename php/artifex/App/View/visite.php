<?php require_once 'header.php'; ?>

    <div class="container mt-4">
        <h1>Elenco delle visite guidate</h1>

        <form action="" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cerca visita..."
                       value="<?= htmlspecialchars($searchTerm ?? '') ?>">
                <button type="submit" class="btn btn-primary">Cerca</button>
            </div>
        </form>

        <div class="row">
            <?php foreach ($visite as $visita): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($visita->getTitolo()) ?></h5>
                            <p class="card-text">
                                <strong>Durata:</strong> <?= htmlspecialchars($visita->getDurataFormattata()) ?><br>
                                <strong>Prezzo:</strong> <?= htmlspecialchars($visita->getPrezzoFormattato()) ?><br>
                                <strong>Guida:</strong> <?= htmlspecialchars($visita->getNomeGuida()) ?>
                            </p>
                            <a href="<?= $appConfig['baseUrl'] ?>visite/dettaglio/<?= $visita->getId() ?>"
                               class="btn btn-primary">Dettagli</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if (empty($visite)): ?>
                <div class="col-12">
                    <p class="alert alert-info">Nessuna visita trovata.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php require_once 'footer.php'; ?>
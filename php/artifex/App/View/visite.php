<?php
require_once 'header.php';
?>

<div class="container mt-4">
    <h1>Elenco delle visite guidate</h1>

    <div class="row">
        <?php if (!empty($visite)): ?>
            <?php foreach ($visite as $visita): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($visita->getTitolo()) ?></h5>
                            <p class="card-text mb-4">
                                <strong>Durata:</strong> <?= htmlspecialchars($visita->getDurata()) ?> ore<br>
                                <strong>Prezzo:</strong> € <?= htmlspecialchars(number_format($visita->getPrezzo(), 2, ',', '.')) ?><br>
                                <strong>Guida:</strong> <?= htmlspecialchars($visita->getNomeGuida()) ?>
                            </p>
                            <a
                                    href="<?= $appConfig['baseURL'].$appConfig['prjName'] ?>visite/dettaglio?id=<?= $visita->getId() ?>"
                                    class="btn btn-primary mt-auto"
                            >
                                Dettagli
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    Nessuna visita trovata.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'footer.php'; ?>

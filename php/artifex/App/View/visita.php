<?php require_once 'header.php'; ?>

    <div class="container mt-4">
        <a href="<?= $appConfig['baseUrl'] ?>home/visite" class="btn btn-secondary mb-3">
            &larr; Torna all'elenco
        </a>

        <h1><?= htmlspecialchars($visita->getTitolo()) ?></h1>

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Dettagli della visita</h5>
                        <p class="card-text">
                            <strong>Durata:</strong> <?= htmlspecialchars($visita->getDurataFormattata()) ?><br>
                            <strong>Prezzo:</strong> <?= htmlspecialchars($visita->getPrezzoFormattato()) ?><br>
                            <strong>Partecipanti:</strong> Min <?= $visita->getNMin() ?>, Max <?= $visita->getNMax() ?><br>
                            <strong>Prenotazioni attuali:</strong> <?= $numeroPrenotazioni ?><br>
                            <strong>Posti disponibili:</strong> <?= $postiDisponibili ? 'Sì' : 'No' ?>
                        </p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Guida</h5>
                        <p class="card-text">
                            <strong>Nome:</strong> <?= htmlspecialchars($visita->getNomeGuida()) ?><br>
                            <strong>Lingue parlate:</strong> <?= htmlspecialchars($visita->getLingueGuida()) ?><br>
                            <?php if (!empty($visita->getGuida()['titolo_studio'])): ?>
                                <strong>Titolo di studio:</strong>
                                <?= htmlspecialchars($visita->getGuida()['titolo_studio']) ?>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>

                <?php if (!empty($visita->getLuoghi())): ?>
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Luoghi visitati</h5>
                            <ul>
                                <?php foreach ($visita->getLuoghi() as $luogo): ?>
                                    <li><?= htmlspecialchars($luogo['descrizione']) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($visita->getEventi())): ?>
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Eventi</h5>
                            <ul>
                                <?php foreach ($visita->getEventi() as $evento): ?>
                                    <li><?= htmlspecialchars($evento['descrizione']) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Prenotazione</h5>

                        <?php if (!isset($_SESSION['user_id'])): ?>
                            <p>Effettua l'accesso per prenotare questa visita.</p>
                            <a href="<?= $appConfig['baseUrl'] ?>home/login" class="btn btn-primary">Accedi</a>
                        <?php elseif ($prenotataUtente): ?>
                            <p>Hai già prenotato questa visita.</p>
                            <a href="<?= $appConfig['baseUrl'] ?>visite/cancella-prenotazione/<?= $visita->getId() ?>"
                               class="btn btn-danger"
                               onclick="return confirm('Sei sicuro di voler cancellare questa prenotazione?');">
                                Cancella prenotazione
                            </a>
                        <?php elseif (!$postiDisponibili): ?>
                            <p class="text-danger">Non ci sono più posti disponibili per questa visita.</p>
                        <?php else: ?>
                            <p>Prenota ora per partecipare a questa visita guidata!</p>
                            <a href="<?= $appConfig['baseUrl'] ?>visite/prenota/<?= $visita->getId() ?>"
                               class="btn btn-success">
                                Prenota
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php require_once 'footer.php'; ?>
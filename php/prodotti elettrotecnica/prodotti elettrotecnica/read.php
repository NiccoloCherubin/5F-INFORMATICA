<?php
include_once 'php/Database.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

Database::connect();

//controlla se utente è admin
$is_admin = (isset($_SESSION['ruolo_id']) && $_SESSION['ruolo_id'] == 1);

// Retrieve products
$products = Database::select("SELECT * FROM elettrotecnica.prodotti ORDER BY id");

// Check for success or error message
$message = $_GET['message'] ?? '';
$error = $_GET['error'] ?? '';
?>

<?php include 'php/header.php'; ?>

    <div class="container my-5">
        <h2 class="text-center mb-4">Prodotti in Magazzino</h2>

        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Descrizione</th>
                    <th>Costo (€)</th>
                    <th>Quantità</th>
                    <th>Data Produzione</th>
                    <?php if ($is_admin): ?>
                        <th>Azioni</th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product->id); ?></td>
                        <td><?php echo htmlspecialchars($product->descrizione); ?></td>
                        <td><?php echo number_format($product->costo, 2); ?></td>
                        <td><?php echo htmlspecialchars($product->quantita); ?></td>
                        <td><?php echo htmlspecialchars($product->data_produzione); ?></td>
                        <?php if ($is_admin): ?>
                            <td>
                                <!-- Aggiornare prezzo tasto-->
                                <button type="button" class="btn btn-sm btn-warning me-1" data-bs-toggle="modal"
                                        data-bs-target="#updatePriceModal<?php echo $product->id; ?>">
                                    <i class="bi bi-pencil"></i> Prezzo
                                </button>

                                <!-- Aggiornare quantità tasto-->
                                <button type="button" class="btn btn-sm btn-info me-1" data-bs-toggle="modal"
                                        data-bs-target="#updateQuantityModal<?php echo $product->id; ?>">
                                    <i class="bi bi-stack"></i> Quantità
                                </button>

                                <!-- Conferma di eliminazione prodotto -->
                                <a href="delete.php?id=<?php echo $product->id; ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Sei sicuro di voler eliminare questo prodotto?');">
                                    <i class="bi bi-trash"></i> Elimina
                                </a>
                            </td>
                        <?php endif; ?>
                    </tr>

                    <!-- aggiorna prezzo -->
                    <?php if ($is_admin): ?>
                        <div class="modal fade" id="updatePriceModal<?php echo $product->id; ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Aggiorna Prezzo</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="updatePrice.php" method="POST">
                                        <div class="modal-body">
                                            <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                                            <div class="mb-3">
                                                <label class="form-label">Nuovo Prezzo (€)</label>
                                                <input type="number" step="0.01" name="new_price"
                                                       class="form-control"
                                                       value="<?php echo $product->costo; ?>"
                                                       required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                            <button type="submit" class="btn btn-primary">Salva</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- aggiorna quantità -->
                        <div class="modal fade" id="updateQuantityModal<?php echo $product->id; ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Aggiorna Quantità</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="updateQuantity.php" method="POST">
                                        <div class="modal-body">
                                            <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                                            <div class="mb-3">
                                                <label class="form-label">Nuova Quantità</label>
                                                <input type="number" name="new_quantity"
                                                       class="form-control"
                                                       value="<?php echo $product->quantita; ?>"
                                                       required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                            <button type="submit" class="btn btn-primary">Salva</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Aggiunta nuovo prodotto-->
        <?php if ($is_admin): ?>
            <div class="card mt-4">
                <div class="card-header">
                    <h4>Aggiungi Nuovo Prodotto</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="addProduct.php">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Descrizione</label>
                                <input type="text" name="descrizione" class="form-control" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Costo (€)</label>
                                <input type="number" step="0.01" name="costo" class="form-control" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Quantità</label>
                                <input type="number" name="quantita" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Data Produzione</label>
                                <input type="date" name="data_produzione" class="form-control"
                                       value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-plus-circle"></i> Aggiungi Prodotto
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>

<?php include 'php/footer.php'; ?>
<?php 
require_once __DIR__ . '/../../views/inc/header.php';
?>

<div class="container mt-4">
    <h3>Checkout</h3>

    <div class="row mt-4">
        <div class="col-md-6">
            <h5>Payment Method: <strong>GCash</strong></h5>
            <p>Scan to pay:</p>

            <?php foreach ($cart as $item): ?>
                <div class="mb-3">
                    <h6>Pay <?= $item['seller']->username ?> for <?= $item['name'] ?></h6>
                    <?php if ($item['seller']->gcash_qr): ?>
                        <img src="<?= ROOT ?>/uploads/<?= $item['seller']->gcash_qr ?>" class="img-fluid mb-2">
                    <?php else: ?>
                        <p class="text-muted">Seller has no QR yet</p>
                    <?php endif; ?>
                    <p>Amount: ₱<?= number_format($item['price'] * $item['qty'], 2) ?></p>
                </div>
            <?php endforeach; ?>


            <form method="POST" action="<?= ROOT ?>/orders/placeOrder">
                <label>GCash Reference Number</label>
                <input type="text" name="reference" class="form-control" required>

                <button class="btn btn-primary mt-3">Place Order</button>
            </form>
        </div>

        <div class="col-md-6">
            <h5>Order Summary</h5>
            <ul class="list-group">
                <?php foreach ($cart as $item): ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <?= $item['qty'] ?>x <?= $item['name'] ?>
                        <span>₱<?= number_format($item['price'] * $item['qty'], 2) ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>

            <h4 class="mt-3">Total: ₱<?= number_format($total, 2) ?></h4>
        </div>
    </div>
</div>






<?php 
require_once __DIR__ . '/../../views/inc/footer.php';
?>
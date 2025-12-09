<?php 
require_once __DIR__ . '/../../views/inc/header.php';
?>


<div class="container mt-4">
    <h3>Your Cart</h3>

    <?php if(empty($cart)): ?>
        <div class="alert alert-info mt-3">
            Your cart is empty.
        </div>
    <?php else: ?>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Product</th>
                    <th width="120">Price</th>
                    <th width="100">Qty</th>
                    <th width="120">Subtotal</th>
                    <th width="60"></th>
                </tr>
            </thead>

            <tbody>
                <?php $total = 0; ?>
                <?php foreach ($cart as $item): ?>
                    <?php $subtotal = $item['price'] * $item['qty']; ?>
                    <?php $total += $subtotal; ?>

                    <tr>
                        <td><?= $item['name'] ?></td>
                        <td>₱<?= number_format($item['price'], 2) ?></td>
                        <td><?= $item['qty'] ?></td>
                        <td>₱<?= number_format($subtotal, 2) ?></td>
                        <td>
                            <a href="<?= ROOT ?>/cart/remove/<?= $item['id'] ?>" class="btn btn-danger btn-sm">X</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h4 class="text-end">Total: ₱<?= number_format($total, 2) ?></h4>

        <div class="text-end mt-3">
            <a href="<?= ROOT ?>/orders/checkout" class="btn btn-success">
                Proceed to Checkout
            </a>
        </div>
    <?php endif; ?>
</div>



<?php 
require_once __DIR__ . '/../../views/inc/footer.php';
?>
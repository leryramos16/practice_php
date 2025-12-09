<?php 
require_once __DIR__ . '/../../views/inc/header.php';
?>


<div class="container mt-4">
    <h3>Order #<?= $order->id ?></h3>

    <p>Status: <strong><?= ucfirst($order->status) ?></strong></p>
    <p>Payment: <?= $order->payment_method ?> (Ref: <?= $order->payment_reference ?>)</p>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Product</th>
                <th width="120">Price</th>
                <th width="100">Qty</th>
                <th width="120">Subtotal</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= $item->name ?></td>
                    <td>₱<?= number_format($item->price, 2) ?></td>
                    <td><?= $item->quantity ?></td>
                    <td>₱<?= number_format($item->price * $item->quantity, 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h4 class="text-end">Total: ₱<?= number_format($order->total_amount, 2) ?></h4>

</div>



















<?php 
require_once __DIR__ . '/../../views/inc/footer.php';
?>
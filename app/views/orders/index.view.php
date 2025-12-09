<?php 
require_once __DIR__ . '/../../views/inc/header.php';
?>


<div class="container mt-4">
    <h3>My Orders</h3>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= $order->id ?></td>
                    <td>₱<?= number_format($order->total_amount, 2) ?></td>
                    <td><?= ucfirst($order->status) ?></td>
                    <td><?= $order->created_at ?></td>
                    <td>
                        <a href="<?= ROOT ?>/orders/show/<?= $order->id ?>" class="btn btn-sm btn-primary">
                            View
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
















<?php 
require_once __DIR__ . '/../../views/inc/footer.php';
?>
<?php 
require_once __DIR__ . '/../../views/inc/header.php';
?>

<h2>Your Active Subscriptions</h2>
<?php if (isset($subscriptions) && count($subscriptions) > 0): ?>
    <ul>
        <?php foreach ($subscriptions as $subscription): ?>
            <li>
                <strong>Coach:</strong> <?= htmlspecialchars($subscription['coach_name']) ?><br>
                <strong>Plan:</strong> <?= htmlspecialchars($subscription['plan']) ?><br>
                <strong>Amount:</strong> ₱<?= htmlspecialchars($subscription['amount']) ?><br>
                <strong>Status:</strong> <?= htmlspecialchars($subscription['status']) ?><br>
                <strong>Created on:</strong> <?= date('F j, Y', strtotime($subscription['created_at'])) ?><br>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>You don't have any active subscription. Please choose a coach and plan to start.</p>
<?php endif; ?>







<?php 
require_once __DIR__ . '/../../views/inc/footer.php';
?>
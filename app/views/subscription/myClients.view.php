<?php 
require_once __DIR__ . '/../../views/inc/header.php';
?>

<h2>Your Clients</h2>

<?php if (isset($clients) && count($clients) > 0): ?>
    <ul>
        <?php foreach ($clients as $client): ?>
            <li>
                <strong>Client:</strong> <?= htmlspecialchars($client['client_name']) ?><br>
                <strong>Plan:</strong> <?= htmlspecialchars($client['plan']) ?><br>
                <strong>Amount:</strong> ₱<?= htmlspecialchars($client['amount']) ?><br>
                <strong>Status:</strong> <?= htmlspecialchars($client['status']) ?><br>
                <strong>Subscribed on:</strong> <?= date('F j, Y', strtotime($client['created_at'])) ?><br>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>You don't have any clients yet. Please wait for clients to subscribe to you.</p>
<?php endif; ?>






<?php 
require_once __DIR__ . '/../../views/inc/footer.php';
?>

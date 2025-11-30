<?php 
require_once __DIR__ . '/../../views/inc/header.php';
?>


<h2>Choose a Coach</h2>

<?php if (isset($users) && count($users) > 0): ?>
    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <?= htmlspecialchars($user['username']) ?>
                <a href="<?= ROOT ?>/subscription/pay?coach_id=<?= $user['id'] ?>">Choose</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No coaches available at the moment. Please check again later.</p>
<?php endif; ?>
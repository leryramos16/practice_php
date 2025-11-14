<?php 
require_once __DIR__ . '/../../views/inc/header.php';
?>

<h2>Your Friends</h2>

<?php if (!empty($friends)): ?>
    <?php foreach ($friends as $f): ?>
        <div style="margin-bottom: 10px">
            <img src="<?= ROOT ?>/uploads/<?= htmlspecialchars($f['profile_image']) ?>" width="40" height="40" style="border-radius:50%;">
            <strong><?= htmlspecialchars($f['username'])?></strong>
            <a href="<?= ROOT ?>/chat/index/<?= $f['id'] ?>" class="btn btn-sm btn-light">
                <i class="bi bi-chat-dots"></i>
            </a>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>You dont' have any friends yet</p>
<?php endif; ?>

<?php 
require_once __DIR__ . '/../../views/inc/footer.php';
?>
<?php 
require_once __DIR__ . '/../../views/inc/header.php';
?>

<h2>Your Friends</h2>

<?php if (!empty($friends)): ?>
    <?php foreach ($friends as $f): ?>
        <div style="margin-bottom: 10px; display: flex; align-items: center; max-width: 250px;">
            <img src="<?= ROOT ?>/uploads/<?= htmlspecialchars($f['profile_image']) ?>" width="40" height="40" style="border-radius:50%; margin-right: 10px;">
            <strong><?= htmlspecialchars($f['username'])?></strong>

            <a href="<?= ROOT ?>/chat/index/<?= $f['id'] ?>" class="btn btn-sm btn-light position-relative" style="margin-left: auto;">
               <i class="bi bi-chat"></i>

               <!-- Unread badge -->
               <?php if (!empty($f['unread_count']) && $f['unread_count'] > 0): ?>
                   <span class="badge badge-danger position-absolute" style="top: -5px; right: -5px; font-size: 0.7rem;">
                       <?= $f['unread_count'] ?>
                   </span>
               <?php endif; ?>
            </a>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>You don't have any friends yet</p>
<?php endif; ?>

<?php 
require_once __DIR__ . '/../../views/inc/footer.php';
?>
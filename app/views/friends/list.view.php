<h2>Your Friends</h2>

<?php if (!empty($friends)): ?>
    <?php foreach ($friends as $f): ?>
        <div style="margin-bottom: 10px">
            <img src="<?= ROOT ?>/uploads/<?= htmlspecialchars($f['profile_image']) ?>" width="40" height="40" style="border-radius:50%;">
            <strong><?= htmlspecialchars($f['username'])?></strong>
            <a href="<?= ROOT ?>/chat/index/<?= $f['id'] ?>" class="btn btn-sm btn-primary">
                Chat
            </a>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>You dont' have any friends yet</p>
<?php endif; ?>
<h2>Friend Requests</h2>

<?php if (!empty($requests)): ?>
    <?php foreach ($requests as $req): ?>
        <div style ="margin-bottom: 10px">
            <img src="<?= ROOT ?>/uploads/<?= htmlspecialchars($req['profile_image']) ?>" width="40" height="40" style="border-radius:50%;">
            <strong><?= htmlspecialchars($req['username'])?></strong>
            <a href="<?= ROOT ?>/friend/accept/<?= $req['id'] ?>"> Accept</a>
            <a href="<?= ROOT ?>/friend/decline/ <?= $req['id'] ?>">Decline</a>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No friend request right now.</p>
<?php endif; ?>
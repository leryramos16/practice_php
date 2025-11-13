

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Friend Requests</h2>

<?php if (!empty($requests)): ?>
    <?php foreach ($requests as $req): ?>
        <div class="friend-request" style="margin-bottom: 10px" data-id="<?= $req['id'] ?>">
            <img src="<?= ROOT ?>/uploads/<?= htmlspecialchars($req['profile_image']) ?>" width="40" height="40" style="border-radius:50%;">
            <strong><?= htmlspecialchars($req['username']) ?></strong>
            <button class="btn btn-success btn-sm accept-btn" data-id="<?= $req['id'] ?>">Accept</button>
            <button class="btn btn-danger btn-sm decline-btn" data-id="<?= $req['id'] ?>">Decline</button>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No friend request right now.</p>
<?php endif; ?>



<script>
document.addEventListener('DOMContentLoaded', () => {
    const acceptBtns = document.querySelectorAll('.accept-btn');
    const declineBtns = document.querySelectorAll('.decline-btn');

    acceptBtns.forEach(btn => {
        btn.addEventListener('click', async () => {
            const id = btn.dataset.id;

            const res = await fetch(`<?= ROOT ?>/friends/accept/${id}`, {
                method: 'POST'
            });

            if (res.ok) {
                const requestDiv = btn.closest('.friend-request');
                requestDiv.innerHTML = '<span class="text-success">You are now friends!</span>';
            }
        });
    });

    declineBtns.forEach(btn => {
        btn.addEventListener('click', async () => {
            const id = btn.dataset.id;

            const res = await fetch(`<?= ROOT ?>/friends/decline/${id}`, {
                method: 'POST'
            });

            if (res.ok) {
                const requestDiv = btn.closest('.friend-request');
                requestDiv.remove();
            }
        });
    });
});
</script>

</body>
</html>
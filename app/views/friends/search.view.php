<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">



<div class="container mt-4">
    <h2>Search Results</h2>
    

    <?php if (!empty($results)): ?>
        <ul class="list-group">
            <?php foreach ($results as $user): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="<?= ROOT ?>/uploads/<?= htmlspecialchars($user['profile_image']) ?>" 
                             alt="Profile" width="40" height="40" class="rounded-circle mr-2">
                        <strong><?= htmlspecialchars($user['username']) ?></strong> 
                        <small class="text-muted ml-2">(<?= htmlspecialchars($user['email']) ?>)</small>
                    </div>
                    <a href="<?= ROOT ?>/friends/add/<?= $user['id'] ?>" class="btn btn-primary text-light btn-sm">
                         Add Friend
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <p class="text-muted mt-3">No users found.</p>
    <?php endif; ?>
</div>



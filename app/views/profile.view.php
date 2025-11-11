<?php 
require 'inc/header.php';
?>

<?php
    $current_user = $_SESSION['user_id'];
    $profile_user = $user['id'];

    $friendModel = new Friend();
    $isFriend = $friendModel->isFriend($current_user, $profile_user);
?>

<?php if ($current_user != $profile_user): ?>
    <div style="margin-top: 10px;">

        <?php if ($isFriend): ?>
            <button disabled class="btn btn-success">✅ Friends</button>

        <?php else: ?>
            <a href="<?= ROOT ?>/friend/add/<?= $profile_user ?>" class="btn btn-primary">
                ➕ Add Friend
            </a>
        <?php endif; ?>

    </div>
<?php endif; ?>



<div class="container mt-5" style="max-width: 500px;">
    <h2 class="mb-4 text-center">Profile Settings</h2>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="text-center mb-3">
        <img src="<?= ROOT ?>/uploads/<?= htmlspecialchars($user['profile_image']) ?>" 
             alt="Profile Image" 
             class="rounded-circle mb-3 shadow" 
             width="120" height="120">
        <h4><?= htmlspecialchars($user['username']) ?></h4>
    </div>

    <form action="<?= ROOT ?>/profile/upload" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Upload new profile picture:</label>
            <input type="file" name="profile_image" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary w-100">Update Image</button>
    </form>
</div>

<?php
require 'inc/footer.php';
?>
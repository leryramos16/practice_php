<?php 
require_once __DIR__ . '/../../views/inc/header.php';
?>

<h2 class="text-center mb-4">Physique Feed</h2>

<div class="d-flex flex-column justify-content-center align-items-center min-vh-100">
    <?php foreach ($uploads as $upload): ?>
    <div class="card mb-3" style="width:500px;">
        <strong class="p-2"><?= htmlspecialchars($upload['username']) ?></strong>
        <div style="width:500px; height:500px; overflow:hidden;">
            <img src="<?= ROOT ?>/<?= $upload['image_path'] ?>" class="card-img-top h-100 w-100" style="object-fit:cover;">
        </div>
        <div class="card-body">
            <p><?= htmlspecialchars($upload['description']) ?></p>
            <small><?= $upload['created_at'] ?></small>
            <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="routineModal<?= $upload['id'] ?>">
                Ask About Routine
            </button>
        </div>
    </div>
    <?php endforeach; ?>
</div>



<?php 
require_once __DIR__ . '/../../views/inc/footer.php';
?>

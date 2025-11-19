<?php 
require_once __DIR__ . '/../../views/inc/header.php';
?>

<h2 class="text-center mb-4">Physique Feed</h2>

<div class="d-flex flex-column justify-content-center align-items-center min-vh-100">
    <?php foreach ($uploads as $upload): ?>
    <div class="card mb-3" style="width:500px;">
        <strong class="p-2"><?= htmlspecialchars($upload['username']) ?></strong> 
        <small><?= $upload['created_at'] ?></small>
        <div style="width:500px; height:500px; overflow:hidden;">
            <img src="<?= ROOT ?>/<?= $upload['image_path'] ?>" class="card-img-top h-100 w-100" style="object-fit:cover;">
        </div>
        <div class="card-body">
            <p><?= htmlspecialchars($upload['description']) ?></p>
            <form action="<?= ROOT ?>/physique/like/<?= $upload['id'] ?>" method="POST">
    <button type="submit"
    class="btn btn-sm <?= $upload['liked'] ? 'btn-danger' : 'btn-outline-danger' ?>">
    <i class="bi bi-fire"></i><?= $upload['likes'] ?? 0 ?>
</button>
</form>

           <form method="post" action="<?= ROOT ?>/physique/askRoutine/<?= $upload['id'] ?>" style="display:inline;">
                <button type="submit" class="btn btn-light mt-2">
                    Ask Routine<i class="bi bi-question"></i>
                </button>
        </form>
        </div>
    </div>
    <?php endforeach; ?>
</div>



<script>
document.querySelectorAll('.ask-routine-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const uploadId = this.dataset.upload;

        fetch('<?= ROOT ?>/physique/askRoutine/' + uploadId, {
            method: 'POST'
        })
        .then(response => response.text())
        .then(data => {
            alert('Routine question sent!');
            // optionally change button text or disable it
            this.disabled = true;
            this.innerText = "Asked";
        });
    });
});
</script>

<?php 
require_once __DIR__ . '/../../views/inc/footer.php';
?>

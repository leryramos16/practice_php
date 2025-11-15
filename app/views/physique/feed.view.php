<h2>Physique Feed</h2>

<?php foreach ($uploads as $upload): ?>
    <div class="card mb-3" style="max-width:400px;">
        <img src="<?= ROOT ?>/<?= $upload['image_path'] ?>" class="card-img-top">
        <div class="card-body">
            <p><?= htmlspecialchars($upload['description']) ?></p>
            <small><?= $upload['created_at'] ?></small>
        </div>
    </div>
<?php endforeach; ?>

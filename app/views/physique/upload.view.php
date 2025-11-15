<form action="<?= ROOT ?>/physique/upload" method="post" enctype="multipart/form-data">
    <textarea name="description" placeholder="Write something..." rows="2"></textarea>
    <input type="file" name="physique_image" accept="image/*" required>
    <button type="submit">Upload</button>
</form>

<h2>Upload Physique</h2>

<form method="POST" enctype="multipart/form-data">
    <label>Select Image</label>
    <input type="file" name="image" required class="form-control">

    <label>Description</label>
    <textarea name="description" class="form-control"></textarea>

    <button class="btn btn-primary mt-3">Upload</button>
</form>

<?php 
require_once __DIR__ . '/../../views/inc/header.php';
?>




<div class="d-flex flex-column justify-content-center align-items-center min-vh-100">
    <h2>Share Your Physique</h2>

<form method="POST" enctype="multipart/form-data">
    <label>Select Image</label>
    <input type="file" name="image" required class="form-control">

    <label>Description</label>
    <textarea name="description" class="form-control"></textarea>

    <button class="btn btn-primary mt-3">Upload</button>
</form>
</div>

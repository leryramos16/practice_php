<?php 
$title = 'Edit Contact';
include 'inc/header.php';
?>

<h2>Edit Contact</h2>

<form method="POST">
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($contact['name']) ?>" required>
    </div>

    <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="phonenumber" class="form-control" value="<?= htmlspecialchars($contact['phonenumber']) ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="<?= ROOT ?>/phonebook" class="btn btn-secondary">Cancel</a>
</form>

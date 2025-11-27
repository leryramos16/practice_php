<?php
$title = "Guest Meals";
include 'inc/header.php';
?>


<div class="container mt-5">

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <h3>Assign Meal to Guest</h3>

    <form method="POST" action="<?= ROOT ?>/guestmeal/add">

        <label>Guest:</label>
        <input name="guest_id" class="form-control" required>

        <label>Meal:</label>
        <input name="meal_id" class="form-control mt-2" required>
            

        <button type="submit" class="btn btn-primary mt-3">Assign Meal</button>
    </form>
</div>
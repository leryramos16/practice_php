<?php
$title = "Add Usage Water/Electric";
require_once __DIR__ . '/../../views/inc/header.php';
?>

<form action="<?= ROOT ?>/usage/add" method="POST">
    <div class="mb-5">
        <label for="">Water Usage</label>
        <input type="number" name="water" class="form-control" required autocomplete="off">
    </div>
    <div class="mb-5">
        <label for="">Electric Usage</label>
        <input type="number" name="electric" class="form-control" required autocomplete="off">
    </div>
        <button type="submit" class="btn btn-primary">Add Record</button>
</form>
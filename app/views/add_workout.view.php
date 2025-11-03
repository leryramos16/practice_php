<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Workout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    
    <?php
         //show error
         if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger" role="alert">
        <?= $_SESSION['error']; ?>
    </div>
    <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <h2 class="mb-4 text-center">Add a Workout</h2>

    <form method="POST" action="<?= ROOT ?>/workout/add" class="card p-4 shadow-sm">

    <div class="mb-3">
            <label for="exercise" class="form-label">Exercise</label>
            <input list="exerciseList" class="form-control" id="exercise" name="exercise" required>
                <datalist id="exerciseList">
                    <option value="Push-ups">
                    <option value="Sit-ups">
                    <option value="Squats">
                    <option value="Plank">
                    <option value="Burpees">
                    <option value="Jumping Jacks">
                    <option value="Lunges">
                    <option value="Pull-ups">
                </datalist>
    </div>


        <div class="mb-3">
            <label for="reps" class="form-label">Reps</label>
            <input type="number" class="form-control" id="reps" name="reps" min="1" required>
        </div>

        <div class="mb-3">
            <label for="sets" class="form-label">Sets</label>
            <input type="number" class="form-control" id="sets" name="sets" min="1" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Add Workout</button>
    </form>

    <div class="text-center mt-3">
        <a href="<?= ROOT ?>/dashboard" class="text-decoration-none">← Back to Dashboard</a>
    </div>
</div>

</body>
</html>

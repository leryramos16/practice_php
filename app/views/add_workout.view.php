<?php
$title = "Add Workout";
include 'inc/header.php';
?>

<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-12 col-md-6">

      <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-danger"><?= $_SESSION['error']; ?></div>
      <?php unset($_SESSION['error']); endif; ?>

      <h2 class="mb-3 text-center">Add a Workout</h2>

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

        <div class="text-center mb-3">
          <img id="exercisePreview" src="" style="max-width:100%; height:auto; display:none; border-radius:5px;">
        </div>

        <div class="mb-3">
          <label for="reps" class="form-label">Reps</label>
          <select class="form-select" name="reps" id="reps" required>
            <option value="" disabled selected hidden>-- How many reps? -- </option>
            <option>5</option>
            <option>8</option>
            <option>10</option>
            <option>12</option>
            <option>15</option>
            <option>20</option>   
          </select>
        </div>

        <div class="mb-3">
          <label for="sets" class="form-label">Sets</label>
          <select class="form-select" name="sets" id="sets" required>
            <option value="" disabled selected hidden>Select sets </option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
          </select>
          
        </div>

        <button type="submit" class="btn btn-primary w-100">Add Workout</button>
      </form>

      <div class="text-center mt-3">
        <a href="<?= ROOT ?>/dashboard" class="text-decoration-none">← Back to Dashboard</a>
      </div>

    </div>
  </div>
</div>




<script>
    const exerciseInput = document.getElementById('exercise');
    const previewImg = document.getElementById('exercisePreview');
    
    // Map exercise names to GIF file paths or URLs
    const exerciseGifs = {
    "Push-ups": "<?= ROOT?>/assets/images/pushups.gif",
    "Sit-ups": "<?= ROOT?>/assets/images/situps.gif",
    "Squats": "<?= ROOT?>/assets/images/squats.gif",
    "Plank": "<?= ROOT?>/assets/images/plank.gif",
    "Burpees": "<?= ROOT?>/assets/images/burpees.gif",
    "Jumping Jacks": "<?= ROOT?>/assets/images/jumpingjacks.gif",
    "Lunges": "<?= ROOT?>/assets/images/lunges.gif",
    "Pull-ups": "<?= ROOT?>/assets/images/pullups.gif"
  };

  // Listen for changes in the input
  exerciseInput.addEventListener('input', function() {
    const selectedExercise = this.value;
    const gifPath = exerciseGifs[selectedExercise];

    if (gifPath) {
        previewImg.src = gifPath;
        previewImg.style.display = 'block';
    } else{
        previewImg.style.display = 'none';
    }
  });


</script>

<?php
include 'inc/footer.php';
?>

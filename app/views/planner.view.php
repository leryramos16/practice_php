<?php 

$title = 'Day Plan';
include 'inc\header.php';

?>
<div class="container max-width: 200px text-center">
  <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success"><?= $_SESSION['success']; ?></div>
      <?php unset($_SESSION['success']); ?>
  <?php endif; ?>

  <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-danger"><?= $_SESSION['error']; ?></div>
      <?php unset($_SESSION['error']); ?>
  <?php endif; ?>
</div>


<div class="container d-flex justify-content-center align-items-center min-vh-100">
  <div class="card text-center p-4 shadow-sm" style="max-width: 400px; width: 100%; margin-top: 50px">
    <h2>Plan Your Day</h2>
    <form method="post" action="<?= ROOT ?>/planner/add">
      <div class="form-floating mb-3">
        <h5>What to do:</h5>
        <input type="text" name="task_name" class="form-control" placeholder="Task / Want to do" required>
      </div>
      <div class="form-floating mb-3">
        <h5>Time to prepare:</h5>
        <input type="time" name="time_to_prepare" class="form-control" required>
      </div>
      <div class="form-floating mb-3">
        <h5>Date of Task:</h5>
        <input type="date" name="task_date" class="form-control" required>
      </div>
      <div class="form-floating mb-3">
        <h5>Note:</h5>
        <input type="text" name="note" class="form-control" placeholder="Optional">
      </div>
      <div class="form-floating mb-3">
        <button type="submit" class="btn btn-primary w-100">Add this Task</button>
      </div>
    </form>
  </div>
</div>

<div class="justify-content-center">
  <div>
   
  </div>
</div>

 <div class="col-md-4 mb-4">
   <h2>Task Lists</h2>
 <?php foreach ($tasks as $task): ?>
<div class="card"  style="width: 18rem;">
  <div class="card-body <?= $task['status'] === 'done' ? 'bg-success-subtle' : 'bg-light'; ?>">
    
    <?php if ($task['status'] === 'done'): ?>
        <h4><span class="badge bg-light text-success">Finished!</span></h4>
    <?php elseif ($task['status'] === 'missed'): ?>
        <h4><span class="badge bg-light text-danger">You forgot this task!</span></h4>
    <?php else: ?>
        <h4><span class="badge bg-primary text-light">Upcoming...</span></h4>
    <?php endif; ?>

    <h5 class="card-title"> <?= htmlspecialchars($task['task_name']) ?></h5>
    <h6 class="card-subtitle mb-2 text-muted"><?= date('g:i A', strtotime($task['time_to_prepare'])) ?></h6>
    <p class="card-text"><?= date('F j, Y', strtotime($task['task_date'])) ?></p>
    <p class="card-text"><?= htmlspecialchars($task['note']) ?></p>
    <a href="<?= ROOT ?>/planner/delete/<?= $task['id'] ?>" class="btn btn-danger btn-sm">Cancel/Delete</a>
    <?php if ($task['status'] === 'done'): ?>
        <span class="badge bg-light text-success">Done ✓</span>
    <?php elseif ($task['status'] === 'missed'): ?>
        <span class="badge bg-light text-danger">Didn't finished</span>
    <?php else: ?>
        <a href="<?= ROOT ?>/planner/done/<?= $task['id'] ?>" class="btn btn-success btn-sm">Mark as Done</a>
    <?php endif; ?>
  </div>
</div>
<?php endforeach; ?>
 </div>



 <!-- Pang hide ng alerts -->
  <script>
  // Wait for the page to fully load
  document.addEventListener("DOMContentLoaded", function() {
    // Select all alert elements
    const alerts = document.querySelectorAll('.alert');

    alerts.forEach(function(alert) {
      // After 3 seconds, start fading out
      setTimeout(function() {
        alert.style.transition = "opacity 0.5s ease";
        alert.style.opacity = "0";
        // After fading, remove it completely
        setTimeout(function() {
          alert.remove();
        }, 500); // matches the transition time
      }, 3000); // delay before fade (3 seconds)
    });
  });
</script>

 <?php 
include 'inc/footer.php';

?>
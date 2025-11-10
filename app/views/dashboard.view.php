<?php
$title = "My Fit App";
include 'inc/header.php';
?>

<!-- Bootstrap Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Upcoming Tasks</h5>
      </div>
      <div class="modal-body">
        <?php if (!empty($upcomingTasks)): ?>
          <strong>Upcoming Tasks (Next 24 Hours):</strong><br>
          <?php $now = strtotime('now');
            foreach ($upcomingTasks as $task):
            $taskDateTime = strtotime($task['task_date'] . ' ' . $task['time_to_prepare']);
            if ($taskDateTime > $now && $task['status'] != 'done'): ?> <!-- Hide past tasks tsaka pag done na ang task -->
            <?= htmlspecialchars($task['task_name']) ?> — 
            <?= date('F j, Y', strtotime($task['task_date'])) ?> at 
            <?= date('g:i A', strtotime($task['time_to_prepare'])) ?><br>
          <?php endif; 
                endforeach; ?>
        <?php else: ?>
          <em>No tasks in the next 24 hours.</em>
        <?php endif; ?>
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary" href="<?= ROOT?>/planner">Add task</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>




 <div class="container mt-5">
  <?php if (!empty($success)): ?>
    <div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert" text-center>
        <?= htmlspecialchars($success) ?>
    </div>
  <?php endif; ?>
      <h2 class="mb-3">Welcome back, <?= htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?>!</h2>
  <?php if ($weeklyWorkouts >= 5): ?>
      <div class="alert alert-success">
          <span style="font-weight: bold;"><?= $workoutMessage?></span>
      </div>
<?php else: ?>
      <div class="alert alert-info">
        <span style="font-weight: bold;"><?= $workoutMessage?></span>
      </div>
<?php endif; ?>
      <p class="text-muted">Here’s a quick overview of your workout.</p>

      <!-- Quick Stats -->
      <div class="row mb-4">
        <div class="col-md-4">
          <div class="card text-center shadow-sm">
            <div class="card-body">
              <h5 class="card-title">Total Workouts</h5>
              <p class="display-6"><?= $totalWorkouts ?? 0; ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-center shadow-sm">
            <div class="card-body">
              <h5 class="card-title">Last Workout</h5>
              <p class="display-6"><?= htmlspecialchars($lastWorkoutDate ?? 'None'); ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-center shadow-sm">
            <div class="card-body">
              <h5 class="card-title">Favorite Exercise</h5>
              <p class="display-6"><?= htmlspecialchars($favoriteExercise ?? '—'); ?></p>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Workouts -->
      <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Recent Workouts</h5>
          <a href="<?= ROOT ?>/workout/add" class="btn btn-primary btn-sm">Start Your Workout</a>
        </div>
        <div class="card-body">
          <?php if (!empty($workouts)): ?>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Exercise</th>
                  <th>Reps</th>
                  <th>Sets</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($workouts as $w): ?>
                  <tr>
                    <td><?= htmlspecialchars($w['exercise']); ?></td>
                    <td><?= htmlspecialchars($w['reps']); ?></td>
                    <td><?= htmlspecialchars($w['sets']); ?></td>
                    <td><?= date("F j, Y ", strtotime($w['date'])); ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php else: ?>
            <p class="text-muted">No workouts recorded yet. Start your first one!</p>
          <?php endif; ?>
        </div>
      </div>
    </div>

 <!--workout added alert-->
 <script>
        document.addEventListener("DOMContentLoaded", function() {
        const alert = document.getElementById("successAlert");
        if (alert) {
            // Wait 3 seconds, then fade it out
            setTimeout(() => {
                alert.classList.remove("show"); // triggers Bootstrap fade animation
                alert.classList.add("fade");
                
                // Then remove it completely after fade (0.5s later)
                setTimeout(() => {
                    alert.remove();
                }, 500);
            }, 3000); // 3000 = 3 seconds
            }
        });
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
  var myModal = new bootstrap.Modal(document.getElementById('myModal'));
  myModal.show(); //  This automatically opens the modal when page loads
});
</script>


<?php 
  include 'inc/footer.php';
?>

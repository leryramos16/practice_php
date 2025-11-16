<?php
$title = "My Fit App";
include 'inc/header.php';
?>


<!-- Bootstrap Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="bi bi-megaphone"> Upcoming Tasks</h5>
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


<!-- Weather Section -->
<div id="weather-bar" style="
  background: #ffffffff; 
  color: #757575ff; 
  text-align: center; 
  padding: 5px 0; 
  font-size: 14px; 
  font-weight: bold;
">
  <span id="weather">Loading weather...</span>


</div>







 <div class="container mt-5">
  <?php if (!empty($success)): ?>
    <div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert" text-center>
        <?= htmlspecialchars($success) ?>
    </div>
  <?php endif; ?>
      <img src="<?= ROOT ?>/uploads/<?= htmlspecialchars($profile_image) ?>" 
         alt="Profile Image" 
         class="rounded-circle me-3" 
         width="50" height="50">
        <a href="<?= ROOT ?>/profile" class="btn btn-outline-primary btn-sm mt-2">
           <i class="bi bi-pencil-square"></i> Edit Profile
        </a>

      <!-- WELCOME BACK ONCE APPEAR AFTER LOG-IN-->
    <?php if (isset($_SESSION['just_logged_in']) && $_SESSION['just_logged_in']): ?>
  <div class="alert alert-light  text-center" id="welcome-message">
    <h4 class="mb-3">Welcome back, <?= htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?>!</h2>
  </div>

  <script>
    // Optional: fade out after 3 seconds
    setTimeout(() => {
      const msg = document.getElementById('welcome-message');
      if (msg) msg.style.display = 'none';
    }, 5000);
  </script>

  <?php unset($_SESSION['just_logged_in']); ?> <!-- Remove it after showing -->
<?php endif; ?>

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


<script>
const apiKey = "9cbee024427e295fe00ca4fa691a8578"; // your API key

async function getWeatherByCoords(lat, lon) {
  try {
    const res = await fetch(
      `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${apiKey}&units=metric`
    );
    const data = await res.json();
    displayWeather(data);
  } catch (err) {
    console.error("Error fetching weather:", err);
    document.getElementById("weather").textContent = "Weather unavailable";
  }
}

async function getWeatherByCity(city = "Manila") {
  try {
    const res = await fetch(
      `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric`
    );
    const data = await res.json();
    displayWeather(data);
  } catch (err) {
    console.error("Error fetching weather:", err);
    document.getElementById("weather").textContent = "Weather unavailable";
  }
}

function displayWeather(data) {
  if (!data || !data.main) {
    document.getElementById("weather").textContent = "Weather unavailable";
    return;
  }
  const temp = data.main.temp.toFixed(1);
  const city = data.name;
  const condition = data.weather[0].description;
  const icon = `https://openweathermap.org/img/wn/${data.weather[0].icon}.png`;

  document.getElementById("weather").innerHTML = `
    <img src="${icon}" alt="${condition}" style="width:20px; height:20px; vertical-align:middle;">
    ${city}: ${temp}°C, ${condition.charAt(0).toUpperCase() + condition.slice(1)}
  `;
}

// Try to get user location
if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(
    pos => {
      getWeatherByCoords(pos.coords.latitude, pos.coords.longitude);
    },
    err => {
      console.warn("Location denied, using default city.");
      getWeatherByCity(); // fallback to Manila
    }
  );
} else {
  getWeatherByCity(); // if browser doesn't support geolocation
}

// Refresh every 10 minutes
setInterval(() => {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      pos => getWeatherByCoords(pos.coords.latitude, pos.coords.longitude),
      () => getWeatherByCity()
    );
  } else {
    getWeatherByCity();
  }
}, 600000);
</script>



<?php 
  include 'inc/footer.php';
?>

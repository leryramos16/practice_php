
<div class="container mt-5">
  <h3 class="mb-4 text-center"> Choose Your Coach</h3>

  <div class="row">
    <?php foreach ($coaches as $coach): ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100 text-center shadow-sm">
          <img src="<?= ROOT ?>/uploads/<?= htmlspecialchars($coach['profile_image']) ?>" 
               alt="<?= htmlspecialchars($coach['name']) ?>"
               class="card-img-top"
               style="height: 180px; object-fit: cover;">
          <div class="card-body">
            <h5><?= htmlspecialchars($coach['name']) ?></h5>
            <p class="text-muted mb-1"><?= htmlspecialchars($coach['specialty']) ?></p>
            <small><?= htmlspecialchars($coach['experience']) ?></small>
            <p class="mt-2"><?= htmlspecialchars($coach['description']) ?></p>
            <button class="btn btn-primary btn-sm choose-coach-btn" 
                    data-id="<?= $coach['id'] ?>">Choose Coach</button>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<script>
document.querySelectorAll('.choose-coach-btn').forEach(btn => {
  btn.addEventListener('click', async () => {
    const id = btn.dataset.id;
    const res = await fetch(`<?= ROOT ?>/coach/choose/${id}`, { method: 'POST' });
    const data = await res.json();

    if (data.success) {
      btn.textContent = "Selected";
      btn.classList.replace("btn-primary", "btn-success");
    }
  });
});
</script>

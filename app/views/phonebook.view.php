<?php 
$title = 'Contacts';
include 'inc/header.php';
?>
    <h2>My Contacts</h2>
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success']; ?></div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error']; ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>
<a href="<?= ROOT ?>/phonebook/add" class="btn btn-primary mt-3 mb-3">Add New Contact <i class="bi bi-plus-circle"></i></a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Phonenumber</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($contacts as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['name']); ?></td>
                <td><?= htmlspecialchars($c['phonenumber']); ?></td>
                <td>
                    <a href="<?= ROOT ?>/phonebook/edit/<?= $c['id']; ?>" class="btn btn-light btn-sm">Edit</a>
                    <a href="<?= ROOT ?>/phonebook/delete/<?= $c['id']; ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Delete this contact?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
    </tbody>
</table>

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


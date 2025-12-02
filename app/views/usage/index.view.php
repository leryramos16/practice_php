<?php 
$title = "Water & Electric Usage";
require_once __DIR__ . '/../../views/inc/header.php'; 
?>

<div class="container mt-4">

    
    <h4>Water & Electric Usage</h4>

    <!-- ALERTS -->
    <?php if (isset($_SESSION['success'])): ?>
    <div id="successAlert" class="alert alert-success alert-dismissible fade show">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>


    <!-- ADD FORM -->
    <form action="<?= ROOT ?>/usage/add" method="POST" class="row g-2 mt-3">

        <div class="col-md-4">
            <label>Water Usage (m³)</label>
            <input type="number" name="water" class="form-control" required>
        </div>

        <div class="col-md-4">
            <label>Electric Usage (kWh)</label>
            <input type="number" name="electric" class="form-control" required>
        </div>

        <div class="col-md-3 d-flex align-items-end">
            <button class="btn btn-primary btn-sm w-100">
                Add Record
            </button>
        </div>
    </form>


    <!-- TABLE -->
    <div class="table-responsive mt-4">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Water (m³)</th>
                    <th>Electric (kWh)</th>
                    <th>Date</th>
                    <th width="140">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php if (empty($usageRecord)) : ?>
                    <tr>
                        <td colspan="5">No records found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach($usageRecord as $r): ?>
                        <tr>
                            <td><?= $r['id'] ?></td>
                            <td><?= $r['water'] ?></td>
                            <td><?= $r['electric'] ?></td>
                            <td><?= date('F d, Y', strtotime($r['created_at'])) ?></td>
                            <td>
                                <button 
                                    class="btn btn-sm btn-primary edit-btn"
                                    data-id="<?= $r['id']; ?>"
                                    data-water="<?= $r['water']; ?>"
                                    data-electric="<?= $r['electric']; ?>"
                                    data-date="<?= $r['created_at']; ?>"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal"
                                >
                                    Edit
                                </button>


                                <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $r['id'] ?>">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>

        </table>
    </div>
</div>

 <!-- MODAL NG EDIT BUTTON TO-->
     <div class="modal fade" id="editModal" tabindex="-1">
            <div class="modal-dialog">
                <form method="POST" id="editForm" action="<?= ROOT ?>/usage/update">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Usage</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="id" id="edit_id">
                            <div class="mb-2">
                                <label>Water Usage</label>                      
                                <input type="number" name="water" class="form-control" id="edit_water" required>
                                
                            </div>

                            <div class="mb-2">
                                <label>Electric Usage</label>                      
                                <input type="number" name="electric" class="form-control" id="edit_electric" required>                           
                            </div>

                            <div class="mb-3">
                                    <label>Date</label>
                                    <input type="date" name="date" id="edit_date" class="form-control" required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-primary">Save Changes</button>
                        </div>

                    </div>
                </form>
            </div>
     </div>



  <!-- DELETE MODAL TO -->
    
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Confirm Delete</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        Are you sure you want to delete this entry?
      </div>

      <div class="modal-footer">
        <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Delete</a>
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>

    </div>
  </div>
</div>

<script>
 // JS ng DELETE MODAL
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const deleteButtons = document.querySelectorAll('.delete-btn');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;

            confirmDeleteBtn.href = "<?= ROOT ?>/usage/delete/" + id;

            deleteModal.show();
        });
    });

    //EDIT MODAL SCRIPT TO
    document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.getElementById('edit_id').value = btn.dataset.id;
        document.getElementById('edit_water').value = btn.dataset.water;
        document.getElementById('edit_electric').value = btn.dataset.electric;

        // format date
        document.getElementById('edit_date').value = btn.dataset.date.split(' ')[0];
    });
});
</script>

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




<?php 
require_once __DIR__ . '/../../views/inc/header.php';
?>

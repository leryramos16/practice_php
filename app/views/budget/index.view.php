<?php 
$title = 'Budget Planner';
require_once __DIR__ . '/../inc/header.php';
?>

<div class="container mt-4">
    <h3>Budget Tracker</h3>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <form method="POST" action="<?= ROOT ?>/budget/add">

        <div class="row g-2 mt-3">
            <div class="col-sm-2">
                <select name="type" class="form-select">
                    <option value="income">Income</option>
                    <option value="expense">Expenses</option>
                </select>
            </div>

            <div class="col-sm-3">
                <input type="text" name="category" placeholder="Category" class="form-control">
            </div>

            <div class="col-sm-3">
                <input type="number" step="0.01" name="amount" placeholder="Amount" class="form-control">
            </div>

            <div class="col-sm-3">
                <input type="text" name="description" placeholder="Description" class="form-control">
            </div>

            <div class="col-sm-1">
                <button class="btn btn-primary w-100">Add</button>
            </div>
        </div>
    </form>
        
    <hr>
        
    <div class="mt-4">
        <p><strong>Total Income:</strong> <?= $data['totals']['total_income'] ?? 0 ?></p>
        <p><strong>Total Expenses:</strong> <?= $data['totals']['total_expense'] ?? 0 ?></p>
        <p><strong>Balance:</strong> <?= ($data['totals']['total_income'] ?? 0) - ($data['totals']['total_expense'] ?? 0) ?></p>
    </div>

    <table class="table table-bordered mt-3">
        <tr>
            <th>Date</th>
            <th>Type</th>
            <th>Category</th>
            <th>Amount</th>
            <th>Description</th>
            <th>Options</th>
        </tr>
        
        <?php foreach($entries as $item): ?>
        <tr>
            <td><?=  $item['date_created']?></td>
            <td><?= $item['type'] ?></td>
            <td><?= $item['category'] ?></td>
            <td><?= $item['type'] === 'expense' ? '-' : '' ?><?= $item['amount'] ?></td>
            <td><?= $item['description'] ?></td>
            <td>
                <button
                    class="btn btn-warning btn-sm edit-btn"
                    data-id="<?= $item['id'] ?>"
                    data-type="<?= $item['type'] ?>"
                    data-category="<?= $item['category'] ?>"
                    data-amount="<?= $item['amount'] ?>"
                    data-description="<?= $item['description'] ?>"
                >
                 Edit   
                </button>    
                <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $item['id'] ?>">
                    Delete
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <!-- MODAL NG EDIT BUTTON TO-->
     <div class="modal fade" id="editModal" tabindex="-1">
            <div class="modal-dialog">
                <form method="POST" id="editForm" action="<?= ROOT ?>/budget/update">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Edit Entry</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="id" id="edit_id">

                            <div class="mb-2">
                                <label>Type</label>
                                <select name="type" class="form-select" id="edit_type">
                                    <option value="income">Income</option>
                                    <option value="expense">Expenses</option>
                                </select>
                            </div>

                            <div class="mb-2">
                                <label>Category</label>
                                <input type="text" name="category" class="form-control" id="edit_category">
                            </div>

                            <div class="mb-2">
                                <label>Amount</label>
                                <input type="number" name="amount" class="form-control" id="edit_amount">
                            </div>

                            <div class="mb-2">
                                <label>Description</label>
                                <input type="text" name="description" class="form-control" id="edit_description">
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


</div>

<script>
    const editButtons = document.querySelectorAll('.edit-btn');
    const editModal = new bootstrap.Modal(document.getElementById('editModal'));

    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('edit_id').value = this.dataset.id;
            document.getElementById('edit_type').value = this.dataset.type;
            document.getElementById('edit_category').value = this.dataset.category;
            document.getElementById('edit_amount').value = this.dataset.amount;
            document.getElementById('edit_description').value = this.dataset.description;

            editModal.show();
        });
    });

    // JS ng DELETE MODAL
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const deleteButtons = document.querySelectorAll('.delete-btn');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;

            confirmDeleteBtn.href = "<?= ROOT ?>/budget/delete/" + id;

            deleteModal.show();
        });
    });
</script>


<?php require_once __DIR__ . '/../inc/footer.php'; ?>
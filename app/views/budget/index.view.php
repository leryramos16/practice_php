<?php 
$title = 'Budget Planner';
require_once __DIR__ . '/../inc/header.php';
?>


<div class="charts-container" style="display:flex; gap:20px; flex-wrap:wrap; margin-top:20px;">
    <div style="flex:1; min-width:250px; height:250px;">
        <h5 class="text-center mb-10">Expenses Report</h5>
        <canvas id="categoryChart"></canvas>
    </div>
    <div style="flex:1; min-width:250px; height:250px;">
        <h5 class="text-center">Monthly Report</h5>
        <canvas id="monthlyChart"></canvas>
    </div>
    <div style="flex:1; min-width:250px; height:250px;">
        <h5 class="text-center">Weekly Report</h5>
        <canvas id="weeklyChart"></canvas>
    </div>
    
</div>



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
                <select name="type" class="form-select" id="type">
                    <option value="income">Income</option>
                    <option value="expense">Expenses</option>
                </select>
            </div>

            <div class="col-sm-3">
                <input type="text" name="category" placeholder="Category" class="form-control" id="category" readonly>
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
        <h3>Total Income: <?= number_format($data['totals']['total_income'],2) ?></h3>
        <h3>Total Expense: <?= number_format($data['totals']['total_expense'],2) ?></h3>
        <h3>Balance: <?= number_format($data['totals']['total_income'] - $data['totals']['total_expense'],2) ?></h3>

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
                                <div class="input-group">
                                    <span class="input-group-text" id="edit_category_icon"></span>
                                     <input type="text" name="category" class="form-control" id="edit_category" readonly>
                                </div>
                               
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

<!-- CATEGORY MODAL TO -->
 <!-- CATEGORY SELECT MODAL FOR EDIT -->
<div class="modal fade" id="categoryEditModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Select Category</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">

        <div class="d-flex gap-3 justify-content-center flex-wrap">

            <div class="category-option income" data-value="Salary"><i class="bi bi-cash-stack"></i><br>Salary</div>
            <div class="category-option income" data-value="Bonus"><i class="bi bi-piggy-bank"></i><br>Bonus</div>
            <div class="category-option income" data-value="Investment"><i class="bi bi-bar-chart"></i><br>Investment</div>
            <div class="category-option income" data-value="Other"><i class="bi bi-grid"></i><br>Other</div>

            <div class="category-option expense" data-value="Food"><i class="bi bi-basket"></i><br>Food</div>
            <div class="category-option expense" data-value="Bills"><i class="bi bi-wallet2"></i><br>Bills</div>
            <div class="category-option expense" data-value="Transport"><i class="bi bi-truck"></i><br>Transport</div>
            <div class="category-option expense" data-value="Shopping"><i class="bi bi-cart"></i><br>Shopping</div>
            <div class="category-option expense" data-value="Other"><i class="bi bi-grid"></i><br>Other</div>

        </div>

      </div>
    </div>
  </div>
</div>



</div>

<script>
    



const editButtons = document.querySelectorAll('.edit-btn');
const editModal = new bootstrap.Modal(document.getElementById('editModal'));
const categoryIcons = {
    "Salary": '<i class="bi bi-cash-stack"></i>',
    "Food": '<i class="bi bi-basket"></i>',
    "Bills": '<i class="bi bi-wallet2"></i>',
    "Transport": '<i class="bi bi-truck"></i>',
    "Shopping": '<i class="bi bi-cart"></i>',
    "Other": '<i class="bi bi-grid"></i>'
};

editButtons.forEach(btn => {
    btn.addEventListener('click', function() {
        const category = this.dataset.category;

        document.getElementById('edit_id').value = this.dataset.id;
        document.getElementById('edit_type').value = this.dataset.type;
        updateEditCategoryModal();
        document.getElementById('edit_category').value = category;
        document.getElementById('edit_category_icon').innerHTML = categoryIcons[category] || '';
        document.getElementById('edit_amount').value = this.dataset.amount;
        document.getElementById('edit_description').value = this.dataset.description;

        editModal.show();
    });
});

// DELETE
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

// ADD form category input
document.getElementById("category").addEventListener("click", function () {
    updateCategoryModal();
    const modal = new bootstrap.Modal(document.getElementById('categoryEditModal'));
    modal.show();

    // Remember we are updating add form
    window.currentCategoryInput = this;
});

// EDIT form category input
    document.getElementById("edit_category").addEventListener("click", function () {
    updateEditCategoryModal();
    const modal = new bootstrap.Modal(document.getElementById('categoryEditModal'));
    modal.show();

    // Remember we are updating edit form
    window.currentCategoryInput = this;
    
});

// SELECT CATEGORY
document.querySelectorAll("#categoryEditModal .category-option").forEach(option => {
    option.addEventListener("click", function () {
        if(window.currentCategoryInput){
            window.currentCategoryInput.value = this.dataset.value;
        }
        if(window.currentCategoryIcon){
            window.currentCategoryIcon.innerHTML = categoryIcons[this.dataset.value] || '';
        }
        bootstrap.Modal.getInstance(document.getElementById('categoryEditModal')).hide();

        // Reset
        window.currentCategoryInput = null;
        window.currentCategoryIcon = null;
    });
});


// Type = income - lalabas ang salary
// type = expense - lalabas ang salary

const typeSelect = document.getElementById('type');

function updateCategoryModal() {
    const isIncome = typeSelect.value === "income";

    document.querySelectorAll('.category-option.income').forEach(el => {
        el.style.display = isIncome ? 'block' : 'none';
    });

    document.querySelectorAll('.category-option.expense').forEach(el => {
        el.style.display = isIncome ? 'none' : 'block';
    });
}

typeSelect.addEventListener('change', updateCategoryModal);
updateCategoryModal();

function updateEditCategoryModal() {
    const editTypeSelect = document.getElementById('edit_type');
    const isIncome = editTypeSelect.value === "income";

    document.querySelectorAll('.category-option.income').forEach(el => {
        el.style.display = isIncome ? 'block' : 'none';
    });

    document.querySelectorAll('.category-option.expense').forEach(el => {
        el.style.display = isIncome ? 'none' : 'block';
    });
}

</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('monthlyChart').getContext('2d');

const months = <?= json_encode(array_column($data['monthlyReport'], 'month')) ?>;
const incomeData = <?= json_encode(array_column($data['monthlyReport'], 'total_income')) ?>;
const expenseData = <?= json_encode(array_column($data['monthlyReport'], 'total_expense')) ?>;

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: months,
        datasets: [
            {
                label: 'Income',
                data: incomeData,
                backgroundColor: 'rgba(75, 192, 192, 0.6)'
            },
            {
                label: 'Expense',
                data: expenseData,
                backgroundColor: 'rgba(255, 99, 132, 0.6)'
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // allows custom height
        scales: { y: { beginAtZero: true } }
    }
});
</script>


<!-- SA WEEKLY CHART TO -->
<script>
const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');

const weeks = <?= json_encode(array_column($data['weeklyReport'], 'week')) ?>;
const weeklyIncome = <?= json_encode(array_column($data['weeklyReport'], 'total_income')) ?>;
const weeklyExpense = <?= json_encode(array_column($data['weeklyReport'], 'total_expense')) ?>;

new Chart(weeklyCtx, {
    type: 'bar',
    data: {
        labels: weeks,
        datasets: [
            {
                label: 'Income',
                data: weeklyIncome,
                backgroundColor: 'rgba(75, 192, 192, 0.6)'
            },
            {
                label: 'Expense',
                data: weeklyExpense,
                backgroundColor: 'rgba(255, 99, 132, 0.6)'
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>

<!-- CATEGORY PIE CHART -->
 <script>
const categoryCtx = document.getElementById('categoryChart').getContext('2d');

const categories = <?= json_encode(array_column($data['categoryReport'], 'category')) ?>;
const categoryTotals = <?= json_encode(array_column($data['categoryReport'], 'total')) ?>;

new Chart(categoryCtx, {
    type: 'pie',
    data: {
        labels: categories,
        datasets: [{
            data: categoryTotals,
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(153, 102, 255, 0.6)',
            ],
        }]
    },
    options: {
        responsive: true
    }
});
</script>


<?php require_once __DIR__ . '/../inc/footer.php'; ?>
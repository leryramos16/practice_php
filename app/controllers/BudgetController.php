<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class BudgetController
{
    use Controller;

      public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . ROOT . '/login');
            exit;
        }

        $budgetModel = $this->model('Budget');
        $user_id = $_SESSION['user_id'];

        // --- Pagination ---
        $limit = 7;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;

        // --- Filter Date ---
        $filter_date = $_GET['filter_date'] ?? null;

        // Fetch correct dataset
        if ($filter_date) {
            // Filter mode: still use pagination
            $entries = $budgetModel->getPaginated($user_id, $limit, $offset, $filter_date);
            $total = $budgetModel->countAll($user_id, $filter_date);
        } else {
            // Normal mode
            $entries = $budgetModel->getPaginated($user_id, $limit, $offset);
            $total = $budgetModel->countAll($user_id);
        }

        // Format dates
        foreach ($entries as &$item) {
            $item['date_created_formatted'] = date('M d, Y', strtotime($item['date_created']));
        }

        $totalPages = ceil($total / $limit);

        // Stats
        $totals = $budgetModel->getTotals($user_id);
        $monthlyReport = $budgetModel->getMonthlyReport($user_id);
        $weeklyReport = $budgetModel->getWeeklyReport($user_id);
        $categoryReport = $budgetModel->getCategoryReport($user_id);

        $data = [
            'username' => $_SESSION['username'],
            'entries' => $entries,
            'totals' => $totals,
            'filter_date' => $filter_date,
            'monthlyReport' => $monthlyReport,
            'weeklyReport' => $weeklyReport,
            'categoryReport' => $categoryReport,
            'page' => $page,
            'totalPages' => $totalPages
        ];

        $this->view('budget/index', $data);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_id = $_SESSION['user_id'];

            $type = $_POST['type'];
            $category = trim($_POST['category']);
            $amount = $_POST['amount'];
            $description = !empty(trim($_POST['description'])) ? trim($_POST['description']) : null;

            if (!empty($type) && !empty($category) && !empty($amount)) {
                //pag hindi empty to, LOAD BUDGET MODEL
                $budgetModel = $this->model('Budget');
                //then ipasok ang submit 
                $budgetModel->insert($user_id, $type, $category, $amount, $description);

                $_SESSION['success'] = 'Entry added successfully';
            } else {
                $_SESSION['error'] = 'Fill all required fields';
            }

            header('Location: ' . ROOT . '/budget');
            exit;
        }
    }

    public function delete($id)
    {
        $budgetModel = $this->model('Budget');
        $budgetModel->delete($id);
        $_SESSION['success'] = "Entry deleted";

        header('Location: ' . ROOT . '/budget');
        exit;
    }

    

    public function update()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id = $_POST['id'];
        $type = $_POST['type'];
        $category = trim($_POST['category']);
        $amount = $_POST['amount'];
        $description = trim($_POST['description']);

        $budgetModel = $this->model('Budget');
        $budgetModel->update($id, $type, $category, $amount, $description);

        $_SESSION['success'] = "Entry updated successfully";

        header('Location: ' . ROOT . '/budget');
        exit;
    }
}

    // AJAX pagination + filtering
    public function fetchEntries()
    {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['error' => 'Not logged in']);
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $budgetModel = $this->model('Budget');

        $limit = 7;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;

        $filter_date = $_GET['filter_date'] ?? null;

        // Unified logic (same as index)
        if ($filter_date) {
            $entries = $budgetModel->getPaginated($user_id, $limit, $offset, $filter_date);
            $total = $budgetModel->countAll($user_id, $filter_date);
        } else {
            $entries = $budgetModel->getPaginated($user_id, $limit, $offset);
            $total = $budgetModel->countAll($user_id);
        }

        // Format dates
        foreach ($entries as &$item) {
            $item['date_created_formatted'] = date('M d, Y', strtotime($item['date_created']));
        }

        $totalPages = ceil($total / $limit);

        echo json_encode([
            'entries' => $entries,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
        exit;
    }



}
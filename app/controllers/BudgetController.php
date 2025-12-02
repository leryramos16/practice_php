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
        }

        $budgetModel = $this->model('Budget');
        $user_id = $_SESSION['user_id'];

        // kunin lahat ng budget entries sa user na to
        $entries = $budgetModel->getAllByUser($user_id);

        $totals = $budgetModel->getTotals($user_id);

        $monthlyReport = $budgetModel->getMonthlyReport($user_id);

        $weeklyReport = $budgetModel->getWeeklyReport($user_id);
        $categoryReport = $budgetModel->getCategoryReport($user_id);

        $data = [
            'username' => $_SESSION['username'],
            'entries' => $entries,
            'totals' => $totals,
            'monthlyReport' => $monthlyReport,
            'weeklyReport' => $weeklyReport,
            'categoryReport' => $categoryReport
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



}
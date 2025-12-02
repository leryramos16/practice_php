<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class UsageController
{
    use Controller;

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . ROOT . '/login');
            exit;
        }

        $usageModel = $this->model('Usage');
        $user_id = $_SESSION['user_id'];

        $usageRecord = $usageModel->getAllUsageRecordByUser($user_id);

        $data = [
            'usageRecord' => $usageRecord,
            'username' => $_SESSION['username']
        ];


        $this->view('usage/index', $data);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $user_id = $_SESSION['user_id'];
            $water = $_POST['water'];
            $electric = $_POST['electric'];

            if (!is_numeric($water) || !is_numeric($electric)) {
                $_SESSION['error'] = "Values must be numeric.";
                header('Location: ' . ROOT . '/usage');
                exit;
            }

            if ($water < 0 || $electric < 0) {
                $_SESSION['error'] = "Values must be positive.";
                header('Location: ' . ROOT . '/usage');
                exit;
            }

            $usageModel = $this->model('Usage');
            $usageModel->insertUsage($user_id, $water, $electric);

            $_SESSION['success'] = "Usage record added.";
            header('Location: ' . ROOT . '/usage');
            exit;
        }
    }

    public function delete($id)
    {
        $usageModel = $this->model('Usage');
        $record = $usageModel->findById($id);

        if ($record['user_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = "Unauthorized action.";
            header('Location: ' . ROOT . '/usage');
            exit;
        }

        $usageModel->delete($id);
        $_SESSION['success'] = "Record deleted.";
        header('Location: ' . ROOT . '/usage');
        exit;
    }

    public function update()
    {   
        if (!isset($_SESSION['user_id'])) {
        header('Location: ' . ROOT . '/login');
        exit;
    }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'];
            $water = $_POST['water'];
            $electric = $_POST['electric'];
            $date = $_POST['date'];

            $usageModel = $this->model('Usage');

            $record = $usageModel->findById($id);
            if ($record['user_id'] != $_SESSION['user_id']) {
                $_SESSION['error'] = "Unauthorized action."; 
                header('Location: ' . ROOT . '/usage');
                exit;

            }

            $usageModel->update($id, $water, $electric, $date, $_SESSION['user_id']);

            $_SESSION['success'] = "Record updated.";
            header('Location: ' . ROOT . '/usage');
            exit;


        }
    }
}
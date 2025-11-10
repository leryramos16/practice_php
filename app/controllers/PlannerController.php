<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class PlannerController
{
    use Controller;
    public function index()
    {
         if(!isset($_SESSION['user_id'])) {
            header('Location: ' . ROOT . '/login');
            exit;
        }

        $plannerModel = $this->model('Planner');
        $user_id = $_SESSION['user_id'];

        // kunin lahat ng task at iload ang model na may function na mark missed tasks
         $tasks = $plannerModel->autoMarkMissedTasks($user_id);
        // Fetch all todos for this user
        $tasks = $plannerModel->getAllByUser($user_id);
       

        $data = [
            'username' => $_SESSION['username'],
            'tasks' => $tasks
            
        ];

        $this->view('planner', $data);
    }

   public function add()
   {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_id = $_SESSION['user_id'];
        $task_name = trim($_POST['task_name']);
        $time_to_prepare = $_POST['time_to_prepare'];
        $task_date = $_POST['task_date'];
        $note = !empty(trim($_POST['note'])) ? trim($_POST['note']) : null; //para optional ang note

        if(!empty($task_name) && !empty($time_to_prepare) && !empty($task_date)) {
            $plannerModel = $this->model('Planner');
            $plannerModel->add($user_id, $task_name, $time_to_prepare, $task_date, $note);
            $_SESSION['success'] = "Task added successfully";

        } else {
            $_SESSION['error'] = "Fill the fields!";
        }
        header('Location: ' . ROOT . '/planner');
        exit;
    }
        $this->view('planner');
   }

    public function delete($id)
    {

        $plannerModel = $this->model('Planner');
        $plannerModel->delete($id);
        $_SESSION['error'] = "Task Deleted";

        header('Location: ' . ROOT . '/planner');
        exit;
    }

    public function done($id)
    {
        $plannerModel = $this->model('Planner');
        $plannerModel->markAsDone($id);
        $_SESSION['success'] = "Task Done";

        header('Location: ' . ROOT . '/planner');
        exit;
    }

    
       


}
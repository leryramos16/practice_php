<?php 

class CoachController
{
    use Controller;

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . ROOT . '/login');
            exit;
        }

        $coachModel = $this->model('Coach');
        $coaches = $coachModel->getAllCoaches();
        $this->view('coach/index', ['coaches' => $coaches]);
    }

    public function choose($coach_id)
    {
        if (!isset($_SESSION['user_id'])) return;

        $user_id = $_SESSION['user_id'];
        $coachModel = $this->model('Coach');
        $coachModel->assignCoach($user_id, $coach_id);

        echo json_encode(['success' => true]);
    }
}
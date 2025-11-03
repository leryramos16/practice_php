<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class WorkoutController
{
    use Controller;

    public function index()
    {
        // Redirect if not logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . ROOT . '/login');
            exit;
        }

        // Load model
        $workoutModel = $this->model('Workout');
        $user_id = $_SESSION['user_id'];
        // Get all workouts for this user
        $workouts = $workoutModel->getAllByUser($user_id);

        // Send data to view
        $data = [
            'username' => $_SESSION['username'],
            'workouts' => $workouts
        ];

        $this->view('workout', $data);
    }

    public function add()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . ROOT . '/login');
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $workoutModel = $this->model('Workout');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'];
            $exercise = $_POST['exercise'];
            $reps = $_POST['reps'];
            $sets = $_POST['sets'];

            // Insert workout
            $workoutModel->add($user_id, $exercise, $reps, $sets);

            $_SESSION['success'] = "Workout added successfully!";
            header('Location: ' . ROOT . '/dashboard');
            exit;
        }

        // If not POST, just show the add workout form
        $this->view('add_workout');
    }

    public function delete($id)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . ROOT . '/login');
            exit;
        }

        $workoutModel = $this->model('Workout');
        $workoutModel->delete($id);

        header('Location: ' . ROOT . '/workout');
        exit;
    }
}

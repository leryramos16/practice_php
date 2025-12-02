<?php 

class DashboardController
{
    use Controller;
    private $workoutModel;

    public function __construct()
    {
        $this->workoutModel = new Workout();
    }

    public function index()
    {
        Auth::requireLogin();
        //check kung meron ng current session state/start pag wala pa
        if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

        if (!isset($_SESSION['user_id'])) {
            header("Location: " . ROOT . "/login");
            exit;
        }

        $user_id = $_SESSION['user_id'];

        // Load the User model to get profile info
        $userModel = $this->model('User');
        $user = $userModel->getUserById($user_id);


        // i-load and Planner Model
        $plannerModel = $this->model('Planner');

        //kunin ang upcoming task sa loob ng 24 hours lang
        $upcomingTasks = $plannerModel->getUpcomingTasks($user_id);
        
        
        //Call model
         $this->workoutModel = $this->model('Workout');

         $limit = 1;
         $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
         $offset = ($page - 1) * $limit;

         $workouts = $this->workoutModel->getByUserPaginated($user_id, $limit, $offset);
         $totalWorkouts = $this->workoutModel->countAllByUser($user_id);
         $totalPages = ceil($totalWorkouts / $limit);

         //count workout per week
          $weeklyWorkouts = $this->workoutModel->countThisWeek($user_id);

          

        if ($weeklyWorkouts == 0) {
            $workoutMessage = 'Start your weekly workout Now!';
            }

        if ($weeklyWorkouts >= 1) {
            $workoutMessage = " Keep going! You’ve done " . $weeklyWorkouts . " workout this week.";
        }  

        if ($weeklyWorkouts >= 2) {
            $workoutMessage = " Great! Keep going! You’ve done " . $weeklyWorkouts . " workouts this week.";
        } 

        if ($weeklyWorkouts >= 3) {
            $workoutMessage = " Alright! You can do this! Stay fit! You’ve done " . $weeklyWorkouts . " workouts this week.";
        } 

        if ($weeklyWorkouts >= 4) {
            $workoutMessage = " How you feeling? Stay consistent and discipline! You've done " . $weeklyWorkouts . " workouts this week.";
        } 

        if ($weeklyWorkouts == 5) {
            $workoutMessage = 'You’re working out great this week! Be consistent!';
        }

        if ($weeklyWorkouts >= 6) {
            $workoutMessage = 'Wow! I love your discipline! But remember to rest!';
        }

        if ($weeklyWorkouts >= 7) {
            $workoutMessage = 'Take a rest! Its time to recover your body';
        }
       
        

        $favorite = $this->workoutModel->getFavoriteExercise(($user_id));
        $favoriteExercise = $favorite['exercise'] ?? '-';

        //Count total workouts
        $totalWorkouts = $this->workoutModel->countAllByUser($user_id);

        //Find most recent workout date (if any)
        if (!empty($workouts)) {
            $lastWorkoutDate = date("F j, Y  g:i A", strtotime($workouts[0]['date']));
        } else {
            $lastWorkoutDate = 'No workout yet';
        }


        // Check if there's a success message in session
        $success = '';
        if (isset($_SESSION['success'])) {
            $success = $_SESSION['success'];
            unset($_SESSION['success']); // remove it so it shows only once
        }

        //Prepare data for the view
        $data = [
            'username' => $_SESSION['username'],
            'workouts' => $workouts,
            'totalWorkouts' => $totalWorkouts,
            'lastWorkoutDate' => $lastWorkoutDate,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'success' => $success,
            'weeklyWorkouts' => $weeklyWorkouts,
            'workoutMessage' => $workoutMessage,
            'upcomingTasks' => $upcomingTasks,
            'profile_image' => $user['profile_image'] ?? 'default.jpg',
            'favoriteExercise' => $favoriteExercise

        ];


        $this->view('dashboard', $data);
    }

}
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

        
        //Call model
         $this->workoutModel = $this->model('Workout');
         //count workout per week
          $weeklyWorkouts = $this->workoutModel->countThisWeek($user_id);

        if ($weeklyWorkouts == 0) {
            $workoutMessage = 'Start your workout Now!';
            }

        if ($weeklyWorkouts >= 1) {
            $workoutMessage = " Keep going! You’ve done " . $weeklyWorkouts . " workouts this week.";
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
       
        
       

        //Get all workouts for this user or Fetch
        $workouts = $this->workoutModel->getAllByUser($user_id);

        //Count total workouts
        $totalWorkouts = count($workouts);

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
            'success' => $success,
            'weeklyWorkouts' => $weeklyWorkouts,
            'workoutMessage' => $workoutMessage
        ];


        $this->view('dashboard', $data);
    }

}
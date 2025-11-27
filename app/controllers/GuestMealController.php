<?php

class GuestMealController
{
    use Controller;

    public function index()
    {
        $this->view('guestmeal');
    }

    

    public function add()
    {
         $guestmealModel = $this->model('GuestMeal');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $guest_id = $_POST['guest_id'];
            $meal_id = $_POST['meal_id'];


            // Check if repeated
            if ($guestmealModel->hasRepeatedMeal($guest_id, $meal_id)) {
                $error = " This guest has already received this meal within the last 6 days.";
                return $this->view('guestmeal', ['error' => $error]);
            }

            // Save meal if not repeated
            $guestmealModel->saveMeal($guest_id, $meal_id);

            $success = " Meal successfully assigned!";
            return $this->view('guestmeal', ['success' => $success]);

            header('Location: ' . ROOT . '/guestmeal');
            exit;
        }

        $this->view('guestmeal');
    }
}

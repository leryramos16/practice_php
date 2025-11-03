<?php 
/**
 * friends class
 */

class FriendsController
{
    use Controller;
    public function index()
    {   
        // Redirect if not logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . ROOT . '/login');
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $friendsModel = new Friends();
        $meals = $friendsModel->getMealsByUser($user_id);
        $this->view('friends');
    }

    public function upload()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['meal_image'])) {
        $user_id = $_SESSION['user_id'];
        $caption = $_POST['caption'] ?? '';

        $targetDir = "uploads/meals/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = time() . '_' . basename($_FILES["meal_image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Allow certain file formats
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["meal_image"]["tmp_name"], $targetFilePath)) {
                // Create model and save
               $friendsModel = $this->model('Friends');
               $friendsModel->addMeal($user_id, $targetFilePath, $caption);

                $_SESSION['success'] = "Meal photo uploaded successfully!";
            } else {
                $_SESSION['error'] = 'Error uploading your photo.';
            }
        } else {
            $_SESSION['error'] = 'Only JPG, JPEG, PNG & GIF files are allowed.';
        }

        header("Location: /friends");
        exit;
    }
}

    
    }


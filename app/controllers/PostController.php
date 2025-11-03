<?php 

class PostController
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
         $caption = $_POST['caption'];
         $image = $_FILES['meal_image']['name'];
         $postmodel = $this->model('Post');
         $this->$postmodel->create($user_id, $caption, $image);
    }
}
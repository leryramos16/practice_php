<?php 

class PhysiqueController
{
    use Controller;

    public function index()
    {
        //bagong variable ng Physique model
        $physiqueModel = $this->model('Physique');
        $uploads = $physiqueModel->getUploadsByUser($_SESSION['user_id']);


        $this->view('physique/feed', ['uploads' => $uploads]);
    }

    public function upload()
    {
          if (!isset($_SESSION['user_id'])) {
        header('Location: ' . ROOT . '/login');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $image = $_FILES['image'];
        $description = $_POST['description'];

        // VALIDATION
        if ($image['error'] === 0) {
            $folder = "uploads/physique/";
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }

            $filename = time() . "_" . $image['name'];
            $path = $folder . $filename;

            move_uploaded_file($image['tmp_name'], $path);

            $physiqueModel = $this->model('Physique');
            $physiqueModel->upload($_SESSION['user_id'], $path, $description);
        }

        header('Location: ' . ROOT . '/physique/feed');
        exit;
    }

    $this->view('physique/upload');
    }

public function feed()
{
    $user_id = $_SESSION['user_id'];

    $friendModel = new Friend();
    $physiqueModel = new Physique();

    // Step 1: get friends
    $friends = $friendModel->getFriends($user_id);

    // Step 2: extract friend IDs
    $friend_ids = array_column($friends, 'id');

    // Step 3: include your own user ID
    $friend_ids[] = $user_id;

    // Step 4: get uploads
    $uploads = $physiqueModel->getFriendUploads($friend_ids);

    $this->view('physique/feed', ['uploads' => $uploads]);
}


}
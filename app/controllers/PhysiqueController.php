<?php 

class PhysiqueController
{
    use Controller;

public function index()
{
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . ROOT . '/login');
        exit;
    }

    $physiqueModel = $this->model('Physique');

    // Get uploads with username
    $uploads = $physiqueModel->getUploadsByUser($_SESSION['user_id']);

    // Add like info
    foreach ($uploads as &$upload) {
        $upload['liked'] = $physiqueModel->hasLiked($_SESSION['user_id'], $upload['id']) ? true : false;
        $upload['likes'] = $physiqueModel->likeCount($upload['id']) ?? 0;
    }

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
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . ROOT . '/login');
        exit;
    }

    $user_id = $_SESSION['user_id'];

    $friendModel = new Friend();
    $physiqueModel = new Physique();

    //  get friends
    $friends = $friendModel->getFriends($user_id);

    // extract friend IDs
    $friend_ids = array_column($friends, 'id');

    // include your own user ID
    $friend_ids[] = $user_id;

    //  get uploads with username
    $uploads = $physiqueModel->getFriendUploads($friend_ids);

    // add like info for each upload
    foreach ($uploads as &$upload) {
        $upload['liked'] = $physiqueModel->hasLiked($user_id, $upload['id']) ? true : false;
        $upload['likes'] = $physiqueModel->getLikeCount($upload['id']) ?? 0;
    }

    $this->view('physique/feed', ['uploads' => $uploads]);
}


public function askRoutine($upload_id)
{
    $user_id = $_SESSION['user_id'];

    // Use model properly
    $physiqueModel = $this->model('Physique');
    $chatModel = $this->model('Chat');

    // Get the owner of the upload via model
    $uploadOwner = $physiqueModel->getUploadOwner($upload_id);

    // Check if owner exists and is not the current user
    if ($uploadOwner && $uploadOwner['user_id'] != $user_id) {
        $receiver_id = $uploadOwner['user_id'];
        $message = "How did you achieve this? What's your routine?";

        // Send message via Chat model
        $chatModel->sendMessage($user_id, $receiver_id, $message);

        // Redirect to chat page with receiver open
        header('Location: ' . ROOT . '/chat/index/' . $receiver_id);
        exit;
    }

    // Fallback: redirect to feed if something is wrong
    header('Location: ' . ROOT . '/physique/feed');
    exit;
}


public function like($upload_id)
{
    if (!isset($_SESSION['user_id'])) {
        http_response_code(403);
        echo json_encode(['success' => false]);
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $physiqueModel = $this->model('Physique');

    if ($physiqueModel->hasLiked($user_id, $upload_id)) {
        $physiqueModel->unlike($user_id, $upload_id);
        $liked = false;
    } else {
        $physiqueModel->like($user_id, $upload_id);
        $liked = true;
    }

    // always get updated count
    $likes = $physiqueModel->getLikeCount($upload_id);

    echo json_encode([
        'success' => true,
        'liked'   => $liked,
        'likes'   => $likes
    ]);
    exit;
}

}
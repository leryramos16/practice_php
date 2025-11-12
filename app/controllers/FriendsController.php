<?php 

class FriendsController
{
    use Controller;

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . ROOT . '/login');
            exit;
        }

        $friendModel = $this->model('Friend');
        $user_id = $_SESSION['user_id'];

        $this->view('friends');
    }

    public function add($receiver_id)
    {
        if (!isset($_SESSION['user_id'])) {
        http_response_code(403);
        exit;
    }

        $friendModel = $this->model('Friend');
        $user_id = $_SESSION['user_id'];

        $friendModel->sendRequest($user_id, $receiver_id);

        // Respond JSON instead of redirect
        echo json_encode(['success' => true]);
        exit;
    }

    public function accept($id)
    {
        $friendModel = $this->model('Friend');
        $friendModel->acceptRequest($id);
        header('Location: ' . ROOT . '/friends/requests');

    }

    public function list()
    {
        $friendModel = $this->model('Friend');
        $user_id = $_SESSION['user_id'];
        $friends = $friendModel->getFriends($user_id);

        $this->view('friends/list', ['friends' => $friends]);
    }

    public function requests()
    {
        $friendModel = $this->model('Friend');
        $user_id = $_SESSION['user_id'];
        $requests = $friendModel->getRequest($user_id);

        $this->view('friends/requests', ['requests' => $requests]);
    }

    public function search()
    {
        $user_id = $_SESSION['user_id'];
        $friendModel = $this->model('Friend');

        $results = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['search'])) {
            $keyword = trim($_POST['search']);
            $results = $friendModel->searchUsers($keyword, $user_id);

            foreach ($results as &$user) {
                $user['friend_status'] = $friendModel->getStatus($user_id, $user['id']);
            }
        }

        $this->view('friends/search', ['results' => $results]);
    }

    public function cancel($receiver_id)
{
    if (!isset($_SESSION['user_id'])) {
        http_response_code(403);
        exit;
    }

    $friendModel = $this->model('Friend');
    $sender_id = $_SESSION['user_id'];

    $friendModel->cancelRequest($sender_id, $receiver_id);

    echo json_encode(['success' => true]);
    exit;
}


    
}
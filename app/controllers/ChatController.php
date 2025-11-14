<?php 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class ChatController
{
    use Controller;

    

    public function index($other_user_id)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . ROOT . '/login');
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $chatModel = $this->model('Chat');
        $messages = $chatModel->getMessages($_SESSION['user_id'], $other_user_id);

        $this->view('chat/index', [
            'messages' => $messages,
            'other_user_id' => $other_user_id,
            'user_id' => $user_id
        ]);
    }

    public function send()
    {
        if (!isset($_SESSION['user_id'])) return;

        $receiver_id = $_POST['receiver_id'];
        $message = $_POST['message'];

        $chatModel = $this->model('Chat');
        $chatModel->sendMessage($_SESSION['user_id'], $receiver_id, $message);

        echo json_encode(['success' => true]);
    }

    public function fetch($other_user_id)
{
    if (!isset($_SESSION['user_id'])) return;

    header('Content-Type: application/json');
    $chatModel = $this->model('Chat');
    $messages = $chatModel->getMessages($_SESSION['user_id'], $other_user_id);

    echo json_encode($messages);
}



}

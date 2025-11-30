<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class SubscriptionController
{
    use Controller;


    public function index()
    {
         if (!isset($_SESSION['user_id'])) {
            header('Location: ' . ROOT . '/login');
        }
        $subscriptionModel = $this->model('Subscription');
        $user_id = $_SESSION['user_id'];

        $userModel = $this->model('User');
        $users = $userModel->getAll();

         $data = [
        'username' => $_SESSION['username'],
        'users' => $users
    ];

        $this->view('subscription/chooseCoach', $data);
    }


    public function pay()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . ROOT . '/login');
            exit;
        }

        if (!isset($_GET['coach_id'])) {
            header('Location: ' . ROOT . '/subscription/chooseCoach');
            exit;
        }

        $coach_id = $_GET['coach_id'];

        $data = [
            'userrname' => $_SESSION['username'],
            'coach_id' => $coach_id
        ];

        $this->view('subscription/pay', $data);
    }

    public function process()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['orderID'])) {
            $subscriptionModel = $this->model('Subscription');

            $user_id = $_SESSION['user_id'];
            $coach_id = $_POST['coach_id'];
            $plan = $_POST['plan'];
            $amount = $_POST['amount'];
            $order_id = $_POST['orderID'];

            $subscriptionModel->insertSubscription($user_id, $coach_id, $plan, $amount, $order_id, 'completed');

            $_SESSION['success'] = "Payment successful and subscription created!";

            echo json_encode(['status' => 'success']);
        }
    }

    public function mySubscription()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . ROOT . '/login');
            exit;
        }

        $subscriptionModel = $this->model('Subscription');
        $subscriptions = $subscriptionModel->getByUser($_SESSION['user_id']);

        $data = [
            'username' => $_SESSION['username'],
            'subscriptions' => $subscriptions
        ];

        $this->view('subscription/mySubscriptions', $data);

    }

    public function myClients()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . ROOT . '/login');
            exit;
        }

        $subscriptionModel = $this->model('Subscription');
        $clients = $subscriptionModel->getByCoach($_SESSION['user_id']);

        $data = [
            'username' => $_SESSION['username'],
            'clients' => $clients
        ];

        $this->view('subscription/myClients', $data);
    }
}
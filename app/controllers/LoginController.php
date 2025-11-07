<?php 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * login class
 */
class LoginController
{
    use Controller;
    public function index()
    {   

        $data = [
            'usernameOrEmail' => '',
            'usernameOrEmailErr' => '',
            'password' => '',
            'passwordErr' => '',
            'error' => ''
        ];

       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usernameOrEmail = trim($_POST['usernameOrEmail']);
            $password = $_POST['password'];

        $_SESSION['form_data'] = [
            'usernameOrEmail' => $usernameOrEmail,
            'usernameOrEmailErr' => '',
            'passwordErr' => '',
            'error' => ''
        ];

        if (empty($usernameOrEmail)) {
            $_SESSION['form_data']['usernameOrEmailErr'] = '*Username is required';
        }
        if (empty($password)) {
            $_SESSION['form_data']['passwordErr'] = '*Password is required';
        }

        if (
            empty($_SESSION['form_data']['usernameOrEmailErr']) &&
            empty($_SESSION['form_data']['passwordErr'])
        ) {
            $userModel = $this->model('User');
            $user = $userModel->findByUsernameOrEmail($usernameOrEmail);

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];

                header("Location: " . ROOT . "/dashboard");
                exit;
            } else {
                $_SESSION['form_data']['error'] = 'Invalid username/email or password.';
            }
        }

        // Redirect after POST (whether error or success)
        header("Location: " . ROOT . "/login");
        exit;
    }

    // After redirect (GET), restore form data from session
    if (isset($_SESSION['form_data'])) {
        $data = $_SESSION['form_data'];
        unset($_SESSION['form_data']);
    }
    
    $this->view('login', $data);

    }
}


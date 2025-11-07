<?php 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


class ForgotPasswordController
{
    use Controller;

    private $pdo;
    private $userModel;
    private $prModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->prModel = $this->model('PasswordReset');
    }

    public function index()
    {
        $this->view('auth/forgotpassword');
    }

    public function showForgot()
    {
        $this->view('auth/forgotpassword');
    }

    public function sendReset()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
        {
            header('Location: ' . ROOT . '/forgotpassword');
            exit;
        }

        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        if (!$email) {
            $_SESSION['error'] = 'Please enter a valid email';
            return $this->view('auth/forgotpassword');
        }

        $user = $this->userModel->findByEmail($email);
        if (!$user) {
            $_SESSION['success'] = 'If that email exists, a reset link has been sent.';
            return $this->view('auth/forgotpassword');
        }

        //Invalidate existing tokens for this user
        $this->prModel->deleteAllForUser($user['id']);

        // CREATE TOKEN ITO
        $token = Security::generateToken(32);
        $token_hash = Security::hashToken($token);
        $expires_at = Security::nowPlusMinutes(60);

        $this->prModel->create($user['id'], $token_hash, $expires_at);

        //CREATE RESET LINK
        $baseUrl = SITE_URL;
        $resetLink = $baseUrl . "/forgotpassword/showreset?token=" . urlencode($token) . "&email=" . urlencode($email);

        // Send email (use PHPMailer recommended)
        $subject = "Password reset request";
        $body = "Hi,\n\nClick the link to reset your password (valid for 60 minutes):\n\n" . $resetLink . "\n\nIf you didn't request this, ignore this email.";

        // Use your mailer function
        Mailer::send($email, $subject, $body);

        $_SESSION['success'] = 'If that email exists, a reset link has been sent.';
        return $this->view('auth/forgotpassword');
    }

    public function showReset()
    {
        $token = $_GET['token'] ?? null;
        $email = $_GET['email'] ?? null;

        if (!$token || !$email) {
            $_SESSION['error'] = 'Invalid reset link.';
            header('Location: ' . ROOT . '/forgotpassword');
            exit;
        }

        return $this->view('auth/reset', ['token' => $token, 'email' => $email]);
    }

    public function reset()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . ROOT . '/forgotpassword');
            exit;
        }

        $token = $_POST['token'] ?? null;
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';

        if (!$token || !$email) {
            $_SESSION['error'] = 'Invalid request';
            return $this->view('auth/reset', ['token' => $token, 'email' => $email]);
        }

        if ($password !== $password_confirm) {
            $_SESSION['error'] = 'Password do not match.';
            return $this->view('auth/reset', ['token' => $token, 'email' => $email]);
        }

         if (strlen($password) < 8) {
            $_SESSION['error'] = 'Password must be at least 8 characters.';
            return $this->view('auth/reset', ['token' => $token, 'email' => $email]);
        }

        $user = $this->userModel->findByEmail($email);
        if (!$user) {
            $_SESSION['success'] = 'Password updated';
            header("Location: " . ROOT . "/login");
            exit;
        }

        $token_hash = Security::hashToken($token);
        $pr = $this->prModel->findByTokenHash($token_hash);

        if (!$pr) {
            $_SESSION['error'] = 'Invalid or expired token.';
            return $this->view('auth/reset', ['token' => $token, 'email' => $email]);
        }

        //CHECK OWNER AND EXPIRY
        if ((int)$pr['user_id'] !== (int)$user['id']) {
            $_SESSION['error'] = 'Invalid reset token.';
            return $this->view('auth/reset', ['token' => $token, 'email' => $email]);
        }

        if (new DateTime($pr['expires_at']) < new DateTime()) {
            $_SESSION['error'] = 'Token expired.';
            $this->prModel->deleteById($pr['id']);
            return $this->view('auth/reset', ['token' => $token, 'email' => $email]);
        }

        //Pag okay lahat UPDATE PASSWORD
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $this->userModel->updatePassword($user['id'], $hashed);

        // remove token
        $this->prModel->deleteAllForUser($user['id']);

       
        $_SESSION['success'] = 'Your password has been updated. You can now log in.';
        header('Location: ' . ROOT . '/login'); 
        exit;
    }
}
<?php 

class ForgotPasswordSubmitController
{
    use Controller;

    public function forgotPasswordSubmit()
    {
        $email = trim($_POST['email'] ?? '');

         // Generic response message shown regardless of existence
        $responseMessage = "If an account with that email exists, a password reset link has been sent.";

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Please enter a valid email address.";
            header('Location: /forgot_password');
            exit;
        }

        // find user
        $userModel = $this->model('User');
        $user = $userModel->findByEmail($email);

        if ($user) {
            //create token
            $prModel = $this->model('PasswordReset');

             // Delete old tokens
            $prModel->deleteByUserId($user['id']);

               // Create a new token
            $reset = $prModel->createReset($user['id'], 60); // expires in 60 mins

             // Create reset URL
            $resetUrl = ROOT . "/reset_password?selector={$reset['selector']}&validator={$reset['validator']}";

            // Send email (or log link for now)
            $this->sendPasswordResetEmail($user['email'], $resetUrl);

        }

         $_SESSION['success'] = $responseMessage;
        header('Location: ' . ROOT . '/forgot-password');
        exit;
    }

     private function sendPasswordResetEmail($toEmail, $resetUrl)
    {
        // For now, log the reset link so you can test locally
        file_put_contents(__DIR__ . '/../logs/reset_links.log', $resetUrl . PHP_EOL, FILE_APPEND);
    }
} 
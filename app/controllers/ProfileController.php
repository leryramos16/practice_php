<?php 

class ProfileController
{
    use Controller;

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . ROOT . '/login');
            exit;
        }

        $user_id = $_SESSION['user_id'];

        $userModel = $this->model('User');
        $user = $userModel->getUserById($user_id);

        $this->view('profile', ['user' => $user]);
    }

    public function upload()
    {
        if (!empty($_FILES['profile_image']['name'])) {
            $targetDir = "uploads/";
            $fileName = basename($_FILES['profile_image']['name']);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

            if(in_array(strtolower($fileType), $allowedTypes)) {
                $newFileName = uniqid() . '.' . $fileType;
                $targetFilePath = __DIR__ . '/../../public/' . $targetDir . $newFileName;

                if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFilePath)) {
                    $userModel = $this->model('User');
                    $userModel->updateProfileImage($_SESSION['user_id'], $newFileName);
                    $_SESSION['success'] = "Profile image updated successfully";
                } else {
                    $_SESSION['error'] = "Error uploading file";
                }
            } else {
                 $_SESSION['error'] = "Invalid file type. Only JPG, JPEG, PNG, and GIF allowed.";
            }
        } else {
            $_SESSION['error'] = "Please select an image.";
        }

        header('Location: ' . ROOT . '/profile');
        exit;
    }
}
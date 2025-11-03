<?php 

    class LogoutController
    {

        use Controller;

        public function index()
        {
            session_unset();       // clear all session variables
            session_destroy();     // destroy the session
            header("Location: " . ROOT . "/login");
            exit;
        }

    }

?>
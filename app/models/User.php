<?php 

class User {
    
    private $db;

    public function __construct()
    {
        $this->db =(new Database())->connect();
    }

    public function register($username, $email, $password)
    {
         $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
         $stmt = $this->db->prepare($sql);
         return $stmt->execute([$username, $email, $password]);
    }

    public function findByUsername($username) 
    {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

     public function findByEmail($email) 
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByUsernameOrEmail($usernameOrEmail)
    {
        $sql = "SELECT * FROM users WHERE username = :usernameOrEmail OR email = :usernameOrEmail LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['usernameOrEmail' => $usernameOrEmail]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
       
    }

  
}
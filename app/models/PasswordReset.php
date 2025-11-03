<?php 

class PasswordReset
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = (new Database())->connect();
    }

    public function createReset($user_id, $expiresInMinutes = 60)
    {
        $selector = bin2hex(random_bytes(6));       // 12 chars -> selector
        $validator = bin2hex(random_bytes(32));     // 64 hex chars -> validator (raw token)
        $token_hash = hash('sha256', $validator);
        $expires_at = (new DateTime('now'))->modify("+{$expiresInMinutes} minutes")->format('Y-m-d H:i:s');

        $sql = "INSERT INTO password_resets (user_id, selector, token_hash, expires_at)
                VALUES (?, ?, ?,?)";
         $stmt = $this->db->prepare($sql);
         return $stmt->execute([$user_id, $selector, $token_hash, $expires_at]);
         
          return ['selector' => $selector, 'validator' => $validator, 'expires_at' => $expires_at];
    }

    //Find reset row by selector
    public function findBySelector($selector)
    {
        $sql = "SELECT * FROM password_resets WHERE selector = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$selector]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Delete reset(s) for a user or selector
    public function deleteBySelector($selector)
    {
        $sql = "DELETE FROM password_resets WHERE selector = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$selector]);
    }

    public function deleteByUserId($user_id)
    {
        $sql = "DELETE FROM password_resets WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$user_id]);
    }
}
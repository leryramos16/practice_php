<?php 

class PasswordReset
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function create($user_id, $token_hash, $expires_at)
    {
        $sql = "INSERT INTO password_resets (user_id, token_hash, expires_at) VALUES (:uid, :th, :exp)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'uid' => $user_id,
            ':th' => $token_hash,
            ':exp' => $expires_at
        ]);
    }

    
    public function findByTokenHash($token_hash)
    {
       $sql = "SELECT * FROM password_resets WHERE token_hash = :th LIMIT 1";
       $stmt = $this->db->prepare($sql);
       $stmt->execute([':th' => $token_hash]);
       return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   public function deleteById($id)
   {
    $sql = "DELETE FROM password_resets WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([':id' => $id]);
   }

    public function deleteAllForUser($user_id)
    {
        $sql = "DELETE FROM password_resets WHERE user_id = :uid";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':uid' => $user_id]);
    }
}
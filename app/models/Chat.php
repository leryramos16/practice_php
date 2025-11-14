<?php 

class Chat
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function sendMessage($sender_id, $receiver_id, $message)
    {
        $sql = "INSERT INTO messages (sender_id, receiver_id, message, is_read) 
                VALUES (:sender, :receiver, :message, 0)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':sender' => $sender_id,
            ':receiver' => $receiver_id,
            ':message' => $message
        ]);
    }

    public function getMessages($user1, $user2)
    {
        $sql = "SELECT m.*, 
                       u1.username AS sender_name, 
                       u1.profile_image AS sender_image,
                       u2.username AS receiver_name,
                       u2.profile_image AS receiver_image
                FROM messages m
                JOIN users u1 ON u1.id = m.sender_id
                JOIN users u2 ON u2.id = m.receiver_id
                WHERE (sender_id = :user1 AND receiver_id = :user2)
                   OR (sender_id = :user2 AND receiver_id = :user1)
                ORDER BY m.created_at ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user1' => $user1, ':user2' => $user2]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   
}

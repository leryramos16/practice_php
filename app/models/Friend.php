<?php 

class Friend
{
    private $db;
    protected $table = 'friends';

     public function __construct()
    {
        $this->db =(new Database())->connect();

    }

    public function sendRequest($sender_id, $receiver_id)
    {   
        //iwas add self account
        if ($sender_id == $receiver_id) return false;
        $sql = "INSERT INTO FRIENDS (sender_id, receiver_id, status)
                VALUES (:sender_id, :receiver_id, 'pending')";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
                ':sender_id' => $sender_id, 
                ':receiver_id' => $receiver_id
            ]);
    }

    public function getRequest($user_id)
    {
        $sql = "SELECT f.*, u.username, u.profile_image
                FROM friends f
                JOIN users u ON u.id = f.sender_id
                WHERE f.receiver_id = :user_id AND f.status = 'pending'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
                
    }

    public function acceptRequest($friend_id)
    {
        $sql = "UPDATE friends SET status = 'accepted' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$friend_id]);
    }

    public function declineRequest($friend_id)
    {
        $sql = "UPDATE friends SET status = 'declined' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$friend_id]);
    }

    public function getFriends($user_id)
    {
        $sql = "SELECT u.id, u.username, u.profile_image
                FROM users u
                JOIN friends f
                ON (u.id = f.sender_id OR u.id = f.receiver_id)
                WHERE (f.sender_id = ? OR f.receiver_id = ?)
                AND f.status = 'accepted'
                AND u.id != ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$user_id, $user_id, $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isFriend($user_id, $other_id)
    {
        // Prevent self-check
        if ($user_id == $other_id) {
            return false;
        }
        
        $sql = "SELECT * FROM friends
                WHERE ((sender_id = ? AND receiver_id = ?)
                OR (sender_id = ? AND receiver_id = ?))
                AND status = 'accepted'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$user_id, $other_id, $other_id, $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function searchUsers($keyword, $current_user_id)
    {
        $sql = "SELECT id, username, email, profile_image
                FROM users
                WHERE (username LIKE ? OR email LIKE ?)
                AND id != ?";
        $stmt = $this->db->prepare($sql);
        $searchTerm = "%" . $keyword . "%";
        $stmt->execute([$searchTerm, $searchTerm, $current_user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
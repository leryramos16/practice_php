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
        $stmt->execute([':id' => $friend_id]);
    }

    public function declineRequest($friend_id)
    {
        $sql = "UPDATE friends SET status = 'declined' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $friend_id]);
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
        $sql = "SELECT u.id,
                        u.username,
                        u.email,
                        u.profile_image,
                        CASE
                            WHEN f.status = 'accepted' THEN 'accepted'
                            WHEN f.status = 'pending' AND f.sender_id = :current_user THEN 'pending_sent'
                            WHEN f.status = 'pending' AND f.receiver_id = :current_user THEN 'pending_received'
                            ELSE 'none'
                        END as friend_status
                FROM users u
                LEFT JOIN friends f
                    ON (
                        (f.sender_id = :current_user AND f.receiver_id = u.id)
                        OR (f.receiver_id = :current_user AND f.sender_id = u.id)
                        )
                WHERE (u.username LIKE :keyword OR u.email LIKE :keyword)
                    AND u.id != :current_user";
        $stmt = $this->db->prepare($sql);
        $searchTerm = "%" . $keyword . "%";
        $stmt->execute([
        ':keyword' => $searchTerm,
        ':current_user' => $current_user_id
    ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStatus($current_user_id, $other_id)
{
    $sql = "SELECT sender_id, receiver_id, status
            FROM friends
            WHERE (sender_id = :user1 AND receiver_id = :user2)
                OR (sender_id = :user2 AND receiver_id = :user1)
            LIMIT 1";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':user1' => $current_user_id, ':user2' => $other_id]);
    $friend = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$friend) {
        return 'none';
    }

    if ($friend['status'] === 'pending') {

        if ($friend['sender_id'] === $current_user_id) {
            return 'pending_sent'; // user sent request -> display cancel
        } else {
            return 'pending_received'; // current user received request → show Accept/Decline
        }
    }

     if ($friend['status'] === 'declined') {
        return 'declined';
    }

    return 'none';

}
    public function cancelRequest($user_id, $other_id)
{
    $sql = "DELETE FROM friends 
            WHERE ((sender_id = :user1 AND receiver_id = :user2)
               OR (sender_id = :user2 AND receiver_id = :user1))
              AND status = 'pending'";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        ':user1' => $user_id,
        ':user2' => $other_id
    ]);
}

public function countPendingRequests($userId)
{
    $sql = "SELECT COUNT(*) AS total
            FROM friends
            WHERE receiver_id = :userId AND status = 'pending'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':userId' => $userId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row ? (int) $row['total'] : 0;
}

}
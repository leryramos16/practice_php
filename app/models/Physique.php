<?php 

class Physique
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function upload($user_id, $image_path, $description)
    {
        $sql = "INSERT INTO physique_uploads (user_id, image_path, description)
                VALUES (:user_id, :image_path, :description)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':user_id' => $user_id,
            ':image_path' => $image_path,
            ':description' => $description
        ]);
    }

    public function getUploadsByUser($user_id)
    {
        $sql = "SELECT * FROM physique_uploads
                WHERE user_id = :user_id
                ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFriendUploads($friend_ids)
    {
        if (empty($friend_ids)) {
            return []; // walang friends = walang posts shown
        }

        $placeholders = implode(',', array_fill(0, count($friend_ids), '?'));

        $sql = "SELECT p.*, u.username, u.profile_image
                FROM physique_uploads p
                JOIN users u ON p.user_id = u.id
                WHERE p.user_id IN ($placeholders)
                ORDER BY p.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($friend_ids);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getUploadOwner($upload_id)
{
    $sql = "SELECT user_id FROM physique_uploads WHERE id = :upload_id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':upload_id' => $upload_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


}
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
}
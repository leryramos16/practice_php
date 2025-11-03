<?php 

class Friends
{
    private $db;

      public function __construct()
    {
        $this->db =(new Database())->connect();
    }

     // Add a new meal upload
    public function addMeal($user_id, $image_path, $caption)
    {
        $sql = "INSERT INTO meals (user_id, image_path, caption) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$user_id, $image_path, $caption]);
    }

    // Get all meals of a specific user
    public function getUserMeals($user_id)
    {
        $sql = "SELECT * FROM meals WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // (Optional) Delete a meal
    public function deleteMeal($meal_id, $user_id)
    {
        $sql = "DELETE FROM meals WHERE id = ? AND user_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$meal_id, $user_id]);
    }

    public function getMealsByUser($user_id)
    {
        $sql = "SELECT * FROM meals WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
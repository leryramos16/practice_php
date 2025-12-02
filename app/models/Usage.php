<?php 

class Usage 
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();

    }

    public function insertUsage($user_id, $water, $electric)
    {
        $sql = "INSERT INTO water_usage ( user_id, water, electric)
                VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$user_id, $water, $electric]);
    }

    public function getAllUsageRecordByUser($user_id)
    {
        $sql = "SELECT * FROM water_usage
                WHERE user_id = ?
                ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM water_usage WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $water, $electric, $date, $user_id)
    {
        $sql = "UPDATE water_usage
                SET water = ?, electric = ?, created_at = ?
                WHERE id = ? AND user_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$water, $electric, $date, $id, $user_id]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM water_usage WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}
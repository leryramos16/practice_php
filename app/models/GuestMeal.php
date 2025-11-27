<?php

class GuestMeal
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }   

    // Check if repeated meal in last 6 days
    public function hasRepeatedMeal($guest_id, $meal_id, $days = 6)
    {
        $sql = "SELECT * FROM guest_meal_history 
                WHERE guest_id = ? 
                  AND meal_id = ?
                  AND date_served >= DATE_SUB(CURDATE(), INTERVAL ? DAY)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$guest_id, $meal_id, $days]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }

    // Save meal record for today
    public function saveMeal($guest_id, $meal_id)
    {
        $sql = "INSERT INTO guest_meal_history(guest_id, meal_id, date_served)
                VALUES (?, ?, CURDATE())";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$guest_id, $meal_id]);
    }
}

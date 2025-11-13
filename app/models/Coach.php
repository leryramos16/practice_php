<?php 

class Coach
{
    private $db;

    public function __construct()
        {
            $this->db = (new Database())->connect();
        }

    public function getAllCoaches()
    {
        $sql = "SELECT * FROM coaches";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function assignCoach($user_id, $coach_id)
    {   
        // Remove old coaches pag naka assigned na
        $sql = "DELETE FROM user_coaches WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);

        //Assign bagong coach
        $sql = "INSERT INTO user_coaches (user_id, coach_id, assigned_date)
                VALUES (:user_id, :coach_id, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':user_id' => $user_id,
            ':coach_id' => $coach_id
        ]);
    }

    public function getUserCoach($user_id)
    {
        $sql = "SELECT c.* FROM user_coaches uc
                JOIN coaches c ON uc.coach = c.id
                WHERE uc.user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
<?php

class Subscription
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }


    public function insertSubscription($user_id, $coach_id, $plan, $amount, $order_id, $status = 'completed')
    {
        $sql = "INSERT INTO subscription (user_id, coach_id, plan, amount, order_id, status)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$user_id, $coach_id, $plan, $amount, $order_id, $status]);
    }

    public function getSubscriptionForAClient($user_id)
    {
        $sql = "SELECT s.*, u.username as coach_name
                FROM subscriptions s
                JOIN users u ON s.coach_id = u.id
                WHERE s.user_id = ?
                ORDER BY s.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

     // Get subscriptions where user is coach
     public function getByCoach($coach_id)
     {
        $sql = "SELECT s.*, u.username as client_name
                FROM subscriptions s
                JOIN users u ON s.user_id = u.id
                WHERE s.coach_id = ?
                ORDER BY s.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$coach_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

      public function updateStatus($order_id, $status)
    {
        $sql = "UPDATE subscriptions SET status = ? WHERE order_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$status, $order_id]);
    }

    
}
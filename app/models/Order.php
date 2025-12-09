<?php

class Order
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function create($user_id, $total, $method, $user_reference, $mock_reference, $status)
{
    $sql = "INSERT INTO orders (user_id, total_amount, payment_method, payment_reference, mock_reference, status)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$user_id, $total, $method, $user_reference, $mock_reference, $status]);

    return $this->db->lastInsertId();
}


    public function getAllByUser($user_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getById($order_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$order_id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}

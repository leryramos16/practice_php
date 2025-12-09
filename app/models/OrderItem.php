<?php

class OrderItem
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function addItem($order_id, $product_id, $qty, $price)
    {
        $sql = "INSERT INTO order_items (order_id, product_id, quantity, price)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$order_id, $product_id, $qty, $price]);
    }

    public function getItemsByOrder($order_id)
    {
        $sql = "SELECT oi.*, p.name 
                FROM order_items oi
                JOIN products p ON p.id = oi.product_id
                WHERE order_id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$order_id]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}

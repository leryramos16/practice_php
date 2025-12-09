<?php

class Product
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM products ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function create($name, $price, $description, $user_id, $image = null)
{
    $sql = "INSERT INTO products (name, price, description, user_id, image)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$name, $price, $description, $user_id, $image]);
}

}

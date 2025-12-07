<?php

class Game
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function findAll()
    {
        $sql = "SELECT * FROM games ORDER BY title ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $sql = "SELECT * FROM games WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($title, $price)
    {
        $sql = "INSERT INTO games (title, price) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$title, $price]);
    }
}

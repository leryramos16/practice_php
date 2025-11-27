<?php

class Budget
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function getAllByUser($user_id)
    {
        $sql = "SELECT * FROM budget_entries
                WHERE user_id = ?
                ORDER BY date_created DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($user_id, $type, $category, $amount, $description = null)
    {
        $sql = "INSERT INTO budget_entries (user_id, type, category, amount, description)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$user_id, $type, $category, $amount, $description]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM budget_entries WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function getTotals($user_id)
    {
        $sql = "SELECT
                    SUM(CASE WHEN type='income' THEN amount ELSE 0 END) as total_income,
                    SUM(CASE WHEN type='expense' THEN amount ELSE 0 END) as total_expense
                FROM budget_entries
                WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $type, $category, $amount, $description = null)
    {
        $sql = "UPDATE budget_entries
                SET type = ?, category = ?, amount = ?, description = ?
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$type, $category, $amount, $description, $id]);
    }


    
}
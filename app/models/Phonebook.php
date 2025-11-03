<?php 

class Phonebook
{
    private $db;
    
     public function __construct()
    {
        $this->db =(new Database())->connect();
    }

    public function getAllByUser($user_id)
    {
        $sql = "SELECT * FROM phonebook WHERE user_id = ? ORDER BY name ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

     public function add($user_id, $name, $phonenumber)
    {
        $sql = "INSERT INTO phonebook (user_id, name, phonenumber)
                    VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$user_id, $name, $phonenumber]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM phonebook WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function update($id, $name, $phonenumber)
    {
        $sql = "UPDATE phonebook SET name = ?, phonenumber = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $phonenumber, $id]);
    }

    public function getbyId($id)
    {
        $sql = "SELECT * FROM phonebook WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
<?php

class Cart
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function getCartByUser($user_id)
    {
        $sql = "SELECT c.id, g.title, g.price, c.quantity 
                FROM cart c
                JOIN games g ON g.id = c.game_id
                WHERE c.user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addToCart($user_id, $game_id, $quantity = 1)
    {
        // check if game already in cart
        $sql = "SELECT id, quantity FROM cart WHERE user_id = ? AND game_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$user_id, $game_id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            // update quantity
            $sql = "UPDATE cart SET quantity = quantity + ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$quantity, $item['id']]);
        } else {
            // insert new
            $sql = "INSERT INTO cart (user_id, game_id, quantity) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$user_id, $game_id, $quantity]);
        }
    }

    public function removeFromCart($id)
    {
        $sql = "DELETE FROM cart WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function emptyCart($user_id)
    {
        $sql = "DELETE FROM cart WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$user_id]);
    }
}

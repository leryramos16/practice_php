<?php

class GameController
{
    use Controller;
     public function index() {
        $this->view('cart'); // points to app/views/games/index.php
    }

    public function games()
    {
        $gameModel = $this->model("Game");
        $games = $gameModel->findAll();

        echo json_encode([
            "status" => "success",
            "data" => $games
        ]);
        exit;
    }

    
    public function game($id)
    {
        $gameModel = $this->model("Game");
        $game = $gameModel->find($id);

        if ($game) {
            echo json_encode(["status" => "success", "data" => $game]);
        } else {
            echo json_encode(["status" => "error", "message" => "Game not found"]);
        }
        exit;
    }

    public function addGame()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(["status" => "error", "message" => "Invalid method"]);
            exit;
        }

        $input = json_decode(file_get_contents("php://input"), true);
        $title = $input['title'] ?? null;
        $price = $input['price'] ?? null;

        if (!$title || !$price) {
            echo json_encode(["status" => "error", "message" => "Missing title or price"]);
            exit;
        }

        $gameModel = $this->model("Game");
        $gameModel->insert($title, $price);

        echo json_encode(["status" => "success", "message" => "Game added"]);
        exit;
    }

    // Get current user's cart
public function cart($user_id)
{
    $cartModel = $this->model("Cart");
    $cart = $cartModel->getCartByUser($user_id);

    echo json_encode([
        "status" => "success",
        "data" => $cart
    ]);
    exit;
}

// Add to cart
public function addToCart()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(["status" => "error", "message" => "Invalid method"]);
        exit;
    }

    $input = json_decode(file_get_contents("php://input"), true);
    $user_id = $input['user_id'] ?? null;
    $game_id = $input['game_id'] ?? null;
    $quantity = $input['quantity'] ?? 1;

    if (!$user_id || !$game_id) {
        echo json_encode(["status" => "error", "message" => "Missing user_id or game_id"]);
        exit;
    }

    $cartModel = $this->model("Cart");
    $cartModel->addToCart($user_id, $game_id, $quantity);

    echo json_encode(["status" => "success", "message" => "Added to cart"]);
    exit;
}

// Remove from cart
public function removeFromCart($id)
{
    $cartModel = $this->model("Cart");
    $cartModel->removeFromCart($id);

    echo json_encode(["status" => "success", "message" => "Removed from cart"]);
    exit;
}

}
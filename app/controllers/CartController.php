<?php

class CartController
{
    use Controller;

    public function index()
    {
        $cart = $_SESSION['cart'] ?? [];

        $this->view("cart/index", [
            'cart' => $cart
        ]);
    }

    public function add($product_id)
    {
        $productModel = $this->model("Product");
        $product = $productModel->getById($product_id);

        if (!$product) {
            die("Product not found");
        }

        $qty = $_POST['qty'] ?? 1;

        // Initialize cart session
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // If item already inside cart, add qty
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['qty'] += $qty;
        } else {
            $_SESSION['cart'][$product_id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'qty' => $qty
            ];
        }

        redirect("cart");
    }

    public function remove($product_id)
    {
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }

        redirect("cart");
    }

    public function clear()
    {
        unset($_SESSION['cart']);
        redirect("cart");
    }
}

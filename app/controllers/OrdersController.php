<?php

class OrdersController
{
    use Controller;

    public function index()
    {
        $this->view('orders/index');
    }

    public function products()
    {
        $productModel = $this->model('Product');
        $products = $productModel->findAll();

        $this->view('orders/products', ['products' => $products]);

    }

    public function addToCart($product_id)
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $_SESSION['cart'][] = $product_id;

        $_SESSION['success'] = "Added to cart!";
        header('Location: ' . ROOT . '/orders/cart');
    }

    public function cart()
    {
        $productModel = $this->model('Product');

        $cartItems = [];
        $total = 0;

        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $pid) {
                $p = $productModel->findById($pid);
                $cartItems[] = $p;
                $total += $p->price;
            }
        }

        $this->view('orders/cart', [
            'items' => $cartItems,
            'total' => $total
        ]);
    }

    public function checkout()
    {
        $this->view('orders/checkout');
    }

    public function pay()
    {
        $orderModel = $this->model('Order');

        $order_id = $orderModel->createOrder($_SESSION['user_id'], $_SESSION['cart']);

        redirect('orders/gcash/' . $order_id);
    }

    public function gcash($id)
    {
        $this->view('orders/gcash', ['order_id' => $id]);
    }

    public function gcashSuccess($id)
    {
        $orderModel = $this->model("Order");
        $orderModel->markAsPaid($id);

        unset($_SESSION['cart']);

        $this->view('orders/success');
    }

}
<?php

class OrdersController
{
    use Controller;

    public function index()
    {
        $user_id = $_SESSION['user_id'];

        $orderModel = $this->model("Order");
        $orders = $orderModel->getAllByUser($user_id);

        $this->view("orders/index", [
            'orders' => $orders
        ]);
    }

    public function show($order_id)
    {
        $orderModel = $this->model("Order");
        $itemModel = $this->model("OrderItem");

        $order = $orderModel->getById($order_id);
        $items = $itemModel->getItemsByOrder($order_id);

        $this->view("orders/show", [
            'order' => $order,
            'items' => $items
        ]);
    }

    public function checkout()
    {
        $cart = $_SESSION['cart'] ?? [];
        $total = 0;
        $sellers = []; // store seller info per product

        $productModel = $this->model("Product");
        $userModel    = $this->model("User");

        foreach ($cart as $key => $item) {
            $total += $item['price'] * $item['qty'];

            // get seller of this product
            $product = $productModel->getById($item['id']);
            $seller_id = $product->user_id;
            $seller = $userModel->getById($seller_id);

            // store seller info in cart for the view
            $cart[$key]['seller'] = $seller;
        }

        $this->view("orders/checkout", [
            'cart'  => $cart,
            'total' => $total
        ]);

    }

    public function placeOrder()
    {
        if (!isset($_SESSION['user_id'])) {
            redirect("login");
        }

        $reference = trim($_POST['reference']);
        if (!$reference) {
            die("GCash reference number required");
        }

        $user_id = $_SESSION['user_id'];
        $cart = $_SESSION['cart'] ?? [];

        if (empty($cart)) {
            redirect("cart");
        }

        // Compute total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

         // --- CALL MOCK GCASH API ---
        $url = ROOT . "/gcashMock/pay";

        $opts = [
            "http" => [
                "method" => "POST",
                "header" => "Content-Type: application/x-www-form-urlencoded",
                "content" => http_build_query([
                    "amount" => $total
                ])
            ]
        ];

        $context = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);

        $gcash = json_decode($result);


        // Save to DB
        $orderModel     = $this->model("Order");
        $orderItemModel = $this->model("OrderItem");

        $order_id = $orderModel->create(
        $_SESSION['user_id'],    // user_id
        $total,                  // total amount
        "GCash",                 // payment method
        $reference,              // user-entered reference number
        $gcash->reference_no,    // mock reference number
        $gcash->status           // status (PAID)
    );

        foreach ($cart as $product_id => $item) {
            $orderItemModel->addItem(
                $order_id,
                $product_id,
                $item['qty'],
                $item['price']
            );
        }

        // Clear cart
        unset($_SESSION['cart']);

        $_SESSION['success'] = "Order placed! Mock GCash payment completed.";
        header("Location: " . ROOT . "/orders/show/" . $order_id);
        exit;
    }
}

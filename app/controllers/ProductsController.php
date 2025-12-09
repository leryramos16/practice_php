<?php

class ProductsController
{
    use Controller;

    public function index()
    {
        $productModel = $this->model("Product");
        $products = $productModel->getAll();

        $this->view("products/index", [
            'products' => $products
        ]);
    }

    public function show($id)
    {
        $productModel = $this->model("Product");
        $product = $productModel->getById($id);

        if (!$product) {
            die("Product not found");
        }

        $this->view("products/show", [
            'product' => $product
        ]);
    }

     public function create()
    {
        $this->view("products/create");
    }

    // Handle form submission
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name = trim($_POST['name']);
            $price = $_POST['price'];
            $description = trim($_POST['description']);
            $user_id = $_SESSION['user_id']; // admin or seller ID

            // Handle image upload
            $image = null;
            if (!empty($_FILES['image']['name'])) {
                $imageName = time() . '_' . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../../public/uploads/' . $imageName);
                $image = $imageName;
            }

            if (!empty($name) && !empty($price)) {
                $productModel = $this->model("Product");
                $productModel->create($name, $price, $description, $user_id, $image);

                $_SESSION['success'] = "Product added successfully";
                header("Location: " . ROOT . "/products");
                exit;
            } else {
                $_SESSION['error'] = "Name and Price are required";
                header("Location: " . ROOT . "/products/create");
                exit;
            }
        }
    }
}

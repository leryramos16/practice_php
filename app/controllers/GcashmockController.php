<?php

class GcashmockController
{
    use Controller;

    // Simulated GCash payment API
    public function pay()
    {
        header("Content-Type: application/json");

        $amount = $_POST['amount'] ?? 0;

        $response = [
            "status" => "PAID",
            "reference_no" => "MOCK-" . rand(10000000, 99999999),
            "amount" => $amount,
            "message" => "Mock GCash payment successful"
        ];

        echo json_encode($response);
    }
}

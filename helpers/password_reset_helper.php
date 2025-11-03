<?php 

    function random_bytes_hex($len = 32) {
        //returns a hex string of length 2*$len
        return bin2hex(random_bytes($len));
    }

    function hash_token($token) {
        // use SHA-256 (store hex)
        return hash('sha256', $token);
    }

    // Create expiry datetime string
    function expiry_datetime($minutes = 60) {
        $dt = new DateTime('now', new DateTimeZone('Asia/Manila'));
        $dt->modify("+{$minutes} minutes");
        return $dt->format('Y-m-d H:i:s');
    }
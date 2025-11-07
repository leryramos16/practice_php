<?php
require 'vendor/autoload.php';
require 'app/libs/Mailer.php';
require 'app/config.php';

Mailer::send('test@example.com', 'Test Email', 'Hello from PHPMailer!');
echo "Sent!";
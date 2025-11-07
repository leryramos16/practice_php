<?php 

    if($_SERVER['SERVER_NAME'] == 'localhost')
    {

            /**database config */
           define('DBNAME', 'useraccounts');
           define('DBHOST', 'localhost'); 
           define('DBUSER', 'root'); 
           define('DBPASS', ''); 

           define('SITE_URL', 'http://localhost/myapp/public');



           define('ROOT', 'http://localhost/myapp/public');

    }else
    {

            /**database config */
           define('DBNAME', 'useraccounts');
           define('DBHOST', 'localhost'); 
           define('DBUSER', 'root'); 
           define('DBPASS', ''); 
            
           define('ROOT', 'https://www.yourwebsite.com');
    }

    define('SMTP_HOST', 'smtp.gmail.com');
    define('SMTP_USER', 'fitnessjourney2025app@gmail.com');
    define('SMTP_PASS', 'upakwuuvjmlgitus');  
    define('SMTP_PORT', 587);

    define('MAIL_FROM', 'youremail@gmail.com');
    define('MAIL_FROM_NAME', 'Fitness Journey App');


    define('APP_NAME', "My Website");
    define('APP_DESC', "Best website on the planet");

    /** true means show errors */
    define('DEBUG', true);

    /**  create PDO connection */
try {
    $conn = new PDO("mysql:host=" . DBHOST . ";dbname=" . DBNAME, DBUSER, DBPASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database Connection failed: " . $e->getMessage());
}
 
    

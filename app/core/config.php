<?php 

    if($_SERVER['SERVER_NAME'] == 'localhost')
    {

            /**database config */
           define('DBNAME', 'useraccounts');
           define('DBHOST', 'localhost'); 
           define('DBUSER', 'root'); 
           define('DBPASS', ''); 



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
 
    

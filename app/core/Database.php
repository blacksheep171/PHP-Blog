<?php
namespace App\Core;
use App;
use PDO;
use PDOException;

/**
 * connect to database
 * @return PDO
 */
class Database
{
   public static function connect(){
        $host = App::getConfig()['host'];
        $username = App::getConfig()['user'];
        $password = App::getConfig()['password'];
        $dbname = App::getConfig()['name'];
       
        try {
            $con = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
        }
            return $con;
   }
}  
?>

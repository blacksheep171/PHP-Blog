<?php
// namespace app\core;

class Database
{
    private $host = DB_SERVER;
    private $user = DB_USERNAME;
    private $pass = DB_PASSWORD;
    private $dbname = DB_NAME;

    private $dbh;
    private $stmt;
    private $error;

    public function __construct(){
        // set DSN
        $dsn = 'mysql:host='.$this->host . ';dbname='.$this->dbname;
        $options = array (
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try{
            $this->dbh = new PDO($dsn, $this->user,$this->pass,$options);
        } catch(PDOException $e){
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }
    //prepare statement with query
    public function query($sql){
        $this->stmt = $this->dbh->prepare($sql);
    }
    //bind values
    public function bind($params, $value, $type = null){
        if(is_null($type)){
            switch(true){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                break;
                default:
                    $type = PDO::PARAM_STR;
                break;
                
            }
        }
        $this->stmt->bindValue($params,$value,$type);
    }
    // Execute the prepare statement
    public function execute(){
        return $this->stmt->execute();
    }
    // Get result set as array of objects 
    public function resultSet(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }
     // Get result set as array of objects 
     public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }
}  
?>
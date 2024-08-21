<?php

class DB{
    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;

    public function __construct(){
        $this->host     = 'localhost';
        $this->db       = '';
        $this->user     = 'TG12r';
        $this->password = 'cachorro1uwu';
        $this->charset  = 'utf8mb4';
    }

    function connect(){
    
        try{
            
            $connection = "mysql:host=localhost;dbname=mazask;charset=" . $this->charset;
            $pdo = new PDO($connection, $this->user, $this->password);
    
            return $pdo;

        }catch(PDOException $e){
            print_r('Error connection: ' . $e->getMessage());
        }   
    }
}

?>
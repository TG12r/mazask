<?php
include_once 'db.php';

class User extends DB{
    private $username;
    private $role_id;
    private $id;
    private $description;

    public function userExists($user, $pass){
        $md5pass = base64_encode($pass);
        $query = $this->connect()->prepare('SELECT * FROM usuarios WHERE username = :user AND password = :pass');
        $query->execute(['user' => $user, 'pass' => $md5pass]);

        if($query->rowCount()){
            return true;
        }else{
            return false;
        }
    }
    public function Regist($user, $pass){
        // Fecha de registo:
        date_default_timezone_set('America/Panama');
        $data = date('d-m-Y', time());
        $short = substr($user,0,3);
        
        $query = $this->connect()->prepare("INSERT INTO `usuarios` (`id`, `username`, `shortUsername`, `password`, `data`, `roleId`) VALUES (NULL, '$user', '$short',  '$pass', '$data', '1')");
        if($query->execute()){
            return true;
        }
        return false;
    }
    public function nameExists($user){
        $query = $this->connect()->prepare('SELECT * FROM usuarios WHERE username = :user');
        $query->execute(['user' => $user,]);

        if($query->rowCount()){
            return true;
        }else{
            return false;
        }
    }

    public function setUser($user){
        $query = $this->connect()->prepare('SELECT * FROM usuarios WHERE username = :user');
        $query->execute(['user' => $user]);
        
        foreach ($query as $currentUser) {
            $this->username = $currentUser['username'];
        }
    }
    public function WatchUser($id){
        $query = $this->connect()->prepare('SELECT * FROM usuarios WHERE id = :id');
        $query->execute(['id' => $id,]);

        if($query->rowCount()){
            return $query->fetchAll();
        }
        return $query->rowCount();
    }
    public function set($user){
        $query = $this->connect()->prepare('SELECT * FROM usuarios WHERE username = :user');
        $query->execute(['user' => $user]);
        
        foreach ($query as $currentRole) {
            $this->role_id = $currentRole['roleId'];
            $this->id = $currentRole['id'];
        }
    }
    public function UserRecord($id){
        $query = $this->connect()->prepare('SELECT * FROM records WHERE userId = :id ORDER BY `records`.`record` ASC');

        if($query->execute(['id'=>$id])){
            return $query->fetchAll();
        }else{
            return false;
        }
    }

    public function getNombre(){
        return $this->username;
    }
    public function getRole(){
        return $this->role_id;
    }
    public function getId(){
        return $this->id;
    }
    public function getDesc(){
        return $this->description;
    }
}
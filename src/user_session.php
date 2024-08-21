<?php

class UserSession{

    public function __construct(){
        session_start();
    }

    public function setCurrentUser($user){
        $_SESSION['user'] = $user;
    }
    public function setCurrentId($id){
        $_SESSION['id'] = $id;
    }
    public function getCurrentUser(){
        return $_SESSION['user'];
    }

    public function closeSession(){
        session_unset();
        session_destroy();
    }
}

?>
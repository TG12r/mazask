<?php
include_once 'db.php';
class records extends DB{
    public function Regist($userId, $record){
        // Fecha de registo:
        date_default_timezone_set('America/Panama');
        $data = date('d-m-Y', time());
        
        $query = $this->connect()->prepare("INSERT INTO `records` (`id`, `userId`, `record`, `data`) VALUES (NULL, '$userId', '$record', '$data')");
        if($query->execute()){
            return true;
        }
        return false;
    }
    public function WatchRecords(){
        $query = $this->connect()->prepare('SELECT * FROM records ORDER BY `records`.`record` ASC');

        if($query->execute()){
            return $query->fetchAll();
        }else{
            return false;
        }
    }
}
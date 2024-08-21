<?php
session_start();
if (isset($_SESSION['id']) && isset($_POST['record'])) {
    include_once 'records.php';

    $records = new records();
    
    $record = htmlspecialchars($_POST['record']);
    $records->Regist($_SESSION['id'], $record);
    echo "uwu";
}else{
    echo "uwu2";
}
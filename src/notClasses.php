<?php
if(isset($_SESSION['user'])){ 
    $user->setUser($userSession->getCurrentUser());
     include_once $fin; 
}elseif(isset($_POST['username']) && isset($_POST['password'])){
    $userForm = htmlspecialchars($_POST['username']);
    $passForm = htmlspecialchars($_POST['password']); 
    if($user->userExists($userForm, $passForm)){ 
        $userSession->setCurrentUser($userForm); 
        $user->setUser($userForm); 
        $user->setRole($userForm);

        $userSession->setCurrentRole($user->getRole()); 
        $userSession->setCurrentId($user->getId());
        $userSession->setCurrentDesc($user->getDesc());

        include_once $fin; 
    }else{ 
        $errorLogin = 'Algo esta mal :('; 
        include_once $login; 
    } 
}else{ 
        include_once $login; 
    }
?>
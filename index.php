<?php
    include_once 'src/user.php';
    include_once 'src/user_session.php';
  
    $userSession = new UserSession();
    $user = new User();
    $FormError = 'input';
    $fin = 'html/index.php';
    $login = './html/main.html';

if(isset($_SESSION['user'])){
    //"hay sesion";
    $user->setUser($userSession->getCurrentUser());
    include_once $fin;
}elseif(isset($_POST['username']) && isset($_POST['password'])){
    //"validacion de login";

    $userForm = htmlspecialchars($_POST['username']);
    $passForm = htmlspecialchars($_POST['password']);
    if($_POST['submit'] == 'Entrar'){
        // Login
        if($userForm == ''){
            $FormError = 'form-error';
            include_once 'html/login.php';
            exit;
        }
        if($user->userExists($userForm, $passForm)){
            //"usuario validado";
            $userSession->setCurrentUser($userForm);
            $user->setUser($userForm);
            
            $userSession->setCurrentId($user->getId());

            if($user->WatchUser($user->getId())['ban'] == 0){
                include_once $fin;
            }elseif($user->WatchUser($user->getId())['ban'] == 1){
                $errorLogin = '<p id="error">Estás baneado :(</p>';
                $FormError = 'form-error';
                include_once $login;
            }
        }else{
            $errorLogin = '<p id="error">Algo esta mal :(</p>';
            $FormError = 'form-error';
            include_once $login;
        }
    }elseif ($_POST['submit'] == 'Crear cuenta'){
        //Registrarse
        $pass = htmlspecialchars($_POST['password']);
        $pass_2 = htmlspecialchars($_POST['password_2']);
    // revisar si las contraseñas son iguales
        if($pass === $pass_2){

        //revisa si el usuario ya existe
        if($user->nameExists($_POST['username']) == false){
            $pass64 = base64_encode($pass_2);

            //Registra el usuarios
            if($user->Regist($_POST['username'], $pass64)){
                //index.php pero sin las clases xDDD
                include 'include/notClasses.php';
            }
        }else{
            $errorRegist = '<p id="error">El usuario ya existe</p>';
            include_once $login;
        }
    }else{
        $errorRegist = 'Las contraseñas no son iguales :(';
        include_once $login;
    }
    }
}else{
    //echo "Login";
    include_once $login;
}

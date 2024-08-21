<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar | Mazask</title>

    <link rel="stylesheet" href="./css/login.css">
    <script>
        if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
  <section class="section" id="supa">
    
    <div>
      <form class="formulario" method="POST" action="" id="form">
        <?php
          if(isset($errorLogin)){
            echo $errorLogin;
          }?>
          <?php if(isset($class)){print $class;} ?>
          <span>INGRESAR</span>
          <input class="<?php if(isset($FormError)){echo $FormError;} ?>" spellcheck="false" autocomplete="off" name="username" id="name" type="text" placeholder="Nombre de usuario"><br>
          <input class="<?php if(isset($FormError)){echo $FormError;} ?>" id="password" type="password" name="password" placeholder="Contraseña"><br>
          <input class="boton" name="submit" type="submit" value="Entrar"> <br>
      </form>
    </div>
  </section>
  <section class="section">
    <div>
      <form class="formulario" method="POST" action="" id="form2" >
        <?php if(isset($errorRegist)){ 
          echo $errorRegist.'<br>'; 
        } ?>
        <span>REGISTRARSE</span>
        <input class="input" name="username" id="name" type="text" placeholder="Nombre de usuario" autocomplete="off" require ><br>
        <input class="input" id="password" type="password" name="password" placeholder="Contraseña" require autocomplete="new-password"><br>
        <input class="input" id="password" type="password" name="password_2" placeholder="Repite la contraseña" require autocomplete="confirm-password"><br>
        <input class="boton" type="submit" name="submit" value="Crear cuenta"> <br>
      </form>
    </div>
  </section>
</body>
</html>
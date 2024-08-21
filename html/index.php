<?php
    $pb = $user->UserRecord($_SESSION['id'])[0]['record'];

    $minutos = str_pad(floor($pb / 60), 2, '0', STR_PAD_LEFT);
    $segundos = str_pad($pb % 60, 2, '0', STR_PAD_LEFT);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mazask</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap">
    <link rel="stylesheet" href="/css/index.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>
<body>
    <div class="title">
        <span class="titulo">¡Aventura en el Laberinto!</span> 
        <div>
            <a href="./ranking/">Ranking mundial</a>
            <a href="./src/close.php">Cerrar sesión</a>
        </div>
    </div>
    <header>
        <div id="nivel-indicador">Nivel: 1/5</div> <!-- Indicador de nivel -->
        <div id="tiempo-indicador">Tiempo: 00:00</div> <!-- Temporizador -->
        <div class="userName">Record: <?php echo "$minutos:$segundos" ?></div>
        <div class="userName"><?php echo $_SESSION['user'] ?></div>

    </header>
    <div id="game-container">
        <div id="maze"></div>
        <div id="object"></div>
        <div id="question-box" class="hidden">
            <p id="question"></p>
            <input type="text" id="answer" placeholder="Escribe tu respuesta">
            <button id="submit-answer">Enviar</button>
        </div>
        <div id="estado-pausa" class="hidden">
            <p>¡Juego en pausa!</p>
        </div>
        <div id="pop-up-container" class="hidden">
            <p id="pop-up-message"></p>
            <button id="close-pop-up">Cerrar</button>
        </div>
        <div id="guardar-record" class="hidden">
            <p>¡Guardar record!</p>
            <div><?php echo $user->WatchUser($_SESSION['id'])[0]['shortUsername'] ?></div>
            <button id="btn-guardar-record">Guardar</button>
        </div>
    </div>
    <script src="/src/index.js" type="module"></script>
</body>
</html>

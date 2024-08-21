<?php
    include_once '../src/records.php';

    $_records = new records();
    
    $records = $_records->WatchRecords();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking Mundial | Mazask</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap">
    <link rel="stylesheet" href="../css/ranking.css">
    <script>
        if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>
<body>
    <div class="title">
        <span class="titulo">Ranking Mundial</span>
        <div>
            <a href="../">Jugar</a>
            <a href="../src/close.php">Cerrar sesión</a>
        </div>
    </div>
    <main>
        <div class="tituloRecords">
            <span>NOMBRE</span><span>TIEMPO</span>
        </div>
        <ul>
<?php
for ($i=0; $i < count($records); $i++) { 
$record = $records[$i];
$minutos = str_pad(floor($record['record'] / 60), 2, '0', STR_PAD_LEFT);
$segundos = str_pad($record['record'] % 60, 2, '0', STR_PAD_LEFT);
?>
            <li>
                <div class="record">
                    <div>
                        <span><?php echo $i+1 ?></span>
                        <span><?php echo $user->WatchUser($record['userId'])[0]['shortUsername'] ?></span>
                    </div>
                    <span><?php echo "$minutos:$segundos" ?></span>
                </div>
            </li>
<?php
}
?>
        </ul>
    </main>
</body>
</html>
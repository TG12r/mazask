<?php
require('./user_session.php');
$user = new UserSession;

$user->closeSession();
header('Location: ../');

?>
<?php
session_start();
unset($_SESSION['juego']); // Reinicia partida
header('Location: controlador/juego.php');
exit;
?>

<?php
session_start();
require_once '../modelo/movimiento.php';


// --------------CREA UN OBJETO DE PARTIDA para acceder a los métodos---------------
$juego = new partida(); 

// ------------------ DATOS FORMULARIO---------------------
if (isset($_POST['nombreX']) && isset($_POST['nombreO'])) {
    $_SESSION['nombreX'] = trim($_POST['nombreX']);
    $_SESSION['nombreO'] = trim($_POST['nombreO']);
}

// ------------------ACCIONES---------------------------
if (isset($_GET['pos'])) { //Busca en URL si hay parámetro
    $pos = (int) $_GET['pos']; //pasa a string
    $juego->jugar($pos); //guarda el estado actual
} elseif (isset($_GET['reiniciar'])) {
    $juego->reiniciar();
    unset($_SESSION['nombreX'], $_SESSION['nombreO']);
}

// ---------------------DATOS DE LA NUEVA VISTA--------------
$tablero = array_chunk($juego->tablero ?? [], 3);
$ganador = $juego->ganador ?? null;
$turno = $juego->turno ?? 'X';

// ---------------------NOMBRES-------------------
$nombreX = $_SESSION['nombreX'] ?? 'Jugador X';
$nombreO = $_SESSION['nombreO'] ?? 'Jugador O';

// --------------------CARGAR LA VISTA----------------------
include '../vista/tablero.php';

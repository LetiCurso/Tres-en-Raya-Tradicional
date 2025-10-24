<?php

class partida
{
    public $tablero;   // Array con 9 posiciones (0–8)
    public $turno;     // 'X' o 'O'
    public $ganador;   // null, 'X', 'O' o 'Empate'

    public function __construct()
    {
        // Si no existe sesión, iniciamos el juego
        if (!isset($_SESSION['tablero'])) {
            $this->reiniciar();
        } else {
            $this->tablero = $_SESSION['tablero'];
            $this->turno = $_SESSION['turno'];
            $this->ganador = $_SESSION['ganador'];
        }
    }

    /**--------------------REINICIAR EL JUEGO---------------------- */
    public function reiniciar()
    {
        $this->tablero = array_fill(0, 9, '');
        $this->turno = 'X';
        $this->ganador = null;
        $this->guardar();
    }

/**--------------------POSICIÓN DE LA JUGADA---------------------- */
    public function jugar($pos)
    {
        // No permite jugada si hay ganador o es diferente a vacío
        if ($this->ganador || $this->tablero[$pos] !== '') {
            return;
        }

        // Marcar jugada
        $this->tablero[$pos] = $this->turno;

        // Verificar si hay ganador
        if ($this->hayGanador()) {
            $this->ganador = $this->turno; // el que está en turno se almacena en ganador
        } elseif (!in_array('', $this->tablero, true)) { //si no hay vacío en el array
            $this->ganador = 'Empate';
        } else {

        // Cambiar turno
            $this->turno = ($this->turno === 'X') ? 'O' : 'X';
        }

        $this->guardar();
    }

    /**--------------------SUPERGLOBAL QUE ACTUALIZA LA SESIÓN ---------------------- */
    private function guardar()
    {
        $_SESSION['tablero'] = $this->tablero;
        $_SESSION['turno'] = $this->turno;
        $_SESSION['ganador'] = $this->ganador;
    }

   /**--------------------POSIBILIDADES DE GANAR---------------------- */
    private function hayGanador()
    {
        $lineas = [
            [0, 1, 2],
            [3, 4, 5],
            [6, 7, 8],
            [0, 3, 6],
            [1, 4, 7],
            [2, 5, 8],
            [0, 4, 8],
            [2, 4, 6],
        ];

        foreach ($lineas as $linea) {
            [$a, $b, $c] = $linea;
            if ($this->tablero[$a] !== '' &&
                $this->tablero[$a] === $this->tablero[$b] &&
                $this->tablero[$a] === $this->tablero[$c]) {
                return true;
            }
        }

        return false;
    }
}

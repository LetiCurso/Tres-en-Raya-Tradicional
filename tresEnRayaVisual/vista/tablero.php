<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tres en Raya</title>
    <style>
        table {
            border-collapse: collapse;
            margin: 20px auto;
        }

        td {
            width: 60px;
            height: 60px;
            text-align: center;
            border: 1px solid #000;
            font-size: 2em;
        }

        a {
            display: block;
            width: 100%;
            height: 100%;
            text-decoration: none;
            color: inherit;
        }

        .boton {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            color: #fff;
            cursor: pointer;
        }

        .boton_primario {
            opacity: 0.9;
            background-color: #333;
        }

        .boton_juego {
            background-color: green;
        }

        .contenedor-juego {

            display: flex;
            justify-content: center;
            align-items: center;
            gap: 40px;
            margin-top: 20px;
        }

        .col {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 150px;
            max-width: 200px;
            box-sizing: border-box;
        }

        .col.jugadores form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            margin-bottom: none;
        }

        .tablero td {
            width: 60px;
            height: 60px;
            text-align: center;
            border: 1px solid #000;
            font-size: 2em;
        }

        .tablero a {
            display: block;
            width: 100%;
            height: 100%;
            text-decoration: none;
            color: inherit;
        }

        .boton_juego {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            border-radius: 8px;
            background-color: green;
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
        }

        .boton_juego:hover {
            opacity: 0.9;
        }
    </style>
</head>

<body>
    <!---------------------------INFORMACIÓN DEL TURNO---------------->
    <h2 style="text-align:center;">
        Turno:
        <?= ($turno === 'X')
            ? htmlspecialchars($nombreX) . " (X)"
            : htmlspecialchars($nombreO) . " (O)" ?>
    </h2>
    <!------------FORMULARIO PARA NOMBRES E INICIO DEL JUEGO ------------------->
    <div class="contenedor-juego">
        <div class="col jugadores">
            <form method="post" action="../controlador/juego.php">

                <small style="display:block; text-align:center;">Nombres personalizables
                </small>
                <button type="button" class="editable boton boton_primario" data-input="inputX">
                    <?= htmlspecialchars($nombreX ?? 'Jugador X') ?>
                </button>
                <input type="text" name="nombreX" id="inputX" value="<?= htmlspecialchars($nombreX ?? '') ?>" style="display:none;">

                <button type="button" class="editable boton boton_primario" data-input="inputO">
                    <?= htmlspecialchars($nombreO ?? 'Jugador O') ?>
                </button>
                <input type="text" name="nombreO" id="inputO" value="<?= htmlspecialchars($nombreO ?? '') ?>" style="display:none;">

                <button type="submit" class="boton boton_juego">Jugar</button>

            </form>
        </div>

        <!--------------------------TURNO Y TABLERO-------------------------------->
        <div class="col tablero">


            <!--------------------------TABLERO-------------------------------->
            <table>
                <?php foreach ($tablero as $filaIndex => $fila): ?> <!-- dentro de tablero, da el índice y el contenido de la FILA -->
                    <tr>
                        <?php foreach ($fila as $colIndex => $valor): // -- dentro de FILA, da el índice y el valor (x,o, O nada) de la COLUMNA -->
                            $pos = $filaIndex * 3 + $colIndex; //posición del tablero sin tener en cuenta 2 dimensiones
                            $esCeldaVacia = ($valor === '' && !$ganador);
                        ?>
                            <td>
                                <?= $esCeldaVacia
                                    ? "<a href='../controlador/juego.php?pos=$pos'>&nbsp;</a>"
                                    : htmlspecialchars($valor)
                                ?>
                            <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <!--------------------------COLUMNA DE GANADOR Y REINICIAR-------------------------------->
        <div class="col info">
            <div>
                <?php if ($ganador): ?>
                    <h3 style="text-align:center;">
                        <?= $ganador === 'Empate'
                            ? '¡Empate!'
                            : "¡Ganó " . ($ganador === 'X' ? htmlspecialchars($nombreX) : htmlspecialchars($nombreO)) . " !" ?>
                    </h3>
                <?php endif; ?>
                <div style="text-align:center; margin-top:20px" class="boton boton_juego">
                    <a href="../controlador/juego.php?reiniciar=1">Reiniciar juego</a>
                </div>
            </div>
        </div>
    </div>
    <!--------------------------JavaScript para que sea input los botones------------------>
    <script>
        document.querySelectorAll('.editable').forEach(btn => {
            const input = document.getElementById(btn.dataset.input);

            btn.addEventListener('click', () => {
                btn.style.display = 'none';
                input.style.display = 'inline-block';
                input.focus();
            });

            input.addEventListener('blur', () => {
                if (input.value.trim() !== '') btn.textContent = input.value;
                input.style.display = 'none';
                btn.style.display = 'inline-block';
            });

            input.addEventListener('keydown', e => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    input.blur();
                }
            });
        });
    </script>


</body>

</html>
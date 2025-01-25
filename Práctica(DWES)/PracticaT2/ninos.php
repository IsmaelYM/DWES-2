<?php
require_once('conexion.php');

// Función para mostrar la tabla de niños
function mostrarTablaNinos($conexion)
{
    $consulta = "SELECT * FROM ninos ORDER BY nombreNino";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        echo "<table border='1'>";
        echo "<tr><td>ID</td><td>Nombre</td><td>Apellido</td><td>Fecha de nacimiento</td><td>Bueno</td><td>Acciones</td></tr>";

        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>{$fila['idNino']}</td>";
            echo "<td>{$fila['nombreNino']}</td>";
            echo "<td>{$fila['apellidoNino']}</td>";
            echo "<td>{$fila['fechaNacimientoNino']}</td>";
            $buenoMalo = ($fila['buenoMalo'] == 1) ? 'Sí' : 'No';
            echo "<td>{$buenoMalo}</td>";
            echo "<td>";
            echo "<form action='ninos.php' method='post'>";
            echo "<input type='hidden' name='id_nino' value='{$fila['idNino']}'>";
            echo "<input type='submit' name='borrar' value='Borrar'>";
            echo "<input type='submit' name='editar' value='Editar'>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No se encontraron registros";
    }
}

// Mostrar la tabla
mostrarTablaNinos($conexion);

// Procesar el formulario para agregar un nuevo niño
if (isset($_POST['agregar_nino'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fechaNacimiento = DateTime::createFromFormat('d/m/Y', $_POST['fecha_nacimiento']);

    if ($fechaNacimiento) {
        $fechaNacimientoFormateada = $fechaNacimiento->format('Y-m-d');

        $buenoMalo = $_POST['bueno_malo'];

        $consultaAgregar = "INSERT INTO ninos (nombreNino, apellidoNino, fechaNacimientoNino, buenoMalo) VALUES ('$nombre', '$apellido', '$fechaNacimientoFormateada', '$buenoMalo')";
        $resultadoAgregar = mysqli_query($conexion, $consultaAgregar);

        if ($resultadoAgregar) {
            echo "Se ha agregado el nuevo niño correctamente";
            // Refrescar la página para ver los cambios
            echo "<meta http-equiv='refresh' content='0'>";
        } else {
            echo "Error al agregar el nuevo niño: " . mysqli_error($conexion);
        }
    } else {
        echo "Formato de fecha incorrecto. Use dd/mm/yyyy.";
    }
}

?>

<h2>Agregar nuevo niño</h2>
<form action="ninos.php" method="post">
    Nombre: <input type="text" name="nombre"><br>
    Apellido: <input type="text" name="apellido"><br>
    Fecha de nacimiento: <input type="text" name="fecha_nacimiento"><br>
    Bueno (1 para Sí, 0 para No): <input type="text" name="bueno_malo"><br>
    <input type="submit" name="agregar_nino" value="Agregar niño">
</form>

<?php
// Procesar el formulario para borrar un niño
if (isset($_POST['borrar'])) {
    $idNinoEliminar = $_POST['id_nino'];

    $consultaEliminar = "DELETE FROM ninos WHERE idNino = '$idNinoEliminar'";
    $resultadoEliminar = mysqli_query($conexion, $consultaEliminar);

    if ($resultadoEliminar) {
        echo "Se ha eliminado el niño correctamente";
        // Refrescar la página para ver los cambios
        echo "<meta http-equiv='refresh' content='0'>";
    } else {
        echo "Error al eliminar el niño: " . mysqli_error($conexion);
    }
}

// Procesar el formulario para editar un niño
if (isset($_POST['editar'])) {
    $idNinoEditar = $_POST['id_nino'];

    $consulta = "SELECT * FROM ninos WHERE idNino = '$idNinoEditar'";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);

        echo "<h2>Editar datos del niño</h2>";
        echo "<form action='ninos.php' method='post'>";
        echo "<input type='hidden' name='id_nino' value='{$fila['idNino']}'>";
        echo "Nombre: <input type='text' name='nombre' value='{$fila['nombreNino']}'><br>";
        echo "Apellido: <input type='text' name='apellido' value='{$fila['apellidoNino']}'><br>";
        echo "Fecha de nacimiento: <input type='text' name='fecha_nacimiento' value='{$fila['fechaNacimientoNino']}'><br>";
        echo "Bueno (1 para Sí, 0 para No): <input type='text' name='bueno_malo' value='{$fila['buenoMalo']}'><br>";
        echo "<input type='submit' name='guardar_cambios' value='Guardar cambios'>";
        echo "</form>";
    } else {
        echo "No se encontró el niño";
    }
}

// Procesar el formulario para guardar los cambios en un niño editado
if (isset($_POST['guardar_cambios'])) {
    $idNino = $_POST['id_nino'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fechaNacimiento = $_POST['fecha_nacimiento'];
    $buenoMalo = $_POST['bueno_malo'];

    $consultaActualizar = "UPDATE ninos SET nombreNino = '$nombre', apellidoNino = '$apellido', fechaNacimientoNino = '$fechaNacimiento', buenoMalo = '$buenoMalo' WHERE idNino = '$idNino'";
    $resultadoActualizar = mysqli_query($conexion, $consultaActualizar);

    if ($resultadoActualizar) {
        echo "Se han guardado los cambios correctamente";
        // Refrescar la página para ver los cambios
        echo "<meta http-equiv='refresh' content='0'>";
    } else {
        echo "Error al guardar los cambios: " . mysqli_error($conexion);
    }
}


mysqli_close($conexion);

?>
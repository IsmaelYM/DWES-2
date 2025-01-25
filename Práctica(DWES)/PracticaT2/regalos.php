<?php
require_once('conexion.php');

// Función para mostrar la tabla de regalos
function mostrarTablaRegalos($conexion)
{
    $consulta = "SELECT * FROM regalos ORDER BY nombreRegalo";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        echo "<table border='1'>";
        echo "<tr><td>ID</td><td>Nombre del regalo</td><td>Precio</td><td>Acciones</td></tr>";

        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>{$fila['idRegalo']}</td>";
            echo "<td>{$fila['nombreRegalo']}</td>";
            echo "<td>{$fila['precioRegalo']} €</td>";
            echo "<td>";
            echo "<form action='regalos.php' method='post'>";
            echo "<input type='hidden' name='id_regalo' value='{$fila['idRegalo']}'>";
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


mostrarTablaRegalos($conexion);

// Procesar el formulario para agregar un nuevo regalo
if (isset($_POST['agregar_regalo'])) {
    $nombreRegalo = $_POST['nombre_regalo'];
    $precioRegalo = $_POST['precio_regalo'];
    $idReyMago = $_POST['idReyMagoFK'] ?? ''; // Verifica si el valor está presente, de lo contrario, asigna una cadena vacía

    // Verifica si todos los campos requeridos tienen valor antes de realizar la inserción
    if (!empty($nombreRegalo) && !empty($precioRegalo) && $idReyMago !== '') {
        $consultaAgregar = "INSERT INTO regalos (nombreRegalo, precioRegalo, idReyMagoFK) VALUES ('$nombreRegalo', '$precioRegalo', '$idReyMago')";
        $resultadoAgregar = mysqli_query($conexion, $consultaAgregar);

        if ($resultadoAgregar) {
            echo "Se ha agregado el nuevo regalo correctamente";
            // Refrescar la página para ver los cambios
            echo "<meta http-equiv='refresh' content='0'>";
        } else {
            echo "Error al agregar el nuevo regalo: " . mysqli_error($conexion);
        }
    } else {
        echo "Por favor, asegúrate de completar todos los campos.";
    }
}

?>

<h2>Agregar nuevo regalo</h2>
<form action="regalos.php" method="post">
    Nombre del regalo: <input type="text" name="nombre_regalo"><br>
    Precio: <input type="text" name="precio_regalo"><br>
    Rey Mago:
    <select name="idReyMagoFK">
        <option value="1">Melchor</option>
        <option value="2">Gaspar</option>
        <option value="3">Baltasar</option>
    </select><br>
    <input type="submit" name="agregar_regalo" value="Agregar regalo">
</form>

<?php
// Procesar el formulario para borrar un regalo
if (isset($_POST['borrar'])) {
    $idRegaloEliminar = $_POST['id_regalo'];

    $consultaEliminar = "DELETE FROM regalos WHERE idRegalo = '$idRegaloEliminar'";
    $resultadoEliminar = mysqli_query($conexion, $consultaEliminar);

    if ($resultadoEliminar) {
        echo "Se ha eliminado el regalo correctamente";
        // Refrescar la página para ver los cambios
        echo "<meta http-equiv='refresh' content='0'>";
    } else {
        echo "Error al eliminar el regalo: " . mysqli_error($conexion);
    }
}

// Procesar el formulario para editar un regalo
if (isset($_POST['editar'])) {
    $idRegaloEditar = $_POST['id_regalo'];

    $consulta = "SELECT * FROM regalos WHERE idRegalo = '$idRegaloEditar'";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);

        echo "<h2>Editar regalo</h2>";
        echo "<form action='regalos.php' method='post'>";
        echo "<input type='hidden' name='id_regalo' value='{$fila['idRegalo']}'>";
        echo "Nombre del regalo: <input type='text' name='nombre_regalo' value='{$fila['nombreRegalo']}'><br>";
        echo "Precio: <input type='text' name='precio_regalo' value='{$fila['precioRegalo']}'><br>";
        echo "<input type='submit' name='guardar_cambios_regalo' value='Guardar cambios'>";
        echo "</form>";
    } else {
        echo "No se encontró el regalo";
    }
}

// Procesar el formulario para guardar los cambios en un regalo editado
if (isset($_POST['guardar_cambios_regalo'])) {
    $idRegalo = $_POST['id_regalo'];
    $nombreRegalo = $_POST['nombre_regalo'];
    $precioRegalo = $_POST['precio_regalo'];

    $consultaActualizar = "UPDATE regalos SET nombreRegalo = '$nombreRegalo', precioRegalo = '$precioRegalo' WHERE idRegalo = '$idRegalo'";
    $resultadoActualizar = mysqli_query($conexion, $consultaActualizar);

    if ($resultadoActualizar) {
        echo "Se han guardado los cambios en el regalo correctamente";
        // Refrescar la página para ver los cambios
        echo "<meta http-equiv='refresh' content='0'>";
    } else {
        echo "Error al guardar los cambios en el regalo: " . mysqli_error($conexion);
    }
}

mysqli_close($conexion);

?>
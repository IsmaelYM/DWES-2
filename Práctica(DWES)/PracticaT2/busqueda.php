<?php
require_once('conexion.php');

$consultaNinos = "SELECT idNino, nombreNino FROM ninos";
$resultadoNinos = mysqli_query($conexion, $consultaNinos);
?>

<h2>Buscar Regalos por Niño</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
    <label for="nino">Selecciona un niño:</label>
    <select name="nino" id="nino">
        <?php
        while ($filaNino = mysqli_fetch_assoc($resultadoNinos)) {
            echo "<option value='{$filaNino['idNino']}'>{$filaNino['nombreNino']}</option>";
        }
        ?>
    </select>
    <input type="submit" value="Buscar">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['nino'])) {
    $idNinoSeleccionado = $_GET['nino'];
    $consultaRegalos = "SELECT r.nombreRegalo FROM regalos r INNER JOIN elegir e ON r.idRegalo = e.idRegaloFK WHERE e.idNinoFK = '$idNinoSeleccionado'";
    $resultadoRegalos = mysqli_query($conexion, $consultaRegalos);

    if ($resultadoRegalos && mysqli_num_rows($resultadoRegalos) > 0) {
        echo "<h3>Regalos del Niño</h3>";
        echo "<ul>";
        while ($filaRegalo = mysqli_fetch_assoc($resultadoRegalos)) {
            echo "<li>{$filaRegalo['nombreRegalo']}</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No se encontraron regalos para este niño.</p>";
    }

    // Formulario para añadir otro regalo al niño
    echo "<h3>Agregar otro regalo al niño</h3>";
    echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>";
    echo "<input type='hidden' name='idNino' value='$idNinoSeleccionado'>";
    echo "<label for='regalo'>Selecciona un regalo:</label>";
    echo "<select name='regalo' id='regalo'>";

    // Consulta para obtener todos los regalos disponibles
    $consultaTodosRegalos = "SELECT idRegalo, nombreRegalo FROM regalos";
    $resultadoTodosRegalos = mysqli_query($conexion, $consultaTodosRegalos);

    while ($filaRegalo = mysqli_fetch_assoc($resultadoTodosRegalos)) {
        echo "<option value='{$filaRegalo['idRegalo']}'>{$filaRegalo['nombreRegalo']}</option>";
    }
    echo "</select>";
    echo "<input type='submit' value='Agregar'>";
    echo "</form>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idNino'])) {
    $idNino = $_POST['idNino'];
    $idRegalo = $_POST['regalo'];

    // Insertar el regalo seleccionado al niño
    $consultaInsertarRegalo = "INSERT INTO elegir (idNinoFK, idRegaloFK) VALUES ('$idNino', '$idRegalo')";
    $resultadoInsertarRegalo = mysqli_query($conexion, $consultaInsertarRegalo);

    if ($resultadoInsertarRegalo) {
        echo "Se ha agregado el nuevo regalo al niño correctamente";
    } else {
        echo "Error al agregar el nuevo regalo al niño: " . mysqli_error($conexion);
    }
}

mysqli_close($conexion);

?>
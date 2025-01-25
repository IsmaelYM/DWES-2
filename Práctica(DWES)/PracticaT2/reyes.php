<?php
require_once('conexion.php');

$consultaReyesMagos = "SELECT idReyMago, nombreReyMago FROM reyesmagos";
$resultadoReyesMagos = mysqli_query($conexion, $consultaReyesMagos);

while ($filaRey = mysqli_fetch_assoc($resultadoReyesMagos)) {
    echo "<h2>{$filaRey['nombreReyMago']}</h2>";

    // Obtener los regalos que tiene que entregar el Rey Mago
    $idReyMago = $filaRey['idReyMago'];
    $consultaRegalosRey = "SELECT r.nombreRegalo, n.nombreNino, r.precioRegalo
            FROM regalos r
            INNER JOIN elegir e ON r.idRegalo = e.idRegaloFK
            INNER JOIN ninos n ON e.idNinoFK = n.idNino
            WHERE r.idReyMagoFK = '$idReyMago'";

    $resultadoRegalosRey = mysqli_query($conexion, $consultaRegalosRey);

    echo "<table border='1'>";
    echo "<tr><th>Regalo</th><th>Niño</th></tr>";
    $totalGastado = 0;

    while ($filaRegaloRey = mysqli_fetch_assoc($resultadoRegalosRey)) {
        echo "<tr>";
        echo "<td>{$filaRegaloRey['nombreRegalo']}</td>";
        echo "<td>{$filaRegaloRey['nombreNino']}</td>";
        echo "</tr>";

        $totalGastado += $filaRegaloRey['precioRegalo'];
    }

    echo "</table>";
    echo "<p>Total gastado: $totalGastado €</p>";
}

mysqli_close($conexion);
?>
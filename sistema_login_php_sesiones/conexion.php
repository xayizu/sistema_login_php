<?php
// Activar reporte de errores (opcional para desarrollo)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "localhost";
$usuario = "root";
$contrasena = "Luchomiguel40.";
$basedatos = "sistema_login";

try {
    $conexion = new mysqli($host, $usuario, $contrasena, $basedatos);
    $conexion->set_charset("utf8"); // Establece codificación UTF-8
} catch (mysqli_sql_exception $e) {
    die("❌ Error de conexión a la base de datos: " . $e->getMessage());
}
?>

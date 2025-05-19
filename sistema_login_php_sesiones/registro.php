<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'conexion.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = trim($_POST['usuario']);
    $clave_raw = $_POST['clave'];

    if (!empty($usuario) && !empty($clave_raw)) {
        $clave = hash('sha256', $clave_raw);

        // Verificar si el usuario ya existe
        $verificar = $conexion->prepare("SELECT id FROM usuarios WHERE usuario = ?");
        $verificar->bind_param("s", $usuario);
        $verificar->execute();
        $resultado = $verificar->get_result();

        if ($resultado->num_rows > 0) {
            $mensaje = "⚠️ El nombre de usuario ya está en uso.";
        } else {
            $sql = "INSERT INTO usuarios (usuario, clave) VALUES (?, ?)";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("ss", $usuario, $clave);
            if ($stmt->execute()) {
                $mensaje = "✅ Usuario registrado correctamente.";
            } else {
                $mensaje = "❌ Error al registrar el usuario.";
            }
        }
    } else {
        $mensaje = "⚠️ Debes llenar todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <style>
        body {
            font-family: Arial;
            text-align: center;
            background-color: #f0f0f0;
            padding-top: 60px;
        }
        form {
            background-color: #fff;
            display: inline-block;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        input, button {
            margin: 10px 0;
            padding: 10px;
            width: 90%;
            max-width: 250px;
        }
        button {
            background-color: #2ecc71;
            color: white;
            border: none;
            border-radius: 4px;
        }
        .mensaje {
            margin-top: 15px;
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <form method="POST">
        <h2>Registro de Usuario</h2>
        <input type="text" name="usuario" placeholder="Nombre de usuario" required><br>
        <input type="password" name="clave" placeholder="Contraseña" required><br>
        <button type="submit">Registrar</button>
        <?php if (!empty($mensaje)) echo "<p class='mensaje'>" . htmlspecialchars($mensaje) . "</p>"; ?>
    </form>
</body>
</html>

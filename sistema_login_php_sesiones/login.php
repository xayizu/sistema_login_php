<?php
session_start();
include 'conexion.php';

$error = "";

// Procesar login solo si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST["usuario"]);
    $clave = hash("sha256", $_POST["clave"]);

    $sql = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $usuario, $clave);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $_SESSION["usuario"] = $usuario;
        header("Location: bienvenido.php");
        exit();
    } else {
        $error = "❌ Credenciales incorrectas. Por favor, verifica tus datos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            background-color: #f4f6f8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-align: center;
            padding-top: 80px;
        }
        form {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            display: inline-block;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
        }
        input[type="text"], input[type="password"] {
            padding: 10px;
            width: 90%;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        input[type="submit"] {
            padding: 10px 25px;
            background-color: #3498db;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #2980b9;
        }
        .mensaje {
            margin-top: 10px;
            font-weight: bold;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <form method="POST" action="">
        <h2>Iniciar Sesión</h2>

        <!-- Mensaje al cerrar sesión -->
        <?php if (isset($_GET['cerrado'])): ?>
            <p class="mensaje success">Sesión cerrada correctamente.</p>
        <?php endif; ?>

        <!-- Mensaje de error de autenticación -->
        <?php if (!empty($error)): ?>
            <p class="mensaje error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="clave" placeholder="Contraseña" required>
        <input type="submit" value="Ingresar">
    </form>
</body>
</html>

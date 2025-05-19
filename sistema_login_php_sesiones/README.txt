Sistema de Autenticación en PHP + MySQL

1. Crear base de datos en MySQL:
CREATE DATABASE sistema_login;

USE sistema_login;

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario VARCHAR(50) NOT NULL,
  clave VARCHAR(255) NOT NULL
);

2. Configura la conexión en 'conexion.php'.

3. Usa 'registro.php' para crear usuarios.

4. Usa 'login.php' para autenticación y sesiones.

5. 'bienvenido.php' está protegido y solo accesible con sesión iniciada.

6. 'logout.php' cierra la sesión.
<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nombre']) && isset($_POST['contrasena'])) {
        $nombre = $_POST['nombre'];
        $contrasena = $_POST['contrasena'];

        // Conectar a la base de datos
        $conexion = mysqli_connect("localhost", "root", "", "chat");

        // Verificar conexión
        if (mysqli_connect_errno()) {
            echo "Error al conectar a la base de datos: " . mysqli_connect_error();
            exit();
        }

        // Escapar variables para prevenir inyección SQL
        $nombre = mysqli_real_escape_string($conexion, $nombre);

        // Consultar la base de datos para obtener el usuario
        $sql = "SELECT * FROM usuarios WHERE nombre = '$nombre'";
        $resultado = mysqli_query($conexion, $sql);

        if ($resultado) {
            // Verificar si se encontró algún usuario
            if (mysqli_num_rows($resultado) > 0) {
                $fila = mysqli_fetch_assoc($resultado);
                
                // Verificar la contraseña utilizando password_verify()
                if (password_verify($contrasena, $fila['contrasena'])) {
                    // Contraseña correcta, iniciar sesión y redirigir
                    $_SESSION['usuario'] = $nombre;
                    if ($nombre == 'admin') {
                        header("Location: registro.html");
                    } else {
                        header("Location: menu1.html");
                    }
                    exit();
                } else {
                    // Contraseña incorrecta
                    header("Location: index.html?error=credenciales");
                    exit();
                }
            } else {
                // Usuario no encontrado
                header("Location: index.html?error=credenciales");
                exit();
            }
        } else {
            // Error en la consulta SQL
            echo "Error al ejecutar la consulta: " . mysqli_error($conexion);
            exit();
        }

        // Cerrar conexión
        mysqli_close($conexion);
    } else {
        // Campos no recibidos correctamente
        header("Location: index.html?error=campos");
        exit();
    }
} else {
    // Redireccionar si no es POST (no debería suceder si el formulario está configurado correctamente)
    header("Location: index.html");
    exit();
}
?>

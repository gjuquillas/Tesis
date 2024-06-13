<?php
// Verificar si se enviaron los datos del formulario de registro
if (isset($_POST['nombre']) && isset($_POST['contrasena'])) {
    $nombre = $_POST['nombre'];
    $contrasena = $_POST['contrasena'];

    // Validar nombre de usuario
    if (strlen($nombre) < 3) {
        echo "El nombre de usuario debe tener al menos 3 caracteres.";
        exit();
    }

    // Validar contraseña
    if (strlen($contrasena) < 8) {
        echo "La contraseña debe tener al menos 8 caracteres.";
        exit();
    }
    if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+}{"\':;?\/.><,])(?!.*\s).{8,}$/', $contrasena)) {
        echo "La contraseña debe contener al menos una letra mayúscula, una letra minúscula, un número y un carácter especial.";
        exit();
    }

    // Conectarse a la base de datos y realizar la inserción del usuario
    $conexion = mysqli_connect("localhost", "root", "", "chat");

    // Verificar si la conexión fue exitosa
    if (mysqli_connect_errno()) {
        echo "Error al conectar a la base de datos: " . mysqli_connect_error();
        exit();
    }

    // Encriptar la contraseña utilizando password_hash()
    $contrasena_encriptada = password_hash($contrasena, PASSWORD_DEFAULT);

    // Insertar el usuario en la base de datos
    $sql = "INSERT INTO usuarios (nombre, contrasena) VALUES ('$nombre', '$contrasena_encriptada')";
    if (mysqli_query($conexion, $sql)) {
        // Registro exitoso, mostrar mensaje y redireccionar a la página de inicio de sesión
        echo "Registro exitoso. Ahora puedes iniciar sesión.";
        header("refresh:2; url=index.html"); // Redireccionar después de 2 segundos
        exit();
    } else {
        echo "Error al registrar el usuario: " . mysqli_error($conexion);
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);
}
?>

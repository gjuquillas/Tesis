<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Definir las variables de conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "contactos_db"; // Base de datos separada para los contactos

    // Establecer conexión con la base de datos
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Eliminar el contacto
    $sql = "DELETE FROM contactos WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Contacto eliminado con éxito.";
    } else {
        echo "Error al eliminar el contacto: " . $conn->error;
    }

    // Cerrar la conexión con la base de datos
    $conn->close();
}
?>

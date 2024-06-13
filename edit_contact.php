<?php
if (isset($_GET['id']) && isset($_GET['telefono'])) {
    $id = $_GET['id'];
    $telefono = $_GET['telefono'];

    // Validar que el número de teléfono tenga exactamente 12 dígitos
    if (preg_match('/^\d{12}$/', $telefono)) {
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

        // Actualizar el contacto
        $sql = "UPDATE contactos SET telefono = '$telefono' WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            echo "Contacto actualizado con éxito.";
        } else {
            echo "Error al actualizar el contacto: " . $conn->error;
        }

        // Cerrar la conexión con la base de datos
        $conn->close();
    } else {
        echo "El número de teléfono debe tener exactamente 12 dígitos.";
    }
}
?>

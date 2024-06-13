<?php
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

// Obtener todos los números de teléfono de la base de datos
$sql = "SELECT telefono FROM contactos";
$result = $conn->query($sql);

// Crear un archivo CSV y añadir los números de teléfono
if ($result->num_rows > 0) {
    $filename = "contactos.csv";
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    
    $output = fopen('php://output', 'w');
    
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, array('+' . $row['telefono']), ',', '"', "\0");
    }
    
    fclose($output);
    exit();
} else {
    echo "No se encontraron contactos.";
}

// Cerrar la conexión con la base de datos
$conn->close();
?>

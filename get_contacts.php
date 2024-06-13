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
$sql = "SELECT * FROM contactos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table class="table table-striped">';
    echo '<thead><tr><th>ID</th><th>Número de Teléfono</th><th>Acciones</th></tr></thead>';
    echo '<tbody>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr id="contact-' . $row['id'] . '">';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td id="telefono-' . $row['id'] . '">' . $row['telefono'] . '</td>';
        echo '<td><button class="btn btn-warning edit-button" data-id="' . $row['id'] . '">Editar</button> ';
        echo '<button class="btn btn-danger delete-button" data-id="' . $row['id'] . '">Eliminar</button></td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
} else {
    echo 'No se encontraron contactos.';
}

// Cerrar la conexión con la base de datos
$conn->close();
?>

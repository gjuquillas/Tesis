<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Conversaciones </title>
    <!-- Incluye los archivos de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            width: 80%;
            margin: 20px auto;
        }

        .conversation {
            border: 1px solid #ccc;
            margin-bottom: 20px;
        }

        .conversation-header {
            background-color: #f8f8f8;
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }

        .message {
            padding: 5px;
            margin-bottom: 10px;
        }

        .user-message {
            background-color: #eaf2f8;
        }

        .bot-message {
            background-color: #f8f8f8;
        }
    </style>
</head>

<body>
    <!-- Barra de navegación Bootstrap -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="menu1.html">Menú Principal</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="conversacion.php">Conversaciones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="enviar.html">Enviar Mensajes de WhatsApp</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="gestion_contactos.php">Gestión de Contactos</a>
                </li>
            </ul>
            <!-- Mueve el botón "Cerrar Sesión" a la derecha -->
            <div class="ml-auto d-flex align-items-center">
                <a class="nav-link" href="index.html">Cerrar Sesión</a>
                <a class="navbar-brand" href="#">
                    <img src="logo.jpg" alt="Logo del sistema" style="width: 50px; height: auto;">
                </a>
            </div>
        </div>
    </nav>
    <div class="container">
        <h1>Conversaciones</h1>
        
        <div class="row">
            <div class="col-md-8">
                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <label for="telefono">Número de teléfono:</label>
                    <input type="text" name="telefono" id="telefono" required>
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </form>
            </div>
            <div class="col-md-4">
                <h5>Números de Teléfono:</h5>
                <select id="phoneSelect" class="form-control">
                    <option value="">Seleccione un número</option>
                    <?php
                    // Definir las variables de conexión a la base de datos
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $database = "chat";

                    // Establecer conexión con la base de datos
                    $conn = new mysqli($servername, $username, $password, $database);
                    
                    // Verificar la conexión
                    if ($conn->connect_error) {
                        die("Error de conexión: " . $conn->connect_error);
                    }
                    
                    // Obtener la lista de números de teléfono únicos
                    $sql = "SELECT DISTINCT telefono_wa FROM registro";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $telefonoWa = $row['telefono_wa'];
                            echo '<option value="' . $telefonoWa . '">' . $telefonoWa . '</option>';
                        }
                    }
                    
                    // Cerrar la conexión con la base de datos
                    $conn->close();
                    ?>
                </select>
            </div>
        </div>

        <!-- Mostrar las conversaciones debajo del formulario -->
        <div id="conversaciones">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Obtener el número de teléfono del formulario
                $telefono = $_POST["telefono"];
            
                // Establecer conexión con la base de datos
                $conn = new mysqli($servername, $username, $password, $database);
                
                // Verificar la conexión
                if ($conn->connect_error) {
                    die("Error de conexión: " . $conn->connect_error);
                }
                
                // Filtrar por el valor de la columna telefono_wa
                $sql = "SELECT * FROM registro WHERE telefono_wa = '$telefono' ORDER BY fecha_hora ASC";
                $result = $conn->query($sql);
                
                // Mostrar las conversaciones divididas por número de teléfono
                $conversations = array();
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $mensajeRecibido = $row['mensaje_recibido'];
                        $mensajeEnviado = $row['mensaje_enviado'];
                        $telefonoWa = $row['telefono_wa'];
                        
                        // Agrupar los mensajes por número de teléfono
                        if (!isset($conversations[$telefonoWa])) {
                            $conversations[$telefonoWa] = array();
                        }
                        
                        $conversations[$telefonoWa][] = array(
                            'mensajeRecibido' => $mensajeRecibido,
                            'mensajeEnviado' => $mensajeEnviado
                        );
                    }
                    
                    // Mostrar las conversaciones en secciones separadas
                    foreach ($conversations as $telefono => $messages) {
                        echo '<div class="conversation">';
                        echo '<div class="conversation-header">Teléfono: ' . $telefono . '</div>';
                        
                        foreach ($messages as $message) {
                            $mensajeRecibido = $message['mensajeRecibido'];
                            $mensajeEnviado = $message['mensajeEnviado'];
                            
                            echo '<div class="message user-message"><strong>Usuario:</strong> ' . $mensajeRecibido . '</div>';
                            echo '<div class="message bot-message"><strong>Chatbot:</strong> ' . $mensajeEnviado . '</div>';
                        }
                        
                        echo '</div>';
                    }
                } else {
                    echo 'No se encontraron conversaciones para el teléfono ' . $telefono;
                }
                
                // Cerrar la conexión con la base de datos
                $conn->close();
            }
            ?>
        </div>
    </div>

    <script>
        // Script para manejar el cambio en el combobox
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('phoneSelect').addEventListener('change', function () {
                var phoneNumber = this.value;
                document.getElementById('telefono').value = phoneNumber;
            });
        });
    </script>
</body>

</html>

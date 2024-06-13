<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Enviar mensajes de WhatsApp</title>
    <!-- Incluye los archivos de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Agrega el fragmento de código de Botsprout aquí -->
    <!-- Reemplaza 'TU_FRAGMENTO_DE_CODIGO_DE_BOTSPROUT' con tu código real -->
    <script>
        (function () {
            var e = document.createElement("script");
            e.type = "text/javascript", e.async = !0, e.src = "https://cdn.botsprout.com/2e83d7751f28ab50f1b0d1725d5059ed.js";
            var t = document.getElementsByTagName("script")[0];
            t.parentNode.insertBefore(e, t);
        })();
    </script>
</head>

<body>
    <!-- Barra de navegación Bootstrap -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="menu.html">Menu Principal</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="conversacion.php">Conversaciones del Chatbot</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="enviar.html">Enviar Mensajes de WhatsApp</a>
                </li>
            </ul>
        </div>
        <!-- Agrega la opción "Cerrar Sesión" en la esquina derecha -->
        <div class="ml-auto">
            <a class="nav-link" href="index.html">Cerrar Sesion</a>
        </div>
    </nav>

    <div class="container">
        <h1 class="mt-5">Enviar mensajes de WhatsApp </h1>
        <div id="containerEnviar">
            <!-- Contenedores y botones de plantillas cargados desde la base de datos -->
            <?php
                // Realiza la conexión a la base de datos (debes ajustar estos valores)
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "chat";

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Verifica la conexión
                if ($conn->connect_error) {
                    die("Error de conexión: " . $conn->connect_error);
                }

                // Realiza una consulta SQL para obtener las plantillas
                $sql = "SELECT id, nombre, archivo_php FROM plantillas";
                $result = $conn->query($sql);

                // Muestra botones y formularios para cada plantilla
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $plantillaId = $row["id"];
                        $nombrePlantilla = $row["nombre"];
                        $archivoPlantilla = $row["archivo_php"];

                        echo '<button class="btn btn-primary" onclick="mostrarPlantilla(\'' . $archivoPlantilla . '\')">' . $nombrePlantilla . '</button>';
                    }
                } else {
                    echo "No se encontraron plantillas.";
                }

                // Cierra la conexión a la base de datos
                $conn->close();
            ?>

            <!-- Contenedor de plantilla -->
            <div id="contenedorPlantilla" style="display: none;">
                <form method="post" enctype="multipart/form-data">
                    <label for="csv_file">Seleccionar archivo CSV:</label>
                    <input type="file" id="csv_file" name="csv_file" accept=".csv">
                    <br>
                    <button type="submit" id="btnEnviar">Enviar mensajes de WhatsApp</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function mostrarPlantilla(archivoPlantilla) {
            // Oculta el contenedor anterior
            document.getElementById('contenedorPlantilla').style.display = 'none';

            // Muestra el nuevo contenedor
            document.getElementById('contenedorPlantilla').style.display = 'block';

            // Cambia el atributo "action" del formulario para que coincida con el nombre de archivo de la plantilla seleccionada
            document.querySelector('form').action = archivoPlantilla;
        }
    </script>
</body>

</html>

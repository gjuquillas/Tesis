<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Contactos</title>
    <!-- Incluye los archivos de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            width: 80%;
            margin: 20px auto;
        }

        .message {
            padding: 5px;
            margin-bottom: 10px;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .hidden {
            display: none;
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
        <h1>Gestión de Contactos</h1>

        <div id="messages"></div>

        <form id="contactForm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <div class="form-group">
                <label for="telefono">Número de teléfono (12 dígitos):</label>
                <input type="text" class="form-control" name="telefono" id="telefono" maxlength="12" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Número</button>
        </form>

        <form method="POST" action="descargar_contactos.php" class="mt-4">
            <button type="submit" class="btn btn-success">Descargar Números en CSV</button>
        </form>

        <button id="showContactsButton" class="btn btn-info mt-4">Ver Números de Teléfono</button>

        <div id="contactList" class="mt-4 hidden">
            <!-- Aquí se mostrarán los números de teléfono -->
        </div>
    </div>

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

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["telefono"])) {
        $telefono = $_POST["telefono"];

        // Validar que el número de teléfono tenga exactamente 12 dígitos
        if (preg_match('/^\d{12}$/', $telefono)) {
            $sql = "INSERT INTO contactos (telefono) VALUES ('$telefono')";
            if ($conn->query($sql) === TRUE) {
                echo '<div class="message success-message">Número de teléfono agregado con éxito.</div>';
            } else {
                echo '<div class="message error-message">Error al agregar el número de teléfono: ' . $conn->error . '</div>';
            }
        } else {
            echo '<div class="message error-message">El número de teléfono debe tener exactamente 12 dígitos.</div>';
        }
    }

    // Cerrar la conexión con la base de datos
    $conn->close();
    ?>

    <script>
        document.getElementById('showContactsButton').addEventListener('click', function () {
            const contactList = document.getElementById('contactList');
            contactList.classList.toggle('hidden');
            if (!contactList.classList.contains('hidden')) {
                fetch('get_contacts.php')
                    .then(response => response.text())
                    .then(data => {
                        contactList.innerHTML = data;
                        attachEventListeners();
                    });
            }
        });

        function attachEventListeners() {
            document.querySelectorAll('.delete-button').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.dataset.id;
                    fetch(`delete_contact.php?id=${id}`)
                        .then(response => response.text())
                        .then(data => {
                            document.getElementById(`contact-${id}`).remove();
                        });
                });
            });

            document.querySelectorAll('.edit-button').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.dataset.id;
                    const telefono = prompt('Ingrese el nuevo número de teléfono (12 dígitos):');
                    if (telefono && telefono.length === 12 && /^\d+$/.test(telefono)) {
                        fetch(`edit_contact.php?id=${id}&telefono=${telefono}`)
                            .then(response => response.text())
                            .then(data => {
                                document.getElementById(`telefono-${id}`).innerText = telefono;
                            });
                    } else {
                        alert('El número de teléfono debe tener exactamente 12 dígitos.');
                    }
                });
            });
        }
    </script>
</body>

</html>

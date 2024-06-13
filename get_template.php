<?php
// Conecta a la base de datos

// Recibe el identificador de la plantilla desde la solicitud GET
$templateId = $_GET['templateId'];

// Realiza una consulta SQL para obtener la información de la plantilla según $templateId

// Devuelve la información de la plantilla en formato JSON
header('Content-Type: application/json');
echo json_encode($templateInfo);
?>

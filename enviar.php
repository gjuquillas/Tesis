<?php
// URL de la API de WhatsApp Business
$url = 'https://graph.facebook.com/v16.0/118706941159372/messages';

// Token de acceso de la API de WhatsApp Business
$token = 'EAAKuxQbNtHYBO9YdUaIIDejcWLv0iUfkYZC92Xsv43WRroDO7iyPDJexhHC51zZAB0gQSCs20C24MAjwjGQEHpte6tT6Gkayx8Pcyzsm0HjhV3iUeCUnl2w3kRl64WyRhgvLXJcIW2X0Psz7hjuhJWYdptuWVaHHs9vptNqwNZA1X80FsN5ZAKuQeLsf8ETDVOfL80efG0bjoBBbaCIZD';

// Nombre del archivo CSV
$file = $_FILES['csv_file']['tmp_name'];

// Verificar que el archivo fue subido
if (!$file) {
    header('Location: enviar.html?error=Error al subir el archivo');
    exit();
}

// Abrir el archivo CSV
if (($handle = fopen($file, 'r')) !== false) {
    // Recorrer las filas del archivo CSV
    while (($data = fgetcsv($handle)) !== false) {
        // Obtener el número de teléfono de la fila actual
        $phone = $data[0];

        // Crear el mensaje a enviar
        $message = ''
        . '{'
        . '"messaging_product": "whatsapp", '
        . '"to": "'.$phone.'", '
        . '"type": "template", '
        . '"template": '
        . '{'
        . '     "name": "hello_world",'
        . '     "language":{ "code": "en_US" } '
        . '} '
        . '}';

        // Declaramos las cabeceras
        $header = array("Authorization: Bearer " . $token, "Content-Type: application/json",);
        
        // Iniciamos el cURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $message);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        // Obtenemos la respuesta del envío de información
        $response = json_decode(curl_exec($curl), true);
        
        // Obtenemos el código de la respuesta
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        // Cerramos el cURL
        curl_close($curl);
        
        // Verificamos si hubo un error en la respuesta
        if ($status_code != 200) {
            header('Location: enviar.html?error=' . urlencode($response['error']['message']));
            exit();
        }
    }

    // Cerrar el archivo CSV
    fclose($handle);
} else {
    header('Location: enviar.html?error=Error al abrir el archivo CSV');
    exit();
}

header('Location: enviar.html?success=Mensajes enviados exitosamente');
exit();
?>

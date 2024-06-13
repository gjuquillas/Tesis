<?php

// URL de la API de WhatsApp Business
$url = 'https://graph.facebook.com/v16.0/118706941159372/messages';

// Token de acceso de la API de WhatsApp Business
$token = 'EAAKuxQbNtHYBO79XHgjGy6OJ6lpTfGXvhEGqyK37kf3EuOqwd00MfZAFVxYjfFYZCe32OKRls3256Uu2eYrrZCbW0qsa25OqcEPgR89JfQaccbfOneoHX7B5t63k5V0DXnzH9PIzS2oiBkP9nyVH1ZAMZA15ZCw9NgXizRH3CgmUXFS2479BQtorIgZA0VVHdROecidZCtLXvND8jSCNjTsZD';

// Nombre del archivo CSV
$file = $_FILES['csv_file']['tmp_name'];

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
        //DECLARAMOS LAS CABECERAS
        $header = array("Authorization: Bearer " . $token, "Content-Type: application/json",);
        //INICIAMOS EL CURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $message);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //OBTENEMOS LA RESPUESTA DEL ENVIO DE INFORMACION
        $response = json_decode(curl_exec($curl), true);
        //IMPRIMIMOS LA RESPUESTA 
        print_r($response);
        //OBTENEMOS EL CODIGO DE LA RESPUESTA
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        //CERRAMOS EL CURL
        curl_close($curl);

    }

    // Cerrar el archivo CSV
    fclose($handle);
}

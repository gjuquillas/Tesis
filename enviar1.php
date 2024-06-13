<?php

// URL de la API de WhatsApp Business
$url = 'https://graph.facebook.com/v17.0/116789374780660/messages';

// Token de acceso de la API de WhatsApp Business
$token = 'EAAKuxQbNtHYBO79XHgjGy6OJ6lpTfGXvhEGqyK37kf3EuOqwd00MfZAFVxYjfFYZCe32OKRls3256Uu2eYrrZCbW0qsa25OqcEPgR89JfQaccbfOneoHX7B5t63k5V0DXnzH9PIzS2oiBkP9nyVH1ZAMZA15ZCw9NgXizRH3CgmUXFS2479BQtorIgZA0VVHdROecidZCtLXvND8jSCNjTsZD';

// Nombre del archivo CSV
$file = $_FILES['csv_file']['tmp_name'];

// Abrir el archivo CSV
if (($handle = fopen($file, 'r')) !== false) {
    // Recorrer las filas del archivo CSV
    while (($data = fgetcsv($handle)) !== false) {
        // Obtener el n��mero de tel��fono de la fila actual
        $phone = $data[0];
        $texto = "¡Hola! 👋\n\nTenemos una oferta exclusiva para usted 🎁:\n\n*   60 Megas de velocidad por \$22.40 mensuales,\n*   Instalación gratis a través de fibra óptica con la mayor velocidad,\n*   Incluye totalmente Claro video igual que Netflix 🎞 totalmente gratis.\n\n¡Es una excelente oportunidad para obtener un servicio de alta velocidad a un precio increíble!\n\nGracias por considerar nuestros servicios. ¡Esperamos poder servirle pronto!";

        // Crear el mensaje a enviar
        $message = '
{
    "messaging_product": "whatsapp",
    "to": "' . $phone . '",
    "type": "template",
    "template": {
        "name": "aditeccl",
        "language": {
            "code": "es"
        },
        "components": [
            {
              "type": "header",
              "parameters": [
                {
                  "type": "video",
                  "video": {
                    "link": "http(s)://URL"
                  }
                }
              ]
            },
            {
              "type": "body",
              "parameters": [
                {
                  "type": "text",
                  "text": "' . $phone . '",
                }
              ]
            }
        ]
    }
}';

        //DECLARAMOS LAS CABECERAS
        $header = array("Authorization: Bearer " . $token, "Content-Type: application/json");

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
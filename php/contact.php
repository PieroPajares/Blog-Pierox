<?php

// configure
$from = 'Mensajes'; 
$sendTo = 'ppajareso@upao.edu.pe';
$subject = 'Nuevo mensaje del blog';
$fields = array('nombre' => 'Nombre', 'email' => 'Email', 'telefono' => 'Telefono', 'mensaje' => 'Mensaje'); // array variable name => Text to appear in email
$okMessage = '¡Su mensaje ha sido enviado correctamente a Piero!';
$errorMessage = 'Error, su mensaje no ha sido enviado';

// let's do the sending

try
{
    $emailText = "Datos :\n=============================\n";

    foreach ($_POST as $key => $value) {

        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    mail($sendTo, $subject, $emailText, "From: " . $from);

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);
    
    header('Content-Type: application/json');
    
    echo $encoded;
}
else {
    echo $responseArray['message'];
}

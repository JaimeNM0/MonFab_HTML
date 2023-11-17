<?php

function enviarResultado($data, $success, $message)
{
    $resultado = [
        "success" => $success,
        "message" => $message,
        "data" => $data
    ];

    echo json_encode($resultado, JSON_PRETTY_PRINT);
}

function validateSentGet($data, $success)
{
    if ($_SERVER["REQUEST_METHOD"] !== "GET") {
        enviarResultado($data, $success, "Envíalo por GET, por favor.");
        return false;
    }
    return true;
}

function validateSentId($id, $data, $success)
{
    if (empty($id)) {
        enviarResultado($data, $success, "Tienes que enviar un id, por favor.");
        return false;
    }
    return true;
}

function validateRecordExists($data, $success, $message)
{
    if ($data === []) {
        enviarResultado($data, $success, $message);
        return false;
    }
    return true;
}

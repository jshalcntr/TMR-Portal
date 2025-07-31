<?php

function respondWithError($message, $error)
{
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "error",
        "message" => $message,
        "data" => $error
    ]);
    exit();
}

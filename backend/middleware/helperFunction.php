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

// Helper function to get and sanitize POST values
function post_clean($key, $default = '') {
    return trim(strip_tags($_POST[$key] ?? $default));
}
function post_int($key, $default = 0) {
    return (int) ($_POST[$key] ?? $default);
}
function post_yesno($key) {
    $val = strtolower(trim($_POST[$key] ?? ''));
    return $val === 'YES' ? 1 : ($val === 'NO' ? 0 : null);
}
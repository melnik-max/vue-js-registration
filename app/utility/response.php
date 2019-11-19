<?php

function json($data, $status = 200)
{
    header('Content-type: application/json;');
    echo json_encode($data);
    http_response_code($status);

    return true;
}

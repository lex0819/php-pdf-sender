<?php

function check_session_pdf(): void
{
    if (!isset($_SESSION['file_pdf'])) {
        header('Location: ', BASE_URL);
        exit;
    }
}

function get_file_name(): string
{
    $file_pdf = explode('/', $_SESSION['file_pdf']);
    $file_pdf = $file_pdf[count($file_pdf) - 1];

    return $file_pdf;
}

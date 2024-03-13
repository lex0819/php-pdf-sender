<?php

const CHAT_ID = 615239834;
const BOT = '6868154468:AAFy8DbOjThJgSNr-m8giDGhfjjsVYvmbg0';

const FILENAME = __DIR__ . "/temp-pdf/pdf01.pdf";

// Create CURL object
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot" . BOT . "/sendDocument");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
// Timeout in seconds
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

// Create CURLFile
$finfo = finfo_file(finfo_open(FILEINFO_MIME_TYPE), FILENAME);
$cFile = new CURLFile(FILENAME, $finfo);

// Add CURLFile to CURL request
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    "chat_id" => CHAT_ID,
    "document" => $cFile,
]);

// Call
$result = curl_exec($ch);

// Show result and close curl
curl_close($ch);
var_dump(json_decode($result, true));

<?php
$cURL = curl_init();

curl_setopt($cURL, CURLOPT_URL, "http://localhost/Projects/Test/test-response.php");
curl_setopt($cURL, CURLOPT_POST, true);
curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);

curl_setopt($cURL, CURLOPT_POSTFIELDS, [
    "ID" => "007",
    "Name" => "James Bond",
    "Picture" => curl_file_create(__DIR__ . "/test.png"),
    "Thumbnail" => curl_file_create(__DIR__ . "/thumbnail.png"),
]);

$Response = curl_exec($cURL);
$HTTPStatus = curl_getinfo($cURL, CURLINFO_HTTP_CODE);

curl_close($cURL);

print "HTTP status: {$HTTPStatus}\n\n{$Response}";

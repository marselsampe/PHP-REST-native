<?php
$idBarang = '16'; // item id that will delete
// URL API
$url = 'http://localhost:8080/NativeREST/api/barang/'.$idBarang;

$client = curl_init();

$options = array(
    CURLOPT_URL				=> $url, // Set URL of API
    CURLOPT_CUSTOMREQUEST 	=> "DELETE", // Set request method
    CURLOPT_RETURNTRANSFER	=> true, // true, to return the transfer as a string
);

curl_setopt_array( $client, $options );

// Execute and Get the response
$response = curl_exec($client);
// Get HTTP Code response
$httpCode = curl_getinfo($client, CURLINFO_HTTP_CODE);
// Close cURL session
curl_close($client);

// Show response
echo '<h3>HTTP Code</h3>';
echo $httpCode;
echo '<h3>Response</h3>';
echo $response;

?>
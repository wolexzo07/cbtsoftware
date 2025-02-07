<?php
// API endpoint URL
$url = 'https://apirone.com/api/v2/auth/login';

// JSON data to send
$data = array(
    'login' => 'btc-f43a47823c6f0894c83e3e364fa12654',
    'password' => 'oAqmClPQ69a2upN83N5XoPCBeH3XID41'
);

// Convert data to JSON format
$jsonData = json_encode($data);

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json;charset=utf-8'
));

// Execute the cURL request
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo 'cURL error: ' . curl_error($ch);
}

// Close cURL session
curl_close($ch);

// Display the response
echo $response;
?>



curl 'https://apirone.com/api/v2/auth/refresh-token' -X POST -H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsIjoiNlJUOkRSVDp5UlQ6VFJUOlJSVDo1UlQ6elJUOkkiLCJleHAiOjE2MTM2NjI3MTN9.Dj6_4betKGS6MH2TkCTyikNWfcd5I_4e45FBvtfBi_8'


<?php
// API endpoint URL
$url = 'https://apirone.com/api/v2/auth/refresh-token';

// Authorization token
$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsIjoiNlJUOkRSVDp5UlQ6VFJUOlJSVDo1UlQ6elJUOkkiLCJleHAiOjE2MTM2NjI3MTN9.Dj6_4betKGS6MH2TkCTyikNWfcd5I_4e45FBvtfBi_8';

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $token
));

// Execute the cURL request
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo 'cURL error: ' . curl_error($ch);
}

// Close cURL session
curl_close($ch);

// Display the response
echo $response;
?>


curl 'https://apirone.com/api/v2/accounts/apr-e7be0e8eabd391b499fe64647576fad5/callback?currency=tbtc&transfer-key=bP1vwTAMNetr7uS5qTYzBTWeY6nPMuZK' 

<?php
// API endpoint URL
$url = 'https://apirone.com/api/v2/accounts/apr-e7be0e8eabd391b499fe64647576fad5/callback';

// Query parameters
$currency = 'tbtc';
$transferKey = 'bP1vwTAMNetr7uS5qTYzBTWeY6nPMuZK';

// Build the query string
$queryString = http_build_query(array(
    'currency' => $currency,
    'transfer-key' => $transferKey
));

// Append the query string to the URL
$url .= '?' . $queryString;

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo 'cURL error: ' . curl_error($ch);
}

// Close cURL session
curl_close($ch);

// Display the response
echo $response;
?>

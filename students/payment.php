<?php
include("../database/connectdb.php");

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Access-Control-Allow-Methods');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

$user_data = json_decode(file_get_contents('php://input'), true);

if ($user_data) {
    $user_id = $user_data['Id'] ?? '';
    $user_email=$user_data['email'] ?? '';
    $user_total = trim($user_data['total'] ?? '');
    $curl = curl_init();


$data = [
    "email" => $user_email,
    "amount" => $user_total * 100,
     "callback_url" =>'http://localhost:4200/studentdash'
];

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer sk_test_b093fd15cf53c1acc9e933d99db17a12db11a515",
        "Content-Type: application/json"
    ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo json_encode( "cURL Error #:" . $err);
} else {
    $rezz= json_decode($response, true);
    echo json_encode($rezz['data']['authorization_url']);
}



}

?>
<?php

$curl = curl_init();

$data = [
    "tx_ref" => "hooli-tx-1920bbtytty",
    "amount" => "100",
    "currency" => "NGN",
    "redirect_url" => "http://google.com",
    "payment_options" => "card",
    "customer" => [
        "email" => "customer@domain.com",
        "phonenumber" => "08012345678",
        "name" => "Yemi Desola"
    ],
    "customizations" => [
        "title" => "Pied Piper Payments",
        "description" => "Middleout isn't free. Pay the price",
        "logo" => "https://assets.piedpiper.com/logo.png"
    ]
];

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.flutterwave.com/v3/payments",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer FLWPUBK_TEST-45d26f9315fd37752c266b29ba8e67fe-X",
        "Content-Type: application/json"
    ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}
?>
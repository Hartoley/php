Paystack payment 


<?php

$curl = curl_init();

$data = [
    "email" => "customer@domain.com",
    "amount" => "10000", // amount in kobo
    "callback_url" => "https://google.com/"
];

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer sk_test_1bc61b4143f3f54c3f52f5c24d92ce168d89bf3c",
        "Content-Type: application/json"
    ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo "Response ". $response;
}
?>
<?php
// Set your credentials and payment settings
$gatewayEndpoint = 'https://api.paymentprovider.com/payments';
$apiKey = 'your-api-key';
$currency = 'USD';

// Process the payment request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $cardNumber = $_POST['cardNumber'];
    $expiryMonth = $_POST['expiryMonth'];
    $expiryYear = $_POST['expiryYear'];
    $cvv = $_POST['cvv'];

    // Prepare the request payload
    $payload = [
        'amount' => $amount,
        'currency' => $currency,
        'cardNumber' => $cardNumber,
        'expiryMonth' => $expiryMonth,
        'expiryYear' => $expiryYear,
        'cvv' => $cvv,
        // Add other required fields based on the payment provider's documentation
    ];

    // Perform the API request
    $ch = curl_init($gatewayEndpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey,
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    $response = curl_exec($ch);
    curl_close($ch);

    // Process the API response
    $responseData = json_decode($response, true);
    if ($responseData['status'] === 'success') {
        // Payment successful, perform necessary actions (e.g., update order status)
        $transactionId = $responseData['transactionId'];
        // ...
        echo 'Payment successful. Transaction ID: ' . $transactionId;
    } else {
        // Payment failed, handle the error (e.g., display an error message)
        $errorMessage = $responseData['message'];
        // ...
        echo 'Payment failed. Error: ' . $errorMessage;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Form</title>
</head>
<body>
    <form method="POST" action="">
        <label for="amount">Amount:</label>
        <input type="text" name="amount" id="amount" required><br>

        <label for="cardNumber">Card Number:</label>
        <input type="text" name="cardNumber" id="cardNumber" required><br>

        <label for="expiryMonth">Expiry Month:</label>
        <input type="text" name="expiryMonth" id="expiryMonth" required><br>

        <label for="expiryYear">Expiry Year:</label>
        <input type="text" name="expiryYear" id="expiryYear" required><br>

        <label for="cvv">CVV:</label>
        <input type="text" name="cvv" id="cvv" required><br>

        <input type="submit" value="Pay">
    </form>
</body>
</html>

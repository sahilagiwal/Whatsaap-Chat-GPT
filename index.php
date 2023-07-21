

<?php
// capture the text from user from POST
$textfromuser = $_POST['Body'];

// include the autoload file from Composer
require_once "vendor/autoload.php";

use Twilio\Rest\Client as TwilioClient;

$url = "https://api.openai.com/v1/chat/completions";
$data = array(
    "model"=>"gpt-3.5-turbo",
    "messages" => array(
        array(
            "role" => "system",
            "content" => "You are a helpful assistant."
        ),
        array(
            "role" => "user",
            "content" => $textfromuser
        )
    )
);
$headers = array(
    'Content-Type: application/json',
    'Authorization: Bearer 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'
);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);

if (!$response) {
    die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
}

$json_response = json_decode($response, true);
$content = $json_response['choices'][0]['message']['content'];
echo $content;

curl_close($ch);



// Your Twilio credentials
$sid = "ACe9a1105c735ddb89ee7e9c3e8c2c0690";
$token = "cd4eef79f158d98a7cfcdb036b47d34a";

// Initialize Twilio client
$twilio = new TwilioClient($sid, $token);

// Send WhatsApp message through Twilio
$message = $twilio->messages
                  ->create("whatsapp:+18145003629", // to
                           [
                               "body" => $generatedText,
                               "from" => "whatsapp:+14155238886"
                           ]
                  );

// Print the message SID
print($message->sid);
?>

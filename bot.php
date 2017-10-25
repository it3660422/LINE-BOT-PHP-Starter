<?php
$access_token = 'qB4SGXnXb+lZ2zf1SUPwBoBwfuuUKD245XJ+M2zJ5ifGkswr1twudJg0kfr1+MVvVljlpArF+CaEJe3oN/TxiaQS+ubBUR/gs26RbJgLjQ1A50ItoZzmtt3oQvnIMWu+HVx5at5Jd5w27iwiN2UuagdB04t89/1O/w1cDnyilFU=';
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
print_r($events);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];
			// Build message to reply back

			if (strtolower($text)==strtolower('BTC')){
				$btcPrice = btcPrice();
			}
			$messages = [
				'type' => 'text',
				'text' => 'Current BTC price is: '.$btcPrice
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);
			echo $result . "\r\n";
		}
	}
}
echo $result;
function btcPrice() {
	$nonce=time();
	$url='https://bittrex.com/api/v1.1/public/getticker?market=USDT-BTC';
	$ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$execResult = curl_exec($ch);
	$obj = json_decode($execResult, true);
	$btcPrice = $obj["result"]["Last"];
	return $btcPrice; 
}
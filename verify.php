<?php
$access_token = 'qB4SGXnXb+lZ2zf1SUPwBoBwfuuUKD245XJ+M2zJ5ifGkswr1twudJg0kfr1+MVvVljlpArF+CaEJe3oN/TxiaQS+ubBUR/gs26RbJgLjQ1A50ItoZzmtt3oQvnIMWu+HVx5at5Jd5w27iwiN2UuagdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;

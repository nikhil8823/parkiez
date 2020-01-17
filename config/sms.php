<?php
return [
  'host_url' => env('SMS_GATEWAY_URL'),
  'username' => env('SMS_GATEWAY_USERNAME'),
  'password' => env('SMS_GATEWAY_PASSWORD'),
  'sender_id' => env('SMS_GATEWAY_SENDER_ID'),
  'is_enable' => env('SMS_GATEWAY_IS_ENABLE')
];

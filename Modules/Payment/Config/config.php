<?php

return [
    'name' => 'Payment',
    'PAYMOB_API_KEY' => env('PAYMOB_API_KEY', 'your_api_key_here'),
    'integrations_ids' => env('PAYMOB_2_INTEGRATION_ID', 'your_second_integration_id_here'),
    'base_url' => env('PAYMOB_BASE_URL', 'https://accept.paymob.com/api/'),
    'username' => env('PAYMOB_USERNAME', 'your_username_here'),
    'password' => env('PAYMOB_PASSWORD', 'your_password_here'),
    'app_url' => env('APP_URL', 'https://yourapp.com/'),
    'frontend_url' => env('FRONTEND_URL', 'https://yourfrontend.com/'),
];

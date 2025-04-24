<?php

return [
    'facebook' => [
        'access_token' => env('FACEBOOK_TOKEN', ''),
        'page_id' => env('FACEBOOK_PAGE_ID', ''),
    ],
    'instagram' => [
        'access_token' => env('INSTAGRAM_TOKEN', ''),
        'ig_user_id' => env('INSTAGRAM_USER_ID', ''),
    ],
    'twitter' => [
        'consumer_key' => env('TWITTER_API_KEY', ''),
        'consumer_secret' => env('TWITTER_API_SECRET', ''),
        'access_token' => env('TWITTER_ACCESS_TOKEN', ''),
        'access_token_secret' => env('TWITTER_ACCESS_SECRET', ''),
    ]
];
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
        'access_token' => env('TWITTER_TOKEN', ''),
    ]
];
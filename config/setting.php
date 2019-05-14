<?php

return [
    'user' => [
        'gender' => [
            'man' => 1,
            'woman' => 2,
            'other' => 3,
        ],
        'role' => [
            'admin' => 1,
            'artist' => 2,
            'member' => 3,
        ],
        'status' => [
            'active' => 1,
            'block' => 2
        ]
    ],

    'media' => [
        'type' => [
            'music' => 1,
            'video' => 2,
        ]
    ],

    'album' => [
        'media_type' => 3,
        'type' => [
            'single' => 1,
            'normal' => 2,
        ]
    ],

    'media_filter_size' => [
        'album' => 5,
        'video' => 6,
        'music' => 7,
    ],

    'category_type' => [
        'selective' => 0,
        'region' => 1,
        'kind' => 2,
    ],

    'images' => [
        'track' => '/frontend/images/track.png',
        'music_playing' => '/frontend/images/music-playing.gif',
        'user_avatar_default' => '/frontend/images/user_avatar_default.png'
    ]
];

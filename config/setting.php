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
    ]
];

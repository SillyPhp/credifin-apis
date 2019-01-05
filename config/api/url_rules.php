<?php

return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => [
            'account',
            'user',
            'states',
            'cities',
            'quiz',
            'quiz-counter',
            'quiz-tracker',
            'feedback',
            'skills',
            'jobs'
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => [
            'applications'
        ]
    ],
];

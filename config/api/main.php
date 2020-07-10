<?php

$params = array_merge(
        require __DIR__ . '/../../common/config/params.php', require __DIR__ . '/../../common/config/params-local.php', require __DIR__ . '/params.php', require __DIR__ . '/params-local.php'
);

$url_rules = require(__DIR__ . '/url_rules.php');

return [
    'id' => 'app-api',
    'basePath' => '@api',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'homeUrl' => '/api',
    'params' => json_decode(json_encode($params)),
    'modules' => [
        'v1' => [
            'basePath' => '@api/modules/v1',
            'class' => 'api\modules\v1\Module'
        ]
    ],
    'components' => [
        'request' => [
//            'csrfParam' => '_csrf-api',
            'baseUrl' => '/api',
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'api\modules\v1\models\Candidates',
            'enableAutoLogin' => false,
            'enableSession' => false
//            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
        'response' => [
          'format' => \yii\web\Response::FORMAT_JSON
        ],
//        'session' => [
//            // this is the name of the session cookie used for login on the api
//            'name' => 'advanced-api',
//        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'baseUrl' => '/api',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules' => $url_rules,
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                ],
                'api' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                ],
            ],
        ],
    ],
];

<?php
$params = array_merge(
    require __DIR__ . '/params.php'
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'params' => json_decode(json_encode($params)),
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
          ],
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
//            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => $params['smtp_settings']['hostname'],
                'username' => $params['smtp_settings']['username'],
                'password' => $params['smtp_settings']['password'],
                'port' => $params['smtp_settings']['port'],
                'encryption' => $params['smtp_settings']['encryption'],
            ],
        ],
    ],
];

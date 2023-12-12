<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$params += require __DIR__ . '/secret.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '958VtXzOCAzXN2taUn25MarsJLVxfuHn',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
            'linkAssets' => true,
            'appendTimestamp' => true
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'aoe2de' => 'site/aoe2de',
                'warcraft3' => 'site/warcraft3',
                'my-maps' => 'site/my-maps',
                'map/<id:\d+>' => 'site/map',
                'site/map/<id:\d+>' => 'site/map',
                'map-edit/<id:\d+>' => 'site/map-edit',

                // Раздел пользователей
                'login' => 'user/login',
                'logout' => 'user/logout',
                'sing-up' => 'user/sing-up',
                'site/sing-up' => 'user/sing-up',
                'user-profile' => 'user/user-profile',
                'map-creators' => 'user/map-creators',
                'user/<id:\d+>' => 'user/user',
                'site/user/<id:\d+>' => 'user/user',
                'site/users' => 'user/map-creators',

                // Раздел с полезной информацией для картоделов
                'useful' => 'useful/index',
                'useful/aoe' => 'useful/aoe',
                'useful/warcraft3' => 'useful/warcraft3',

                '/' => 'site/index',
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;

<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'admin',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:\w+>s' => '<controller>/index',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
            ],
        ],
        'imageresize' => [
            'class' => 'app\components\Imageresize',
        ],
        'customs3' => [
            'class' => 'app\components\Customs3',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'aswdsdcwsdwa',
        ],

        'cache' => [
            'class' => 'yii\caching\MemCache',
            'servers' => [
                [
                    'host' => 'localhost',
                    'port' => 11211,
                    'weight' => 100,
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'app\models\Useradmin',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
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
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=main.cdb3bm2h7j5j.us-east-1.rds.amazonaws.com;port=3306;dbname=hangshare',
            'username' => 'hangshare',
            'password' => 'Khaled!23',
            'charset' => 'utf8',
        ],
    ],
    'params' => $params,
];


// configuration adjustments for 'dev' environment
$config['bootstrap'][] = 'debug';
$config['modules']['debug'] = [
    'class' => 'yii\debug\Module',
];

$config['bootstrap'][] = 'gii';
$config['modules']['gii'] = [
    'class' => 'yii\gii\Module',
    'allowedIPs' => ['127.0.0.1', $_SERVER['REMOTE_ADDR']]
];


return $config;

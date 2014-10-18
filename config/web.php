<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'OO0OEjRX3PJP44-OvNGf6eDl0VKJmFsV',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\db\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => "@runtime/logs/info.log",
                    'levels' => ['info'],
                    'logVars' => [], //NO GET, NO POST, NO PUT, NO PATCH, NO COOKIES etc.

                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
        ],
        'user' => [
            'identityClass' => 'app\models\db\User',
            'enableAutoLogin' => true,
        ],
    ],
    'modules' => [
        'adminradio' => [
            'class' => 'app\modules\adminradio\AdminRadioModule',
        ],
        'direktur' => [
            'class' => 'app\modules\direktur\DirekturModule',
        ],
        'manajerkeuangan' => [
            'class' => 'app\modules\manajerkeuangan\ManajerKeuanganModule',
        ],
        'petugas' => [
            'class' => 'app\modules\petugas\PetugasModule',
        ],
        'admin' => [
            'class' => 'app\modules\admin\AdminModule',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;

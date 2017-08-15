<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
	'id' => 'basic',
	'basePath' => dirname(__DIR__),
    'language' => 'ru-RU',
    'bootstrap' => ['log'],
	'modules' => [
		'users' => [
			'class' => 'app\modules\users\Module',
		],
        'projects' => [
            'class' => 'app\modules\projects\Module',
        ],
        'treemanager' =>  [
            'class' => '\kartik\tree\Module',
            // other module settings, refer detailed documentation
        ]
	],
	
	'components' => [

        'i18n' => [
            'translations' => [
                'projects'=>[
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                ],
                'links'=>[
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                ],
                'papp*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                ],
            ],
        ],

        'ym' => [
            'class' => 'grigorieff\ym\YMComponent',
            'client_id' => '8E5A1A14FA88A30DD2A219F32301D9C6787C4385A7721849CE6C0B8F072CCC99',
            'code' => '',
            'redirect_uri' => 'http://crowdl.tk/users/balance/redirect',
            'client_secret' => '35474EBE1E2C2FF7538041B63005065CD2E9324CDB3BB658CF2A9B3EBF44DDC412FE72204394FDDC26C3EC98505C4B655FFBD59207F936B905094713BE17F3B8'
        ],

    
		'request' => [
			// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
			'cookieValidationKey' => 'jQBCJlH_6TyBmU_YA92tzh0hKlWm3691',
			'baseUrl' => '',
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
			'class' => 'yii\swiftmailer\Mailer',
			// send all mails to a file by default. You have to set
			// 'useFileTransport' to false and configure a transport
			// for the mailer to send real emails.
			'useFileTransport' => true,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'ssl://smtp.yandex.com', //вставляем имя или адрес почтового сервера
                'username' => 'serial-i@ya.ru',
                'password' => '7dec19977',
                'port' => '587',
                'encryption' => '',
            ],

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
		'db' => $db,

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],



		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => [
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
		'allowedIPs' => ['127.0.0.1', '::1'],
	];
}

return $config;
